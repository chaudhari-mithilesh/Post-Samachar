<?php

function post_samachar_page() {

    add_menu_page(
        __('Post Samachar', 'post-samachar'),
        'Post Samachar',
        'manage_options',
        'post-samachar',
        'fetch_post',
        'dashicons-analytics',
        '40'
    );
}

add_action( 'admin_menu', 'post_samachar_page' );

?>