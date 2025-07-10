<?php
if (!defined('ABSPATH')) exit;
/**
 * Template para exibir o arquivo do post type personalizado "blogs".
 */

get_header();

// ===================================================================
// [INICIALIZAÇÃO]
// ===================================================================
$paged = get_query_var('paged') ?: 1;
$blogs_query = criar_query_otimizada('blogs', 8, ['paged' => $paged]);

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
        <?php else : ?>
          <!-- Fallback card se o template não existir -->
          <article id="post-<?php the_ID(); ?>" <?php post_class('item'); ?>>
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
              <div class="relative w-full h-auto max-w-sm mx-auto rounded-[20px] overflow-hidden">
                <?php if (has_post_thumbnail()) : ?>
                  <?php the_post_thumbnail('medium', ['class' => 'relative z-0 w-full h-auto max-w-sm mx-auto']); ?>
                <?php endif; ?>
                <div class="hover:opacity-40 absolute top-0 left-0 z-10 w-full h-full transition-opacity duration-300 bg-indigo-600 opacity-0"></div>
              </div>
              <h2 class="mt-2 text-xl font-normal text-center text-black"><?php the_title(); ?></h2>
            </a>
          </article>
        <?php endif; ?>
      <?php endwhile; ?>
    <?php else : ?>
      <div class="col-span-full max-w-[900px] bg-red-50 flex items-center w-full p-4 m-auto mb-4 text-sm text-red-800 border border-red-300 rounded-lg mt-10 justify-center" role="alert">
        <svg class="me-3 flex-shrink-0 inline w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
        </svg>
        <span class="sr-only">Info</span>
        <div>
          <span class="font-medium"><?php _e('Ops!', 'textdomain'); ?></span> <?php _e('Não existem postagens disponíveis no momento.', 'textdomain'); ?>
        </div>
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

  <?php if ($blogs_query->max_num_pages > 1) : ?>
    <div class="w-full mt-10">
      <?php
      $pagination = paginate_links([
        'prev_text' => __('&laquo; Anterior', 'textdomain'),
        'next_text' => __('Próximo &raquo;', 'textdomain'),
        'type'      => 'array',
        'class'     => 'pagination',
        'total'     => $blogs_query->max_num_pages,
        'current'   => $paged
      ]);
      if ($pagination) : ?>
        <nav class="flex justify-center" aria-label="<?php esc_attr_e('Navegação de páginas', 'textdomain'); ?>">
          <ul class="flex space-x-2">
            <?php foreach ($pagination as $link) : ?>
              <li><?php echo $link; ?></li>
            <?php endforeach; ?>
          </ul>
        </nav>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</div>

<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>