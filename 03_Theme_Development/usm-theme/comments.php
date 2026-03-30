<?php
if (post_password_required()) {
    return;
}
?>

<div class="comments-area">

    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comments_count = get_comments_number();
            echo $comments_count . ' comments';
            ?>
        </h2>

        <ul class="comment-list">
            <?php
            wp_list_comments([
                'style' => 'ul',
                'short_ping' => true,
                'avatar_size' => 50,
            ]);
            ?>
        </ul>

        <?php the_comments_navigation(); ?>

    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number()) : ?>
        <p class="no-comments">Comments are closed.</p>
    <?php endif; ?>

    <?php comment_form(); ?>

</div>