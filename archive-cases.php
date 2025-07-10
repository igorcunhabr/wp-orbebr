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
    <div class="gap-14 flex flex-col">
        <!-- abre -->
        <article id="event-item" class="md:flex-row gap-7 md:gap-14 flex flex-col">
            <div class="w-full md:basis-1/2">
                <img
                    class="w-full h-auto md:h-[520px] rounded-[20px] object-cover"
                    src="imagem"
                    alt="titulo">
            </div>

            <div class="w-full md:basis-1/2 md:items-start flex flex-col items-center justify-center gap-5">
                <div class="md:text-start text-center">
                    <h2 class="text-2xl font-medium text-black">titulo</h2>
                </div>
                <div class="text-lg font-normal text-black">
                    <div class="htmlchars">
                        resumo
                    </div>
                </div>
                <a class="w-[230px] h-[62px] bg-amber-400 hover:bg-amber-500 transition-all rounded-[10px] text-slate-950 text-xl font-normal flex justify-center items-center" href="url"
                    title="Mais detalhes">Mais detalhes</a>
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