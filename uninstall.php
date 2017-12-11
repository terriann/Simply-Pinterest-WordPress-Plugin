<?php
/**
 * Simply Pinterest Uninstall File Doc Comment
 *
 * @category  Uninstall
 * @package   SimplyPinterest
 * @author    Terri Ann Swallow
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      http://www.terrianncreative.com/
 */

// If uninstall is not called from WordPress, exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

define( 'BPP_PLUGIN_FILE', __FILE__ );

require_once __DIR__ . '/includes/simple-pinterest-base.php';
require_once __DIR__ . '/includes/class-simple-pinterest-plugin-admin.php';

// When the plugin is uninstalled, remove options from database.
Simple_Pinterest_Plugin_Admin::settings_remove();
