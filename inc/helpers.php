<?php

/**
 * Funções auxiliares do tema.
 */

// ===================================================================
// [CLASSE DE HELPERS]
// Centraliza todas as funções auxiliares em uma classe organizada
// ===================================================================

class ThemeHelpers
{

  /**
   * Monta um link "click-to-chat" do WhatsApp usando número e mensagem do ACF.
   *
   * @param string $numero_field Nome do campo ACF para o número (padrão: 'config_whatsapp_numero')
   * @param string $mensagem_field Nome do campo ACF para a mensagem (padrão: 'config_whatsapp_mensagem')
   * @return string URL completa do WhatsApp ou string vazia se número não definido.
   */
  public static function montar_link_whatsapp($numero_field = 'config_whatsapp_numero', $mensagem_field = 'config_whatsapp_mensagem')
  {
    // Obtém o número bruto do campo ACF
    $numero_raw = self::obter_campo_acf($numero_field, 'option');

    if (empty($numero_raw)) {
      return '';
    }

    // Sanitiza o número para conter apenas dígitos
    $numero_sanitizado = preg_replace('/[^0-9]/', '', $numero_raw);

    if (empty($numero_sanitizado)) {
      return '';
    }

    // Prepara os parâmetros da query
    $query_args = ['phone' => $numero_sanitizado];

    // Adiciona a mensagem, se houver
    $mensagem = self::obter_campo_acf($mensagem_field, 'option');
    if (!empty($mensagem)) {
      $query_args['text'] = $mensagem;
    }

    // Monta a URL final
    $base_url = 'https://api.whatsapp.com/send';
    $final_url = add_query_arg($query_args, $base_url);

    return esc_url($final_url);
  }

  /**
   * Obtém imagem de post com fallback inteligente
   * 
   * @param int    $post_id       ID do post
   * @param string $campo_acf     Nome do campo ACF (padrão: 'imagem')
   * @param string $tamanho       Tamanho da imagem (padrão: 'full')
   * @param string $imagem_padrao URL da imagem padrão (opcional)
   * @return string URL da imagem ou string vazia
   */
  public static function obter_imagem_post($post_id, $campo_acf = 'imagem', $tamanho = 'full', $imagem_padrao = null)
  {
    if (!$post_id || !is_numeric($post_id)) {
      return $imagem_padrao ?: '';
    }

    $imagem = '';

    // Tenta pegar featured image
    if (has_post_thumbnail($post_id)) {
      $imagem = get_the_post_thumbnail_url($post_id, $tamanho);
    }

    // Se não tiver, tenta campo ACF
    if (empty($imagem) && function_exists('get_field')) {
      $acf_imagem = get_field($campo_acf, $post_id);
      if ($acf_imagem && isset($acf_imagem['url'])) {
        $imagem = $acf_imagem['url'];
      } elseif (is_string($acf_imagem) && !empty($acf_imagem)) {
        $imagem = $acf_imagem;
      }
    }

    // Fallback para imagem padrão
    if (empty($imagem) && $imagem_padrao) {
      $imagem = $imagem_padrao;
    }

    return $imagem;
  }

  /**
   * Obtém valor de campo ACF com fallback seguro
   *
   * @param string $campo    Nome do campo ACF
   * @param int    $post_id  ID do post (null para opções do tema)
   * @param mixed  $fallback Valor padrão se campo não existir
   * @return mixed Valor do campo ou fallback
   */
  public static function obter_campo_acf($campo, $post_id = null, $fallback = '')
  {
    if (!function_exists('get_field')) {
      return $fallback;
    }

    if (empty($campo)) {
      return $fallback;
    }

    $valor = get_field($campo, $post_id);
    return !empty($valor) ? $valor : $fallback;
  }

