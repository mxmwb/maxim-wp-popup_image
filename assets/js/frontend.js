jQuery(document).ready(function($) {
    // Only proceed if we have popup data
    if (typeof wpMaximPopupData === 'undefined' || !wpMaximPopupData.image) {
        return;
    }
    
    var popup = $('#wp-maxim-popup');
    var image = wpMaximPopupData.image;
    var settings = wpMaximPopupData.settings;
    
    // Set popup format and dimensions
    popup.attr('data-format', settings.popup_format);
    popup.find('.wp-maxim-popup-content').css({
        '--popup-width': settings.width + 'px',
        '--popup-height': settings.height + 'px'
    });
    
    // Set popup content
    $('.wp-maxim-popup-image').attr({
        'src': image.url,
        'alt': image.title || ''
    });
    
    // Set link if available
    if (image.link_url) {
        $('.wp-maxim-popup-image-link').attr('href', image.link_url);
    } else {
        $('.wp-maxim-popup-image-link').removeAttr('href');
    }
    
    // Show popup after delay
    setTimeout(function() {
        popup.fadeIn(300);
        
        // Auto close if enabled
        if (settings.auto_close > 0) {
            setTimeout(function() {
                popup.fadeOut(300);
            }, settings.auto_close);
        }
    }, settings.display_delay);
    
    // Close popup when clicking the close button
    $('.wp-maxim-popup-close').on('click', function() {
        popup.fadeOut(300);
    });
    
    // Close popup when clicking outside
    popup.on('click', function(e) {
        if ($(e.target).is(popup)) {
            popup.fadeOut(300);
        }
    });
    
    // Close popup when pressing ESC key
    $(document).on('keydown', function(e) {
        if (e.keyCode === 27) { // ESC key
            popup.fadeOut(300);
        }
    });
}); 