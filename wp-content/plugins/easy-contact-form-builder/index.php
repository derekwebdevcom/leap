<?php

/**
Plugin Name: GrandWP Form Builder
Plugin URI: https://grandwp.com/wordpress-contact-form-builder
Description: Easy to use Form Plugin for creating simple to custom complex forms.
Version: 1.0.9
Author: GrandWP
Author URI: https://grandwp.com/
License: GNU/GPLv3 https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: gdfrm
Domain Path: /languages
 */

if(!defined('ABSPATH')){
    exit();
}

function gutenberg_gd_forms_builder()
{

    wp_register_script(
        'gd-forms-builder-gutenberg',
        plugins_url('assets/js/admin/block.js', __FILE__),
        array('wp-blocks', 'wp-element', 'wp-components')
    );
    wp_register_style(
        'gd-forms-builder-gutenberg',
        plugins_url('assets/css/admin/block.css', __FILE__),
        array('wp-edit-blocks'),
        filemtime(plugin_dir_path(__FILE__) . 'assets/css/admin/block.css')
    );

    global $wpdb;

    $gdforms = $wpdb->get_results("SELECT id,Name FROM " . $wpdb->prefix . "gdformforms");

    $options = array(
        array(
            'value' => '',
            'label' => 'Select Forms'
        )
    );

    foreach ($gdforms as $gdform) {
        $options[] = array(
            'value' => $gdform->id,
            'label' => $gdform->Name,
        );
    }

    wp_localize_script('gd-forms-builder-gutenberg', 'gdformsbuilderblock', array(
        'gdforms' => $options
    ));
    if (function_exists('register_block_type')) {
        register_block_type('easy-contact-form-builder/index', array(
            'editor_script' => 'gd-forms-builder-gutenberg',
            'editor_style' => 'gd-forms-builder-gutenberg',
        ));
    }
}
add_action( 'init', 'gutenberg_gd_forms_builder' );

function gd_forms_builder_gutenberg_category( $categories, $post ) {
    if ( $post->post_type !== 'post' ) {
        return $categories;
    }
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'easy-contact-form-builder',
                'title' => __( 'GrandWP Forms', 'gdfrm' ),
                'icon'  => 'feedback',
            ),
        )
    );
}
add_filter( 'block_categories', 'gd_forms_builder_gutenberg_category', 10, 2 );

require 'autoload.php';

require 'GDForm.php';


/**
 * Main instance of GDForm.
 *
 * Returns the main instance of GDForm to prevent the need to use globals.
 *
 * @return \GDForm\GDForm
 */

function GDForm()
{
    return \GDForm\GDForm::instance();
}

$GLOBALS['GDForm'] = GDForm();