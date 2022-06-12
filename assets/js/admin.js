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

            let date_create = document.querySelector('#date_create');
            if (required(date_create.value)) {
                if (!validatedate(date_create.value)) {
                    date_create.focus();
                    alert( 'Неверный формат даты' );
                    return false;
                }
            } else {
                date_create.focus();
                alert( 'Укажите дату создания продукта' );
                return false;
            }

            let type_of_product = document.querySelector('#type_of_product');
            if (required(type_of_product.value)) {
                if ( 'rare' == type_of_product.value || 'frequent' == type_of_product.value || 'unusual' == type_of_product.value || '' == type_of_product.value) {
                    // NICE
                } else{
                    type_of_product.focus();
                    alert( 'Неверный тип продукта' );
                    return false;
                }
            } else {
                type_of_product.focus();
                alert( 'Укажите тип продукта продукта' );
                return false;
            }

            let pr_image = document.querySelector('#pr_image');
            if (!required(pr_image.value)) {
                pr_image.closest('.pr_image_field').querySelector('.upload_button').focus();
                alert( 'Укажите изображение продукта' );
                return false;
            }

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

function required(input) {
    if (input.length == 0) {
        return false;
    }
    return true;
}

function validatedate(inputText) {
    var dateformat = /^\d{4}-((0\d)|(1[012]))-(([012]\d)|3[01])$/;
    // Match the date format through regular expression
    if (inputText.match(dateformat)) {
        //Test which seperator is used '/' or '-'
        var opera1 = inputText.split('/');
        var opera2 = inputText.split('-');
        lopera1 = opera1.length;
        lopera2 = opera2.length;
        // Extract the string into month, date and year
        if (lopera1 > 1) {
            var pdate = inputText.split('/');
        }
        else if (lopera2 > 1) {
            var pdate = inputText.split('-');
        }
        var yy = parseInt(pdate[0]);
        var mm = parseInt(pdate[1]);
        var dd = parseInt(pdate[2]);
        // Create list of days of a month [assume there is no leap year by default]
        var ListofDays = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        if (mm == 1 || mm > 2) {
            if (dd > ListofDays[mm - 1]) {
                return false;
            }
        }
        if (mm == 2) {
            var lyear = false;
            if ((!(yy % 4) && yy % 100) || !(yy % 400)) {
                lyear = true;
            }
            if ((lyear == false) && (dd >= 29)) {
                return false;
            }
            if ((lyear == true) && (dd > 29)) {
                return false;
            }
        }
    }
    else {
        return false;
    }

    return true;
}