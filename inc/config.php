<?php

/**
 * Template Part para configurações centralizadas do tema.
 */

// ===================================================================
// [CLASSE DE CONFIGURAÇÃO DO TEMA]
// Centraliza todas as configurações do tema
// ===================================================================

class ThemeConfig
{

    /**
     * Configurações gerais do tema
     */
    public static $theme_config = [
        'name' => 'WP Orbe BR',
        'version' => '1.0.0',
        'text_domain' => 'textdomain',
        'debug' => false,
    ];

    /**
     * Configurações de assets
     */
    public static $assets_config = [
        'styles' => [
            'swiper-style' => [
                'src' => '/assets/css/swiper.min.css',
                'deps' => [],
            ],
            'tailwind-custom' => [
                'src' => '/assets/css/tailwind-custom.css',
                'deps' => [],
            ],
        ],
        'scripts' => [
            'swiper-script' => [
                'file' => 'swiper.min.js',
                'deps' => [],
            ],
            'fslightbox-script' => [
                'file' => 'fslightbox.js',
                'deps' => [],
            ],
            'svg-inject-script' => [
                'file' => 'svg-inject.min.js',
                'deps' => [],
            ],
            'scrollreveal-script' => [
                'file' => 'scrollreveal.min.js',
                'deps' => [],
            ],
            'custom-script' => [
                'file' => 'scripts.js',
                'deps' => ['swiper-script', 'fslightbox-script', 'svg-inject-script', 'scrollreveal-script'],
            ],
        ],
    ];

    /**
     * Configurações de menus
     */
    public static $menus_config = [
        'nav-header' => 'Menu Principal',
        'nav-footer' => 'Menu Rodapé',
    ];

    /**
     * Configurações de redes sociais
     */
    public static $social_networks_config = [
        ['field' => 'config_instagram', 'icon' => 'icon-social-instagram.svg', 'label' => 'Instagram'],
        ['field' => 'config_facebook',  'icon' => 'icon-social-facebook.svg', 'label' => 'Facebook'],
        ['field' => 'config_tiktok',   'icon' => 'icon-social-tiktok.svg', 'label' => 'Tiktok'],
        ['field' => 'config_pinterest', 'icon' => 'icon-social-pinterest.svg', 'label' => 'Pinterest'],
        ['field' => 'config_linkedin', 'icon' => 'icon-social-linkedin.svg', 'label' => 'Linkedin'],
        ['field' => 'config_behance',  'icon' => 'icon-social-behance.svg', 'label' => 'Behance'],
        ['field' => 'config_youtube',  'icon' => 'icon-social-youtube.svg', 'label' => 'YouTube'],
        ['field' => 'icon-social-spotify.svg', 'label' => 'Spotify'],
    ];

    /**
     * Configurações de posts por página
     */
    public static $posts_per_page_config = [
        'comunidades' => 4,
        'livros'      => 8,
        'blogs'       => 8,
        'cases'       => 6,
        'servicos'    => 6,
        'clientes'    => 12,
        'certificacoes' => 12,
        'teams'       => 8,
        'banners'     => 10,
    ];

    /**
     * Configurações de ordenação
     */
    public static $order_config = [
        'servicos' => [
            'orderby'  => 'meta_value_num',
            'meta_key' => 'ordem'
        ],
        'banners' => [
            'orderby' => 'date',
            'order'   => 'ASC'
        ],
    ];

    /**
     * Configurações de SEO
     */
    public static $seo_config = [
        'default_title' => '',
        'default_description' => '',
        'default_image' => '',
        'twitter_card' => 'summary_large_image',
        'og_type' => 'website',
    ];

    /**
     * Configurações de upload
     */
    public static $upload_config = [
        'allowed_svg_tags' => [
            'svg',
            'path',
            'circle',
            'rect',
            'polygon',
            'line',
            'text',
            'g'
        ],
        'dangerous_svg_tags' => [
            'script',
            'object',
            'embed',
            'iframe',
            'link',
            'meta',
            'title',
            'desc'
        ],
        'dangerous_svg_attributes' => [
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
        ],
    ];

    /**
     * Obtém configuração do tema
     *
     * @param string $key Chave da configuração
     * @param mixed  $default Valor padrão
     * @return mixed Valor da configuração
     */
    public static function get($key, $default = null)
    {
        $keys = explode('.', $key);
        $config = self::$theme_config;

        foreach ($keys as $k) {
            if (isset($config[$k])) {
                $config = $config[$k];
            } else {
                return $default;
            }
        }

        return $config;
    }

    /**
     * Define configuração do tema
     *
     * @param string $key Chave da configuração
     * @param mixed  $value Valor da configuração
     */
    public static function set($key, $value)
    {
        $keys = explode('.', $key);
        $config = &self::$theme_config;

        foreach ($keys as $k) {
            if (!isset($config[$k])) {
                $config[$k] = [];
            }
            $config = &$config[$k];
        }

        $config = $value;
    }

    /**
     * Obtém configuração de assets
     *
     * @param string $type Tipo de asset (styles|scripts)
     * @return array Configuração de assets
     */
    public static function get_assets_config($type)
    {
        return self::$assets_config[$type] ?? [];
    }

    /**
     * Obtém configuração de menus
     *
     * @return array Configuração de menus
     */
    public static function get_menus_config()
    {
        return self::$menus_config;
    }

    /**
     * Obtém configuração de redes sociais
     *
     * @return array Configuração de redes sociais
     */
    public static function get_social_networks_config()
    {
        return self::$social_networks_config;
    }

    /**
     * Obtém configuração de posts por página
     *
     * @return array Configuração de posts por página
     */
    public static function get_posts_per_page_config()
    {
        return self::$posts_per_page_config;
    }

    /**
     * Obtém configuração de ordenação
     *
     * @return array Configuração de ordenação
     */
    public static function get_order_config()
    {
        return self::$order_config;
    }

    /**
     * Obtém configuração de SEO
     *
     * @return array Configuração de SEO
     */
    public static function get_seo_config()
    {
        return self::$seo_config;
    }

    /**
     * Obtém configuração de upload
     *
     * @return array Configuração de upload
     */
    public static function get_upload_config()
    {
        return self::$upload_config;
    }

    /**
     * Verifica se o debug está ativo
     *
     * @return bool True se debug ativo
     */
    public static function is_debug()
    {
        return self::get('debug', false) || (defined('WP_DEBUG') && WP_DEBUG);
    }

    /**
     * Obtém versão do tema
     *
     * @return string Versão do tema
     */
    public static function get_version()
    {
        return self::get('version', '1.0.0');
    }

    /**
     * Obtém nome do tema
     *
     * @return string Nome do tema
     */
    public static function get_name()
    {
        return self::get('name', 'WP Theme');
    }

    /**
     * Obtém text domain
     *
     * @return string Text domain
     */
    public static function get_text_domain()
    {
        return self::get('text_domain', 'textdomain');
    }
}

// ===================================================================
// [FUNÇÕES DE CONVENIÊNCIA]
// Funções globais para facilitar o acesso às configurações
// ===================================================================

/**
 * Obtém configuração do tema
 */
function theme_config($key, $default = null)
{
    return ThemeConfig::get($key, $default);
}

/**
 * Define configuração do tema
 */
function set_theme_config($key, $value)
{
    ThemeConfig::set($key, $value);
}

/**
 * Verifica se debug está ativo
 */
function is_theme_debug()
{
    return ThemeConfig::is_debug();
}

/**
 * Obtém versão do tema
 */
function get_theme_version()
{
    return ThemeConfig::get_version();
}
