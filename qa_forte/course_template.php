<?php 
/*
Template Name: courses_template
*/
get_header();?>

<div class="container d-flex flex-wrap">

<?php


$courses_post = get_posts( array(
            'numberposts' => -1,
            'post_type'   => 'courses',
            'orderby'     => 'name',
            ) );

        foreach( $courses_post as $post ){
            setup_postdata( $post ); ?>
            
            <div class="courses-content">

            <div class="courses-item">
                <div class="course-title">Курс: <?php the_title(); ?></div>
                <div class="course-content">Описание курса: <?php the_content(); ?></div>
                    <div class="course-description">
                        <div class="teacher">Курс предоставил: <?php the_field('преподаватель') ?></div>
                        <div class="programm-course">Программа курса: <?php the_field('программа_курса')?></div>
                        <div class="dowload-course"><a href="<?php the_field('файл_программы_курса') ?>" download>Скачать программу курса</a></div>
                        <div class="order-btn">Записаться на курс</div>
                    </div>
            </div>
            
            <div class="registration-form">
                <form class="register" >
                    <label for="name">Имя:</label>
                    <input id="name" form="register"  name="name" class="inp_name" type="name" placeholder="введите ваше имя" pattern="[a-zа-я]{1,255}"><br>
                    <label for="email">Email:</label>
                    <input id="email" form="register"  class="inp_email" type="email" placeholder="xxxx@xxxxxx.xxx" pattern="[a-z0-9._%+-]{1,4}[@]{1}[a-z]{1,6}[.]{1}[a-z]{3}"><br>
                    <label for="phone">Телефон:</label>
                    <input id="phone" form="register"  class="inp_phone" type="tel" placeholder="x-xxx-xxx-xx-xx" pattern="[0-9]{1}-[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}"><br>
                    
                    
                    <input type="radio" form="register" name="choice" id="сhoice1" class="radio radio_1" value="Дневная форма обучения" />
                    <label class="radio-label" for="choice1">Дневная форма обучения</label><br>
                    
                    <input type="radio" form="register" name="choice" id="сhoice2" class="radio radio_2" value="Вечерняя форма обучения" />
                    <label class="radio-label" for="choice2">Вечерняя форма обучения</label><br>
                    
                    
                    <input type="submit" form="register" id="submit" class="form-btn" value="Отправить" disabled>
                   

                </form>    
            </div>
            
            </div>

        
 <?php  }; //конец foreach
         
wp_reset_postdata(); ?>
<div class="alert alert-success" role="alert">
    Спасибо за ваш отзыв, вы выбрали вечернюю группу
    <div class="alert-btn">Ok</div>
</div>
<div class="register-info">
    Спасибо за вашу заявку, Вы выбрали <span class="ri-type">вечернюю группу</span>, наш менеджер свяжется в Вами в течении 10 минут
    <div class="alert-btn">Ok</div>
</div>
</div>
<?php
get_footer();  
    