# WP OrbeBR - Tema WordPress

Tema WordPress personalizado para a OrbeBR, desenvolvido com foco em performance, acessibilidade e manutenibilidade.

## 🚀 Funcionalidades Implementadas

### 📝 Sistema de Blog

- **Post Type Personalizado**: `blogs` com suporte completo ao WordPress
- **Página de Arquivo**: `archive-blogs.php` com listagem responsiva
- **Cards Personalizados**: Template `card-blog.php` com design moderno
- **Paginação**: Sistema de paginação com 8 posts por página
- **Busca em Tempo Real**: Funcionalidade JavaScript para filtrar posts instantaneamente

### 🎨 Design System

- **Tailwind CSS**: Framework CSS utilitário para desenvolvimento rápido
- **Fontes Customizadas**: Filson Pro (Light, Regular, Book, Medium)
- **Cores Personalizadas**: Paleta de cores definida no tema
- **Componentes Reutilizáveis**: Cards, botões, formulários padronizados

### 📱 Responsividade

- **Mobile First**: Design otimizado para dispositivos móveis
- **Grid Responsivo**: Layout adaptativo para diferentes tamanhos de tela
- **Menu Mobile**: Navegação otimizada para touch

### ⚡ Performance

- **Lazy Loading**: Carregamento otimizado de imagens
- **Debounce**: Controle de frequência em buscas
- **Animações CSS**: Transições suaves e performáticas

## 📁 Estrutura do Projeto

```
wp-orbebr/
├── assets/
│   ├── css/
│   │   ├── tailwind-custom.css    # Estilos customizados
│   │   └── swiper.min.css         # CSS do Swiper
│   ├── js/
│   │   ├── scripts.js             # Scripts principais
│   │   └── animations.js          # Animações
│   ├── fonts/                     # Fontes customizadas
│   └── img/                       # Imagens e ícones
├── inc/
│   ├── custom-post-types.php      # Registro de CPTs
│   ├── queries.php                # Configurações de query
│   └── assets.php                 # Carregamento de assets
├── template-parts/
│   └── content/
│       └── card-blog.php          # Template do card de blog
├── archive-blogs.php              # Página de arquivo do blog
└── functions.php                  # Arquivo principal do tema
```

## 🛠️ Como Usar

### 1. Criar Posts do Blog

1. Acesse o painel administrativo do WordPress
2. Vá para "Blogs" no menu lateral
3. Clique em "Adicionar Novo"
4. Preencha o título e conteúdo
5. Adicione uma imagem em destaque (opcional)
6. Publique o post

### 2. Personalizar o Design

- Edite `assets/css/tailwind-custom.css` para modificar estilos
- Ajuste cores e fontes nas variáveis CSS
- Modifique componentes no arquivo de estilos

### 3. Adicionar Funcionalidades

- Novos scripts em `assets/js/scripts.js`
- Novos post types em `inc/custom-post-types.php`
- Novos templates em `template-parts/`

## 🎯 Funcionalidades do Blog

### Busca em Tempo Real

- Campo de busca funcional na página de arquivo
- Filtragem instantânea por título e conteúdo
- Debounce de 300ms para otimizar performance
- Mensagem de "nenhum resultado" quando necessário

### Paginação

- 8 posts por página
- Navegação intuitiva
- Estilos personalizados para botões

### Cards Responsivos

- Layout em grid adaptativo
- Hover effects suaves
- Suporte a imagens em destaque
- Fallback para posts sem imagem

## 🔧 Configurações

### Post Type "Blogs"

```php
// Configurações do post type
'public'       => true,
'has_archive'  => true,
'rewrite'      => ['slug' => 'blogs'],
'supports'     => ['title', 'editor', 'thumbnail'],
'posts_per_page' => 8
```

### Estilos da Paginação

```css
.pagination {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}
```

## 📈 Próximos Passos

1. **Implementar SEO Avançado**: Meta tags, schema markup
2. **Adicionar Categorias**: Sistema de categorização para posts
3. **Comentários**: Sistema de comentários personalizado
4. **Cache**: Implementar cache para melhor performance
5. **Analytics**: Integração com Google Analytics

## 🤝 Contribuição

Para contribuir com o projeto:

1. Faça um fork do repositório
2. Crie uma branch para sua feature
3. Implemente as mudanças
4. Teste em diferentes dispositivos
5. Envie um pull request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo LICENSE para mais detalhes.
