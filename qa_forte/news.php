<?php

/*
Template Name: News page
*/

get_header(); ?>





<div class="container">
    <div class="row">

<?php
    $news_post = get_posts( array(
                'numberposts' => 5,
                'post_type'   => 'post',
                'orderby'     => 'date',
                ) );

        foreach( $news_post as $post ){
        setup_postdata( $post ); ?>
        
        <div class="news-page">
        <div class="news-title"><p>Свежая новость от: <?php the_author();?> : <?php the_title(); ?></p></div>
        <div class="news-content"><p><?php echo mb_strimwidth(strip_tags(get_the_content()), 0, 528, "..."); ?></p></div>
        <div class="news-timestomp"><p>Новость опубликована: <b><?php the_time(get_option( 'date_format' )." в ".get_option( 'time_format' )); ?></b></p></div>
        </div>    
          <?php };
    wp_reset_postdata(); 
    
?>

    </div> <!-- end_row -->
</div> <!-- end_container -->

<?php get_footer();