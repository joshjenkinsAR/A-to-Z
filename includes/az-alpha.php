><?php 
function alphaindex_save_alpha( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	return;
	//only run for items
	$slug = 'item';
	$letter = '';
	// If this isn't a 'item', don't update it.
	if ( isset( $_POST['post_type'] ) && ( $slug != $_POST['post_type'] ) )
	return;
	// Check permissions
	if ( !current_user_can( 'edit_post', $post_id ) )
	return;
	// OK, we're authenticated: we need to find and save the data
	$taxonomy = 'alpha';
	if ( isset( $_POST['post_type'] ) ) {
		// Get the title of the post
		$title = strtolower( $_POST['post_title'] );
		
		// The next few lines remove A, An, or The from the start of the title
		$splitTitle = explode(" ", $title);
		$blacklist = array("an","a","the");
		$splitTitle[0] = str_replace($blacklist,"",strtolower($splitTitle[0]));
		$title = implode(" ", $splitTitle);
		
		// Get the first letter of the title
		$letter = substr( $title, 0, 1 );
		
		// Set to 0-9 if it's a number
		if ( is_numeric( $letter ) ) {
			$letter = '0-9';
		}
	}
	//set term as first letter of post title, lower case
	wp_set_post_terms( $post_id, $letter, $taxonomy );
}
add_action( 'save_post', 'alphaindex_save_alpha' );