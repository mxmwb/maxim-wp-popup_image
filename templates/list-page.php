<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap wp-maxim-popup-list">
    <div class="wp-maxim-popup-header">
        <h1>Listar Imagens</h1>
        <a href="<?php echo admin_url('admin.php?page=wp-maxim-popup-add'); ?>" class="button button-primary">
            <span class="dashicons dashicons-plus-alt"></span>
            Adicionar Nova Imagem
        </a>
    </div>
    
    <div class="wp-maxim-popup-content">
        <?php if (!empty($images)) : ?>
            <div class="wp-maxim-popup-grid">
                <?php foreach ($images as $image) : ?>
                    <div class="wp-maxim-popup-card">
                        <div class="wp-maxim-popup-card-image">
                            <img src="<?php echo esc_url($image->image_url); ?>" alt="<?php echo esc_attr($image->title); ?>">
                            <div class="wp-maxim-popup-card-overlay">
                                <div class="wp-maxim-popup-card-actions">
                                    <button type="button" class="button delete-image" data-id="<?php echo esc_attr($image->id); ?>">
                                        <span class="dashicons dashicons-trash"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="wp-maxim-popup-card-content">
                            <h3 class="wp-maxim-popup-card-title"><?php echo esc_html($image->title); ?></h3>
                            <?php if (!empty($image->description)) : ?>
                                <p class="wp-maxim-popup-card-description"><?php echo esc_html($image->description); ?></p>
                            <?php endif; ?>
                            <div class="wp-maxim-popup-card-footer">
                                <label class="switch">
                                    <input type="checkbox" class="toggle-status" 
                                           data-id="<?php echo esc_attr($image->id); ?>"
                                           <?php checked($image->is_active, 1); ?>>
                                    <span class="slider round"></span>
                                </label>
                                <span class="status-text"><?php echo $image->is_active ? 'Ativo' : 'Inativo'; ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="wp-maxim-popup-empty-state">
                <span class="dashicons dashicons-images-alt2"></span>
                <h2>Nenhuma imagem cadastrada</h2>
                <p>Comece adicionando sua primeira imagem para exibir no popup.</p>
                <a href="<?php echo admin_url('admin.php?page=wp-maxim-popup-add'); ?>" class="button button-primary">
                    Adicionar Primeira Imagem
                </a>
            </div>
        <?php endif; ?>
    </div>
</div> 