<?php

/**
 * Gerenciamento do suporte aos editores no WordPress.
 */

// ===================================================================
// [REMOVER SUPORTE AO EDITOR]
// Remove o editor clássico ou de blocos de tipos de post específicos.
// ===================================================================
/**
 * Remove o suporte ao editor no post type 'page', por exemplo, para uso exclusivo de ACF.
 */
function meu_tema_gerenciar_suporte_editores()
{
  // Remove o editor para o tipo de post 'page'.
  remove_post_type_support('page', 'editor');

  // ===================================================================
  // [DEFINIÇÃO DO EDITOR CLÁSSICO]
  // Define quais tipos de post usarão o editor clássico, desabilitando o Gutenberg para eles.
  // ===================================================================
  $post_types_com_editor_classico = [
    // 'post',      // Descomente para usar o Editor Clássico em Posts.
    // 'blogs',     // Descomente para usar o Editor Clássico em Blogs.
    // 'livros',    // Descomente para usar o Editor Clássico em Livros.
    // 'comunidades'// Descomente para usar o Editor Clássico em Comunidades.
  ];

  // Se não houver tipos definidos, encerra a função.
  if (empty($post_types_com_editor_classico)) {
    return;
  }

  // Adiciona filtro para desabilitar o editor de blocos apenas nos tipos de post definidos.
  add_filter('use_block_editor_for_post_type', function ($is_enabled, $post_type) use ($post_types_com_editor_classico) {
    if (in_array($post_type, $post_types_com_editor_classico, true)) {
      return false; // Desativa Gutenberg para o tipo de post.
    }
    return $is_enabled; // Mantém o comportamento padrão para os demais.
  }, 10, 2);
}
add_action('init', 'meu_tema_gerenciar_suporte_editores', 99);
