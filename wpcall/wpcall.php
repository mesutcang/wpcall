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
?>

