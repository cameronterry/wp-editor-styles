<?php
/*
Plugin Name: Editor Styles
Plugin URI: https://cameronterry.supernovawp.com/
Description: A very simple plugin which allows users to choose a color scheme for their writing experience.
Author: Cameron Terry
Version: 1.0
Author URI: https://cameronterry.supernovawp.com/
*/
	global $editor_styles_plugin_list;
	$editor_styles_plugin_list = array(
		'amy-sublime' => 'Amy (Sublime)',
		'expresso-sublime' => 'Expresso (Sublime)',
		'monokai-sublime' => 'Monokai (Sublime)',
		'space-cadet-sublime' => 'Space Cadet (Sublime)',
		'solarized-dark-sublime' => 'Solarized Dark (Sublime)',
		'sunburst-sublime' => 'Sunburst (Sublime)',
		'twilight-sublime' => 'Twilight (Sublime)'
	);

	function editor_styles_admin_print_styles() {
		$editor_style = get_user_meta( get_current_user_id(), 'editor_style', true );

		wp_enqueue_style( 'editor-styles-css', plugins_url( "$editor_style.css", __FILE__ ) );
	}

	function editor_styles_init() {
		$editor_style = get_user_meta( get_current_user_id(), 'editor_style', true );

		if ( false === empty( $editor_style ) ) {
			add_editor_style( plugins_url( "$editor_style.css", __FILE__ ) );
		}
	}

	function editor_styles_profile_options( $user ) {
		global $editor_styles_plugin_list;
		?>
			<h3><?php _e( 'Editor Styles' ) ?></h3>
			<table class="form-table">
				<tr>
					<th><label for="style"><?php _e( 'Choose a style:' ); ?></label></th>
					<td>
						<select name="editor_style">
							<option>&lt;Default&gt;</option>
							<?php foreach ( $editor_styles_plugin_list as $key => $title ) {
								if ( $key === $user->editor_style ) {
									printf( '<option selected="selected" value="%1$s">%2$s</option>', $key, $title );
								}
								else {
									printf( '<option value="%1$s">%2$s</option>', $key, $title );
								}
							} ?>
						</select>
					</td>
				</tr>
			</table>
		<?php
	}

	function editor_styles_profile_options_save( $user_id ) {
		update_usermeta( $user_id, 'editor_style', $_POST['editor_style'] );
	}

	add_action( 'admin_print_styles-post.php', 'editor_styles_admin_print_styles' );
	add_action( 'admin_print_styles-post-new.php', 'editor_styles_admin_print_styles' );
	add_action( 'init', 'editor_styles_init' );
	add_action( 'show_user_profile', 'editor_styles_profile_options' );
	add_action( 'edit_user_profile', 'editor_styles_profile_options' );
	add_action( 'edit_user_profile_update', 'editor_styles_profile_options_save' );
	add_action( 'personal_options_update', 'editor_styles_profile_options_save' );