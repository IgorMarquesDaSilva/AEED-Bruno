<?php
class CatalogoAvatar
{
    public static function categorias()
    {
        return [
            'cabelo' => 'Cabelo e chapéus',
            'rosto' => 'Rosto',
            'roupa' => 'Roupas',
            'acessorio' => 'Acessórios'
        ];
    }

    public static function itens()
    {
        return [
            'cabelo_curto' => ['nome' => 'Cabelo curto', 'categoria' => 'cabelo', 'preco' => 0, 'descricao' => 'Visual inicial.'],
            'cabelo_cacheado' => ['nome' => 'Cachos', 'categoria' => 'cabelo', 'preco' => 30, 'descricao' => 'Cachos com volume.'],
            'cabelo_longo' => ['nome' => 'Cabelo longo', 'categoria' => 'cabelo', 'preco' => 35, 'descricao' => 'Fios longos e soltos.'],
            'bone' => ['nome' => 'Boné', 'categoria' => 'cabelo', 'preco' => 25, 'descricao' => 'Boné verde.'],
            'chapeu' => ['nome' => 'Chapéu', 'categoria' => 'cabelo', 'preco' => 45, 'descricao' => 'Chapéu de explorador.'],
            'rosto_sorriso' => ['nome' => 'Sorriso', 'categoria' => 'rosto', 'preco' => 0, 'descricao' => 'Expressão inicial.'],
            'rosto_serio' => ['nome' => 'Concentrado', 'categoria' => 'rosto', 'preco' => 20, 'descricao' => 'Olhar atento.'],
            'rosto_piscada' => ['nome' => 'Piscadela', 'categoria' => 'rosto', 'preco' => 25, 'descricao' => 'Um toque de humor.'],
            'roupa_basica' => ['nome' => 'Camiseta verde', 'categoria' => 'roupa', 'preco' => 0, 'descricao' => 'Roupa inicial.'],
            'roupa_azul' => ['nome' => 'Moletom azul', 'categoria' => 'roupa', 'preco' => 40, 'descricao' => 'Moletom com capuz.'],
            'roupa_vermelha' => ['nome' => 'Jaqueta vermelha', 'categoria' => 'roupa', 'preco' => 50, 'descricao' => 'Jaqueta com detalhes claros.'],
            'oculos' => ['nome' => 'Óculos', 'categoria' => 'acessorio', 'preco' => 30, 'descricao' => 'Armação redonda.'],
            'fone' => ['nome' => 'Fones', 'categoria' => 'acessorio', 'preco' => 35, 'descricao' => 'Fones para estudar.']
        ];
    }

    public static function iniciais()
    {
        return ['cabelo' => 'cabelo_curto', 'rosto' => 'rosto_sorriso', 'roupa' => 'roupa_basica'];
    }
}
