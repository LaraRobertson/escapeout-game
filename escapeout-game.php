<?php
/**
 * Plugin Name:       EscapeOut Game
 * Description:       Allows user to create a game
 * Version:           0.1.9.1
 * Requires at least: 6.6
 * Requires PHP:      7.2
 * Author:            EscapeOut.Games
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       escapeout-game
 *
 * @package           create-block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * used handle for game-block/index.js
 * looked at source code to find handle  - it  is the id without the -js
 */
function my_enqueue_scripts(){
    wp_localize_script(
        'create-block-escapeout-game-editor-script',
        'my_data',
        [
            'siteUrl' => get_site_url(),
            'restBase' => get_rest_url(),
        ]
    );
    wp_localize_script( 'wp-api', 'wpApiSettings', array(
        'root' => esc_url_raw( rest_url() ),
        'nonce' => wp_create_nonce( 'wp_rest' )
    ) );

}
add_action( 'enqueue_block_editor_assets',  'my_enqueue_scripts' );



register_activation_hook( __FILE__, 'escapeout_table' );
function escapeout_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'game_score';

    $sql = "CREATE TABLE $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      postID varchar (100) NOT NULL,
      userID varchar (100) NOT NULL,
      gameID varchar (200) NOT NULL,
      userEmail varchar (200) NOT NULL,
      gameName varchar (200) NOT NULL,
      gameLink varchar (200) NOT NULL,
      designerEmail varchar (200) NOT NULL,
      designerName varchar (200),
      gameRating varchar (100),
      gameCommentPrivate varchar (200),
      gameCommentPublic varchar (200),
      gameCommentPublicApproved varchar (100),
      timeStart varchar (100),
      formattedDate varchar (100),
      timeEnd varchar (100),
      totalTime varchar (100),
      hintTime varchar (100),
      firstTime varchar (100),
      teamName varchar (100),
      completed varchar (100),
      userDelete varchar (100),
      adminDelete varchar (100),
      testing varchar (100),
      PRIMARY KEY  (id)
    )";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

/**
 * Register the REST API wp-learn-form-submissions-api/v1/form-submission routes
 * https://learn.wordpress.org/tutorial/wordpress-rest-api-custom-routes-endpoints/
 */
add_action( 'rest_api_init', 'escapeout_register_routes' );
function escapeout_register_routes() {
    // Register the routes

	// protect game info
	register_rest_route(
		'escapeout/v1',
		'/eo-game/(?P<id>\d+)',
		array(
			'methods'  => 'GET',
			'callback' => 'escapeout_get_eo_game_by_id',
			'permission_callback' => 'nonce_permission_callback'
		)
	);
    register_rest_route(
        'escapeout/v1',
        '/game-score/',
        array(
            'methods'  => 'GET',
            'callback' => 'escapeout_get_game_score',
            'permission_callback' => 'logged_in_permission_callback'
        )
    );
    /**
     * POST
     */
    register_rest_route(
        'escapeout/v1',
        '/game-score/',
        array(
            'methods'  => 'POST',
            'callback' => 'escapeout_create_game_score',
            'permission_callback' => 'logged_in_permission_callback'
        )
    );

    /**
     * PATCH
     */
    register_rest_route(
        'escapeout/v1',
        '/game-score-complete/(?P<id>\d+)',
        array(
            'methods'  => 'PATCH',
            'callback' => 'escapeout_update_game_score_complete',
            'permission_callback' => 'logged_in_permission_callback'
        )
    );
    /**
     * PATCH
     */
    register_rest_route(
        'escapeout/v1',
        '/game-score-delete/(?P<id>\d+)',
        array(
            'methods'  => 'DELETE',
            'callback' => 'escapeout_delete_game_score',
            'permission_callback' => 'logged_in_permission_callback'
        )
    );

    /**
     * PATCH
     */
    register_rest_route(
        'escapeout/v1',
        '/game-score-comment/(?P<id>\d+)',
        array(
            'methods'  => 'PATCH',
            'callback' => 'escapeout_update_game_score_comment',
            'permission_callback' => 'logged_in_permission_callback'
        )
    );
    /**
     * PATCH
     */
    register_rest_route(
        'escapeout/v1',
        '/game-score-comment-approve/(?P<id>\d+)',
        array(
            'methods'  => 'PATCH',
            'callback' => 'escapeout_update_game_score_comment_approve',
            'permission_callback' => 'logged_in_permission_callback'
        )
    );

    /**
     * Update single
     *
     * ?P<{name}>{regex-pattern}
     *
     * The start of the path variable is a query string using an upper case P as the query parameter
     * name is the name of the placeholder. This will be used to create the property on the $request object, to access the path variable value
     * regex-pattern is the regular expression pattern that the value should match. In this case, \d+ means that the value should be a number.
     */
    register_rest_route(
        'escapeout/v1',
        '/game-score/(?P<id>\d+)',
        array(
            'methods'  => 'GET',
            'callback' => 'escapeout_get_game_score_by_id',
            'permission_callback' => '__return_true'
        )
    );

    register_rest_route(
        'escapeout/v1',
        '/game-stats/(?P<id>\d+)',
        array(
            'methods'  => 'GET',
            'callback' => 'escapeout_get_game_stats_by_id',
            'permission_callback' => '__return_true'
        )
    );

	/**
	 * GET single for sensitive eo-game info
	 */
	register_rest_route(
		'escapeout/v1',
		'/eo-game/(?P<id>\d+)',
		array(
			'methods'  => 'GET',
			'callback' => 'escapeout_get_eo_game_attributes',
			'permission_callback' => 'nonce_permission_callback'
		)
	);

    // send email
    register_rest_route(
        'escapeout/v1',
        '/game-score-email/',
        array(
            'methods'  => 'POST',
            'callback' => 'escapeout_send_email',
            'permission_callback' => 'nonce_permission_callback'
        )
    );
}

