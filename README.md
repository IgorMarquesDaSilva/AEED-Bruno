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
`index.php?pagina=quiz`. O banco de 25 perguntas fica em
`Model/Quiz/Perguntas.php`, com teoria e exemplos em C# das cinco materias.
A rodada geral sorteia 10 perguntas; por materia, sao 5.

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

Esta etapa inclui ganhar, guardar e consultar moedas. Loja, compras, avatar e
habilidades dos itens ainda nao fazem parte dela.

Para executar os testes na pasta do projeto, com o MySQL e as migracoes prontos:

```sh
php tests/QuizTest.php
php tests/MoedasTest.php
```

O teste de moedas usa contas temporarias e remove seus registros ao terminar.
Verifica as recompensas, abandono, mudanca do dia, migracao de rodadas antigas,
isolamento de contas, falha com rollback e conclusoes simultaneas. Nao altera
contas existentes.
