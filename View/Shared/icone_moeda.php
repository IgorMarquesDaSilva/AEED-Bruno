<?php
// Ícone de moeda usado ao lado de qualquer valor ou menção de moedas (decorativo: o texto "moedas" continua na tela).
if (!function_exists('iconeMoeda')) {
    function iconeMoeda()
    {
        return '<svg class="icone-moeda" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="10.5" fill="#f6c445" stroke="#b7791f" stroke-width="1.5"/><circle cx="12" cy="12" r="7.6" fill="none" stroke="#d99a1b" stroke-width="1.4"/><polygon points="12.00,7.40 13.12,10.46 16.37,10.58 13.81,12.59 14.70,15.72 12.00,13.90 9.30,15.72 10.19,12.59 7.63,10.58 10.88,10.46" fill="#b7791f"/></svg>';
    }
}