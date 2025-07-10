<?php

/**
 * Template Part para exibir um card de post de Blog.
 */

// ===================================================================
// [INICIALIZAÇÃO]
// Coleta e preparação dos dados do post para exibição no card
// ===================================================================

// Define a URI do tema para uso nos assets (imagens, ícones, etc.)
$template_uri = get_template_directory_uri();

// Obtém a imagem usando a função helper com fallback inteligente
$imagem_url = obter_imagem_post(get_the_ID(), 'imagem', 'medium');

// Obtém a data formatada
$data_iso = get_the_date('c');
$data_exibicao = get_the_date('j \d\e F \d\e Y');

// ===================================================================
// [INÍCIO DO HTML]
// Marcações para apresentação do card do post
// ===================================================================
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
      <div class="hover:opacity-40 absolute top-0 left-0 z-10 w-full h-full transition-opacity duration-300 bg-indigo-600 opacity-0">
      </div>
    </div>
    <h2 class="mt-2 text-xl font-normal text-center text-black"><?php the_title(); ?></h2>
  </a>
</article>