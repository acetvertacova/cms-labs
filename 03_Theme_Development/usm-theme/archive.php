<?php get_header(); ?>
<h1><?php the_archive_title(); ?></h1>
<?php if (have_posts()) : ?>
    <ul class="archive-posts">
        <?php while (have_posts()) : the_post(); ?>
            <li>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                <p><?php the_excerpt(); ?></p>
            </li>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p>No posts found.</p>
<?php endif; ?>
<?php get_footer(); ?>