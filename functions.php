<?php

/**
 * radical functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package radical
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

if (!function_exists('rdl_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function rdl_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on radical, use a find and replace
		 * to change 'rdl' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('rdl', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');
	}
endif;
add_action('after_setup_theme', 'rdl_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function rdl_content_width()
{
	$GLOBALS['content_width'] = apply_filters('rdl_content_width', 640);
}
add_action('after_setup_theme', 'rdl_content_width', 0);

/**
 * Enqueue scripts and styles.
 */
function rdl_scripts()
{
	wp_enqueue_style('rdl-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_enqueue_style('rdl-stylesheet', get_template_directory_uri() . '/dist/css/style.min.css', array(), _S_VERSION);

	wp_enqueue_script('rdl-custom-js', get_template_directory_uri() . '/dist/js/app.js', '', _S_VERSION, true);

	// передаем данные в подключенные скрипты
	wp_localize_script('rdl-custom-js', 'myajax', array(
		'url' => admin_url('admin-ajax.php'),
	));
}
add_action('wp_enqueue_scripts', 'rdl_scripts');

// Добавляем свой тип записи
add_action('init', 'register_post_types');
function register_post_types()
{
	register_post_type('portfolio', [
		'label'  => null,
		'labels' => [
			'name'               => 'Проекты', // основное название для типа записи
			'singular_name'      => 'Проекты', // название для одной записи этого типа
			'add_new'            => 'Добавить новый проект', // для добавления новой записи
			'add_new_item'       => 'Добавить новый проект', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактировать проект', // для редактирования типа записи
			'new_item'           => 'Новый проект', // текст новой записи
			'view_item'          => 'Смотреть проект', // для просмотра записи этого типа.
			'search_items'       => 'Искать проект', // для поиска по этим типам записи
			'not_found'          => 'Ничего не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Ничего не найдено в корзине', // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => 'Проекты', // название меню
		],
		'description'         => 'Проекты',
		'public'              => true,
		'show_in_menu'        => true, // показывать ли в меню адмнки
		'rest_base'           => null, // $post_type. C WP 4.7
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-portfolio',
		'hierarchical'        => true,
		'show_in_rest'		  => true,
		'supports'            => ['title', 'excerpt'], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		'taxonomies'          => ['theme'],
		'has_archive'         => true,
		'rewrite'             => true,
		'query_var'           => true,
	]);
	register_post_type('blog', [
		'label'  => null,
		'labels' => [
			'name'               => 'Блог', // основное название для типа записи
			'singular_name'      => 'Блог', // название для одной записи этого типа
			'add_new'            => 'Добавить новую статью', // для добавления новой записи
			'add_new_item'       => 'Добавить новую статью', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактировать статью', // для редактирования типа записи
			'new_item'           => 'Новая статья', // текст новой записи
			'view_item'          => 'Смотреть статью', // для просмотра записи этого типа.
			'search_items'       => 'Искать статью', // для поиска по этим типам записи
			'not_found'          => 'Ничего не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Ничего не найдено в корзине', // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => 'Блог', // название меню
		],
		'description'         => 'Блог',
		'public'              => true,
		'show_in_menu'        => true, // показывать ли в меню адмнки
		'rest_base'           => null, // $post_type. C WP 4.7
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-admin-post',
		'hierarchical'        => true,
		'show_in_rest'		  => true,
		'supports'            => ['title', 'editor', 'thumbnail'], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		'taxonomies'          => ['rubric'],
		'has_archive'         => true,
		'rewrite'             => true,
		'query_var'           => true,
	]);
}

// Добавляем таксономии для своего типа записей
add_action('init', 'create_taxonomy');
function create_taxonomy()
{
	// список параметров: wp-kama.ru/function/get_taxonomy_labels
	register_taxonomy('theme', ['portfolio'], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => 'Категории',
			'singular_name'     => 'Категории',
			'search_items'      => 'Искать по категории',
			'all_items'         => 'Все категории',
			'view_item '        => 'Смотреть категорию',
			'edit_item'         => 'Редактировать',
			'update_item'       => 'Обновить',
			'add_new_item'      => 'Добавить новую категорию',
			'menu_name'         => 'Категории',
		],
		'description'           => 'Категории', // описание таксономии
		'public'                => true,
		'publicly_queryable'    => null, // равен аргументу public
		'show_in_nav_menus'     => true, // равен аргументу public
		'show_ui'               => true, // равен аргументу public
		'show_in_menu'          => true, // равен аргументу show_ui
		'show_tagcloud'         => true, // равен аргументу show_ui
		'show_in_quick_edit'    => true, // равен аргументу show_ui
		'show_admin_column'		=> true,
		'show_in_rest'			=> true,
		'hierarchical'          => false,
		'rewrite'               => true,
	]);
	register_taxonomy('rubric', ['blog'], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => 'Рубрика',
			'singular_name'     => 'Рубрика',
			'search_items'      => 'Искать по рубрике',
			'all_items'         => 'Все рубрики',
			'view_item '        => 'Смотреть рубрику',
			'edit_item'         => 'Редактировать',
			'update_item'       => 'Обновить',
			'add_new_item'      => 'Добавить новую рубрику',
			'menu_name'         => 'Рубрика',
		],
		'description'           => 'Рубрика', // описание таксономии
		'public'                => true,
		'publicly_queryable'    => null, // равен аргументу public
		'show_in_nav_menus'     => true, // равен аргументу public
		'show_ui'               => true, // равен аргументу public
		'show_in_menu'          => true, // равен аргументу show_ui
		'show_tagcloud'         => true, // равен аргументу show_ui
		'show_in_quick_edit'    => true, // равен аргументу show_ui
		'show_admin_column'		=> true,
		'show_in_rest'			=> true,
		'hierarchical'          => false,
		'rewrite'               => true,
	]);
}

