# Orbe Brasil - Tema WordPress

Tema WordPress moderno e responsivo para a Orbe Brasil, desenvolvido com **Tailwind CSS 4** e foco em performance e simplicidade.

## 🚀 Características

- **Tailwind CSS 4** via CDN (sem build necessário)
- Design responsivo e moderno
- Performance otimizada
- Acessibilidade (WCAG 2.1)
- SEO otimizado
- Suporte a ACF (Advanced Custom Fields)

## 📦 Estrutura do Projeto

```
orbe-br/
├── assets/
│   ├── css/
│   │   └── swiper.min.css
│   ├── fonts/
│   │   └── FilsonPro*.woff2
│   ├── img/
│   │   └── *.svg, *.png
│   └── js/
│       ├── scripts.js
│       ├── swiper.min.js
│       ├── gsap.min.js
│       └── ...
├── inc/
│   ├── assets.php
│   ├── cleanup.php
│   ├── custom-post-types.php
│   └── ...
├── template-parts/
│   ├── header/
│   ├── footer/
│   └── content/
├── header.php
├── footer.php
└── functions.php
```

## 🎨 Tailwind CSS 4

O tema utiliza **Tailwind CSS 4** via CDN com configurações customizadas:

### Cores do Tema

```css
@theme {
  --color-header-green: #50d71e;
  --color-primary: #3b82f6;
  --color-primary-dark: #2563eb;
  --color-secondary: #64748b;
  --color-accent: #f59e0b;
}
```

### Fontes

- **Filson Pro** (fonte principal)
- Pesos: 300 (light), 400 (regular), 500 (book), 600 (medium)

### Componentes Customizados

- Botões (`.btn`, `.btn-primary`, `.btn-secondary`, `.btn-outline`)
- Cards (`.card`)
- Gradientes (`.bg-gradient-primary`, `.bg-gradient-secondary`)
- Animações (`.animate-fade-in`, `.animate-slide-up`)

## 🛠️ Desenvolvimento

### Pré-requisitos

- WordPress 6.0+
- PHP 8.0+
- ACF Pro (recomendado)

### Instalação

1. Clone o repositório
2. Ative o tema no WordPress
3. Configure os menus e widgets
4. Configure o ACF (se necessário)

### Desenvolvimento Local

```bash
# Não é necessário build - Tailwind CSS 4 via CDN
npm run dev
```

## 📱 Responsividade

O tema é totalmente responsivo com breakpoints:

- **Mobile**: < 768px
- **Tablet**: 768px - 1024px
- **Desktop**: > 1024px

## ♿ Acessibilidade

- Navegação por teclado
- Screen readers
- Contraste adequado
- ARIA labels
- Foco visível

## 🚀 Performance

- Tailwind CSS 4 via CDN (sem build)
- Lazy loading de imagens
- Scripts com defer
- Otimização de fontes
- Minificação automática

## 📄 Licença

MIT License - veja o arquivo LICENSE para detalhes.

## 👨‍💻 Desenvolvido por

**Igor Cunha** - Engenheiro de Software Sênior

---

> **Nota**: Este tema foi refatorado para usar Tailwind CSS 4 com abordagem simplificada, eliminando a necessidade de build e mantendo alta performance.
