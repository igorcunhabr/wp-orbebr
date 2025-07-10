<?php

// ===================================================================
// [SEGURANÇA]
// Previne acesso direto aos arquivos PHP.
// ===================================================================
if (!defined('ABSPATH')) {
  exit;
}

// ===================================================================
// [INCLUSÃO DE ARQUIVOS]
// Carrega os arquivos essenciais do tema para funcionalidades específicas.
// ===================================================================
require_once get_template_directory() . '/inc/config.php';
require_once get_template_directory() . '/inc/cleanup.php';
require_once get_template_directory() . '/inc/menus.php';
require_once get_template_directory() . '/inc/editor.php';
require_once get_template_directory() . '/inc/custom-post-types.php';
require_once get_template_directory() . '/inc/acf-options.php';
require_once get_template_directory() . '/inc/assets.php';
require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/seo.php';
require_once get_template_directory() . '/inc/queries.php';
require_once get_template_directory() . '/inc/uploads.php';
