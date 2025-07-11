<?php

/**
 * Integração genérica Contact Form 7 -> Custom Post Types
 * Salva submissões de múltiplos formulários do CF7 em diferentes CPTs, conforme configuração.
 */

add_action('wpcf7_mail_sent', function ($contact_form) {
    // Mapeamento de formulários para CPTs e campos
    $integracoes = [
        // Formulário "Fale Conosco"
        291 => [
            'post_type' => 'contatos',
            'title_field' => 'your-name',
            'fields' => [
                'nome'     => 'your-name',
                'email'    => 'your-email',
                'telefone' => 'your-phone',
                'empresa'  => 'your-enterprise',
                'website'  => 'your-website',
                'mensagem' => 'your-message',
            ],
            'metabox_title' => 'Dados do Contato',
        ],
        // Formulário "Trabalhe Conb"
        301 => [
            'post_type' => 'trabalhe-conosco',
            'title_field' => 'your-name',
            'fields' => [
                'nome'      => 'your-name',
                'email'     => 'your-email',
                'telefone'  => 'your-phone',
                'behance'   => 'your-behance',
                'instagram' => 'your-instagram',
                'mensagem'  => 'your-message',
            ],
            'metabox_title' => 'Dados do Candidato',
        ],
    ];

    $form_id = (int) $contact_form->id();
    if (!isset($integracoes[$form_id])) {
        return;
    }
    $config = $integracoes[$form_id];

    $submission = WPCF7_Submission::get_instance();
    if ($submission) {
        $data = $submission->get_posted_data();
        $post_title = isset($data[$config['title_field']]) ? sanitize_text_field($data[$config['title_field']]) : 'Novo Registro';

        // Cria o post do tipo correto
        $post_id = wp_insert_post([
            'post_type'   => $config['post_type'],
            'post_title'  => $post_title,
            'post_status' => 'publish',
        ]);

        // Salva os campos como custom fields
        if ($post_id) {
            foreach ($config['fields'] as $meta_key => $form_key) {
                $valor = isset($data[$form_key]) ? $data[$form_key] : '';
                if ($meta_key === 'email') {
                    $valor = sanitize_email($valor);
                } elseif ($meta_key === 'mensagem') {
                    $valor = sanitize_textarea_field($valor);
                } else {
                    $valor = sanitize_text_field($valor);
                }
                update_post_meta($post_id, $meta_key, $valor);
            }
        }
    }
});

// Metaboxes somente leitura para todos os CPTs integrados
add_action('add_meta_boxes', function () {
    $integracoes = [
        'contatos' => [
            'title' => 'Dados do Contato',
            'fields' => [
                'nome'     => 'Nome',
                'email'    => 'E-mail',
                'telefone' => 'Telefone',
                'empresa'  => 'Empresa',
                'website'  => 'Website',
                'mensagem' => 'Mensagem',
            ],
        ],
        'trabalhe-conosco' => [
            'title' => 'Dados do Candidato',
            'fields' => [
                'nome'      => 'Nome',
                'email'     => 'E-mail',
                'telefone'  => 'Telefone',
                'behance'   => 'Behance',
                'instagram' => 'Instagram',
                'mensagem'  => 'Mensagem',
            ],
        ],
    ];
    foreach ($integracoes as $post_type => $meta) {
        add_meta_box(
            $post_type . '_dados_box',
            $meta['title'],
            function ($post) use ($meta) {
                echo '<table class="form-table">';
                foreach ($meta['fields'] as $key => $label) {
                    $valor = get_post_meta($post->ID, $key, true);
                    echo '<tr><th style="width:120px">' . esc_html($label) . ':</th><td><div style="background:#f7f7f7;padding:8px 12px;border-radius:4px;min-width:200px;">' . nl2br(esc_html($valor)) . '</div></td></tr>';
                }
                echo '</table>';
            },
            $post_type,
            'normal',
            'high'
        );
    }
});
