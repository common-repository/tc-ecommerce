<?php 
function tc_app_banner_setting() {
	global $wpdb;
	if ( isset( $_REQUEST[ 'action' ] ) && $_REQUEST[ 'action' ] == 'addedit' ) {
		if(isset($_REQUEST[ 'id' ])){  $banners_id = sanitize_text_field($_REQUEST[ 'id' ]);  }		
		 $date_added = date('Y-m-d');
		  wp_enqueue_media(); ?>

<div class="wrap">
  <style>
		#poststuff .inside {
			margin: 6px 0 0;
		}
		
		#newImageButton { background:#ccc; box-shadow:none; }
			
		.stuffbox label {
			line-height: 20px;
			font-size: 12px;
			text-align: left;
			padding: 0 15px 10px;
			font-weight: 700;
		}
		
		.inside input,
		.inside select {
			width: 50%;
			height: 35px;
			box-shadow: none;
			background: #fff;
		}
		
		#poststuff {
			padding-top: 10px;
			width: 100%;
			padding: 0 10px;
		}
		
		#poststuff .stuffbox>h3,
		#poststuff h2,
		#poststuff h3.hndle {
			font-size: 14px;
			padding: 8px 12px;
			margin: 0;
			line-height: 1.4;
		}
		
		.postbox,
		.stuffbox {
			margin-bottom: 20px;
			padding: 0;
			line-height: 1;
			background: #fff;
			padding: 8px 0 0 0;
		}
		
		#poststuff {
			width: 70%;
			background: #eee;
			padding: 20px;
		}
		
		#poststuff h4 {
			font-size: 18px;
		}
		
		.stuffbox .inside {
		    padding: 0 15px 10px;
		}
		
		.msg {
			color: #ff0000;
			text-align: center;
			font-size: 12px;
			line-height: 20px;
		}
		@media only screen and (max-device-width : 768px) {
			#poststuff {width: 94%; padding: 20px 3%;}
			.inside input, .inside select { width: 100%; }				
		}	
		
		
	</style>
  <?php if ( isset( $_POST[ 'submit' ] ) && $_POST[ 'submit' ] == 'add_banner' ) {
					if ( !check_admin_referer( 'action_settings_add_edit', 'add_edit_nonce' ) ) {wp_die( 'Security check fail' );}
					foreach ( $_POST as $key => $value ) { $$key = sanitize_text_field($value); }	
			  		if(isset($type) && $type == 'category'){
						$banners_url = $categories_id;
					}elseif(isset($type) && $type == 'product'){
						$banners_url = $products_id;
					}else{
						$banners_url = "";
					}
					
					$add_query = "INSERT into `".TCVC_APP_BANNERS_SETTINGS."` SET `banners_title` = '".sanitize_text_field($banners_title)."', `banners_url` = '".sanitize_text_field($banners_url)."', `banners_image` = '".sanitize_text_field($banners_image)."', `expires_date` = '".sanitize_text_field($expires_date)."', `date_added` = '".sanitize_text_field($date_added)."',`banners_order` = '".sanitize_text_field($banners_order)."' , `status` = '".sanitize_text_field($status)."', `type` = '".sanitize_text_field($type)."';";

					if($wpdb->query($add_query)){
						$msg = esc_attr("Banner Added successfully");
					}else{
						$msg = esc_attr("Something Wrong there");
					}
			}elseif( isset( $_POST[ 'submit' ] ) && $_POST[ 'submit' ] == 'edit_banner'){	
			  		foreach ( $_POST as $key => $value ) { $$key = sanitize_text_field($value); }	
			  		if(isset($type) && $type == 'category'){
						$banners_url = $categories_id;
					}elseif(isset($type) && $type == 'product'){
						$banners_url = $products_id;
					}else{
						$banners_url = "";
					}
				 
				 $add_query = "UPDATE `".TCVC_APP_BANNERS_SETTINGS."` SET `banners_title` = '".sanitize_text_field($banners_title)."', `banners_url` = '".sanitize_text_field($banners_url)."', `banners_image` = '".sanitize_text_field($banners_image)."', `expires_date` = '".sanitize_text_field($expires_date)."', `status` = '".sanitize_text_field($status)."',`banners_order` = '".sanitize_text_field($banners_order)."' , `type` = '".sanitize_text_field($type)."' WHERE `banners_id` = '".sanitize_text_field($banners_id)."';";

				 if($wpdb->query($add_query)){
					$msg = esc_attr("Banner Updated successfully");
				 }else{
					$msg = esc_attr("Something Wrong there");
				 }
		 }
		
		if(isset($_REQUEST['action']) &&  $_REQUEST['action'] = 'addedit' && isset($_REQUEST['id']) && $_REQUEST['id'] >= 1){
			
			$get_data_qry 		= "SELECT * FROM `".TCVC_APP_BANNERS_SETTINGS."` where `banners_id`='".$banners_id."'";
			$ban_settings 		= $wpdb->get_results($get_data_qry, 'ARRAY_A');			
			foreach($ban_settings[0] as $ban_data => $value){
				 $$ban_data = sanitize_text_field($value);
			}
		}
			
		?>
  <h1 class="wp-heading-inline">Add New Banner</h1>
  <?php if(isset($msg) && $msg != ""){ ?>
  <div id="message" class="updated notice is-dismissible">
    <p><?php echo esc_attr($msg); ?>. </p>
    <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
  </div>
  <?php } ?>
  <div class="poststuff" id="poststuff">
    <form method="post" action="" id="appsettings" name="appsettings">
      <div class="stuffbox">
        <label for="name" class="col-sm-2 col-md-3 control-label">Title </label>
        <div class="inside">
          <input class="form-control field-validate" id="banners_title" name="banners_title" type="text" value="<?php if(isset($banners_title) && $banners_title != ""){ echo esc_attr($banners_title); } ?>">
          <br />
          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Enter banner title.</span> </div>
      </div>
      <div class="stuffbox">
        <label for="name" class="col-sm-2 col-md-3 control-label">Image</label>
        <div class="inside">
          <input id="newImageButton" type="button" value="Upload Image" />
          <br />
          <input type="text" name="banners_image" id="newImage" value="<?php if(isset($banners_image) && $banners_image != ""){ echo esc_url_raw($banners_image);} ?> " />
          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
          <?php if(isset($banners_image) && $banners_image != ""){ ?>
          <img src="<?php echo esc_url_raw($banners_image); ?>" width="80px" height="50px" />
          <?php }else {echo esc_attr("Upload Banner");} ?>
          </span> <br>
        </div>
        <span></span> </div>
      <div class="stuffbox">
        <label for="name" class="col-sm-2 col-md-3 control-label">Type</label>
        <div class="inside">
          <select class="form-control" name="type" id="bannerType">
            <option>Select Type</option>
            <option <?php if(isset($type) && $type == "category"){ ?> selected <?php } ?> value="category">Choose Sub Category</option>
            <option <?php if(isset($type) && $type == "product"){ ?> selected <?php } ?> value="product">Product</option>
            <option <?php if(isset($type) && $type == "latest"){ ?> selected <?php } ?> value="latest">Latest</option>
            <option <?php if(isset($type) && $type == "on_sale"){ ?> selected <?php } ?> value="on_sale">On Sale</option>
            <option <?php if(isset($type) && $type == "featured"){ ?> selected <?php } ?> value="featured">Featured</option>
          </select>
          <br />
          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">With whome do you want to associate this banner?</span> </div>
      </div>
      <div class="stuffbox categoryContent">
        <label for="name" class="col-sm-2 col-md-3 control-label">Categories</label>
        <div class="inside">
          <select class="form-control" name="categories_id" id="categories_id">
            <?php $args = array('taxonomy' => 'product_cat', 'orderby' => 'name', 'order' => 'ASC', 'show_count' => 0, 'pad_counts' => 0, 'hierarchical' => 1,'title_li' => '', 'hide_empty' => 1, 'parent' => 0);
					  $all_main_categories = get_categories( $args );		
					  foreach ($all_main_categories as $cat) { $category_id = $cat->term_id; ?>
					  <option <?php if(isset($banners_url) && $banners_url == $cat->term_id){ ?> selected <?php } ?> value="<?php echo esc_attr($cat->term_id); ?>"><?php echo esc_attr($cat->cat_name); ?> </option>
                      <?php if($category_id && $category_id >= 1){
						$args2 = array('taxonomy' => 'product_cat','parent' => $category_id,'hierarchical' => 1, 'orderby' => 'name', 'order' => 'ASC','hide_empty' => 1);
						$all_sub_cats   = get_categories( $args2 );
						foreach($all_sub_cats as $sub_cate) { ?>
            			<option <?php if(isset($banners_url) && $banners_url == $sub_cate->term_id){ ?> selected <?php } ?> value="<?php echo esc_attr($sub_cate->term_id); ?>">--<?php echo esc_attr($sub_cate->cat_name); ?> </option>
            <?php }} } ?>
          </select>
          <br />
          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Which category do you want to associate this banner?</span> </div>
      </div>
      <div class="stuffbox productContent" style="display:none;">
        <label for="name" class="col-sm-2 col-md-3 control-label">Products</label>
        <div class="inside">
          <select class="form-control" name="products_id" id="products_id">
            <?php 
			$loop_products = new WP_Query( array( 'post_type' => 'product', 'posts_per_page' => -1 ) );
				while ( $loop_products->have_posts() ) : $loop_products->the_post(); $theid = get_the_ID(); $thetitle = get_the_title();?>
            <option <?php if(isset($banners_url) && $banners_url == $theid){ ?> selected <?php } ?> value="<?php echo esc_attr($theid); ?>"><?php echo esc_attr($thetitle); ?></option>
            <?php endwhile; wp_reset_query(); ?>
          </select>
          <br />
          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">Which products do you want to associate this banner?</span> </div>
      </div>
      <div class="stuffbox">
        <label for="name" class="col-sm-2 col-md-3 control-label">Expiry Date</label>
        <div class="inside">
          <input readonly class="form-control datepicker field-validate" type="text" name="expires_date" value="<?php if(isset($expires_date) && $expires_date != ""){echo esc_attr($expires_date);} ?>">
          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;"><br />
          <?php if(isset($expires_date) && $expires_date != ""){echo esc_attr($expires_date);}else {echo esc_attr("Enter expiry date of this banner.");} ?>
          </span> </div>
      </div>
      <div class="stuffbox">
        <label for="name" class="col-sm-2 col-md-3 control-label">Order</label>
        <div class="inside">
          <input class="form-control field-validate" id="banners_order" name="banners_order" type="tel" value="<?php if(isset($banners_order) && $banners_order != ""){ echo esc_attr($banners_order); } ?>">
          <br />
          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">To show the banner in custom order.</span> </div>
      </div>
      <div class="stuffbox">
        <label for="name" class="col-sm-2 col-md-3 control-label">Status</label>
        <div class="inside">
          <select class="form-control" name="status">
            <option <?php if(isset($status) && $status == 1){ ?> selected <?php } ?> value="1">Active</option>
            <option <?php if(isset($status) && $status == 0){ ?> selected <?php } ?> value="0">In Active</option>
          </select>
          <br />
          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">To show this banner into the app choose Active.</span> </div>
      </div>
      <?php wp_nonce_field('action_settings_add_edit','add_edit_nonce'); ?>
      <div>
        <button type="submit" name="submit" id="btnsave" value="<?php if(isset($banners_id) && $banners_id != "" ){echo esc_attr("edit_banner"); }else{ echo esc_attr("add_banner"); } ?>" class="button-primary">Submit</button>
        &nbsp;&nbsp;
        <button type="button" name="button" onclick="location.href='admin.php?page=banner-settings'" id="btnsave" value="true" class="button-primary">Cancel</button>
      </div>
      <?php 
					if(isset($type) && $type == 'category'){ ?>
      <script type="text/javascript">
							jQuery(document).ready(function($) {
								$('.categoryContent').show();
								$('.productContent').hide();
							});
						</script>
      <?php }elseif(isset($type) && $type == 'product') { ?>
      <script type="text/javascript">
							jQuery(document).ready(function($) {
								$('.categoryContent').hide();
								$('.productContent').show();
							});
						</script>
      <?php }else { ?>
      <script type="text/javascript">
							jQuery(document).ready(function($) {
								$('.categoryContent').hide();
								$('.productContent').hide();
							});
						</script>
      <?php } 
	  
	 	wp_enqueue_script('jquery-ui-datepicker');
		wp_register_style('jquery-ui', TCVC_PLUGIN_URL.'assets/css/jquery-ui.css');
		wp_enqueue_style('jquery-ui');

	  ?>
      <script type="text/javascript">
					jQuery(document).ready(function($) {
							$('.datepicker').datepicker({
								dateFormat: "yy-mm-dd"
							});
						
							jQuery('#newImageButton').click(function() { 
							var send_attachment_bkp = wp.media.editor.send.attachment;
							wp.media.editor.send.attachment = function(props, attachment) {
								jQuery('#newImage').val(attachment.url);
								wp.media.editor.send.attachment = send_attachment_bkp;
							}
							wp.media.editor.open();
							return false;
						});
						
						
						
						$(document).on('change', '#bannerType', function(e){
							var type = $(this).val();

							if(type=='category'){
								$('.categoryContent').show();
								$('.productContent').hide();
							}else if(type=='product'){
								$('.categoryContent').hide();
								$('.productContent').show();
							}else{
								$('.categoryContent').hide();
								$('.productContent').hide();	
							}

						});
					});
				</script>
    </form>
  </div>
