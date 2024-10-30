<?php
/*
Plugin Name: BuddyPress Better Pagination
Plugin URI: http://buddypress.org/community/groups/buddypress-better-pagination/
Description: Adds pagination links at the bottom of all directories in BuddyPress - in groups, forums, members, friends, blogs, messages. It also makes the pagination links bolder. 
Version: 1.0
Author: Deryk Wenaus
Author URI: http:://bluemandala.com
*/


// make the pagination links a bit bolder
function bpag_css() {
	echo '<link rel="stylesheet" type="text/css" href="'.WP_PLUGIN_URL.'/buddypress-better-pagination/pagination.css" media="screen" />'."\n";
}
add_action('wp_head', 'bpag_css');



//
// Better Pagination Links
//

// add pagination links to the bottom of the GROUPS directory
function add_bottom_pagination_links_group() {
	?>
	<div class="pagination" style="margin-top:5px;">

		<div class="pag-count" id="group-dir-count">
			<?php bp_groups_pagination_count() ?>
		</div>

		<div class="pagination-links" id="group-dir-pag">
			<?php bp_groups_pagination_links() ?>
		</div>

	</div>
	<?php
}
add_action( 'bp_after_groups_loop', 'add_bottom_pagination_links_group' );


// add pagination links to the bottom of the MEMBERS and friends directory
function add_bottom_pagination_links_members() {
	?>
	<div class="pagination">

		<div class="pag-count" id="member-dir-count">
			<?php bp_members_pagination_count() ?>
		</div>

		<div class="pagination-links" id="member-dir-pag">
			<?php bp_members_pagination_links() ?>
		</div>

	</div>
	<?php
}
add_action( 'bp_after_members_loop', 'add_bottom_pagination_links_members' );


// add pagination links to the bottom of the FORUMS directory
function add_bottom_pagination_links_forums() {
	?>
	<div class="pagination">

		<div id="post-count" class="pag-count">
			<?php bp_forum_pagination_count() ?>
		</div>

		<div class="pagination-links" id="topic-pag">
			<?php bp_forum_pagination() ?>
		</div>

	</div>
	<?php
}
add_action( 'bp_after_directory_forums_list', 'add_bottom_pagination_links_forums' );


// add pagination links to the bottom of the BLOGS directory
function add_bottom_pagination_links_blogs() {
	?>
	<div class="pagination no-ajax" id="user-pag">

		<div class="pag-count" id="messages-dir-count">
			<?php bp_messages_pagination_count() ?>
		</div>

		<div class="pagination-links" id="messages-dir-pag">
			<?php bp_messages_pagination() ?>
		</div>

	</div><!-- .pagination -->
	<?php
}
add_action( 'bp_after_directory_blogs_list', 'add_bottom_pagination_links_blogs' );


// add pagination links to the bottom of the MESSAGES list
function add_bottom_pagination_links_messages() {
	?>
	<div class="pagination">

		<div class="pag-count" id="blog-dir-count">
			<?php bp_blogs_pagination_count() ?>
		</div>

		<div class="pagination-links" id="blog-dir-pag">
			<?php bp_blogs_pagination_links() ?>
		</div>

	</div>
	<?php
}
add_action( 'bp_after_member_messages_threads', 'add_bottom_pagination_links_messages' );



// change the pagination for each item type
function bpag_increase_per_page_default( $query_string ) {
	global $bp;

	$groups_per = get_option( 'bpag_per_page_groups' );
	$forums_per = get_option( 'bpag_per_page_forums' );
	$members_per = get_option( 'bpag_per_page_members' );
	$blogs_per = get_option( 'bpag_per_page_blogs' );
	$messages_per = get_option( 'bpag_per_page_messages' );

	if ( $groups_per && 'groups' == $bp->current_component )
		return $query_string . '&per_page='.$groups_per;

	if ( $forums_per && 'forums' == $bp->current_component )
		return $query_string . '&per_page='.$forums_per;

	if ( $members_per && ( 'members' == $bp->current_component || 'friends' == $bp->current_component ) )
		return $query_string . '&per_page='.$members_per;

	if ( $blogs_per && 'blogs' == $bp->current_component )
		return $query_string . '&per_page='.$blogs_per;

	if ( $messages_per && 'messages' == $bp->current_component )
		return $query_string . '&per_page='.$messages_per;		

	return $query_string;
}
add_filter( 'bp_dtheme_ajax_querystring', 'bpag_increase_per_page_default', 20 );


// setting for the admin page
function bpag_add_admin_menu() {
	global $bp;
	if ( !$bp->loggedin_user->is_site_admin )
		return false;
	require ( dirname( __FILE__ ) . '/admin.php' );
	add_submenu_page( 'bp-general-settings', 'Better Pagination', 'Better Pagination', 'manage_options', 'bpag_admin', 'bpag_admin' );
}
add_action( 'admin_menu', 'bpag_add_admin_menu', 20 );


?>