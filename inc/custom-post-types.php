<?php

/**
 * Template Part para registro de Custom Post Types (CPTs).
 */

// ===================================================================
// [GERAÇÃO DE LABELS]
// Função para gerar um array completo e traduzível de labels para CPTs
// ===================================================================
/**
 * Gera um array completo e traduzível de etiquetas para um Custom Post Type.
 *
 * @param string $singular Nome no singular (ex: 'Livro').
 * @param string $plural   Nome no plural (ex: 'Livros').
 * @return array           Array completo de labels.
 */
function meu_tema_get_cpt_labels($singular, $plural)
{
  return [
    'name'                  => _x($plural, 'Post Type General Name', 'textdomain'),
    'singular_name'         => _x($singular, 'Post Type Singular Name', 'textdomain'),
    'menu_name'             => __($plural, 'textdomain'),
    'name_admin_bar'        => __($singular, 'textdomain'),
    'archives'              => sprintf(__('Arquivos de %s', 'textdomain'), strtolower($plural)),
    'attributes'            => sprintf(__('Atributos de %s', 'textdomain'), strtolower($singular)),
    'parent_item_colon'     => sprintf(__('Parent %s:', 'textdomain'), $singular),
    'all_items'             => sprintf(__('Todos os %s', 'textdomain'), $plural),
    'add_new_item'          => sprintf(__('Adicionar Novo %s', 'textdomain'), $singular),
    'add_new'               => __('Adicionar Novo', 'textdomain'),
    'new_item'              => sprintf(__('Novo %s', 'textdomain'), $singular),
    'edit_item'             => sprintf(__('Editar %s', 'textdomain'), $singular),
    'update_item'           => sprintf(__('Atualizar %s', 'textdomain'), $singular),
    'view_item'             => sprintf(__('Ver %s', 'textdomain'), $singular),
    'view_items'            => sprintf(__('Ver %s', 'textdomain'), $plural),
    'search_items'          => sprintf(__('Pesquisar %s', 'textdomain'), $plural),
    'not_found'             => __('Não encontrado', 'textdomain'),
    'not_found_in_trash'    => __('Não encontrado na lixeira', 'textdomain'),
    'featured_image'        => __('Imagem em destaque', 'textdomain'),
    'set_featured_image'    => __('Definir imagem em destaque', 'textdomain'),
    'remove_featured_image' => __('Remover imagem em destaque', 'textdomain'),
    'use_featured_image'    => __('Usar como imagem em destaque', 'textdomain'),
    'insert_into_item'      => sprintf(__('Inserir em %s', 'textdomain'), strtolower($singular)),
    'uploaded_to_this_item' => sprintf(__('Enviado para este %s', 'textdomain'), strtolower($singular)),
    'items_list'            => sprintf(__('Lista de %s', 'textdomain'), $plural),
    'items_list_navigation' => sprintf(__('Navegação da lista de %s', 'textdomain'), $plural),
    'filter_items_list'     => sprintf(__('Filtrar lista de %s', 'textdomain'), $plural),
  ];
}

