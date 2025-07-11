<?php

/**
 * Ajustes e integrações de plugins de terceiros
 * Centraliza hooks, filtros e funções específicas de plugins externos
 */

// ===================================================================
// [CONTACT FORM 7] - Ajuste para remover <p> automático
// ===================================================================
add_filter('wpcf7_autop_or_not', '__return_false');
require_once __DIR__ . '/wpcf7-to-contatos.php';
