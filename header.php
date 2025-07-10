<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,maximum-scale=1,minimum-scale=1,initial-scale=1">

  <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/favicon.png">

  <title><?php wp_title('-', true, 'right'); ?><?php bloginfo('name'); ?></title>

  <!-- Tailwind CSS 4 via CDN -->
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

  <?php wp_head(); ?>
</head>

<body class="<?php echo obter_body_classes_com_contexto("antialiased"); ?>">

  <?php
  // Verificação dinâmica para escolher o header correto
  // eslint-disable-next-line
  $is_home = is_front_page() || is_home();

  if ($is_home) {
    // Header para página inicial (home)
    get_template_part('template-parts/header/site', 'header');
  } else {
    // Header para outras páginas (internas)
    get_template_part('template-parts/header-internal/site', 'header-internal');
  }
  ?>