//https://developer.wordpress.org/reference/functions/wp_mail/
function escapeout_send_email( $request) {
    $to = $request['designerEmail'];
    $userEmail = $request['userEmail'];
    $inputPublic = $request['inputPublic'];
    $inputPrivate = $request['inputPrivate'];
    $rating = $request['rating'];
    $gameName = $request['gameName'];
    $gameSlug = $request['gameSlug'];
    $gameScore = $request['gameScore'];
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $subject = "EsccapeOut.games - Game Comments: " . $gameName;
    $message  = "Player: " . $userEmail ."<br />";
    $message .= "Game Name: " . $gameName  ."<br />";
    $message .= "Game Slug: " . $gameSlug     ."<br />";
    $message .= "Private Comment: " . sanitize_textarea_field($inputPrivate)     ."<br />";
    $message .= "Public Comment: " . sanitize_textarea_field($inputPublic)     ."<br />";
    $message .= "Rating: " . $rating     ."<br />";
    $message .= "Game Score: " . $gameScore     ."<br />";

    wp_mail($to, $subject, $message, $headers);
}


function escapeout_update_game_score_complete( $request ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'game_score';

    $rows = $wpdb->update(
        $table_name,
        array(
            'timeEnd' => $request['timeEnd'],
            'totalTime' => $request['totalTime'],
            'hintTime' => $request['hintTime'],
            'completed' => $request['completed'],
        ),

        array(
            'id' => $request['id'],
        ),
    );

    return $rows;
}
function escapeout_delete_game_score( $request ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'game_score';

    $rows = $wpdb->delete(
        $table_name,

        array(
            'id' => $request['id'],
        ),
    );

    return $rows;
}

function escapeout_update_game_score_comment( $request ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'game_score';

    $rows = $wpdb->update(
        $table_name,
        array(
            'gameCommentPrivate' => $request['gameCommentPrivate'],
            'gameCommentPublic' => $request['gameCommentPublic'],
            'gameRating' => $request['gameRating'],
        ),

        array(
            'id' => $request['id'],
        ),
    );

    return $rows;
}

function escapeout_update_game_score_comment_approve( $request ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'game_score';

    $rows = $wpdb->update(
        $table_name,
        array(
            'gameCommentPublicApproved' => $request['gameCommentPublicApproved'],
        ),

        array(
            'id' => $request['id'],
        ),
    );

    return $rows;
}

function escapeout_admin_require_permissions() {
    return current_user_can( 'edit_posts' );
}

