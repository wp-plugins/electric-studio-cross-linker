<?php
/*
Plugin Name: Electric Studio Cross Linker
Plugin URI: http://www.electricstudio.co.uk
Description: A plugin to make references to posts in your site's content into cross-links.
Version: 0.9
Author: James Irving-Swift
Author URI: http://www.irving-swift.com
License: GPL2
*/

include 'php/install.php';
include 'php/options.php';

add_action('template_redirect', 'add_my_script');
 
function add_my_script() {
	wp_enqueue_script('highlighter', WP_CONTENT_URL . '/plugins/ES_tag_highlighter/js/highlighter.js', array('jquery'), '1.0', true);
}


/* This calls ES_tag_highlighter() function when wordpress adds scripts.*/
add_action('wp_print_footer_scripts','ES_tag_highlighter');
function ES_tag_highlighter(){

global $wpdb;
global $post;
$excluded_pages = get_option('selectpage');
$pluralForms = get_option('PluralForms');
$exactMatchesOnly = get_option('exactMatchesOnly');

  //sql string
  $sql = "SELECT ID, post_title FROM wp_posts";
  //execute sql command  
  $page_titles = $wpdb->get_results($sql);

  //initiate array for excluded tags
  $excluded_tags = array();
      
  //that that the array is not empty in the databse
  if(get_option('selectpost')!=NULL){

    //pull the stored data from the database into a variable
    $excluded_tags = get_option('selectpost');
  }

  //that that the array is not empty in the databse
  if(get_option('selectpage')!=NULL){
    //check that this page is not an excluded page
    if(!in_array("post".$post->ID,$excluded_pages)){

      //put the PHP array of titles into a javascript array  
      echo '<script type="text/javascript">
              var homeurl = "'.get_home_url()."/".'";
              var titles = new Array();';
      
      //if statement to set pluralFroms into the javascript 
      if($pluralForms=="true"){
        echo 'var pluralForms="s";';
      }else{
        echo 'var pluralForms="";';
      }

	//This is a redundant feature
      //if statement to set the exactMatchesOnly into the javascript
      //if($exactMatchesOnly=="true"){
        //echo 'var exactMatchesOnly=" ";';
      //}else{
      //  echo 'var exactMatchesOnly="";';
      //}
    echo 'var exactMatchesOnly=" ";';
      
      
      $i = 0;
      foreach($page_titles as $page_title){
        if(!in_array("post".$page_title->ID,$excluded_tags)){  
        echo 'titles['.$i.'] = new Array(2);
              titles['.$i.'][0] = "'.$page_title->post_title.'";
              titles['.$i.'][1] = "'.$page_title->ID.'";';
        }
        $i++;
      }
            
    echo '</script>';

    }//end (!in_array("post".$post->ID,$excluded_pages))

  }//end if(get_option('selectpage')!=NULL)

}//end function

?>
