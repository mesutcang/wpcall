<?php
/*
 * Plugin Name: WPCall
 * Version: 0.0.1
 * Description: WPCall helps users to make calls over WebRTC.
 * Author: Mesut Can Gurle
 * Author URI: http://mesutcang.blogspot.com
 * Plugin URI: https://github.com/mesutcang/wpcall
 * Text Domain: wpcall
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0

{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.
 
{Plugin Name} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {License URI}.*/

echo "WPCall";
/**
 * Add an admin submenu link under Settings
 */
function wpcall_add_options_submenu_page() {
     add_submenu_page(
          'options-general.php',          // admin page slug
          __( 'WPCall Options', 'wpcall' ), // page title
          __( 'WPCall Options', 'wpcall' ), // menu title
          'manage_options',               // capability required to see the page
          'wpcall_options',                // admin page slug, e.g. options-general.php?page=wporg_options
          'wpcall_options_page'            // callback function to display the options page
     );
}
add_action( 'admin_menu', 'wpcall_add_options_submenu_page' );
 
/**
 * Register the settings
 */
function wpcall_register_settings() {
     register_setting(
          'wpcall_options',  // settings section
          'wpcall_hide_meta' // setting name
     );
}
add_action( 'admin_init', 'wpcall_register_settings' );
 
/**
 * Build the options page
 */
function wpcall_options_page() {
    ?>
    <div class="wrap">
          <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
        <form method="post" action="options.php">
	        <?php
	            settings_fields("section");
	            do_settings_sections("theme-options");      
	            submit_button(); 
	        ?>          
	    </form>
    </div>
<?php
}

function display_ws_element()
{	
	echo '<input type="text" name="ws_url" id="ws_url" value="' . get_option('ws_url') . '" />';
}

function display_sipOutboundProxy_element()
{
	
    echo '<input type="text" name="sipOutboundProxy" id="sipOutboundProxy" value="'. get_option('sipOutboundProxy') . '" />';
    
}

function display_theme_panel_fields()
{
	add_settings_section("section", "All Settings", null, "theme-options");
	
	add_settings_field("ws_url", "WebSocket Server URL", "display_ws_element", "theme-options", "section");
    add_settings_field("sipOutboundProxy", "SIP Outbound Proxy URL", "display_sipOutboundProxy_element", "theme-options", "section");

    register_setting("section", "ws_url");
    register_setting("section", "sipOutboundProxy");
}

add_action("admin_init", "display_theme_panel_fields");


function wpcall_add_endpoints()
{
    add_rewrite_endpoint( 'wpcall*', EP_PAGES );
}
add_action('init', 'wpcall_add_endpoints');

function wpcall_plugin_redirect() {
    global $wp;
 
    if ( !isset( $wp->query_vars['name'] ) || $wp->query_vars['name'] != "wpcall" )
        return;
    
    // include custom template
    include dirname( __FILE__ ) . '/wpcall-template.php';
    exit;
}
 add_action( 'template_redirect', 'wpcall_plugin_redirect' );

//wp_enqueue_script( 'my-script-handle', plugin_dir_url( __FILE__ ) . 'assets/my-file' . $suffix . '.js', array( 'jquery' ) );
function myplugin_scripts() {
  echo "denenmemeee";
    wp_register_style( 'wpcall-styles', plugin_dir_url( __FILE__ ) . '/css/style.css' );
    wp_register_style( 'wpcall-style-horizontal', plugin_dir_url( __FILE__ ) . '/css/style-horizontal.css' );
    wp_register_style( 'wpcall-skins', plugin_dir_url( __FILE__ ) . '/css/skins.css' );
    wp_register_style( 'wpcall_jqueryui', plugin_dir_url( __FILE__ ) . '/css/jquery-ui.css' );
    wp_register_style( 'wpcall_font-awesome', plugin_dir_url( __FILE__ ) . '/css/font-awesome.min.css' );
    wp_enqueue_style( 'wpcall-styles' );
    wp_enqueue_style( 'wpcall-style-horizontal' );
    wp_enqueue_style( 'wpcall-skins' );
    wp_enqueue_style( 'wpcall-jquery-ui' );
    wp_enqueue_style( 'wpcall_font-awesome' );
}
add_action( 'wp_print_scripts', 'myplugin_scripts' );
/*
function myplugin_scripts() {
  echo "styles";
  echo is_readable(plugin_dir_url( __FILE__ ) . '/css/style.css');
    wp_register_style( 'wpcall-styles', plugin_dir_url( __FILE__ ) . '/css/style.css', array(), '0.1', 'screen' );
    wp_enqueue_style( 'wpcall-styles' );
}
add_action( 'wp_enqueue_scripts', 'myplugin_scripts' );
*/
?>

