<?php
$wpcrm_notes_email_key    = get_option( 'wpcrm_notes_email_license_key' );
$wpcrm_notes_email_status = get_option( 'wpcrm_notes_email_license_status' );
?>

<tr valign="top">
	<th scope="row" valign="top">
		<?php _e( 'Notes & License Key', 'wp-crm-system-notes-email' ); ?>
	</th>
	<td>
		<input id="wpcrm_notes_email_license_key" name="wpcrm_notes_email_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $wpcrm_notes_email_key ); ?>" />
		<label class="description" for="wpcrm_notes_email_license_key"><?php _e( 'Enter your license key', 'wp-crm-system-notes-email' ); ?></label>
	</td>
</tr>
<?php if ( false !== $wpcrm_notes_email_key ) { ?>
	<tr valign="top">
		<th scope="row" valign="top">
		</th>
		<td>
			<?php if ( $wpcrm_notes_email_status !== false && $wpcrm_notes_email_status == 'valid' ) { ?>
				<span style="color:green;"><?php _e( 'active' ); ?></span>
				<?php wp_nonce_field( 'wpcrm_plugin_license_nonce', 'wpcrm_plugin_license_nonce' ); ?>
				<input type="submit" class="button-secondary" name="wpcrm_notes_email_deactivate" value="<?php _e( 'Deactivate License', 'wp-crm-system-notes-email' ); ?>"/>
				<?php
			} else {
				wp_nonce_field( 'wpcrm_plugin_license_nonce', 'wpcrm_plugin_license_nonce' );
				?>
				<input type="submit" class="button-secondary" name="wpcrm_notes_email_activate" value="<?php _e( 'Activate License', 'wp-crm-system-notes-email' ); ?>"/>
			<?php } ?>
		</td>
	</tr>
<?php } ?>
