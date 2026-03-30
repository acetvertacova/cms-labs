<?php get_header(); ?>

<main class="single-post-wrapper">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1><?php the_title(); ?></h1>

                <div class="post-content">
                    <?php the_content(); ?>
                </div>

                <div class="comments-area-wrapper">
                    <?php comments_template(); ?>
                </div>
            </article>

    <?php endwhile;
    endif; ?>
</main>

<?php get_footer(); ?>