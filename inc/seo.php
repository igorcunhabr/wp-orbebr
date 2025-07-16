<?php
// eslint-disable-next-line
// Este arquivo depende de funções globais do WordPress como site_url() e home_url().

/**
 * Template Part para funcionalidades SEO do tema.
 */

// ===================================================================
// [CLASSE PARA GERENCIAMENTO SEO]
// Centraliza todas as funcionalidades SEO do tema
// ===================================================================

class ThemeSEO
{

  /**
   * Configurações padrão de SEO
   */
  private static $default_seo = [
    'title' => '',
    'description' => '',
    'image' => '',
    'url' => '',
    'site_name' => '',
  ];

  /**
   * Gera meta tags SEO para a página atual
   */
  public static function gerar_meta_tags()
  {
    $seo_data = self::obter_dados_seo();
    self::exibir_meta_tags($seo_data);
  }

  /**
   * Obtém dados SEO para a página atual
   *
   * @return array Dados SEO
   */
  private static function obter_dados_seo()
  {
    $seo_data = self::$default_seo;

    // Obtém dados padrão das opções do tema
    $seo_data = self::obter_dados_padrao($seo_data);

    // Aplica dados específicos da página
    $seo_data = self::aplicar_dados_especificos($seo_data);

    return $seo_data;
  }

  /**
   * Obtém dados padrão das opções do tema
   *
   * @param array $seo_data Dados SEO atuais
   * @return array Dados SEO atualizados
   */
  private static function obter_dados_padrao($seo_data)
  {
    $default_image = self::obter_campo_acf('seo_padrao_imagem', 'option');
    $default_image_url = self::processar_imagem_acf($default_image);

    // Fallback absoluto se não houver imagem padrão no ACF
    if (empty($default_image_url)) {
      $default_image_url = (function_exists('site_url') ? site_url() : home_url()) . '/assets/img/default.png';
    }

    $seo_data['title'] = self::obter_campo_acf('seo_padrao_titulo', 'option') ?: get_bloginfo('name');
    $seo_data['description'] = self::obter_campo_acf('seo_padrao_descricao', 'option') ?: get_bloginfo('description');
    $seo_data['image'] = $default_image_url;
    $seo_data['url'] = home_url();
    $seo_data['site_name'] = get_bloginfo('name');

    return $seo_data;
  }

  /**
   * Aplica dados específicos da página atual
   *
   * @param array $seo_data Dados SEO atuais
   * @return array Dados SEO atualizados
   */
  private static function aplicar_dados_especificos($seo_data)
  {
    if (is_singular()) {
      return self::aplicar_dados_singular($seo_data);
    } elseif (is_front_page()) {
      return self::aplicar_dados_home($seo_data);
    } elseif (is_category() || is_tag() || is_tax()) {
      return self::aplicar_dados_taxonomia($seo_data);
    } elseif (is_author()) {
      return self::aplicar_dados_autor($seo_data);
    } elseif (is_search()) {
      return self::aplicar_dados_busca($seo_data);
    } elseif (is_404()) {
      return self::aplicar_dados_404($seo_data);
    }

    return $seo_data;
  }

  /**
   * Aplica dados para páginas singulares
   *
   * @param array $seo_data Dados SEO atuais
   * @return array Dados SEO atualizados
   */
  private static function aplicar_dados_singular($seo_data)
  {
    global $post;

    $seo_title = self::obter_campo_acf('seo_titulo', $post->ID);
    $seo_description = self::obter_campo_acf('seo_descricao', $post->ID);
    $seo_image = self::obter_campo_acf('seo_imagem', $post->ID);

    $seo_data['title'] = $seo_title ?: get_the_title($post) ?: $seo_data['title'];
    $seo_data['description'] = $seo_description ?: self::gerar_descricao_automatica($post) ?: $seo_data['description'];
    $seo_data['url'] = get_permalink($post);

    // Processa imagem SEO
    if ($seo_image) {
      $img = self::processar_imagem_acf($seo_image);
      if (!empty($img)) {
        $seo_data['image'] = $img;
      }
    } else {
      $thumb_url = get_the_post_thumbnail_url($post, 'full');
      if (!empty($thumb_url)) {
        $seo_data['image'] = $thumb_url;
      }
    }

    // Fallback absoluto se ainda não houver imagem
    if (empty($seo_data['image'])) {
      $seo_data['image'] = (function_exists('site_url') ? site_url() : home_url()) . '/assets/img/default.png';
    }

    return $seo_data;
  }

  /**
   * Aplica dados para página inicial
   *
   * @param array $seo_data Dados SEO atuais
   * @return array Dados SEO atualizados
   */
  private static function aplicar_dados_home($seo_data)
  {
    // Mantém dados padrão para página inicial
    return $seo_data;
  }

  /**
   * Aplica dados para páginas de taxonomia
   *
   * @param array $seo_data Dados SEO atuais
   * @return array Dados SEO atualizados
   */
  private static function aplicar_dados_taxonomia($seo_data)
  {
    $term = get_queried_object();

    $seo_data['title'] = single_term_title('', false);
    $seo_data['description'] = term_description($term) ?: $seo_data['description'];
    $seo_data['url'] = get_term_link($term);

    return $seo_data;
  }

