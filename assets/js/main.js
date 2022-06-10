document.addEventListener("DOMContentLoaded", function(event) {
    
    if( document.querySelector('#create_product') ){
        document.querySelector('#create_product').addEventListener( 'click', function(e){
    
            e.preventDefault();
            if (window.FormData != undefined) {
    
                document.querySelector('#result').innerHTML = '<div class="loader-bg"><div class="lds-ripple"><div></div><div></div></div></div>';
    
                var formData = new FormData();
                formData.append('action', 'create_product');
    
                if( document.querySelector('#newimg').files != '' ){
                    var files = document.querySelector('#newimg').files;
                    console.log(files);
                    formData.append('newimg', files[0]);
                    formData.append('filename', files[0].name);
                }
    
                if( document.querySelector('#product_name').value != '' ){
                    formData.append('product_name', document.querySelector('#product_name').value );
                } else{
                    document.querySelector('#result').innerHTML = 'Укажите название продукта';
                    return false;
                }
    
                if( document.querySelector('#price').value != '' ){
                    formData.append('price', document.querySelector('#price').value );
                } else{
                    document.querySelector('#result').innerHTML = 'Укажите цену продукта';
                    return false;
                }
    
                if( document.querySelector('#date_create').value != '' ){
                    formData.append('date_create', document.querySelector('#date_create').value );
                } else{
                    document.querySelector('#result').innerHTML = 'Укажите дату создания продукта';
                    return false;
                }
    
                if( document.querySelector('#type_of_product').value != '' ){
                    formData.append('type_of_product', document.querySelector('#type_of_product').value );
                } else{
                    document.querySelector('#result').innerHTML = 'Укажите тип продукта продукта';
                    return false;
                }
    
    
                var create_request = new XMLHttpRequest();
                create_request.open('POST', woocommerce_params.ajax_url, true);
    
                create_request.send( formData );
    
                create_request.onload = function() {
                    if (this.status >= 200 && this.status < 400) {
                        // Success!
                        if( undefined != this.response && '' != this.response ){
                            var resp = JSON.parse(this.response);

                            if( resp.success == true ){
                                document.querySelector('#result').innerHTML = '<a href="'+resp.link+'">Смотреть '+document.querySelector('#product_name').value+'</a>';
                            } else{
                                document.querySelector('#result').innerHTML = 'Что-то пошло не так...попробуйте снова';
                            }
                        }
                    }
                };
            }
        })
    }
})