<?php
require_once __DIR__ . '/Perguntas.php';
require_once __DIR__ . '/../Avatar/CatalogoAvatar.php';

class Quiz
{
    public const QUESTOES_POR_MATERIA = 6;
    public const QUESTOES_GERAL = 12;
    private $perguntas;

    public function __construct()
    {
        $this->perguntas = Perguntas::listar();
    }

    public function listarTemas()
    {
        return [
            'todos' => 'Todas as matérias',
            'tad' => 'TAD',
            'lisimples' => 'Lista Simples',
            'lisdupla' => 'Lista Dupla',
            'fila' => 'Fila Encadeada FIFO',
            'filaprioridade' => 'Fila de Prioridades',
            'pilha' => 'Pilha Encadeada LIFO'
        ];
    }

    public function podeSortearPerguntas($tema, $excluidas = [])
    {
        if (!is_string($tema) || !isset($this->listarTemas()[$tema]) || !is_array($excluidas)) return false;
        foreach ($this->grupos($tema) as [$materia, $tipo, $quantidade]) {
            $disponiveis = array_filter($this->perguntas, function ($pergunta, $id) use ($materia, $tipo, $excluidas) {
                return $pergunta['tema'] === $materia && $pergunta['tipo'] === $tipo && !in_array($id, $excluidas, true);
            }, ARRAY_FILTER_USE_BOTH);
            if (count($disponiveis) < $quantidade) return false;
        }
        return true;
    }

    public function sortearPerguntas($tema, $excluidas = [])
    {
        if (!is_string($tema) || !isset($this->listarTemas()[$tema])) {
            throw new DomainException('Selecione uma matéria válida.');
        }
        if (!$this->podeSortearPerguntas($tema, $excluidas)) {
            throw new DomainException('Todas as perguntas disponíveis para este lote já foram usadas. Volte amanhã.');
        }
        $ids = [];
        foreach ($this->grupos($tema) as [$materia, $tipo, $quantidade]) {
            $grupo = array_keys(array_filter($this->perguntas, function ($pergunta, $id) use ($materia, $tipo, $excluidas) {
                return $pergunta['tema'] === $materia && $pergunta['tipo'] === $tipo && !in_array($id, $excluidas, true);
            }, ARRAY_FILTER_USE_BOTH));
            shuffle($grupo);
            array_push($ids, ...array_slice($grupo, 0, $quantidade));
        }
        shuffle($ids);
        return $ids;
    }

    private function grupos($tema)
    {
        $materias = $tema === 'todos' ? array_keys(array_diff_key($this->listarTemas(), ['todos' => true])) : [$tema];
        $quantidade = $tema === 'todos' ? 1 : 3;
        $grupos = [];
        foreach ($materias as $materia) {
            foreach (['Teoria', 'Código'] as $tipo) $grupos[] = [$materia, $tipo, $quantidade];
        }
        return $grupos;
    }

    public function criarTentativa($tema, $usuarioId, $ids = null, $itensHabilidade = [])
    {
        if (!is_string($tema) || !isset($this->listarTemas()[$tema])) {
            throw new DomainException('Selecione uma matéria válida.');
        }
        if ($ids === null) $ids = $this->sortearPerguntas($tema);
        $total = $tema === 'todos' ? self::QUESTOES_GERAL : self::QUESTOES_POR_MATERIA;
        if (!is_array($ids) || count($ids) !== $total) {
            throw new DomainException('Lote de perguntas inválido.');
        }
        foreach ($ids as $id) {
            if (!is_string($id) || !isset($this->perguntas[$id])) throw new DomainException('Lote de perguntas inválido.');
        }
        if (count(array_unique($ids)) !== $total) throw new DomainException('Lote de perguntas inválido.');
        foreach ($this->grupos($tema) as [$materia, $tipo, $quantidade]) {
            $encontradas = 0;
            foreach ($ids as $id) {
                if ($this->perguntas[$id]['tema'] === $materia && $this->perguntas[$id]['tipo'] === $tipo) $encontradas++;
            }
            if ($encontradas !== $quantidade) throw new DomainException('Lote de perguntas inválido.');
        }
        if (!is_array($itensHabilidade) || array_diff($itensHabilidade, array_keys(CatalogoAvatar::habilidades()))) {
            throw new DomainException('Habilidades da rodada inválidas.');
        }

        return [
            'id' => bin2hex(random_bytes(16)),
            'usuario_id' => $usuarioId,
            'tema' => $tema,
            'perguntas' => $ids,
            'respostas' => [],
            'habilidades' => array_fill_keys($itensHabilidade, false),
            'ajudas' => [],
            'indice' => 0,
            'concluida' => false
        ];
    }

