<?php
require_once __DIR__ . '/Quiz.php';
require_once __DIR__ . '/../Moedas/Carteira.php';
require_once __DIR__ . '/../Avatar/AvatarLoja.php';
require_once __DIR__ . '/DicasQuiz.php';

class RodadaQuiz
{
    public const PRECO_RENOVACAO = 5;
    public const PRECO_DICA = 3;
    private $pdo;
    private $quiz;
    private $carteira;
    private $agora;

    public function __construct($pdo = null, $agora = null)
    {
        $this->pdo = $pdo ?? Conexao::conectar();
        $this->quiz = new Quiz();
        $this->carteira = new Carteira($this->pdo);
        $this->agora = ($agora ?? new DateTimeImmutable())->setTimezone(new DateTimeZone('America/Sao_Paulo'));
    }

    private function transacao($usuarioId, $operacao)
    {
        $this->pdo->beginTransaction();
        try {
            // Um bloqueio por conta serializa respostas e pagamentos de abas/dispositivos diferentes.
            $this->carteira->bloquear($usuarioId);
            $resultado = $operacao();
            $this->pdo->commit();
            return $resultado;
        } catch (Throwable $exception) {
            if ($this->pdo->inTransaction()) $this->pdo->rollBack();
            throw $exception;
        }
    }

    private function instanteUtc()
    {
        return $this->agora->setTimezone(new DateTimeZone('UTC'))->format('Y-m-d H:i:s');
    }

    public function buscarAtual($usuarioId, $preferida = null)
    {
        $stmt = $this->pdo->prepare("SELECT dados FROM quiz_rodadas WHERE usuario_id = ? AND estado = 'andamento' LIMIT 1");
        $stmt->execute([$usuarioId]);
        $dados = $stmt->fetchColumn();
        if ($dados === false && is_string($preferida)) {
            $stmt = $this->pdo->prepare("SELECT dados FROM quiz_rodadas WHERE usuario_id = ? AND id = ? AND estado = 'concluida'");
            $stmt->execute([$usuarioId, $preferida]);
            $dados = $stmt->fetchColumn();
        }
        return $dados === false ? null : json_decode($dados, true, 512, JSON_THROW_ON_ERROR);
    }

    public function iniciar($usuarioId, $tema)
    {
        return $this->transacao($usuarioId, function () use ($usuarioId, $tema) {
            if ($this->buscarAtual($usuarioId)) {
                throw new DomainException('Já existe uma rodada em andamento. Continue ou encerre essa rodada.');
            }
            $lote = $this->buscarLote($usuarioId, $tema);
            if ($lote === null) {
                $anterior = $this->pdo->prepare('SELECT perguntas FROM quiz_lotes_dia WHERE usuario_id = ? AND tema = ? AND dia < ? ORDER BY dia DESC LIMIT 1');
                $anterior->execute([$usuarioId, $tema, $this->agora->format('Y-m-d')]);
                $idsAnteriores = $anterior->fetchColumn();
                $excluidas = $idsAnteriores === false ? [] : json_decode($idsAnteriores, true, 512, JSON_THROW_ON_ERROR);
                if (!$this->quiz->podeSortearPerguntas($tema, $excluidas)) $excluidas = [];
                $perguntas = $this->quiz->sortearPerguntas($tema, $excluidas);
                $stmt = $this->pdo->prepare('INSERT INTO quiz_lotes_dia (usuario_id, tema, dia, perguntas, usadas) VALUES (?, ?, ?, ?, ?)');
                $json = json_encode($perguntas, JSON_THROW_ON_ERROR);
                $stmt->execute([$usuarioId, $tema, $this->agora->format('Y-m-d'), $json, $json]);
            } else {
                $perguntas = $lote['perguntas'];
            }
            $habilidades = (new AvatarLoja($this->pdo))->habilidadesEquipadas($usuarioId);
            $tentativa = $this->quiz->criarTentativa($tema, $usuarioId, $perguntas, $habilidades);
            $this->inserir($tentativa);
            return $tentativa;
        });
    }

    private function buscarLote($usuarioId, $tema)
    {
        if (!is_string($tema) || !isset($this->quiz->listarTemas()[$tema])) {
            throw new DomainException('Selecione uma matéria válida.');
        }
        $stmt = $this->pdo->prepare('SELECT perguntas, usadas FROM quiz_lotes_dia WHERE usuario_id = ? AND tema = ? AND dia = ?');
        $stmt->execute([$usuarioId, $tema, $this->agora->format('Y-m-d')]);
        $registro = $stmt->fetch();
        if (!$registro) return null;
        return [
            'perguntas' => json_decode($registro['perguntas'], true, 512, JSON_THROW_ON_ERROR),
            'usadas' => json_decode($registro['usadas'], true, 512, JSON_THROW_ON_ERROR)
        ];
    }

