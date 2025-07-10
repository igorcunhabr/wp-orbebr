<?php

/**
 * Template Part para funcionalidades de upload e mídia.
 */

// ===================================================================
// [SUPORTE A UPLOAD DE SVG]
// Permite o upload de arquivos SVG no WordPress com sanitização de segurança
// ===================================================================

/**
 * Adiciona suporte para upload de arquivos SVG
 * 
 * @param array $mimes Array de tipos MIME permitidos
 * @return array Array modificado com suporte a SVG
 */
function adicionar_suporte_svg($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}

/**
 * Sanitiza arquivos SVG antes do upload para segurança
 * 
 * @param array $file Array com informações do arquivo
 * @return array Array do arquivo (modificado se necessário)
 */
function sanitizar_svg_upload($file)
{
    // Verifica se é um arquivo SVG
    if ($file['type'] === 'image/svg+xml') {

        // Lê o conteúdo do arquivo
        $svg_content = file_get_contents($file['tmp_name']);

        // Lista de tags e atributos potencialmente perigosos
        $dangerous_tags = [
            'script',
            'object',
            'embed',
            'iframe',
            'link',
            'meta',
            'title',
            'desc'
        ];

        $dangerous_attributes = [
            'onload',
            'onclick',
            'onmouseover',
            'onmouseout',
            'onfocus',
            'onblur',
            'onchange',
            'onsubmit',
            'onreset',
            'onselect',
            'onunload',
            'onerror'
        ];

        // Remove tags perigosas
        foreach ($dangerous_tags as $tag) {
            $svg_content = preg_replace('/<' . $tag . '[^>]*>.*?<\/' . $tag . '>/is', '', $svg_content);
            $svg_content = preg_replace('/<' . $tag . '[^>]*\/>/is', '', $svg_content);
        }

        // Remove atributos perigosos
        foreach ($dangerous_attributes as $attr) {
            $svg_content = preg_replace('/\s+' . $attr . '\s*=\s*["\'][^"\']*["\']/i', '', $svg_content);
        }

        // Remove comentários que podem conter código malicioso
        $svg_content = preg_replace('/<!--.*?-->/s', '', $svg_content);

        // Remove CDATA sections que podem conter código malicioso
        $svg_content = preg_replace('/<!\[CDATA\[.*?\]\]>/s', '', $svg_content);

        // Escreve o conteúdo sanitizado de volta ao arquivo
        file_put_contents($file['tmp_name'], $svg_content);
    }

    return $file;
}

// ===================================================================
// [REGISTRO DOS HOOKS]
// Registra as funções nos hooks apropriados do WordPress
// ===================================================================

// Adiciona suporte para upload de SVG
add_filter('upload_mimes', 'adicionar_suporte_svg');

// Sanitiza arquivos SVG para segurança
add_filter('wp_handle_upload_prefilter', 'sanitizar_svg_upload');
