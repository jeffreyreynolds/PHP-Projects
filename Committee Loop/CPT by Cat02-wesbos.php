--List WordPress Posts by Category
--http://wesbos.com/wordpress-list-posts-by-category/
--Awesome Video at https://youtu.be/tiLKGPhUEpM

--I saw on twitter that John Gardner was looking for a way to loop through his WordPress categories --and then display all posts that belonged to that category below it.  I thought it was a great --question / problem to solve so I did a quick tutorial on how to do so.

--First thing you need to do is setup a new page with a custom page template. It can be as simple as --below but may vary depending on your theme structure. I’m using the default WordPress 2010 theme.
	
<?php
/* template name: Posts by Category! */
get_header(); ?>
        <div id="container">
            <div id="content" role="main">
            </div><!-- #content -->
        </div><!-- #container -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>

--Then We need to get all of our categories into a variable called $cats. Once they are setup, we’ll --just loop through the categories, setup a new WordPress loop for each of them, and echo out the --information needed.

--Here is the final code, I’ve commended each line as needed.
<?php
/* template name: Posts by Category! */
get_header(); ?>
 
        <div id="container">
            <div id="content" role="main">
 
            <?php
            // get all the categories from the database
            $cats = get_categories(); 
 
                // loop through the categries
                foreach ($cats as $cat) {
                    // setup the cateogory ID
                    $cat_id= $cat->term_id;
                    // Make a header for the cateogry
                    echo "<h2>".$cat->name."</h2>";
                    // create a custom wordpress query
                    query_posts("cat=$cat_id&posts_per_page=100");
                    // start the wordpress loop!
                    if (have_posts()) : while (have_posts()) : the_post(); ?>
 
                        <?php // create our link now that the post is setup ?>
                        <a href="<?php the_permalink();?>"><?php the_title(); ?></a>
                        <?php echo '<hr/>'; ?>
 
                    <?php endwhile; endif; // done our wordpress loop. Will start again for each category ?>
                <?php } // done the foreach statement ?>
 
            </div><!-- #content -->
        </div><!-- #container -->
 
<?php get_sidebar(); ?>
<?php get_footer(); ?>