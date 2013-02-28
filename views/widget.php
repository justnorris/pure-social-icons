<?php
$networks = $this -> get_instance_networks($instance);
$options = $this -> get_instance_options($instance);

$options['icon_size'] = ( $this -> get_tipsy_option('use_large_icons', $instance)  == 'large' ) ? '32' : '16' ;
$tooltip_position = ( $position = $this -> get_tipsy_option( 'tooltip_position', $instance ) ) ? " tooltip-position-".$position : null;
?>
<div class="tipsy-social-icon-container">
	<ul class="tipsy-social-icons<?php echo $tooltip_position; ?> "><?php 
		
		foreach( $networks as $network => $network_value ) { 
				if( $network_value != '' ) { ?>
					<li>
						<?php 
							$this -> render_icon(
								array(
									'network' => $network,
									'network_value' => $network_value,
									'options' => $options,
									)
							);
						?>
						
					</li><?php
				} // end if
		} // end foreach 
	?></ul><!-- /.tipsy-social-icons -->
<!--
Licensing For Several Icons:
If you use these icons, please place an attribution link to komodomedia.com. Social Network Icon Pack by Rogie King is licensed under a Creative Commons Attribution-Share Alike 3.0 Unported License (http://creativecommons.org/licenses/by-nc-sa/3.0/). I claim no right of ownership to the respective company logos and glyphs in each one of these icons.
-->
</div><!-- /.tipsy-social-icon-container -->
