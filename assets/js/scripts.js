/**
 * Scripts principais do tema
 */

document.addEventListener("DOMContentLoaded", function () {
  // ===================================================================
  // [MENU MOBILE]
  // Funcionalidade para abrir/fechar o menu mobile
  // ===================================================================

  const menuButton = document.getElementById("js-open-menu");
  const mobileMenu = document.getElementById("mobile-menu");
  const menuSpans = menuButton?.querySelectorAll("span");

  if (menuButton && mobileMenu) {
    menuButton.addEventListener("click", function () {
      const isOpen = mobileMenu.classList.contains("translate-x-0");

      if (isOpen) {
        // Fechar menu
        mobileMenu.classList.remove("translate-x-0");
        mobileMenu.classList.add("-translate-x-full");
        mobileMenu.setAttribute("aria-hidden", "true");
        menuButton.setAttribute("aria-expanded", "false");
        document.body.classList.remove("menu-open");

        // Resetar ícone do menu - controlado pelo CSS via aria-expanded
      } else {
        // Abrir menu
        mobileMenu.classList.remove("-translate-x-full");
        mobileMenu.classList.add("translate-x-0");
        mobileMenu.setAttribute("aria-hidden", "false");
        menuButton.setAttribute("aria-expanded", "true");
        document.body.classList.add("menu-open");

        // Animar ícone do menu - agora controlado pelo CSS
        // O CSS já aplica as transformações necessárias via aria-expanded
      }
    });

    // Fechar menu ao clicar em um link
    const mobileMenuLinks = mobileMenu.querySelectorAll("a");
    mobileMenuLinks.forEach((link) => {
      link.addEventListener("click", function () {
        // Pequeno delay para permitir a navegação
        setTimeout(() => {
          mobileMenu.classList.remove("translate-x-0");
          mobileMenu.classList.add("-translate-x-full");
          mobileMenu.setAttribute("aria-hidden", "true");
          menuButton.setAttribute("aria-expanded", "false");
          document.body.classList.remove("menu-open");

          // Resetar ícone do menu - controlado pelo CSS via aria-expanded
        }, 100);
      });
    });

    // Fechar menu ao pressionar ESC
    document.addEventListener("keydown", function (event) {
      if (
        event.key === "Escape" &&
        mobileMenu.classList.contains("translate-x-0")
      ) {
        mobileMenu.classList.remove("translate-x-0");
        mobileMenu.classList.add("-translate-x-full");
        mobileMenu.setAttribute("aria-hidden", "true");
        menuButton.setAttribute("aria-expanded", "false");
        document.body.classList.remove("menu-open");

        // Resetar ícone do menu
        if (menuSpans) {
          menuSpans.forEach((span) => {
            span.classList.remove("rotate-45", "-rotate-45", "opacity-0");
          });
        }
      }
    });

    // Fechar menu ao clicar fora dele
    document.addEventListener("click", function (event) {
      if (
        mobileMenu.classList.contains("translate-x-0") &&
        !mobileMenu.contains(event.target) &&
        !menuButton.contains(event.target)
      ) {
        mobileMenu.classList.remove("translate-x-0");
        mobileMenu.classList.add("-translate-x-full");
        mobileMenu.setAttribute("aria-hidden", "true");
        menuButton.setAttribute("aria-expanded", "false");
        document.body.classList.remove("menu-open");

        // Resetar ícone do menu
        if (menuSpans) {
          menuSpans.forEach((span) => {
            span.classList.remove("rotate-45", "-rotate-45", "opacity-0");
          });
        }
      }
    });
  }

  // ===================================================================
  // [SCROLL SUAVE]
  // Implementa scroll suave para links internos
  // ===================================================================

  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute("href"));
      if (target) {
        target.scrollIntoView({
          behavior: "smooth",
          block: "start",
        });
      }
    });
  });

  // ===================================================================
  // [ANIMAÇÕES NO SCROLL]
  // Adiciona animações quando elementos entram no viewport
  // ===================================================================

  const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("animate-fade-in");
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  // Observar elementos com classe de animação
  document.querySelectorAll(".animate-on-scroll").forEach((el) => {
    observer.observe(el);
  });

  // ===================================================================
  // [LAZY LOADING]
  // Implementa lazy loading para imagens
  // ===================================================================

  const imageObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const img = entry.target;
        img.src = img.dataset.src;
        img.classList.remove("opacity-0");
        img.classList.add("opacity-100");
        imageObserver.unobserve(img);
      }
    });
  });

  document.querySelectorAll("img[data-src]").forEach((img) => {
    img.classList.add("opacity-0", "transition-opacity", "duration-300");
    imageObserver.observe(img);
  });

  // ===================================================================
  // [FORMULÁRIOS]
  // Melhora a experiência dos formulários
  // ===================================================================

  document.querySelectorAll("form").forEach((form) => {
    const inputs = form.querySelectorAll("input, textarea, select");

    inputs.forEach((input) => {
      // Adicionar classes do Tailwind
      input.classList.add(
        "w-full",
        "px-4",
        "py-2",
        "border",
        "border-gray-300",
        "rounded-lg",
        "focus:outline-none",
        "focus:ring-2",
        "focus:ring-primary",
        "focus:border-transparent",
        "transition-all",
        "duration-200"
      );

      // Adicionar label flutuante se necessário
      const label = input.previousElementSibling;
      if (label && label.tagName === "LABEL") {
        label.classList.add(
          "block",
          "text-sm",
          "font-medium",
          "text-gray-700",
          "mb-1"
        );
      }
    });
  });

  // ===================================================================
  // [BOTÕES]
  // Adiciona classes do Tailwind aos botões
  // ===================================================================

  document
    .querySelectorAll('button:not([class*="btn"]):not([id="js-open-menu"])')
    .forEach((button) => {
      button.classList.add("btn", "btn-primary");
    });

  // ===================================================================
  // [CARDS]
  // Adiciona classes do Tailwind aos cards
  // ===================================================================

  document.querySelectorAll(".card").forEach((card) => {
    card.classList.add(
      "bg-white",
      "rounded-lg",
      "shadow-md",
      "p-6",
      "hover:shadow-lg",
      "transition-shadow",
      "duration-300"
    );
  });

  // ===================================================================
  // [BUSCA EM TEMPO REAL - BLOG]
  // Implementa busca em tempo real para posts do blog
  // ===================================================================

  const searchInput = document.querySelector('#search input[type="text"]');
  const postsContainer = document.getElementById("paginated-posts");
  const noResultsMessage = document.querySelector(".no-results-message");

  if (searchInput && postsContainer) {
    let searchTimeout;

    searchInput.addEventListener("input", function () {
      const searchTerm = this.value.toLowerCase().trim();

      // Limpar timeout anterior
      clearTimeout(searchTimeout);

      // Debounce para evitar muitas requisições
      searchTimeout = setTimeout(() => {
        searchPosts(searchTerm);
      }, 300);
    });

    function searchPosts(searchTerm) {
      const posts = postsContainer.querySelectorAll("article");
      let hasVisiblePosts = false;

      posts.forEach((post) => {
        const title =
          post.querySelector("h2, h3")?.textContent.toLowerCase() || "";
        const content = post.textContent.toLowerCase();

        if (
          searchTerm === "" ||
          title.includes(searchTerm) ||
          content.includes(searchTerm)
        ) {
          post.style.display = "block";
          post.classList.add("animate-fade-in");
          hasVisiblePosts = true;
        } else {
          post.style.display = "none";
        }
      });

      // Mostrar/esconder mensagem de "nenhum resultado"
      if (noResultsMessage) {
        if (hasVisiblePosts || searchTerm === "") {
          noResultsMessage.style.display = "none";
        } else {
          noResultsMessage.style.display = "flex";
        }
      }
    }
  }

  // ===================================================================
  // [UTILITÁRIOS]
  // Funções utilitárias
  // ===================================================================

  // Função para debounce
  window.debounce = function (func, wait) {
    let timeout;
    return function executedFunction(...args) {
      const later = () => {
        clearTimeout(timeout);
        func(...args);
      };
      clearTimeout(timeout);
      timeout = setTimeout(later, wait);
    };
  };

  // Função para throttle
  window.throttle = function (func, limit) {
    let inThrottle;
    return function () {
      const args = arguments;
      const context = this;
      if (!inThrottle) {
        func.apply(context, args);
        inThrottle = true;
        setTimeout(() => (inThrottle = false), limit);
      }
    };
  };

  console.log("Scripts do tema carregados com sucesso! 🚀");
});
