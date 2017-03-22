<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package aberdeen
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
        <?php if (has_post_thumbnail()){ ?>
            <figure clas="featured-image">
                <?php
                $thumb_id = get_post_thumbnail_id();
                $thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true);
                if($thumb_id){
                    if (is_single()) {
                        echo "<img src='" . $thumb_url[0] . "' class='img-responsive' >";
                    }
                    else{
                        echo "<a href='" . esc_url(get_permalink()) . "'><img src='" . $thumb_url[0] . "' class='img-responsive'></a>";
                    }
                }?>
            </figure>
        <?php } ?>

		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php aberdeen_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

    <div class="entry-content">
        <?php
        if (is_single()) {
            the_content(sprintf(
            /* translators: %s: Name of current post. */
                wp_kses(__('Continue reading %s <span class="meta-nav">&rarr;</span>', 'eiene'), array('span' => array('class' => array()))),
                the_title('<span class="screen-reader-text">"', '"</span>', false)
            ));
        } else { ?>
            <div class="entry-content index-excerpt">
                <?php the_excerpt(); ?>
            </div>
            <div class="continue-reading">
                <a href="<?php echo esc_url(get_permalink()); ?>" rel="bookmark" class="link-continue-reading">
                    <?php printf(
                    /* translators: %s: Name of current post. */
                        wp_kses(__('Continue reading %s <span class="fa fa-arrow-right"></span>', 'eiene'), array('span' => array('class' => array()))),
                        the_title('<span class="screen-reader-text">"', '"</span>', false)
                    ); ?>
                </a>
            </div>
        <?php } ?>

        <?php
        bootstrap_wp_link_pages(array(
            'before' => '<ul class="pagination">',
            'after' => '</ul>',
        ));
        ?>
    </div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php aberdeen_entry_footer(); ?>

        <?php aberdeen_author_bio(); ?>

	</footer><!-- .entry-footer -->
</article><!-- #post-## -->