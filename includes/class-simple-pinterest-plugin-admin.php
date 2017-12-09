<?php
/**
 * Simple_Pinterest_Plugin_Admin File Doc Comment
 *
 * @category Simple_Pinterest_Plugin_Admin
 * @package  SimplyPinterest
 * @author   Terri Ann Swallow
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.terrianncreative.com/
 */

/**
 * Simple_Pinterest_Plugin_Admin class is a collection of utility methods
 * around supporting Simply Pinterest in the WordPress admin.
 *
 * @category Class
 * @package  SimplyPinterest
 * @author   Terri Ann Swallow
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.terrianncreative.com/
 */
class Simple_Pinterest_Plugin_Admin  extends Simple_Pinterest_Base {

	/**
	 * Filters and actions that are run in the admin_init hook.
	 *
	 * @return void
	 */
	public static function admin_init() {

		// Enqueue editor things - used in post.php and pages.php.
		add_action( 'wp_enqueue_editor', array( __CLASS__, 'enqueue' ), 10, 1 );
		add_action( 'print_media_templates', array( __CLASS__, 'template' ) );

		// Add settings link under plugin actions on plugins page.
		add_filter( 'plugin_action_links_' . plugin_basename( BPP_PLUGIN_FILE ), array( __CLASS__, 'plugin_action_links' ) );

		// Adds sidebar metabox to disable spp on a per post basis.
		add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_box' ) );

		// Saves metadata when the post is saved.
		add_action( 'save_post', array( __CLASS__, 'save_meta_box_data' ) );
	}

	/**
	 * Filters and actions that are run in the init hook.
	 *
	 * @return void
	 */
	public static function init() {

		// Create custom plugin settings menu.
		add_action( 'admin_menu', array( __CLASS__, 'create_settings_menu' ) );

		// Registeres settings so POST knows to look for them.
		add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
	}

	/**
	 * Enqueue scripts.
	 *
	 * @param array $options    List of options sent to enqueue.
	 * @return void
	 */
	public static function enqueue( $options ) {

		if ( $options['tinymce'] ) {
			// Note: An additional dependency "media-views" is not listed below
			// because in some cases such as /wp-admin/press-this.php the media
			// library isn't enqueued and shouldn't be. The script includes
			// safeguards to avoid errors in this situation.
			wp_enqueue_script( 'advanced-pinterest-settings', plugins_url( 'scripts/advanced-pinterest-settings.js', BPP_PLUGIN_FILE ), array( 'jquery' ), self::VERSION, true );
		}
	}

	/**
	 * Backbone template for advanced settings through editing an image in the visual editor for posts/pages
	 *
	 * @return void
	 */
	public static function template() {
		include plugin_dir_path( BPP_PLUGIN_FILE ) . 'templates/advanced-pinterest-settings-tmpl.php';
	}

	/**
	 * Register settings so WordPress knows to update them when
	 * editing plugin settings.
	 *
	 * @return void
	 */
	public static function register_settings() {

		// Register settings.
		register_setting( 'bpp-settings-group', 'bpp_color' );
		register_setting( 'bpp-settings-group', 'bpp_onhover' );
		register_setting( 'bpp-settings-group', 'bpp_corner' );
		register_setting( 'bpp-settings-group', 'bpp_size', 'intval' );
		register_setting( 'bpp-settings-group', 'bpp_lang' );
		register_setting( 'bpp-settings-group', 'bpp_count' );
		register_setting( 'bpp-settings-group', 'bpp_zero_count' );
		register_setting( 'bpp-settings-group', 'bpp_load' );
		register_setting( 'bpp-settings-group', 'bpp_load_jq' );
		register_setting( 'bpp-settings-group', 'bpp_description_append', 'trim' );
		register_setting( 'bpp-settings-group', 'bpp_pagetype' );
		register_setting( 'bpp-settings-group', 'bpp_important' );
		register_setting( 'bpp-settings-group', 'bpp_mobile' );

		self::set_default_settings();
	}

	/**
	 * Defines all the default settings for easier programatic
	 * registration and update.
	 *
	 * @return array
	 */
	public static function get_default_options() {
		return array(
			'bpp_color'              => 'red',
			'bpp_onhover'            => 'false',
			'bpp_corner'             => 'northeast',
			'bpp_size'               => 20,
			'bpp_lang'               => 'en',
			'bpp_count'              => 'above',
			'bpp_load'               => 'async',
			'bpp_load_jq'            => 'false',
			'bpp_description_append' => '',
			'bpp_pagetype'           => array( 'posts', 'pages', 'home', 'archives' ),
			'bpp_important'          => 'false',
			'bpp_mobile'             => 'false',
			'bpp_zero_count'         => 'true',
		);
	}

