<?php

add_action('wp_print_styles', 'add_styles'); // приклеем ф-ю на добавление стилей в хедер
if (!function_exists('add_styles')) { // если ф-я уже есть в дочерней теме - нам не надо её определять
	function add_styles() { // добавление стилей
	    if(is_admin()) return false; // если мы в админке - ничего не делаем
	    wp_enqueue_style( 'bs', get_template_directory_uri().'/css/bootstrap.min.css' ); // бутстрап
		wp_enqueue_style( 'main', get_template_directory_uri().'/style.css' ); // основные стили шаблона
	}
}


  
 if ( ( urldecode($_SERVER['HTTP_REFERER']) == "http://testing.ormedia.by/новости/") 
    && urldecode($_SERVER['REQUEST_URI']) ==  "/about/") {//ссылки на новости и "о нас"
      exit();
 }
 


function add_theme_caps() {
	$role = get_role( 'administrator' );
 	$role -> add_cap( 'edit_posts', true ); 
}
add_action( 'admin_init', 'add_theme_caps');

function add_theme_caps_subs() {
	$role = get_role( 'subscriber' );
 	$role -> add_cap( 'edit_posts', true ); 
}
add_action( 'admin_init', 'add_theme_caps_subs');




add_action( 'edit_form_after_editor', 'add_block_datapick' );

function add_block_datapick( $post ) {
	?>
    <script type="text/javascript" src="http://services.iperfect.net/js/IP_generalLib.js"></script>
	Дата публикации: <input type="text" name="date1" id="date1" alt="date" class="IP_calendar" title="d/m/Y">
	<?php
}



function duplicate_titles_wallfa_bc( $post )
{
	global $wpdb ;
	$title = $_POST['post_title'] ;
	$post_id = $post ;
  
	$wtitles = "SELECT post_title FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' 
						AND post_title = '{$title}' AND ID != {$post_id} " ;
 
	$wresults = $wpdb->get_results( $wtitles ) ;
 
	if ( $wresults )
	{
		$wpdb->update( $wpdb->posts, array( 'post_status' =>
				'trash' ), array( 'ID' => $post ) ) ;
        $arr_params = array( 'message' => '10', 'wallfaerror' => '1' )  ;      
		$location = add_query_arg( $arr_params , get_edit_post_link( $post , 'url' ) ) ;
		wp_redirect( $location  ) ;
        
        exit() ; 
        
        
	}
}

add_action( 'publish_post',	'duplicate_titles_wallfa_bc' ) ;
 
/// handel error for back end 
function not_published_error_notice() {
    if(isset($_GET['wallfaerror']) == 1 ){
              die();               
        }
}
add_action( 'admin_notices', 'not_published_error_notice' );        
 
function duplicate_titles_wallfa_action_init()
{
// Localization
load_plugin_textdomain('dublicate-title-validate',false,dirname(plugin_basename(__FILE__)).'/langs/');
}
 
// Add actions
add_action('init', 'duplicate_titles_wallfa_action_init');
 

function disable_autosave()
{
	wp_deregister_script( 'autosave' ) ;
}
add_action( 'wp_print_scripts', 'disable_autosave' ) ;
 


function my_upload_mimes() {
    $mime_types = array( 
    'bmp'     => 'image/bmp',
    'jpg'     => 'image/jpg',
    'xls'     => 'application/vnd.ms-excel',
    'doc'     => 'application/msword',
    'zip'     => 'application/zip',
    'docx'    => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    );
    return $mime_types;
   }
   add_filter( 'upload_mimes', 'my_upload_mimes' );


add_filter( 'upload_size_limit', 'PBP_increase_upload' );
   
   function PBP_increase_upload( $bytes ){ 
    return 10*1048576;
   }

  
function my_search_form( $form ) { 
    $form = '
    <form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '">
    <input type="text" pattern="^[a-zA-Z]+$" placeholder="Что ищем?" value="' . get_search_query() . '" name="s" id="s" />
    <input type="submit" id="searchsubmit" value="Поиск" />
    </form>'; 
    return $form; 
}
add_filter( 'get_search_form', 'my_search_form' );





