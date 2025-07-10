<?php

/**
 * Template Part para opções do tema via ACF.
 */

// ===================================================================
// [REGISTRO DE PÁGINA DE CONFIGURAÇÕES]
// Cria uma página de opções no admin para configurações gerais do site
// ===================================================================

if (function_exists('acf_add_options_page')) {
  acf_add_options_page([
    'page_title' => 'Configurações Gerais do Site',
    'menu_title' => 'Configurações do Site',
    'menu_slug'  => 'theme-general-settings',
    'capability' => 'edit_posts',
    'icon_url'   => 'dashicons-admin-tools',
    'redirect'   => false,
  ]);
}
