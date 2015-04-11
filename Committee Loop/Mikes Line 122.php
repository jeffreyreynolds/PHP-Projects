Pseudocode for SL@SCC site

Select next item in title array
Print that item
Select all items in the category that corresponds to that title
Print all those items 
Repeat

Sample of mike's code that looked pretty good:

// Get Portfolio Galleries
<?php
function get_portfolio() {
		
	$attachments = get_children(array('post_parent' => get_the_ID(), 'order' => 'ASC', 'orderby' => 'menu_order','post_type' => 'attachment'));
			
	if ($attachments) { 	
	
		$portfolio;
		foreach ( $attachments as $attachment_id => $attachment ) { 
		
			$myPermalink = get_permalink($attachment_id); // link to attachment page
			$myImage = wp_get_attachment_image($attachment_id, 'medium'); // image
			$myTitle = apply_filters('the_title', $attachment->post_title); // title
			$myCaption = get_post_field('post_excerpt', $attachment->ID); // caption
			
			$portfolio .= '<section class="portfolio-piece"><a href="'.$myPermalink.'">'.$myImage.'</a><h3><a href="'.$myPermalink.'">'.$myTitle.'&nbsp;&raquo;</a></h3><p>'.$myCaption.' <a href="'.$myPermalink.'">View&nbsp;&raquo;</a></p></section>';			      
	
		} // end foreach 
	} // end if attachments
		
	return $portfolio;
		
} // end function
?>