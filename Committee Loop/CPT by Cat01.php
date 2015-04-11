--Listing WordPress Custom Post Types by Category
--http://mtspacewebdesign.com/blog/listing-wordpress-custom-post-types-by-category/

--If you are looking for a way to list your WordPress custom post types by category, look no --further! I was in the process of a redesign for a travel agent and need to create a custom post --type for “travel Deals”, which then get broken down and listed by country. So, I set up the custom --post type in my functions.php, built into it a taxonomy and was able to call the custom posts in --my template. What I wasn’t able to easily figure out was how to sort the posts by listed categories.

--Luckily, in my searching, I found a tutorial setup by Wes Bos which listed regular WordPress posts --by category. I modified his code a bit and it now sorts custom post types by category as requested --by my client. You can see my code in action here and feel free to use the code below on your --projects!


<?php
            // get all the categories from the database
            $cats = get_categories('taxonomy=types');
 
                // loop through the categries
                foreach ($cats as $cat) {
                    // setup the cateogory ID
                    $cat_id= $cat->term_id;
                    // Make a header for the cateogry
                    echo "<h2>".$cat->name."</h2>";  
                    // create a custom wordpress query
 
                    $args = array(
                        'tax_query' => array(
                        array(
                            'taxonomy' => 'types',
                            'field' => 'slug',
                            'terms' => ".$cat->name."
                            )
                            )
                        );
                    $query = query_posts( $args );
                    // start the wordpress loop!
                    if (have_posts()) : while (have_posts()) : the_post(); ?>
 
                    <?php
                    $custom = get_post_custom($post->ID);
                    $price = $custom["price"][0];
                    $short_text = $custom["short_text"][0];
                    ?>
 
                <div id="gallery" class="one_column">
 
                    <ul class="portfolio">
 
                    <li class="clearfix">
                        <div class="clearfix">
                    <span class="image-border"><a class="image-wrap" href="<?php the_permalink() ?>" title="<?php _e('Permanent Link to', 'theme1512');?> <?php the_title_attribute(); ?>" ><?php the_post_thumbnail( 'portfolio-post-thumbnail-xl' ); ?></a></span>
                            <div class="folio-desc"> 
                        <?php // create our link now that the post is setup ?>
                        <a href="<?php the_permalink();?>"><?php the_title(); ?> | <?php echo $price; ?></a><br />
                        <p><?php echo $short_text; ?></p>
                        <p><a href="<?php the_permalink(); ?>">View Details</a></p>
 
                        </div>
                    </div>
                </li>
                </div>
 
                    <?php endwhile; endif; // done our wordpress loop. Will start again for each category ?>
                    <?php wp_reset_query(); ?>
                <?php } // done the foreach statement ?>