<figure class="aula-diagrama">
    <picture>
        <source media="(prefers-reduced-motion: reduce)" srcset="<?php echo htmlspecialchars($conteudo['animacao']['poster']); ?>">
        <img src="<?php echo htmlspecialchars($conteudo['animacao']['gif']); ?>"
             alt="<?php echo htmlspecialchars($conteudo['animacao']['alt']); ?>"
             width="760" height="260" loading="lazy" decoding="async">
    </picture>
    <figcaption><?php echo htmlspecialchars($conteudo['animacao']['legenda']); ?></figcaption>
</figure>
