<?php

/**
 * Plugin Name: USM Plugin
 * Description: Plugin Development
 * Version: 1.0
 */

require_once plugin_dir_path(__FILE__) . 'includes/class-usm-notes.php';

function usm_plugin_init()
{
    $usm_daily_tip = new USMNotes();
    $usm_daily_tip->init();
}

add_action('plugins_loaded', 'usm_plugin_init');
