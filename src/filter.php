<?php
add_filter('manage_edit-wpcrm-notes_columns', 'my_columns');

function my_columns($columns)
{
    $columns = array_merge($columns, array('author' => __('Author')));

    return $columns;
}


add_action('manage_wpcrm-notes_posts_custom_column', 'my_manage_columns', 10, 2);

function my_manage_columns($column, $post_id)
{
    global $post;

    switch ($column) {

        case 'author':

            /* Get the post meta. */
            $duration = get_post_meta($post_id, 'current_user', true);

            printf(__('%s'), $duration);

            break;


        default:
            break;
    }
}

add_action('load-edit.php', 'my_edit_movie_load');

function my_edit_movie_load()
{
    add_filter('request', 'my_filter');
}

function my_filter($vars)
{

    if (isset($vars['post_type']) && 'wpcrm-notes' == $vars['post_type']) {
        // $vars = array_merge(
        //     $vars,
        //     array(
        //         'meta_key' => 'current_user',
        //         'meta_value' => wp_get_current_user()->user_login,
        //         // 'meta_compare' => '='
        //     )
        // );
        if (!isset($_GET['author'])) {
            $Id = wp_get_current_user()->ID;
            echo '<script>';
            echo "window.location.search='?post_type=wpcrm-notes&author=$Id'";
            echo '</script>';
        }
    }

    return $vars;
}
