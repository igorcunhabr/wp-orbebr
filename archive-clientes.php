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

$paged = get_query_var('paged') ?: 1;

// Verifica se o post type 'clientes' está registrado
if (!post_type_exists('clientes')) {
    wp_die(__('Post type "clientes" não está registrado.', 'textdomain'));
}

// Cria uma nova query em vez de usar query_posts para evitar conflitos
$clientes_query = criar_query_otimizada('clientes', null, [
    'paged' => $paged,
    'orderby'    => 'menu_order',
    'order'      => 'ASC'
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
                <?php endif; ?>
            <?php endwhile; ?>
        <?php else : ?>
            <!-- Mensagem quando não há posts -->
            <div class="col-span-full flex flex-col items-center justify-center py-16">
                <span class="text-5xl font-extrabold text-[#FFD530] mb-4"><?php _e('Ooops...', 'textdomain'); ?></span>
                <p class="text-lg text-gray-700 font-medium mb-2"><?php _e('Nenhum cliente encontrado.', 'textdomain'); ?></p>
                <p class="text-base text-gray-500"><?php _e('Assim que tivermos novidades, você verá nossos clientes incríveis por aqui!', 'textdomain'); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Paginação -->
    <?php
    // Renderiza o componente de paginação reutilizável
    renderizar_paginacao($clientes_query);
    ?>

</div>

<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>