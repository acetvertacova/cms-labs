<?php

class USMNotes
{
    /**
     * Plugin initialization: register hooks and shortcodes.
     */
    public function init()
    {
        add_action('init', [$this, 'usm_register_note_post_type']);
        add_action('init', [$this, 'usm_register_priority_tag_taxonomy']);
        add_action('add_meta_boxes', [$this, 'usm_add_note_meta_box']);
        add_action('save_post', [$this, 'usm_save_note_meta'], 10, 2);
        add_filter('the_content', [$this, 'usm_display_note_due_date']);
        add_shortcode('usm_notes', [$this, 'usm_notes_shortcode']);
    }

    /**
     * Register the custom post type "Note"
     */
    function usm_register_note_post_type()
    {
        $labels = array(
            'name'               => 'Notes',
            'singular_name'      => 'Note',
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'has_archive'        => true,
            'menu_icon'          => 'dashicons-edit',
            'supports'           => array('title', 'editor', 'author', 'thumbnail'),
        );

        register_post_type('note', $args);
    }

    /**
     * Register the custom taxonomy "Priority Tag"
     */
    function usm_register_priority_tag_taxonomy()
    {
        $labels = array(
            'name'              => 'Priority Tags',
            'singular_name'     => 'Priority Tag',
        );

        $args = array(
            'labels'            => $labels,
            'show_admin_column' => true,
            'rewrite'           => array('slug' => 'priority-tag'),
            'hierarchical'      => true,
        );

        register_taxonomy('priority_tag', 'note', $args);
    }

    /**
     * Add a meta box for the custom field "Due Date"
     */
    function usm_add_note_meta_box()
    {
        add_meta_box(
            'usm_note_due_date',
            __('Due Date', 'usm-plugin'),
            [$this, 'usm_render_note_due_date_meta_box'],
            'note',
            'side',
            'default'
        );
    }

    /**
     * Render the "Due Date" meta box
     * 
     * @param WP_Post $post Current post
     */
    function usm_render_note_due_date_meta_box($post)
    {
        $due_date = get_post_meta($post->ID, 'note_due_date', true);

        wp_nonce_field('usm_save_note_meta', 'usm_note_meta_nonce');

        echo '<label for="note_due_date">Due Date:</label>';
        echo '<input type="date" id="note_due_date" name="note_due_date" value="' . esc_attr($due_date) . '" />';
    }

    /**
     * Save the value of the "Due Date" meta field
     */
    function usm_save_note_meta($post_id, $post)
    {
        if (!isset($_POST['usm_note_meta_nonce']) || !wp_verify_nonce($_POST['usm_note_meta_nonce'], 'usm_save_note_meta')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if ($post->post_type != 'note') {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (isset($_POST['note_due_date']) && !empty($_POST['note_due_date'])) {
            $due_date = sanitize_text_field($_POST['note_due_date']);
            update_post_meta($post_id, 'note_due_date', $due_date);
        } else {
            delete_post_meta($post_id, 'note_due_date');
        }

        $due_date = sanitize_text_field($_POST['note_due_date']);
        $today = date('Y-m-d');

        if ($due_date < $today) {
            set_transient('usm_note_error_' . $post_id, 'Error: Due Date cannot be in the past.');
            return;
        }
    }

    /**
     * Display the due date in the content of a "Note" post
     */
    function usm_display_note_due_date($content)
    {
        if (is_singular('note')) {
            $due_date = get_post_meta(get_the_ID(), 'note_due_date', true);
            if ($due_date) {
                $content .= '<p><strong>Due Date:</strong> ' . esc_html($due_date) . '</p>';
            }
        }
        return $content;
    }

    /**
     * Shortcode to display notes with optional filtering by priority and due date
     */
    public function usm_notes_shortcode($atts)
    {
        $atts = shortcode_atts(array(
            'priority'    => '',
            'before_date' => '',
        ), $atts);

        // Base query arguments
        $args = array(
            'post_type'      => 'note',
            'post_status'    => 'publish',
            'tax_query'      => array(),
            'meta_query'     => array(),
        );

        if (!empty($atts['priority'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'priority_tag',
                'field'    => 'slug',
                'terms'    => $atts['priority'],
            );
        }

        if (!empty($atts['before_date'])) {
            $args['meta_query'][] = array(
                'key'     => 'note_due_date',
                'value'   => $atts['before_date'],
                'compare' => '<=',
                'type'    => 'DATE',
            );
        }

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                $due_date   = get_post_meta(get_the_ID(), 'note_due_date', true);
                $priorities = get_the_terms(get_the_ID(), 'priority_tag');

                echo '<h2>' . get_the_title() . '</h2>';

                if ($priorities && !is_wp_error($priorities)) {
                    echo '<p>Priority: ' . esc_html($priorities[0]->name) . '</p>';
                }

                if ($due_date) {
                    echo '<p><strong>Due Date:</strong> ' . esc_html($due_date) . '</p>';
                }

                the_content();
            }
        } else {
            echo 'No notes found.';
        }
    }
}
