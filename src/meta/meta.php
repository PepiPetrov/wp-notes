<?php

function register_meta_data()
{
    add_meta_box('note', 'Note Info', 'cb', 'wpcrm-notes');
}

function cb()
{
    include plugin_dir_path(__FILE__) . 'form.php';
}

add_action('add_meta_boxes', 'register_meta_data');