	/**
	 * Sets all of the default settings.
	 *
	 * @return void
	 */
	public static function set_default_settings() {
		foreach ( self::get_default_options() as $option => $default_value ) {
			$option_current_value = get_option( $option );
			if ( empty( $option_current_value ) ) {
				self::update_option( $option, $default_value );
			}
		}
	}

	/**
	 * Update or add individual options.
	 *
	 * @param string $name   The name of the option.
	 * @param string $value  The value you want to save for the named otion.
	 * @return void
	 */
	public static function update_option( $name, $value ) {
		if ( get_option( $name ) !== false ) {
			update_option( $name, $value );
		} else {
			add_option( $name, $value );
		}
	}

	/**
	 * Permenantly deletes Simply Pinterest options.
	 *
	 * @return void
	 */
	public static function settings_remove() {
		self::settings_remove_deprecated();

		delete_option( 'bpp_color' );
		delete_option( 'bpp_onhover' );
		delete_option( 'bpp_corner' );
		delete_option( 'bpp_size' );
		delete_option( 'bpp_lang' );
		delete_option( 'bpp_count' );
		delete_option( 'bpp_zero_count' );
		delete_option( 'bpp_load' );
		delete_option( 'bpp_load_jq' );
		delete_option( 'bpp_description_append' );
		delete_option( 'bpp_pagetype' );
		delete_option( 'bpp_important' );
		delete_option( 'bpp_mobile' );
	}

	/**
	 * Deletes deprecated options.
	 *
	 * Used to make sure that as the plugin evolves we don't leave
	 * orphan DB records.
	 *
	 * @return void
	 */
	public static function settings_remove_deprecated() {
		// @deprecated
		delete_option( 'bpp_description_end' );
		delete_option( 'bpp_loadasync' );
	}

	/**
	 * Add submenu under settings to mangage Simply Pinterest settings.
	 *
	 * @return void
	 */
	public static function create_settings_menu() {
		add_submenu_page( 'options-general.php', 'Simply Pinterest Settings', 'Pinterest Settings', 'update_plugins', 'spp_settings', array( __CLASS__, 'settings_page' ) );
	}

	/**
	 * Code to display the Simply Pinterest plugin settings page.
	 *
	 * @return void
	 */
	public static function settings_page() {
		include 'settings-page.php';
	}

	/**
	 * Code to display the Simply Pinterest post metabox.
	 *
	 * @param WP_Post $post  WordPress post object associated with the record being edited.
	 * @return void
	 */
	public static function meta_box( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'bpp_meta_box', 'bpp_meta_box_nonce' );

		/**
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
		$value = get_post_meta( $post->ID, 'bpp_disable_pinit', true );
		?>
			<label for="bpp_disable_pinit">
			<input type="checkbox" id="bpp_disable_pinit" name="bpp_disable_pinit" value="1" <?php checked( 1 === $value ); ?> />
			<?php esc_html_e( 'Disable Pin It button for all images in this post', 'simplypinterest' ); ?>
			</label>
		<?php
	}

	/**
	 * Adding action links to plugin's display on the WordPress Admin > Plugins page
	 *
	 * @param array $links   List of links already being displayed under the plugin.
	 * @return array $links  List of modified links.
	 */
	public static function plugin_action_links( $links ) {
		$links[] = sprintf(
			'<a href="%s">%s</a>',
			get_admin_url( null, 'options-general.php?page=spp_settings' ),
			__( 'Settings', 'simplypinterest' )
		);
		$links[] = sprintf(
			'<a href="%s" target="_blank">%s</a>',
			'https://github.com/terriann/simple-pinterest-plugin/issues',
			__( 'Report Issues', 'simplypinterest' )
		);
		return $links;
	}

	/**
	 * Adding the Simply Pinterest meta box to the edit screen.
	 *
	 * @return void
	 */
	public static function add_meta_box() {

		$screens = array( 'post', 'page' );

		foreach ( $screens as $screen ) {
			add_meta_box(
				'bpp_metabox_config',
				__( 'Simply Pinterest Settings' ),
				array( __CLASS__, 'meta_box' ),
				$screen,
				'side'
			);
		}
	}


	/**
	 * When the post is saved, saves our custom data.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public static function save_meta_box_data( $post_id ) {

		// Check if our nonce is set.
		if ( ! isset( $_POST['bpp_meta_box_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['bpp_meta_box_nonce'], 'bpp_meta_box' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' === $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		// If it's not set then make sure there's no unnecessary post meta empty value hanging around.
		if ( ! isset( $_POST['bpp_disable_pinit'] ) ) {
			delete_post_meta( $post_id, 'bpp_disable_pinit' );
			return;
		}

		// Sanitize user input.
		$value = sanitize_text_field( wp_unslash( $_POST['bpp_disable_pinit'] ) );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'bpp_disable_pinit', $value );
	}


}