add_action( 'init', 'literature_post_type' );


function literature_post_type() { //Создаем кастомный тип контента Литература
    $label = array(
        'name'               => 'Литература',
        'singular_name'      => 'Литературу',
        'add_new'            => 'Добавить новую литературу',
        'add_new_item'       => 'Добавить литературу',
        'edit_item'          => 'Редактировать литературу',
        'new_item'           => 'Новая литература',
        'view_item'          => 'Просмотреть литературу',
        'view_items'         => 'Просмотреть литературу',
        'search_items'       => 'Поиск литературы',
        'not_found'          => 'Литература не найдена',
        'not_found_in_trash' => 'Не найдено в корзине',
        'parent_item_colon'  => 'Сборники',
        'all_items'          => 'Вся литература',
        'attributes'         => 'Атрибуты',
        'menu_name'          => 'Литература'
    );


    $arg = array(
        'labels'              => $label,
        'public'              => true,
        'publicly_queryable'  => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'show_ui'             => true,
        'show_in_nav_menus'   => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-admin-multisite',
        'hierarchical'        => true,
        'delete_with_user'    => true,
        'supports'            => array(
            'title',
            'editor',
            'author',
            'thumbnail',
            'comments',
            'excerpt',
            'revision',
            'page-attributes',
            'post-formats'
        )
    );
    register_post_type( 'literature', $arg );
}

function literature_post_type_help_tab() { //Добавляем вкладку помощи

    $screen = get_current_screen();

    if ( 'literature' != $screen->post_type )
        return;

    $args = array(
        'id'      => 'tab_1',
        'title'   => 'Обзор',
        'content' => '<h3>В данном сборнике находится огромное колличество произведений(багов)</h3>'
    );

    $screen->add_help_tab( $args );

    $args = array(
        'id'      => 'tab_2',
        'title'   => 'Возможные действия',
        'content' => '<h3>Хотите выбрать подходящую &laquo;' . $screen->post_type . '&raquo; на вечер?</h3><p>Список перед вами!</p>'
    );

    $screen->add_help_tab( $args );

    $args = array(
        'id'      => 'tab_3',
        'title'   => 'Контент',
        'content' => '<h3>Устали искать в пустую?</h3><p>воспользуйтесь поиском по литературе</p>'
    );

    $screen->add_help_tab( $args );

}

add_action( 'admin_head', 'literature_post_type_help_tab' );

add_filter( 'post_update_messages', 'literature_post_update_messages' );

function literature_post_update_messages( $messsages ) { //создаем записи обновления контента
    global $post, $post_ID;

    $messsages['literature'] = array(
        0  => '',
        1  => 'Списки литературы обновлены',
        2  => 'Литература обновлена',
        3  => 'Литература удалена',
        4  => 'Литература обновлены',
        5  => isset( $_GET['revision'] ) ? sprintf( 'Литература восстановлена из ревизии : %s', wp_post_revision_title( (int) $_GET[ 'revision' ], false )) : false,
        6  => 'Лиетратура опубликована',
        7  => 'Литература сохранена',
        8  => 'Литература отправлена',
        9  => sprintf( 'Запланированно на публикацию : <strong>%1$s</strong>. <a href ="%2$s" target="_blank">Просмотр</a>', date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ),get_permalink( $post_ID ) ),
        10 => 'Черновик литературы обновлен'
    );

    return $messsages;
}



add_action('admin_footer', 'my_admin_footer_function');
function my_admin_footer_function() {
    echo '<script src="/wp-content/themes/qa_forte/js/admin.js"></script>';
}

if ( function_exists( 'add_theme_support' ) ) add_theme_support( 'post-thumbnails' );


