<?php
function az_shortcode($atts){

//Call the stylesheet if the shortcode is present
wp_register_style( 'shortcode-style', plugins_url('style.css', __FILE__));
wp_enqueue_style( 'shortcode-style' );
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
			
			<div class="b">
				<div class="letter-holder">b</div>
				<div class="item-holder">
					<ul>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
					</ul>
				</div>
			</div>
			
			
			*/
			
			
	$query = new WP_Query( $options );
    // run the loop based on the query
    if ( $query->have_posts() ) { 
			echo '<div class="'. $term->name .'">
				<div id="letter-holder">' . $term->name .'</div>';
			echo '<div class="item-holder">';
			echo '<ul class="item-list">';
				while ( $query->have_posts() ) : $query->the_post();
				 ?>
				 
					<li class="item">
						<a href="<?php the_permalink();?>" class="item-title"><?php the_title(); ?></a>
						<div class="hidden-card">
							<div class="item-description"><?php echo get_post_meta( get_the_ID(), 'item_description', true ); ?></div>
							<div class="item-location"><?php echo get_post_meta( get_the_ID(), 'item_location', true ); ?></div>
							<div class="item-link"><?php echo get_post_meta( get_the_ID(), 'item_link', true ); ?></div>
						</div>
					</li>
				
           		<?php 
				endwhile;
				echo '</ul>';
				echo '</div>';
			echo '</div>';
			}  
    }
	
	echo '</div>';	
}
add_shortcode('az-index','az_shortcode');