# AEED-Bruno

Sistema web em PHP para ensino de Estruturas de Dados.

## Banco de dados

1. Inicie Apache e MySQL no XAMPP e abra o phpMyAdmin.
2. Em uma instalacao nova, crie o banco `aeed_bruno` com collation `utf8mb4_unicode_ci`.
3. Selecione esse banco e importe `database/aeed_bruno.sql`.

Se o banco ja existe, **nao reimporte o dump** para atualizar a recuperacao de
senha. Execute na pasta do projeto (o comando pode ser repetido):

```sh
php database/migrar_recuperacao.php
```

A migracao acrescenta os campos e a tabela de limites sem apagar usuarios.

Para habilitar o quiz com moedas, tanto em uma instalacao nova quanto em um
banco existente, execute depois da importacao/migracao acima:

```sh
php database/migrar_moedas.php
```

Esse comando cria as quatro tabelas de carteira, rodadas, respostas e controle
diario. Pode ser repetido sem apagar usuarios, saldos ou historico. Como
alternativa, importe `database/moedas.sql` no banco `aeed_bruno` pelo phpMyAdmin.
No Windows, se PHP nao estiver no PATH, use `C:\xampp\php\php.exe` no lugar de `php`.

Depois, habilite o avatar e a loja:

```sh
php database/migrar_avatar_loja.php
```

A migracao cria as tabelas de inventario e equipamento sem alterar usuarios,
moedas ou rodadas existentes. Pode ser repetida. Tambem e possivel importar
`database/avatar_loja.sql` pelo phpMyAdmin no banco `aeed_bruno`.

Para os lotes diarios de perguntas, execute tambem:

```sh
php database/migrar_lotes_quiz.php
```

Essa migracao e repetivel e preserva rodadas, moedas e compras anteriores.

Para liberar a compra de dicas do quiz, execute:

```sh
php database/migrar_dicas_quiz.php
```

A migracao das dicas pode ser repetida e nao apaga saldo nem rodadas. Todos
esses arquivos de migracao estao no repositorio para uso pelos demais membros
da equipe.

Usuario inicial para teste:

- E-mail: `admin@aeed.com`
- Senha: `123456`

Se o MySQL local usar outro usuario ou senha, altere os dados em
`Model/Database/Conexao.php`.

## Recuperacao de senha

Requer PHP 8.2+, PDO MySQL, OpenSSL e Composer. Na pasta do projeto, instale
as dependencias com `composer install`. A versao do PHPMailer fica fixada
no `composer.lock`; cada integrante deve executar esse comando ao baixar o projeto.

Configure `config/email.local.php` com os campos de `config/email.example.php`.
O arquivo local e ignorado pelo Git e protegido contra acesso HTTP no Apache.
Nunca coloque a senha SMTP no arquivo de exemplo, em prints, no chat ou no GitHub.

- `app_url`: URL onde o site sera acessado, sem barra final. Exemplo local:
  `http://localhost/AEED-Bruno`. Em hospedagem, use a URL HTTPS publica.
- `host` e `port`: servidor e porta informados pelo provedor SMTP.
- `encryption`: `tls` para STARTTLS ou `ssl` para TLS implicito.
- `username` e `password`: credenciais SMTP. Nao use a senha de login deste site.
- `from_email` e `from_name`: remetente autorizado pelo provedor e nome exibido.

Tambem sao aceitas variaveis de ambiente `AEED_APP_URL` e
`AEED_SMTP_HOST`, `AEED_SMTP_PORT`, `AEED_SMTP_ENCRYPTION`,
`AEED_SMTP_USERNAME`, `AEED_SMTP_PASSWORD`, `AEED_SMTP_FROM_EMAIL` e
`AEED_SMTP_FROM_NAME`. Elas tem prioridade sobre o arquivo local.

