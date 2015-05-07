<?php
/**
 * Template Name: GLM Home Page
 *
 * This Full Width template removes the primary and secondary asides so that content
 * can be displayed the entire width of the #content area.
 *
 */


    // calling the header.php
    get_header();

    // action hook for placing content above #container
    thematic_abovecontainer();

?>

		<div id="container-homepage">
		    <?php if (function_exists('easing_slider')){ easing_slider(); }; ?>

			<?php thematic_abovecontent(); ?>
		
			<div id="content"style="margin-left:10px;">
	
	            <?php
	        
	            // calling the widget area 'page-top'
	            get_sidebar('page-top');
	
	            the_post();
	            
	            thematic_abovepost();
	        
	            ?>
	            
				
				<div id="post-<?php the_ID();
					echo '" ';
					if (!(THEMATIC_COMPATIBLE_POST_CLASS)) {
						post_class();
						echo '>';
					} else {
						echo 'class="';
						thematic_post_class();
						echo '">';
					}
	                
	                // creating the post header
	                //thematic_postheader();
	                
	                ?>
	                
					<div class="entry-content">
	
						<?php
	                    	the_content();
	                    
	                    	wp_link_pages( "\t\t\t\t\t<div class='page-link'>" . __( 'Pages: ', 'thematic' ), "</div>\n", 'number' );
	                    
	                    	edit_post_link( __( 'Edit', 'thematic' ), "\n\t\t\t\t\t\t" . '<span class="edit-link">' , '</span>' . "\n" );
	                    ?>

					</div><!-- .entry-content -->
				</div><!-- .post -->
	
	        <?php
	        
	        thematic_belowpost();
	        
	        // calling the comments template
	        thematic_comments_template();
	        
	        // calling the widget area 'page-bottom'
	        get_sidebar('page-bottom');
	        
	        ?>
	
			</div><!-- #content -->
			<?php thematic_belowcontent(); ?> 
			
			
		</div><!-- #container -->

<?php 

    // action hook for placing content below #container
    thematic_belowcontainer();
    
    // calling footer.php
    get_footer();

?>