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
                <div class="create_product_form">
                    <h1>Создание продукта</h1>
                    <div class="row mt-5">
                        <div class="col-md-6 mb-3">
                            <label for="product_name">Название продукта</label>
                            <p>
                                <input id="product_name" name="product_name" type="text" value="" placeholder="Название">
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="price">Цена продукта</label>
                            <p>
                                <input id="price" name="price" type="number" value="" placeholder="Цена" min=0>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_create">Дата создания</label>
                            <p>
                                <input id="date_create" name="date_create" type="date" value="" placeholder="Дата создания">
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type_of_product">Тип продукта</label>
                            <p>
                                <select id="type_of_product" name="type_of_product">
                                    <option default="" disabled="" selected="" hidden=""></option>
                                    <option value="rare">Редкий</option>
                                    <option value="frequent">Частый</option>
                                    <option value="unusual">Необычный</option>
                                </select>
                            </p>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="type_of_product">Тип продукта</label>
                            <p>
                                <input id="newimg" type="file" name="newimg" placeholder="Выберите файл" accept=".jpeg,.png,.jpg">
                            </p>
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
    </div>
</section>
<?php
get_footer();
