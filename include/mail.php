<?php

// // Schedule the email event to run daily at 4:30 pm IST
// add_action( 'init', 'schedule_admin_email' );
// function schedule_admin_email() {
//     echo "Inside Schedule Function";
//     if ( ! wp_next_scheduled( 'send_admin_email' ) ) {
//         // Convert the time to the UTC timestamp
//         $timestamp = strtotime( '5:24pm GMT+5:30' );
//         wp_schedule_event( $timestamp, 'daily', 'send_admin_email' );
//     }
// }

// Define the function to send the email to the admin
add_action( 'publish_post', 'send_email_to_admin' );
function send_email_to_admin() {
    $to = 'dev-email@wpengine.local';
    $subject = 'Daily Update';
    $message = 'This is your daily update from WordPress.';
    $headers = array( 
        'From: misuchaudhari25@gmail.com',
        'Content-Type: text/html; charset=UTF-8' 
    );

    wp_mail( $to, $subject, $message, $headers );
}



?>