    public function podeRenovar($usuarioId, $tema)
    {
        $lote = $this->buscarLote($usuarioId, $tema);
        return $lote !== null && $this->quiz->podeSortearPerguntas($tema, $lote['usadas']);
    }

    public function renovarEIniciar($usuarioId, $tema)
    {
        return $this->transacao($usuarioId, function () use ($usuarioId, $tema) {
            if ($this->buscarAtual($usuarioId)) {
                throw new DomainException('Finalize ou encerre a rodada atual antes de trocar as perguntas.');
            }
            $lote = $this->buscarLote($usuarioId, $tema);
            if ($lote === null) throw new DomainException('Comece pelo lote gratuito de hoje.');
            $perguntas = $this->quiz->sortearPerguntas($tema, $lote['usadas']);
            if ($this->carteira->saldo($usuarioId) < self::PRECO_RENOVACAO) {
                throw new DomainException('Moedas insuficientes para trocar as perguntas.');
            }
            $stmt = $this->pdo->prepare('UPDATE moedas_carteiras SET saldo = saldo - ? WHERE usuario_id = ? AND saldo >= ?');
            $stmt->execute([self::PRECO_RENOVACAO, $usuarioId, self::PRECO_RENOVACAO]);
            if ($stmt->rowCount() !== 1) throw new RuntimeException('Não foi possível atualizar o saldo.');
            $stmt = $this->pdo->prepare('UPDATE quiz_lotes_dia SET perguntas = ?, usadas = ?, renovacoes = renovacoes + 1, moedas_gastas = moedas_gastas + ?
                WHERE usuario_id = ? AND tema = ? AND dia = ?');
            $stmt->execute([
                json_encode($perguntas, JSON_THROW_ON_ERROR),
                json_encode(array_merge($lote['usadas'], $perguntas), JSON_THROW_ON_ERROR),
                self::PRECO_RENOVACAO, $usuarioId, $tema, $this->agora->format('Y-m-d')
            ]);
            $habilidades = (new AvatarLoja($this->pdo))->habilidadesEquipadas($usuarioId);
            $tentativa = $this->quiz->criarTentativa($tema, $usuarioId, $perguntas, $habilidades);
            $this->inserir($tentativa);
            return $tentativa;
        });
    }

    private function inserir($tentativa)
    {
        $stmt = $this->pdo->prepare('INSERT INTO quiz_rodadas (id, usuario_id, tema, estado, dados, criado_em, concluido_em, saldo_apos)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $tentativa['id'], $tentativa['usuario_id'], $tentativa['tema'], $tentativa['concluida'] ? 'concluida' : 'andamento',
            json_encode($tentativa, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE), $this->instanteUtc(),
            $tentativa['concluida'] ? $this->instanteUtc() : null,
            $tentativa['concluida'] ? $this->carteira->saldo($tentativa['usuario_id']) : null
        ]);
    }

    public function importarLegada($usuarioId, $tentativa)
    {
        if ((int) ($tentativa['usuario_id'] ?? 0) !== (int) $usuarioId) return;
        $this->transacao($usuarioId, function () use ($usuarioId, $tentativa) {
            $stmt = $this->pdo->prepare('SELECT id FROM quiz_rodadas WHERE id = ?');
            $stmt->execute([$tentativa['id']]);
            if ($stmt->fetchColumn() !== false || $this->buscarAtual($usuarioId)) return;
            $this->inserir($tentativa);
            // Respostas anteriores a esta atualizacao sao preservadas, sem moedas retroativas.
            $stmt = $this->pdo->prepare('INSERT INTO quiz_respostas (rodada_id, pergunta_id, alternativa, correta) VALUES (?, ?, ?, ?)');
            foreach ($tentativa['respostas'] as $id => $alternativa) {
                $correta = $this->quiz->obterPergunta($id)['correta'] === $alternativa;
                $stmt->execute([$tentativa['id'], $id, $alternativa, (int) $correta]);
            }
        });
    }

