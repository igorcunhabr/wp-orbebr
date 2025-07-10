<?php

/**
 * Componente de Paginação Reutilizável
 * 
 * Este template pode ser incluído em qualquer página que precise de paginação.
 * 
 * @param WP_Query $query Objeto da query (opcional, usa query principal se não fornecido)
 * @param array $args Argumentos personalizados para a paginação
 */

// ===================================================================
// [CONFIGURAÇÃO]
// ===================================================================

// Se não foi passada uma query, usa a query principal
if (!isset($query) || !$query instanceof WP_Query) {
    global $wp_query;
    $query = $wp_query;
}

// Configurações padrão
$default_args = [
    'prev_text' => __('&laquo; Anterior', 'textdomain'),
    'next_text' => __('Próximo &raquo;', 'textdomain'),
    'type'      => 'array',
    'class'     => 'pagination',
    'show_all'  => false,
    'end_size'  => 1,
    'mid_size'  => 2,
    'add_args'  => [],
    'add_fragment' => '',
    'before_page_number' => '',
    'after_page_number'  => '',
];

// Mescla argumentos personalizados com os padrões
$pagination_args = isset($args) ? array_merge($default_args, $args) : $default_args;

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

// Gera os links de paginação
$pagination_links = paginate_links(array_merge($pagination_args, [
    'total'   => $total_pages,
    'current' => $current_page,
    'base'    => get_pagenum_link(1) . '%_%',
    'format'  => '?paged=%#%'
]));

// Se não há links, não exibe nada
if (!$pagination_links) {
    return;
}

?>

<div class="w-full mt-10">
    <nav class="flex justify-center" aria-label="<?php esc_attr_e('Navegação de páginas', 'textdomain'); ?>">
        <ul class="flex space-x-2">
            <?php foreach ($pagination_links as $link) : ?>
                <li><?php echo $link; ?></li>
            <?php endforeach; ?>
        </ul>
    </nav>
</div>

<?php
// ===================================================================
// [DEBUG (APENAS PARA ADMINISTRADORES)]
// ===================================================================

if (current_user_can('administrator') && defined('WP_DEBUG') && WP_DEBUG) {
    echo '<!-- Debug Paginação: Total de páginas: ' . $total_pages . ', Página atual: ' . $current_page . ' -->';
}
?>