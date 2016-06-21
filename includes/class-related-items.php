<?php 
class WPSE_85107 {
  var $FOR_POST_TYPE = 'item';
  var $SELECT_POST_TYPE = 'item';
  var $SELECT_POST_LABEL = 'Related Items';
  var $box_id;
  var $box_label;
  var $field_id;
  var $field_label;
  var $field_name;
  var $meta_key;
  function __construct() {
    add_action( 'admin_init', array( $this, 'admin_init' ) );
  }
  function admin_init() {
    add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
    add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
    $this->meta_key     = "_selected_{$this->SELECT_POST_TYPE}";
    $this->box_id       = "select-{$this->SELECT_POST_TYPE}-metabox";
    $this->field_id     = "selected-{$this->SELECT_POST_TYPE}";
    $this->field_name   = "selected_{$this->SELECT_POST_TYPE}";
    $this->box_label    = __( "Select {$this->SELECT_POST_LABEL}", 'wpse-85107' );
    $this->field_label  = __( "Choose {$this->SELECT_POST_LABEL}", 'wpse-85107' );
  }
  function add_meta_boxes() {
    add_meta_box(
      $this->box_id,
      $this->box_label,
      array( $this, 'select_box' ),
      $this->FOR_POST_TYPE,
      'side'
    );
  }
  function select_box( $post ) {
    $selected_post_id = get_post_meta( $post->ID, $this->meta_key, true );
    global $wp_post_types;
    $save_hierarchical = $wp_post_types[$this->SELECT_POST_TYPE]->hierarchical;
    $wp_post_types[$this->SELECT_POST_TYPE]->hierarchical = true;
	
	
	
   
    $wp_post_types[$this->SELECT_POST_TYPE]->hierarchical = $save_hierarchical;
  }
  function save_post( $post_id, $post ) {
    if ( $post->post_type == $this->FOR_POST_TYPE && isset( $_POST[$this->field_name] ) ) {
      update_post_meta( $post_id, $this->meta_key, $_POST[$this->field_name] );
    }
  }
}
new WPSE_85107();