  /**
   * Aplica dados para páginas de autor
   *
   * @param array $seo_data Dados SEO atuais
   * @return array Dados SEO atualizados
   */
  private static function aplicar_dados_autor($seo_data)
  {
    $author = get_queried_object();

    $seo_data['title'] = 'Artigos de ' . $author->display_name;
    $seo_data['description'] = get_the_author_meta('description', $author->ID) ?: $seo_data['description'];
    $seo_data['url'] = get_author_posts_url($author->ID);

    return $seo_data;
  }

  /**
   * Aplica dados para páginas de busca
   *
   * @param array $seo_data Dados SEO atuais
   * @return array Dados SEO atualizados
   */
  private static function aplicar_dados_busca($seo_data)
  {
    $search_query = get_search_query();

    $seo_data['title'] = 'Resultados da busca por: ' . $search_query;
    $seo_data['description'] = 'Veja os resultados da busca para "' . $search_query . '"';
    $seo_data['url'] = get_search_link();

    return $seo_data;
  }

  /**
   * Aplica dados para página 404
   *
   * @param array $seo_data Dados SEO atuais
   * @return array Dados SEO atualizados
   */
  private static function aplicar_dados_404($seo_data)
  {
    $seo_data['title'] = 'Página não encontrada';
    $seo_data['description'] = 'A página que você tentou acessar não existe.';
    $seo_data['url'] = home_url('/404');

    return $seo_data;
  }

  /**
   * Processa imagem do ACF
   *
   * @param mixed $acf_image Dados da imagem do ACF
   * @return string URL da imagem ou string vazia
   */
  private static function processar_imagem_acf($acf_image)
  {
    if (!$acf_image) {
      return '';
    }

    if (is_array($acf_image) && !empty($acf_image['url'])) {
      return $acf_image['url'];
    } elseif (is_numeric($acf_image)) {
      return wp_get_attachment_image_url($acf_image, 'full');
    } elseif (is_string($acf_image)) {
      return $acf_image;
    }

    return '';
  }

  /**
   * Gera descrição automática para posts
   *
   * @param WP_Post $post Objeto do post
   * @return string Descrição gerada
   */
  private static function gerar_descricao_automatica($post)
  {
    $excerpt = get_the_excerpt($post);
    if (!empty($excerpt)) {
      return $excerpt;
    }

    $content = strip_tags($post->post_content);
    return wp_trim_words($content, 25, '...');
  }

  /**
   * Obtém campo ACF com fallback
   *
   * @param string $campo Nome do campo
   * @param mixed  $post_id ID do post ou 'option'
   * @return mixed Valor do campo
   */
  private static function obter_campo_acf($campo, $post_id = null)
  {
    if (!function_exists('get_field')) {
      return '';
    }

    return get_field($campo, $post_id);
  }

  /**
   * Exibe as meta tags SEO
   *
   * @param array $seo_data Dados SEO
   */
  private static function exibir_meta_tags($seo_data)
  {
    // Meta description
    echo "<meta name=\"description\" content=\"" . esc_attr($seo_data['description']) . "\">\n";

    // Open Graph
    echo "<meta property=\"og:title\" content=\"" . esc_attr($seo_data['title']) . "\">\n";
    echo "<meta property=\"og:description\" content=\"" . esc_attr($seo_data['description']) . "\">\n";
    echo "<meta property=\"og:url\" content=\"" . esc_url($seo_data['url']) . "\">\n";
    echo "<meta property=\"og:site_name\" content=\"" . esc_attr($seo_data['site_name']) . "\">\n";
    echo "<meta property=\"og:type\" content=\"website\">\n";

    // Sempre exibe og:image, nunca vazio
    $base_url = function_exists('site_url') ? site_url() : home_url();
    $og_image = !empty($seo_data['image']) ? esc_url($seo_data['image']) : esc_url($base_url . '/assets/img/default.png');
    echo "<meta property=\"og:image\" content=\"$og_image\">\n";

    // Twitter Card
    echo "<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
    echo "<meta name=\"twitter:title\" content=\"" . esc_attr($seo_data['title']) . "\">\n";
    echo "<meta name=\"twitter:description\" content=\"" . esc_attr($seo_data['description']) . "\">\n";
    echo "<meta name=\"twitter:image\" content=\"$og_image\">\n";
  }
}

// ===================================================================
// [REGISTRO DO HOOK]
// Registra a função no wp_head
// ===================================================================

add_action('wp_head', [ThemeSEO::class, 'gerar_meta_tags']);

// ===================================================================
// [FUNÇÕES DE CONVENIÊNCIA]
// Funções globais para facilitar o uso do SEO
// ===================================================================

/**
 * Gera meta tags SEO manualmente
 */
function gerar_meta_tags_seo()
{
  ThemeSEO::gerar_meta_tags();
}