Para Gmail, quando a conta permitir, utilize uma senha de app com a verificacao
em duas etapas ativada, nao a senha normal da conta. Consulte a
[orientacao oficial do Google](https://support.google.com/accounts/answer/185833?hl=pt-BR).

Para testes sem entrega real, pode-se configurar um capturador SMTP local:
host `127.0.0.1`, porta do capturador, `encryption`, `username` e `password`
vazios e um remetente de teste valido. O capturador deve estar em execucao e
acessivel somente na maquina local. Sem criptografia so e permitido SMTP em
loopback; **nunca desative a verificacao de certificados para um provedor real**.

Sem SMTP configurado, o site informa indisponibilidade; nao exibe links de
recuperacao nem escreve mensagens contendo tokens em arquivos publicos.
Um link que usa `localhost` so funciona no computador que hospeda o projeto.

### Fluxo e testes

Em `index.php?pagina=esqueciSenha`, informe o email de uma conta cadastrada.
O link chega somente por email, expira em 30 minutos e e de uso unico. Um novo
pedido substitui o link anterior. A nova senha deve ser confirmada e respeitar
o limite do hash bcrypt (6 a 72 bytes neste projeto).

A resposta do formulario e igual para contas existentes e inexistentes. Ha
limites persistentes de 3 pedidos por email por hora e 10 por IP a cada 15 minutos.
As paginas usam CSRF, POST/Redirect/GET e `Referrer-Policy: no-referrer`. O token
e retirado da URL antes da exibicao do formulario; apenas seu hash fica no banco.
A troca de senha invalida cookies de permanencia e sessoes anteriores da conta,
sem desconectar outros usuarios. Um email separado notifica a alteracao.

Erros de envio geram mensagens genericas no log do PHP/Apache, sem senha,
destinatario ou token. Configuracao validada nao garante entrega: problemas de
SMTP ou filtros de spam devem ser verificados no provedor.

```sh
php tests/RecuperacaoSenhaTest.php
php tests/QuizTest.php
```

O teste de recuperacao usa uma conta temporaria dentro de transacao e um
transporte de email simulado, sem enviar emails reais ou alterar contas existentes.
Os registros temporarios de limite sao removidos ao final. As orientacoes de
seguranca seguem a [referencia OWASP sobre recuperacao de senha](https://cheatsheetseries.owasp.org/cheatsheets/Forgot_Password_Cheat_Sheet.html).

## Quiz

Depois de entrar na conta, acesse **Quiz** no menu ou
`index.php?pagina=quiz`. O banco de 72 perguntas fica em
`Model/Quiz/Perguntas.php` e `Model/Quiz/PerguntasAdicionais.php`, com teoria
e exemplos em C# das seis materias, incluindo Pilha Encadeada. A rodada
geral tem 12 perguntas (uma teorica e uma de codigo por materia); por
materia, sao 6 (tres teoricas e tres de codigo).

O primeiro lote de cada materia ou do quiz geral e gratuito em cada dia, no
horario de Brasilia. Repetir o quiz no mesmo dia usa as mesmas perguntas sem
custo. A primeira rodada do dia evita o ultimo lote do dia anterior quando ha
perguntas suficientes. Depois de concluir uma rodada, e possivel gastar
**5 moedas** para iniciar outra com perguntas ainda nao usadas naquele modo
naquele dia. Quando nao restam perguntas suficientes para um lote completo,
a troca deixa de aparecer ate o dia seguinte. O quiz geral e cada materia
possuem lotes proprios; a recompensa por acerto continua limitada a uma vez
por questao e por dia, mesmo se a questao aparecer em modos diferentes.

O progresso, as respostas e o resultado ficam no MySQL, vinculados a conta.
Uma rodada em andamento pode ser retomada depois de F5, logout ou acesso em
outro navegador. Cada conta tem no maximo uma rodada em andamento.

## Moedas do quiz

As recompensas sao controladas por usuario, questao e dia, independentemente
de a questao aparecer no quiz geral ou no quiz de uma materia:

| Situacao ao acertar a questao | Moedas |
| --- | --- |
| Nenhum erro anterior nessa questao no dia | 10 |
| Um erro anterior nessa questao no dia | 5 |
| Dois ou mais erros anteriores nessa questao no dia | 2 |
| Questao ja premiada para essa conta nesse dia | 0 |
| Resposta incorreta | 0 |

- Errar nao desconta moedas do saldo. Cada erro e registrado imediatamente,
  mesmo que a pessoa abandone a rodada ou saia da conta.
- As moedas dos acertos so entram no saldo ao concluir a rodada em **Ver resultado**.
  Uma rodada abandonada nao paga recompensas.
- No dia seguinte, as questoes podem render moedas novamente; o saldo acumulado
  permanece. O dia de cada resposta e definido pelo horario de Brasilia
  (`America/Sao_Paulo`), usando o relogio do servidor.
- Se a rodada atravessar a meia-noite, cada resposta continua vinculada ao dia
  em que foi enviada, mesmo que a conclusao aconteca depois.
- Valores e acertos sao calculados no servidor. Transacoes e bloqueio da carteira
  impedem pagamento duplicado por F5 ou requisicoes simultaneas.
- O cabecalho mostra o saldo; o resultado detalha a recompensa por questao;
  o perfil mostra o saldo e as dez ultimas rodadas concluidas.
- Rodadas que ja estavam na sessao antes desta atualizacao sao preservadas,
  mas respostas anteriores nao geram moedas nem penalidades retroativas.

As moedas tambem podem ser usadas na loja do avatar. Todos os itens pagos tem
uma habilidade descrita na propria loja: eliminar uma ou duas alternativas
erradas ou ganhar uma segunda tentativa depois de um erro. Somente itens
comprados e equipados entram na rodada; os itens iniciais sao esteticos.
Cada item pode ser ativado uma vez por rodada, em apenas uma questao. A
segunda chance elimina a primeira resposta errada sem registrar erro nem
reduzir a recompensa; uma nova resposta errada segue as regras normais.
Trocar o equipamento durante uma rodada nao altera as habilidades dela;
a proxima rodada usa o equipamento atualizado. O uso fica salvo com a rodada
no MySQL, inclusive ao atualizar a pagina ou trocar de dispositivo.

Cada uma das 72 questoes tambem possui uma dica conceitual. Ela custa
**3 moedas** e pode ser comprada antes de responder. O desbloqueio e permanente
para aquela conta e questao: se a pergunta reaparecer em outra rodada ou
materia, a dica ja estara disponivel sem nova cobranca. Compras duplicadas,
inclusive de abas diferentes, sao cobradas uma unica vez.

Para executar os testes na pasta do projeto, com o MySQL e as migracoes prontos:

```sh
php tests/QuizTest.php
php tests/MoedasTest.php
php tests/LotesQuizTest.php
php tests/HabilidadesQuizTest.php
php tests/DicasQuizTest.php
```

O teste de moedas usa contas temporarias e remove seus registros ao terminar.
Verifica as recompensas, abandono, mudanca do dia, migracao de rodadas antigas,
isolamento de contas, falha com rollback e conclusoes simultaneas. Nao altera
contas existentes.

## Avatar e loja

Depois de entrar, acesse **Loja** no menu ou `index.php?pagina=loja`.
O perfil mostra o avatar e o link para **Meu armario**. O avatar inicial possui
cabelo curto, sorriso e camiseta verde. O catalogo inclui cabelo ou chapeu,
rosto, roupas e acessorios. O catalogo e seus precos ficam em
`Model/Avatar/CatalogoAvatar.php`.

Uma compra desconta as moedas e adiciona o item ao armario na mesma transacao.
O item comprado e equipado imediatamente. No armario, e possivel equipar
novamente qualquer item comprado ou inicial e retirar o acessorio. Pecas,
compras e equipamento continuam na conta apos F5, logout ou troca de navegador.
O servidor confere propriedade e saldo; uma compra duplicada nao debita de novo.

```sh
php tests/AvatarLojaTest.php
```

O teste usa contas temporarias, verifica compras, saldo, equipamento, isolamento
entre contas e duas compras simultaneas. Remove os registros criados ao terminar.
