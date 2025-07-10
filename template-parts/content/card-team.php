<?php

/**
 * Template Part para exibir um card de membro do time.
 */

// ===================================================================
// [INICIALIZAÇÃO]
// Coleta e preparação dos dados do post para exibição no card
// ===================================================================

// Define a URI do tema para uso nos assets (imagens, ícones, etc.)
$template_uri = get_template_directory_uri();

// Organiza os dados necessários para o card em um array para melhor clareza
$card_data = [
    'image_url'     => get_field('imagem')['url'] ?? null,
    'image_alt'     => get_field('imagem')['alt'] ?? get_the_title(),
    'cargo'         => get_field('cargo') ?? '',
    'descricao'     => get_field('descricao') ?? '',
    'permalink'     => get_the_permalink(),
    'title_attr'    => the_title_attribute(['echo' => false]),
];

// ===================================================================
// [INÍCIO DO HTML]
// Marcações para apresentação do card do membro do time
// ===================================================================
?>

<article id="team-item-<?php the_ID(); ?>" <?php post_class('team-item'); ?>>

    <?php if ($card_data['image_url']) : ?>
        <img class="w-full h-[260px] rounded-[20px] object-cover mb-3"
            src="<?php echo esc_url($card_data['image_url']); ?>"
            alt="<?php echo esc_attr($card_data['image_alt']); ?>"
            loading="lazy"
            decoding="async" />
    <?php endif; ?>

    <div class="flex flex-col gap-5">
        <div class="md:text-start flex flex-col gap-2 text-center">
            <div>
                <h2 class="text-black text-[28px] font-medium"><?php the_title(); ?></h2>
                <?php if ($card_data['cargo']) : ?>
                    <p class="text-base font-normal text-black"><?php echo esc_html($card_data['cargo']); ?></p>
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