  /**
   * Cria query WordPress com parâmetros flexíveis
   *
   * @param string $post_type      Tipo de post
   * @param int    $posts_per_page Número de posts por página
   * @param array  $args_extras    Argumentos extras para a query
   * @return WP_Query Objeto de query
   */
  public static function criar_query($post_type, $posts_per_page = 8, $args_extras = [])
  {
    if (empty($post_type)) {
      return new WP_Query(['post__in' => []]); // Query vazia
    }

    $args_padrao = [
      'post_type'      => $post_type,
      'posts_per_page' => absint($posts_per_page),
      'post_status'    => 'publish',
      'no_found_rows'  => true,
      'orderby'        => 'menu_order title',
      'order'          => 'ASC',
    ];

    return new WP_Query(array_merge($args_padrao, $args_extras));
  }

  /**
   * Obtém dados de redes sociais de forma organizada
   *
   * @param array $networks_config Configuração das redes sociais
   * @return array Array com links das redes sociais
   */
  public static function obter_redes_sociais($networks_config = [])
  {
    if (empty($networks_config)) {
      $networks_config = [
        ['field' => 'config_instagram', 'icon' => 'icon-social-instagram.svg', 'label' => 'Instagram'],
        ['field' => 'config_facebook',  'icon' => 'icon-social-facebook.svg', 'label' => 'Facebook'],
        ['field' => 'config_tiktok',   'icon' => 'icon-social-tiktok.svg', 'label' => 'Tiktok'],
        ['field' => 'config_pinterest', 'icon' => 'icon-social-pinterest.svg', 'label' => 'Pinterest'],
        ['field' => 'config_linkedin', 'icon' => 'icon-social-linkedin.svg', 'label' => 'Linkedin'],
        ['field' => 'config_behance',  'icon' => 'icon-social-behance.svg', 'label' => 'Behance'],
        ['field' => 'config_youtube',  'icon' => 'icon-social-youtube.svg', 'label' => 'YouTube'],
        ['field' => 'config_spotify',  'icon' => 'icon-social-spotify.svg', 'label' => 'Spotify'],
      ];
    }

    $template_uri = get_template_directory_uri();
    $social_links = [];

    foreach ($networks_config as $network) {
      $url = self::obter_campo_acf($network['field'], 'option');
      if ($url) {
        $social_links[] = [
          'url'   => esc_url($url),
          'icon'  => esc_url($template_uri . '/assets/img/' . $network['icon']),
          'label' => $network['label'],
        ];
      }
    }

    return $social_links;
  }

  /**
   * Renderiza o componente de paginação
   *
   * @param WP_Query|null $query Objeto da query (opcional)
   * @param array $args Argumentos personalizados para a paginação
   */
  public static function renderizar_paginacao($query = null, $args = [])
  {
    // Se não foi passada uma query, usa a query principal
    if (!$query || !$query instanceof WP_Query) {
      global $wp_query;
      $query = $wp_query;
    }

    // Obtém informações da paginação
    $total_pages = $query->max_num_pages;
    $current_page = get_query_var('paged') ?: 1;

    // Só exibe se há mais de uma página
    if ($total_pages <= 1) {
      return;
    }

    // Renderiza o componente
    get_template_part('template-parts/pagination', 'simple', [
      'query' => $query,
      'args'  => $args
    ]);
  }

  /**
   * Verifica se deve exibir paginação
   *
   * @param WP_Query|null $query Objeto da query (opcional)
   * @return bool True se deve exibir paginação
   */
  public static function deve_exibir_paginacao($query = null)
  {
    if (!$query || !$query instanceof WP_Query) {
      global $wp_query;
      $query = $wp_query;
    }

    return $query->max_num_pages > 1;
  }

  /**
   * Define o título personalizado da página para o header interno
   *
   * @param string $titulo Título personalizado da página
   * @return void
   */
  public static function definir_titulo_pagina($titulo)
  {
    if (!empty($titulo)) {
      $GLOBALS['custom_page_title'] = sanitize_text_field($titulo);
    }
  }

