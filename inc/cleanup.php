<?php

/**
 * Template Part para funções e configurações iniciais do tema.
 */

// ===================================================================
// [CONFIGURAÇÃO INICIAL DO TEMA]
// Configurações básicas, limpeza do <head> e ajustes gerais
// ===================================================================

/**
 * Executa a configuração inicial do tema e adiciona/remove hooks do WordPress.
 */
function meu_tema_setup_and_cleanup()
{

  // -----------------------------------------------------------------
  // [LIMPEZA DO <HEAD>]
  // Remove tags e links desnecessários do cabeçalho gerado pelo WP
  // -----------------------------------------------------------------

  // Remove a tag do gerador do WordPress.
  remove_action('wp_head', 'wp_generator');

  // Remove links para clientes de blog obsoletos.
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'rsd_link');

  // Remove links relacionais para posts (start, prev, next).
  remove_action('wp_head', 'start_post_rel_link', 10, 0);
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

  // Remove links extras de feed RSS.
  remove_action('wp_head', 'feed_links_extra', 3);

  // -----------------------------------------------------------------
  // [REMOÇÃO DO SUPORTE A EMOJIS]
  // Remove scripts e estilos relacionados a emojis para otimizar
  // -----------------------------------------------------------------

  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action('admin_print_styles', 'print_emoji_styles');

  // -----------------------------------------------------------------
  // [GERENCIAMENTO DA BARRA DE ADMINISTRAÇÃO]
  // Desativa a barra para todos os usuários.
  // Caso queira desativar apenas para usuários sem permissão, usar o código comentado.
  // -----------------------------------------------------------------

  // Exemplo para desativar para todos exceto administradores:
  // if (! current_user_can('manage_options')) {
  //   add_filter('show_admin_bar', '__return_false');
  // }

  // Desativa para todos (ativa sempre)
  add_filter('show_admin_bar', '__return_false');
}
add_action('after_setup_theme', 'meu_tema_setup_and_cleanup');

/**
 * Carrega o textdomain para internacionalização do tema.
 */
function meu_tema_carregar_textdomain()
{
  load_theme_textdomain('textdomain', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'meu_tema_carregar_textdomain');
