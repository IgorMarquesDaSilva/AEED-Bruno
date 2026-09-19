<?php
function desenharAvatar($equipado, $rotulo = 'Seu avatar')
{
    $cabelo = $equipado['cabelo'] ?? 'cabelo_curto';
    $rosto = $equipado['rosto'] ?? 'rosto_sorriso';
    $roupa = $equipado['roupa'] ?? 'roupa_basica';
    $acessorio = $equipado['acessorio'] ?? '';
    ob_start();
    ?>
    <svg class="avatar-desenho" viewBox="0 0 240 280" role="img" aria-label="<?php echo htmlspecialchars($rotulo, ENT_QUOTES, 'UTF-8'); ?>" xmlns="http://www.w3.org/2000/svg">
        <g stroke-linecap="round" stroke-linejoin="round">
            <?php if ($cabelo === 'cabelo_longo') { ?>
                <path d="M72 105c-2-49 15-75 48-75s50 26 48 75l7 89c-14 13-29 18-44 17l-8-35h-6l-8 35c-16 1-31-4-44-17z" fill="#4a3431"/>
                <path d="M75 135c-2 26-4 42-9 58 11 8 20 11 29 12" fill="none" stroke="#705049" stroke-width="4"/>
            <?php } ?>

            <?php if ($roupa === 'roupa_azul') { ?>
                <path d="M91 181c7-11 18-16 29-16s22 5 29 16l-9 39h-40z" fill="#274e69"/>
                <path d="M47 280v-48c0-31 19-50 54-54l19 13 19-13c35 4 54 23 54 54v48z" fill="#3b7398" stroke="#285577" stroke-width="2"/>
                <path d="M100 178c-12 6-16 15-17 28l19 17 18-32zm40 0c12 6 16 15 17 28l-19 17-18-32z" fill="#315f80"/>
                <path d="M120 193v87" stroke="#265473" stroke-width="3"/>
                <path d="M106 207v23m28-23v23" stroke="#d3dce2" stroke-width="3"/>
                <path d="M105 230h3m25 0h3" stroke="#d3dce2" stroke-width="4"/>
                <path d="M58 252h35m54 0h35" stroke="#79a4ba" stroke-width="2"/>
            <?php } elseif ($roupa === 'roupa_vermelha') { ?>
                <path d="M54 280v-48c0-32 20-51 54-54h24c34 3 54 22 54 54v48z" fill="#a7504d" stroke="#8d403d" stroke-width="2"/>
                <path d="M104 179h32l15 101H89z" fill="#263c4b"/>
                <path d="M101 177l19 18-18 22-16-31zm38 0-19 18 18 22 16-31z" fill="#c46b62"/>
                <path d="M94 184l26 29 26-29" fill="none" stroke="#e3b0a1" stroke-width="2"/>
                <path d="M120 212v68" stroke="#efcfb7" stroke-width="3"/>
                <path d="M59 246h34m54 0h34" stroke="#d78b79" stroke-width="2"/>
                <path d="M69 251v16h23v-16m56 0v16h23v-16" fill="none" stroke="#e2a49a" stroke-width="2"/>
                <circle cx="126" cy="229" r="2" fill="#f5d5ba"/>
            <?php } else { ?>
                <path d="M48 280v-48c0-32 21-51 57-54h30c36 3 57 22 57 54v48z" fill="#176e69" stroke="#105b57" stroke-width="2"/>
                <path d="M104 178c4 12 27 16 32 0" fill="none" stroke="#d6eee9" stroke-width="4"/>
                <path d="M58 232c9 2 15 8 19 18m105-18c-9 2-15 8-19 18" fill="none" stroke="#378780" stroke-width="3"/>
                <path d="M72 266h96" stroke="#55a49b" stroke-width="2"/>
                <path d="M135 227h23v17h-23z" fill="#0f5c58"/>
                <text x="139" y="239" fill="#d8f0eb" font-family="Arial, sans-serif" font-size="9" font-weight="700">ED</text>
            <?php } ?>

            <path d="M105 150v32c3 7 10 12 15 12s12-5 15-12v-32z" fill="#d89b78"/>
            <path d="M105 165c6 8 23 9 30 1v11c-8 10-22 11-30 0z" fill="#c88869"/>
            <path d="M77 104c-10-3-15 3-14 13 1 9 7 15 16 14m84-27c10-3 15 3 14 13-1 9-7 15-16 14" fill="#dda47f" stroke="#c98b6d" stroke-width="2"/>
            <path d="M78 86c0-36 17-53 42-53s42 17 42 53v39c0 33-18 57-42 57s-42-24-42-57z" fill="#e7ad87" stroke="#c98b6d" stroke-width="2"/>
            <path d="M153 95c2 40-4 63-22 79 20-5 31-24 31-49V91z" fill="#d99d79" opacity=".55"/>
            <path d="M90 134c4 3 9 3 13 0m34 0c4 3 9 3 13 0" fill="none" stroke="#db9a79" stroke-width="2" opacity=".6"/>

            <?php if ($cabelo === 'cabelo_cacheado') { ?>
                <path d="M76 102c-8-7-7-18-2-25-5-9-1-19 8-23 1-11 10-18 20-17 7-9 18-11 27-6 10-4 20 2 23 10 11 0 18 8 18 18 8 6 9 16 4 24 2 8-2 16-10 20l-4-19c-8-2-13-8-16-13-13 8-32 11-48 5-5 9-12 17-20 26z" fill="#403331"/>
                <path d="M82 67c1-8 8-10 14-8m13-18c4-6 13-6 18-2m28 25c5 3 8 9 6 15" fill="none" stroke="#68504a" stroke-width="3"/>
            <?php } elseif ($cabelo === 'cabelo_longo') { ?>
                <path d="M76 104V82c0-33 18-53 44-53s44 20 44 53v21c-12-7-20-20-23-33-11 13-29 18-51 17-2 8-7 14-14 17z" fill="#4a3431"/>
                <path d="M93 49c11-12 33-14 45-6m7 13c3 9 9 16 16 20" fill="none" stroke="#705049" stroke-width="3"/>
                <path d="M75 103c-1 28-2 58-9 89m99-89c1 28 2 58 9 89" fill="none" stroke="#4a3431" stroke-width="10"/>
            <?php } else { ?>
                <path d="M77 102c-5-42 12-67 43-67s48 25 43 67c-8-7-14-20-17-32-14 12-36 17-54 14-1 7-6 14-15 18z" fill="#393735"/>
                <path d="M87 66c14-20 39-25 58-12m-50 28c14 2 34-2 46-11" fill="none" stroke="#5c5450" stroke-width="3"/>
                <path d="M78 102v15m84-15v15" stroke="#393735" stroke-width="7"/>
            <?php } ?>

            <?php if ($cabelo === 'bone') { ?>
                <path d="M79 76c2-29 17-45 41-45s39 16 41 45z" fill="#0e7770" stroke="#0b5954" stroke-width="2"/>
                <path d="M82 71h76m-38-37v37" stroke="#4da69b" stroke-width="2"/>
                <path d="M115 75h58c7 0 9 4 4 8-11 8-33 10-62 1z" fill="#095e58" stroke="#0b5954" stroke-width="2"/>
                <path d="M121 79h47" stroke="#3b8e84" stroke-width="2"/>
            <?php } elseif ($cabelo === 'chapeu') { ?>
                <path d="M90 71l9-42c13-5 29-5 42 0l9 42z" fill="#be9458" stroke="#82643f" stroke-width="2"/>
                <path d="M95 54h50" stroke="#1b6963" stroke-width="8"/>
                <path d="M69 72c11 5 30 7 51 7s40-2 51-7c4 0 6 5 2 8-12 10-35 13-53 13s-41-3-53-13c-4-3-2-8 2-8z" fill="#a87d48" stroke="#82643f" stroke-width="2"/>
                <path d="M82 77c20 5 56 6 77 0" fill="none" stroke="#d0ad77" stroke-width="2"/>
            <?php } ?>

            <?php if ($rosto === 'rosto_piscada') { ?>
                <path d="M94 107c5-4 11-4 16 0m21-3c5-2 11-2 16 1" fill="none" stroke="#5d433a" stroke-width="2"/>
                <path d="M96 115h13" stroke="#493731" stroke-width="2.5"/>
                <path d="M132 114q6-5 13 0" fill="none" stroke="#493731" stroke-width="2.5"/>
                <path d="M105 145q16 15 30-2" fill="none" stroke="#8f5148" stroke-width="2.5"/>
            <?php } elseif ($rosto === 'rosto_serio') { ?>
                <path d="M95 105l14-2m22 0 14 2" stroke="#5d433a" stroke-width="2.5"/>
                <path d="M99 114h8m26 0h8" stroke="#493731" stroke-width="3"/>
                <path d="M109 148h22" stroke="#8f5148" stroke-width="2.5"/>
            <?php } else { ?>
                <path d="M96 105q7-4 13-1m22 0q6-3 13 1" fill="none" stroke="#5d433a" stroke-width="2"/>
                <path d="M99 114h8m26 0h8" stroke="#493731" stroke-width="3"/>
                <path d="M107 144q13 16 26 0" fill="none" stroke="#8f5148" stroke-width="2.5"/>
            <?php } ?>
            <path d="M120 113l-3 17q3 3 7 0" fill="none" stroke="#ba7e63" stroke-width="2"/>

            <?php if ($acessorio === 'oculos') { ?>
                <g fill="none" stroke="#243d4b" stroke-width="2.5">
                    <rect x="91" y="106" width="24" height="22" rx="7"/>
                    <rect x="125" y="106" width="24" height="22" rx="7"/>
                    <path d="M115 111q5-4 10 0m-34 1-12-3m70 3 12-3"/>
                </g>
                <path d="M93 109h18m16 0h18" stroke="#ffffff" stroke-width="2" opacity=".5"/>
            <?php } elseif ($acessorio === 'fone') { ?>
                <path d="M74 119V91c0-39 19-61 46-61s46 22 46 61v28" fill="none" stroke="#2d4554" stroke-width="7"/>
                <path d="M76 87c1-33 16-51 44-51s43 18 44 51" fill="none" stroke="#557383" stroke-width="2"/>
                <rect x="67" y="103" width="17" height="35" rx="6" fill="#243b4c"/>
                <rect x="156" y="103" width="17" height="35" rx="6" fill="#243b4c"/>
                <path d="M75 110v20m90-20v20" stroke="#52b5aa" stroke-width="3"/>
            <?php } ?>
        </g>
    </svg>
    <?php
    return ob_get_clean();
}
