<?php

/**
 * Template Part para gerenciamento de assets (JS/CSS).
 */

// ===================================================================
// [ENQUEUE DE ESTILOS (CSS)]
// Enfileira os arquivos CSS, incluindo fontes customizadas
// ===================================================================

function meu_tema_enqueue_assets()
{
  $dir_uri = get_template_directory_uri();
  $dir_path = get_template_directory();
  $version_suffix = defined('WP_DEBUG') && WP_DEBUG ? '.' . time() : '';

  // Carrega apenas as fontes customizadas e estilos específicos
  $styles = [
    'swiper-style' => [
      'src'  => $dir_uri . '/assets/css/swiper.min.css',
      'path' => $dir_path . '/assets/css/swiper.min.css',
      'deps' => [],
    ],
    'tailwind-custom' => [
      'src'  => $dir_uri . '/assets/css/tailwind-custom.css',
      'path' => $dir_path . '/assets/css/tailwind-custom.css',
      'deps' => [],
    ],
  ];

  foreach ($styles as $handle => $style) {
    if (isset($style['path'])) {
      if (file_exists($style['path'])) {
        wp_enqueue_style($handle, $style['src'], $style['deps'], filemtime($style['path']) . $version_suffix);
      }
    } else {
      wp_enqueue_style($handle, $style['src'], $style['deps'], $style['version']);
    }
  }

  // ===================================================================
  // [ENQUEUE DE SCRIPTS (JS)]
  // Enfileira scripts locais com dependências, usando defer para otimizar.
  // ===================================================================

  $scripts = [
    'swiper-script'         => ['file' => 'swiper.min.js', 'deps' => []],
    'fslightbox-script'     => ['file' => 'fslightbox.js', 'deps' => []],
    'gsap-script'           => ['file' => 'gsap.min.js', 'deps' => []],
    'scroll-trigger-script' => ['file' => 'ScrollTrigger.min.js', 'deps' => ['gsap-script']],
    'svg-inject-script'     => ['file' => 'svg-inject.min.js', 'deps' => []],
    'animations'     => ['file' => 'animations.js', 'deps' => ['gsap-script', 'scroll-trigger-script']],
    'custom-script'         => [
      'file' => 'scripts.js',
      'deps' => ['swiper-script', 'fslightbox-script', 'gsap-script', 'scroll-trigger-script', 'svg-inject-script', 'animations'],
    ],
  ];

  foreach ($scripts as $handle => $script) {
    $path = $dir_path . '/assets/js/' . $script['file'];
    if (file_exists($path)) {
      wp_enqueue_script($handle, $dir_uri . '/assets/js/' . $script['file'], $script['deps'], filemtime($path) . $version_suffix, [
        'strategy' => 'defer',
      ]);
    }
  }
}
add_action('wp_enqueue_scripts', 'meu_tema_enqueue_assets');

// ===================================================================
// [RESOURCE HINTS]
// Adiciona preconnect para domínios do Google Fonts e Tailwind CDN para otimizar o carregamento.
// ===================================================================

/**
 * Adiciona hints para preconnect dos domínios usados pelo Google Fonts e Tailwind CDN.
 *
 * @param array  $hints          Os hints para o tipo de relação
 * @param string $relation_type  Tipo de relação (ex: preconnect)
 * @return array
 */
function meu_tema_resource_hints($hints, $relation_type)
{
  if ('preconnect' === $relation_type) {
    $hints[] = [
      'href' => 'https://fonts.googleapis.com',
    ];
    $hints[] = [
      'href'       => 'https://fonts.gstatic.com',
      'crossorigin' => '',
    ];
    $hints[] = [
      'href' => 'https://cdn.jsdelivr.net',
    ];
  }
  return $hints;
}
add_action('wp_resource_hints', 'meu_tema_resource_hints', 10, 2);
