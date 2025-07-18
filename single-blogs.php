<?php
if (!defined('ABSPATH')) exit;
/**
 * Template para exibir um post único do tipo "Blog".
 */

get_header();

$template_uri = get_template_directory_uri();
?>

<?php if (have_posts()) : while (have_posts()) : the_post();
    $post_data = [
      'date_iso'     => get_the_date('c'),
      'date_display' => get_the_date('j \d\e F \d\e Y'),
      'cover_image'  => [
        'url' => esc_url(obter_imagem_post(get_the_ID(), 'imagem', 'full')),
        'alt' => esc_attr(get_the_title()),
      ],
      'main_content' => obter_campo_acf('conteudo', get_the_ID(), ''),
      'gallery'     => [],
    ];
    $raw_gallery = obter_campo_acf('galeria_imagens', get_the_ID(), []);
    if (!empty($raw_gallery) && is_array($raw_gallery)) {
      foreach ($raw_gallery as $img) {
        $thumb_url = $img['sizes']['thumbnail'] ?? $img['url'];
        $post_data['gallery'][] = [
          'full_url'  => esc_url($img['url'] ?? ''),
          'thumb_url' => esc_url($thumb_url),
          'alt'       => esc_attr($img['alt'] ?? __('Imagem da galeria', 'textdomain')),
        ];
      }
    }
?>
    <div class="lg:my-20 container my-10">
      <div class="max-w-[900px] mx-auto">
        <?php if (!empty($post_data['gallery']) && count($post_data['gallery']) > 1) : ?>
          <div class="md:grid-cols-3 lg:grid-cols-4 gallery grid grid-cols-2 gap-5 mb-8">
            <?php foreach ($post_data['gallery'] as $image) : ?>
              <div class="relative rounded-[10px] h-[180px] overflow-hidden">
                <a data-fslightbox="gallery" href="<?php echo $image['full_url']; ?>">
                  <img src="<?php echo $image['thumb_url']; ?>"
                    alt="<?php echo $image['alt']; ?>"
                    class="object-cover w-full h-full">
                  <div class="hover:opacity-40 z-1 absolute top-0 left-0 w-full h-full transition-opacity duration-300 bg-indigo-600 opacity-0"></div>
                </a>
              </div>
            <?php endforeach; ?>
          </div>
        <?php elseif (!empty($post_data['cover_image']['url'])) : ?>
          <div class="rounded-[10px] h-[300px] lg:h-[480px] overflow-hidden mb-8">
            <a data-fslightbox="gallery" href="<?php echo $post_data['cover_image']['url']; ?>">
              <img src="<?php echo $post_data['cover_image']['url']; ?>"
                alt="<?php echo $post_data['cover_image']['alt']; ?>"
                class="object-cover w-full h-full">
            </a>
          </div>
        <?php endif; ?>
        <?php if (!empty($post_data['main_content'])) : ?>
          <div class="prose prose-lg max-w-none">
            <?php echo wp_kses_post($post_data['main_content']); ?>
          </div>
        <?php else : ?>
          <div class="prose prose-lg max-w-none">
            <?php the_content(); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
<?php endwhile;
endif; ?>
<?php get_footer(); ?>