    private function carregar($usuarioId, $rodadaId)
    {
        if (!is_string($rodadaId)) throw new DomainException('Rodada inválida.');
        $stmt = $this->pdo->prepare('SELECT dados, estado FROM quiz_rodadas WHERE usuario_id = ? AND id = ? FOR UPDATE');
        $stmt->execute([$usuarioId, $rodadaId]);
        $registro = $stmt->fetch();
        if (!$registro || $registro['estado'] === 'abandonada') {
            throw new DomainException('Esta rodada não está mais ativa. Confira o quiz atual.');
        }
        return json_decode($registro['dados'], true, 512, JSON_THROW_ON_ERROR);
    }

    private function salvar($tentativa)
    {
        $stmt = $this->pdo->prepare('UPDATE quiz_rodadas SET dados = ? WHERE id = ? AND usuario_id = ?');
        $stmt->execute([json_encode($tentativa, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE), $tentativa['id'], $tentativa['usuario_id']]);
    }

    public function usarHabilidade($usuarioId, $rodadaId, $perguntaId, $itemId)
    {
        return $this->transacao($usuarioId, function () use ($usuarioId, $rodadaId, $perguntaId, $itemId) {
            $tentativa = $this->carregar($usuarioId, $rodadaId);
            $this->quiz->usarHabilidade($tentativa, $rodadaId, $perguntaId, $itemId);
            $this->salvar($tentativa);
            return $tentativa;
        });
    }

    public function dicaComprada($usuarioId, $perguntaId)
    {
        $stmt = $this->pdo->prepare('SELECT 1 FROM quiz_dicas WHERE usuario_id = ? AND pergunta_id = ?');
        $stmt->execute([$usuarioId, $perguntaId]);
        return $stmt->fetchColumn() !== false;
    }

    public function comprarDica($usuarioId, $rodadaId, $perguntaId)
    {
        return $this->transacao($usuarioId, function () use ($usuarioId, $rodadaId, $perguntaId) {
            $tentativa = $this->carregar($usuarioId, $rodadaId);
            $this->quiz->validarQuestaoPendente($tentativa, $rodadaId, $perguntaId);
            DicasQuiz::obter($perguntaId);
            if ($this->dicaComprada($usuarioId, $perguntaId)) return $this->carteira->saldo($usuarioId);
            if ($this->carteira->saldo($usuarioId) < self::PRECO_DICA) {
                throw new DomainException('Moedas insuficientes para comprar a dica.');
            }
            $stmt = $this->pdo->prepare('UPDATE moedas_carteiras SET saldo = saldo - ? WHERE usuario_id = ? AND saldo >= ?');
            $stmt->execute([self::PRECO_DICA, $usuarioId, self::PRECO_DICA]);
            if ($stmt->rowCount() !== 1) throw new RuntimeException('Não foi possível atualizar o saldo.');
            $stmt = $this->pdo->prepare('INSERT INTO quiz_dicas (usuario_id, pergunta_id, custo_moedas, comprado_em) VALUES (?, ?, ?, ?)');
            $stmt->execute([$usuarioId, $perguntaId, self::PRECO_DICA, $this->instanteUtc()]);
            return $this->carteira->saldo($usuarioId);
        });
    }

