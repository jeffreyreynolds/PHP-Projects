
<?php // Premium Design Works 
// Link to admin styles
add_editor_style( 'admin.css' );
//
//  Register My Sidebar
register_sidebar(array(
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
));
//
// Register My Menus
function register_my_menus() {
	
  register_nav_menus(array(
      'main-menu' => __( 'Main Menu' ),
      'footer-menu' => __( 'Footer Menu' )
    ));
	
}
add_action( 'init', 'register_my_menus' );
//
// Create Post Thumbnails
add_theme_support( 'post-thumbnails' );
//
// Create Page Excerpts
add_post_type_support( 'page', 'excerpt' );
//
//  Show Gravatars
function show_avatar($comment, $size) {	
			
	$email=strtolower(trim($comment->comment_author_email));
	$rating = "G"; // [G | PG | R | X]
	 
	if (function_exists('get_avatar')) {
		
		echo get_avatar($email, $size);
	
	} else {
  
	  $grav_url = "http://www.gravatar.com/avatar.php?gravatar_id=
		 " . md5($emaill) . "&size=" . $size."&rating=".$rating;
		 
	  echo "<img src='$grav_url'/>";
	  
	}
	
}
//
// Get My Title Tag
function get_my_title_tag() {
	
	global $post;
	
	if ( is_front_page() ) {  // for the site’s Front Page
	
		bloginfo('description'); // retrieve the site tagline
	
	} 
	
	elseif ( is_page() || is_single() ) { // for your site’s Pages or Postings
	
		the_title(); // retrieve the page or posting title 
	
	} 
	
	else { // for everything else
		
		bloginfo('description'); // retrieve the site tagline
		
	}
	
	if ( $post->post_parent ) { // for your site’s Parent Pages
	
		echo ' | '; // separator with spaces
		echo get_the_title($post->post_parent);  // retrieve the parent page title
		
	}
	echo ' | '; // separator with spaces
	bloginfo('name'); // retrieve the site name
	echo ' | '; // separator with spaces
	echo 'Seattle, WA.'; // write in the location
	
}
//
// Get Gateway Page Spotlights
function get_gateway_spotlights() {
	
	global $post;
	
	$words = get_post_meta($post->ID, 'spotlight-page', true);
	$get = explode(',' , $words);
	
	$word01 = $get[0];
	$word02 = $get[1];
	$word03 = $get[2];
	
	if ($words) {
	
		echo '<div id="spotlight-page">';
		echo '<span id="word-one">'.$word01.'. </span>';
		echo '<span id="word-two">'.$word02.'. </span>';
		echo '<span id="word-three">'.$word03.'. </span>';
		echo '</div>';
		
	}
	
}
//
// Get Portfolio Galleries
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
	
add_shortcode( 'portfolio', 'get_portfolio' );
//
// Get SEO Paragraph From Home Page
function get_seo() {
	$myPosting = get_post(8);
	
	$mySEO = $myPosting->post_content;
	
	echo $mySEO;
	
}
//
// Get Featured Case Study 
function get_featured_case_study($atts) {
	
	$myPostID = intval($atts[id]); // sets the id to pass
	
	$myPosting = get_post($myPostID); // gets the post of id passed
	
	$caseTitle = $myPosting->post_title; // get title
	$caseExcerpt = $myPosting->post_excerpt; // get excerpt
	$caseImage = get_the_post_thumbnail($myPostID, 'thumbnail'); // get featured thumbnail
	$caseLink = get_permalink( $myPosting->ID ); // get permalink
	
	$myCaseStudy = '<section class="featured-case"><h3><a href="'.$caseLink.'">Case Study: '.$caseTitle.' &raquo;</a></h3><a href="'.$caseLink.'">'.$caseImage.'</a><p>'.$caseExcerpt.'&nbsp;<a href="'.$caseLink.'">Read More&nbsp;&raquo;</a></p></section>'; // write it up...
	
	return $myCaseStudy; // ... and return it, bitch.
	
}
add_shortcode('casestudy', 'get_featured_case_study');
//
// Get Child Pages 
function get_child_pages() {
	
	global $post;
	
	rewind_posts(); // stop any previous loops 
	query_posts(array('post_type' => 'page', 'posts_per_page' => -1, 'post_status' => publish,'post_parent' => $post->ID,'order' => 'ASC','orderby' => 'menu_order')); // query and order child pages 
    
	while (have_posts()) : the_post(); 
	
		$childPermalink = get_permalink( $post->ID ); // post permalink
		$childID = $post->ID; // post id
		$childTitle = $post->post_title; // post title
		$childExcerpt = $post->post_excerpt; // post excerpt
        
		echo '<article id="page-excerpt-'.$childID.'" class="page-excerpt">';
		echo '<h3><a href="'.$childPermalink.'">'.$childTitle.' &raquo;</a></h3>';
		echo '<p>'.$childExcerpt.' <a href="'.$childPermalink.'">Read More&nbsp;&raquo;</a></p>';
		echo '</article>';
        
	endwhile;
	
	// reset query
	wp_reset_query();
        
}
//
	
