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

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- abre -->
        <article id="team-item">
            <img class="w-full h-[260px] rounded-[20px] object-cover mb-3"
                src="imagem" alt="titulo">

            <div class="flex flex-col gap-5">
                <div class="md:text-start flex flex-col gap-2 text-center">
                    <div>
                        <h2 class="text-black text-[28px] font-medium">titulo</h2>
                        <p class="text-base font-normal text-black">cargo</p>
                    </div>
                    <span class="w-[100px] h-1 bg-amber-400 m-auto md:m-0"></span>
                </div>
                <div class="w-full md:max-w-[477px] text-lg font-normal text-black text-center md:text-start">
                    <div class="htmlchars">
                        descricao
                    </div>
                </div>
            </div>
        </article>
        <!-- fecha -->

        <!-- {{-- <div class="md:justify-start flex justify-center w-full mt-10">--}}
        {{-- <buttom wire:click="loadMore" class="btn">Carregar Mais</buttom>--}}
        {{-- </div>--}} -->
    </div>

    <div class="w-full mt-16">
        <div class="max-w-[900px] bg-black rounded-[20px] p-10 m-auto">
            <div class="mb-5 text-center">
                <span class="text-slate-200 text-base font-normal">QUER FAZER PARTE DA EQUIPE?</span>
                <h3 class="text-amber-400 text-3xl font-bold text-center">MANDA UMA MENSAGEM</h3>
            </div>

            formulario aqui!

        </div>
    </div>
</div>

<?php wp_reset_query(); ?>
<?php get_footer(); ?>