<?php

function usm_force_enqueue_scripts()
{
    wp_enqueue_style('usm-custom-style', get_template_directory_uri() . '/style.css', array(), time(), 'all');
}
add_action('wp_enqueue_scripts', 'usm_force_enqueue_scripts');

function usm_theme_register_menus()
{
    register_nav_menus(array(
        'header-menu' => __('Main Menu', 'usm-theme'),
        'footer-menu' => __('Footer Menu', 'usm-theme'),
    ));
}
add_action('after_setup_theme', 'usm_theme_register_menus');

add_theme_support('post-thumbnails');
