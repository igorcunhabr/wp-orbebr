<?php

/**
 * Função para adicionar meta tags SEO dinâmicas no head do site
 * Baseado em campos ACF e informações padrão do WordPress.
 */

// ===================================================================
// [META TAGS SEO DINÂMICAS]
// Gera as meta tags SEO para Open Graph e Twitter Card, usando
// campos personalizados (ACF) para títulos, descrições e imagens.
// ===================================================================
function meu_tema_meta_tags_seo()
{
  global $post;

  // ===================================================================
  // [VALORES PADRÃO - ACF OPTIONS PAGE]
  // Obtém título, descrição e imagem padrão para SEO da página de opções ACF,
  // tratando os diferentes formatos possíveis para o campo de imagem.
  // ===================================================================
  $default_image = get_field('seo_padrao_imagem', 'option');
  $default_image_url = '';

  if ($default_image) {
    if (is_array($default_image) && !empty($default_image['url'])) {
      $default_image_url = $default_image['url'];
    } elseif (is_numeric($default_image)) {
      $default_image_url = wp_get_attachment_image_url($default_image, 'full');
    } elseif (is_string($default_image)) {
      $default_image_url = $default_image;
    }
  }

  $default_title = get_field('seo_padrao_titulo', 'option') ?: get_bloginfo('name');
  $default_description = get_field('seo_padrao_descricao', 'option') ?: get_bloginfo('description');

  // Inicializa as variáveis de SEO com valores padrão
  $title = $default_title;
  $description = $default_description;
  $image = $default_image_url;
  $url = home_url();
  $site_name = get_bloginfo('name');

  // ===================================================================
  // [CONDIÇÕES PARA PÁGINAS ESPECÍFICAS]
  // Define os valores de SEO conforme o tipo da página sendo exibida:
  // - Página singular (post, página, CPT)
  // - Página inicial
  // - Arquivos (categoria, tag, taxonomia)
  // - Autor
  // - Página de busca
  // - Página 404
  // ===================================================================
  if (is_singular()) {
    // Busca campos SEO específicos do post
    $seo_title = get_field('seo_titulo', $post->ID);
    $seo_description = get_field('seo_descricao', $post->ID);
    $seo_image = get_field('seo_imagem', $post->ID);

    $title = $seo_title ?: get_the_title($post) ?: $default_title;
    $description = $seo_description ?: get_the_excerpt($post) ?: wp_trim_words(strip_tags($post->post_content), 25, '...') ?: $default_description;
    $url = get_permalink($post);

    // Tratamento da imagem SEO do post
    if ($seo_image) {
      if (is_array($seo_image) && !empty($seo_image['url'])) {
        $image = $seo_image['url'];
      } elseif (is_numeric($seo_image)) {
        $image = wp_get_attachment_image_url($seo_image, 'full');
      } elseif (is_string($seo_image)) {
        $image = $seo_image;
      }
    } else {
      // Usa imagem destacada do post ou fallback para imagem padrão
      $thumb_url = get_the_post_thumbnail_url($post, 'full');
      $image = $thumb_url ?: $default_image_url;
    }
  } elseif (is_front_page()) {
    $title = $default_title;
    $description = $default_description;
    $url = home_url();
  } elseif (is_category() || is_tag() || is_tax()) {
    $term = get_queried_object();
    $title = single_term_title('', false);
    $description = term_description($term) ?: $default_description;
    $url = get_term_link($term);
  } elseif (is_author()) {
    $author = get_queried_object();
    $title = 'Artigos de ' . $author->display_name;
    $description = get_the_author_meta('description', $author->ID) ?: $default_description;
    $url = get_author_posts_url($author->ID);
  } elseif (is_search()) {
    $title = 'Resultados da busca por: ' . get_search_query();
    $description = 'Veja os resultados da busca para "' . get_search_query() . '"';
    $url = get_search_link();
  } elseif (is_404()) {
    $title = 'Página não encontrada';
    $description = 'A página que você tentou acessar não existe.';
    $url = home_url('/404');
  }

  // ===================================================================
  // [SAÍDA DAS META TAGS NO HEAD]
  // Exibe as meta tags SEO para descrição, Open Graph e Twitter Card
  // ===================================================================
  echo "<meta name=\"description\" content=\"" . esc_attr($description) . "\">\n";
  echo "<meta property=\"og:title\" content=\"" . esc_attr($title) . "\">\n";
  echo "<meta property=\"og:description\" content=\"" . esc_attr($description) . "\">\n";
  echo "<meta property=\"og:url\" content=\"" . esc_url($url) . "\">\n";
  echo "<meta property=\"og:site_name\" content=\"" . esc_attr($site_name) . "\">\n";
  echo "<meta property=\"og:type\" content=\"website\">\n";

  if ($image) {
    echo "<meta property=\"og:image\" content=\"" . esc_url($image) . "\">\n";
  }

  echo "<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
  echo "<meta name=\"twitter:title\" content=\"" . esc_attr($title) . "\">\n";
  echo "<meta name=\"twitter:description\" content=\"" . esc_attr($description) . "\">\n";

  if ($image) {
    echo "<meta name=\"twitter:image\" content=\"" . esc_url($image) . "\">\n";
  }
}

// Registra a função no hook wp_head para inserir as meta tags no head do tema
add_action('wp_head', 'meu_tema_meta_tags_seo');
