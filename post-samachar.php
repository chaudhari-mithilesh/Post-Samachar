<?php

/*

Plugin Name: Post Samachar
Author: Mithilesh
Version: 1.0.0

*/

if( !defined('WPINC') ) {
    die;
}

if( !defined('POST_SAMACHAR_PLUGIN_VERSION') ) {
    define('POST_SAMACHAR_PLUGIN_VERSION', '1.0.0' );
}

if( !defined('POST_SAMACHAR_DIR') ) {
    define( 'POST_SAMACHAR_DIR', plugin_dir_url( __FILE__ ) );
}

if( !defined('POST_SAMACHAR_DIR_PATH') ) {
    define( 'POST_SAMACHAR_DIR_PATH', plugin_dir_path( __FILE__ ) );
}

// Enqueue plugin Scripts
require POST_SAMACHAR_DIR_PATH. 'include/scripts.php';

// Add Menu page for Plugin
require POST_SAMACHAR_DIR_PATH. 'include/post-samachar-page.php';

// fetch post data
require POST_SAMACHAR_DIR_PATH. 'include/fetch-post.php';

// Sending Mail to admin
require POST_SAMACHAR_DIR_PATH. 'include/mail.php';

// add_action('wp_mail_failed', 'log_mailer_errors', 10, 1);
// function log_mailer_errors( $wp_error ){
//   $fn = ABSPATH . '/mail.log'; // say you've got a mail.log file in your server root
//   $fp = fopen($fn, 'a');
//   fputs($fp, "Mailer Error: " . $wp_error->get_error_message() ."\n");
//   fclose($fp);
//   wp_die("Mailer Error: " . $wp_error->get_error_message() ."\n");
// }

?>
