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
      } else {
        // Abrir menu
        mobileMenu.classList.remove("-translate-x-full");
        mobileMenu.classList.add("translate-x-0");
        mobileMenu.setAttribute("aria-hidden", "false");
        menuButton.setAttribute("aria-expanded", "true");
        document.body.classList.add("menu-open");
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
  // [LAZY LOADING]
  // Implementa lazy loading para imagens
  // ===================================================================

  const imageObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const img = entry.target;
        img.src = img.dataset.src;
        imageObserver.unobserve(img);
      }
    });
  });

  document.querySelectorAll("img[data-src]").forEach((img) => {
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
        "focus:border-transparent"
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
    card.classList.add("bg-white", "rounded-lg", "shadow-md", "p-6");
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
  // [SWIPER]
  // Inicialização do Swiper para o banner
  // ===================================================================

  // SWIPER
  var bannerSwiper = new Swiper(".bannerSwiper");

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

  // ===================================================================
  // [SCROLL REVEAL]
  // Implementa animações de scroll reveal
  // ===================================================================

  // SCROLL REVEAL
  const sr = ScrollReveal({
    origin: "top",
    distance: "30px",
    duration: 2000,
    mobile: false,
  });

  sr.reveal(
    "#header, #banner-title , #banner-subtitle, #services-title, #forms-title, #forms, #team, #footer, #client-item, #certificate-item, #event-item, #team-item, #search, #blog-item, #images-item, #text",
    {
      interval: 200,
    }
  );

  sr.reveal(
    "#event-1, #event-2 , #event-3, #event-4, #event-5, #event-6, #event-7, #event-8, #event-9, #event-10",
    {
      origin: "left",
      interval: 200,
    }
  );

  sr.reveal(
    "#service-1, #service-2 , #service-3, #service-4, #service-5, #service-6",
    {
      origin: "left",
      interval: 200,
    }
  );

  console.log("Scripts do tema carregados com sucesso! 🚀");
});
