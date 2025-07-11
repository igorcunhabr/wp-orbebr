<?php

/**
 * Template para exibir o arquivo do post type personalizado "cases".
 */

// Define o título personalizado para o header interno
ThemeHelpers::definir_titulo_pagina(__('Cases', 'textdomain'));

get_header();

// ===================================================================
// [INICIALIZAÇÃO]
// Carregamento inicial e verificações de templates
// ===================================================================

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$cases_query = criar_query_otimizada('cases', null, [
    'paged'    => $paged,
    'orderby'    => 'menu_order',
    'order'      => 'ASC'
]);

// Verifica se o card de cases existe para evitar erro em tempo de execução
$card_template_path   = 'template-parts/content/card-cases.php';
$card_template_exists = locate_template($card_template_path);

// ===================================================================
// [INÍCIO DO HTML]
// Estrutura de apresentação da listagem dos cases
// ===================================================================
?>

<div class="lg:my-20 container my-10">
    <div class="gap-14 flex flex-col">
        <?php if ($cases_query->have_posts()) : ?>
            <?php while ($cases_query->have_posts()) : $cases_query->the_post(); ?>
                <?php if ($card_template_exists) : ?>
                    <?php get_template_part('template-parts/content/card', 'cases'); ?>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php else : ?>
            <div class="text-center py-10">
                <h2 class="text-2xl font-medium text-gray-600"><?php _e('Nenhum case encontrado', 'textdomain'); ?></h2>
                <p class="text-lg text-gray-500 mt-4"><?php _e('Não há cases publicados no momento.', 'textdomain'); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Paginação -->
    <?php
    // Renderiza o componente de paginação reutilizável
    renderizar_paginacao($cases_query);
    ?>
</div>

<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>