  /**
   * Obtém o título da página com fallback inteligente
   *
   * @return string Título da página
   */
  public static function obter_titulo_pagina()
  {
    // 1. Verifica se existe uma variável global definida (maior prioridade)
    $page_title = $GLOBALS['custom_page_title'] ?? null;

    // 2. Se não houver variável global, verifica campo ACF 'titulo_pagina'
    if (!$page_title) {
      $page_title = self::obter_campo_acf('titulo_pagina');
    }

    // 3. Se não houver ACF, verifica campo ACF 'titulo_header'
    if (!$page_title) {
      $page_title = self::obter_campo_acf('titulo_header');
    }

    // 4. Fallback: usa o título da página/post atual
    if (!$page_title) {
      if (is_archive()) {
        $page_title = get_the_archive_title();
        // Remove prefixos comuns do WordPress como "Arquivos:", "Categoria:", etc.
        $page_title = self::limpar_prefixos_archive($page_title);
      } elseif (is_search()) {
        $page_title = 'Resultados da busca';
      } elseif (is_404()) {
        $page_title = 'Página não encontrada';
      } else {
        $page_title = get_the_title();
      }
    }

    // Remove tags HTML do título (caso venha do WordPress)
    return wp_strip_all_tags($page_title);
  }

  /**
   * Remove prefixos comuns do WordPress dos títulos de archive
   *
   * @param string $titulo Título com prefixo
   * @return string Título limpo
   */
  private static function limpar_prefixos_archive($titulo)
  {
    // Lista de prefixos comuns do WordPress para remover
    $prefixos = [
      'Arquivos: ',
      'Arquivo: ',
      'Categoria: ',
      'Categorias: ',
      'Tag: ',
      'Tags: ',
      'Autor: ',
      'Autores: ',
      'Ano: ',
      'Mês: ',
      'Dia: ',
      'Archives: ',
      'Archive: ',
      'Category: ',
      'Categories: ',
      'Tag: ',
      'Tags: ',
      'Author: ',
      'Authors: ',
      'Year: ',
      'Month: ',
      'Day: '
    ];

    // Remove cada prefixo se encontrado
    foreach ($prefixos as $prefixo) {
      if (strpos($titulo, $prefixo) === 0) {
        $titulo = substr($titulo, strlen($prefixo));
        break; // Remove apenas o primeiro prefixo encontrado
      }
    }

    return trim($titulo);
  }

  /**
   * Sanitiza e valida dados de entrada
   *
   * @param mixed  $data    Dados a serem sanitizados
   * @param string $type    Tipo de sanitização ('text', 'email', 'url', 'int')
   * @return mixed Dados sanitizados
   */
  public static function sanitizar_dados($data, $type = 'text')
  {
    if (empty($data)) {
      return '';
    }

    switch ($type) {
      case 'email':
        return sanitize_email($data);
      case 'url':
        return esc_url_raw($data);
      case 'int':
        return absint($data);
      case 'text':
      default:
        return sanitize_text_field($data);
    }
  }

  /**
   * Verifica se uma página é a página inicial
   *
   * @return bool True se for página inicial
   */
  public static function is_home_page()
  {
    return is_front_page() || is_home();
  }

  /**
   * Obtém o template URI de forma segura
   *
   * @return string Template URI
   */
  public static function get_template_uri()
  {
    return get_template_directory_uri();
  }

  /**
   * Obtém classes personalizadas para o elemento body
   * Combina classes do WordPress com classes customizadas do tema
   *
   * @param string|array $classes_adicionais Classes adicionais para incluir
   * @return string String com todas as classes aplicadas
   */
  public static function get_body_classes($classes_adicionais = '')
  {
    // Classes base do tema
    $classes_base = ['antialiased'];

    // Classes do WordPress (body_class())
    $wp_classes = get_body_class();

    // Classes adicionais (pode ser string ou array)
    $classes_extra = [];
    if (!empty($classes_adicionais)) {
      if (is_string($classes_adicionais)) {
        $classes_extra = array_filter(array_map('trim', explode(' ', $classes_adicionais)));
      } elseif (is_array($classes_adicionais)) {
        $classes_extra = array_filter($classes_adicionais);
      }
    }

    // Combina todas as classes
    $todas_classes = array_merge($classes_base, $wp_classes, $classes_extra);

    // Remove duplicatas e valores vazios
    $todas_classes = array_unique(array_filter($todas_classes));

    // Retorna como string
    return implode(' ', $todas_classes);
  }

