<?php

/**
 * Template para exibir um post único do tipo "Cases".
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
                'url' => obter_imagem_post(get_the_ID(), 'imagem', 'full'),
                'alt' => get_the_title(),
            ],
            'main_content' => obter_campo_acf('descricao', get_the_ID(), ''),
            'gallery'     => [],
        ];

        // Processa a galeria de imagens se existir
        $raw_gallery = obter_campo_acf('galeria_imagens', get_the_ID(), []);
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

                <!-- Título do case -->
                <h1 class="text-3xl lg:text-4xl font-medium text-black mb-6"><?php the_title(); ?></h1>

                <!-- Data do case -->
                <time datetime="<?php echo esc_attr($post_data['date_iso']); ?>" class="text-gray-600 mb-8 block">
                    <?php echo esc_html($post_data['date_display']); ?>
                </time>

                <!-- Galeria de imagens (se houver múltiplas imagens) -->
                <?php if (!empty($post_data['gallery']) && count($post_data['gallery']) > 1) : ?>
                    <div class="md:grid-cols-3 lg:grid-cols-4 gallery grid grid-cols-2 gap-5 mb-8">
                        <?php foreach ($post_data['gallery'] as $image) : ?>
                            <div class="relative rounded-[10px] h-[180px] overflow-hidden">
                                <a href="<?php echo esc_url($image['full_url']); ?>" class="glightbox">
                                    <img src="<?php echo esc_url($image['thumb_url']); ?>"
                                        alt="<?php echo esc_attr($image['alt']); ?>"
                                        class="object-cover w-full h-full">
                                    <div class="hover:opacity-40 z-1 absolute top-0 left-0 w-full h-full transition-opacity duration-300 bg-indigo-600 opacity-0">
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php elseif (!empty($post_data['cover_image']['url'])) : ?>
                    <!-- Imagem única em destaque -->
                    <div class="rounded-[10px] h-[300px] lg:h-[480px] overflow-hidden mb-8">
                        <a href="<?php echo esc_url($post_data['cover_image']['url']); ?>" class="glightbox">
                            <img src="<?php echo esc_url($post_data['cover_image']['url']); ?>"
                                alt="<?php echo esc_attr($post_data['cover_image']['alt']); ?>"
                                class="object-cover w-full h-full">
                        </a>
                    </div>
                <?php endif; ?>

                <!-- Conteúdo principal (descrição do case) -->
                <?php if (!empty($post_data['main_content'])) : ?>
                    <div class="prose prose-lg max-w-none">
                        <?php echo wp_kses_post($post_data['main_content']); ?>
                    </div>
                <?php else : ?>
                    <!-- Fallback para o conteúdo padrão do WordPress -->
                    <div class="prose prose-lg max-w-none">
                        <?php the_content(); ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>

<?php endwhile;
endif; ?>

<?php get_footer(); ?>