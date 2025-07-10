<?php

/**
 * Template para exibir o arquivo do post type personalizado "certificacoes".
 */

get_header();

// ===================================================================
// [INICIALIZAÇÃO]
// Carregamento inicial e verificações de templates
// ===================================================================

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$cert_query = criar_query_otimizada('certificacoes', 8, ['paged' => $paged]);

// Verifica se o card de certificação existe para evitar erro em tempo de execução
$card_template_path   = 'template-parts/content/card-certificacoes.php';
$card_template_exists = locate_template($card_template_path);

// ===================================================================
// [INÍCIO DO HTML]
// Estrutura de apresentação da listagem das certificações
// ===================================================================
?>

<div class="lg:my-20 container my-10">
    <div class="gap-9 flex flex-col w-full max-w-[1000px]">
        <?php if ($cert_query->have_posts()) : ?>
            <?php while ($cert_query->have_posts()) : $cert_query->the_post(); ?>

                <?php if ($card_template_exists) : ?>
                    <?php get_template_part('template-parts/content/card', 'certificacoes'); ?>
                <?php endif; ?>

            <?php endwhile; ?>

            <!-- Paginação -->
            <div class="md:justify-start flex justify-center w-full mt-10">
                <?php
                $pagination = paginate_links([
                    'prev_text' => '&laquo; Anterior',
                    'next_text' => 'Próximo &raquo;',
                    'type'      => 'array',
                    'class'     => 'pagination',
                    'total'     => $cert_query->max_num_pages,
                    'current'   => $paged
                ]);

                if ($pagination) : ?>
                    <nav class="pagination-wrapper" aria-label="Navegação de páginas">
                        <?php echo implode('', $pagination); ?>
                    </nav>
                <?php endif; ?>
            </div>

        <?php else : ?>
            <!-- Mensagem quando não há certificações -->
            <div class="text-center py-10">
                <h2 class="text-2xl font-medium text-gray-600 mb-4">Nenhuma certificação encontrada</h2>
                <p class="text-lg text-gray-500">Ainda não temos certificações publicadas.</p>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>