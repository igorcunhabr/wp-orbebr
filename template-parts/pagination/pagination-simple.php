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
    <nav class="flex justify-center items-center" aria-label="<?php esc_attr_e('Navegação de páginas', 'textdomain'); ?>">
        <div class="flex items-center justify-center space-x-1 md:space-x-2">
            <?php
            // Botão Anterior
            if ($current_page > 1) : ?>
                <a href="<?php echo esc_url(get_pagenum_link($current_page - 1)); ?>"
                    class="flex items-center justify-center px-3 py-2 md:px-4 md:py-2 text-sm md:text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                    <svg class="w-4 h-4 mr-1 md:mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="hidden sm:inline"><?php _e('Anterior', 'textdomain'); ?></span>
                </a>
            <?php endif; ?>

            <?php
            // Números das páginas
            $start_page = max(1, $current_page - 2);
            $end_page = min($total_pages, $current_page + 2);

            // Ajusta o range para mostrar sempre 5 páginas quando possível
            if ($end_page - $start_page < 4) {
                if ($start_page == 1) {
                    $end_page = min($total_pages, $start_page + 4);
                } else {
                    $start_page = max(1, $end_page - 4);
                }
            }

            // Primeira página e reticências
            if ($start_page > 1) : ?>
                <a href="<?php echo esc_url(get_pagenum_link(1)); ?>"
                    class="flex items-center justify-center px-3 py-2 md:px-4 md:py-2 text-sm md:text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                    1
                </a>
                <?php if ($start_page > 2) : ?>
                    <span class="flex items-center justify-center px-2 py-2 text-sm md:text-base text-gray-400">
                        ...
                    </span>
                <?php endif; ?>
            <?php endif; ?>

            <?php
            // Páginas do meio
            for ($i = $start_page; $i <= $end_page; $i++) : ?>
                <?php if ($i == $current_page) : ?>
                    <span class="flex items-center justify-center px-3 py-2 md:px-4 md:py-2 text-sm md:text-base font-medium text-white bg-amber-500 border border-amber-500 rounded-lg cursor-default">
                        <?php echo $i; ?>
                    </span>
                <?php else : ?>
                    <a href="<?php echo esc_url(get_pagenum_link($i)); ?>"
                        class="flex items-center justify-center px-3 py-2 md:px-4 md:py-2 text-sm md:text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        <?php echo $i; ?>
                    </a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php
            // Última página e reticências
            if ($end_page < $total_pages) : ?>
                <?php if ($end_page < $total_pages - 1) : ?>
                    <span class="flex items-center justify-center px-2 py-2 text-sm md:text-base text-gray-400">
                        ...
                    </span>
                <?php endif; ?>
                <a href="<?php echo esc_url(get_pagenum_link($total_pages)); ?>"
                    class="flex items-center justify-center px-3 py-2 md:px-4 md:py-2 text-sm md:text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                    <?php echo $total_pages; ?>
                </a>
            <?php endif; ?>

            <?php
            // Botão Próximo
            if ($current_page < $total_pages) : ?>
                <a href="<?php echo esc_url(get_pagenum_link($current_page + 1)); ?>"
                    class="flex items-center justify-center px-3 py-2 md:px-4 md:py-2 text-sm md:text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                    <span class="hidden sm:inline"><?php _e('Próximo', 'textdomain'); ?></span>
                    <svg class="w-4 h-4 ml-1 md:ml-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            <?php endif; ?>
        </div>
    </nav>
</div>

<?php
// Debug apenas para administradores
if (current_user_can('administrator') && defined('WP_DEBUG') && WP_DEBUG) {
    echo '<!-- Debug: Total de páginas: ' . $total_pages . ', Página atual: ' . $current_page . ' -->';
}
?>