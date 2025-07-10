# WP OrbeBR - Tema WordPress

Tema WordPress personalizado para a OrbeBR, desenvolvido com foco em performance, escalabilidade, acessibilidade e manutenibilidade.

---

## 🚀 Visão Geral

Este tema foi totalmente refatorado para adotar uma arquitetura moderna, orientada a objetos e baseada em helpers reutilizáveis. O código está padronizado, seguro, pronto para internacionalização e fácil de manter e evoluir.

### ✨ Principais Características

- **Arquitetura Orientada a Objetos**: Classes organizadas para configuração, helpers, queries e SEO
- **Configuração Centralizada**: Todas as configurações do tema em um único local
- **Helpers Reutilizáveis**: Funções auxiliares para operações comuns
- **SEO Dinâmico**: Sistema avançado de SEO com meta tags automáticas
- **Sistema de Títulos Dinâmicos**: 4 níveis de prioridade para títulos de páginas
- **Componentização**: Cards e partes do layout organizados em template-parts
- **Segurança**: Sanitização de dados e proteção contra vulnerabilidades
- **Performance**: Queries otimizadas e assets organizados

---

## 🏗️ Estrutura do Projeto

```
wp-orbebr/
├── assets/
│   ├── css/
│   │   ├── swiper.min.css
│   │   └── tailwind-custom.css
│   ├── js/
│   │   ├── swiper.min.js
│   │   ├── fslightbox.js
│   │   ├── svg-inject.min.js
│   │   ├── scrollreveal.min.js
│   │   └── scripts.js
│   ├── fonts/
│   │   ├── FilsonProBook.woff2
│   │   ├── FilsonProLight.woff2
│   │   ├── FilsonProMedium.woff2
│   │   └── FilsonProRegular.woff2
│   └── img/
│       ├── logo.svg
│       ├── favicon.png
│       ├── bg-body.png
│       ├── bg-section.png
│       └── icons/
├── inc/
│   ├── config.php              # Configuração centralizada do tema
│   ├── helpers.php             # Helpers e utilitários globais
│   ├── queries.php             # Helpers para queries WordPress
│   ├── custom-post-types.php   # Registro de Custom Post Types
│   ├── seo.php                 # SEO dinâmico e meta tags
│   ├── assets.php              # Gerenciamento de CSS/JS
│   ├── cleanup.php             # Limpeza e otimizações
│   ├── uploads.php             # Configurações de upload
│   ├── editor.php              # Personalização do editor
│   ├── menus.php               # Registro de menus
│   └── acf-options.php         # Configurações ACF
├── template-parts/
│   ├── content/
│   │   ├── card-blog.php
│   │   ├── card-cases.php
│   │   ├── card-certificacoes.php
│   │   ├── card-clientes.php
│   │   └── card-team.php
│   ├── header/
│   │   └── site-header.php
│   ├── header-internal/
│   │   └── site-header-internal.php
│   ├── footer/
│   │   └── site-footer.php
│   └── pagination/
│       ├── pagination.php
│       ├── pagination-simple.php
│       └── exemplo-paginacao.php
├── archive-blogs.php
├── archive-cases.php
├── archive-certificacoes.php
├── archive-clientes.php
├── archive-teams.php
├── single-blogs.php
├── single-cases.php
├── page-home.php
├── 404.php
├── header.php
├── footer.php
├── functions.php
└── style.css
```

---

## 🧩 Arquitetura e Classes Principais

### 1. **ThemeConfig** (`inc/config.php`)

Classe centralizada para todas as configurações do tema:

```php
// Configurações gerais
ThemeConfig::$theme_config

// Configurações de assets (CSS/JS)
ThemeConfig::$assets_config

// Configurações de menus
ThemeConfig::$menus_config

// Configurações de redes sociais
ThemeConfig::$social_networks_config

// Configurações de posts por página
ThemeConfig::$posts_per_page_config

// Configurações de SEO
ThemeConfig::$seo_config
```

### 2. **ThemeHelpers** (`inc/helpers.php`)

Classe com funções auxiliares reutilizáveis:

- `obter_imagem_post()` - Imagem com fallback inteligente
- `obter_campo_acf()` - Campo ACF com fallback seguro
- `criar_query()` - Query WordPress otimizada
- `obter_redes_sociais()` - Links de redes sociais organizados
- `renderizar_paginacao()` - Paginação padronizada
- `definir_titulo_pagina()` - Sistema de títulos dinâmicos
- `montar_link_whatsapp()` - Link WhatsApp com ACF

### 3. **ThemeQueries** (`inc/queries.php`)

Classe especializada em queries WordPress:

- `criar_query_otimizada()` - Query com performance otimizada
- `obter_posts_por_tipo()` - Posts por tipo com configurações
- `obter_posts_relacionados()` - Posts relacionados
- `obter_posts_em_destaque()` - Posts em destaque

### 4. **ThemeSEO** (`inc/seo.php`)

Classe para SEO dinâmico:

- Meta tags automáticas
- Open Graph e Twitter Cards
- Títulos e descrições dinâmicas
- Imagens SEO automáticas

