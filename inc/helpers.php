<?php

/**
 * Funções do tema.
 */

// ===================================================================
// [MONTAGEM DO LINK WHATSAPP]
// Monta um link click-to-chat do WhatsApp de forma segura e robusta.
// ===================================================================

/**
 * Monta um link "click-to-chat" do WhatsApp usando número e mensagem do ACF.
 *
 * Busca os dados nas opções do tema, sanitiza o número e monta a URL.
 *
 * @return string URL completa do WhatsApp ou string vazia se número não definido.
 */
function montar_link_whatsapp()
{
  // --- Passo 1: Obtém o número bruto do campo ACF ---
  $numero_raw = get_field('config_whatsapp_numero', 'option');

  // --- Passo 2: Verifica se o número foi fornecido ---
  if (empty($numero_raw)) {
    return '';
  }

  // --- Passo 3: Sanitiza o número para conter apenas dígitos ---
  // Exemplo: "+55 (82) 99999-9999" vira "5582999999999"
  $numero_sanitizado = preg_replace('/[^0-9]/', '', $numero_raw);

  // --- Passo 4: Prepara os parâmetros da query ---
  $query_args = [
    'phone' => $numero_sanitizado,
  ];

  // --- Passo 5: Adiciona a mensagem, se houver ---
  $mensagem = get_field('config_whatsapp_mensagem', 'option');
  if (!empty($mensagem)) {
    $query_args['text'] = $mensagem;
  }

  // --- Passo 6: Monta a URL final usando add_query_arg (WordPress) ---
  $base_url = 'https://api.whatsapp.com/send';
  $final_url = add_query_arg($query_args, $base_url);

  // --- Passo 7: Escapa a URL para segurança e retorna ---
  return esc_url($final_url);
}

// ===================================================================
// [FUNÇÕES AUXILIARES PARA CONTEÚDO]
// Funções reutilizáveis para manipulação de posts e campos ACF
// ===================================================================

/**
 * Obtém imagem de post com fallback inteligente
 * 
 * Tenta obter imagem na seguinte ordem:
 * 1. Featured image (imagem em destaque)
 * 2. Campo ACF especificado
 * 3. Imagem padrão fornecida
 *
 * @param int    $post_id       ID do post
 * @param string $campo_acf     Nome do campo ACF (padrão: 'imagem')
 * @param string $tamanho       Tamanho da imagem (padrão: 'full')
 * @param string $imagem_padrao URL da imagem padrão (opcional)
 * @return string URL da imagem ou string vazia
 */
function obter_imagem_post($post_id, $campo_acf = 'imagem', $tamanho = 'full', $imagem_padrao = null)
{
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
 * @param string $fallback Valor padrão se campo não existir
 * @return mixed Valor do campo ou fallback
 */
function obter_campo_acf($campo, $post_id = null, $fallback = '')
{
  if (!function_exists('get_field')) {
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
function criar_query($post_type, $posts_per_page = 8, $args_extras = [])
{
  $args_padrao = [
    'post_type'      => $post_type,
    'posts_per_page' => $posts_per_page,
    'post_status'    => 'publish',
    'no_found_rows'  => true,
    'orderby'        => 'menu_order title',
    'order'          => 'ASC',
  ];

  return new WP_Query(array_merge($args_padrao, $args_extras));
}