  /**
   * Obtém classes do body com contexto da página
   * Adiciona classes condicionais baseadas no tipo de página
   *
   * @param string|array $classes_adicionais Classes adicionais para incluir
   * @return string String com todas as classes aplicadas
   */
  public static function get_body_classes_with_context($classes_adicionais = '')
  {
    $classes_contextuais = [];

    // Classes baseadas no tipo de página
    if (is_front_page()) {
      $classes_contextuais[] = 'page-home';
    } elseif (is_single()) {
      $classes_contextuais[] = 'page-single';
      $classes_contextuais[] = 'post-type-' . get_post_type();
    } elseif (is_archive()) {
      $classes_contextuais[] = 'page-archive';
      $classes_contextuais[] = 'archive-' . get_post_type();
    } elseif (is_page()) {
      $classes_contextuais[] = 'page-static';
    } elseif (is_404()) {
      $classes_contextuais[] = 'page-error';
      $classes_contextuais[] = 'error-404';
    } elseif (is_search()) {
      $classes_contextuais[] = 'page-search';
    }

    // Classes baseadas no estado do usuário
    if (is_user_logged_in()) {
      $classes_contextuais[] = 'user-logged-in';
    } else {
      $classes_contextuais[] = 'user-logged-out';
    }

    // Classes baseadas no dispositivo (se necessário)
    if (wp_is_mobile()) {
      $classes_contextuais[] = 'device-mobile';
    } else {
      $classes_contextuais[] = 'device-desktop';
    }

    // Combina classes contextuais com as adicionais
    $todas_classes_adicionais = array_merge($classes_contextuais, (array) $classes_adicionais);

    // Chama a função principal
    return self::get_body_classes($todas_classes_adicionais);
  }
}

// ===================================================================
// [FUNÇÕES DE CONVENIÊNCIA]
// Funções globais para facilitar o uso dos helpers
// ===================================================================

/**
 * Função global para montar link WhatsApp
 */
function montar_link_whatsapp($numero_field = 'config_whatsapp_numero', $mensagem_field = 'config_whatsapp_mensagem')
{
  return ThemeHelpers::montar_link_whatsapp($numero_field, $mensagem_field);
}

/**
 * Função global para obter imagem de post
 */
function obter_imagem_post($post_id, $campo_acf = 'imagem', $tamanho = 'full', $imagem_padrao = null)
{
  return ThemeHelpers::obter_imagem_post($post_id, $campo_acf, $tamanho, $imagem_padrao);
}

/**
 * Função global para obter campo ACF
 */
function obter_campo_acf($campo, $post_id = null, $fallback = '')
{
  return ThemeHelpers::obter_campo_acf($campo, $post_id, $fallback);
}

/**
 * Função global para criar query
 */
function criar_query($post_type, $posts_per_page = 8, $args_extras = [])
{
  return ThemeHelpers::criar_query($post_type, $posts_per_page, $args_extras);
}

/**
 * Função global para obter redes sociais
 */
function obter_redes_sociais($networks_config = [])
{
  return ThemeHelpers::obter_redes_sociais($networks_config);
}

/**
 * Função global para renderizar paginação
 */
function renderizar_paginacao($query = null, $args = [])
{
  return ThemeHelpers::renderizar_paginacao($query, $args);
}

/**
 * Função global para verificar se deve exibir paginação
 */
function deve_exibir_paginacao($query = null)
{
  return ThemeHelpers::deve_exibir_paginacao($query);
}

/**
 * Função global para obter classes do body
 */
function obter_body_classes($classes_adicionais = '')
{
  return ThemeHelpers::get_body_classes($classes_adicionais);
}

/**
 * Função global para obter classes do body com contexto
 */
function obter_body_classes_com_contexto($classes_adicionais = '')
{
  return ThemeHelpers::get_body_classes_with_context($classes_adicionais);
}
