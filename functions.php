<?php
/**
 * Theme functions main file.
 *
 * @package Abelohost\Core
 */
define( 'THEME_DIR', get_stylesheet_directory() );
define( 'THEME_URL', get_stylesheet_directory_uri() );

require_once THEME_DIR . '/classes/class-core.php';

function TC() : \Abelohost\Core { //phpcs:ignore
	return \Abelohost\Core::instance();
}
TC();