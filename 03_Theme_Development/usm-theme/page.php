<?php
get_header(); ?>

<main class="site-main page-layout">
    <div class="content-wrapper">

        <article <?php post_class('page-card'); ?>>

            <?php if (has_post_thumbnail()) : ?>
                <div class="page-thumbnail">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <h1 class="page-title"><?php the_title(); ?></h1>

            <div class="page-content">
                <?php the_content(); ?>
            </div>

            <?php
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>

        </article>

        <?php get_sidebar(); ?>

    </div>
</main>

<?php get_footer(); ?>