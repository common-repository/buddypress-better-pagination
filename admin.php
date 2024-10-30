<?php 

function bpag_admin() {
	global $bp;

	/* If the form has been submitted and the admin referrer checks out, save the settings */
	if ( isset( $_POST['submit'] ) && check_admin_referer('bpag_admin') ) {
		update_option( 'bpag_per_page_groups', $_POST['bpag_per_page_groups'] );
		update_option( 'bpag_per_page_forums', $_POST['bpag_per_page_forums'] );
		update_option( 'bpag_per_page_members', $_POST['bpag_per_page_members'] );
		update_option( 'bpag_per_page_blogs', $_POST['bpag_per_page_blogs'] );
		update_option( 'bpag_per_page_messages', $_POST['bpag_per_page_messages'] );
		$updated = true;
	}

?>	

	<div class="wrap">
		<h2>BuddyPress Better Pagination</h2>

		<?php if ( isset($updated) ) : ?><div id='message' class='updated fade'><p>Settings Updated</p></div><?php endif; ?>

		<form action="<?php echo site_url() . '/wp-admin/admin.php?page=bpag_admin' ?>" name="bpag-settings-form" id="bpag-settings-form" method="post">

			<h3>Number of items to show for in directory listings</h3>
			<p>A good number to show per page is between 20 and 40. However remember that increasing it too much will result in quite large page sizes. To return to the BuddyPress defaults leave a field blank.</p>
			Groups Directory Per Page <input name="bpag_per_page_groups" type="text" value="<?php echo get_option( 'bpag_per_page_groups' ); ?>" size="5" /><br>			
			Forums Directory Per Page <input name="bpag_per_page_forums" type="text" value="<?php echo get_option( 'bpag_per_page_forums' ); ?>" size="5" /><br>
			Members/Friends Directory Per Page <input name="bpag_per_page_members" type="text" value="<?php echo get_option( 'bpag_per_page_members' ); ?>" size="5" /><br>
			Blogs Directory Per Page <input name="bpag_per_page_blogs" type="text" value="<?php echo get_option( 'bpag_per_page_blogs' ); ?>" size="5" /><br>
			Messages Inbox Per Page <input name="bpag_per_page_messages" type="text" value="<?php echo get_option( 'bpag_per_page_messages' ); ?>" size="5" /><br>
			
			<p class="submit"><input type="submit" name="submit" value="Save Settings"/></p>

			<?php
			/* This is very important, don't leave it out. */
			wp_nonce_field( 'bpag_admin' );
			?>
		</form>
	</div>
<?php
}
?>