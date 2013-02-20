<div class="tipsy-social-icon-container">
	<ul class="tipsy-social-icons tooltip-position-<?php echo $tooltip_position; ?>"><?php 
		$icon_size = ( 'large' == $use_large_icons ? '32' : '16' );
		foreach( $instance as $key => $val ) { 
			if( 'use_large_icons' != $key && 'use_fade_effect' != $key && 'tooltip_position' != $key ) {
				if( $instance[$key] != '' ) { ?>
					<li>
						<a href="<?php echo $key == 'email' ? 'mailto:' . $val : $val; ?>" class="<?php echo 'enable' == $use_fade_effect ? 'fade' : 'no-fade'; ?>" target="_blank">
							<img src="<?php echo  plugins_url( '/tipsy-social-icons/images/' . $icon_size . '/' . $key . '_' . $icon_size . '.png' ); ?>" alt="<?php echo ucfirst( $key ); ?>" class="tipsy-social-icons" />
						</a>
					</li><?php
				} // end if
			} // end if
		} // end foreach 
	?></ul><!-- /.tipsy-social-icons -->
<!--
Licensing For Several Icons:
If you use these icons, please place an attribution link to komodomedia.com. Social Network Icon Pack by Rogie King is licensed under a Creative Commons Attribution-Share Alike 3.0 Unported License (http://creativecommons.org/licenses/by-nc-sa/3.0/). I claim no right of ownership to the respective company logos and glyphs in each one of these icons.
-->
</div><!-- /.tipsy-social-icon-container -->