</div>
<?php }
	else{ ?>
<style>
		.widefat .check-column {
			padding: 10px 0 0 0;
		}
		
		.widefat .fixed {
			width: 7%;
		}
		
		.widefat .fixed2 {
			width: 20%;
		}
		
		.alignCenter {
			text-align: center;
		}
		
		th.alignCenter {
			text-align: center !important;
		}
		
		.widefat td.check-column {
			padding: 10px 0 0 6px;
		}
		@media only screen and (max-device-width : 768px) {
			.widefat .fixed , .widefat .fixed2 {display:none; text-align:left;}	
			.alignCenter{text-align:left;}
					
		}
		
	</style>
<div class="wrap">
  <?php 	global $wpdb;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete' ){ 
					$retrieved_nonce = sanitize_text_field($_REQUEST['nonce']);
				 if (!wp_verify_nonce($retrieved_nonce, 'delete_image' ) ){ wp_die('Security check fail');  } 
					$banners_id = sanitize_text_field($_REQUEST['id']);
					
					 $delete_query = "DELETE from `".TCVC_APP_BANNERS_SETTINGS."` WHERE `banners_id` = '".$banners_id."'";
					 if($wpdb->query($delete_query)){
						$msg = "Banner Deleted successfully";
					 }
				}
				
				if(isset($_REQUEST['deleteselected']) && $_REQUEST['deleteselected'] == 'Apply'){
					if(!check_admin_referer('action_settings_mass_delete','mass_delete_nonce')){               
						wp_die('Security check fail'); 
					}
					$all_banns  =  sanitize_text_field($_REQUEST['banner_ids']);
					
					foreach($all_banns as $ban_id => $value){						
						 $delete_query = "DELETE from `".TCVC_APP_BANNERS_SETTINGS."` WHERE `banners_id` = '".esc_attr($value)."'";
						 if($wpdb->query($delete_query)){
							$msg = "Selected Banners Deleted successfully";
						 }						
					}
				}
		?>
  <h1 class="wp-heading-inline"> <?php echo get_admin_page_title(); ?> &nbsp; <a class="page-title-action" href="admin.php?page=banner-settings&action=addedit">Add New</a> </h1>
  <?php if(isset($msg) && $msg != ""){ ?>
  <div id="message" class="updated notice is-dismissible">
    <p><?php echo esc_attr($msg); ?>. </p>
    <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
  </div>
  <?php } ?>
  <form method="POST" action="admin.php?page=banner-settings" id="posts-filter">
    <div class="tablenav top">
      <select name="action_upper">
        <option selected="selected" value="-1">Bulk Actions</option>
        <option value="delete">delete</option>
      </select>
      <input type="submit" value="Apply" class="button-secondary action" id="deleteselected" name="deleteselected">
    </div>
    <br class="clear">
    <?php   global $wpdb;
					
		$get_data_qry =  "SELECT * FROM `".TCVC_APP_BANNERS_SETTINGS."` order by `banners_order` asc";
		$rows = $wpdb->get_results($get_data_qry , 'ARRAY_A');
		$rowCount=sizeof($rows);
	?>
    <div id="no-more-tables">
      <table cellspacing="0" id="gridTbl" class="wp-list-table widefat fixed striped">
        <thead>
          <tr>
            <th class="manage-column column-cb check-column" scope="col"><input type="checkbox"></th>
            <th class="manage-column column-primary column-title sortable desc"><span>Title</span></th>
            <th class="manage-column fixed alignCenter" scope="col"><span>Order</span></th>
            <th class="manage-column fixed2 alignCenter" scope="col"><span>Image</span></th>
            <th class="manage-column fixed2 alignCenter" scope="col"><span>Added / Expiry / modify</span></th>
            <th class="manage-column fixed alignCenter" scope="col"><span>Status</span></th>
            <th class="manage-column fixed alignCenter" scope="col"><span>Type</span></th>
            <th class="manage-column fixed alignCenter" scope="col"><span>Edit</span></th>
            <th class="manage-column fixed alignCenter" scope="col"><span>Delete</span></th>
          </tr>
        </thead>
        <tbody id="the-list">
          <?php

		if ( count( $rows ) > 0 ) {
			$rows_per_page = 15;
			$current = ( isset( $_GET[ 'paged' ] ) ) ? ( ( int )$_GET[ 'paged' ] ) : 1;
			$pagination_args = array(
				'base' => @add_query_arg( 'paged', '%#%' ),
				'format' => '',
				'total' => ceil( sizeof( $rows ) / $rows_per_page ),
				'current' => $current,
				'show_all' => false,
				'type' => 'plain',
			);

			$start = ( $current - 1 ) * $rows_per_page;
			$end = $start + $rows_per_page;
			$end = ( sizeof( $rows ) < $end ) ? sizeof( $rows ) : $end;

			$delRecNonce = wp_create_nonce( 'delete_image' );
			for ( $i = $start; $i < $end; ++$i ) {

				$row = $rows[ $i ];
				$banner_id = $row[ 'banners_id' ];
				$edit_link = "admin.php?page=banner-settings&action=addedit&id=" . $banner_id;
				$delete_link = "admin.php?page=banner-settings&action=delete&id=$banner_id&nonce=$delRecNonce";
				?>
          <tr valign="top" id="banner_<?php echo esc_attr($i); ?>" class="iedit author-self level-0 banner-<?php echo esc_attr($i); ?> type-page status-publish hentry">
            <th class="alignCenter check-column" data-title="Select Record"> <input type="checkbox" value="<?php echo esc_attr($row['banners_id']); ?>" name="banner_ids[]">
            </th>
            <td data-title="Title" class="column-primary has-row-actions"><strong> <?php echo esc_attr($row['banners_title']); ?> </strong>
              <div class="row-actions"> <span><a href='<?php echo esc_url($edit_link); ?>' title="edit">Edit |</a></span> <span><a href='<?php echo esc_url($delete_link); ?>' onclick="return confirm('Are you really want to delete?');"  title="delete">Delete</a></span> </div>
              <button class="toggle-row" type="button"> <span class="screen-reader-text">Show more details</span> </button></td>
            <td  class="alignCenter" data-colname="order"><?php echo esc_attr($row['banners_order']); ?></td>
            <td data-title="Image" class="alignCenter" data-colname="Image"><img src="<?php echo esc_url($row['banners_image']); ?>" style="width:80px" height="50px"/></td>
            <td class="" data-title="dates" data-colname="Dates"><strong>Added Date : </strong> <?php echo esc_attr($row['date_added']); ?><br/>
              <strong>Expiry Date : </strong> <?php echo esc_attr($row['expires_date']); ?><br/></td>
            <td class="alignCenter" data-colname="Status"><?php $bstatus = esc_attr($row['status']); if($bstatus == 1){echo esc_attr("Active");}else{echo esc_attr("InActive");} ?></td>
            <td class="alignCenter" data-colname="Type"><?php echo esc_attr($row['type']); ?></td>
            <td class="alignCenter" data-title="Edit Record" data-colname="Edit"><strong><a href='<?php echo esc_url($edit_link); ?>' title="edit">Edit</a></strong></td>
            <td class="alignCenter" data-title="Delete Record" data-colname="Delete"><strong><a href='<?php echo esc_attr($delete_link); ?>' onclick="return confirm('Are you really want to delete?');"  title="delete">Delete</a> </strong></td>
          </tr>
          <?php } } else{ ?>
          <tr valign="top" class="no-items" id="">
            <td colspan="9" data-title="No Record" align="center"><strong>No Banners Found</strong></td>
          </tr>
          <?php } ?>
        </tbody>
        <tfoot>
          <tr>
            <th class="manage-column column-cb check-column" scope="col"><input type="checkbox">
            </th>
            <th class="manage-column column-primary column-title sortable desc"><span>Title</span> </th>
            <th class="manage-column fixed alignCenter" scope="col"><span>Order</span></th>
            <th class="manage-column fixed2 alignCenter" scope="col"><span>Image</span> </th>
            <th class="manage-column fixed2 alignCenter" scope="col"><span>Added / Expiry / modify</span> </th>
            <th class="manage-column fixed alignCenter" scope="col"><span>Status</span> </th>
            <th class="manage-column fixed alignCenter" scope="col"><span>Type</span> </th>
            <th class="manage-column fixed alignCenter" scope="col"><span>Edit</span></th>
            <th class="manage-column fixed alignCenter" scope="col"><span>Delete</span></th>
          </tr>
        </tfoot>
      </table>
    </div>
    <?php
			if ( sizeof( $rows ) > 0 ) { ?>
    <div class='pagination' style='padding-top:10px'> <?php echo paginate_links( $pagination_args ); ?> </div>
    <?php } ?>
    <br/>
    <div class="tablenav actions">
      <select name="action_upper">
        <option selected="selected" value="-1">Bulk Actions</option>
        <option value="delete">delete</option>
      </select>
      <?php wp_nonce_field('action_settings_mass_delete','mass_delete_nonce'); ?>
      <input type="submit" value="Apply" class="button-secondary action" id="deleteselected" name="deleteselected">
    </div>
  </form>
</div>
<?php
}
}
?>