function nonce_permission_callback($request) {
	// Check if nonce is provided and validate it
	//$nonce = $request->get_param('_wpnonce');
	$nonce = $request->get_header('X-WP-Nonce');
	//$nonce = isset($_REQUEST['_wpnonce']) ? $_REQUEST['_wpnonce'] : '';

	if (!wp_verify_nonce($nonce, 'wp_rest')) {
		return new WP_Error('rest_forbidden', 'Invalid nonce', ['status' => 403]);
	}

	return true; // User is authorized
}

function logged_in_permission_callback($request) {
	// Check if nonce is provided and validate it
	//$nonce = $request->get_param('_wpnonce');
	$nonce = $request->get_header('X-WP-Nonce');
	//$nonce = isset($_REQUEST['_wpnonce']) ? $_REQUEST['_wpnonce'] : '';

	if (!wp_verify_nonce($nonce, 'wp_rest')) {
		return new WP_Error('rest_forbidden', 'Invalid nonce', ['status' => 403]);
	}

	// Check if the user is logged in
	if (!is_user_logged_in()) {
		return new WP_Error('rest_forbidden', 'User is not logged in', ['status' => 401]);
	}

	// Optional: Check for user capabilities if needed
	/*$user = wp_get_current_user();
	if (!user_can($user, 'manage_options')) {
		return new WP_Error('rest_forbidden', 'You do not have permission', ['status' => 403]);
	}*/

	return true; // User is authorized
}
/**
 * GET callback for the wp-learn-form-submissions-api/v1/form-submission route
 *
 * @return array|object|stdClass[]|null
 */
function escapeout_get_game_score($request) {
    $postID = $request->get_param('postID');
    $userID = $request->get_param('userID');
	$gameID = $request->get_param('gameID');
	$gameName = $request->get_param('gameName');
	$gameLink = $request->get_param('gameLink');
	$designerEmail = $request->get_param('designerEmail');
	$designerName = $request->get_param('designerName');
	$gameCommentPublic = $request->get_param('gameCommentPublic');
	$gameCommentPrivate = $request->get_param('gameCommentPrivate');
    $gameCommentPublicApproved = $request->get_param('gameCommentPublicApproved');
	$gameRating = $request->get_param('gameRating');
	$userEmail = $request->get_param('userEmail');
    $timeStart = $request->get_param('timeStart');
    $firstTime = $request->get_param('firstTime');
    $completed = $request->get_param('completed');

    global $wpdb;
    $table_name = $wpdb->prefix . 'game_score';

    if ($userEmail && $gameID) {
        if ($timeStart) {
            $results = $wpdb->get_results("SELECT * FROM `$table_name` WHERE `gameID` = '$gameID' AND `userEmail` = '$userEmail' AND `timeStart` = '$timeStart'");
        } else {
            $results = $wpdb->get_results("SELECT * FROM `$table_name` WHERE `gameID` = '$gameID' AND `userEmail` = '$userEmail'");
        }
    } elseif ($gameID) {
           $results = $wpdb->get_results( "SELECT * FROM `$table_name` WHERE `gameID` = '$gameID'" );
    } else {
		/* is this what I really want? */
        $results = $wpdb->get_results("SELECT * FROM $table_name");
    }
    return $results;

}

/**
 * POST callback for the wp-learn-form-submissions-api/v1/form-submission route
 *
 * @param $request
 *
 * @return void
 */
function escapeout_create_game_score( $request ){
    global $wpdb;
    $table_name = $wpdb->prefix . 'game_score';

    $rows = $wpdb->insert(
        $table_name,
        array(
            'postID' => $request['postID'],
            'userID' => $request['userID'],
            'gameID' => $request['gameID'],
            'gameName' => $request['gameName'],
            'gameCommentPublic' => $request['gameCommentPublic'],
            'gameCommentPublicApproved' => $request['gameCommentPublicApproved'],
            'gameCommentPrivate' => $request['gameCommentPrivate'],
            'gameRating' => $request['gameRating'],
            'userEmail' => $request['userEmail'],
            'designerEmail' => $request['designerEmail'],
            'designerName' => $request['designerName'],
            'timeStart' => $request['timeStart'],
            'formattedDate' => $request['formattedDate'],
            'timeEnd' => $request['timeEnd'],
            'totalTime' => $request['totalTime'],
            'hintTime' => $request['hintTime'],
            'firstTime' => $request['firstTime'],
            'teamName' => $request['teamName'],
            'testing' => $request['testing'],
            'completed' => $request['completed'],
        )
    );

    return $rows;
}
function escapeout_get_game_score_by_id( $request ) {
    $id = $request['id'];
    global $wpdb;
    $table_name = $wpdb->prefix . 'game_score';

    $results = $wpdb->get_results( "SELECT * FROM $table_name WHERE id = $id" );

    return $results[0];
}