### 5. **CustomPostTypes** (`inc/custom-post-types.php`)

Classe para gerenciamento de CPTs:

**CPTs Registrados:**

- `clientes` - Clientes da empresa
- `certificacoes` - Certificações e credenciais
- `cases` - Cases de sucesso
- `teams` - Time de especialistas
- `blogs` - Posts do blog
- `banners` - Banners promocionais
- `contatos` - Informações de contato
- `trabalhe-conosco` - Oportunidades de trabalho
- `servicos` - Serviços oferecidos

---

## 🎯 Sistema de Títulos Dinâmicos

O tema possui um sistema avançado de títulos dinâmicos com **4 níveis de prioridade**:

### 1. **Variável Global** (maior prioridade)

```php
ThemeHelpers::definir_titulo_pagina('Título Personalizado');
```

### 2. **Campo ACF 'titulo_pagina'**

Configurado via ACF no painel WordPress

### 3. **Campo ACF 'titulo_header'**

Configurado via ACF no painel WordPress

### 4. **Título automático** (fallback)

Título da página/post automaticamente

### Exemplos de Uso:

```php
// Programaticamente
if (is_page('sobre')) {
    ThemeHelpers::definir_titulo_pagina('Nossa História e Valores');
}

if (is_post_type_archive('blogs')) {
    ThemeHelpers::definir_titulo_pagina('Blog e Artigos');
}
```

---

## 🛠️ Como Manter e Evoluir

### 1. **Adicionar/Alterar Custom Post Types**

Edite `inc/custom-post-types.php` e adicione no array `$post_types`:

```php
'meu_cpt' => [
    'singular' => 'Meu Item',
    'plural'   => 'Meus Itens',
    'slug'     => 'meus-itens',
    'icon'     => 'dashicons-admin-generic',
    'description' => 'Descrição do CPT.',
],
```

### 2. **Criar/Editar Cards e Componentes**

Crie novos arquivos em `template-parts/content/` seguindo o padrão:

```php
<?php
// Sempre use helpers para dados
$imagem = ThemeHelpers::obter_imagem_post($post->ID);
$titulo = ThemeHelpers::sanitizar_dados(get_the_title());
?>
```

### 3. **Adicionar Novos Campos ACF**

Use sempre os helpers:

```php
$valor = ThemeHelpers::obter_campo_acf('meu_campo', $post_id);
```

### 4. **Configurar Assets (CSS/JS)**

Adicione no array `$assets_config` em `inc/config.php`:

```php
'styles' => [
    'meu-css' => [
        'src' => '/assets/css/meu-arquivo.css',
        'deps' => [],
    ],
],
'scripts' => [
    'meu-js' => [
        'file' => 'meu-arquivo.js',
        'deps' => [],
    ],
],
```

### 5. **Configurar Redes Sociais**

Edite o array `$social_networks_config` em `inc/config.php`:

```php
['field' => 'config_minha_rede', 'icon' => 'icon-minha-rede.svg', 'label' => 'Minha Rede'],
```

### 6. **Criar Queries Otimizadas**

Use os helpers de query:

```php
$query = ThemeQueries::criar_query_otimizada('meu_cpt', 8, [
    'meta_query' => [
        [
            'key' => 'destaque',
            'value' => '1',
            'compare' => '='
        ]
    ]
]);
```

### 7. **SEO Dinâmico**

Configure campos ACF para SEO:

- `titulo_seo` - Título da página
- `descricao_seo` - Meta description
- `imagem_seo` - Imagem para redes sociais

---

## 💡 Dicas de Manutenção

### ✅ **Boas Práticas**

- **Sempre use helpers**: Evite duplicação de código
- **Sanitize dados**: Use `ThemeHelpers::sanitizar_dados()`
- **Configure centralmente**: Use `ThemeConfig` para configurações
- **Mantenha arquivos pequenos**: Quebre em partes se necessário
- **Use fallbacks**: Sempre forneça alternativas para dados

### ❌ **Evite**

- **Editar helpers sem revisar dependências**
- **Duplicar código existente**
- **Usar funções depreciadas do WordPress**
- **Hardcode de valores**
- **Arquivos com mais de 500-800 linhas**

### 🔧 **Debug e Desenvolvimento**

```php
// Verificar configurações
ThemeConfig::get('theme_config.name');

// Debug mode
ThemeConfig::is_debug();

// Obter versão
ThemeConfig::get_version();
```

---

## 📈 Próximos Passos Sugeridos

1. **Implementar cache para queries frequentes**
2. **Adicionar testes automatizados para helpers**
3. **Criar documentação inline para classes**
4. **Implementar sistema de cache para títulos dinâmicos**
5. **Adicionar hooks e filtros customizados**
6. **Expandir sistema de SEO para mais meta tags**
7. **Criar guia de estilos para componentes**

---

## 🤝 Contribuição

1. Faça um fork do repositório
2. Crie uma branch para sua feature
3. Implemente as mudanças seguindo o padrão do tema
4. Teste em diferentes dispositivos e cenários
5. Envie um pull request

---

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo LICENSE para mais detalhes.
