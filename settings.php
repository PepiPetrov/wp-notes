<?php
$notes_email_fields = array(
	array(
		'id'    => 'wpcrm_notes_email_app_key',
		'name'  => __( 'Notes & Email App Key', 'wp-crm-system-notes-email' ),
		'input' => 'text',
		'more'  => '<a href="https://www.test.com/developers/apps/create" target="_blank">' . __( 'Click here to create an app key', 'wp-crm-system-notes-email' ) . '</a>.',
	),
); ?>
<div class="wrap">
	<div>
		<h2><?php _e( 'Notes & Email Settings', 'wp-crm-system-notes-email' ); ?></h2>
		<form method="post" action="options.php">
			<?php
				wp_nonce_field( 'wpcrm-notes_email' );
				settings_fields( 'wpcrm_system_notes_email_settings_group' );
			?>
			<table style="border-collapse: collapse;">
				<tbody>
				<?php foreach ( $notes_email_fields as $notes_email_field ) { ?>
					<tr>
						<td>
							<strong><?php echo $notes_email_field['name']; ?></strong><br />
							<?php echo $notes_email_field['more']; ?>
						</td>
						<td colspan="2">
							<input type="<?php echo $notes_email_field['input']; ?>" id="<?php echo $notes_email_field['id']; ?>" name="<?php echo $notes_email_field['id']; ?>" value="<?php echo get_option( $notes_email_field['id'] ); ?>" />
						</td>
					</tr>
					<?php } ?>
					<tr><td><input type="hidden" name="action" value="update" /><?php submit_button(); ?></td></tr>
				</tbody>
			</table>
		</form>
	</div>
</div>
