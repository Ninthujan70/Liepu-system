<?php get_header(); ?>
<div class="wp-site-blocks">
    <main class="is-layout-flow wp-block-group" style="margin-top: var(--wp--preset--spacing--50)" id="wp--skip-link--target">
        
        <div class="has-global-padding is-layout-constrained wp-block-group">
            
            <h1>
                <?php echo get_the_title(); ?>
            </h1>
        </div>
        <div class="has-global-padding is-layout-constrained entry-content wp-block-post-content">
            <?php the_content(); ?>
        </div>
    </main>
</div>
<?php get_footer(); ?>
