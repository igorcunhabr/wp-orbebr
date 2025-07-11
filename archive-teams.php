<?php

/**
 * Template para exibir o arquivo do post type personalizado "teams".
 */

// Define o título personalizado para o header interno
ThemeHelpers::definir_titulo_pagina(__('Trabalhe com a gente', 'textdomain'));

get_header();

// ===================================================================
// [INICIALIZAÇÃO]
// Carregamento inicial e verificações de templates
// ===================================================================

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$teams_query = criar_query_otimizada('teams', null, ['paged' => $paged]);

// Verifica se o card de team existe para evitar erro em tempo de execução
$card_template_path   = 'template-parts/content/card-team.php';
$card_template_exists = locate_template($card_template_path);

// ===================================================================
// [INÍCIO DO HTML]
// Estrutura de apresentação da listagem do time
// ===================================================================
?>

<div class="lg:my-20 container my-10">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <?php if ($teams_query->have_posts()) : ?>
            <?php while ($teams_query->have_posts()) : $teams_query->the_post(); ?>
                <?php if ($card_template_exists) : ?>
                    <?php get_template_part('template-parts/content/card-team'); ?>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php else : ?>
            <!-- Mensagem quando não há posts -->
            <div class="col-span-full flex flex-col items-center justify-center py-16">
                <span class="text-5xl font-extrabold text-[#FFD530] mb-4"><?php _e('Ooops...', 'textdomain'); ?></span>
                <p class="text-lg text-gray-700 font-medium mb-2"><?php _e('Nenhum membro do time encontrado.', 'textdomain'); ?></p>
                <p class="text-base text-gray-500"><?php _e('Assim que tivermos novidades, você verá nosso time incrível por aqui!', 'textdomain'); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Paginação -->
    <?php
    // Renderiza o componente de paginação reutilizável
    renderizar_paginacao($teams_query);
    ?>

    <div class="w-full mt-16">
        <div class="max-w-[900px] bg-black rounded-[20px] p-10 m-auto">
            <div class="mb-5 text-center">
                <span class="text-slate-200 text-base font-normal"><?php _e('QUER FAZER PARTE DA EQUIPE?', 'textdomain'); ?></span>
                <h3 class="text-amber-400 text-3xl font-bold text-center"><?php _e('MANDA UMA MENSAGEM', 'textdomain'); ?></h3>
            </div>

            <?php echo do_shortcode('[contact-form-7 id="af58837" title="Trabalhe Conb"]'); ?>
        </div>
    </div>
</div>

<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>