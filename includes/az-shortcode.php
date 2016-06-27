<?php
function az_shortcode($atts){

//Call the stylesheet if the shortcode is present
//wp_register_script( 'proglist-filter', plugins_url('list.min.js', __FILE__), array('jquery'), true );
//wp_register_script( 'proglist-init', plugins_url('init.js', __FILE__), array('dirswitch-filter'), true );

$terms = get_terms( 'alpha' );
 ?>
       <div id="az-index">

		   
			<?php 	
			foreach ( $terms as $term ) {
			
			
			
			$options = array(
				'post_type' => 'item',
				'orderby' => 'title',
				'order'   => 'ASC',
				'tax_query' => array (
							array (
								'taxonomy' => 'alpha',
								'field' => array($term->slug),
								'terms' => array($term->term_id),
							),
						),
			);	
			
			/*
			
			Basic structure outline for letter section.
			
			<div class="letter-heading">
				<div class="letter-holder">
					<h2>A</h2>
				</div>
				<ul class="items-list">
					<li></li>
				</ul>
			</div>
			
			
			*/
			
			
	$query = new WP_Query( $options );
    // run the loop based on the query
    if ( $query->have_posts() ) { 
			echo '<div class="'. $term->name .'">
				<div id="letter-heading">' . $term->name .'</div>';
				while ( $query->have_posts() ) : $query->the_post();
				 ?>
				<li class="plain-list switch-view">
					<a href="<?php the_permalink();?>" class="item-title"><?php the_title(); ?></a>
					<div class="hidden-card">
						<div class="item-description"><?php echo get_post_meta( get_the_ID(), 'item_description', true ); ?></div>
						<div class="item-location"><?php echo get_post_meta( get_the_ID(), 'item_location', true ); ?></div>
						<div class="item-link"><?php echo get_post_meta( get_the_ID(), 'item_link', true ); ?></div>
					</div>
				</li>
			
           		<?php 
				endwhile;
			echo '</div>';
			}  
    }
	
	echo '</div>';	
}
add_shortcode('az-index','az_shortcode');