document.addEventListener("DOMContentLoaded", function (event) {

    if (document.querySelector('#create_product')) {
        document.querySelector('#create_product').addEventListener('click', function (e) {

            e.preventDefault();
            if (window.FormData != undefined) {

                document.querySelector('#result').innerHTML = '<div class="loader-bg"><div class="lds-ripple"><div></div><div></div></div></div>';

                var formData = new FormData();
                formData.append('action', 'create_product');

                let newimg = document.querySelector('#newimg').files;
                if (newimg.length > 0) {
                    var files = newimg;
                    if( files[0].type == 'image/jpeg' || files[0].type == 'image/png' || files[0].type == 'image/jpg' ){                        
                        formData.append('newimg', files[0]);
                        formData.append('filename', files[0].name);
                    } else{
                        document.querySelector('#result').innerHTML = 'Выберите изображение формата jpg/jpeg/png';
                        return false;
                    }
                } else {
                    document.querySelector('#result').innerHTML = 'Добавьте изображение продукта';
                    return false;
                }

                let product_name = document.querySelector('#product_name').value;
                if (required(product_name)) {
                    if (allLetter(product_name)) {
                        formData.append('product_name', product_name);
                    } else {
                        document.querySelector('#result').innerHTML = 'Неверный формат названия';
                        return false;
                    }
                } else {
                    document.querySelector('#result').innerHTML = 'Укажите название продукта';
                    return false;
                }

                let price = document.querySelector('#price').value;
                if (required(price)) {
                    if (allnumeric(price)) {
                        formData.append('price', price);
                    } else {
                        document.querySelector('#result').innerHTML = 'Неверный формат числа';
                        return false;
                    }
                } else {
                    document.querySelector('#result').innerHTML = 'Укажите цену продукта';
                    return false;
                }

                let date_create = document.querySelector('#date_create').value;
                if (required(date_create)) {
                    if (validatedate(date_create)) {
                        formData.append('date_create', date_create);
                    } else {
                        document.querySelector('#result').innerHTML = 'Неверный формат даты';
                        return false;
                    }
                } else {
                    document.querySelector('#result').innerHTML = 'Укажите дату создания продукта';
                    return false;
                }

                let type_of_product = document.querySelector('#type_of_product').value;
                if (required(type_of_product)) {
                    if ( 'rare' == type_of_product || 'frequent' == type_of_product || 'unusual' == type_of_product) {
                        formData.append('type_of_product', type_of_product);
                    } else {
                        document.querySelector('#result').innerHTML = 'Неверный тип продукта';
                        return false;
                    }
                } else {
                    document.querySelector('#result').innerHTML = 'Укажите тип продукта продукта';
                    return false;
                }


                var create_request = new XMLHttpRequest();
                create_request.open('POST', woocommerce_params.ajax_url, true);

                create_request.send(formData);

                create_request.onload = function () {
                    if (this.status >= 200 && this.status < 400) {
                        // Success!
                        if (undefined != this.response && '' != this.response) {
                            var resp = JSON.parse(this.response);

                            if (resp.link != true) {
                                document.querySelector('#result').innerHTML = '<a href="' + resp.link + '">Смотреть ' + document.querySelector('#product_name').value + '</a>';
                            } else {
                                document.querySelector('#result').innerHTML = 'Что-то пошло не так...попробуйте снова';
                            }
                        }
                    }
                };
            }
        })
    }

    function allLetter(input) {
        var letters = /^[0-9А-Яа-яA-Za-z]+$/;

        if (input.match(letters)) {
            return true;
        } else {
            return false;
        }
    }

    function required(input) {
        if (input.length == 0) {
            return false;
        }
        return true;
    }

    function allnumeric(input) {
        var numbers = /^[0-9]+$/;
        if (input.match(numbers)) {
            return true;
        }
        else {
            return false;
        }
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
})