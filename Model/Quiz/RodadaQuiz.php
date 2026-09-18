<?php
require_once __DIR__ . '/Quiz.php';
require_once __DIR__ . '/../Moedas/Carteira.php';

class RodadaQuiz
{
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
            $tentativa = $this->quiz->criarTentativa($tema, $usuarioId);
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

    public function responder($usuarioId, $rodadaId, $perguntaId, $alternativa)
    {
        return $this->transacao($usuarioId, function () use ($usuarioId, $rodadaId, $perguntaId, $alternativa) {
            $tentativa = $this->carregar($usuarioId, $rodadaId);
            $this->quiz->responder($tentativa, $rodadaId, $perguntaId, $alternativa);
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
