<?php
/*
Template Name: CREATE PRODUCT
*/

get_header();
the_post();

?>
<section>
    <div class="container">
        <div class="row mb-5 mt-5">
            <div class="col-md-6">
                <h1>Создание продукта</h1>
                <div class="row mt-5">
                    <div class="col-md-6 mb-3">
                        <input id="product_name" name="product_name" type="text" value="" placeholder="Название">
                    </div>
                    <div class="col-md-6 mb-3">
                        <input id="price" name="price" type="number" value="" placeholder="Цена" min=0>
                    </div>
                    <div class="col-md-6 mb-3">
                        <input id="date_create" name="date_create" type="date" value="" placeholder="Дата создания">
                    </div>
                    <div class="col-md-6 mb-3">
                        <select id="type_of_product" name="type_of_product">
                            <option default="" disabled="" selected="" hidden=""></option>
                            <option value="rare">Редкий</option>
                            <option value="frequent">Частый</option>
                            <option value="unusual">Необычный</option>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <input id="newimg" type="file" name="newimg" placeholder="Выберите файл" accept=".jpeg,.png,.jpg">
                    </div>
                    <div class="col-12 mb-3">
                        <input id="create_product" type="submit" value="Создать">
                    </div>
                    <div class="col-12 mb-3">
                        <div id="result"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
get_footer();