    public function obterPergunta($id)
    {
        if (!isset($this->perguntas[$id])) {
            throw new DomainException('Questão não encontrada.');
        }
        return $this->perguntas[$id];
    }

    public function usarHabilidade(&$tentativa, $tentativaId, $perguntaId, $itemId)
    {
        $this->validarQuestaoPendente($tentativa, $tentativaId, $perguntaId);
        if (isset($tentativa['ajudas'][$perguntaId])) {
            throw new DomainException('Esta questão já recebeu uma ajuda ou uma resposta.');
        }
        $habilidade = is_string($itemId) ? (CatalogoAvatar::habilidades()[$itemId] ?? null) : null;
        if (!$habilidade || !array_key_exists($itemId, $tentativa['habilidades'] ?? []) || $tentativa['habilidades'][$itemId]) {
            throw new DomainException('Esta habilidade não está disponível nesta rodada.');
        }
        $ajuda = ['item' => $itemId];
        if ($habilidade['tipo'] === 'eliminar') {
            $correta = $this->obterPergunta($perguntaId)['correta'];
            $erradas = array_values(array_diff([0, 1, 2, 3], [$correta]));
            shuffle($erradas);
            $ajuda['ocultas'] = array_slice($erradas, 0, $habilidade['quantidade']);
        } else {
            $ajuda['escudo'] = true;
        }
        $tentativa['ajudas'][$perguntaId] = $ajuda;
        $tentativa['habilidades'][$itemId] = true;
    }

    public function validarQuestaoPendente($tentativa, $tentativaId, $perguntaId)
    {
        $this->validarEtapa($tentativa, $tentativaId, $perguntaId);
        if (array_key_exists($perguntaId, $tentativa['respostas'])) {
            throw new DomainException('Esta questão já foi respondida.');
        }
    }

    public function responder(&$tentativa, $tentativaId, $perguntaId, $alternativa)
    {
        $this->validarEtapa($tentativa, $tentativaId, $perguntaId);
        if (array_key_exists($perguntaId, $tentativa['respostas'])) {
            throw new DomainException('Essa questão já foi respondida. Continue para a próxima etapa.');
        }
        if (!is_string($alternativa) || !in_array($alternativa, ['0', '1', '2', '3'], true)) {
            throw new DomainException('Selecione uma alternativa antes de confirmar.');
        }
        $ajuda = $tentativa['ajudas'][$perguntaId] ?? [];
        $ocultas = $ajuda['ocultas'] ?? [];
        if (isset($ajuda['erro'])) $ocultas[] = $ajuda['erro'];
        if (in_array((int) $alternativa, $ocultas, true)) {
            throw new DomainException('Essa alternativa foi eliminada. Escolha outra.');
        }
        if (($ajuda['escudo'] ?? false) && !isset($ajuda['erro']) && (int) $alternativa !== $this->obterPergunta($perguntaId)['correta']) {
            $tentativa['ajudas'][$perguntaId]['erro'] = (int) $alternativa;
            return;
        }
        $tentativa['respostas'][$perguntaId] = (int) $alternativa;
    }

    public function avancar(&$tentativa, $tentativaId, $perguntaId)
    {
        $this->validarEtapa($tentativa, $tentativaId, $perguntaId);
        if (!array_key_exists($perguntaId, $tentativa['respostas'])) {
            throw new DomainException('Responda à questão antes de continuar.');
        }
        if ($tentativa['indice'] === count($tentativa['perguntas']) - 1) {
            $tentativa['concluida'] = true;
        } else {
            $tentativa['indice']++;
        }
    }

    private function validarEtapa($tentativa, $tentativaId, $perguntaId)
    {
        if ($tentativa['concluida'] || $tentativaId !== $tentativa['id'] ||
            $perguntaId !== $tentativa['perguntas'][$tentativa['indice']]) {
            throw new DomainException('Esta etapa já mudou. Continue pela questão exibida agora.');
        }
    }

    public function obterResultado($tentativa)
    {
        $acertos = 0;
        $revisao = [];
        foreach ($tentativa['perguntas'] as $id) {
            if (!array_key_exists($id, $tentativa['respostas'])) continue;
            $pergunta = $this->obterPergunta($id);
            $resposta = $tentativa['respostas'][$id];
            $acertou = $resposta === $pergunta['correta'];
            if ($acertou) $acertos++;
            $revisao[] = ['id' => $id, 'pergunta' => $pergunta, 'resposta' => $resposta, 'acertou' => $acertou];
        }
        $total = count($tentativa['perguntas']);
        return [
            'acertos' => $acertos,
            'total' => $total,
            'respondidas' => count($revisao),
            'percentual' => (int) round($acertos * 100 / $total),
            'revisao' => $revisao
        ];
    }
}
