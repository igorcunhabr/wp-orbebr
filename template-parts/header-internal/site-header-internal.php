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

// Organiza os dados necessários para o card em um array para melhor clareza
$card_data = [
    'image_url'     => get_field('imagem')['url'] ?? null,
    'image_alt'     => get_field('imagem')['alt'] ?? get_the_title(),
    'date_iso'      => get_the_date('c'),
    'date_display'  => get_the_date('j \d\e F \d\e Y'),
    'permalink'     => get_the_permalink(),
    'title_attr'    => the_title_attribute(['echo' => false]),
];

// ===================================================================
// [SISTEMA DE TÍTULO DINÂMICO]
// Define o título da página com prioridade: ACF > Global > Fallback
// ===================================================================

// Obtém o título da página usando a função helper
$page_title = ThemeHelpers::obter_titulo_pagina();

// ===================================================================
// [INÍCIO DO HTML]
// Marcações para apresentação do card do post
// ===================================================================
?>

<div class="bg-black relative h-[160px] lg:h-[310px]">
    <?php get_template_part('template-parts/header/site-header'); ?>
    <h2
        class="text-center text-white text-[24px] lg:text-[44px] font-medium pb-4 lg:pb-8 w-full absolute left-0 bottom-0">
        <?php echo esc_html($page_title); ?>
    </h2>
</div>