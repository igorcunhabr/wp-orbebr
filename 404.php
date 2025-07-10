<?php
if (!defined('ABSPATH')) exit;
/**
 * Template para exibir a página 404 (Página não encontrada).
 */

get_header();
?>

<section class="container my-20 text-center">
  <div class="max-w-xl mx-auto">
    <h2 class="text-3xl font-bold mb-4"><?php _e('Página não encontrada', 'textdomain'); ?></h2>
    <p class="mb-8 text-lg"><?php _e('Desculpe, mas a página que você procura não existe ou foi removida.', 'textdomain'); ?></p>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block px-6 py-3 bg-amber-400 hover:bg-amber-500 transition-all rounded-[10px] text-slate-950 text-lg font-medium">
      <?php _e('Voltar para a Home', 'textdomain'); ?>
    </a>
  </div>
</section>

<?php get_footer(); ?>