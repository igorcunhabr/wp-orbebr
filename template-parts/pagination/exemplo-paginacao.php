<?php

/**
 * Exemplo de Uso do Componente de Paginação
 * 
 * Este arquivo demonstra como usar o componente de paginação
 * em diferentes cenários.
 */

// ===================================================================
// [EXEMPLO 1: USO BÁSICO]
// ===================================================================

echo '<h2>Exemplo 1: Uso Básico</h2>';

$query_basica = criar_query_otimizada('blogs', 4, ['paged' => get_query_var('paged')]);

if ($query_basica->have_posts()) {
    echo '<div class="grid grid-cols-2 gap-4 mb-8">';
    while ($query_basica->have_posts()) {
        $query_basica->the_post();
        echo '<div class="p-4 border rounded">';
        echo '<h3>' . get_the_title() . '</h3>';
        echo '</div>';
    }
    echo '</div>';
    wp_reset_postdata();
}

// Renderiza paginação básica
renderizar_paginacao($query_basica);

// ===================================================================
// [EXEMPLO 2: PAGINAÇÃO PERSONALIZADA]
// ===================================================================

echo '<h2>Exemplo 2: Paginação Personalizada</h2>';

$query_personalizada = criar_query_otimizada('cases', 3, ['paged' => get_query_var('paged')]);

if ($query_personalizada->have_posts()) {
    echo '<div class="grid grid-cols-1 gap-4 mb-8">';
    while ($query_personalizada->have_posts()) {
        $query_personalizada->the_post();
        echo '<div class="p-4 bg-gray-100 rounded">';
        echo '<h3>' . get_the_title() . '</h3>';
        echo '</div>';
    }
    echo '</div>';
    wp_reset_postdata();
}

// Renderiza paginação com argumentos personalizados
renderizar_paginacao($query_personalizada, [
    'prev_text' => '← Voltar',
    'next_text' => 'Avançar →',
    'mid_size'  => 3,
    'end_size'  => 2
]);

// ===================================================================
// [EXEMPLO 3: VERIFICAÇÃO CONDICIONAL]
// ===================================================================

echo '<h2>Exemplo 3: Verificação Condicional</h2>';

$query_condicional = criar_query_otimizada('clientes', 6, ['paged' => get_query_var('paged')]);

if ($query_condicional->have_posts()) {
    echo '<div class="grid grid-cols-3 gap-4 mb-8">';
    while ($query_condicional->have_posts()) {
        $query_condicional->the_post();
        echo '<div class="p-4 bg-blue-100 rounded">';
        echo '<h3>' . get_the_title() . '</h3>';
        echo '</div>';
    }
    echo '</div>';
    wp_reset_postdata();
}

// Só exibe paginação se necessário
if (deve_exibir_paginacao($query_condicional)) {
    echo '<p class="text-sm text-gray-600 mb-4">Exibindo paginação porque há múltiplas páginas</p>';
    renderizar_paginacao($query_condicional);
} else {
    echo '<p class="text-sm text-gray-600 mb-4">Não há paginação porque só existe uma página</p>';
}

// ===================================================================
// [EXEMPLO 4: TEMPLATE PART DIRETO]
// ===================================================================

echo '<h2>Exemplo 4: Template Part Direto</h2>';

$query_template = criar_query_otimizada('certificacoes', 5, ['paged' => get_query_var('paged')]);

if ($query_template->have_posts()) {
    echo '<div class="grid grid-cols-2 gap-4 mb-8">';
    while ($query_template->have_posts()) {
        $query_template->the_post();
        echo '<div class="p-4 bg-green-100 rounded">';
        echo '<h3>' . get_the_title() . '</h3>';
        echo '</div>';
    }
    echo '</div>';
    wp_reset_postdata();
}

// Usa template part diretamente
get_template_part('template-parts/pagination/pagination-simple', null, [
    'query' => $query_template
]);
