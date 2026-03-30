<aside class="site-sidebar">
    <h2>Navigation</h2>
    <h2>Last posts</h2>
    <ul>
        <?php
        $recent_posts = wp_get_recent_posts(['numberposts' => 5]);
        foreach ($recent_posts as $post) {
            echo '<li><a href="' . get_permalink($post["ID"]) . '">' . $post["post_title"] . '</a></li>';
        }
        ?>
    </ul>
</aside>