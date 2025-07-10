# Sistema de Título Dinâmico para Header Interno

Este sistema permite definir manualmente o título que aparece no header interno das páginas, substituindo o texto "titulo da pagina" por um título personalizado.

## 🎯 Como Funciona

O sistema tem **4 níveis de prioridade** para definir o título:

1. **Variável Global** (maior prioridade) - Definida programaticamente
2. **Campo ACF 'titulo_pagina'** - Configurado via ACF
3. **Campo ACF 'titulo_header'** - Configurado via ACF
4. **Título automático** (fallback) - Título da página/post

## 📝 Métodos de Definição

### Método 1: Definição Programática

Use esta função no início de qualquer template:

```php
<?php
// No início do seu template (page.php, archive.php, etc.)
ThemeHelpers::definir_titulo_pagina('Seu Título Personalizado');
?>
```

**Exemplos práticos:**

```php
// Para página "Sobre"
if (is_page('sobre')) {
    ThemeHelpers::definir_titulo_pagina('Nossa História e Valores');
}

// Para archive de blogs
if (is_post_type_archive('blogs')) {
    ThemeHelpers::definir_titulo_pagina('Blog e Artigos');
}

// Para archive de cases
if (is_post_type_archive('cases')) {
    ThemeHelpers::definir_titulo_pagina('Cases de Sucesso');
}
```

### Método 2: Campos ACF

Configure estes campos no ACF para páginas específicas:

#### Campo: `titulo_pagina`

- **Tipo:** Text
- **Localização:** Post Type = Page
- **Posição:** Normal (acima do conteúdo)

#### Campo: `titulo_header`

- **Tipo:** Text
- **Localização:** Post Type = Page
- **Posição:** Normal (acima do conteúdo)

## 🔧 Implementação Atual

### Arquivos Modificados

1. **`template-parts/header-internal/site-header-internal.php`**

   - Sistema de título dinâmico implementado
   - Usa a função `ThemeHelpers::obter_titulo_pagina()`

2. **`inc/helpers.php`**

   - Adicionadas funções `definir_titulo_pagina()` e `obter_titulo_pagina()`
   - Sistema de fallback inteligente

3. **`archive-blogs.php`**

   - Título definido: "Blog e Artigos"

4. **`archive-cases.php`**
   - Título definido: "Cases de Sucesso"

### Funções Disponíveis

```php
// Define o título da página
ThemeHelpers::definir_titulo_pagina($titulo);

// Obtém o título da página (usado internamente)
ThemeHelpers::obter_titulo_pagina();
```

## 📋 Exemplos de Uso

### Para Páginas Simples (page.php)

```php
<?php
// No início do page.php
if (is_page('contato')) {
    ThemeHelpers::definir_titulo_pagina('Entre em Contato Conosco');
} elseif (is_page('sobre')) {
    ThemeHelpers::definir_titulo_pagina('Sobre Nós');
}
?>
```

### Para Archives (archive-\*.php)

```php
<?php
// No início do archive-blogs.php
ThemeHelpers::definir_titulo_pagina('Blog e Artigos');

// No início do archive-cases.php
ThemeHelpers::definir_titulo_pagina('Cases de Sucesso');

// No início do archive-clientes.php
ThemeHelpers::definir_titulo_pagina('Nossos Clientes');
?>
```

### Para Singles (single-\*.php)

```php
<?php
// No início do single-blogs.php
ThemeHelpers::definir_titulo_pagina('Artigo do Blog');

// No início do single-cases.php
ThemeHelpers::definir_titulo_pagina('Case de Sucesso');
?>
```

## 🎨 Fallbacks Automáticos

O sistema automaticamente define títulos para:

- **Páginas 404:** "Página não encontrada"
- **Páginas de busca:** "Resultados da busca"
- **Archives:** Título do archive (ex: "Blog", "Cases") - **sem prefixos WordPress**
- **Singles:** Título do post
- **Páginas:** Título da página

### 🔧 Limpeza Automática de Prefixos

O sistema automaticamente remove prefixos comuns do WordPress como:

- "Arquivos: " → "Blog"
- "Categoria: " → "Nome da Categoria"
- "Tag: " → "Nome da Tag"
- "Autor: " → "Nome do Autor"
- E outros prefixos em português e inglês

## 🔄 Como Adicionar em Novos Templates

1. **Adicione no início do template:**

```php
<?php ThemeHelpers::definir_titulo_pagina('Seu Título'); ?>
```

2. **Ou configure via ACF:**
   - Crie campos `titulo_pagina` ou `titulo_header`
   - O sistema detectará automaticamente

## ✅ Vantagens do Sistema

- ✅ **Flexibilidade:** Múltiplas formas de definir o título
- ✅ **Fallback inteligente:** Sempre há um título
- ✅ **Manutenível:** Centralizado nas funções helpers
- ✅ **Escalável:** Fácil de adicionar em novos templates
- ✅ **Compatível:** Funciona com ACF e sem ACF
- ✅ **Limpeza automática:** Remove prefixos WordPress automaticamente

## 🚀 Próximos Passos

1. **Adicionar títulos** nos outros archives (clientes, certificações, teams)
2. **Configurar campos ACF** para páginas específicas
3. **Testar** em diferentes tipos de página
4. **Documentar** casos de uso específicos

---

**Nota:** Os erros de linter são normais em ambiente de desenvolvimento WordPress, pois as funções são carregadas pelo WordPress em tempo de execução.
