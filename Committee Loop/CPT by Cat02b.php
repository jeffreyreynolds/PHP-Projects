<?php get_header(); ?>

<div id="center">

	<div id="main">

		<!-- START SIDEBAR -->
		<?php get_sidebar( 'primary' ); ?>
		<!-- END SIDEBAR -->

		<!-- START CONTENT -->

			<div id="content">
            <?php
			        <?php global $post; ?>
		<h2><?php echo $post->post_title;?></h2>
		<p><?php echo $post->post_content;?></p>
            // set up desired categories as array
				//**********************************************
				$commcats = array(1 => 'committee-asc', 'committee-cab', 'committee-cw', 'committee-wpt');
				//mike
				$commlist = array(

				'post_type' => 'sccsl-org',
				'category_name' => 'committee-info',
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC'
				);
				//end mike
				//**********************************************
            //$cats = get_categories(); 

                // loop through the categories
                foreach ($commcats as $cat) {
                    // setup the category ID
                    //$cat_id= $cat->term_id;
                    // Make a header for the category
                    echo "<h2>".$cat->name."</h2>";

			//mike				
			$query = new WP_Query( $commlist );?>

	
		<?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
            <div id="post-<?php the_ID(); ?>">
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>     
            </div><!--/post-->
   
            <?php endwhile; 
					else:?>
				Sorry, no posts to be found.
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
			
			//end mike
			
    </div><!--/content-->

<!-- START SIDEBAR -->
<?php get_sidebar( 'secondary' ); ?>
<!-- END SIDEBAR -->

</div><!--#main-->
	
</div><!--#center-->

<?php get_footer(); ?>