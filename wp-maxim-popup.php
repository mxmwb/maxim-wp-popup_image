<?php
/**
 * Plugin Name: WP Maxim Popup
 * Plugin URI: 
 * Description: Plugin para exibir popups com imagens aleatórias em páginas do WordPress
 * Version: 1.0.0
 * Author: Maxim Web Sistemas
 * Author URI: Maxim Web
 * Text Domain: wp-maxim-popup
 * Domain Path: /languages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Plugin constants
define('WP_MAXIM_POPUP_VERSION', '1.0.0');
define('WP_MAXIM_POPUP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WP_MAXIM_POPUP_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required files
require_once WP_MAXIM_POPUP_PLUGIN_DIR . 'includes/class-wp-maxim-popup.php';
require_once WP_MAXIM_POPUP_PLUGIN_DIR . 'includes/class-wp-maxim-popup-admin.php';
require_once WP_MAXIM_POPUP_PLUGIN_DIR . 'includes/class-wp-maxim-popup-frontend.php';

// Initialize the plugin
function wp_maxim_popup_init() {
    $plugin = new WP_Maxim_Popup();
    $plugin->init();
}
add_action('plugins_loaded', 'wp_maxim_popup_init');

// Activation hook
register_activation_hook(__FILE__, 'wp_maxim_popup_activate');
function wp_maxim_popup_activate() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'maxim_popup_images';
    
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title varchar(255) NOT NULL,
        description text,
        image_url varchar(255) NOT NULL,
        link_url varchar(255),
        is_active tinyint(1) DEFAULT 1,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Deactivation hook
register_deactivation_hook(__FILE__, 'wp_maxim_popup_deactivate');
function wp_maxim_popup_deactivate() {
    // Cleanup if needed
} 