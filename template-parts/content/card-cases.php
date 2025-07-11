<?php

/**
 * Template Part para exibir um card de post de Cases.
 */

$template_uri = get_template_directory_uri();
$card_data = [
    'image_url'     => obter_imagem_post(get_the_ID(), 'imagem', 'large', $template_uri . '/assets/img/default.png'),
    'image_alt'     => esc_attr(get_field('imagem')['alt'] ?? get_the_title()),
    'permalink'     => esc_url(get_the_permalink()),
    'title_attr'    => esc_attr(the_title_attribute(['echo' => false])),
    'resumo'     => get_field('resumo') ?? '',
];
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('md:flex-row gap-7 md:gap-14 flex flex-col'); ?>>
    <div class="w-full md:basis-1/2">
        <?php if ($card_data['image_url']) : ?>
            <img
                class="w-full h-auto md:h-[520px] rounded-[20px] object-cover"
                src="<?php echo $card_data['image_url']; ?>"
                alt="<?php echo $card_data['image_alt']; ?>"
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
                <?php echo wp_kses_post($card_data['resumo']); ?>
            </div>
        </div>
        <a class="w-[230px] h-[62px] bg-amber-400 hover:bg-amber-500 transition-all rounded-[10px] text-slate-950 text-xl font-normal flex justify-center items-center"
            href="<?php echo $card_data['permalink']; ?>"
            title="<?php echo $card_data['title_attr']; ?>">
            <?php _e('Mais detalhes', 'textdomain'); ?>
        </a>
    </div>
</article>