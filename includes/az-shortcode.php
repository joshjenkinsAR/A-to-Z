<?php
function az_scripts_styles() {
    wp_register_style( 'shortcode-style', plugins_url('style.css', __FILE__));
	wp_enqueue_style( 'shortcode-style' );
	wp_enqueue_script( 'az-script', plugins_url('script.js', __FILE__), array('jquery', 'wow-js'), false );
	wp_enqueue_script('wow-js', get_stylesheet_directory_uri() .'/js/wow.min.js', false);
	wp_register_style( 'animate-css', get_stylesheet_directory_uri() .'/js/animate.css');
	wp_enqueue_style( 'animate-css' );
}
add_action( 'wp_enqueue_scripts', 'az_scripts_styles' );

function az_shortcode($atts){

$terms = get_terms( 'alpha' );
 ?>
       
	   <div class="index-menu">
		<ul id="atoz">
			<li class="letter"><a href="#letter-a">A</a></li>
			<li class="letter"><a href="#letter-b">B</a></li>
			<li class="letter"><a href="#letter-c">C</a></li>
			<li class="letter"><a href="#letter-d">D</a></li>
			<li class="letter"><a href="#letter-e">E</a></li>
			<li class="letter"><a href="#letter-f">F</a></li>
			<li class="letter"><a href="#letter-g">G</a></li>
			<li class="letter"><a href="#letter-h">H</a></li>
			<li class="letter"><a href="#letter-i">I</a></li>
			<li class="letter"><a href="#letter-j">J</a></li>
			<li class="letter"><a href="#letter-k">K</a></li>
			<li class="letter"><a href="#letter-l">L</a></li>
			<li class="letter"><a href="#letter-m">M</a></li>
			<li class="letter"><a href="#letter-n">N</a></li>
			<li class="letter"><a href="#letter-o">O</a></li>
			<li class="letter"><a href="#letter-p">P</a></li>
			<li class="letter"><a href="#letter-r">R</a></li>
			<li class="letter"><a href="#letter-s">S</a></li>
			<li class="letter"><a href="#letter-t">T</a></li>
			<li class="letter"><a href="#letter-u">U</a></li>
			<li class="letter"><a href="#letter-v">V</a></li>
			<li class="letter"><a href="#letter-w">W</a></li>
			<li class="letter"><a href="#letter-y">Y</a></li>
			<li class="letter"><a href="#letter-z">Z</a></li>
		</ul>
		</div>
			<div class="az-search"><form id="live-search" class="styled" action="" method="post">
			<fieldset><input id="filter" class="text-input" type="text" value="" placeholder="Type here and filter results below..." /></fieldset>
			</form></div>
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
			
	
			
			
	$query = new WP_Query( $options );
    // run the loop based on the query
    if ( $query->have_posts() ) { 
			echo '<div id="letter-'. $term->name .'" class="'. $term->name .' letter-section ">
				<div class="letter-holder">' . $term->name .'</div>';
			echo '<div class="item-holder">';
			echo '<ul class="item-list">';
				while ( $query->have_posts() ) : $query->the_post();
				 ?>
					<li class="item">
						<div class="plus-icon"><i class="fa fa-plus"></i></div> <a href="<?php echo get_post_meta( get_the_ID(), 'item_link', true ); ?>" class="item-title"><?php the_title(); ?></a>
						<div class="hidden-card">
							<div class="item-description"><?php echo get_post_meta( get_the_ID(), 'item_description', true ); ?></div>
							<div class="item-location"><?php echo get_post_meta( get_the_ID(), 'item_location', true ); ?></div>
							<div class="item-link">
								<a class="button" href="<?php echo get_post_meta( get_the_ID(), 'item_link', true ); ?>">Visit Site</a>
							</div>
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