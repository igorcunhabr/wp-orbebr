<?php

/**
 * Template Part para exibir um card de membro do time.
 */

$template_uri = get_template_directory_uri();
$card_data = [
    'image_url'     => obter_imagem_post(get_the_ID(), 'imagem', 'medium', $template_uri . '/assets/img/placeholder.png'),
    'image_alt'     => esc_attr(get_field('imagem')['alt'] ?? get_the_title()),
    'cargo'         => esc_html(get_field('cargo') ?? ''),
    'descricao'     => get_field('descricao') ?? '',
    'permalink'     => esc_url(get_the_permalink()),
    'title_attr'    => esc_attr(the_title_attribute(['echo' => false])),
];
?>
<article id="team-item-<?php the_ID(); ?>" <?php post_class('team-item'); ?>>
    <?php if ($card_data['image_url']) : ?>
        <img class="w-full h-[260px] rounded-[20px] object-cover mb-3"
            src="<?php echo $card_data['image_url']; ?>"
            alt="<?php echo $card_data['image_alt']; ?>"
            loading="lazy"
            decoding="async" />
    <?php endif; ?>
    <div class="flex flex-col gap-5">
        <div class="md:text-start flex flex-col gap-2 text-center">
            <div>
                <h2 class="text-black text-[28px] font-medium"><?php the_title(); ?></h2>
                <?php if ($card_data['cargo']) : ?>
                    <p class="text-base font-normal text-black"><?php echo $card_data['cargo']; ?></p>
                <?php endif; ?>
            </div>
            <span class="w-[100px] h-1 bg-amber-400 m-auto md:m-0"></span>
        </div>
        <?php if ($card_data['descricao']) : ?>
            <div class="w-full md:max-w-[477px] text-lg font-normal text-black text-center md:text-start">
                <div class="htmlchars">
                    <?php echo wp_kses_post($card_data['descricao']); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</article>