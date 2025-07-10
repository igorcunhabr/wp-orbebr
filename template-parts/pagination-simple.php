<?php

/**
 * Componente de Paginação Simples e Reutilizável
 * 
 * Uso:
 * - get_template_part('template-parts/pagination', 'simple');
 * - get_template_part('template-parts/pagination', 'simple', ['query' => $minha_query]);
 */

// ===================================================================
// [CONFIGURAÇÃO]
// ===================================================================

// Se não foi passada uma query, usa a query principal
if (!isset($args['query']) || !$args['query'] instanceof WP_Query) {
    global $wp_query;
    $query = $wp_query;
} else {
    $query = $args['query'];
}

// Obtém informações da paginação
$total_pages = $query->max_num_pages;
$current_page = get_query_var('paged') ?: 1;

// ===================================================================
// [VERIFICAÇÃO]
// Só exibe se há mais de uma página
// ===================================================================

if ($total_pages <= 1) {
    return;
}

// ===================================================================
// [RENDERIZAÇÃO]
// ===================================================================

?>

<div class="w-full mt-10">
    <nav class="flex justify-center" aria-label="<?php esc_attr_e('Navegação de páginas', 'textdomain'); ?>">
        <?php
        echo paginate_links([
            'prev_text' => __('&laquo; Anterior', 'textdomain'),
            'next_text' => __('Próximo &raquo;', 'textdomain'),
            'type'      => 'list',
            'total'     => $total_pages,
            'current'   => $current_page,
            'base'      => get_pagenum_link(1) . '%_%',
            'format'    => '?paged=%#%'
        ]);
        ?>
    </nav>
</div>

<?php
// Debug apenas para administradores
if (current_user_can('administrator') && defined('WP_DEBUG') && WP_DEBUG) {
    echo '<!-- Debug: Total de páginas: ' . $total_pages . ', Página atual: ' . $current_page . ' -->';
}
?>