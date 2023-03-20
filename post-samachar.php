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


// Cron schedules

function my_cron_schedules($schedules){
    if(!isset($schedules["1min"])){
        $schedules["1min"] = array(
            'interval' => 1*60,
            'display' => __('Once every minutes'));
    }
    if(!isset($schedules["24hr"])){
        $schedules["30min"] = array(
            'interval' => 60*60*24,
            'display' => __('Once every day'));
    }
    return $schedules;
}
add_filter('cron_schedules','my_cron_schedules');

// // Schedule the email event to run daily at 6:30 pm IST

function schedule_admin_email() {
    echo "Inside Schedule Function";
    if ( ! wp_next_scheduled( 'send_admin_email' ) ) {
        // Convert the time to the UTC timestamp
        $timestamp = strtotime( '6:30pm GMT+5:30' );
        wp_schedule_event( time(), '1min', 'send_admin_email' );
    }
}
register_activation_hook( __FILE__, 'schedule_admin_email' );


// remove schedule when deactivating plugin

function remove_schedule() {
    wp_clear_scheduled_hook( 'send_admin_email' );
}

register_deactivation_hook( __FILE__, 'remove_schedule' );

?>
