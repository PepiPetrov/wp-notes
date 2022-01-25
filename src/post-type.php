<?php
function register_type()
{
    register_post_type('wpcrm-notes', array(
        'labels' => array(
            'name' => __("Notes", 'dxbase'),
            'singular_name' => __("Note", 'dxbase'),
            'add_new' => _x("Add Note", 'pluginbase', 'dxbase'),
            'add_new_item' => __("Add New Note", 'dxbase'),
            'edit_item' => __("Edit Note", 'dxbase'),
            'new_item' => __("New Note", 'dxbase'),
            'view_item' => __("View Note", 'dxbase'),
            'search_items' => __("Search Notes", 'dxbase'),
            'not_found' =>  __("No Notes found", 'dxbase'),
            'not_found_in_trash' => __("No Notes found in Trash", 'dxbase'),
        ),
        'public' => true,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => true,
        'exclude_from_search' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'supports' => array(
            'title',
            'editor',
            'thumbnail',
            'custom-fields',
        )
    ));

    require_once plugin_dir_path(__FILE__).'/meta/meta.php';
    require_once plugin_dir_path(__FILE__).'/emailMeta/meta.php';
    require_once plugin_dir_path(__FILE__).'filter.php';
}
