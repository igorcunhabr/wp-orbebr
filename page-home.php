<?php

/**
 * Template Name: Página Inicial
 */


echo '<div class="bg-black">'; // abre bg-black

get_header();

// ===================================================================
// [CONSULTAS DE CONTEÚDO]
// ===================================================================

$template_uri = get_template_directory_uri();

$banners_query = criar_query('banners', 5, [
  'orderby' => 'date',
  'order'   => 'ASC'
]);

$cases_query = criar_query('cases', 10);

$servicos_query = criar_query('servicos', 6, [
  'orderby'  => 'meta_value_num',
  'meta_key' => 'ordem'
]);

// ===================================================================
// [INICIO DO HTML]
// ===================================================================

?>

<section id="banner" class="relative w-full">
  <div class="swiper bannerSwiper">
    <div class="swiper-wrapper">
      <?php if ($banners_query->have_posts()) : ?>
        <?php while ($banners_query->have_posts()) : $banners_query->the_post(); ?>
          <?php
          $banner_id = get_the_ID();
          $banner_image = obter_imagem_post($banner_id, 'imagem', 'full', $template_uri . '/assets/img/bg-section.png');
          $banner_title = get_the_title();
          $banner_subtitle = obter_campo_acf('subtitulo', $banner_id);
          ?>
          <div class="swiper-slide">
            <article class="w-full h-[200px] lg:h-auto">
              <img class="object-cover w-full h-full"
                src="<?php echo esc_url($banner_image); ?>"
                alt="<?php echo esc_attr($banner_title); ?>">
              <div class="w-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-[1] text-center">
                <h2 id="banner-title" class="max-w-[500px] m-auto text-white text-[24px] lg:text-[44px] font-medium">
                  <?php echo esc_html($banner_title); ?>
                </h2>
                <?php if (!empty($banner_subtitle)) : ?>
                  <p id="banner-subtitle" class="max-w-[500px] m-auto text-white text-lg lg:text-3xl">
                    <?php echo esc_html($banner_subtitle); ?>
                  </p>
                <?php endif; ?>
              </div>
            </article>
          </div>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<section class="hidden lg:grid md:grid-cols-3 lg:grid-cols-5 grid-cols-1">
  <?php if ($cases_query->have_posts()) : ?>
    <?php while ($cases_query->have_posts()) : $cases_query->the_post(); ?>
      <?php
      $case_id = get_the_ID();
      $case_title = get_the_title();
      $case_link = get_permalink();
      $case_category = obter_campo_acf('categoria', $case_id);

      // Fallback para taxonomia se não tiver campo ACF
      if (empty($case_category)) {
        $terms = get_the_terms($case_id, 'categoria_cases');
        if ($terms && !is_wp_error($terms)) {
          $case_category = end($terms)->name;
        }
      }

      $case_image = obter_imagem_post($case_id, 'imagem', 'medium', $template_uri . '/assets/img/bg-section.png');
      ?>
      <?php static $event_index = 1; ?>
      <article id="event-<?php echo $event_index; ?>" class="group relative transition-all">
        <?php $event_index = ($event_index < 10) ? $event_index + 1 : 1; ?>
        <a href="<?php echo esc_url($case_link); ?>" title="<?php echo esc_attr($case_title); ?>">
          <div class="hover:group relative">
            <img src="<?php echo esc_url($case_image); ?>"
              alt="<?php echo esc_attr($case_title); ?>"
              class="w-full h-auto">
            <div class="bg-gradient-to-b from-transparent to-black absolute inset-0"></div>
          </div>
          <div class="group-hover:pb-5 absolute bottom-0 left-0 w-full p-4 transition-all">
            <h2 class="text-lg font-medium text-white"><?php echo esc_html($case_title); ?></h2>
            <?php if (!empty($case_category)) : ?>
              <p class="text-lg text-white"><?php echo esc_html($case_category); ?></p>
            <?php endif; ?>
          </div>
        </a>
      </article>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
  <?php endif; ?>
</section>

<section class="py-14">
  <div class="container">
    <h2 id="services-title" class="text-white text-[42px] text-center mb-6">COMO PODEMOS
      <span class="font-bold">AJUDAR?</span>
    </h2>

    <div class="md:grid-cols-2 lg:grid-cols-3 gap-7 grid grid-cols-1">
      <?php if ($servicos_query->have_posts()) : ?>
        <?php while ($servicos_query->have_posts()) : $servicos_query->the_post(); ?>
          <?php
          $servico_id = get_the_ID();
          $servico_title = get_the_title();
          $servico_description = obter_campo_acf('descricao', $servico_id);
          $servico_icon = obter_campo_acf('icone', $servico_id);

          // Fallback para excerpt se não tiver descrição
          if (empty($servico_description)) {
            $servico_description = get_the_excerpt();
            if (empty($servico_description)) {
              $servico_description = wp_trim_words(get_the_content(), 20, '...');
            }
          }
          ?>
          <?php static $service_index = 1; ?>
          <article id="service-<?php echo $service_index; ?>" class="opacity-75 bg-gray-950 p-[32px] rounded-[40px] border-2 border-slate-900 hover:border-amber-400 transition-all">
            <?php $service_index = ($service_index < 6) ? $service_index + 1 : 1; ?>
            <div class="w-20 h-20 bg-slate-900 rounded-[20px] flex items-center justify-center mb-6">
              <?php if (is_array($servico_icon) && isset($servico_icon['url'])) : ?>
                <img src="<?php echo esc_url($servico_icon['url']); ?>"
                  alt="<?php echo esc_attr($servico_title); ?>"
                  class="w-10 h-10 object-contain">
              <?php elseif (is_string($servico_icon) && !empty($servico_icon)) : ?>
                <img src="<?php echo esc_url($servico_icon); ?>"
                  alt="<?php echo esc_attr($servico_title); ?>"
                  class="w-10 h-10 object-contain">
              <?php endif; ?>
            </div>
            <h3 class="text-white text-[25px] font-medium mb-2"><?php echo esc_html($servico_title); ?></h3>
            <p class="text-base text-white"><?php echo esc_html($servico_description); ?></p>
          </article>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      <?php endif; ?>
    </div>
  </div>
</section>
</div><!-- fecha bg-black -->

<section class="py-14">
  <div class="container">
    <div id="forms-title" class="w-full max-w-[640px] m-auto mb-5 text-center">
      <span class="text-zinc-500 text-base font-normal">VAMOS TOMAR UM CAFÉ?</span>
      <h2 class="text-3xl font-bold text-indigo-900">FALE COM UM DE NOSSOS ESPECIALISTAS</h2>
    </div>

    <div class="w-full max-w-[770px] m-auto">
      <?php echo do_shortcode('[contact-form-7 id="2f9d491" title="Fale Conosco"]'); ?>
    </div>
  </div>
</section>

<?php
// Seção do time (apenas se houver imagem configurada)
$team_image = obter_campo_acf('config_team_rodape', 'option');
if (!empty($team_image)) :
  $team_image_url = is_array($team_image) && isset($team_image['url']) ? $team_image['url'] : $team_image;
?>
  <section id="team">
    <img src="<?php echo esc_url($team_image_url); ?>" alt="Team">
  </section>
<?php endif; ?>

<?php
get_footer();
?>