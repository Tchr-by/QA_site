<?php
/**
 *
 * Template name: О нас
 *
 */
 
get_header(); ?>

<div class="container pl-4">
    <div class="row d-flex flex-column align-items-center">
        <h1 class="w-100"><?php the_title(); ?></h1>
        <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <?php the_content(); ?>
        <?php endwhile; ?>
        <div class="map">
            <img src="<?php the_field('карта'); ?>">
        </div>
        <div class="adress">
            Адрес: ул. Некрасивая 10а
        </div>
        <div class="post-index">
            Почта: <?php the_field('почта'); ?>
        </div>
        <div class="phone">
            Телефон: <?php the_field('телефон'); ?>
        </div>
        <a href="/news" class="order-btn">Оставить заявку</a>
    </div>
</div>

<?php get_footer(); ?>