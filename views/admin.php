<?php
$networks = $this -> get_instance_networks($instance);
$options = $this -> get_instance_options($instance);
?>

<div class="tipsy-social-icons">
	<label><?php _e('Social Icons:', 'tipsy-social-icons'); ?></label>
	<p class="description"><?php _e( 'Provide the full address to your profile. If not provided, the icon will not display.', 'tipsy-social-icons' ); ?></p>
	<?php
		foreach( $networks as $key => $val ): 
	?>
			<div class="icon-group">
				<img src="<?php echo  WP_PLUGIN_URL . '/tipsy-social-icons/images/16/' . $key . '_16.png';  ?>" alt="<?php echo $key; ?>" title="<?php echo ucfirst( $key ); ?>" />
				<input type="text" value="<?php echo esc_attr( $val ) ?>" name="<?php echo $this->get_field_name( $key ); ?>" id="<?php echo $this->get_field_id( $key ); ?>" class="icon-url" placeholder="<?php echo ucfirst( $key ); ?>" />
			</div><!-- /.icon-group -->
	
	<?php 
		endforeach;
	?>
</div><!-- /.tipsy-social-icons -->

<div class="tipsy-display-options">
	<?php if( isset( $option['use_large_icons'] ) ): ?>
		<div>
			<?php _e( 'Display ', 'tipsy-social-icons' ); ?>
			<select id="<?php echo $this->get_field_id( 'use_large_icons' ); ?>" name="<?php echo $this->get_field_name( 'use_large_icons' ); ?>">
				<option value="small" <?php selected( 'small', $instance['use_large_icons'], true ); ?>><?php _e( 'small', 'tipsy-social-icons' ); ?></option>
				<option value="large" <?php selected( 'large', $instance['use_large_icons'], true ); ?>><?php _e( 'large', 'tipsy-social-icons' ); ?></option>
			</select>
			<?php _e( ' icons.', 'tipsy-social-icons' ); ?>
		</div>
	<?php endif; ?>

	<?php if( isset( $option['use_fade_effect'] ) ): ?>
		<div>
			<select id="<?php echo $this->get_field_id( 'use_fade_effect' ); ?>" name="<?php echo $this->get_field_name( 'use_fade_effect' ); ?>">
				<option value="disable" <?php selected( 'disable', $instance['use_fade_effect'], true ); ?>><?php _e( 'Disable', 'tipsy-social-icons' ); ?></option>
				<option value="enable" <?php selected( 'enable', $instance['use_fade_effect'], true ); ?>><?php _e( 'Enable', 'tipsy-social-icons' ); ?></option>
			</select>
			<?php _e( ' hover fade effect.', 'tipsy-social-icons' ); ?>
		</div>
	<?php endif; ?>

	<?php if (isset( $option['tooltip_position'] ) ): ?>
		<div>
			<?php _e( 'Icon tooltip is ', 'tipsy-social-icons' ); ?>
			<select id="<?php echo $this->get_field_id( 'tooltip_position' ); ?>" name="<?php echo $this->get_field_name( 'tooltip_position' ); ?>">
				<option value="above" <?php selected( 'above', $instance['tooltip_position'], true ); ?>><?php _e( 'above', 'tipsy-social-icons' ); ?></option>
				<option value="below" <?php selected( 'below', $instance['tooltip_position'], true ); ?>><?php _e( 'below', 'tipsy-social-icons' ); ?></option>
				<option value="off" <?php selected( 'off', $instance['tooltip_position'], true ); ?>><?php _e( 'off', 'tipsy-social-icons' ); ?></option>
			</select>
			<?php _e( '.', 'tipsy-social-icons' ); ?>
		</div>
	<?php endif; ?>
</div><!-- /.tipsy-display-options -->

<div class="tipsy-notice">
	<p>
		<?php _e( '<strong>Like this plugin?</strong> Consider <a href="http://tommcfarlin.com/tipsy-social-icons" target="_blank">donating</a>.', 'tipsy-social-icons' ); ?>
	</p>
</div><!-- /.tipsy-notice -->