function escapeout_get_eo_game_by_id( $request ) {
	$id = $request['id'];
	global $wpdb;
	$table_name = $wpdb->prefix . 'posts';

	$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE ID = $id" );

	return $results[0];
}

function escapeout_get_eo_game_attributes($request) {
	$id = $request['id'];
	global $wpdb;
	$table_name = $wpdb->prefix . 'posts';

	$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE id = $id" );

	return $results[0];

}
/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_game_block_block_init() {
	register_block_type_from_metadata( __DIR__ . '/build' );
}
add_action( 'init', 'create_block_game_block_block_init' );
function cptui_register_my_cpts() {

	/**
	 * Post Type: EO Games.
	 */

	$labels = [
		"name" => esc_html__( "EO Games", "escapeout-game" ),
		"singular_name" => esc_html__( "EO Game", "escapeout-game" ),
		"menu_name" => esc_html__( "EO Games", "escapeout-game" ),
		"all_items" => esc_html__( "All EO Games", "escapeout-game" ),
		"add_new" => esc_html__( "Add new", "escapeout-game" ),
		"add_new_item" => esc_html__( "Add new EO Game", "escapeout-game" ),
		"edit_item" => esc_html__( "Edit EO Game", "escapeout-game" ),
		"new_item" => esc_html__( "New EO Game", "escapeout-game" ),
		"view_item" => esc_html__( "View EO Game", "escapeout-game" ),
		"view_items" => esc_html__( "View EO Games", "escapeout-game" ),
		"search_items" => esc_html__( "Search EO Games", "escapeout-game" ),
		"not_found" => esc_html__( "No EO Games found", "escapeout-game" ),
		"not_found_in_trash" => esc_html__( "No EO Games found in trash", "escapeout-game" ),
		"parent" => esc_html__( "Parent EO Game:", "escapeout-game" ),
		"featured_image" => esc_html__( "Featured image for this EO Game", "escapeout-game" ),
		"set_featured_image" => esc_html__( "Set featured image for this EO Game", "escapeout-game" ),
		"remove_featured_image" => esc_html__( "Remove featured image for this EO Game", "escapeout-game" ),
		"use_featured_image" => esc_html__( "Use as featured image for this EO Game", "escapeout-game" ),
		"archives" => esc_html__( "EO Game archives", "escapeout-game" ),
		"insert_into_item" => esc_html__( "Insert into EO Game", "escapeout-game" ),
		"uploaded_to_this_item" => esc_html__( "Upload to this EO Game", "escapeout-game" ),
		"filter_items_list" => esc_html__( "Filter EO Games list", "escapeout-game" ),
		"items_list_navigation" => esc_html__( "EO Games list navigation", "escapeout-game" ),
		"items_list" => esc_html__( "EO Games list", "escapeout-game" ),
		"attributes" => esc_html__( "EO Games attributes", "escapeout-game" ),
		"name_admin_bar" => esc_html__( "EO Game", "escapeout-game" ),
		"item_published" => esc_html__( "EO Game published", "escapeout-game" ),
		"item_published_privately" => esc_html__( "EO Game published privately.", "escapeout-game" ),
		"item_reverted_to_draft" => esc_html__( "EO Game reverted to draft.", "escapeout-game" ),
		"item_trashed" => esc_html__( "EO Game trashed.", "escapeout-game" ),
		"item_scheduled" => esc_html__( "EO Game scheduled", "escapeout-game" ),
		"item_updated" => esc_html__( "EO Game updated.", "escapeout-game" ),
		"parent_item_colon" => esc_html__( "Parent EO Game:", "escapeout-game" ),
	];

	$args = [
		"label" => esc_html__( "EO Games", "escapeout-game" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"can_export" => true,
		"rewrite" => [ "slug" => "eo-game", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 5,
		"menu_icon" => "dashicons-awards",
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "revisions", "author", "page-attributes" ],
		"taxonomies" => [ "category", "post_tag", "city", "level", "location" ],
		"show_in_graphql" => false,
	];

	register_post_type( "eo-game", $args );
    register_post_meta('eo-game', '_wporg_meta_key',  array(
        'show_in_rest' => true ));
}

add_action( 'init', 'cptui_register_my_cpts' );
function cptui_register_my_taxes_city() {

	/**
	 * Taxonomy: Cities.
	 */

	$labels = [
		"name" => esc_html__( "Cities", "escapeout-game" ),
		"singular_name" => esc_html__( "City", "escapeout-game" ),
		"menu_name" => esc_html__( "Cities", "escapeout-game" ),
		"all_items" => esc_html__( "All Cities", "escapeout-game" ),
		"edit_item" => esc_html__( "Edit City", "escapeout-game" ),
		"view_item" => esc_html__( "View City", "escapeout-game" ),
		"update_item" => esc_html__( "Update City name", "escapeout-game" ),
		"add_new_item" => esc_html__( "Add new City", "escapeout-game" ),
		"new_item_name" => esc_html__( "New City name", "escapeout-game" ),
		"parent_item" => esc_html__( "Parent City", "escapeout-game" ),
		"parent_item_colon" => esc_html__( "Parent City:", "escapeout-game" ),
		"search_items" => esc_html__( "Search Cities", "escapeout-game" ),
		"popular_items" => esc_html__( "Popular Cities", "escapeout-game" ),
		"separate_items_with_commas" => esc_html__( "Separate Cities with commas", "escapeout-game" ),
		"add_or_remove_items" => esc_html__( "Add or remove Cities", "escapeout-game" ),
		"choose_from_most_used" => esc_html__( "Choose from the most used Cities", "escapeout-game" ),
		"not_found" => esc_html__( "No Cities found", "escapeout-game" ),
		"no_terms" => esc_html__( "No Cities", "escapeout-game" ),
		"items_list_navigation" => esc_html__( "Cities list navigation", "escapeout-game" ),
		"items_list" => esc_html__( "Cities list", "escapeout-game" ),
		"back_to_items" => esc_html__( "Back to Cities", "escapeout-game" ),
		"name_field_description" => esc_html__( "The name is how it appears on your site.", "escapeout-game" ),
		"parent_field_description" => esc_html__( "Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.", "escapeout-game" ),
		"slug_field_description" => esc_html__( "The slug is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.", "escapeout-game" ),
		"desc_field_description" => esc_html__( "The description is not prominent by default; however, some themes may show it.", "escapeout-game" ),
	];


	$args = [
		"label" => esc_html__( "Cities", "escapeout-game" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'city', 'with_front' => true, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"show_tagcloud" => true,
		"rest_base" => "city",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => true,
		"sort" => true,
		"show_in_graphql" => false,
	];
	register_taxonomy( "city", [ "eo-game" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_city' );
function cptui_register_my_taxes_level() {

	/**
	 * Taxonomy: Levels.
	 */

	$labels = [
		"name" => esc_html__( "Levels", "escapeout-game" ),
		"singular_name" => esc_html__( "Level", "escapeout-game" ),
		"menu_name" => esc_html__( "Levels", "escapeout-game" ),
		"all_items" => esc_html__( "All Levels", "escapeout-game" ),
		"edit_item" => esc_html__( "Edit Level", "escapeout-game" ),
		"view_item" => esc_html__( "View Level", "escapeout-game" ),
		"update_item" => esc_html__( "Update Level name", "escapeout-game" ),
		"add_new_item" => esc_html__( "Add Level", "escapeout-game" ),
		"new_item_name" => esc_html__( "New Level name", "escapeout-game" ),
		"parent_item" => esc_html__( "Parent Level", "escapeout-game" ),
		"parent_item_colon" => esc_html__( "Parent Level:", "escapeout-game" ),
		"search_items" => esc_html__( "Search Tybee Island Levels", "escapeout-game" ),
		"popular_items" => esc_html__( "Popular Tybee Island Levels", "escapeout-game" ),
		"separate_items_with_commas" => esc_html__( "Separate Tybee Island Levels with commas", "escapeout-game" ),
		"add_or_remove_items" => esc_html__( "Add or remove Tybee Island Levels", "escapeout-game" ),
		"choose_from_most_used" => esc_html__( "Choose from the most used Tybee Island Levels", "escapeout-game" ),
		"not_found" => esc_html__( "No Tybee Island Levels found", "escapeout-game" ),
		"no_terms" => esc_html__( "No Tybee Island Levels", "escapeout-game" ),
		"items_list_navigation" => esc_html__( "Tybee Island Levels list navigation", "escapeout-game" ),
		"items_list" => esc_html__( "Tybee Island Levels list", "escapeout-game" ),
		"back_to_items" => esc_html__( "Back to Tybee Island Levels", "escapeout-game" ),
		"name_field_description" => esc_html__( "The name is how it appears on your site.", "escapeout-game" ),
		"parent_field_description" => esc_html__( "Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.", "escapeout-game" ),
		"slug_field_description" => esc_html__( "The slug is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.", "escapeout-game" ),
		"desc_field_description" => esc_html__( "The description is not prominent by default; however, some themes may show it.", "escapeout-game" ),
	];


	$args = [
		"label" => esc_html__( "Levels", "escapeout-game" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'level', 'with_front' => true,  'hierarchical' => true, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"show_tagcloud" => true,
		"rest_base" => "level",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => true,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "level", [ "eo-game" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_level' );
function cptui_register_my_taxes_location() {

	/**
	 * Taxonomy: Locations.
	 */

	$labels = [
		"name" => esc_html__( "Locations", "escapeout-game" ),
		"singular_name" => esc_html__( "Location", "escapeout-game" ),
		"menu_name" => esc_html__( "Locations", "escapeout-game" ),
		"all_items" => esc_html__( "All Locations", "escapeout-game" ),
		"edit_item" => esc_html__( "Edit Location", "escapeout-game" ),
		"view_item" => esc_html__( "View Location", "escapeout-game" ),
		"update_item" => esc_html__( "Update Location name", "escapeout-game" ),
		"add_new_item" => esc_html__( "Add new Location", "escapeout-game" ),
		"new_item_name" => esc_html__( "New Location name", "escapeout-game" ),
		"parent_item" => esc_html__( "Parent Location", "escapeout-game" ),
		"parent_item_colon" => esc_html__( "Parent Location:", "escapeout-game" ),
		"search_items" => esc_html__( "Search Locations", "escapeout-game" ),
		"popular_items" => esc_html__( "Popular Locations", "escapeout-game" ),
		"separate_items_with_commas" => esc_html__( "Separate Locations with commas", "escapeout-game" ),
		"add_or_remove_items" => esc_html__( "Add or remove Locations", "escapeout-game" ),
		"choose_from_most_used" => esc_html__( "Choose from the most used Locations", "escapeout-game" ),
		"not_found" => esc_html__( "No Locations found", "escapeout-game" ),
		"no_terms" => esc_html__( "No Locations", "escapeout-game" ),
		"items_list_navigation" => esc_html__( "Locations list navigation", "escapeout-game" ),
		"items_list" => esc_html__( "Locations list", "escapeout-game" ),
		"back_to_items" => esc_html__( "Back to Locations", "escapeout-game" ),
		"name_field_description" => esc_html__( "The name is how it appears on your site.", "escapeout-game" ),
		"parent_field_description" => esc_html__( "Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.", "escapeout-game" ),
		"slug_field_description" => esc_html__( "The slug is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.", "escapeout-game" ),
		"desc_field_description" => esc_html__( "The description is not prominent by default; however, some themes may show it.", "escapeout-game" ),
	];


	$args = [
		"label" => esc_html__( "Locations", "escapeout-game" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'location', 'with_front' => true,  'hierarchical' => true, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"show_tagcloud" => true,
		"rest_base" => "location",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => true,
		"sort" => true,
		"show_in_graphql" => false,
	];
	register_taxonomy( "location", [ "eo-game" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_location' );


/* do I want to do this?? */
function tg_include_custom_post_types_in_archive_pages( $query ) {
	if ( $query->is_main_query() && ! is_admin() && ( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) ) {
		$query->set( 'post_type', array( 'eo-game', 'post' ) );
	}
}
add_action( 'pre_get_posts', 'tg_include_custom_post_types_in_archive_pages' );

function tg_include_custom_post_types_in_archive_pages2( $query ) {
    if ( $query->is_main_query() && ! is_admin() && ( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) ) {
        $query->set( 'post_status', 'publish' ); // we only want published posts, no drafts or private
    }
}
add_action( 'pre_get_posts', 'tg_include_custom_post_types_in_archive_pages2' );

/* causes a little error in author post screen
function tg_include_custom_post_types_in_author_pages( $query ) {
	if ($query->is_author) {

		$query->set('post_type', array('eo-game') );
		remove_action( 'pre_get_posts', 'tg_include_custom_post_types_in_author_pages' );

	}
}
add_action( 'pre_get_posts', 'tg_include_custom_post_types_in_author_pages' );*/

function reg_tag() {
	register_taxonomy_for_object_type('post_tag', 'eo-game');
}
add_action('init', 'reg_tag');

/* am hiding "status-private" so that you can see private posts in query but can access directly */
add_action( 'init', 'add_subscriber_private_page_capability' );
function add_subscriber_private_page_capability() {
    $role = get_role( 'subscriber' );
    if ( $role ) {
        $role->add_cap( 'read_private_posts' );
    }
    $role2 = get_role( 'author' );
    if ( $role2 ) {
        $role2->add_cap( 'read_private_posts' );
    }
}

/* added meta box so only admin can change test vs live on post by authors
 - see below for extra classes and styles to hide meta box */

// https://learn.wordpress.org/lesson/custom-post-type-data/#:~:text=Then%2C%20when%20editing%20a%20custom,a%20name%20and%20a%20value.
function wporg_add_custom_box() {
	add_meta_box(
		'wporg_box_id',                 // Unique ID
		'Test or Live game',      // Box title
		'wporg_custom_box_html',  // Content callback, must be of type callable
		'eo-game'                          // Post type
	);
}
add_action( 'add_meta_boxes', 'wporg_add_custom_box' );

function wporg_custom_box_html( $post ) {
	$value = get_post_meta( $post->ID, '_wporg_meta_key', true );
	?>
	<label for="wporg_field">Admin Only (change to Live when ready)</label>
	<select name="wporg_field" id="wporg_field" class="postbox">
		<option value="eo-test-game" <?php selected( $value, 'eo-test-game' ); ?>>Test Game</option>
		<option value="eo-live-game" <?php selected( $value, 'eo-live-game' ); ?>>Live Game</option>
	</select>
	<?php
}

function wporg_save_postdata( $post_id ) {
	if ( array_key_exists( 'wporg_field', $_POST ) ) {
		update_post_meta(
			$post_id,
			'_wporg_meta_key',
			$_POST['wporg_field']
		);
	}
}
add_action( 'save_post', 'wporg_save_postdata' );
/* end add meta box */

function auto_select_testing_tag( $post_ID ) {
    $testing_tag = get_term_by('slug', 'testing', 'post_tag');
    if ( !has_term( 'testing', 'post_tag', $post_ID ) && !has_term( 'live', 'post_tag', $post_ID ) ) {
        wp_set_post_tags( $post_ID, array( $testing_tag->term_id ), true );
    }
} add_action( 'save_post', 'auto_select_testing_tag' );

/* added class so can hide meta box with test vs live on post by authors */
add_filter( 'admin_body_class', 'admin_body_class' );
function admin_body_class( $classes ) {
	// Wrong: No space in the beginning/end.
	//$classes .= 'my-class1 my-class2';
	$user = wp_get_current_user();
	$roles = ( array ) $user->roles;
	if( $roles[0] ){
		$classes .= ' user-role-'.$roles[0].' ';
	}
	// Right: Add a leading space and a trailing space.
	//$classes .= ' my-class1 my-class2 ';

	return $classes;
}
/*current theme does not have a style-admin.css */
/*
 * function my_admin_style() {
 	wp_enqueue_style(
		'my-admin-styles',
		get_stylesheet_directory_uri() . '/style-admin.css'
	);
}
add_action('admin_enqueue_scripts', 'my_admin_style');
*/


function weplugins_query_vars( $qvars ) {
	$qvars[] = 'city';
	$qvars[] = 'location';
	$qvars[] = 'level';
	return $qvars;
}
add_filter( 'query_vars', 'weplugins_query_vars' );