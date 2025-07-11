<?php
if (!defined('ABSPATH')) exit;

/**
 * Template para exibir o arquivo do post type personalizado "certificacoes".
 */

get_header();

// ===================================================================
// [INICIALIZAÇÃO]
// Carregamento inicial e verificações de templates
// ===================================================================

$paged = get_query_var('paged') ?: 1;
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
        <?php else : ?>
            <!-- Mensagem quando não há posts -->
            <div class="col-span-full flex flex-col items-center justify-center py-16">
                <span class="text-5xl font-extrabold text-[#FFD530] mb-4"><?php _e('Ooops...', 'textdomain'); ?></span>
                <p class="text-lg text-gray-700 font-medium mb-2"><?php _e('Nenhuma certificação encontrada.', 'textdomain'); ?></p>
                <p class="text-base text-gray-500"><?php _e('Assim que tivermos novidades, você verá nossas certificações incríveis por aqui!', 'textdomain'); ?></p>
            </div>
        <?php endif; ?>

        <!-- Paginação -->
        <?php
        // Renderiza o componente de paginação reutilizável
        renderizar_paginacao($cert_query);
        ?>

    </div>
</div>

<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>