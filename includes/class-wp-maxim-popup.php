<?php

class WP_Maxim_Popup {
    private $admin;
    private $frontend;

    public function init() {
        // Initialize admin and frontend
        $this->admin = new WP_Maxim_Popup_Admin();
        $this->frontend = new WP_Maxim_Popup_Frontend();
        
        // Add menu items
        add_action('admin_menu', array($this->admin, 'add_menu_pages'));
        
        // Register settings
        add_action('admin_init', array($this->admin, 'register_settings'));
        
        // Register scripts and styles
        add_action('admin_enqueue_scripts', array($this->admin, 'enqueue_admin_scripts'));
        add_action('wp_enqueue_scripts', array($this->frontend, 'enqueue_frontend_scripts'));
        
        // Add popup template to footer
        add_action('wp_footer', array($this->frontend, 'render_popup'));
        
        // Register AJAX handlers
        add_action('wp_ajax_save_popup_image', array($this->admin, 'save_popup_image'));
        add_action('wp_ajax_delete_popup_image', array($this->admin, 'delete_popup_image'));
        add_action('wp_ajax_toggle_popup_image', array($this->admin, 'toggle_popup_image'));
    }

    public function get_random_active_image() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'maxim_popup_images';
        
        $image = $wpdb->get_row(
            "SELECT * FROM $table_name 
            WHERE is_active = 1 
            ORDER BY RAND() 
            LIMIT 1"
        );
        
        return $image;
    }
} 