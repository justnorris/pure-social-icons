<?php
/*
Plugin Name: Tipsy Social Icons
Plugin URI: http://tommcfarlin.com/tipsy-social-icons/
Description: The easiest way to add your social networks to your blog. Visit the <a href="http://tommcfarlin.com/tipsy-social-icons">plugin's homepage</a> for more information.
Version: 3.4
Author: Tom McFarlin
Author URI: http://tommcfarlin.com/
License:

    Copyright 2011 - 2013 Tom McFarlin (tom@tommcfarlin.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Tipsy_Social_Icons extends WP_Widget {


	protected $namespace = 'tipsy_social_';
	protected $networks = array(
		'behance',
		'deviantart',
		'digg',
		'dribbble',
		'email',
		'evernote',
		'facebook',
		'flickr',
		'forrst',
		'foursquare',
		'github',
		'googleplus',
		'instagram',
		'lastfm',
		'linkedin',
		'mixcloud',
		'picasa',
		'pinterest',
		'rdio',
		'rss',
		'skype',
		'soundcloud',
		'stackoverflow',
		'stumbleupon',
		'tumblr',
		'twitter',
		'vimeo',
		'yelp',
		'youtube',
		'zootool',
		'use_large_icons',
		'use_fade_effect',
		'tooltip_position'
	);

	protected $tipsy_options = array(
		'use_large_icons',
		'use_fade_effect',
		'tooltip_position'
	);

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	/**
	 * The widget constructor. Specifies the classname and description, instantiates
	 * the widget, loads localization files, and includes necessary scripts and
	 * styles.
	 */
	function Tipsy_Social_Icons() {

		add_action( 'init', array( $this, 'plugin_textdomain' ) );

		parent::__construct(
			'tipsy-social-icons',
			__( 'Tipsy Social Icons', 'tipsy-social-icons' ),
			array (
				'classname'  => 'tipsy-social-icons',
				'description'  => __( 'Displays icons for all of your social networks.', 'tipsy-social-icons' )
			)
		);

		add_action( 'admin_print_styles', array( &$this, 'register_admin_styles' ) );

		add_action( 'wp_enqueue_scripts', array( &$this, 'register_widget_styles' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'register_widget_scripts' ) );

	} // end constructor


	/*--------------------------------------------------*/
	/* Get all Plugin Options
	/*--------------------------------------------------*/
	public function get_tipsy_options() {
		return array_merge( $this -> networks, $this -> tipsy_options );
	}


	/*--------------------------------------------------*/
	/* Core Widget API Functions
	/*--------------------------------------------------*/

	/**
	 * Outputs the content of the widget.
	 *
	 * @args   The array of form elements
	 * @instance  The current instance of the widget
	 */
	function widget( $args, $instance ) {

		extract( $args, EXTR_SKIP );

		echo $before_widget;


		// BEWARE:
		// Variable-Variables Here!
		// Instead, we should just call upon the object itself or use an array.
		foreach ( $this -> get_tipsy_options() as $option ) {
			$instance[$option] = $this -> _strip( $instance, $option );

			// This part right here is going to become the shorthand like this some day again.
			// For now (for backwards compatibility, apply filters TWICE :[  )
			// $$option = empty( $instance[$option] ) ? '' : apply_filters( $this -> namespace . $option, $instance[$option] );
			if ( empty( $instance[$option] ) ) {
				$$option = '';
			}

			else {
				$$option = apply_filters( $this -> namespace . $option, $instance[$option] );
				$$option = apply_filters( $option, $$option ); // This is dirty. I feel dirty.
			}
		}

		// Remove old instances of posterous since this has been removed
		if ( isset( $instance['posterous'] ) ) unset( $instance['posterous'] );

		include plugin_dir_path( __FILE__ ) . '/views/widget.php';

		echo $after_widget;

	} // end widget

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @new_instance The previous instance of values before the update.
	 * @old_instance The new instance of values to be generated via the update.
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		foreach ( $this -> get_tipsy_options() as $option ) {
			$instance[$option] = $this -> _strip( $new_instance, $option );
		}

		return $instance;

	} // end widget

	/**
	 * Generates the administration form for the widget.
	 *
	 * @instance The array of keys and values for the widget.
	 */
	function form( $instance ) {
		$all_tipsy_options = $this -> get_tipsy_options();

		$instance = wp_parse_args(
			(array)$instance,
			array_fill_keys( $all_tipsy_options , '' )
		);

		// Remove old instances of posterous since this has been removed
		if ( isset( $instance['posterous'] ) ) unset( $instance['posterous'] );


		foreach ( $all_tipsy_options as $option ) {
			// BEWARE:
			// Variable-Variable Here!
			// Instead, we should just call upon the object itself or use an array.
			$$option = $this -> _strip ( $instance, $option );
		}


		include plugin_dir_path( __FILE__ ) . '/views/admin.php';

	} // end form

	/*--------------------------------------------------*/
	/* Public Functions
	/*--------------------------------------------------*/

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {
		wp_enqueue_style( 'tipsy-social-icons', plugins_url( 'tipsy-social-icons/css/admin.css' ) );
	} // end register_admin_styles

	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function register_widget_styles() {
		wp_enqueue_style( 'tipsy-social-icons', plugins_url( 'tipsy-social-icons/css/widget.css' ) );
	} // end register_widget_styles

	/**
	 * Registers and enqueues widget-specific scripts.
	 */
	public function register_widget_scripts() {
		wp_enqueue_script( 'tipsy-social-icons', plugins_url( 'tipsy-social-icons/js/widget.min.js' ), array( 'jquery' ) );
	} // end register_widget_styles

	/**
	 * Loads the plugin text domain for translation
	 */
	public function plugin_textdomain() {
		load_plugin_textdomain( 'tipsy-social-icons', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
	} // end plugin_textdomain

	/*--------------------------------------------------*/
	/* Private Functions
	/*--------------------------------------------------*/

	/**
	 * Convenience method for stripping tags and slashes from the content
	 * of a form input.
	 *
	 */
	private function _strip( $obj, $title ) {
		return strip_tags( stripslashes( $obj[ $title ] ) );
	} // end _strip

} // end class
add_action( 'widgets_init', create_function( '', 'register_widget( "Tipsy_Social_Icons" );' ) );

?>
