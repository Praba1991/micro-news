<?php
/*
Plugin Name: Kush Micro News
Description: Spread the news in shortest possible way. Use links to refer subjective data and title to concise it.
Version: 1.0
Author: Kush Sharma
Author URI: http://softnuke.com/
Plugin URI: http://softnuke.com/kush-micro-news
*/

define('KUSH_MICRO_NEWS_DIR', plugin_dir_path(__FILE__));
define('KUSH_MICRO_NEWS_URL', plugin_dir_url(__FILE__));
	

function kush_micronews_load_depen_reg(){
	wp_register_style( 'kush_mn_style', KUSH_MICRO_NEWS_URL.'assets/css/style.css');
	wp_register_style( 'kush_mn_style-admin', KUSH_MICRO_NEWS_URL.'assets/css/style-admin.css');
	wp_register_script( 'kush_mn_script', KUSH_MICRO_NEWS_URL.'assets/js/script.js',array('jquery'));//importing stylesheet and js.
}
add_action('init','kush_micronews_load_depen_reg');

add_action('wp_enqueue_scripts','kush_micronews_load_depen');
add_action('admin_enqueue_scripts','kush_micronews_load_depen');
function kush_micronews_load_depen(){

	if(is_admin())
		{wp_enqueue_style('kush_mn_style-admin');
		wp_enqueue_script('kush_mn_script');
		
		$arr =array('url'=>KUSH_MICRO_NEWS_URL);
		
		wp_localize_script( 'kush_mn_script', 'object', $arr );
		}
	else
		wp_enqueue_style('kush_mn_style');
}

/*function kush_mn_cssjs(){
	if(!is_admin())
	{echo '<link rel="stylesheet" href="'.KUSH_MICRO_NEWS_URL.'assets/css/style.css'.'" media="all" type="text/css"/>';
	}
	else
	{echo '<link rel="stylesheet" href="'.KUSH_MICRO_NEWS_URL.'assets/css/style-admin.css'.'" media="all" type="text/css"/>';
	//echo '<script src="'.KUSH_MICRO_NEWS_URL.'assets/js/script.js'.'"></script>';
	}	
	
}
add_action('wp_head','kush_mn_cssjs');
add_action( 'admin_menu', 'kush_mn_cssjs' );*/


function kush_micronews_load(){
	
    if(is_admin()) //load admin files only in admin
        require_once(KUSH_MICRO_NEWS_DIR.'includes/admin.php');
        
    require_once(KUSH_MICRO_NEWS_DIR.'includes/core.php');
	
}
kush_micronews_load();

register_activation_hook(__FILE__, 'kush_micronews_activation');
register_deactivation_hook(__FILE__, 'msp_micronews_deactivation');
	

function kush_micronews_activation() {
    
	//actions to perform once on plugin activation go here  
	
	
	
function kush_mn_install () {
   global $wpdb;
   $table_name = $wpdb->prefix . "kushmicronews"; 
   
$sql = "CREATE TABLE $table_name (
  id mediumint(9) PRIMARY KEY AUTO_INCREMENT,
  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  name mediumtext NOT NULL,
  text text NOT NULL,
  url tinytext
);";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );

  $welcome_name = "Ms. WordPress";
  $welcome_text = "Congratulations, you just completed the installation! Delete or edit this news.";
  $welcome_link = "http://www.softnuke.com";

  $rows_affected = $wpdb->insert( $table_name, array( 'time' => current_time('mysql'), 'name' => $welcome_name, 'text' => $welcome_text, 'url' => $welcome_link ) );
  
  add_option( "kush_mn_db_version", "1.0" );
  add_option( "kush_mn_num_news","5");
}
kush_mn_install ();

	class KushMNWidget extends WP_Widget {

		function KushMNWidget() {
			// Instantiate the parent object
			parent::__construct( false, 'Kush Micro News','description=Output Micro News Stuff' );
		}

		function widget( $args, $instance ) {
			// Widget output
			echo 'Hell Yeah.!';
		}

		function update( $new_instance, $old_instance ) {
			// Save widget options
		}

		function form( $instance ) {
			// Output admin widget options form
			echo 'All micro news data will be output where this widget resides.';
		}
	}
	register_widget( 'KushMNWidget' );
	
}

function kush_micronews_deactivation() {    
	// actions to perform once on plugin deactivation go here	
		
	delete_option('kush_mn_db_version');
	
	unregister_widget('KushMNWidget');
}





function sanitize($data){
	return htmlentities(strip_tags(mysql_real_escape_string($data)));
}
?>