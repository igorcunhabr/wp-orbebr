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

<header id="header" class="lg:absolute lg:bg-transparent relative top-0 left-0 z-10 w-full bg-black">
  <div class="lg:py-7 max-w-[90%] m-auto relative flex items-center justify-between py-4">
    <div>
      <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="flex items-center hover-scale">
        <img src="<?php echo esc_url($template_uri . '/assets/img/logo.svg'); ?>"
          alt="<?php bloginfo('name'); ?>"
          class="max-w-[100px] lg:max-w-max">
      </a>
    </div>

    <?php
    wp_nav_menu([
      'theme_location' => 'nav-header',
      'container'      => false,
      'menu_id'        => 'primary-menu',
      'menu_class'     => 'md:flex md:items-center z-20 md:z-auto md:static absolute bg-white md:bg-transparent w-full left-0 md:w-auto md:py-0 py-4 md:pl-0 pl-7 md:opacity-100 opacity-0 top-[-400px] transition-all ease-in duration-500',
      'fallback_cb'    => false,
      'walker'         => new class extends Walker_Nav_Menu {
        public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
        {
          $classes = empty($item->classes) ? [] : (array) $item->classes;
          $classes[] = 'md:my-0 mx-4 my-6'; // mesma classe de <li> no seu código original

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
          $item_output .= '<a' . $attributes . ' class="text-zinc-500 lg:text-white hover:text-[#FFD530] text-[16px] duration-500">';
          $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
          $item_output .= '</a>';
          $item_output .= $args->after;

          $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }
      }
    ]);
    ?>

    <?php if (!empty($social_links)) : ?>
      <div class="lg:flex hidden gap-1">
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

    <div class="lg:flex hidden gap-1">
      <a href="javascript:trocarIdioma('pt')" class="hover:opacity-65 transition-opacity" title="Português">
        <img src="<?php echo esc_url($template_uri . '/assets/img/lang-pt.svg'); ?>" alt="Português">
      </a>

      <a href="javascript:trocarIdioma('en')" class="hover:opacity-65 transition-opacity" title="English">
        <img src="<?php echo esc_url($template_uri . '/assets/img/lang-en.svg'); ?>" alt="English">
      </a>
    </div>
  </div>
</header>