<?php

// Define the function to send the email to the admin
add_action( 'send_admin_email', 'send_email_to_admin' );
function send_email_to_admin() {
    $data = fetch_post();
    $to = 'dev-email@wpengine.local';
    $subject = 'Daily Update';
    $message = '';

    foreach( $data as $post_data ) {
      $message.= 'Post Title: '. $post_data['title']. "\n";
      $message.= 'Post URL: '. $post_data['url']. "\n";
      $message.= 'Meta Title: '. $post_data['meta_title']. "\n";
      $message.= 'Meta Description: '. $post_data['meta_description']. "\n";
      $message.= 'Meta Keywords: '. $post_data['meta_keywords']. "\n";
      $message.= "\n\n";
    }

    $headers = array( 
        'From: misuchaudhari25@gmail.com',
        'Content-Type: text/html; charset=UTF-8' 
    );

    wp_mail( $to, $subject, $message, $headers );
}

add_action('wp_mail_failed', 'log_mailer_errors', 10, 1);
function log_mailer_errors( $wp_error ){
  $fn = ABSPATH . '/mail.log'; // say you've got a mail.log file in your server root
  $fp = fopen($fn, 'a');
  fputs($fp, "Mailer Error: " . $wp_error->get_error_message() ."\n");
  fclose($fp);
  wp_die("Mailer Error: " . $wp_error->get_error_message() ."\n");
}



?>