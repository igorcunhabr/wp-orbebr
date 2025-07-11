<?php
if (!defined('ABSPATH')) exit;
/**
 * Template para exibir o arquivo do post type personalizado "blogs".
 */

// Define o título personalizado para o header interno
ThemeHelpers::definir_titulo_pagina(__('Blogs', 'textdomain'));

get_header();

// ===================================================================
// [INICIALIZAÇÃO]
// ===================================================================
$paged = get_query_var('paged') ?: 1;
$blogs_query = criar_query_otimizada('blogs', null, ['paged' => $paged]);

$card_template_path   = 'template-parts/content/card-blog.php';
$card_template_exists = locate_template($card_template_path);

// ===================================================================
// [INÍCIO DO HTML]
// ===================================================================
?>

<div class="lg:my-20 container my-10">
  <div id="search" class="w-full max-w-[570px] relative m-auto">
    <input class="bg-slate-200 text-black text-lg font-normal rounded-[10px] border-0 ring-1 ring-inset ring-slate-200 focus:ring-1 focus:ring-inset focus:ring-indigo-900 block w-full py-4 px-4 placeholder-black focus:placeholder-black" type="text" placeholder="<?php echo esc_attr(__('Buscar por', 'textdomain')); ?>">
    <img class="z-1 top-1/2 right-4 absolute w-6 h-6 -translate-y-1/2" src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon-search.svg'); ?>" alt="Search">
  </div>

  <div id="paginated-posts" class="md:grid-cols-2 lg:grid-cols-4 grid w-full grid-cols-1 gap-4 mt-10">
    <?php if ($blogs_query->have_posts()) : ?>
      <?php while ($blogs_query->have_posts()) : $blogs_query->the_post(); ?>
        <?php if ($card_template_exists) : ?>
          <?php get_template_part('template-parts/content/card', 'blog'); ?>
        <?php endif; ?>
      <?php endwhile; ?>
    <?php else : ?>
      <!-- Mensagem quando não há posts -->
      <div class="col-span-full flex flex-col items-center justify-center py-16">
        <span class="text-5xl font-extrabold text-[#FFD530] mb-4"><?php _e('Ooops...', 'textdomain'); ?></span>
        <p class="text-lg text-gray-700 font-medium mb-2"><?php _e('Nenhuma postagem encontrada.', 'textdomain'); ?></p>
        <p class="text-base text-gray-500"><?php _e('Assim que tivermos novidades, você verá nossas postagens incríveis por aqui!', 'textdomain'); ?></p>
      </div>
    <?php endif; ?>

    <div class="no-results-message col-span-full max-w-[900px] bg-red-50 flex items-center w-full p-4 m-auto mb-4 text-sm text-red-800 border border-red-300 rounded-lg mt-10 justify-center" role="alert" style="display: none;">
      <svg class="me-3 flex-shrink-0 inline w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
      </svg>
      <span class="sr-only">Info</span>
      <div>
        <span class="font-medium"><?php _e('Ops!', 'textdomain'); ?></span> <?php _e('Não existem postagens com o termo pesquisado.', 'textdomain'); ?>
      </div>
    </div>
  </div>

  <?php
  // Renderiza o componente de paginação reutilizável
  renderizar_paginacao($blogs_query);
  ?>
</div>

<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>