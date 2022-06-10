<?php
/**
 * Setup theme features and core functions.
 *
 * @package Abelohost\Core
 */

namespace Abelohost;

/**
 * Setup theme main features
 *
 * @package Abelohost
 */
class Setup_Theme {

	const THEME_ID = 'Abelohost';

	/**
	 * Identifier to determine which assets to load
	 *
	 * @var string
	 */
	public $assets_id = null;

	/**
	 * Constructor.
	 */
	public function __construct() {

		define( 'THEME_VSN', 'v1.0.0' );

		add_theme_support( 'post-thumbnails' );
		add_filter( 'template_include', [ $this, 'set_assets' ], PHP_INT_MAX );

		add_theme_support( 'woocommerce' );

		add_action( 'wp_enqueue_scripts', [ $this, 'theme_scripts' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'theme_styles' ] );

		add_action( 'admin_menu', [ $this, 'wpexplorer_remove_menus' ] );

		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts_action' ] );
	}

	/**
	 * Reads Assets ID from template header and sets releveant class variable.
	 * Post meta 'assets_id' if set will override value from template.
	 *
	 * @param string $template - template name.
	 * @return string
	 */
	public function set_assets( $template ) {

		$data = get_file_data( $template, [ 'assetsID' => 'Assets ID' ] );

		if ( $data['assetsID'] ) {
			$this->assets_id = $data['assetsID'];
		} else {
			$this->assets_id = 'index';
		}

		if ( is_singular() ) {
			global $post;
			if ( get_post_meta( $post->ID, 'assets_id', true ) ) {
				$this->assets_id = get_post_meta( $post->ID, 'assets_id', true );
			}
		}

		return $template;
	}

	/**
	 * Register theme styles.
	 *
	 * @return void
	 */
	public function theme_styles() {

		wp_enqueue_style( self::THEME_ID . "-main-css", THEME_URL . "/assets/css/main.css", [], THEME_VSN, 'all' );
		wp_enqueue_style( self::THEME_ID . "-bootstrap-css", THEME_URL . "/assets/css/bootstrap.css", [], THEME_VSN, 'all' );
	}

	public function admin_enqueue_scripts_action(){

        wp_enqueue_style( 'cstm-admin-css', THEME_URL .'/assets/css/admin.css', [], THEME_VSN, 'all' );
        wp_enqueue_script( 'cstm-admin-js', THEME_URL .'/assets/js/admin.js', [], THEME_VSN, 'all' );
    }

	/**
	 * Register theme scripts.
	 *
	 * @return void
	 */
	public function theme_scripts() {

		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', 'https://code.jquery.com/jquery-3.3.1.min.js', false, null, true );
		wp_enqueue_script( 'jquery' );

		wp_enqueue_script( self::THEME_ID . "main-js", THEME_URL . "/assets/js/main.js", [], THEME_VSN, true );
	}

	public function wpexplorer_remove_menus() {
		remove_menu_page( 'edit.php' );
	}

}
