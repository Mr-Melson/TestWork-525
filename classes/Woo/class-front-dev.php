<?php
/**
 * Control product page in admin
 *
 * @package Abelohost\Core
 */

namespace Abelohost\Woo;

class Front_dev {

    /**
	 * Constructor. Initializes class autoloading.
	 */
	public function __construct() {

		add_action( 'wp_ajax_cstmpostajax', [ $this, 'cstmpostajax' ] );
		
		add_action( 'wp_ajax_create_product', [ $this, 'create_product' ] );
		add_action( 'wp_ajax_nopriv_create_product', [ $this, 'create_product' ] );

		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );
        add_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'cstm_woocommerce_template_loop_product_thumbnail' ], 10 );
	}

	public function cstmpostajax() {
		
		$return = false;
		$post_id = edit_post();
		if( $post_id ) $return = true;
		
		wp_send_json($return);
	}

	public function create_product() {

		$result = false;
		$link = '';
		if( !empty($_POST) ){

			$file_link = '';
			if ( $_FILES['newimg']['error'] == 0 ) {

				$valid_formats = array("img", "jpg", "png");
				$extension = pathinfo( $_POST['filename'], PATHINFO_EXTENSION );
			
				// Check if the file being uploaded is in the allowed file types
				if( ! in_array( strtolower( $extension ), $valid_formats ) ){
					// is not a valid format
					$fresult = false;
			
				} else{
					require_once( ABSPATH . 'wp-admin/includes/file.php' );
	
					$overrides = [ 'test_form' => false ];
	
					$movefile = wp_handle_upload( $_FILES["newimg"], $overrides );
	
					if ( $movefile && empty($movefile['error']) ) {
						$file_link = $movefile['url'];
					}
				}
			}

			if( !empty($_POST['product_name']) ){
				$post_data = array(
					'post_title'    => sanitize_text_field($_POST['product_name']),
					'post_type'		=> 'product',
					'post_status'   => 'publish',
					'post_author'   => 1,
				);
	
				$post_id = wp_insert_post( wp_slash($post_data) );
			}

			if( !is_wp_error($post_id) ){

				$result = true;
				$link = get_permalink($post_id);

				if( '' != $file_link ){
					update_post_meta( $post_id, 'pr_image', sanitize_text_field( $file_link ) );
				}
				if( '' != $_POST['date_create'] ){
					update_post_meta( $post_id, 'date_create', sanitize_text_field( $_POST['date_create'] ) );
				}
				if( '' != $_POST['type_of_product'] ){
					update_post_meta( $post_id, 'type_of_product', sanitize_text_field( $_POST['type_of_product'] ) );
				}
				if( '' != $_POST['price'] ){
					update_post_meta( $post_id, '_regular_price', sanitize_text_field( $_POST['price'] ) );
					update_post_meta( $post_id, '_price', sanitize_text_field( $_POST['price'] ) );
				}
			}
		}

		$return = array(
            'success' 	=> $result,
            'link'      => $link,
        );

        wp_send_json($return);
	}

	public function cstm_woocommerce_template_loop_product_thumbnail() {

        $pr_image = esc_url( get_post_meta( get_the_ID(), "pr_image", true ) );
        if( '' != $pr_image ){
            echo '<img src="'.$pr_image.'" alt="Thumb">';
        } else{
            echo woocommerce_get_product_thumbnail();
        }
	}

}