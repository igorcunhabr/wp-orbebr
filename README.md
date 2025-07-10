# WP OrbeBR - Tema WordPress

Tema WordPress personalizado para a OrbeBR, desenvolvido com foco em performance, escalabilidade, acessibilidade e manutenibilidade.

---

## 🚀 Visão Geral

Este tema foi totalmente refatorado para adotar uma arquitetura moderna, orientada a objetos e baseada em helpers reutilizáveis. O código está padronizado, seguro, pronto para internacionalização e fácil de manter e evoluir.

---

## 🏗️ Estrutura do Projeto

```
wp-orbebr/
├── assets/
│   ├── css/
│   ├── js/
│   ├── fonts/
│   └── img/
├── inc/
│   ├── acf-options.php
│   ├── assets.php
│   ├── cleanup.php
│   ├── config.php         # Configuração centralizada do tema
│   ├── custom-post-types.php
│   ├── editor.php
│   ├── helpers.php        # Helpers e utilitários globais
│   ├── menus.php
│   ├── queries.php        # Helpers para queries WP
│   ├── seo.php            # SEO dinâmico
│   ├── uploads.php
├── template-parts/
│   ├── content/
│   │   ├── card-blog.php
│   │   ├── card-cases.php
│   │   ├── card-certificacoes.php
│   │   ├── card-clientes.php
│   │   └── card-team.php
│   ├── footer/
│   ├── header/
│   └── header-internal/
├── 404.php
├── archive-blogs.php
├── archive-cases.php
├── archive-certificacoes.php
├── archive-clientes.php
├── archive-teams.php
├── footer.php
├── functions.php
├── header.php
├── page-home.php
├── single-blogs.php
├── single-cases.php
├── style.css
└── ...
```

---

## 🧩 Arquitetura e Boas Práticas

- **Helpers e Classes**: Toda a lógica de negócio e utilitários está centralizada em helpers (`inc/helpers.php`, `inc/queries.php`, etc.) e classes (`ThemeHelpers`, `ThemeQueries`, `ThemeSEO`, `ThemeConfig`, etc.), facilitando reuso e manutenção.
- **Configuração Centralizada**: O arquivo `inc/config.php` concentra todas as configurações do tema (assets, menus, SEO, etc.), tornando fácil alterar comportamentos globais.
- **Internacionalização**: Todos os textos fixos usam funções de tradução (`__()`, `_e()`, etc.), prontos para multi-idioma.
- **Sanitização e Segurança**: Todos os dados vindos do banco, ACF ou usuário são sanitizados com `esc_html`, `esc_url`, `esc_attr`, `wp_kses_post`.
- **Fallbacks Inteligentes**: Imagens e campos sempre têm fallback para evitar quebras visuais.
- **Paginação Padronizada**: Uso de `paginate_links` para melhor acessibilidade e SEO.
- **Evita Funções Depreciadas**: Não utiliza `query_posts` ou práticas antigas do WP.
- **Componentização**: Todos os cards e partes do layout estão em `template-parts/` para fácil reuso.

---

## 🛠️ Como Manter e Evoluir

### 1. **Adicionar/Alterar Custom Post Types**

- Edite `inc/custom-post-types.php` e adicione/ajuste no array de configuração da classe `CustomPostTypes`.
- Use os helpers para criar queries: `criar_query_otimizada('meu_cpt', 8, [...])`.

### 2. **Criar/Editar Cards e Componentes**

- Crie novos arquivos em `template-parts/content/` seguindo o padrão dos cards existentes.
- Sempre use os helpers para imagens e campos ACF.
- Sanitizar todos os dados exibidos.

### 3. **Adicionar Novos Campos ACF**

- Registre campos normalmente pelo painel ACF.
- Use os helpers: `obter_campo_acf('meu_campo', $post_id)`.

### 4. **Internacionalização**

- Para qualquer texto fixo, use `__('Texto', 'textdomain')` ou `_e('Texto', 'textdomain')`.
- Adicione arquivos `.po/.mo` para novos idiomas.

### 5. **SEO**

- O SEO dinâmico está em `inc/seo.php` e pode ser customizado facilmente.
- Use campos ACF para títulos, descrições e imagens SEO.

### 6. **Sistema de Títulos Dinâmicos**

O tema possui um sistema avançado de títulos dinâmicos para o header interno, com **4 níveis de prioridade**:

1. **Variável Global** (maior prioridade) - Definida programaticamente
2. **Campo ACF 'titulo_pagina'** - Configurado via ACF
3. **Campo ACF 'titulo_header'** - Configurado via ACF
4. **Título automático** (fallback) - Título da página/post

#### Métodos de Definição:

**Programaticamente:**

```php
// No início de qualquer template
ThemeHelpers::definir_titulo_pagina('Seu Título Personalizado');

// Exemplos práticos:
if (is_page('sobre')) {
    ThemeHelpers::definir_titulo_pagina('Nossa História e Valores');
}

if (is_post_type_archive('blogs')) {
    ThemeHelpers::definir_titulo_pagina('Blog e Artigos');
}
```

**Via ACF:**

- Configure campos `titulo_pagina` ou `titulo_header` no ACF
- Tipo: Text
- Localização: Post Type = Page

#### Fallbacks Automáticos:

- **Páginas 404:** "Página não encontrada"
- **Páginas de busca:** "Resultados da busca"
- **Archives:** Título limpo (sem prefixos WordPress)
- **Singles:** Título do post
- **Páginas:** Título da página

#### Limpeza Automática:

O sistema remove automaticamente prefixos WordPress como "Arquivos:", "Categoria:", "Tag:", etc.

### 7. **Assets (CSS/JS)**

- Adicione novos arquivos em `assets/css` ou `assets/js`.
- Registre no array de configuração em `inc/assets.php` ou `inc/config.php`.

### 8. **Paginação**

- Use sempre `paginate_links` para navegação entre páginas.

### 9. **Fallbacks de Imagem**

- Sempre forneça um fallback ao usar `obter_imagem_post`.

---

## 💡 Dicas de Manutenção

- **Nunca edite funções helpers diretamente sem revisar dependências.**
- **Evite duplicação de código:** sempre procure por helpers ou funções já existentes antes de criar novas.
- **Mantenha os arquivos de template pequenos:** se um arquivo crescer demais, quebre em partes menores em `template-parts/`.
- **Sempre sanitize dados antes de exibir.**
- **Prefira soluções simples e diretas.**
- **Comente trechos complexos para facilitar manutenção futura.**
- **Antes de atualizar dependências, teste em ambiente de homologação.**
- **Para títulos dinâmicos:** use sempre `ThemeHelpers::definir_titulo_pagina()` no início dos templates.

---

## 📈 Próximos Passos Sugeridos

1. **Implementar testes automatizados para helpers e classes.**
2. **Adicionar cache para queries frequentes.**
3. **Documentar helpers e classes no próprio código.**
4. **Criar um guia de estilos para componentes visuais.**
5. **Adicionar hooks e filtros customizados para extensibilidade.**
6. **Expandir o sistema de títulos dinâmicos para outros headers.**
7. **Implementar cache para títulos dinâmicos em páginas com muito tráfego.**

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
