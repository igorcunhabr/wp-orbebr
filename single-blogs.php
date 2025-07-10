<?php

/**
 * Template para exibir um post único do tipo "Blog".
 */

get_header();

// ===================================================================
// [INICIALIZAÇÃO]
// Definição de variáveis globais e preparação dos dados do post
// ===================================================================

// URI do tema para uso em imagens e recursos
$template_uri = get_template_directory_uri();

?>

<?php if (have_posts()) : while (have_posts()) : the_post();

    // ===================================================================
    // [COLETA DE DADOS DO POST]
    // Centraliza a coleta de campos personalizados e processamento da galeria
    // ===================================================================

    $post_data = [
      'date_iso'     => get_the_date('c'),
      'date_display' => get_the_date('j \d\e F \d\e Y'),
      'cover_image'  => [
        'url' => get_field('imagem')['url'] ?? null,
        'alt' => get_field('imagem')['alt'] ?? get_the_title(),
      ],
      'main_content' => get_field('conteudo') ?? '',
      'gallery'     => [],
    ];

    $raw_gallery = get_field('galeria_imagens');
    if (!empty($raw_gallery) && is_array($raw_gallery)) {
      foreach ($raw_gallery as $img) {
        $thumb_url = $img['sizes']['thumbnail'] ?? $img['url'];
        $post_data['gallery'][] = [
          'full_url'  => $img['url'] ?? '',
          'thumb_url' => $thumb_url,
          'alt'       => $img['alt'] ?? __('Imagem da galeria', 'textdomain'),
        ];
      }
    }
?>

    <!-- =================================================================== -->
    <!-- [INÍCIO DO HTML] -->
    <!-- Estrutura de apresentação do post único -->
    <!-- =================================================================== -->

    <div class="lg:my-20 container my-10">
      <div class="max-w-[900px] mx-auto">
        @if (!empty($blog->images))
        <div class="md:grid-col-3 lg:grid-cols-4 gallery grid grid-cols-2 gap-5">
          @foreach ($blog->images as $image)
          <div id="images-item" class="relative rounded-[10px] h-[180px] overflow-hidden">
            <a href="{{ asset('storage/' . $image) }}" class="glightbox">
              <img src="{{ asset('storage/' . $image) }}" alt="{{ $blog->title }}"
                class="object-cover w-full h-full">
              <div
                class="hover:opacity-40 z-1 absolute top-0 left-0 w-full h-full transition-opacity duration-300 bg-indigo-600 opacity-0">
              </div>
            </a>
          </div>
          @endforeach
        </div>
        @else
        <div id="images-item" class="rounded-[10px] h-[300px] lg:h-[480px] overflow-hidden">
          <a href="{{ asset('storage/' . $blog->cover) }}" class="glightbox">
            <img src="{{ asset('storage/' . $blog->cover) }}" alt="{{ $blog->title }}"
              class="object-cover w-full h-full">
          </a>
        </div>
        @endif
        <div id="text" class="mt-5">
          <p>
            {!! $blog->content !!}
          </p>
        </div>
      </div>
    </div>


    @if ($setting->team_cover != '')
    <section id="team">
      <img src="{{ asset('storage/' . $setting->team_cover) }}" alt="Team">
    </section>
    @endif

<?php endwhile;
endif; ?>

<?php get_footer(); ?>