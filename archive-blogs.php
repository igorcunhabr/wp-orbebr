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
  <div id="search" class="w-full max-w-[570px] relative m-auto">
    <input class="bg-slate-200 text-black text-lg font-normal rounded-[10px] border-0 ring-1 ring-inset ring-slate-200 focus:ring-1 focus:ring-inset focus:ring-indigo-900 block w-full py-4 px-4 placeholder-black focus:placeholder-black" type="text" placeholder="Buscar por">
    <img class="z-1 top-1/2 right-4 absolute w-6 h-6 -translate-y-1/2" src="images/icon-search.svg" alt="Search">
  </div>

  <div id="paginated-posts" class="md:grid-cols-2 lg:grid-cols-4 grid w-full grid-cols-1 gap-4 mt-10">

    <!-- abre -->
    <article id="blog-item">
      <a href="url" title="titulo">
        <div class="relative w-full h-auto max-w-sm mx-auto rounded-[20px] overflow-hidden">
          <img src="imagem" alt="titulo" class="relative z-0 w-full h-auto max-w-sm mx-auto">
          <div
            class="hover:opacity-40 absolute top-0 left-0 z-10 w-full h-full transition-opacity duration-300 bg-indigo-600 opacity-0">
          </div>
        </div>

        <h2 class="mt-2 text-xl font-normal text-center text-black">titulo</h2>
      </a>
    </article>
    <!-- fecha -->

  </div>

  <div class="w-full mt-10">
    paginacao
  </div>
  <div class="max-w-[900px] bg-red-50 flex items-center w-full p-4 m-auto mb-4 text-sm text-red-800 border border-red-300 rounded-lg mt-10 justify-center"
    role="alert">
    <svg class="me-3 flex-shrink-0 inline w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
      fill="currentColor" viewBox="0 0 20 20">
      <path
        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
    </svg>
    <span class="sr-only">Info</span>
    <div>
      <span class="font-medium">Ops!</span> Não existem postagens com termo pesquisado.
    </div>
  </div>
  @endif
</div>

<?php wp_reset_query(); ?>
<?php get_footer(); ?>