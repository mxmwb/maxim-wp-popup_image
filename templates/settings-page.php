<?php
if (!defined('ABSPATH')) {
    exit;
}

$settings = get_option('wp_maxim_popup_settings', array(
    'popup_format' => 'center',
    'display_delay' => 1000,
    'auto_close' => 0,
    'width' => '600',
    'height' => '400'
));
?>

<div class="wrap">
    <h1>Configurações do WP Maxim Popup</h1>
    
    <form method="post" action="options.php">
        <?php settings_fields('wp_maxim_popup_settings'); ?>
        <?php do_settings_sections('wp_maxim_popup_settings'); ?>
        
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="popup_format">Formato do Popup</label>
                </th>
                <td>
                    <select name="wp_maxim_popup_settings[popup_format]" id="popup_format" class="regular-text">
                        <option value="center" <?php selected($settings['popup_format'], 'center'); ?>>Centralizado</option>
                        <option value="top-right" <?php selected($settings['popup_format'], 'top-right'); ?>>Superior Direito</option>
                        <option value="top-left" <?php selected($settings['popup_format'], 'top-left'); ?>>Superior Esquerdo</option>
                        <option value="bottom-right" <?php selected($settings['popup_format'], 'bottom-right'); ?>>Inferior Direito</option>
                        <option value="bottom-left" <?php selected($settings['popup_format'], 'bottom-left'); ?>>Inferior Esquerdo</option>
                    </select>
                    <p class="description">Escolha a posição onde o popup será exibido na tela.</p>
                </td>
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="popup_width">Largura do Popup</label>
                </th>
                <td>
                    <input type="number" 
                           name="wp_maxim_popup_settings[width]" 
                           id="popup_width" 
                           value="<?php echo esc_attr($settings['width']); ?>" 
                           class="small-text" 
                           min="200" 
                           max="1200" 
                           step="10">
                    <span class="description">px</span>
                    <p class="description">Largura do popup em pixels. Mínimo: 200px, Máximo: 1200px.</p>
                </td>
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="popup_height">Altura do Popup</label>
                </th>
                <td>
                    <input type="number" 
                           name="wp_maxim_popup_settings[height]" 
                           id="popup_height" 
                           value="<?php echo esc_attr($settings['height']); ?>" 
                           class="small-text" 
                           min="200" 
                           max="800" 
                           step="10">
                    <span class="description">px</span>
                    <p class="description">Altura do popup em pixels. Mínimo: 200px, Máximo: 800px.</p>
                </td>
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="display_delay">Tempo para Aparecer (ms)</label>
                </th>
                <td>
                    <input type="number" 
                           name="wp_maxim_popup_settings[display_delay]" 
                           id="display_delay" 
                           value="<?php echo esc_attr($settings['display_delay']); ?>" 
                           class="regular-text" 
                           min="0" 
                           step="100">
                    <p class="description">Tempo em milissegundos para o popup aparecer após o carregamento da página. Use 0 para desativar o delay.</p>
                </td>
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="auto_close">Tempo para Fechar (ms)</label>
                </th>
                <td>
                    <input type="number" 
                           name="wp_maxim_popup_settings[auto_close]" 
                           id="auto_close" 
                           value="<?php echo esc_attr($settings['auto_close']); ?>" 
                           class="regular-text" 
                           min="0" 
                           step="1000">
                    <p class="description">Tempo em milissegundos para o popup fechar automaticamente. Use 0 para desativar o fechamento automático.</p>
                </td>
            </tr>
        </table>
        
        <?php submit_button('Salvar Configurações'); ?>
    </form>
</div> 