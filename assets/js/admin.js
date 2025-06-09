jQuery(document).ready(function($) {
    // Media Uploader
    var mediaUploader;
    
    $('#upload-image-button').on('click', function(e) {
        e.preventDefault();
        
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        
        mediaUploader = wp.media({
            title: 'Selecionar Imagem',
            button: {
                text: 'Usar esta imagem'
            },
            multiple: false
        });
        
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#popup-image-url').val(attachment.url);
            $('.image-preview').attr('src', attachment.url).show();
            $('.wp-maxim-popup-upload-placeholder').hide();
        });
        
        mediaUploader.open();
    });
    
    // Form Submission
    $('#wp-maxim-popup-form').on('submit', function(e) {
        e.preventDefault();
        
        var formData = {
            action: 'save_popup_image',
            nonce: wpMaximPopup.nonce,
            title: $('#popup-title').val(),
            description: $('#popup-description').val(),
            image_url: $('#popup-image-url').val(),
            link_url: $('#popup-link').val()
        };
        
        $.post(wpMaximPopup.ajaxurl, formData, function(response) {
            if (response.success) {
                window.location.href = wpMaximPopup.listUrl;
            } else {
                alert('Erro ao salvar imagem: ' + response.data);
            }
        });
    });
    
    // Toggle Status
    $('.toggle-status').on('change', function() {
        var imageId = $(this).data('id');
        var isActive = $(this).prop('checked') ? 1 : 0;
        
        var data = {
            action: 'toggle_popup_image',
            nonce: wpMaximPopup.nonce,
            image_id: imageId,
            is_active: isActive
        };
        
        $.post(wpMaximPopup.ajaxurl, data, function(response) {
            if (!response.success) {
                alert('Erro ao atualizar status: ' + response.data);
                location.reload();
            }
        });
    });
    
    // Delete Image
    $('.delete-image').on('click', function() {
        if (!confirm('Tem certeza que deseja excluir esta imagem?')) {
            return;
        }
        
        var imageId = $(this).data('id');
        
        var data = {
            action: 'delete_popup_image',
            nonce: wpMaximPopup.nonce,
            image_id: imageId
        };
        
        $.post(wpMaximPopup.ajaxurl, data, function(response) {
            if (response.success) {
                location.reload();
            } else {
                alert('Erro ao excluir imagem: ' + response.data);
            }
        });
    });
}); 