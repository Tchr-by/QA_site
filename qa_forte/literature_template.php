<?php 
/*
Template Name: literature_template
*/
get_header(); ?>

<div class="page-bg">

<div class="container d-flex flex-wrap">
    <div class="search-row">
        <?php get_search_form(); ?>
    </div>
    
    
      <?php $literature_post = get_posts( array(
                'numberposts' => -1,
                'post_type'   => 'literature',
                'orderby'       => 'name',
                ) ); 
 
          foreach( $literature_post as $post ){
                    setup_postdata( $post ); 
                 
                    if (has_post_thumbnail()) { ?>
                    <div class="literature-item"> 
                        <div class="literature-dl-tmb">
                            <img src="<?php the_post_thumbnail_url(); ?>">
                         </div>
                        <div class="literature-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </div>
                        <div class="literature-content">
                            <?php echo mb_strimwidth(strip_tags(get_the_content()), 0, 300, "..."); ?>
                        </div>
                                     
                    <?php
                                if ( is_user_logged_in() ) {
                                    if ( current_user_can('administrator') ) { ?>
                                        <div class="literature-dl-admin-btn"><a href="Cкачать" download>Скачать</a></div>
                                    
                            <?php } else {  ?>
                                  
                                        <div class="literature-dl-fake-btn"><a>Скачать</a></div>
                                   <?php } ?>
                                   
                    <?php } else {  ?>
                                           
                                <div class="literature-dl-info">Чтобы скачать литературу вы должны быть зарегестрированы</div>
                    <?php } ?>    
                    </div>                                            
                <?php } ?>
                
           <?php }; ?>
     
         
  <?php  wp_reset_postdata(); ?>
    


</div> <!-- end_container -->

</div> <!-- end_page_bg -->
      
<?php get_footer();   