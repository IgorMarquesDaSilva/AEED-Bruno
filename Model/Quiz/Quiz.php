<?php
require_once __DIR__ . '/Perguntas.php';

class Quiz
{
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
            'filaprioridade' => 'Fila de Prioridades'
        ];
    }

    public function criarTentativa($tema, $usuarioId)
    {
        if (!is_string($tema) || !array_key_exists($tema, $this->listarTemas())) {
            throw new DomainException('Selecione uma matéria válida.');
        }

        $ids = [];
        if ($tema === 'todos') {
            // Uma questão teórica e uma de código por matéria na rodada geral.
            foreach (array_keys($this->listarTemas()) as $materia) {
                if ($materia === 'todos') continue;
                foreach (['Teoria', 'Código'] as $tipo) {
                    $grupo = array_keys(array_filter($this->perguntas, function ($pergunta) use ($materia, $tipo) {
                        return $pergunta['tema'] === $materia && $pergunta['tipo'] === $tipo;
                    }));
                    $ids[] = $grupo[random_int(0, count($grupo) - 1)];
                }
            }
        } else {
            $ids = array_keys(array_filter($this->perguntas, function ($pergunta) use ($tema) {
                return $pergunta['tema'] === $tema;
            }));
        }
        shuffle($ids);

        return [
            'id' => bin2hex(random_bytes(16)),
            'usuario_id' => $usuarioId,
            'tema' => $tema,
            'perguntas' => $ids,
            'respostas' => [],
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

    public function responder(&$tentativa, $tentativaId, $perguntaId, $alternativa)
    {
        $this->validarEtapa($tentativa, $tentativaId, $perguntaId);
        if (array_key_exists($perguntaId, $tentativa['respostas'])) {
            throw new DomainException('Essa questão já foi respondida. Continue para a próxima etapa.');
        }
        if (!is_string($alternativa) || !in_array($alternativa, ['0', '1', '2', '3'], true)) {
            throw new DomainException('Selecione uma alternativa antes de confirmar.');
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