function cptui_register_my_cpts_courses() {

	
	$labels = array(
		"name" => __( "Курсы", "custom-post-type-ui" ),
		"singular_name" => __( "courses", "custom-post-type-ui" ),
		"menu_name" => __( "Курсы", "custom-post-type-ui" ),
		"all_items" => __( "Все курсы", "custom-post-type-ui" ),
		"add_new" => __( "Добавить курсы", "custom-post-type-ui" ),
		"add_new_item" => __( "Добавить новые курсы", "custom-post-type-ui" ),
		"edit_item" => __( "Редактировать курсы", "custom-post-type-ui" ),
		"new_item" => __( "Новый курс", "custom-post-type-ui" ),
		"view_item" => __( "Просмотреть курс", "custom-post-type-ui" ),
		"view_items" => __( "Просмотреть курсы", "custom-post-type-ui" ),
		"search_items" => __( "Поиск курсов", "custom-post-type-ui" ),
		"not_found" => __( "Не найдено курсов", "custom-post-type-ui" ),
		"not_found_in_trash" => __( "Не найдено в корзине", "custom-post-type-ui" ),
		"archives" => __( "Архив курсов", "custom-post-type-ui" ),
		"attributes" => __( "Атрибуты курсов", "custom-post-type-ui" ),
		"name_admin_bar" => __( "Курсы", "custom-post-type-ui" ),
	);

	$args = array(
		"label" => __( "Курсы", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => array( "slug" => "courses", "with_front" => true ),
		"query_var" => true,
		"menu_position" => 15,
		"menu_icon" => "dashicons-networking",
		"supports" => array( "title", "editor", "thumbnail", "excerpt", "trackbacks", "custom-fields", "comments", "revisions", "author", "page-attributes", "post-formats", "Course-supports" ),
		"taxonomies" => array( "category", "post_tag" ),
	);

	register_post_type( "courses", $args );
}

add_action( 'init', 'cptui_register_my_cpts_courses' );


if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_5c0576bb6c1fd',
        'title' => 'О нас',
        'fields' => array(
            array(
                'key' => 'field_5c0576cabb7b2',
                'label' => 'Карта',
                'name' => 'карта',
                'type' => 'image',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
                'min_width' => '',
                'min_height' => '',
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '',
                'mime_types' => '',
            ),
            array(
                'key' => 'field_5c0576d7bb7b3',
                'label' => 'Адрес',
                'name' => 'адрес',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5c0576e3bb7b4',
                'label' => 'Почта',
                'name' => 'почта',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5c0576eabb7b5',
                'label' => 'Телефон',
                'name' => 'телефон',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => '5',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));
    
    acf_add_local_field_group(array(
        'key' => 'group_5c0a559eba82b',
        'title' => 'Скачать литературу',
        'fields' => array(
            array(
                'key' => 'field_5c0a55b199ad4',
                'label' => 'Файл для скачивания',
                'name' => 'файл_для_скачивания',
                'type' => 'file',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'url',
                'library' => 'all',
                'min_size' => '',
                'max_size' => '',
                'mime_types' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'literature',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));
    
    acf_add_local_field_group(array(
        'key' => 'group_5c0fbb536590f',
        'title' => 'Форма курсов',
        'fields' => array(
            array(
                'key' => 'field_5c0fbbfb0efb2',
                'label' => 'Преподаватель',
                'name' => 'преподаватель',
                'type' => 'text',
                'instructions' => 'Введите имя лектора',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_5c0fbcee0efb3',
                'label' => 'Программа курса',
                'name' => 'программа_курса',
                'type' => 'textarea',
                'instructions' => 'Введите программу курса',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => 3,
                'new_lines' => '',
            ),
            array(
                'key' => 'field_5c0fbdbf0efb4',
                'label' => 'Файл программы курса',
                'name' => 'файл_программы_курса',
                'type' => 'file',
                'instructions' => 'Поделитесь вашей программой с слушателями',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'url',
                'library' => 'all',
                'min_size' => '',
                'max_size' => '',
                'mime_types' => '.xls, .xla, .xlt, .jpg, .bmp',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'courses',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));
    
    endif;