// Add a Flexslider Gallery	
function add_flexslider() {
	$attachments = get_children(array('post_parent' => get_the_ID(), 'order' => 'ASC', 'orderby' => 'menu_order',  'post_type' => 'attachment', 'post_mime_type' => 'image','caption' => $attachment->post_excerpt, ));
	if ($attachments) { // see if there are images attached to posting
	
		echo '<div id="spotlight-home" class="flexslider">';
		echo '<ul class="slides">';
		
		foreach ( $attachments as $attachment_id => $attachment ) { // create the list items for images with captions
		
			echo '<li>';
			echo wp_get_attachment_image($attachment_id, 'full'); // get image size large
			echo '<span class="description">';
			echo get_post_field('post_content', $attachment->ID); // get image description field
			echo '</span>';
			echo '</li>';
		
		}
	
		echo '</ul>';
		echo '</div>';
	
	} // end see if images attachmed
} 
// 
// Get Featured Image with a Custom Link
function get_featured_image_with_link() {
	
	global $post;
	
	$theImage = get_the_post_thumbnail($page->ID, 'large');
	$theLink = get_post_meta($post->ID, 'featured-image-link', true);
		
	echo '<figure class="featured-image">';
	
	if ($theLink) { 
	
		echo '<a href="'.$theLink.'" target="_blank" title="View: '.$theLink.'">'.$theImage.'</a>';
		
	} else {
		
		echo $theImage;
		
	}
		
	echo '</figure>';
	
}
//
// Get My Social Icons
function get_my_social_icons() {
		
	$myDirectory = 'http://www.premiumdw.com/wp-content/themes/premium-design-works';
			
	echo '<span class="social-icons">';
	echo '<a title="Mike Sinkula&rsquo;s Twitter Feed" href="http://twitter.com/#!/mikesinkula" target="_blank"><img title="Mike Sinkula&rsquo;s Twitter Feed" src="'.$myDirectory.'/images/ico-twitter.png" alt="Mike Sinkula&rsquo;s Twitter Feed"></a>';
	echo '<a title="Mike Sinkula&rsquo;s FaceBook Page" href="http://www.facebook.com/msinkula?ref=profile" target="_blank"><img title="Mike Sinkula&rsquo;s FaceBook Page" src="'.$myDirectory.'/images/ico-facebook.png" alt="Mike Sinkula&rsquo;s FaceBook Page"  /></a>';
	echo '<a title="Mike Sinkula&rsquo;s LinkedIn Profile" href="http://www.linkedin.com/ppl/webprofile?action=vmi&amp;id=5408871&amp;pvs=pp&amp;authToken=C0zy&amp;authType=name&amp;trk=ppro_viewmore&amp;lnk=vw_pprofile" target="_blank"><img title="Mike Sinkula&rsquo;s LinkedIn Profile" src="'.$myDirectory.'/images/ico-linkedin.png" alt="Mike Sinkula&rsquo;s LinkedIn Profile"  /></a>';
	echo '<a title="Mike Sinkula&rsquo;s YouTube Channel" href="http://www.youtube.com/mikesinkula" target="_blank"><img title="Mike Sinkula&rsquo;s YouTube Channel" src="'.$myDirectory.'/images/ico-youtube.png" alt="Mike Sinkula&rsquo;s YouTube Channel"  /></a>';
	echo '<a title="Mike Sinkula&rsquo;s Flickr Photo Stream" href="http://www.flickr.com/photos/51088942@N05/" target="_blank"><img title="Mike Sinkula&rsquo;s Flickr Photo Stream" src="'.$myDirectory.'/images/ico-flickr.png" alt="Mike Sinkula&rsquo;s Flickr Photo Stream"  /></a>';
	echo '</span>';
	
}
//
// Remove Inline Styles from Captions
add_shortcode('wp_caption', 'fixed_img_caption_shortcode');
add_shortcode('caption', 'fixed_img_caption_shortcode');
function fixed_img_caption_shortcode($attr, $content = null) {
	
	if ( ! isset( $attr['caption'] ) ) {
		if ( preg_match( '#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches ) ) {
			$content = $matches[1];
			$attr['caption'] = trim( $matches[2] );
		}
	}
	$output = apply_filters('img_caption_shortcode', '', $attr, $content);
	if ( $output != '' )
		return $output;
	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr));
	if ( 1 > (int) $width || empty($caption) )
		return $content;
	if ( $id ) $id = 'id="' . esc_attr($id) . '" ';
	return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" >'
	. do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}
//
?>

    © 2015 GitHub, Inc. Terms Privacy Security Contact 

