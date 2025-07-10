<?php

/**
 * Template para exibir o arquivo do post type personalizado "clientes".
 */

// ===================================================================
// [SEGURANÇA]
// Previne acesso direto ao arquivo
// ===================================================================
if (!defined('ABSPATH')) {
    exit;
}

get_header();

// ===================================================================
// [INICIALIZAÇÃO]
// Carregamento inicial e verificações de templates
// ===================================================================

$paged = get_query_var('paged') ? get_query_var('paged') : 1;

// Verifica se o post type 'clientes' está registrado
if (!post_type_exists('clientes')) {
    wp_die('Post type "clientes" não está registrado.');
}

// Cria uma nova query em vez de usar query_posts para evitar conflitos
$clientes_query = new WP_Query([
    'post_type'      => 'clientes',
    'posts_per_page' => 8,
    'paged'          => $paged,
    'post_status'    => 'publish'
]);

// Verifica se o card de clientes existe para evitar erro em tempo de execução
$card_template_path   = 'template-parts/content/card-clientes.php';
$card_template_exists = locate_template($card_template_path);

// ===================================================================
// [INÍCIO DO HTML]
// Estrutura de apresentação da listagem de clientes
// ===================================================================
?>

<div class="lg:my-20 container my-10">

    <div class="md:grid-cols-2 grid w-full grid-cols-1 gap-8">
        <?php if ($clientes_query->have_posts()) : ?>
            <?php while ($clientes_query->have_posts()) : $clientes_query->the_post(); ?>
                <?php if ($card_template_exists) : ?>
                    <?php get_template_part('template-parts/content/card', 'clientes'); ?>
                <?php else : ?>
                    <!-- Fallback se o template do card não existir -->
                    <article class="md:flex-row md:gap-8 md:items-center flex flex-col gap-4">
                        <h2 class="text-2xl font-medium text-black"><?php the_title(); ?></h2>
                    </article>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php else : ?>
            <!-- Mensagem quando não há posts -->
            <div class="col-span-full text-center py-10">
                <p class="text-gray-600">Nenhum cliente encontrado.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Paginação -->
    <?php if ($clientes_query->have_posts()) : ?>
        <div class="md:justify-start flex justify-center w-full mt-10">
            <?php
            echo paginate_links([
                'prev_text' => '&laquo; Anterior',
                'next_text' => 'Próximo &raquo;',
                'type'      => 'list',
                'total'     => $clientes_query->max_num_pages,
                'current'   => $paged
            ]);
            ?>
        </div>
    <?php endif; ?>

</div>

<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>