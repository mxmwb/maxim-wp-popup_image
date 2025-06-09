<?php

class WP_Maxim_Popup_Admin {
    public function add_menu_pages() {
        // Add main menu
        add_menu_page(
            'WP Maxim Popup',
            'WP Maxim Popup',
            'manage_options',
            'wp-maxim-popup',
            array($this, 'render_list_page'),
            'dashicons-images-alt2',
            30
        );

        // Add submenu for listing images
        add_submenu_page(
            'wp-maxim-popup',
            'Listar Imagens',
            'Listar Imagens',
            'manage_options',
            'wp-maxim-popup',
            array($this, 'render_list_page')
        );

        // Add submenu for adding new image
        add_submenu_page(
            'wp-maxim-popup',
            'Adicionar Nova Imagem',
            'Adicionar Nova',
            'manage_options',
            'wp-maxim-popup-add',
            array($this, 'render_add_page')
        );

        // Add submenu for settings
        add_submenu_page(
            'wp-maxim-popup',
            'Configurações',
            'Configurações',
            'manage_options',
            'wp-maxim-popup-settings',
            array($this, 'render_settings_page')
        );
    }

    public function register_settings() {
        register_setting(
            'wp_maxim_popup_settings',
            'wp_maxim_popup_settings',
            array($this, 'sanitize_settings')
        );
    }

    public function sanitize_settings($input) {
        $sanitized = array();
        
        $sanitized['popup_format'] = sanitize_text_field($input['popup_format']);
        $sanitized['display_delay'] = absint($input['display_delay']);
        $sanitized['auto_close'] = absint($input['auto_close']);
        
        // Sanitize width and height
        $width = absint($input['width']);
        $height = absint($input['height']);
        
        // Ensure minimum and maximum values
        $sanitized['width'] = max(200, min(1200, $width));
        $sanitized['height'] = max(200, min(800, $height));
        
        return $sanitized;
    }

    public function enqueue_admin_scripts($hook) {
        if (!in_array($hook, array('toplevel_page_wp-maxim-popup', 'wp-maxim-popup_page_wp-maxim-popup-add', 'wp-maxim-popup_page_wp-maxim-popup-settings'))) {
            return;
        }

        wp_enqueue_media();
        wp_enqueue_style('wp-maxim-popup-admin', WP_MAXIM_POPUP_PLUGIN_URL . 'assets/css/admin.css', array(), WP_MAXIM_POPUP_VERSION);
        wp_enqueue_script('wp-maxim-popup-admin', WP_MAXIM_POPUP_PLUGIN_URL . 'assets/js/admin.js', array('jquery'), WP_MAXIM_POPUP_VERSION, true);
        
        wp_localize_script('wp-maxim-popup-admin', 'wpMaximPopup', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wp_maxim_popup_nonce'),
            'listUrl' => admin_url('admin.php?page=wp-maxim-popup')
        ));
    }

    public function render_list_page() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'maxim_popup_images';
        $images = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");
        
        include WP_MAXIM_POPUP_PLUGIN_DIR . 'templates/list-page.php';
    }

    public function render_add_page() {
        include WP_MAXIM_POPUP_PLUGIN_DIR . 'templates/add-page.php';
    }

    public function render_settings_page() {
        include WP_MAXIM_POPUP_PLUGIN_DIR . 'templates/settings-page.php';
    }

    public function save_popup_image() {
        check_ajax_referer('wp_maxim_popup_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized');
        }

        $title = sanitize_text_field($_POST['title']);
        $description = sanitize_textarea_field($_POST['description']);
        $image_url = esc_url_raw($_POST['image_url']);
        $link_url = esc_url_raw($_POST['link_url']);

        if (empty($title) || empty($image_url)) {
            wp_send_json_error('Title and image are required');
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'maxim_popup_images';
        
        $result = $wpdb->insert(
            $table_name,
            array(
                'title' => $title,
                'description' => $description,
                'image_url' => $image_url,
                'link_url' => $link_url,
                'is_active' => 1
            ),
            array('%s', '%s', '%s', '%s', '%d')
        );

        if ($result) {
            wp_send_json_success('Image saved successfully');
        } else {
            wp_send_json_error('Failed to save image');
        }
    }

    public function delete_popup_image() {
        check_ajax_referer('wp_maxim_popup_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized');
        }

        $image_id = intval($_POST['image_id']);
        
        global $wpdb;
        $table_name = $wpdb->prefix . 'maxim_popup_images';
        
        $result = $wpdb->delete(
            $table_name,
            array('id' => $image_id),
            array('%d')
        );

        if ($result) {
            wp_send_json_success('Image deleted successfully');
        } else {
            wp_send_json_error('Failed to delete image');
        }
    }

    public function toggle_popup_image() {
        check_ajax_referer('wp_maxim_popup_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized');
        }

        $image_id = intval($_POST['image_id']);
        $is_active = intval($_POST['is_active']);
        
        global $wpdb;
        $table_name = $wpdb->prefix . 'maxim_popup_images';
        
        $result = $wpdb->update(
            $table_name,
            array('is_active' => $is_active),
            array('id' => $image_id),
            array('%d'),
            array('%d')
        );

        if ($result !== false) {
            wp_send_json_success('Image status updated successfully');
        } else {
            wp_send_json_error('Failed to update image status');
        }
    }
} 