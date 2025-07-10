<?php

/**
 * Template para exibir o arquivo do post type personalizado "blogs".
 */

get_header();

// ===================================================================
// [INICIALIZAÇÃO]
// Carregamento inicial e verificações de templates
// ===================================================================


$paged = get_query_var('paged') ? get_query_var('paged') : 1;
query_posts([
    'post_type'      => 'blogs',
    'posts_per_page' => 8,
    'paged'          => $paged
]);

// Verifica se o card de blog existe para evitar erro em tempo de execução
$card_template_path   = 'template-parts/content/card-blog.php';
$card_template_exists = locate_template($card_template_path);

// ===================================================================
// [INÍCIO DO HTML]
// Estrutura de apresentação da listagem do blog
// ===================================================================
?>

<div class="lg:my-20 container my-10">
    <div class="gap-9 flex flex-col w-full max-w-[1000px]">
        <!-- abre -->
        <article id="certificate-item" class="md:flex-row md:gap-14 md:items-center flex flex-col gap-4">
            <img class="w-full md:max-w-[370px] md:h-[310px] h-auto rounded-[20px] object-cover"
                src="imagem" alt="titulo">

            <div class="md:items-start flex flex-col items-center justify-center gap-1">
                <h2 class=" text-2xl font-medium text-black">titulo</h2>
                <p class=" text-lg font-normal text-black">descricao</p>
            </div>
        </article>
        <!-- fecha -->
    </div>

    <!-- <div class="md:justify-start flex justify-center w-full mt-10">
        <buttom wire:click="loadMore" class="btn">Carregar Mais</buttom>
    </div> -->
</div>

<?php wp_reset_query(); ?>
<?php get_footer(); ?>