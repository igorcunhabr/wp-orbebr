<?php

/**
 * Template Part para gerenciamento de assets (JS/CSS).
 */

// ===================================================================
// [CONFIGURAÇÃO DE ASSETS]
// Define os assets do tema de forma centralizada
// ===================================================================

class ThemeAssets
{
  private $template_uri;
  private $template_path;
  private $version_suffix;

  public function __construct()
  {
    $this->template_uri = get_template_directory_uri();
    $this->template_path = get_template_directory();
    $this->version_suffix = defined('WP_DEBUG') && WP_DEBUG ? '.' . time() : '';
  }

  /**
   * Registra todos os assets do tema
   */
  public function register_assets()
  {
    $this->register_styles();
    $this->register_scripts();
    $this->add_resource_hints();
  }

  /**
   * Registra os estilos CSS
   */
  private function register_styles()
  {
    $styles = [
      'swiper-style' => [
        'src' => $this->template_uri . '/assets/css/swiper.min.css',
        'path' => $this->template_path . '/assets/css/swiper.min.css',
      ],
      'tailwind-custom' => [
        'src' => $this->template_uri . '/assets/css/tailwind-custom.css',
        'path' => $this->template_path . '/assets/css/tailwind-custom.css',
      ],
    ];

    foreach ($styles as $handle => $style) {
      if (file_exists($style['path'])) {
        wp_enqueue_style(
          $handle,
          $style['src'],
          [],
          filemtime($style['path']) . $this->version_suffix
        );
      }
    }
  }

  /**
   * Registra os scripts JavaScript
   */
  private function register_scripts()
  {
    $scripts = [
      'swiper-script' => [
        'file' => 'swiper.min.js',
        'deps' => []
      ],
      'fslightbox-script' => [
        'file' => 'fslightbox.js',
        'deps' => []
      ],
      'svg-inject-script' => [
        'file' => 'svg-inject.min.js',
        'deps' => []
      ],
      'scrollreveal-script' => [
        'file' => 'scrollreveal.min.js',
        'deps' => []
      ],
      'custom-script' => [
        'file' => 'scripts.js',
        'deps' => ['swiper-script', 'fslightbox-script', 'svg-inject-script', 'scrollreveal-script']
      ],
    ];

    foreach ($scripts as $handle => $script) {
      $path = $this->template_path . '/assets/js/' . $script['file'];
      if (file_exists($path)) {
        wp_enqueue_script(
          $handle,
          $this->template_uri . '/assets/js/' . $script['file'],
          $script['deps'],
          filemtime($path) . $this->version_suffix,
          ['strategy' => 'defer']
        );
      }
    }
  }

  /**
   * Adiciona resource hints para otimização
   */
  private function add_resource_hints()
  {
    add_action('wp_resource_hints', [$this, 'resource_hints'], 10, 2);
  }

  /**
   * Adiciona hints para preconnect dos domínios externos
   */
  public function resource_hints($hints, $relation_type)
  {
    if ('preconnect' === $relation_type) {
      $hints[] = ['href' => 'https://fonts.googleapis.com'];
      $hints[] = [
        'href' => 'https://fonts.gstatic.com',
        'crossorigin' => ''
      ];
      $hints[] = ['href' => 'https://cdn.jsdelivr.net'];
    }
    return $hints;
  }
}

// ===================================================================
// [INICIALIZAÇÃO]
// Instancia e registra os assets
// ===================================================================

$theme_assets = new ThemeAssets();
add_action('wp_enqueue_scripts', [$theme_assets, 'register_assets']);
