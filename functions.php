<?php

//
//  Custom Child Theme Functions
//

// I've included a "commented out" sample function below that'll add a home link to your menu
// More ideas can be found on "A Guide To Customizing The Thematic Theme Framework" 
// http://themeshaper.com/thematic-for-wordpress/guide-customizing-thematic-theme-framework/

// Adds a home link to your menu
// http://codex.wordpress.org/Template_Tags/wp_page_menu
//function childtheme_menu_args($args) {
//    $args = array(
//        'show_home' => 'Home',
//        'sort_column' => 'menu_order',
//        'menu_class' => 'menu',
//        'echo' => true
//    );
//	return $args;
//}
//add_filter('wp_page_menu_args','childtheme_menu_args');

// Unleash the power of Thematic's dynamic classes
// 
// define('THEMATIC_COMPATIBLE_BODY_CLASS', true);
// define('THEMATIC_COMPATIBLE_POST_CLASS', true);

// Unleash the power of Thematic's comment form

 define('THEMATIC_COMPATIBLE_COMMENT_FORM', true);

// Unleash the power of Thematic's feed link functions
//
// define('THEMATIC_COMPATIBLE_FEEDLINKS', true);
// Add support for WP3 custom menus
add_theme_support( 'nav-menus' );


// Remove Thematic default menu
function remove_thematic_menu() {
remove_action('thematic_header','thematic_access',9);
}
add_action('init','remove_thematic_menu');

// Register the custom menu with the theme
function register_custom_menu() {
register_nav_menu( 'primary-menu', __( 'Primary Menu' ) );
}
add_action( 'init', 'register_custom_menu' );
// Output the new 3.0 menu to the thematic header
function childtheme_access(){?>
<div id="access">
<div class="skip-link"><a href="#content" title="<?php _e('Skip navigation to the content', 'thematic'); ?>"><?php _e('Skip to content', 'thematic'); ?></a></div>
<?php wp_nav_menu( array('primary-menu', 'container_class' => 'menu', 'menu_class' => 'sf-menu') ); ?>
</div><!-- #access -->
<?php
}
add_action('thematic_header','childtheme_access',9);
?>
<?php
// ---------- "Grey Leaf Options" menu STARTS HERE
 
add_action('admin_menu' , 'childtheme_add_admin');
 
function childtheme_add_admin() {
	add_submenu_page('themes.php', 'Grey Leaf Options', 'Grey Leaf Options', 'edit_themes', basename(__FILE__), 'childtheme_admin');
}
 
function childtheme_admin() {
 
	$child_theme_image = get_option('child_theme_image');
	$enabled = get_option('child_theme_logo_enabled');
 
	if ($_POST['options-submit']){
		$enabled = htmlspecialchars($_POST['enabled']);
		update_option('child_theme_logo_enabled', $enabled);
 
		$file_name = $_FILES['logo_image']['name'];
		$temp_file = $_FILES['logo_image']['tmp_name'];
		$file_type = $_FILES['logo_image']['type'];
 
		if($file_type=="image/gif" || $file_type=="image/jpeg" || $file_type=="image/pjpeg" || $file_type=="image/png"){
			$fd = fopen($temp_file,’rb’);
			$file_content=file_get_contents($temp_file);
			fclose($fd);
 
			$wud = wp_upload_dir();
 
			if (file_exists($wud[path].'/'.strtolower($file_name))){
				unlink ($wud[path].'/'.strtolower($file_name));
			}
 
			$upload = wp_upload_bits( $file_name, '', $file_content);
		//	echo $upload['error'];
 
			$child_theme_image = $wud[url].'/'.strtolower($file_name);
			update_option('child_theme_image', $child_theme_image);
		}
 
		?>
			<div class="updated"><p>Your new options have been successfully saved.</p></div>
		<?php
 
	}
 
	if($enabled) $checked='checked="checked"';
 
	?>
		<div class="wrap">
			<div id="icon-themes" class="icon32"></div>
			<h2>Child Theme Options</h2>
			<form name="theform" method="post" enctype="multipart/form-data" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);?>">
				<table class="form-table">
					<tr>
						<td width="200">Use logo image instead of blog title and description:</td>
						<td><input type="checkbox" name="enabled" value="1" <?php echo $checked; ?>/></td>
					</tr>
					<tr>
						<td>Current image:</td>
						<td><img src="<?php echo $child_theme_image; ?>" /></td>
					</tr>
					<tr>
						<td>Logo image to use (gif/jpeg/png):</td>
						<td><input type="file" name="logo_image"><br />(you must have writing permissions for your uploads directory)</td>
					</tr>
				</table>
				<input type="hidden" name="options-submit" value="1" />
				<p class="submit"><input type="submit" name="submit" value="Save Options" /></p>
			</form>
		</div>
	<?php
}
 
// ---------- "Child Theme Options" menu ENDS HERE
 
// ---------- Adding the logo image to the header STARTS HERE
 
if(get_option('child_theme_logo_enabled')){
	function remove_thematic_blogtitle() {
	 remove_action('thematic_header','thematic_blogtitle',3);
	}
	add_action('init','remove_thematic_blogtitle');
 
	function remove_thematic_blogdescription() {
	 remove_action('thematic_header','thematic_blogdescription',5);
	}
	add_action('init','remove_thematic_blogdescription');
 
	function thematic_logo_image() {
		echo '<div id="logo-image"><a href="'.get_option('home').'"><img src="'.get_option('child_theme_image').'" /></a></div>';
	}
	add_action('thematic_header','thematic_logo_image',4);
}
// ---------- Adding the logo image to the header ENDS HERE
?>