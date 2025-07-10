<?php
// Filtro para definir quantidade de posts no arquivo de comunidades
function definir_posts_por_pagina_para_comunidades($query)
{
  if (!is_admin() && $query->is_main_query() && is_post_type_archive('comunidades')) {
    $query->set('posts_per_page', 4);
  }
}
add_action('pre_get_posts', 'definir_posts_por_pagina_para_comunidades');

// Filtro para definir quantidade de posts no arquivo de livros
function definir_posts_por_pagina_para_livros($query)
{
  if (!is_admin() && $query->is_main_query() && is_post_type_archive('livros')) {
    $query->set('posts_per_page', 8);
  }
}
add_action('pre_get_posts', 'definir_posts_por_pagina_para_livros');
