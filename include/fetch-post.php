<?php

function fetch_post() {

    // Setup Args for the query
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => -1,
        'date_query'     =>array(
                'year'  => date('Y'),
                'month' => date('n'),
                'day'   => date('j'),
            ),
    );

    // Retrieve the posts using WP_Query
    $posts_array = get_posts($args);

    $post_data = array();

    foreach ( $posts_array as $post ) {

        $title = $post->post_title;
        $url = get_permalink( $post -> ID );

        $meta_title = get_post_meta( $post->ID, '_yoast_wpseo_title', true );
        $meta_description = get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true );
        $meta_keywords = get_post_meta( $post->ID, '_yoast_wpseo_focuskw', true );


        $post_data[] = array(
            'title' => $title,
            'url'   => $url,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,
        );
    }

    if( empty($post_data) ) {
        echo "<center><h1>Oops! there are no posts published today.</h1></center>";
    }else {
        print("<pre>".print_r( $post_data, true ). "</pre>");
    }

    return $post_data;

}

?>