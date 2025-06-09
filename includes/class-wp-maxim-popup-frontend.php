<?php

class WP_Maxim_Popup_Frontend {
    public function enqueue_frontend_scripts() {
        wp_enqueue_style('wp-maxim-popup-frontend', WP_MAXIM_POPUP_PLUGIN_URL . 'assets/css/frontend.css', array(), WP_MAXIM_POPUP_VERSION);
        wp_enqueue_script('wp-maxim-popup-frontend', WP_MAXIM_POPUP_PLUGIN_URL . 'assets/js/frontend.js', array('jquery'), WP_MAXIM_POPUP_VERSION, true);
        
        // Get random active image
        $plugin = new WP_Maxim_Popup();
        $image = $plugin->get_random_active_image();
        
        if ($image) {
            // Get settings
            $settings = get_option('wp_maxim_popup_settings', array(
                'popup_format' => 'center',
                'display_delay' => 1000,
                'auto_close' => 0
            ));
            
            wp_localize_script('wp-maxim-popup-frontend', 'wpMaximPopupData', array(
                'image' => array(
                    'url' => $image->image_url,
                    'title' => $image->title,
                    'description' => $image->description,
                    'link_url' => $image->link_url
                ),
                'settings' => $settings
            ));
        }
    }

    public function render_popup() {
        if (!is_admin()) {
            include WP_MAXIM_POPUP_PLUGIN_DIR . 'templates/popup.php';
        }
    }
} 