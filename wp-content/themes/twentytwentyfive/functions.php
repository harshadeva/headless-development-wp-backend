<?php
/**
 * Twenty Twenty-Five functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

// Adds theme support for post formats.
if ( ! function_exists( 'twentytwentyfive_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'twentytwentyfive_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_editor_style() {
		add_editor_style( get_parent_theme_file_uri( 'assets/css/editor-style.css' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_editor_style' );

// Enqueues style.css on the front.
if ( ! function_exists( 'twentytwentyfive_enqueue_styles' ) ) :
	/**
	 * Enqueues style.css on the front.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_enqueue_styles() {
		wp_enqueue_style(
			'twentytwentyfive-style',
			get_parent_theme_file_uri( 'style.css' ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'twentytwentyfive_enqueue_styles' );

// Registers custom block styles.
if ( ! function_exists( 'twentytwentyfive_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'twentytwentyfive' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 'twentytwentyfive_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_pattern_categories() {

		register_block_pattern_category(
			'twentytwentyfive_page',
			array(
				'label'       => __( 'Pages', 'twentytwentyfive' ),
				'description' => __( 'A collection of full page layouts.', 'twentytwentyfive' ),
			)
		);

		register_block_pattern_category(
			'twentytwentyfive_post-format',
			array(
				'label'       => __( 'Post formats', 'twentytwentyfive' ),
				'description' => __( 'A collection of post format patterns.', 'twentytwentyfive' ),
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 'twentytwentyfive_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_register_block_bindings() {
		register_block_bindings_source(
			'twentytwentyfive/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'twentytwentyfive' ),
				'get_value_callback' => 'twentytwentyfive_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 'twentytwentyfive_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function twentytwentyfive_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;

// customized code for returning first category name for get posts rest api
function add_category_name_to_posts( $response, $post, $request ) {
	$categories = get_the_category( $post->ID );
    if ( ! empty( $categories ) ) {
		$response->data['category_name'] = $categories[0]->name;
    }
    return $response;
}
add_filter( 'rest_prepare_post', 'add_category_name_to_posts', 10, 3 );

// customized code for returning author details for get posts rest api
function add_author_data_to_posts( $response, $post, $request ) {
    $author_id = $post->post_author;
    $author_obj = get_user_by('id', $author_id);

    if ($author_obj) {
        $response->data['author_data'] = [
            'id'          => $author_obj->ID,
            'name'        => $author_obj->display_name,
            'slug'        => $author_obj->user_nicename,
            'description' => get_the_author_meta('description', $author_id),
            'avatar'      => get_avatar_url($author_id),
            'url'         => get_author_posts_url($author_id),
        ];
    }

    return $response;
}
add_filter( 'rest_prepare_post', 'add_author_data_to_posts', 10, 3 );

function add_featured_image_data_to_posts( $response, $post, $request ) {
    if ( has_post_thumbnail( $post->ID ) ) {
        $thumbnail_id = get_post_thumbnail_id( $post->ID );
        $thumbnail = wp_get_attachment_image_src( $thumbnail_id, 'full' );
        $media_data = wp_get_attachment_metadata( $thumbnail_id );

        $response->data['featured_image'] = [
            'url' => $thumbnail[0],
            'width' => $thumbnail[1],
            'height' => $thumbnail[2],
            'media_details' => $media_data,
        ];
    }

    return $response;
}
add_filter( 'rest_prepare_post', 'add_featured_image_data_to_posts', 10, 3 );


// this is custom api to get most liked posts
add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/most-commented-post', [
        'methods'  => 'GET',
        'callback' => 'get_most_commented_post',
        'permission_callback' => '__return_true', // public access
    ]);
});

function get_most_commented_post() {
    $args = [
        'posts_per_page' => 1,
        'orderby'        => 'comment_count',
        'order'          => 'DESC',
        'post_status'    => 'publish',
    ];

    $posts = get_posts($args);

    if (empty($posts)) {
        return new WP_REST_Response(['message' => 'No posts found'], 404);
    }

    $post = $posts[0];

    return [
        'id'           => $post->ID,
        'title'        => get_the_title($post),
        'content'      => apply_filters('the_content', $post->post_content),
        'comment_count'=> $post->comment_count,
        'permalink'    => get_permalink($post),
        'author'       => get_userdata($post->post_author)->display_name,
        'date'         => get_the_date('', $post),
        'categories'   => wp_get_post_categories($post->ID, ['fields' => 'names']),
        'featured_image' => get_the_post_thumbnail_url($post->ID, 'medium_large'),
    ];
}
