# AEED-Bruno

Sistema web em PHP para ensino de Estruturas de Dados.

## Banco de dados

1. Abra o phpMyAdmin no XAMPP.
2. Importe o arquivo `database/aeed_bruno.sql`.
3. Confira se o banco `aeed_bruno` foi criado.

Usuario inicial para teste:

- E-mail: `admin@aeed.com`
- Senha: `123456`

Se o MySQL local usar outro usuario ou senha, altere os dados em
`Model/Database/Conexao.php`.

## Quiz

Depois de entrar na conta, acesse **Quiz** no menu ou
`index.php?pagina=quiz`. O banco de 25 perguntas fica em
`Model/Quiz/Perguntas.php`, com teoria e exemplos em C# das cinco materias.
A rodada geral sorteia 10 perguntas; por materia, sao 5.

O progresso e o resultado da rodada ficam na sessao do usuario e sobrevivem
ao F5, mas nao constituem um historico permanente no MySQL. Esta etapa nao
inclui moedas, loja ou avatar e nao exige alteracoes no banco de dados.

Para executar os testes da logica do quiz na pasta do projeto:

```sh
php tests/QuizTest.php
```
