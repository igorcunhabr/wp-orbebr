<?php

/**
 * Template Part para registro de Custom Post Types (CPTs).
 */

// ===================================================================
// [CLASSE PARA GERENCIAMENTO DE CPTs]
// Centraliza o registro de Custom Post Types de forma organizada
// ===================================================================

class CustomPostTypes
{

  /**
   * Configurações padrão dos CPTs
   */
  private static $default_config = [
    'public'       => true,
    'has_archive'  => true,
    'show_in_rest' => true,
    'supports'     => ['title'],
  ];

  /**
   * Lista de CPTs do tema
   */
  private static $post_types = [
    'clientes' => [
      'singular' => 'Cliente',
      'plural'   => 'Clientes',
      'slug'     => 'clientes',
      'icon'     => 'dashicons-groups',
      'description' => 'Gerenciamento de clientes da empresa.',
    ],
    'certificacoes' => [
      'singular' => 'Certificação',
      'plural'   => 'Certificações',
      'slug'     => 'certificacoes',
      'icon'     => 'dashicons-awards',
      'description' => 'Certificações e credenciais da empresa.',
    ],
    'cases' => [
      'singular' => 'Case',
      'plural'   => 'Cases',
      'slug'     => 'cases',
      'icon'     => 'dashicons-portfolio',
      'description' => 'Cases de sucesso e projetos realizados.',
    ],
    'teams' => [
      'singular' => 'Teams',
      'plural'   => 'Team',
      'slug'     => 'teams',
      'icon'     => 'dashicons-businessman',
      'description' => 'Nosso time de especialistas.',
    ],
    'blogs' => [
      'singular' => 'Blog',
      'plural'   => 'Blogs',
      'slug'     => 'blogs',
      'icon'     => 'dashicons-welcome-write-blog',
      'description' => 'Posts do blog sobre diversos temas.',
    ],
    'banners' => [
      'singular' => 'Banner',
      'plural'   => 'Banners',
      'slug'     => 'banners',
      'icon'     => 'dashicons-images-alt2',
      'description' => 'Banners promocionais e publicitários do site.',
    ],
    'contatos' => [
      'singular' => 'Contato',
      'plural'   => 'Contatos',
      'slug'     => 'contatos',
      'icon'     => 'dashicons-location',
      'description' => 'Informações de contato e localização da empresa.',
    ],
    'trabalhe-conosco' => [
      'singular' => 'Oportunidade',
      'plural'   => 'Trabalhe Conosco',
      'slug'     => 'trabalhe-conosco',
      'icon'     => 'dashicons-businessman',
      'description' => 'Oportunidades de trabalho e vagas disponíveis.',
    ],
    'servicos' => [
      'singular' => 'Serviço',
      'plural'   => 'Serviços',
      'slug'     => 'servicos',
      'icon'     => 'dashicons-admin-tools',
      'description' => 'Serviços oferecidos pela empresa.',
    ],
  ];

  /**
   * Gera labels para um CPT
   *
   * @param string $singular Nome no singular
   * @param string $plural   Nome no plural
   * @return array Array de labels
   */
  private static function get_cpt_labels($singular, $plural)
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

  /**
   * Registra um CPT individual
   *
   * @param string $post_type Nome do post type
   * @param array  $config    Configuração do CPT
   */
  private static function register_single_cpt($post_type, $config)
  {
    $args = array_merge(self::$default_config, [
      'labels'       => self::get_cpt_labels($config['singular'], $config['plural']),
      'description'  => __($config['description'], 'textdomain'),
      'rewrite'      => ['slug' => $config['slug']],
      'menu_icon'    => $config['icon'],
    ]);

    register_post_type($post_type, $args);
  }

  /**
   * Registra todos os CPTs do tema
   */
  public static function register_all_cpts()
  {
    foreach (self::$post_types as $post_type => $config) {
      self::register_single_cpt($post_type, $config);
    }
  }

  /**
   * Obtém a lista de CPTs registrados
   *
   * @return array Lista de CPTs
   */
  public static function get_post_types()
  {
    return array_keys(self::$post_types);
  }

  /**
   * Verifica se um post type existe
   *
   * @param string $post_type Nome do post type
   * @return bool True se existir
   */
  public static function post_type_exists($post_type)
  {
    return array_key_exists($post_type, self::$post_types);
  }

  /**
   * Obtém configuração de um CPT
   *
   * @param string $post_type Nome do post type
   * @return array|null Configuração ou null se não existir
   */
  public static function get_post_type_config($post_type)
  {
    return self::$post_types[$post_type] ?? null;
  }
}

// ===================================================================
// [REGISTRO DOS CPTs]
// Registra todos os Custom Post Types no WordPress
// ===================================================================

add_action('init', [CustomPostTypes::class, 'register_all_cpts']);

// ===================================================================
// [FUNÇÕES DE CONVENIÊNCIA]
// Funções globais para facilitar o uso dos CPTs
// ===================================================================

/**
 * Verifica se um post type existe
 */
function cpt_exists($post_type)
{
  return CustomPostTypes::post_type_exists($post_type);
}

/**
 * Obtém configuração de um CPT
 */
function get_cpt_config($post_type)
{
  return CustomPostTypes::get_post_type_config($post_type);
}

/**
 * Obtém lista de CPTs registrados
 */
function get_registered_cpts()
{
  return CustomPostTypes::get_post_types();
}
