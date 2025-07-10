# Componente de Paginação Reutilizável

Este componente foi criado para centralizar e padronizar a paginação em todo o tema WordPress.

## 📁 Arquivos Criados

- `template-parts/pagination.php` - Componente completo com mais opções
- `template-parts/pagination-simple.php` - Versão simplificada (recomendada)
- `inc/helpers.php` - Funções helper adicionadas

## 🚀 Como Usar

### Método 1: Função Helper (Recomendado)

```php
// Usando a query principal
renderizar_paginacao();

// Usando uma query específica
renderizar_paginacao($minha_query);

// Com argumentos personalizados
renderizar_paginacao($minha_query, [
    'prev_text' => '← Anterior',
    'next_text' => 'Próximo →'
]);
```

### Método 2: Template Part Direto

```php
// Usando a query principal
get_template_part('template-parts/pagination', 'simple');

// Passando uma query específica
get_template_part('template-parts/pagination', 'simple', [
    'query' => $minha_query
]);
```

### Método 3: Verificação Condicional

```php
// Verifica se deve exibir paginação
if (deve_exibir_paginacao($minha_query)) {
    renderizar_paginacao($minha_query);
}
```

## 📋 Arquivos Atualizados

Os seguintes arquivos foram atualizados para usar o novo componente:

- `archive-blogs.php`
- `archive-clientes.php`
- `archive-cases.php`
- `archive-certificacoes.php`
- `archive-teams.php`

## 🎨 Personalização

### Argumentos Disponíveis

```php
$args = [
    'prev_text' => '&laquo; Anterior',     // Texto do botão anterior
    'next_text' => 'Próximo &raquo;',      // Texto do botão próximo
    'type'      => 'list',                 // Tipo de saída (list, array, plain)
    'show_all'  => false,                  // Mostrar todos os números
    'end_size'  => 1,                      // Números no início/fim
    'mid_size'  => 2,                      // Números no meio
    'add_args'  => [],                     // Argumentos extras na URL
    'add_fragment' => '',                  // Fragmento da URL
    'before_page_number' => '',            // Texto antes do número
    'after_page_number'  => '',           // Texto depois do número
];
```

### Estilos CSS

O componente usa as classes CSS já definidas em `assets/css/tailwind-custom.css`:

```css
.pagination {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.pagination a,
.pagination span {
  /* Estilos dos links e números */
}

.pagination .current {
  /* Estilo da página atual */
}
```

## 🔧 Funcionalidades

### ✅ Recursos Implementados

- **Detecção automática**: Usa a query principal se nenhuma for fornecida
- **Verificação inteligente**: Só exibe se há mais de uma página
- **Debug para administradores**: Informações de debug apenas para admins
- **Acessibilidade**: Labels ARIA apropriados
- **Internacionalização**: Textos traduzíveis
- **Flexibilidade**: Aceita queries customizadas e argumentos personalizados

### 🎯 Benefícios

1. **DRY (Don't Repeat Yourself)**: Código centralizado e reutilizável
2. **Manutenibilidade**: Mudanças em um lugar afetam todo o site
3. **Consistência**: Mesmo visual e comportamento em todas as páginas
4. **Flexibilidade**: Fácil personalização por página
5. **Performance**: Código otimizado e eficiente

## 📝 Exemplos de Uso

### Exemplo Básico

```php
<?php
$query = criar_query_otimizada('blogs', 8, ['paged' => get_query_var('paged')]);

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        get_template_part('template-parts/content/card', 'blog');
    }
}

// Renderiza a paginação
renderizar_paginacao($query);
?>
```

### Exemplo com Personalização

```php
<?php
// Paginação personalizada para uma seção específica
renderizar_paginacao($query, [
    'prev_text' => '← Voltar',
    'next_text' => 'Avançar →',
    'mid_size'  => 3,
    'end_size'  => 2
]);
?>
```

### Exemplo com Verificação

```php
<?php
// Só exibe paginação se necessário
if (deve_exibir_paginacao($query)) {
    renderizar_paginacao($query);
}
?>
```

## 🐛 Debug

Para administradores com `WP_DEBUG` ativado, o componente exibe informações de debug:

```html
<!-- Debug: Total de páginas: 5, Página atual: 2 -->
```

## 📚 Referências

- [WordPress paginate_links()](https://developer.wordpress.org/reference/functions/paginate_links/)
- [WordPress WP_Query](https://developer.wordpress.org/reference/classes/wp_query/)
