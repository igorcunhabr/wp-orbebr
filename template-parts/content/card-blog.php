<?php

/**
 * Template Part para exibir um card de post de Blog.
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
  'date_iso'      => get_the_date('c'),
  'date_display'  => get_the_date('j \d\e F \d\e Y'),
  'permalink'     => get_the_permalink(),
  'title_attr'    => the_title_attribute(['echo' => false]),
];

// ===================================================================
// [INÍCIO DO HTML]
// Marcações para apresentação do card do post
// ===================================================================
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('item'); ?>>
  <a href="<?php echo esc_url($card_data['permalink']); ?>" title="<?php echo esc_attr($card_data['title_attr']); ?>">

    <?php if ($card_data['image_url']) : ?>
      <div class="cover">
        <img
          src="<?php echo esc_url($card_data['image_url']); ?>"
          alt="<?php echo esc_attr($card_data['image_alt']); ?>"
          loading="lazy"
          decoding="async" />
      </div>
    <?php endif; ?>

    <div class="desc">

      <div class="date" aria-label="<?php esc_attr_e('Data da publicação', 'textdomain'); ?>">
        <img
          src="<?php echo esc_url($template_uri . '/assets/img/icon-calendar.svg'); ?>"
          alt="<?php esc_attr_e('Ícone calendário', 'textdomain'); ?>"
          aria-hidden="true" />
        <time datetime="<?php echo esc_attr($card_data['date_iso']); ?>">
          <?php echo esc_html($card_data['date_display']); ?>
        </time>
      </div>

      <h3><?php the_title(); ?></h3>

      <div class="more" aria-hidden="true">
        <img
          src="<?php echo esc_url($template_uri . '/assets/img/icon-arrow-circle-right.svg'); ?>"
          alt="<?php esc_attr_e('Ícone seta', 'textdomain'); ?>" />
        <span><?php esc_html_e('Veja mais', 'textdomain'); ?></span>
      </div>
    </div>
  </a>
</article>