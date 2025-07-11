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
$teams_query = criar_query_otimizada('teams', 10, ['paged' => $paged]);

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
                <?php else : ?>
                    <!-- Fallback caso o template não exista -->
                    <article id="team-item-<?php the_ID(); ?>" class="team-item">
                        <?php if (get_field('imagem')) : ?>
                            <img class="w-full h-[260px] rounded-[20px] object-cover mb-3"
                                src="<?php echo esc_url(get_field('imagem')['url']); ?>"
                                alt="<?php echo esc_attr(get_field('imagem')['alt'] ?? get_the_title()); ?>"
                                loading="lazy"
                                decoding="async" />
                        <?php endif; ?>

                        <div class="flex flex-col gap-5">
                            <div class="md:text-start flex flex-col gap-2 text-center">
                                <div>
                                    <h2 class="text-black text-[28px] font-medium"><?php the_title(); ?></h2>
                                    <?php if (get_field('cargo')) : ?>
                                        <p class="text-base font-normal text-black"><?php echo esc_html(get_field('cargo')); ?></p>
                                    <?php endif; ?>
                                </div>
                                <span class="w-[100px] h-1 bg-amber-400 m-auto md:m-0"></span>
                            </div>

                            <?php if (get_field('descricao')) : ?>
                                <div class="w-full md:max-w-[477px] text-lg font-normal text-black text-center md:text-start">
                                    <div class="htmlchars">
                                        <?php echo wp_kses_post(get_field('descricao')); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php else : ?>
            <div class="col-span-full text-center py-10">
                <p class="text-gray-500 text-lg"><?php _e('Nenhum membro do time encontrado.', 'textdomain'); ?></p>
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