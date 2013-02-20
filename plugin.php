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
				'classname' 	=> 'tipsy-social-icons',
				'description' 	=> __( 'Displays icons for all of your social networks.', 'tipsy-social-icons' )
			)
		);
		
		add_action( 'admin_print_styles', array( &$this, 'register_admin_styles' ) );
		
		add_action( 'wp_enqueue_scripts', array( &$this, 'register_widget_styles' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'register_widget_scripts' ) );
		
	} // end constructor

	/*--------------------------------------------------*/
	/* Core Widget API Functions
	/*--------------------------------------------------*/
	
	/**
	 * Outputs the content of the widget.
	 *
	 * @args			The array of form elements
	 * @instance		The current instance of the widget
	 */
	function widget( $args, $instance ) {
		
		extract( $args, EXTR_SKIP );
		
		echo $before_widget;
		
		$behance = empty( $instance['behance'] ) ? '' : apply_filters( 'behance', $instance['behance'] );
		$deviantart = empty( $instance['deviantart'] ) ? '' : apply_filters( 'deviantart', $instance['deviantart'] );
		$digg = empty( $instance['digg'] ) ? '' : apply_filters( 'digg', $instance['digg'] );
		$dribbble = empty( $instance['dribbble'] ) ? '' : apply_filters( 'dribbble', $instance['dribbble'] );
		$email = empty( $instance['email'] ) ? '' : apply_filters( 'email', $instance['email'] );
		$evernote = empty( $instance['evernote'] ) ? '' : apply_filters( 'evernote', $instance['evernote'] );
		$facebook = empty( $instance['facebook'] ) ? '' : apply_filters( 'facebook', $instance['facebook'] );
		$flickr = empty( $instance['flickr'] ) ? '' : apply_filters( 'flickr', $instance['flickr'] );
		$forrst = empty( $instance['forrst'] ) ? '' : apply_filters( 'forrst', $instance['forrst'] );
		$foursquare = empty( $instance['foursquare'] ) ? '' : apply_filters( 'foursquare', $instance['foursquare'] );
		$github = empty( $instance['github'] ) ? '' : apply_filters( 'github', $instance['github'] );
		$googleplus = empty( $instance['googleplus'] ) ? '' : apply_filters( 'googleplus', $instance['googleplus'] );
		$instagram = empty( $instance['instagram'] ) ? '' : apply_filters( 'instagram', $instance['instagram'] );
		$lastfm = empty( $instance['lastfm'] ) ? '' : apply_filters( 'lastfm', $instance['lastfm'] );
		$mixcloud = empty( $instance['mixcloud'] ) ? '' : apply_filters( 'mixcloud', $instance['mixcloud'] );
		$linkedin = empty( $instance['linkedin'] ) ? '' : apply_filters( 'linkedin', $instance['linkedin'] );
		$picasa = empty( $instance['picasa'] ) ? '' : apply_filters( 'picasa', $instance['picasa'] );
		$pinterest = empty( $instance['pinterest'] ) ? '' : apply_filters( 'pinterest', $instance['pinterest'] );
		$rdio = empty( $instance['rdio'] ) ? '' : apply_filters( 'rdio', $instance['rdio'] );
		$rss = empty( $instance['rss'] ) ? '' : apply_filters( 'rss', $instance['rss'] );
		$skype = empty( $instance['skype'] ) ? '' : apply_filters( 'skype', $instance['skype'] );
		$soundcloud = empty( $instance['soundcloud'] ) ? '' : apply_filters( 'soundcloud', $instance['soundcloud'] );
		$stackoverflow = empty( $instance['stackoverflow'] ) ? '' : apply_filters( 'stackoverflow', $instance['stackoverflow'] );
		$stumbleupon = empty( $instance['stumbleupon'] ) ? '' : apply_filters( 'stumbleupon', $instance['stumbleupon'] );
		$tumblr = empty( $instance['tumblr'] ) ? '' : apply_filters( 'tumblr', $instance['tumblr'] );
		$twitter = empty( $instance['twitter'] ) ? '' : apply_filters( 'twitter', $instance['twitter'] );
		$vimeo = empty( $instance['vimeo'] ) ? '' : apply_filters( 'vimeo', $instance['vimeo'] );
		$yelp = empty( $instance['yelp'] ) ? '' : apply_filters( 'yelp', $instance['yelp'] );
		$youtube = empty( $instance['youtube'] ) ? '' : apply_filters( 'youtube', $instance['youtube'] );
		$zootool = empty( $instance['zootool'] ) ? '' : apply_filters( 'zootool', $instance['zootool'] );
	    
		$use_large_icons = empty( $instance['use_large_icons'] ) ? '' : apply_filters('use_large_icons', $instance['use_large_icons'] );
		$use_fade_effect = empty( $instance['use_fade_effect'] ) ? '' : apply_filters( 'use_fade_effect', $instance['use_fade_effect'] );
		$tooltip_position = empty( $instance['tooltip_position'] ) ? '' : apply_filters( 'tooltip_position', $instance['tooltip_position'] ); 
		
		// Remove old instances of posterous since this has been removed
		if( isset( $instance['posterous'] ) ) unset( $instance['posterous'] );
		
		include( plugin_dir_path( __FILE__ ) . '/views/widget.php' );
		
		echo $after_widget;
		
	} // end widget
	
	/**
	 * Processes the widget's options to be saved.
	 *
	 * @new_instance	The previous instance of values before the update.
	 * @old_instance	The new instance of values to be generated via the update.
	 */
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['behance'] = $this->_strip( $new_instance, 'behance' );
		$instance['deviantart'] = $this->_strip( $new_instance, 'deviantart' );
		$instance['digg'] = $this->_strip( $new_instance, 'digg' );
		$instance['dribbble'] = $this->_strip( $new_instance, 'dribbble' );
		$instance['email'] = $this->_strip( $new_instance, 'email' );
		$instance['evernote'] = $this->_strip( $new_instance, 'evernote' );
		$instance['facebook'] = $this->_strip( $new_instance, 'facebook' );
		$instance['flickr'] = $this->_strip( $new_instance, 'flickr' );
		$instance['forrst'] = $this->_strip( $new_instance, 'forrst' );
		$instance['foursquare'] = $this->_strip( $new_instance, 'foursquare' );
		$instance['github'] = $this->_strip( $new_instance, 'github' );
		$instance['googleplus'] = $this->_strip( $new_instance, 'googleplus' );
		$instance['instagram'] = $this->_strip( $new_instance, 'instagram' );
		$instance['lastfm'] = $this->_strip( $new_instance, 'lastfm' );
		$instance['linkedin'] = $this->_strip( $new_instance, 'linkedin' );
		$instance['mixcloud'] = $this->_strip( $new_instance, 'mixcloud' );
		$instance['picasa'] = $this->_strip( $new_instance, 'picasa' );
		$instance['pinterest'] = $this->_strip( $new_instance, 'pinterest' );
		$instance['rdio'] = $this->_strip( $new_instance, 'rdio' );
		$instance['rss'] = $this->_strip( $new_instance, 'rss' );
		$instance['skype'] = $this->_strip( $new_instance, 'skype' );
		$instance['soundcloud'] = $this->_strip( $new_instance, 'soundcloud' );
		$instance['stackoverflow'] = $this->_strip( $new_instance, 'stackoverflow' );
		$instance['stumbleupon'] = $this->_strip( $new_instance, 'stumbleupon' );
		$instance['tumblr'] = $this->_strip( $new_instance, 'tumblr' );
		$instance['twitter'] = $this->_strip( $new_instance, 'twitter' );
		$instance['vimeo'] = $this->_strip( $new_instance, 'vimeo' );
		$instance['yelp'] = $this->_strip( $new_instance, 'yelp' );
		$instance['youtube'] = $this->_strip( $new_instance, 'youtube' );
	    $instance['zootool'] = $this->_strip( $new_instance, 'zootool' );
	    
		$instance['use_large_icons'] = $this->_strip( $new_instance, 'use_large_icons' );
		$instance['use_fade_effect'] = $this->_strip( $new_instance, 'use_fade_effect' );
		$instance['tooltip_position'] = $this->_strip( $new_instance, 'tooltip_position' );
		
		return $instance;
		
	} // end widget
	
	/**
	 * Generates the administration form for the widget.
	 *
	 * @instance	The array of keys and values for the widget.
	 */
	function form($instance) {
	
		$instance = wp_parse_args(
			(array)$instance,
			array(
				'behance'			=> '',
				'deviantart' 		=> '',
				'digg' 				=> '',
				'dribbble' 			=> '',
				'email' 			=> '',
				'evernote'			=> '',
				'facebook' 			=> '',
				'flickr' 			=> '',
				'forrst' 			=> '',
				'foursquare' 		=> '',
				'github'	 		=> '',
				'googleplus' 		=> '',
				'instagram'			=> '',
				'lastfm' 			=> '',
				'linkedin' 			=> '',
				'mixcloud' 			=> '',
				'picasa'	 		=> '',
				'pinterest' 		=> '',
				'rdio' 				=> '',
				'rss' 				=> '',
				'skype' 			=> '',
				'soundcloud'		=> '',
				'stackoverflow'		=> '',
				'stumbleupon'		=> '',
				'tumblr' 			=> '',
				'twitter' 			=> '',
				'vimeo' 			=> '',
				'yelp' 				=> '',
				'youtube' 			=> '',
				'zootool' 			=> '',
				'use_large_icons' 	=> '',
				'use_fade_effect' 	=> '',
				'tooltip_position' 	=> ''
			)
		);
		
		// Remove old instances of posterous since this has been removed
		if( isset( $instance['posterous'] ) ) unset( $instance['posterous'] );
		
		$behance = $this->_strip( $instance, 'behance' );
		$deviantart = $this->_strip( $instance, 'deviantart' );
		$digg = $this->_strip( $instance, 'digg' );
		$dribbble = $this->_strip( $instance, 'dribbble' );
		$email = $this->_strip( $instance, 'email' );
		$evernote = $this->_strip( $instance, 'evernote' );
		$facebook = $this->_strip( $instance, 'facebook' );
		$flickr = $this->_strip( $instance, 'flickr' );
		$forrst = $this->_strip( $instance, 'forrst' );
		$foursquare = $this->_strip( $instance, 'foursquare' );
		$github = $this->_strip( $instance, 'github' );
	    $googleplus = $this->_strip( $instance, 'googleplus' );
	    $instagram = $this->_strip( $instance, 'instagram' );
		$lastfm = $this->_strip( $instance, 'lastfm' );
		$linkedin = $this->_strip( $instance, 'linkedin' );
		$linkedin = $this->_strip( $instance, 'mixcloud' );
		$picasa = $this->_strip( $instance, 'pinterest' );
		$pinterest = $this->_strip( $instance, 'pinterest' );
		$rdio = $this->_strip( $instance, 'rdio' );
		$rss = $this->_strip( $instance, 'rss' );
		$skype = $this->_strip( $instance, 'skype' );
		$soundcloud = $this->_strip( $instance, 'soundcloud' );
		$stackoverflow = $this->_strip( $instance, 'stackoverflow' );
		$stumbleupon = $this->_strip( $instance, 'stumbleupon' );
		$tumblr = $this->_strip( $instance, 'tumblr' );
		$twitter = $this->_strip( $instance, 'twitter' );
		$vimeo = $this->_strip( $instance, 'vimeo' );
		$yelp = $this->_strip( $instance, 'yelp' );
		$youtube = $this->_strip( $instance, 'youtube' );
		$zootool = $this->_strip( $instance, 'zootool' );
	    
		$use_large_icons = $this->_strip( $instance, 'use_large_icons' );
		$use_fade_effect = $this->_strip( $instance, 'use_fade_effect' );
		$tooltip_position = $this->_strip( $instance, 'tooltip_position' );

		include(  plugin_dir_path( __FILE__ ) . '/views/admin.php' );
		
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
	 * @obj			The instance of the argument array
	 * @title		The title of the element from which we're stripping tags and slashes.
	 */
	private function _strip( $obj, $title ) {
		return strip_tags( stripslashes( $obj[ $title ] ) );
	} // end _strip
	
} // end class
add_action( 'widgets_init', create_function( '', 'register_widget( "Tipsy_Social_Icons" );' ) );

?>