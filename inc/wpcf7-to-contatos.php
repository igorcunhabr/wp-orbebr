<?php

/**
 * Integração Contact Form 7 -> CPT Contatos
 * Salva submissões do formulário "Fale Conosco" como posts do tipo 'contatos'.
 */

add_action('wpcf7_mail_sent', function ($contact_form) {
    // Substitua pelo ID real do seu formulário (veja no painel do Contact Form 7)
    $form_id = 291; // ID do formulário como número
    error_log('CF7 integração chamada! Form ID recebido: ' . $contact_form->id());
    if ((string)$contact_form->id() !== (string)$form_id) {
        error_log('CF7 integração: ID não confere. Esperado: ' . $form_id . ' | Recebido: ' . $contact_form->id());
        return;
    }
    error_log('CF7 integração: ID confere, processando submissão.');

    $submission = WPCF7_Submission::get_instance();
    if ($submission) {
        $data = $submission->get_posted_data();
        error_log('CF7 integração: Dados recebidos: ' . print_r($data, true));

        // Ajuste os nomes dos campos conforme o seu formulário
        $nome       = isset($data['your-name'])        ? sanitize_text_field($data['your-name'])        : '';
        $email      = isset($data['your-email'])       ? sanitize_email($data['your-email'])            : '';
        $telefone   = isset($data['your-phone'])       ? sanitize_text_field($data['your-phone'])        : '';
        $empresa    = isset($data['your-enterprise'])  ? sanitize_text_field($data['your-enterprise'])   : '';
        $website    = isset($data['your-website'])     ? sanitize_text_field($data['your-website'])      : '';
        $mensagem   = isset($data['your-message'])     ? sanitize_textarea_field($data['your-message'])  : '';

        // Cria o post do tipo 'contatos'
        $post_id = wp_insert_post([
            'post_type'   => 'contatos',
            'post_title'  => $nome ? $nome : 'Novo Contato',
            'post_status' => 'publish',
        ]);
        error_log('CF7 integração: Post criado com ID: ' . $post_id);

        // Salva os campos como custom fields
        if ($post_id) {
            update_post_meta($post_id, 'nome', $nome);
            update_post_meta($post_id, 'email', $email);
            update_post_meta($post_id, 'telefone', $telefone);
            update_post_meta($post_id, 'empresa', $empresa);
            update_post_meta($post_id, 'website', $website);
            update_post_meta($post_id, 'mensagem', $mensagem);
            error_log('CF7 integração: Metadados salvos para o post ' . $post_id);
        }
    } else {
        error_log('CF7 integração: Submission não encontrada.');
    }
});

// Adiciona um metabox somente leitura para exibir os dados do contato
add_action('add_meta_boxes', function () {
    add_meta_box(
        'contato_dados_box',
        'Dados do Contato',
        function ($post) {
            // Recupera os campos
            $campos = [
                'nome'     => 'Nome',
                'email'    => 'E-mail',
                'telefone' => 'Telefone',
                'empresa'  => 'Empresa',
                'website'  => 'Website',
                'mensagem' => 'Mensagem',
            ];
            echo '<table class="form-table">';
            foreach ($campos as $key => $label) {
                $valor = get_post_meta($post->ID, $key, true);
                echo '<tr><th style="width:120px">' . esc_html($label) . ':</th><td><div style="background:#f7f7f7;padding:8px 12px;border-radius:4px;min-width:200px;">' . nl2br(esc_html($valor)) . '</div></td></tr>';
            }
            echo '</table>';
        },
        'contatos',
        'normal',
        'high'
    );
});
