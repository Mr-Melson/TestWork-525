<?php
/**
 * Init and control CPT Menu
 *
 * @package Abelohost\Core
 */

namespace Abelohost\Menu;

class Menu {

    /**
	 * Constructor. Initializes class autoloading.
	 */
	public function __construct() {

        add_theme_support( 'menus' );
        add_action( 'after_setup_theme', [ $this, 'theme_register_nav_menu' ] );
	}

    public function theme_register_nav_menu() {
        register_nav_menu( 'mainmenu', 'Main Menu' );
    }
}