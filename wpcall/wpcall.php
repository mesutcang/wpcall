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
function wpcall_sytle_scripts() {
    wp_register_style( 'wpcall-styles', plugin_dir_url( __FILE__ ) . '/css/style.css' );
    wp_register_style( 'wpcall-style-horizontal', plugin_dir_url( __FILE__ ) . '/css/style-horizontal.css' );
    wp_register_style( 'wpcall-skins', plugin_dir_url( __FILE__ ) . '/css/skins.css' );
    wp_register_style( 'wpcall-jquery-ui', plugin_dir_url( __FILE__ ) . '/css/jquery-ui.css' );
    wp_register_style( 'wpcall-font-awesome', plugin_dir_url( __FILE__ ) . '/css/font-awesome.min.css' );
    wp_enqueue_style( 'wpcall-styles' );
    wp_enqueue_style( 'wpcall-style-horizontal' );
    wp_enqueue_style( 'wpcall-skins' );
    wp_enqueue_style( 'wpcall-jquery-ui' );
    wp_enqueue_style( 'wpcall-font-awesome' );

    wp_register_script( 'wpcall-jquery', plugin_dir_url( __FILE__ ) . '/js/jquery.js' );
    wp_register_script( 'wpcall-arbiter', plugin_dir_url( __FILE__ ) . '/js/Arbiter.js' );
    wp_register_script( 'wpcall-jquery.i18n.properties', plugin_dir_url( __FILE__ ) . '/js/jquery.i18n.properties.js' );
    wp_register_script( 'wpcall-jquery-ui', plugin_dir_url( __FILE__ ) . '/js/jquery-ui.js' );
    wp_register_script( 'wpcall-jssip', plugin_dir_url( __FILE__ ) . '/js/jssip.js' );
    wp_register_script( 'wpcall-init', plugin_dir_url( __FILE__ ) . '/js/init.js' );
    wp_register_script( 'wpcall-config', plugin_dir_url( __FILE__ ) . '/js/config.js' );
    wp_register_script( 'wpcall-JSComm', plugin_dir_url( __FILE__ ) . '/js/JSComm.js' );
    wp_enqueue_script( 'wpcall-jquery' );
    wp_enqueue_script( 'wpcall-arbiter' );
    wp_enqueue_script( 'wpcall-jquery.i18n.properties' );
    wp_enqueue_script( 'wpcall-jquery-ui' );
    wp_enqueue_script( 'wpcall-jssip' );
    wp_enqueue_script( 'wpcall-init' );
    wp_enqueue_script( 'wpcall-config' );
    wp_enqueue_script( 'wpcall-JSComm' );

}
add_action( 'wp_print_footer_scripts', 'wpcall_sytle_scripts' );
/*
function myplugin_scripts() {
  echo "styles";
  echo is_readable(plugin_dir_url( __FILE__ ) . '/css/style.css');
    wp_register_style( 'wpcall-styles', plugin_dir_url( __FILE__ ) . '/css/style.css', array(), '0.1', 'screen' );
    wp_enqueue_style( 'wpcall-styles' );
}
add_action( 'wp_enqueue_scripts', 'myplugin_scripts' );
*/
/**
 * WPCall Widget 
 */
class wpcall_widget extends WP_Widget {


    /** constructor */
    function wpcall_widget() {
        parent::WP_Widget(false, $name = 'WPCALL RTC');
    }

