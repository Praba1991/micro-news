<?php

require_once( ABSPATH . 'wp-load.php' );
global $wpdb;
	$table_name = $wpdb->prefix . "kushmicronews"; 

if(isset($_POST['nTitle']) & empty($_POST['nTitle'])===false)
		{
		$title=$_POST['nTitle'];
		$id=$_POST['nId'];
		$content=$_POST['nContent'];
		$link=$_POST['nLink'];
		
		$query="UPDATE `$table_name` SET `name`='$title' ,`text`='$content' ,`link`='$link' WHERE `id`='$id';";
		
			$chk=$wpdb->query($query);
			
			if($chk)
				echo "Changes saved.";
			else
				echo "Changes not saved.";
		
		}
		
		
?>