    public function responder($usuarioId, $rodadaId, $perguntaId, $alternativa)
    {
        return $this->transacao($usuarioId, function () use ($usuarioId, $rodadaId, $perguntaId, $alternativa) {
            $tentativa = $this->carregar($usuarioId, $rodadaId);
            $this->quiz->responder($tentativa, $rodadaId, $perguntaId, $alternativa);
            if (!array_key_exists($perguntaId, $tentativa['respostas'])) {
                $this->salvar($tentativa);
                return $tentativa;
            }
            $correta = $this->quiz->obterPergunta($perguntaId)['correta'] === (int) $alternativa;
            $dia = $this->agora->format('Y-m-d');
            $stmt = $this->pdo->prepare('INSERT INTO moedas_questoes_dia (usuario_id, pergunta_id, dia) VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE usuario_id = VALUES(usuario_id)');
            $stmt->execute([$usuarioId, $perguntaId, $dia]);
            $stmt = $this->pdo->prepare('SELECT erros, moedas_creditadas FROM moedas_questoes_dia WHERE usuario_id = ? AND pergunta_id = ? AND dia = ? FOR UPDATE');
            $stmt->execute([$usuarioId, $perguntaId, $dia]);
            $diario = $stmt->fetch();
            $previstas = $correta && (int) $diario['moedas_creditadas'] === 0 ? Carteira::recompensaPorErros((int) $diario['erros']) : 0;
            if (!$correta) {
                $stmt = $this->pdo->prepare('UPDATE moedas_questoes_dia SET erros = erros + 1 WHERE usuario_id = ? AND pergunta_id = ? AND dia = ?');
                $stmt->execute([$usuarioId, $perguntaId, $dia]);
            }
            $stmt = $this->pdo->prepare('INSERT INTO quiz_respostas (rodada_id, pergunta_id, dia, alternativa, correta, moedas_previstas) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([$rodadaId, $perguntaId, $dia, (int) $alternativa, (int) $correta, $previstas]);
            $this->salvar($tentativa);
            return $tentativa;
        });
    }

    public function avancar($usuarioId, $rodadaId, $perguntaId)
    {
        return $this->transacao($usuarioId, function () use ($usuarioId, $rodadaId, $perguntaId) {
            $tentativa = $this->carregar($usuarioId, $rodadaId);
            $this->quiz->avancar($tentativa, $rodadaId, $perguntaId);
            if ($tentativa['concluida']) $this->creditar($tentativa);
            $this->salvar($tentativa);
            return $tentativa;
        });
    }

    private function creditar($tentativa)
    {
        $stmt = $this->pdo->prepare('SELECT pergunta_id, dia, correta, moedas_previstas FROM quiz_respostas WHERE rodada_id = ? ORDER BY pergunta_id');
        $stmt->execute([$tentativa['id']]);
        $respostas = $stmt->fetchAll();
        if (count($respostas) !== count($tentativa['perguntas'])) {
            throw new RuntimeException('Rodada com respostas incompletas.');
        }
        $ganhas = 0;
        foreach ($respostas as $resposta) {
            $valor = (int) $resposta['moedas_previstas'];
            if (!$resposta['correta'] || $valor === 0 || $resposta['dia'] === null) continue;
            $stmt = $this->pdo->prepare('UPDATE moedas_questoes_dia SET moedas_creditadas = ?
                WHERE usuario_id = ? AND pergunta_id = ? AND dia = ? AND moedas_creditadas = 0');
            $stmt->execute([$valor, $tentativa['usuario_id'], $resposta['pergunta_id'], $resposta['dia']]);
            if ($stmt->rowCount() !== 1) continue;
            $stmt = $this->pdo->prepare('UPDATE quiz_respostas SET moedas_recebidas = ? WHERE rodada_id = ? AND pergunta_id = ?');
            $stmt->execute([$valor, $tentativa['id'], $resposta['pergunta_id']]);
            $ganhas += $valor;
        }
        $stmt = $this->pdo->prepare('UPDATE moedas_carteiras SET saldo = saldo + ? WHERE usuario_id = ?');
        $stmt->execute([$ganhas, $tentativa['usuario_id']]);
        $stmt = $this->pdo->prepare("UPDATE quiz_rodadas SET estado = 'concluida', moedas_ganhas = ?, saldo_apos = ?, concluido_em = ? WHERE id = ? AND usuario_id = ?");
        $stmt->execute([$ganhas, $this->carteira->saldo($tentativa['usuario_id']), $this->instanteUtc(), $tentativa['id'], $tentativa['usuario_id']]);
    }

    public function abandonar($usuarioId, $rodadaId)
    {
        $this->transacao($usuarioId, function () use ($usuarioId, $rodadaId) {
            $tentativa = $this->carregar($usuarioId, $rodadaId);
            if ($tentativa['concluida']) throw new DomainException('Esta rodada já foi concluída.');
            $stmt = $this->pdo->prepare("UPDATE quiz_rodadas SET estado = 'abandonada' WHERE id = ? AND usuario_id = ?");
            $stmt->execute([$rodadaId, $usuarioId]);
        });
    }

    public function recompensas($usuarioId, $rodadaId)
    {
        $stmt = $this->pdo->prepare('SELECT r.moedas_ganhas, r.saldo_apos, p.pergunta_id, p.dia, p.moedas_recebidas
            FROM quiz_rodadas r LEFT JOIN quiz_respostas p ON p.rodada_id = r.id WHERE r.id = ? AND r.usuario_id = ?');
        $stmt->execute([$rodadaId, $usuarioId]);
        $resultado = ['ganhas' => 0, 'por_questao' => []];
        foreach ($stmt->fetchAll() as $registro) {
            $resultado['ganhas'] = (int) $registro['moedas_ganhas'];
            if ($registro['pergunta_id'] !== null) {
                $resultado['por_questao'][$registro['pergunta_id']] = [
                    'moedas' => (int) $registro['moedas_recebidas'], 'dia' => $registro['dia']
                ];
            }
        }
        return $resultado;
    }
}
