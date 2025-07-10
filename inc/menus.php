<?php

/**
 * Registro dos menus do tema.
 */

// ===================================================================
// [REGISTRO DE MENUS]
// Define e registra as localizações de menu do tema.
// ===================================================================
function meu_tema_registrar_menus()
{
  // Registra múltiplas localizações de menu de forma clara e centralizada.
  register_nav_menus([
    'nav-header' => __('Menu Principal', 'textdomain'),
    'nav-footer' => __('Menu Rodapé', 'textdomain'),
  ]);
}

// Adiciona a ação para registrar os menus no momento da inicialização do WordPress.
add_action('init', 'meu_tema_registrar_menus');
