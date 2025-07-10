<?php

/**
 * Template Part para exibir um card de post de Blog.
 */

$template_uri = get_template_directory_uri();
$imagem_url = obter_imagem_post(get_the_ID(), 'imagem', 'medium', $template_uri . '/assets/img/placeholder.png');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('item'); ?>>
  <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
    <div class="relative w-full h-auto max-w-sm mx-auto rounded-[20px] overflow-hidden">
      <?php if ($imagem_url) : ?>
        <img
          src="<?php echo esc_url($imagem_url); ?>"
          alt="<?php echo esc_attr(get_the_title()); ?>"
          class="relative z-0 w-full h-auto max-w-sm mx-auto"
          loading="lazy"
          decoding="async">
      <?php endif; ?>
      <div class="hover:opacity-40 absolute top-0 left-0 z-10 w-full h-full transition-opacity duration-300 bg-indigo-600 opacity-0"></div>
    </div>
    <h2 class="mt-2 text-xl font-normal text-center text-black"><?php the_title(); ?></h2>
  </a>
</article>