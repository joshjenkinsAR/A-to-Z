<?php
/**
 * Register metaboxes
 */
class Item_Post_Type_Metaboxes {
	public function init() {
		add_action( 'add_meta_boxes', array( $this, 'item_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_meta_boxes' ),  10, 2 );
	}
	/**
	 * Register the metaboxes to be used for the item post type
	 *
	 * @since 0.1.0
	 */
	public function item_meta_boxes() {
		add_meta_box(
			'item_fields',
			'Item Fields',
			array( $this, 'render_meta_boxes' ),
			'item',
			'normal',
			'high'
		);
	}
   /**
	* The HTML for the fields
	*
	* @since 0.1.0
	*/
	function render_meta_boxes( $post ) {
		$meta = get_post_custom( $post->ID );
		$description = ! isset( $meta['item_description'][0] ) ? '' : $meta['item_description'][0];
		$location = ! isset( $meta['item_location'][0] ) ? '' : $meta['item_location'][0];
		$link = ! isset( $meta['item_link'][0] ) ? '' : $meta['item_link'][0];
		$related = ! isset( $meta['related_items'][0] ) ? '' : $meta['related_items'][0];
		$synonyms = ! isset( $meta['item_synonyms'][0] ) ? '' : $meta['item_synonyms'][0];
		wp_nonce_field( basename( __FILE__ ), 'item_fields' ); ?>

		<table class="form-table">

			<tr>
				<td class="item_meta_box_td" colspan="2">
					<label for="item_description"><?php _e( 'Description', 'item-post-type' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="item_description" class="regular-text" value="<?php echo $description; ?>">
					<p class="description"><?php _e( 'Brief text description here', 'item-post-type' ); ?></p>
				</td>
			</tr>
			<tr>
				<td class="item_meta_box_td" colspan="2">
					<label for="item_location"><?php _e( 'Location', 'item-post-type' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="item_location" class="regular-text" value="<?php echo $location; ?>">
					<p class="description"><?php _e( 'E.g. Bruce Center, Reynolds 201', 'item-post-type' ); ?></p>
				</td>
			</tr>

			<tr>
				<td class="item_meta_box_td" colspan="2">
					<label for="item_link"><?php _e( 'Link', 'item-post-type' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="item_link" class="regular-text" value="<?php echo $link; ?>">
				</td>
			</tr>

			<tr>
				<td class="item_meta_box_td" colspan="2">
					<label for="related_items"><?php _e( 'Related Items', 'item-post-type' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="related_items" class="regular-text" value="<?php echo $related; ?>">
				</td>
			</tr>

			<tr>
				<td class="item_meta_box_td" colspan="2">
					<label for="item_synonyms"><?php _e( 'Synonyms', 'item-post-type' ); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="item_synonyms" class="regular-text" value="<?php echo $synonyms; ?>">
				</td>
			</tr>

		</table>

	<?php }
   /**
	* Save metaboxes
	*
	* @since 0.1.0
	*/
	function save_meta_boxes( $post_id ) {
		global $post;
		// Verify nonce
		if ( !isset( $_POST['item_fields'] ) || !wp_verify_nonce( $_POST['item_fields'], basename(__FILE__) ) ) {
			return $post_id;
		}
		// Check Autosave
		if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || ( defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit']) ) {
			return $post_id;
		}
		// Don't save if only a revision
		if ( isset( $post->post_type ) && $post->post_type == 'revision' ) {
			return $post_id;
		}
		// Check permissions
		if ( !current_user_can( 'edit_post', $post->ID ) ) {
			return $post_id;
		}
		$meta['item_description'] = ( isset( $_POST['item_description'] ) ? esc_textarea( $_POST['item_description'] ) : '' );
		$meta['item_location'] = ( isset( $_POST['item_location'] ) ? esc_textarea( $_POST['item_location'] ) : '' );
		$meta['related_items'] = ( isset( $_POST['related_items'] ) ? esc_textarea( $_POST['related_items'] ) : '' );
		$meta['item_synonyms'] = ( isset( $_POST['item_synonyms'] ) ? esc_textarea( $_POST['item_synonyms'] ) : '' );
		$meta['item_link'] = ( isset( $_POST['item_link'] ) ? esc_url( $_POST['item_link'] ) : '' );
		foreach ( $meta as $key => $value ) {
			update_post_meta( $post->ID, $key, $value );
		}
	}
}