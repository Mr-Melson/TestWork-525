document.addEventListener("DOMContentLoaded", function(event) {

    // Установка изображения
    if( document.querySelectorAll('.upload_button') ){
        var frame; 
        let button =  document.querySelectorAll('.upload_button');
        for (const ev of button) {
                
            ev.addEventListener('click', function (){
        
                event.preventDefault();
                
                // Create a new media frame
                frame = wp.media({
                    title: 'Select or Upload Image',
                    button: {
                        text: 'Use this Image'
                    },
                    multiple: false
                });
                
                // If the media frame already exists, reopen it.
                if ( frame ) {
                    frame.open();
                }
        
                let input = ev.closest('.pr_image_field').querySelector('.pr_image_file');
                let image = ev.closest('.pr_image_field').querySelector('.pr_image_url');
        
                // When an image is selected in the media frame...
                frame.on( 'select', function() {
        
                    // Get media attachment details from the frame state
                    var attachment = frame.state().get('selection').first().toJSON();
        
                    input.value = attachment.url;
                    image.setAttribute( 'src', attachment.url );
                    image.classList.remove("hidden");
                });
            });
        }
    }

    // Удаление изображения
    if( document.querySelectorAll('.remove_button') ){
        let remove =  document.querySelectorAll('.remove_button');
        for (const ev of remove) {
                
            ev.addEventListener('click', function (){
        
                event.preventDefault();
        
                let input = ev.closest('.pr_image_field').querySelector('.pr_image_file');
                let image = ev.closest('.pr_image_field').querySelector('.pr_image_url');
                input.value = '';
                image.setAttribute( 'src', '' );
                image.classList.add("hidden");
            });
        }
    }

    // Очищение кастомных полей
    if( document.querySelector('#clear_cstm_fields') ){
        document.querySelector('#clear_cstm_fields').addEventListener( 'click', function(e){
            
            document.querySelector('.pr_image_file').value = '';
            document.querySelector('.pr_image_url').setAttribute( 'src', '' );
            document.querySelector('.pr_image_url').classList.add("hidden");
            
            document.querySelector('#date_create').value = '';
            document.querySelector('#type_of_product').value = '';
        })
    }

    // Кастомное обновление продукта
    if( document.querySelector('#cstm-publish') ){
        document.querySelector('#cstm-publish').addEventListener( 'click', function(e){
    
            document.querySelector('input[name=action]').value = 'cstmpostajax';
            var data = jQuery("#post").serialize()
    
            jQuery.ajax({
                url: ajaxurl,
                data: data,
                type: 'POST',
                dataType: 'json',
                cache       : false,
                success: function( data ) {
                    if( data ){
                        document.querySelector('input[name=action]').value = 'editpost';
                        alert('Обновлено');
                    }
                }
            });
        })
    }
})