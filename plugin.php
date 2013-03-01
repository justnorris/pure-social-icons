<?php
/*
Plugin Name: Pure Social Icons
Plugin URI: http://www.puremellow.com/social-icons
Description: Pure Social Icons aims to be a simple social icon widget, while still giving the power of visual customization to theme developers.
Version: 3.4
Author: Pure Mellow
Author URI: http://www.puremellow.com
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
		'zootool'
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
			__( 'Pure Social Icons', 'pure-social-icons' ),
			array (
				'classname'  => 'tipsy-social-icons',
				'description'  => __( 'Displays icons for all of your social networks.', 'tipsy-social-icons' )
			)
		);

		add_action( 'admin_print_styles', array( &$this, 'register_admin_styles' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'register_widget_styles' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'register_widget_scripts' ) );

		// Allow to modify the networks available
		$this -> networks = apply_filters( $this -> namespace . "networks", $this -> networks ) ;

		// Allow to modify the options available
		$this -> tipsy_options = apply_filters( $this -> namespace . "options", $this -> tipsy_options ) ;

	} // end constructor


	/**
	 * Return Only the available Options
	 * @return (array) $this -> tipsy_options
	 */
	public function get_tipsy_options() {
		return array_merge( $this -> networks, $this -> tipsy_options );
	}

	/**
	 * Get Tipsy Option, and make sure it's there
	 * @param  (string)				 $option Which option to get ?
	 * @return (mixed bool|string)   $option Value or False if failed
	 */
	public function get_tipsy_option( $option, $from ) {
		
		if ( isset( $from[$option] ) ) {
			return $from[$option];
		}

		return false;
	}

	/**
	 * Get instance options
	 * @param  (array) $instance
	 * @return (array) Only the Options
	 */
	public function get_instance_options( $instance ) {
		return array_intersect_key( $instance, array_fill_keys( $this -> tipsy_options, null ) );
	}

	/**
	 * Get instance options
	 * @param  (array) $instance
	 * @return (array) Only the Networks
	 */
	public function get_instance_networks( $instance ) {
		return array_intersect_key( $instance, array_fill_keys( $this -> networks, null ) );
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

		foreach ( $this -> get_tipsy_options() as $option ) {
			$instance[$option] = $this -> _strip( $instance, $option );

			/* This part right here is going to become the shorthand like this some day again.
			 * For now (for backwards compatibility, apply filters TWICE :[  )
			 * $instance[$option] = empty( $instance[$option] ) ? '' : apply_filters( $this -> namespace . $option, $instance[$option] );
			 */

			if ( empty( $instance[$option] ) ) {
				$instance[$option] = '';
			}

			else {
				$instance[$option] = apply_filters( $this -> namespace . $option, $instance[$option] );
				$instance[$option] = apply_filters( $option, $instance[$option] ); // This is dirty. I feel dirty.
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
			$instance[$option] = $this -> _strip ( $instance, $option );
		}

		include plugin_dir_path( __FILE__ ) . '/views/admin.php';

	} // end form


	/**
	 * Renders an icon
	 * @uses do_action
	 * @param  (array) $args The instance arguments (network name, value, etc.)
	 * @return none    Don't return anything. This prints data out.
	 */
	public function render_icon( $args ) {
		// If there is an action hook, display that instead
		if ( has_action ( $this -> namespace . "render_icon" ) ):
			do_action ( $this -> namespace . "render_icon", $args );
		
		// Otherwise just display the default way
		else:
			extract( $args, EXTR_SKIP );
?>

		<a href="<?php echo $network == 'email' ? 'mailto:' . $network_value : $network_value; ?>" class="<?php echo 'enable' == $options['use_fade_effect'] ? 'fade' : 'no-fade'; ?>" target="_blank">
			<img src="<?php echo  plugins_url( '/tipsy-social-icons/images/' . $options['icon_size'] . '/' . $network . '_' . $options['icon_size'] . '.png' ); ?>" alt="<?php echo ucfirst( $network ); ?>" class="tipsy-social-icons" />
		</a>

		<?php
		endif;
	}



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