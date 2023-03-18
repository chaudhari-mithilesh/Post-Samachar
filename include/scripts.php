<?php

function post_samachar_scripts() {
    
    wp_enqueue_style( 'post-samachar-style', POST_SAMACHAR_DIR. 'assets/CSS/style.css' );
    
}
    
    add_action( 'admin_enqueue_scripts', 'post_samachar_scripts' );

?>