// Добавляем страницу настроек для работ
function mindbase_create_acf_pages()
{
	if (function_exists('acf_add_options_page')) {
		acf_add_options_sub_page(array(
			'page_title'      => 'Настройки архива работ', /* Use whatever title you want */
			'parent_slug'     => 'edit.php?post_type=interior', /* Change "interior" to fit your situation */
			'capability' => 'manage_options'
		));
	}
}
add_action('init', 'mindbase_create_acf_pages');

// Выводим настройки в меню админки
if (function_exists('acf_add_options_page')) {
	// Main Theme Settings Page
	$parent = acf_add_options_page(array(
		'page_title' => 'Основные настройки темы',
		'menu_title' => 'Настройки темы',
		'redirect'   => 'Theme Settings',
	));
}

// Изменяем стартовую высоту textarea в advanced custom field
function PREFIX_apply_acf_modifications()
{
?>
	<style>
		.acf-editor-wrap iframe {
			min-height: 0;
		}
	</style>
	<script>
		(function($) {
			// (filter called before the tinyMCE instance is created)
			acf.add_filter('wysiwyg_tinymce_settings', function(mceInit, id, $field) {
				// enable autoresizing of the WYSIWYG editor
				mceInit.wp_autoresize_on = true;
				return mceInit;
			});
			// (action called when a WYSIWYG tinymce element has been initialized)
			acf.add_action('wysiwyg_tinymce_init', function(ed, id, mceInit, $field) {
				// reduce tinymce's min-height settings
				ed.settings.autoresize_min_height = 130;
				// reduce iframe's 'height' style to match tinymce settings
				$('.acf-editor-wrap iframe').css('height', '130px');
			});
		})(jQuery)
	</script>
<?php
}
add_action('acf/input/admin_footer', 'PREFIX_apply_acf_modifications');

// Отключение Emoji в WordPress
function disable_emojis()
{
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
	add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
}
add_action('init', 'disable_emojis');
function disable_emojis_tinymce($plugins)
{
	if (is_array($plugins)) {
		return array_diff($plugins, array('wpemoji'));
	} else {
		return array();
	}
}

// Удаление стилей и скриптов wordpress по умолчанию
function wpassist_remove_block_library_css()
{
	wp_dequeue_style('global-styles');
	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wp-block-library-theme');
	wp_dequeue_style('wc-blocks-style');
	wp_dequeue_style('woocommerce-general');
	wp_dequeue_style('woocommerce-layout');
	wp_dequeue_style('woocommerce-smallscreen');
	wp_dequeue_style('font-awesome');
	wp_dequeue_style('yith-wcwl-main');

	wp_dequeue_script('prettyPhoto');
	wp_dequeue_script('prettyPhoto-init');
}
add_action('wp_enqueue_scripts', 'wpassist_remove_block_library_css');

remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');

function agentwp_dequeue_stylesandscripts()
{
	if (class_exists('woocommerce')) {
		wp_dequeue_style('selectWoo');
		wp_deregister_style('selectWoo');

		wp_dequeue_script('selectWoo');
		wp_deregister_script('selectWoo');

		wp_dequeue_script('wc-country-select');
	}
}

// Удаляем <p> и <br/> из Contact Form 7
add_filter('wpcf7_autop_or_not', '__return_false');

/* Меняем у excerpt '[...]' на '...' */
add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more($more)
{
	global $post;
	return '...';
}
/* Меняем длину excerpt с 55 на 40 */
function wp_example_excerpt_length($length)
{
	return 40;
}
add_filter('excerpt_length', 'wp_example_excerpt_length');

/* Удаляем лишние пункты меню из админки */
function remove_options()
{
	remove_menu_page('edit.php');
	remove_menu_page('edit-comments.php');
	remove_menu_page('themes.php');
}
add_action('admin_menu', 'remove_options');

// Ajax загрузка постов в блоге
add_action('wp_ajax_getpost', 'rdl_get_posts');
add_action('wp_ajax_nopriv_getpost', 'rdl_get_posts');
function rdl_get_posts()
{
	if (!empty($_POST['taxonomy'])) {
		$args = array(
			'post_type' => $_POST['post_type'],
			'tax_query' => array(
				array(
					'taxonomy' => 'rubric',
					'field'    => 'slug',
					'terms'    => $_POST['taxonomy']
				)
			),
			'posts_per_page' => get_option('posts_per_page'), //posts per one load
			'paged' => $_POST['page'],
		);
	} else {
		$args = array(
			'post_type' => $_POST['post_type'],
			'posts_per_page' => get_option('posts_per_page'), //posts per one load
			'paged' => $_POST['page'],
		);
	}

	query_posts($args);

	if (have_posts()) :
		while (have_posts()) :
			the_post();

			echo '<article class="blog__item blog-item">';
				echo '<img src="' . get_the_post_thumbnail_url() . '" alt="" loading="lazy">';

				echo '<div class="blog-item__body">';
					echo '<div class="blog-item__heading">';
						echo '<div class="blog-item__date">' . get_the_date() . '</div>';
						echo '<a href="' . get_the_permalink() . '" class="blog-item__caption">';
							echo '<span>' . get_the_title() . '</span>';
							echo '<i class="_icon-arrow-left"></i>';
						echo '</a>';
					echo '</div>';
					echo '<div class="blog-item__excerpt _content">' . get_the_excerpt() . '</div>';
				echo '</div>';
			echo '</article>';
		endwhile;

		wp_reset_query();
	endif;

	wp_die();
}
