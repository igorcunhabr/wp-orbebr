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
// [INÍCIO DO HTML]
// Marcações para apresentação do card do post
// ===================================================================
?>

<div>
    <div class="bg-black relative h-[160px] lg:h-[310px]">
        <x:header />
        <h2
            class="text-center text-white text-[24px] lg:text-[44px] font-medium pb-4 lg:pb-8 w-full absolute left-0 bottom-0">
            titulo da pagina
        </h2>
    </div>
</div>