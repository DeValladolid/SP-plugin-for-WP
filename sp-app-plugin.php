<?php

/*
Plugin Name: SportsPress app WP plugin
Plugin URI: https://github.com/DeValladolid/sportspress-android-app
Description: This is a plugin is to help developers prepare the website for the app for Android.
Version: 0.1
Author: DeValladolid
Author URI: https://github.com/DeValladolid
License: Unlicense
*/
register_activation_hook( __FILE__, 'welcome_screen_activate' );
function welcome_screen_activate() {
  set_transient( '_welcome_screen_activation_redirect', true, 30 );
}

add_action( 'admin_init', 'welcome_screen_do_activation_redirect' );
function welcome_screen_do_activation_redirect() {
  // Bail if no activation redirect
    if ( ! get_transient( '_welcome_screen_activation_redirect' ) ) {
    return;
  }

  // Delete the redirect transient
  delete_transient( '_welcome_screen_activation_redirect' );

  // Bail if activating from network, or bulk
  if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
    return;
  }

  // Redirect to bbPress about page
  wp_safe_redirect( add_query_arg( array( 'page' => 'welcome-screen-about' ), admin_url( 'index.php' ) ) );

}

add_action('admin_menu', 'welcome_screen_pages');

function welcome_screen_pages() {
  add_dashboard_page(
    'Welcome To Welcome Screen',
    'Welcome To Welcome Screen',
    'read',
    'welcome-screen-about',
    'welcome_screen_content'
  );
}

function welcome_screen_content() {
  ?>
  <div class="wrap">
    <div align="center"><h2>Bienvenido al manual para la <i SP android app i/></h2></div>

    <p>
      You can put any content you like here from columns to sliders - it's up to you
    </p>
  </div>
  <?php
}

add_action( 'admin_head', 'welcome_screen_remove_menus' );

function welcome_screen_remove_menus() {
    remove_submenu_page( 'index.php', 'welcome-screen-about' );
}