    /** @see WP_Widget::widget  */
    function widget($args, $instance) {
        extract( $args );
        $title 		= apply_filters('widget_title', $instance['title']);
        $message 	= $instance['message'];
        ?>

    <div id="network-controls">
        <div id="jsc-login">
            <div id="jsc-login-display-name">
                <span class="jsc-login-label">Display name (may be empty)</span>
                <input type="text" id="jsc-login-display-name-field"/>
            </div>
            <div id="jsc-login-sip-uri">
                <span class="jsc-login-label">SIP address</span>
                <input type="text" id="jsc-login-sip-address-field"/>
            </div>
            <div id="jsc-login-password">
                <span class="jsc-login-label">Password</span>
                <input type="password" id="jsc-login-password-field"/>
            </div>
            <div id="jsc-login-option">
                <input type="checkbox" id="rememberMe"><span id="remember-label">Remember me</span><br>
            </div>
            <input type="button" value="Login" id="jsc-login-button"/>
        </div>
    </div>

    <div id="communicator">
        <div id="call">
            <h3>Call</h3>
            <div id="call-info">
                <span class="no-contact" id="call-contact-error">Please enter a contact.</span>
                <div id="state">
                    <span class="session-outgoing">Dialing...</span>
                    <span class="session-active">Call connected</span>
                </div>
            </div>

            <div id="dial-controls" class="ws-connected">
                <div id="dest">
                    <span id="dest_label">Destination:</span>
                    <input type="text" id="address" placeholder="Enter contact"/>
                </div>
                <div id="dialing-actions">
                    <button id="call-audio"><i class="fa fa-phone fa-lg" style="color:green;">Audio</i></button>
                    <button id="call-video"><i class="fa fa-video-camera fa-lg" style="color:green;">Video</i></button>
                </div>
            </div>

            <div id="session-controls" class="ws-connected in-call">
                <div id="peer"></div>
                <div id="session-actions">
                    <button value="Cancel" id="session-cancel" class="session-outgoing">
                        <i class="fa fa-phone fa-lg red-phone" ></i>
                    </button>
                    <button value="Reject" id="session-reject" class="session-incoming">
                        <i class="fa fa-phone fa-lg red-phone" style="color:red;"></i>
                    </button>
                    <button value="Answer" id="session-answer" class="session-incoming">
                        <i class="fa fa-phone fa-lg" style="color:green;"></i>
                    </button>
                    <button value="Answer (with video)" id="session-answer-video" class="session-incoming">
                        <i class="fa fa-video-camera fa-lg" style="color:green;"></i>
                    </button>
                    <!-- Not implemented yet?
                    <button value="Hold" id="session-hold" class="session-active" disabled>
                        <i class="fa fa-pause fa-lg" style="color:red;"></i>
                    </button>-->
                    <button value="Hangup" id="session-hangup" class="session-active">
                        <i class="fa fa-phone fa-lg red-phone" style="color:red;"></i>
                    </button>
                    <button id="dtmf-button" class="session-active">
                        <i class="fa fa-th fa-lg" style="color:darkblue;"></i>
                    </button>
                </div>
            </div>
            <div id="dtmf-pad">
                <input type="button" value="1" class="dtmf-number"/>
                <input type="button" value="2" class="dtmf-number"/>
                <input type="button" value="3" class="dtmf-number"/>
                <input type="button" value="A" class="dtmf-symbol"/>
                <br/>
                <input type="button" value="4" class="dtmf-number"/>
                <input type="button" value="5" class="dtmf-number"/>
                <input type="button" value="6" class="dtmf-number"/>
                <input type="button" value="B" class="dtmf-symbol"/>
                <br/>
                <input type="button" value="7" class="dtmf-number"/>
                <input type="button" value="8" class="dtmf-number"/>
                <input type="button" value="9" class="dtmf-number"/>
                <input type="button" value="C" class="dtmf-symbol"/>
                <br/>
                <input type="button" value="*" class="dtmf-symbol"/>
                <input type="button" value="0" class="dtmf-number"/>
                <input type="button" value="#" class="dtmf-symbol"/>
                <input type="button" value="D" class="dtmf-symbol"/>
                <br/>
            </div>
        </div>
        <hr>
<!--
        <div id="chat">
            <h3>Chat</h3>
            <div id="chat-error">
                <span class="no-contact" id="chat-contact-error">Please enter a contact.</span>
            </div>
            <div id="new-chat">
                <span id="chat_dest_label">Destination:</span>
                <input type="text" id="chat-address" placeholder="Enter contact"/>
                <button id="start-chat"><i class="fa fa-comments fa-lg" style="color:darkblue;"></i></button>
            </div>
            <ul id="tab-labels">
            </ul>
            <div id="tab-pages">
            </div>
        </div>
    </div>
-->
    <div id="error">
        <span id="js">ERROR: This service requires JavaScript.  Please enable JavaScript in your web browser settings.</span>
        <span id="webrtc">ERROR: This service requires WebRTC.  Please try <a href="http://www.mozilla.org">Mozilla Firefox</a> or <a href="http://www.google.com/chrome">Google Chrome</a>, using the latest version is strongly recommended.</span>
        <span id="no-config">ERROR: JsCommunicator configuration not found</span>
        <span id="ua-init-failure">ERROR: Failed to initialize user agent</span>
        <span id="reg-fail">ERROR: SIP Registration failure</span>
        <span id="call-attempt-failed">ERROR: failed to start call, check that microphone/webcam are connected, check browser security settings, peer may not support compatible codecs</span>
        <span id="dynamic"></span>
    </div>
    <div id="ws">
        <span id="ws_link">WebSocket link:</span>
        <span id="connected" class="state ws-connected">Connected</span>
        <span id="disconnected" class="state ws-disconnected">Disconnected</span>
    </div>
    <div id="reg" class="ws-connected up down"><span>SIP registration:</span>
        <span id="state">
            <span class="up">Registered</span>
            <span class="down">Not Registered</span>
        </span>
        <span id="control">
            <input type="button" value="Register" id="reg-button" class="down"/>
            <input type="button" value="De-Register" id="de-reg-button" class="up"/>
        </span>
    </div>

</div>

<div id="video-session" class="ws-connected in-call">
    <video id="remoteView" autoplay controls></video>
    <video id="selfView" autoplay muted></video>
    <div id="video-controls">
        <input type="button" value="Self view" id="video-control-self-view" class="self"/>
        <input type="button" value="Self hide" id="video-control-self-hide" class="self"/>
    </div>
</div>




        <!--
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
							<ul>
								<li><?php echo $message; ?></li>
							</ul>
              <?php echo $after_widget; ?>
        -->
        <?php
    }

    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['message'] = strip_tags($new_instance['message']);
        return $instance;
    }

    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {

        $title 		= esc_attr($instance['title']);
        $message	= esc_attr($instance['message']);
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('message'); ?>"><?php _e('Simple Message'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('message'); ?>" name="<?php echo $this->get_field_name('message'); ?>" type="text" value="<?php echo $message; ?>" />
        </p>
        <?php
    }

} // end class wpcall_widget
add_action('widgets_init', create_function('', 'return register_widget("wpcall_widget");'));
?>