// ===================================================================
// [REGISTRO DOS CUSTOM POST TYPES]
// Define os CPTs do tema com suas configurações e labels
// ===================================================================
function meu_tema_registrar_cpts()
{
  // Clientes
  register_post_type('clientes', [
    'labels'       => meu_tema_get_cpt_labels('Cliente', 'Clientes'),
    'description'  => __('Gerenciamento de clientes da empresa.', 'textdomain'),
    'public'       => true,
    'has_archive'  => true,
    'rewrite'      => ['slug' => 'clientes'],
    'supports'     => ['title'], // Pode adicionar 'editor', 'thumbnail' etc.
    'menu_icon'    => 'dashicons-groups',
    'show_in_rest' => true,
  ]);

  // Certificações
  register_post_type('certificacoes', [
    'labels'       => meu_tema_get_cpt_labels('Certificação', 'Certificações'),
    'description'  => __('Certificações e credenciais da empresa.', 'textdomain'),
    'public'       => true,
    'has_archive'  => true,
    'rewrite'      => ['slug' => 'certificacoes'],
    'supports'     => ['title'], // Pode adicionar 'editor', 'thumbnail' etc.
    'menu_icon'    => 'dashicons-awards',
    'show_in_rest' => true,
  ]);

  // Cases
  register_post_type('cases', [
    'labels'       => meu_tema_get_cpt_labels('Case', 'Cases'),
    'description'  => __('Cases de sucesso e projetos realizados.', 'textdomain'),
    'public'       => true,
    'has_archive'  => true,
    'rewrite'      => ['slug' => 'cases'],
    'supports'     => ['title'], // Pode adicionar 'editor', 'thumbnail' etc.
    'menu_icon'    => 'dashicons-portfolio',
    'show_in_rest' => true,
  ]);

  // Teams
  register_post_type('teams', [
    'labels'       => meu_tema_get_cpt_labels('Teams', 'Team'),
    'description'  => __('Nosso time de especialistas.', 'textdomain'),
    'public'       => true,
    'has_archive'  => true,
    'rewrite'      => ['slug' => 'teams'],
    'supports'     => ['title'], // Pode adicionar 'editor', 'thumbnail' etc.
    'menu_icon'    => 'dashicons-businessman',
    'show_in_rest' => true,
  ]);

  // Blog
  register_post_type('blogs', [
    'labels'       => meu_tema_get_cpt_labels('Blog', 'Blogs'),
    'description'  => __('Posts do blog sobre diversos temas.', 'textdomain'),
    'public'       => true,
    'has_archive'  => true,
    'rewrite'      => ['slug' => 'blogs'],
    'supports'     => ['title'], // Pode adicionar 'editor', 'thumbnail' etc.
    'menu_icon'    => 'dashicons-welcome-write-blog',
    'show_in_rest' => true,
  ]);

  // Banners
  register_post_type('banners', [
    'labels'       => meu_tema_get_cpt_labels('Banner', 'Banners'),
    'description'  => __('Banners promocionais e publicitários do site.', 'textdomain'),
    'public'       => true,
    'has_archive'  => true,
    'rewrite'      => ['slug' => 'banners'],
    'supports'     => ['title'], // Pode adicionar 'editor', 'thumbnail' etc.
    'menu_icon'    => 'dashicons-images-alt2',
    'show_in_rest' => true,
  ]);

  // Contatos
  register_post_type('contatos', [
    'labels'       => meu_tema_get_cpt_labels('Contato', 'Contatos'),
    'description'  => __('Informações de contato e localização da empresa.', 'textdomain'),
    'public'       => true,
    'has_archive'  => true,
    'rewrite'      => ['slug' => 'contatos'],
    'supports'     => ['title'], // Pode adicionar 'editor', 'thumbnail' etc.
    'menu_icon'    => 'dashicons-location',
    'show_in_rest' => true,
  ]);

  // Trabalhe Conosco
  register_post_type('trabalhe-conosco', [
    'labels'       => meu_tema_get_cpt_labels('Oportunidade', 'Trabalhe Conosco'),
    'description'  => __('Oportunidades de trabalho e vagas disponíveis.', 'textdomain'),
    'public'       => true,
    'has_archive'  => true,
    'rewrite'      => ['slug' => 'trabalhe-conosco'],
    'supports'     => ['title'], // Pode adicionar 'editor', 'thumbnail' etc.
    'menu_icon'    => 'dashicons-businessman',
    'show_in_rest' => true,
  ]);

  // Serviços
  register_post_type('servicos', [
    'labels'       => meu_tema_get_cpt_labels('Serviço', 'Serviços'),
    'description'  => __('Serviços oferecidos pela empresa.', 'textdomain'),
    'public'       => true,
    'has_archive'  => true,
    'rewrite'      => ['slug' => 'servicos'],
    'supports'     => ['title'], // Pode adicionar 'editor', 'thumbnail' etc.
    'menu_icon'    => 'dashicons-admin-tools',
    'show_in_rest' => true,
  ]);
}
add_action('init', 'meu_tema_registrar_cpts');
