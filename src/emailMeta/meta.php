<?php

function register_meta_email()
{
    add_meta_box('email', 'Email Info', 'cb_email', 'wpcrm-contact');
}

function cb_email()
{
    include plugin_dir_path(__FILE__) . 'form.php';
}

add_action('add_meta_boxes', 'register_meta_email');
