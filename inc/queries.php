<?php

/**
 * Template Part para gerenciamento de queries personalizadas.
 */

// ===================================================================
// [CLASSE PARA GERENCIAMENTO DE QUERIES]
// Centraliza o gerenciamento de queries personalizadas
// ===================================================================

class ThemeQueries
{

  /**
   * Configurações padrão de posts por página para diferentes arquivos
   */
  private static $posts_per_page_config = [
    'comunidades' => 4,
    'livros'      => 8,
    'blogs'       => 8,
    'cases'       => 6,
    'servicos'    => 6,
    'clientes'    => 12,
    'certificacoes' => 12,
    'teams'       => 8,
    'banners'     => 10,
  ];

  /**
   * Configurações de ordenação personalizadas
   */
  private static $order_config = [
    'servicos' => [
      'orderby'  => 'meta_value_num',
      'meta_key' => 'ordem'
    ],
    'banners' => [
      'orderby' => 'date',
      'order'   => 'ASC'
    ],
  ];

  /**
   * Define posts por página para arquivos específicos
   *
   * @param WP_Query $query Objeto da query
   */
  public static function definir_posts_por_pagina($query)
  {
    if (is_admin() || !$query->is_main_query()) {
      return;
    }

    $post_type = get_query_var('post_type');
    if (!$post_type) {
      // Tenta obter o post type da query atual
      $post_type = $query->get('post_type');
    }

    // Se não tem post type específico, verifica se é um arquivo de post type
    if (!$post_type) {
      foreach (array_keys(self::$posts_per_page_config) as $type) {
        if (is_post_type_archive($type)) {
          $post_type = $type;
          break;
        }
      }
    }

    if ($post_type && isset(self::$posts_per_page_config[$post_type])) {
      $query->set('posts_per_page', self::$posts_per_page_config[$post_type]);
    }
  }

  /**
   * Aplica ordenação personalizada para post types específicos
   *
   * @param WP_Query $query Objeto da query
   */
  public static function aplicar_ordenacao_personalizada($query)
  {
    if (is_admin() || !$query->is_main_query()) {
      return;
    }

    $post_type = get_query_var('post_type');
    if (!$post_type) {
      $post_type = $query->get('post_type');
    }

    if ($post_type && isset(self::$order_config[$post_type])) {
      $config = self::$order_config[$post_type];
      foreach ($config as $key => $value) {
        $query->set($key, $value);
      }
    }
  }

  /**
   * Cria uma query otimizada para um post type específico
   *
   * @param string $post_type      Tipo de post
   * @param int    $posts_per_page Número de posts por página
   * @param array  $args_extras    Argumentos extras
   * @return WP_Query Objeto da query
   */
  public static function criar_query_otimizada($post_type, $posts_per_page = null, $args_extras = [])
  {
    // Usa configuração padrão se não especificado
    if ($posts_per_page === null && isset(self::$posts_per_page_config[$post_type])) {
      $posts_per_page = self::$posts_per_page_config[$post_type];
    }

    $args = [
      'post_type'      => $post_type,
      'posts_per_page' => $posts_per_page ?: 8,
      'post_status'    => 'publish',
      'no_found_rows'  => true,
      'orderby'        => 'menu_order title',
      'order'          => 'ASC',
    ];

    // Aplica configuração de ordenação personalizada
    if (isset(self::$order_config[$post_type])) {
      $args = array_merge($args, self::$order_config[$post_type]);
    }

    // Mescla argumentos extras
    if (!empty($args_extras)) {
      $args = array_merge($args, $args_extras);
    }

    return new WP_Query($args);
  }

  /**
   * Obtém posts relacionados
   *
   * @param int    $post_id       ID do post atual
   * @param string $post_type     Tipo de post
   * @param int    $posts_per_page Número de posts
   * @return WP_Query Query de posts relacionados
   */
  public static function obter_posts_relacionados($post_id, $post_type, $posts_per_page = 3)
  {
    $args = [
      'post_type'      => $post_type,
      'posts_per_page' => $posts_per_page,
      'post_status'    => 'publish',
      'post__not_in'   => [$post_id],
      'no_found_rows'  => true,
      'orderby'        => 'rand',
    ];

    return new WP_Query($args);
  }

  /**
   * Obtém posts em destaque
   *
   * @param string $post_type     Tipo de post
   * @param int    $posts_per_page Número de posts
   * @return WP_Query Query de posts em destaque
   */
  public static function obter_posts_destaque($post_type, $posts_per_page = 3)
  {
    $args = [
      'post_type'      => $post_type,
      'posts_per_page' => $posts_per_page,
      'post_status'    => 'publish',
      'meta_query'     => [
        [
          'key'     => 'destaque',
          'value'   => '1',
          'compare' => '='
        ]
      ],
      'no_found_rows'  => true,
      'orderby'        => 'menu_order title',
      'order'          => 'ASC',
    ];

    return new WP_Query($args);
  }

  /**
   * Obtém configuração de posts por página
   *
   * @param string $post_type Tipo de post
   * @return int|null Número de posts por página ou null
   */
  public static function get_posts_per_page($post_type)
  {
    return self::$posts_per_page_config[$post_type] ?? null;
  }

  /**
   * Adiciona nova configuração de posts por página
   *
   * @param string $post_type Tipo de post
   * @param int    $posts_per_page Número de posts
   */
  public static function adicionar_config_posts_per_page($post_type, $posts_per_page)
  {
    self::$posts_per_page_config[$post_type] = $posts_per_page;
  }

  /**
   * Adiciona nova configuração de ordenação
   *
   * @param string $post_type Tipo de post
   * @param array  $config    Configuração de ordenação
   */
  public static function adicionar_config_ordenacao($post_type, $config)
  {
    self::$order_config[$post_type] = $config;
  }
}

// ===================================================================
// [REGISTRO DOS HOOKS]
// Registra as funções nos hooks apropriados
// ===================================================================

add_action('pre_get_posts', [ThemeQueries::class, 'definir_posts_por_pagina']);
add_action('pre_get_posts', [ThemeQueries::class, 'aplicar_ordenacao_personalizada']);

// ===================================================================
// [FUNÇÕES DE CONVENIÊNCIA]
// Funções globais para facilitar o uso das queries
// ===================================================================

/**
 * Cria query otimizada
 */
function criar_query_otimizada($post_type, $posts_per_page = null, $args_extras = [])
{
  return ThemeQueries::criar_query_otimizada($post_type, $posts_per_page, $args_extras);
}

/**
 * Obtém posts relacionados
 */
function obter_posts_relacionados($post_id, $post_type, $posts_per_page = 3)
{
  return ThemeQueries::obter_posts_relacionados($post_id, $post_type, $posts_per_page);
}

/**
 * Obtém posts em destaque
 */
function obter_posts_destaque($post_type, $posts_per_page = 3)
{
  return ThemeQueries::obter_posts_destaque($post_type, $posts_per_page);
}

/**
 * Adiciona configuração de posts por página
 */
function adicionar_config_posts_per_page($post_type, $posts_per_page)
{
  ThemeQueries::adicionar_config_posts_per_page($post_type, $posts_per_page);
}

/**
 * Adiciona configuração de ordenação
 */
function adicionar_config_ordenacao($post_type, $config)
{
  ThemeQueries::adicionar_config_ordenacao($post_type, $config);
}
