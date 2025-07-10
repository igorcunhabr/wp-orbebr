<?php

/**
 * Template Part para exibir um card de post de Cases.
 */

// ===================================================================
// [INICIALIZAÇÃO]
// Coleta e preparação dos dados do post para exibição no card
// ===================================================================

// Organiza os dados necessários para o card em um array para melhor clareza
$card_data = [
    'image_url'     => get_field('imagem')['url'] ?? get_the_post_thumbnail_url(get_the_ID(), 'large'),
    'image_alt'     => get_field('imagem')['alt'] ?? get_the_title(),
    'permalink'     => get_the_permalink(),
    'title_attr'    => the_title_attribute(['echo' => false]),
    'excerpt'       => get_the_excerpt() ?: wp_trim_words(get_the_content(), 20, '...'),
];

// ===================================================================
// [INÍCIO DO HTML]
// Marcações para apresentação do card do case
// ===================================================================
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('md:flex-row gap-7 md:gap-14 flex flex-col'); ?>>
    <div class="w-full md:basis-1/2">
        <?php if ($card_data['image_url']) : ?>
            <img
                class="w-full h-auto md:h-[520px] rounded-[20px] object-cover"
                src="<?php echo esc_url($card_data['image_url']); ?>"
                alt="<?php echo esc_attr($card_data['image_alt']); ?>"
                loading="lazy"
                decoding="async">
        <?php endif; ?>
    </div>

    <div class="w-full md:basis-1/2 md:items-start flex flex-col items-center justify-center gap-5">
        <div class="md:text-start text-center">
            <h2 class="text-2xl font-medium text-black"><?php the_title(); ?></h2>
        </div>
        <div class="text-lg font-normal text-black">
            <div class="htmlchars">
                <?php echo get_field('descricao'); ?>
            </div>
        </div>
        <a class="w-[230px] h-[62px] bg-amber-400 hover:bg-amber-500 transition-all rounded-[10px] text-slate-950 text-xl font-normal flex justify-center items-center"
            href="<?php echo esc_url($card_data['permalink']); ?>"
            title="<?php echo esc_attr($card_data['title_attr']); ?>">
            Mais detalhes
        </a>
    </div>
</article>