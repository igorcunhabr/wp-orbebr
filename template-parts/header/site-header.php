<?php

/**
 * Template Part para o cabeçalho do site.
 */

// ===================================================================
// [INICIALIZAÇÃO]
// Coleta e preparação dos dados necessários para o cabeçalho
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

$social_links = [];
foreach ($social_networks_config as $network) {
  $url = get_field($network['field'], 'option');
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
// Estrutura de apresentação do cabeçalho
// ===================================================================
?>

<header id="header" class="lg:absolute lg:bg-transparent relative top-0 left-0 z-50 w-full bg-black">
  <div class="lg:py-7 max-w-[90%] m-auto relative flex items-center justify-between py-4">
    <!-- Logo -->
    <div>
      <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="flex items-center hover-scale">
        <img src="<?php echo esc_url($template_uri . '/assets/img/logo.svg'); ?>"
          alt="<?php bloginfo('name'); ?>"
          class="max-w-[100px] lg:max-w-max">
      </a>
    </div>

    <!-- Menu Desktop -->
    <nav class="hidden lg:block">
      <?php
      wp_nav_menu([
        'theme_location' => 'nav-header',
        'container'      => false,
        'menu_id'        => 'primary-menu-desktop',
        'menu_class'     => 'flex items-center space-x-8',
        'fallback_cb'    => false,
        'walker'         => new class extends Walker_Nav_Menu {
          public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
          {
            $classes = empty($item->classes) ? [] : (array) $item->classes;
            $classes[] = '';

            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';

            $output .= '<li' . $id . $class_names . '>';

            $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';
            $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target) . '"' : '';
            $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) . '"' : '';
            $attributes .= ! empty($item->url)        ? ' href="'   . esc_url($item->url) . '"' : '';

            $item_output  = $args->before;
            $item_output .= '<a' . $attributes . ' class="text-white hover:text-[#FFD530] text-[16px] font-medium duration-300 transition-colors">';
            $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
          }
        }
      ]);
      ?>
    </nav>

    <!-- Redes Sociais Desktop -->
    <?php if (!empty($social_links)) : ?>
      <div class="hidden lg:flex gap-3">
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

    <!-- Seletor de Idioma Desktop -->
    <div class="hidden lg:flex gap-2">
      <a href="https://orbebrasil.com" class="hover:opacity-65 transition-opacity" title="Português">
        <img src="<?php echo esc_url($template_uri . '/assets/img/lang-pt.svg'); ?>" alt="Português">
      </a>
      <a href="https://orbeuk.co.uk" target="_blank" class="hover:opacity-65 transition-opacity" title="English">
        <img src="<?php echo esc_url($template_uri . '/assets/img/lang-en.svg'); ?>" alt="English">
      </a>
    </div>

    <!-- Botão Menu Mobile -->
    <button id="js-open-menu"
      class="lg:hidden z-50"
      aria-label="Abrir menu"
      aria-expanded="false"
      aria-controls="mobile-menu">
      <span></span>
      <span></span>
      <span></span>
    </button>
  </div>

  <!-- Menu Mobile -->
  <div id="mobile-menu"
    class="lg:hidden fixed top-0 left-0 w-full h-screen bg-black bg-opacity-95 z-40 transform -translate-x-full transition-transform duration-300 ease-in-out"
    aria-hidden="true">

    <div class="flex flex-col h-full pt-20 px-6">
      <!-- Menu de Navegação Mobile -->
      <nav class="flex-1">
        <?php
        wp_nav_menu([
          'theme_location' => 'nav-header',
          'container'      => false,
          'menu_id'        => 'primary-menu-mobile',
          'menu_class'     => 'space-y-6',
          'fallback_cb'    => false,
          'walker'         => new class extends Walker_Nav_Menu {
            public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
            {
              $classes = empty($item->classes) ? [] : (array) $item->classes;
              $classes[] = '';

              $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
              $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

              $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
              $id = $id ? ' id="' . esc_attr($id) . '"' : '';

              $output .= '<li' . $id . $class_names . '>';

              $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';
              $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target) . '"' : '';
              $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) . '"' : '';
              $attributes .= ! empty($item->url)        ? ' href="'   . esc_url($item->url) . '"' : '';

              $item_output  = $args->before;
              $item_output .= '<a' . $attributes . ' class="block text-white hover:text-[#FFD530] text-xl font-medium duration-300 transition-colors py-2">';
              $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
              $item_output .= '</a>';
              $item_output .= $args->after;

              $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
            }
          }
        ]);
        ?>
      </nav>

      <!-- Redes Sociais Mobile -->
      <?php if (!empty($social_links)) : ?>
        <div class="flex justify-center gap-4 py-8 border-t border-gray-700 social-icons">
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

      <!-- Seletor de Idioma Mobile -->
      <div class="flex justify-center gap-4 py-4 language-selector">
        <a href="https://orbebrasil.com" class="hover:opacity-65 transition-opacity" title="Português">
          <img src="<?php echo esc_url($template_uri . '/assets/img/lang-pt.svg'); ?>" alt="Português">
        </a>
        <a href="https://orbeuk.co.uk" target="_blank" class="hover:opacity-65 transition-opacity" title="English">
          <img src="<?php echo esc_url($template_uri . '/assets/img/lang-en.svg'); ?>" alt="English">
        </a>
      </div>
    </div>
  </div>
</header>