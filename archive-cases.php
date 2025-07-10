<?php

/**
 * Template para exibir o arquivo do post type personalizado "cases".
 */

// Define o título personalizado para o header interno
ThemeHelpers::definir_titulo_pagina('Cases');

get_header();

// ===================================================================
// [INICIALIZAÇÃO]
// Carregamento inicial e verificações de templates
// ===================================================================

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$cases_query = criar_query_otimizada('cases', 8, ['paged' => $paged]);

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
                <h2 class="text-2xl font-medium text-gray-600">Nenhum case encontrado</h2>
                <p class="text-lg text-gray-500 mt-4">Não há cases publicados no momento.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Paginação -->
    <?php if ($cases_query->max_num_pages > 1) : ?>
        <div class="md:justify-start flex justify-center w-full mt-10">
            <div class="flex gap-4">
                <?php if ($cases_query->get('paged') > 1) : ?>
                    <a href="<?php echo esc_url(get_pagenum_link($cases_query->get('paged') - 1)); ?>"
                        class="px-6 py-3 bg-gray-200 hover:bg-gray-300 transition-all rounded-[10px] text-slate-950 text-lg font-normal">
                        Anterior
                    </a>
                <?php endif; ?>

                <?php if ($cases_query->get('paged') < $cases_query->max_num_pages) : ?>
                    <a href="<?php echo esc_url(get_pagenum_link($cases_query->get('paged') + 1)); ?>"
                        class="px-6 py-3 bg-amber-400 hover:bg-amber-500 transition-all rounded-[10px] text-slate-950 text-lg font-normal">
                        Próxima
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>