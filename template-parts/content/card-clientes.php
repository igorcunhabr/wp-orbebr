<?php

/**
 * Template Part para exibir um card de post de Cliente.
 */

// ===================================================================
// [INICIALIZAÇÃO]
// Coleta e preparação dos dados do post para exibição no card
// ===================================================================

// Obtém a imagem usando a função helper
$imagem_url = obter_imagem_post(get_the_ID(), 'imagem', 'medium');

// Obtém a descrição usando a função helper
$descricao = obter_campo_acf('descricao', get_the_ID());

// ===================================================================
// [INÍCIO DO HTML]
// Marcações para apresentação do card do cliente
// ===================================================================
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('md:flex-row md:gap-8 md:items-center flex flex-col gap-4'); ?>>

    <?php if ($imagem_url) : ?>
        <img class="w-full md:max-w-[370px] md:h-[310px] h-auto rounded-[20px] object-cover border"
            src="<?php echo esc_url($imagem_url); ?>"
            alt="<?php echo esc_attr(get_the_title()); ?>"
            loading="lazy"
            decoding="async">
    <?php endif; ?>

    <div class="md:items-start flex flex-col items-center justify-center gap-1">
        <h2 class="text-2xl font-medium text-black"><?php the_title(); ?></h2>
        <?php if ($descricao) : ?>
            <div class="htmlchars">
                <?php echo wp_kses_post($descricao); ?>
            </div>
        <?php endif; ?>
    </div>

</article>