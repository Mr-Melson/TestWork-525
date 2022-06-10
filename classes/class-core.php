<?php
/**
 * Core class.
 *
 * @package Abelohost\Core
 */

namespace Abelohost;

/**
 * Core class implementation.
 */
final class Core {

	/**
	 * Base path for classes within package.
	 *
	 * @var [type]
	 */
	public static $classes_base_path;

	/**
	 * Core class instance (singleton).
	 *
	 * @var Core
	 */
	protected static $instance = null;

	/**
	 * Add your class instances here
	 *
	 * Each class you want to make a part of core should be deсlared
	 * (with initial value null) and documented in section below
	 */

	/**
	 * Constructor. Initializes class autoloading.
	 */
	public function __construct() {

		self::$classes_base_path = untrailingslashit( dirname( __FILE__ ) );
		spl_autoload_register( __CLASS__ . '::autoload' );

		new Setup_Theme();
		new Menu\Menu();
		new Woo\Admin_dev();
		new Woo\Fron_dev();
	}

	/**
	 * Get class instance. Ensure there can be only one.
	 *
	 * @return Core
	 */
	public static function instance() : Core {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Autoload handler.
	 *
	 * @param string $class_name - name of the class to load.
	 * @return void
	 */
	public static function autoload( $class_name ) {

		if ( 0 !== strpos( $class_name, __NAMESPACE__ ) ) {
			return;
		}

		$class_name = str_replace( __NAMESPACE__ . '\\', '', $class_name );
		$class = explode( '\\', $class_name );
		$class_file = 'class-' . str_replace( '_', '-', strtolower( array_pop( $class ) ) ) . '.php';
		$class_path = self::$classes_base_path . DIRECTORY_SEPARATOR . implode( DIRECTORY_SEPARATOR, $class );

		require_once $class_path . DIRECTORY_SEPARATOR . $class_file;
	}
}
