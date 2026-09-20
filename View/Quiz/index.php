<?php require_once __DIR__ . '/../Shared/header.php'; ?>

<section class="quiz-cabecalho" aria-labelledby="quiz-titulo">
    <span class="quiz-rotulo">Pratique seus conhecimentos</span>
    <h1 id="quiz-titulo">Quiz de Estruturas de Dados</h1>
    <a class="quiz-link" href="index.php#conteudos">Voltar às matérias</a>
</section>

<?php if ($erro !== '') { ?>
    <div class="quiz-aviso quiz-aviso-erro" role="alert"><?php echo htmlspecialchars($erro); ?></div>
<?php } ?>

<?php if ($indisponivel) { ?>
    <a class="quiz-link" href="index.php?pagina=quiz">Tentar novamente</a>
<?php } elseif (!$tentativa) { ?>
    <section class="quiz-inicio" aria-labelledby="quiz-nova-rodada">
        <div>
            <h2 id="quiz-nova-rodada">Nova rodada</h2>
            <dl class="quiz-dados">
                <div><dt>Rodada geral</dt><dd>12 questões</dd></div>
                <div><dt>Por matéria</dt><dd>6 questões</dd></div>
                <div><dt>Tempo</dt><dd>Sem limite</dd></div>
            </dl>
            <p class="quiz-nota">Perguntas novas a cada dia. Repetir gratuitamente no mesmo dia mantém o lote atual.</p>
            <form class="quiz-configuracao" method="post" action="index.php?pagina=quiz">
                <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">
                <input type="hidden" name="acao" value="iniciar">
                <label for="quiz-tema">Matéria</label>
                <select id="quiz-tema" name="tema">
                    <?php foreach ($temas as $chave => $nome) { ?>
                        <option value="<?php echo htmlspecialchars($chave); ?>"><?php echo htmlspecialchars($nome); ?></option>
                    <?php } ?>
                </select>
                <button class="quiz-botao" type="submit">Começar quiz</button>
            </form>
        </div>
        <aside class="quiz-materias" aria-labelledby="quiz-revisar">
            <h2 id="quiz-revisar">Revisar as aulas</h2>
            <ul>
                <?php foreach ($temas as $chave => $nome) { if ($chave === 'todos') continue; ?>
                    <li><a href="index.php?pagina=<?php echo htmlspecialchars($chave); ?>"><?php echo htmlspecialchars($nome); ?></a></li>
                <?php } ?>
            </ul>
        </aside>
    </section>
<?php } elseif (!$tentativa['concluida']) { ?>
    <section class="quiz-rodada" aria-labelledby="quiz-questao">
        <div class="quiz-andamento">
            <div><strong>Questão <?php echo $tentativa['indice'] + 1; ?> de <?php echo $resultado['total']; ?></strong><span><?php echo htmlspecialchars($temas[$tentativa['tema']]); ?></span></div>
            <label for="quiz-progresso"><?php echo $resultado['respondidas']; ?> de <?php echo $resultado['total']; ?> respondidas</label>
        </div>
        <progress id="quiz-progresso" max="<?php echo $resultado['total']; ?>" value="<?php echo $resultado['respondidas']; ?>"><?php echo $resultado['respondidas']; ?> / <?php echo $resultado['total']; ?></progress>

        <div class="quiz-questao-meta">
            <span><?php echo htmlspecialchars($temas[$pergunta['tema']]); ?></span>
            <span><?php echo htmlspecialchars($pergunta['tipo']); ?></span>
        </div>
        <h2 id="quiz-questao"><?php echo htmlspecialchars($pergunta['enunciado']); ?></h2>
        <?php if (isset($pergunta['codigo'])) { ?>
            <pre class="quiz-codigo" tabindex="0" aria-label="Código C# da questão"><code><?php echo htmlspecialchars($pergunta['codigo']); ?></code></pre>
        <?php } ?>

        <?php if ($dicaComprada || !$respondida) { ?>
        <div class="quiz-dica" aria-label="Dica da questão">
            <?php if ($dicaComprada) { ?>
                <strong>Dica desbloqueada</strong>
                <p><?php echo htmlspecialchars($dicaTexto); ?></p>
            <?php } elseif (!$respondida) { ?>
                <strong>Dica da questão</strong>
                <form method="post" action="index.php?pagina=quiz">
                    <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">
                    <input type="hidden" name="tentativa" value="<?php echo htmlspecialchars($tentativa['id']); ?>">
                    <input type="hidden" name="pergunta" value="<?php echo htmlspecialchars($perguntaId); ?>">
                    <input type="hidden" name="acao" value="comprar_dica">
                    <button class="quiz-botao quiz-botao-secundario" type="submit"<?php if ($saldoMoedas < RodadaQuiz::PRECO_DICA) echo ' disabled'; ?>>Comprar dica · <?php echo RodadaQuiz::PRECO_DICA; ?> moedas</button>
                </form>
            <?php } ?>
        </div>
        <?php } ?>

        <?php if (!empty($tentativa['habilidades'])) { ?>
            <div class="quiz-habilidades" aria-label="Habilidades dos itens equipados">
                <strong>Habilidades</strong>
                <div class="quiz-habilidades-lista">
                    <?php foreach ($tentativa['habilidades'] as $itemId => $usada) { ?>
                        <?php if ($usada || $respondida || $ajudaAtual) { ?>
                            <span class="quiz-habilidade-inativa"><?php echo htmlspecialchars($itensCatalogo[$itemId]['nome']); ?>: <?php echo $usada ? 'usada' : 'disponível na próxima questão'; ?></span>
                        <?php } else { ?>
                            <form method="post" action="index.php?pagina=quiz">
                                <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">
                                <input type="hidden" name="tentativa" value="<?php echo htmlspecialchars($tentativa['id']); ?>">
                                <input type="hidden" name="pergunta" value="<?php echo htmlspecialchars($perguntaId); ?>">
                                <input type="hidden" name="acao" value="habilidade">
                                <input type="hidden" name="item" value="<?php echo htmlspecialchars($itemId); ?>">
                                <button class="quiz-botao quiz-botao-secundario" type="submit"><?php echo htmlspecialchars($itensCatalogo[$itemId]['nome'] . ': ' . $habilidadesCatalogo[$itemId]['descricao']); ?></button>
                            </form>
                        <?php } ?>
                    <?php } ?>
                </div>
                <?php if ($ajudaAtual && !$respondida) { ?>
                    <p class="quiz-habilidade-ativa"><?php echo !empty($ajudaAtual['escudo']) ? 'Segunda chance ativa nesta questão.' : 'Alternativas erradas removidas nesta questão.'; ?></p>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if (isset($ajudaAtual['erro']) && !$respondida) { ?>
            <div class="quiz-aviso quiz-aviso-sucesso" role="status"><strong>Segunda chance!</strong><p>A alternativa anterior foi eliminada. Escolha outra resposta.</p></div>
        <?php } ?>

        <form method="post" action="index.php?pagina=quiz">
            <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">
            <input type="hidden" name="tentativa" value="<?php echo htmlspecialchars($tentativa['id']); ?>">
            <input type="hidden" name="pergunta" value="<?php echo htmlspecialchars($perguntaId); ?>">
            <input type="hidden" name="acao" value="<?php echo $respondida ? 'avancar' : 'responder'; ?>">
            <fieldset class="quiz-alternativas"<?php if ($respondida) echo ' disabled'; ?>>
                <legend>Alternativas</legend>
                <?php foreach ($pergunta['alternativas'] as $indice => $alternativa) {
                    $ocultas = $ajudaAtual['ocultas'] ?? [];
                    if (isset($ajudaAtual['erro'])) $ocultas[] = $ajudaAtual['erro'];
                    if (in_array($indice, $ocultas, true)) continue;
                    $selecionada = $respondida && $tentativa['respostas'][$perguntaId] === $indice;
                    $classe = '';
                    if ($respondida && $indice === $pergunta['correta']) $classe = ' quiz-alternativa-correta';
                    elseif ($selecionada) $classe = ' quiz-alternativa-errada';
                ?>
                    <label class="quiz-alternativa<?php echo $classe; ?>">
                        <input type="radio" name="alternativa" value="<?php echo $indice; ?>" required<?php if ($selecionada) echo ' checked'; ?>>
                        <span class="quiz-alternativa-texto"><strong><?php echo chr(65 + $indice); ?>.</strong> <?php echo htmlspecialchars($alternativa); ?></span>
                        <?php if ($respondida && $indice === $pergunta['correta']) { ?>
                            <span class="quiz-alternativa-status"><?php echo $selecionada ? 'Sua resposta · Correta' : 'Resposta correta'; ?></span>
                        <?php } elseif ($selecionada) { ?>
                            <span class="quiz-alternativa-status">Sua resposta · Incorreta</span>
                        <?php } ?>
                    </label>
                <?php } ?>
            </fieldset>

            <?php if ($respondida) {
                $acertou = $tentativa['respostas'][$perguntaId] === $pergunta['correta'];
            ?>
                <div class="quiz-aviso <?php echo $acertou ? 'quiz-aviso-sucesso' : 'quiz-aviso-erro'; ?>" role="status">
                    <strong><?php echo $acertou ? 'Resposta correta!' : 'Não foi desta vez.'; ?></strong>
                    <p><?php echo htmlspecialchars($pergunta['explicacao']); ?></p>
                </div>
            <?php } ?>

            <div class="quiz-acoes">
                <button class="quiz-botao" type="submit"><?php echo !$respondida ? 'Confirmar resposta' : ($tentativa['indice'] + 1 === $resultado['total'] ? 'Ver resultado' : 'Próxima questão'); ?></button>
                <?php if ($respondida) { ?>
                    <a class="quiz-link" href="index.php?pagina=<?php echo htmlspecialchars($pergunta['tema']); ?>">Revisar esta matéria</a>
                <?php } ?>
            </div>
        </form>
    </section>
    <details class="quiz-encerrar">
        <summary>Encerrar rodada</summary>
        <p>Esta rodada será encerrada sem moedas. Os erros já registrados continuam valendo para hoje.</p>
        <form method="post" action="index.php?pagina=quiz">
            <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">
            <input type="hidden" name="tentativa" value="<?php echo htmlspecialchars($tentativa['id']); ?>">
            <input type="hidden" name="acao" value="abandonar">
            <button class="quiz-botao quiz-botao-secundario" type="submit">Confirmar encerramento</button>
        </form>
    </details>
<?php } else { ?>
    <section class="quiz-resultado" aria-labelledby="quiz-resultado-titulo">
        <span class="quiz-rotulo">Rodada concluída</span>
        <h2 id="quiz-resultado-titulo">Seu resultado</h2>
        <p><?php echo htmlspecialchars($temas[$tentativa['tema']]); ?></p>
        <dl class="quiz-dados quiz-placar">
            <div><dt>Acertos</dt><dd><?php echo $resultado['acertos']; ?> <span>/ <?php echo $resultado['total']; ?></span></dd></div>
            <div><dt>Erros</dt><dd><?php echo $resultado['total'] - $resultado['acertos']; ?></dd></div>
            <div><dt>Aproveitamento</dt><dd><?php echo $resultado['percentual']; ?>%</dd></div>
        </dl>
        <div class="quiz-recompensa" role="status">
            <div><span>Moedas nesta rodada</span><strong>+<?php echo $recompensas['ganhas']; ?></strong></div>
            <a class="quiz-link" href="index.php?pagina=perfil#moedas">Saldo atual: <?php echo number_format($saldoMoedas, 0, ',', '.'); ?> moedas</a>
        </div>
        <div class="quiz-acoes">
            <form method="post" action="index.php?pagina=quiz">
                <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">
                <input type="hidden" name="tentativa" value="<?php echo htmlspecialchars($tentativa['id']); ?>">
                <input type="hidden" name="acao" value="novo">
                <button class="quiz-botao" type="submit">Novo quiz</button>
            </form>
            <?php if ($podeRenovar) { ?>
                <form method="post" action="index.php?pagina=quiz">
                    <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($csrf); ?>">
                    <input type="hidden" name="tentativa" value="<?php echo htmlspecialchars($tentativa['id']); ?>">
                    <input type="hidden" name="acao" value="renovar">
                    <button class="quiz-botao quiz-botao-secundario" type="submit"<?php if ($saldoMoedas < RodadaQuiz::PRECO_RENOVACAO) echo ' disabled'; ?>>Trocar perguntas · <?php echo RodadaQuiz::PRECO_RENOVACAO; ?> moedas</button>
                </form>
            <?php } ?>
            <a class="quiz-link" href="index.php#conteudos">Voltar às matérias</a>
        </div>
    </section>
    <section class="quiz-revisao" aria-labelledby="quiz-revisao-titulo">
        <h2 id="quiz-revisao-titulo">Revisão das respostas</h2>
        <?php foreach ($resultado['revisao'] as $numero => $item) {
            $questao = $item['pergunta'];
        ?>
            <details class="quiz-revisao-item">
                <summary>
                    <span><strong><?php echo $numero + 1; ?>.</strong> <?php echo htmlspecialchars($questao['enunciado']); ?></span>
                    <span class="quiz-revisao-status <?php echo $item['acertou'] ? 'quiz-certo' : 'quiz-errado'; ?>"><?php echo $item['acertou'] ? 'Acertou' : 'Errou'; ?></span>
                </summary>
                <div class="quiz-revisao-conteudo">
                    <span class="quiz-rotulo"><?php echo htmlspecialchars($temas[$questao['tema']] . ' · ' . $questao['tipo']); ?></span>
                    <?php $premio = $recompensas['por_questao'][$item['id']]; ?>
                    <p class="quiz-premio-questao"><strong>+<?php echo $premio['moedas']; ?> moedas</strong>
                        <?php if ($premio['dia'] === null) { ?>
                            · Resposta anterior ao sistema de moedas
                        <?php } elseif (!$item['acertou']) { ?>
                            · Resposta incorreta
                        <?php } elseif ($premio['moedas'] === 0) { ?>
                            · Questão já recompensada no dia da resposta
                        <?php } elseif ($premio['moedas'] === 5) { ?>
                            · Acerto após 1 erro no dia
                        <?php } elseif ($premio['moedas'] === 2) { ?>
                            · Acerto após 2 ou mais erros no dia
                        <?php } else { ?>
                            · Acerto sem erros anteriores no dia
                        <?php } ?>
                    </p>
                    <?php if (isset($questao['codigo'])) { ?>
                        <pre class="quiz-codigo" tabindex="0" aria-label="Código C# da questão"><code><?php echo htmlspecialchars($questao['codigo']); ?></code></pre>
                    <?php } ?>
                    <p><strong>Sua resposta:</strong> <?php echo htmlspecialchars($questao['alternativas'][$item['resposta']]); ?></p>
                    <?php if (!$item['acertou']) { ?>
                        <p><strong>Resposta correta:</strong> <?php echo htmlspecialchars($questao['alternativas'][$questao['correta']]); ?></p>
                    <?php } ?>
                    <p><?php echo htmlspecialchars($questao['explicacao']); ?></p>
                    <a class="quiz-link" href="index.php?pagina=<?php echo htmlspecialchars($questao['tema']); ?>">Revisar esta matéria</a>
                </div>
            </details>
        <?php } ?>
    </section>
<?php } ?>

<?php require_once __DIR__ . '/../Shared/footer.php'; ?>
