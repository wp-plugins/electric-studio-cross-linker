<?php
if ( is_admin() ){

/* Call the html code */
add_action('admin_menu', 'ES_tag_highlighter_admin_menu');

function ES_tag_highlighter_admin_menu() {
add_options_page('ES Cross Linker', 'ES Cross Linker', 'administrator',
'tag-highlighter', 'ES_cross_linker_html_page');
}
}

function ES_cross_linker_html_page() {
  global $wpdb;

  //sql string for posts
  $sql = $wpdb->prepare("SELECT ID, post_title FROM $wpdb->posts WHERE post_content not like '' AND post_title NOT LIKE  '' AND post_status='publish' ORDER BY post_title ASC");
  //execute sql command  
  $post_titles = $wpdb->get_results($sql);

  //sql string pages
  $sql = $wpdb->prepare("SELECT ID, post_title FROM $wpdb->posts WHERE post_content not like '' AND post_title NOT LIKE  '' AND post_type like 'page' AND post_status='publish' ORDER BY post_title ASC");
  //execute sql command  
  $page_titles = $wpdb->get_results($sql);
?>
  <div>
  <h2>Electric Studio Tag Highlighter</h2>

  Electric Studio Tag Highlighter is activated. Any usage of a phrase that is a post heading within &lt;p&gt;&lt;/p&gt; tags will be turned into a link to that page.
  </div>
  <br/>
  <SCRIPT LANGUAGE="JavaScript">

    //functions to check/uncheck all the posts
    function checkAll(field)
    {
    for (i = 0; i < field.length; i++)
	    field[i].checked = true ;
    }

    function uncheckAll(field)
    {
    for (i = 0; i < field.length; i++)
	    field[i].checked = false ;
    }

</script>
  <div style="width: 400px; float: left; margin-right: 20px; margin-bottom: 20px; border: 1px solid #B0B0B0; moz-border-radius: 5px; border-radius: 5px; padding: 5px">
    <h3>Tags/Posts to Not Link</h3>
    <form name="manageposts" method="post" action="options.php">
      <?php wp_nonce_field('update-options');
      //initiate array
      $prevChecked = array();
      
      //that that the array is not empty in the databse
      if(get_option('selectpost')!=NULL){

        //pull the stored data from the database into a variable
        $prevChecked = get_option('selectpost');
      }
      ?>

      <input type=button name="CheckAll" value="Check All" onClick="checkAll(document.manageposts.selectpost)">
      <input type=button name="UnCheckAll" value="Uncheck All" onClick="uncheckAll(document.manageposts.selectpost)">
      <div style="height:400px; overflow-y: scroll; width: 400px">

        <?//foreach loop to go through all the posts
          foreach($post_titles as $post_title){
            // make sure that $selected is blank
            $selected = "";
            
            //if statement to check if it was already select
            if(in_array("post".$post_title->ID,$prevChecked)){
              $selected = "checked = \"checked\"";
            }

            //echo out the checkbox with post name
            echo '<input type="checkbox" id="selectpost" name="selectpost[]" value="post'.$post_title->ID.'" '.$selected.'/>'.$post_title->post_title .'<br/>'."\n";       
          }?>
      </div>

      <input type="hidden" name="action" value="update" />
      <input type="hidden" name="page_options" value="selectpost" />

      <p>
        <input type="submit" value="<?php _e('Save Changes') ?>" />
      </p>

      </form>
      
  </div>


<div style="width: 400px; float: left; margin-right: 20px; margin-bottom: 20px; border: 1px solid #B0B0B0; moz-border-radius: 5px; border-radius: 5px; padding: 5px">
  <h3>Pages To contain no highlighting</h3>
    <form name="managepages" method="post" action="options.php">
        <?php wp_nonce_field('update-options');
        //initiate array
        $prevCheckedPages = array();
        
        //that that the array is not empty in the databse
        if(get_option('selectpage')!=NULL){

          //pull the stored data from the database into a variable
          $prevCheckedPages = get_option('selectpage');
        }
        ?>

        <input type=button name="CheckAll" value="Check All" onClick="checkAll(document.managepages.selectpage)">
        <input type=button name="UnCheckAll" value="Uncheck All" onClick="uncheckAll(document.managepages.selectpage)">
        <div style="height:400px; overflow-y: scroll; width: 400px">

          <?//foreach loop to go through all the posts
            foreach($page_titles as $page_title){
              // make sure that $selected is blank
              $selected = "";
              
              //if statement to check if it was already select
              if(in_array("post".$page_title->ID,$prevCheckedPages)){
                $selected = "checked = \"checked\"";
              }

              //echo out the checkbox with post name
              echo '<input type="checkbox" id="selectpage" name="selectpage[]" value="post'.$page_title->ID.'" '.$selected.'/>'.$page_title->post_title .'<br/>'."\n";       
            }?>
        </div>

        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="selectpage" />
        <p>
          <input type="submit" value="<?php _e('Save Changes') ?>" />
        </p>
      </form>
      
  </div>


<div style="clear:both; width: 830px; border: 1px solid #B0B0B0; moz-border-radius: 5px; border-radius: 5px; padding: 5px">
  <form name="miscoptions" method="post" action="options.php">
  <?php wp_nonce_field('update-options');
    $pluralForms = get_option('PluralForms');
    $exactMatchesOnly = get_option('exactMatchesOnly');
    ?>
    <h3>Misc. Options</h3>
      <h4>Highlight Plural Forms</h4>
        <p>
          <?php //check if already selected in the database
            if($pluralForms=="true"){
              $select2="checked=\"checked\"";
            }else{
              $select2="";
            }?>
          <input type="checkbox" id="PluralForms" name="PluralForms" value="true" <?php echo $select2 ?>/>
          This is highlight cases in which the post title reference is followed by an 's'
        </p>        
        <p>
          <input type="hidden" name="action" value="update" />
          <input type="hidden" name="page_options" value="exactMatchesOnly,PluralForms" />
          <input type="submit" value="<?php _e('Save Changes') ?>" />
        </p>
  </form>
</div>
<?php
}
?>
