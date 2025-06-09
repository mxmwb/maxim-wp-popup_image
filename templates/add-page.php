<?php
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap">
    <div class="wp-maxim-popup-header">
        <h1>Adicionar Nova Imagem</h1>
        <a href="<?php echo admin_url('admin.php?page=wp-maxim-popup'); ?>" class="button">
            <span class="dashicons dashicons-arrow-left-alt"></span>
            Voltar para Lista
        </a>
    </div>
    
    <div class="card">
        <form id="wp-maxim-popup-form">
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="popup-title">Título *</label>
                    </th>
                    <td>
                        <input type="text" id="popup-title" name="title" class="regular-text" required>
                        <p class="description">Um título descritivo para a imagem do popup.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="popup-description">Descrição</label>
                    </th>
                    <td>
                        <textarea id="popup-description" name="description" class="large-text" rows="3"></textarea>
                        <p class="description">Uma breve descrição que será exibida abaixo da imagem (opcional).</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="popup-image">Imagem *</label>
                    </th>
                    <td>
                        <div class="image-preview-wrapper">
                            <img src="" style="max-width: 200px; display: none;" class="image-preview">
                            <div class="wp-maxim-popup-upload-placeholder" style="display: none;">
                                <span class="dashicons dashicons-format-image"></span>
                                <p>Nenhuma imagem selecionada</p>
                            </div>
                        </div>
                        <input type="hidden" name="image_url" id="popup-image-url" required>
                        <button type="button" class="button" id="upload-image-button">Selecionar Imagem</button>
                        <p class="description">Selecione uma imagem para exibir no popup. Tamanho recomendado: 800x600 pixels.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="popup-link">URL do Link</label>
                    </th>
                    <td>
                        <input type="url" id="popup-link" name="link_url" class="regular-text">
                        <p class="description">URL para onde o usuário será redirecionado ao clicar na imagem (opcional).</p>
                    </td>
                </tr>
            </table>
            <p class="submit">
                <button type="submit" class="button button-primary">Salvar Imagem</button>
            </p>
        </form>
    </div>
</div> 