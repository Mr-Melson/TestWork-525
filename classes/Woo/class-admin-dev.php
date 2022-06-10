<?php
/**
 * Init and control Woo
 *
 * @package Abelohost\Core
 */

namespace Abelohost\Woo;

class Admin_dev {

    /**
	 * Constructor. Initializes class autoloading.
	 */
	public function __construct() {

        add_filter( 'woocommerce_product_data_tabs', [ $this, 'custom_product_tabs' ] );
        add_filter( 'woocommerce_product_data_panels', [ $this, 'custom_field_product_tab_content' ] );

        add_action( 'woocommerce_process_product_meta_simple', [ $this, 'save_custom_field_option_fields' ]  );
        add_action( 'woocommerce_process_product_meta_variable', [ $this, 'save_custom_field_option_fields' ]  );

        add_action( 'manage_edit-product_columns' , [ $this, 'edit_product_column' ], 10, 2 );
        add_action( 'manage_product_posts_custom_column' , [ $this, 'custom_product_column' ], 10, 2 );

        add_action('post_submitbox_minor_actions', [ $this, 'add_custom_buttons_to_submitbox' ], 10 );
	}

    /*
    * Add Custom Tab to product data
    */
    public function custom_product_tabs( $original_tabs ) {

        $original_tabs['custom-field'] = array(
            'label'		=> 'Add-on Fields',
            'target'	=> 'custom_field',
            'class'		=> '',
            'priority'  => 1000,
        );
    
        return $original_tabs;
    }

    /*
    * Add content to custom tab
    */
    public function custom_field_product_tab_content() {

        global $post;
        
        ?>
        <div id='custom_field' class='panel woocommerce_options_panel'>

            <div class='options_group'>
                <?php

                woocommerce_wp_text_input( array(
                    'id'				=> 'date_create',
                    'label'				=> 'Дата создания',
                    'type' 				=> 'date',
                ) );
                
                woocommerce_wp_select( array(
                    'id'				=> 'type_of_product',
                    'label'				=> 'Тип товара',
                    'options' 		    => array(
                        ''  => 'Выберите тип товара',
                        'rare'      => 'Редкий',
                        'frequent'  => 'Частый',
                        'unusual'   => 'Необычный',
                    ),
                ) );

                $pr_image = get_post_meta($post->ID, "pr_image", true);

                ?>
                <p class="form-field pr_image_field d-flex">
                    <label for="pr_image">Изображение товара</label>
                    <img class="pr_image_url <?php if( '' == $pr_image ) echo 'hidden' ?>" src="<?php echo $pr_image ?>" alt="">
                    <input id="pr_image" class="pr_image_file" name="pr_image" type="text" value="<?php echo $pr_image ?>" hidden/>
                    <input class="upload_button" type="button" value="Загрузить" />
                    <input class="remove_button" type="button" value="Удалить" />
                </p>

            </div>

        </div>
        <?php
    }

    /**
    * Save the custom fields.
    */
    public function save_custom_field_option_fields( $post_id ) {

        if ( empty( $_POST['date_create'] ) ) :
            update_post_meta( $post_id, 'date_create', get_the_date( 'Y-m-d', $post_id ) );
        else:
            update_post_meta( $post_id, 'date_create', $_POST['date_create'] );
        endif;

        if ( isset( $_POST['type_of_product'] ) ) :
            update_post_meta( $post_id, 'type_of_product', $_POST['type_of_product'] );
        else:
            update_post_meta( $post_id, 'type_of_product', '' );
        endif;
        
        update_post_meta( $post_id, 'pr_image', $_POST['pr_image'] );
        
    }

    /**
    * Delete thumb as column and add image column into products admin page
    */
    public function edit_product_column( $columns ) {

        unset( $columns[ 'thumb' ] );
        $preview[ 'pr_image' ] = '<span class="wc-image tips">Картинка</span>';
        $columns = array_slice( $columns, 0, 1, true ) + $preview + array_slice( $columns, 1, NULL, true );

        return $columns;
    }

    /**
    * Add content for image column into products admin page
    */
    public function custom_product_column( $column, $post_id ) {

        switch ( $column ) {
    
            case 'pr_image' :
                $pr_image = get_post_meta( $post_id, "pr_image", true );
                if ( '' != $pr_image ){
                    echo '<a href="' . get_edit_post_link() . '">';
                    echo '<img class="pr_image_url" src="'.$pr_image.'" alt="thumb">';
                    echo '</a>';
                } else{
                    echo woocommerce_get_product_thumbnail();
                }
                break;
    
        }
    }

    /**
    * Add custom buttons to submitbox
    */
    public function add_custom_buttons_to_submitbox( $post ){

        if ( get_post_type( $post ) == 'product' ){
            echo '
            <div class="cstm-buttons">
                <div id="clear_cstm_fields" class="button-primary">Очистить</div>
                <div id="cstm-publish" class="button-primary">Обновить</div>
            </div>';
        }
    }

}