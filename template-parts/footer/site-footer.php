<?php

/**
 * O template para exibir o rodapé do site.
 */

// ===================================================================
// [INICIALIZAÇÃO]
// Coleta e preparação dos dados necessários para o rodapé
// ===================================================================

$template_uri = get_template_directory_uri();

// Define as redes sociais que queremos exibir.
$social_networks_config = [
  ['field' => 'config_instagram', 'icon' => 'icon-social-instagram.svg', 'label' => 'Instagram'],
  ['field' => 'config_facebook',  'icon' => 'icon-social-facebook.svg', 'label' => 'Facebook'],
  ['field' => 'config_tiktok',  'icon' => 'icon-social-tiktok.svg', 'label' => 'Tiktok'],
  ['field' => 'config_pinterest',  'icon' => 'icon-social-pinterest.svg', 'label' => 'Pinterest'],
  ['field' => 'config_linkedin',  'icon' => 'icon-social-linkedin.svg', 'label' => 'Linkedin'],
  ['field' => 'config_behance',  'icon' => 'icon-social-behance.svg', 'label' => 'Behance'],
  ['field' => 'config_youtube',   'icon' => 'icon-social-youtube.svg', 'label' => 'YouTube'],
  ['field' => 'config_spotify',  'icon' => 'icon-social-spotify.svg', 'label' => 'Spotify'],
];

// Coleta links de redes sociais usando helper
$social_links = [];
foreach ($social_networks_config as $network) {
  $url = obter_campo_acf($network['field'], 'option', '');
  if ($url) {
    $social_links[] = [
      'url'   => esc_url($url),
      'icon'  => esc_url($template_uri . '/assets/img/' . $network['icon']),
      'label' => $network['label'],
    ];
  }
}

// ===================================================================
// [INÍCIO DO HTML]
// Estrutura de apresentação do rodapé
// ===================================================================
?>

<footer id="footer">
  <div class="bg-[#0A121A] py-10 lg:py-20">
    <div class="lg:flex-row lg:justify-between container flex flex-col items-center">
      <div>
        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
          <img src="<?php echo esc_url($template_uri . '/assets/img/logo.svg'); ?>" alt="<?php bloginfo('name'); ?>">
        </a>
      </div>

      <div class="flex flex-col lg:flex-row text-center lg:text-start gap-5 lg:gap-10 max-w-[600px] mt-5 lg:mt-0">
        <div>
          <?php if (obter_campo_acf('config_endereco_titulo', 'option')) : ?>
            <h2 class="text-white text-[22px] font-normal"><?php echo esc_html(obter_campo_acf('config_endereco_titulo', 'option')); ?></h2>
          <?php endif; ?>

          <?php if (obter_campo_acf('config_endereco', 'option')) : ?>
            <p class="text-lg font-light leading-7 text-white"><?php echo esc_html(obter_campo_acf('config_endereco', 'option')); ?></p>
          <?php endif; ?>
        </div>

        <div>
          <h2 class="text-white text-[22px] font-normal"><?php _e('Contatos', 'textdomain'); ?></h2>

          <?php if (obter_campo_acf('config_telefone', 'option')) : ?>
            <p class="text-lg font-light leading-7 text-white"><?php echo esc_html(obter_campo_acf('config_telefone', 'option')); ?></p>
          <?php endif; ?>

          <?php if (obter_campo_acf('config_email', 'option')) : ?>
            <p class="text-lg font-light leading-7 text-white"><?php echo esc_html(obter_campo_acf('config_email', 'option')); ?></p>
          <?php endif; ?>
        </div>
      </div>

      <?php if (!empty($social_links)) : ?>
        <div class="lg:mt-0 flex gap-1 mt-5">
          <?php foreach ($social_links as $link) : ?>
            <a href="<?php echo $link['url']; ?>"
              target="_blank"
              rel="noopener"
              aria-label="<?php echo esc_attr($link['label']); ?>"
              class="hover:opacity-65 transition-opacity">
              <img src="<?php echo $link['icon']; ?>" alt="<?php echo esc_attr($link['label']); ?>">
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

    </div>
  </div>

  <div class="py-3 text-center">
    <p class="text-base font-normal text-black">&copy; 2024. <?php _e('Todos os direitos reservados.', 'textdomain'); ?></p>
  </div>
</footer>