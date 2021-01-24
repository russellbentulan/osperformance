<?php
/**
 * Plugin Name: OS Blocks
 * Description: OS Theme Blocks
 * Version:     0.1.0
 * Author:      Russell Bentulan
 * Author URI:  https://russellbentulan.com
 * License:     MIT License
 * Text Domain: os-blocks
 * Domain Path: /resources/lang
 **/

function os_blocks_init() {
    // Register block JS
    wp_register_script(
        'os-blocks-scripts',
        plugins_url( 'dist/index.min.js', __FILE__ ),
        array(
            'wp-element',
            'wp-blocks',
            'wp-editor',
        ),
        null
    );

    // Register editor-specific CSS
    if ( is_admin() ) :
        wp_register_style(
            'os-blocks-editor-styles',
            plugins_url( 'dist/editor.css', __FILE__ ),
            array(
                'wp-edit-blocks'
            ),
            null
        );
    endif;

    // Register blocks CSS
    wp_register_style(
        'os-blocks-styles',
        plugins_url( 'dist/style.css' ),
        array(),
        null
    );

    wp_enqueue_script( 'os-blocks-scripts' );
    wp_enqueue_style( 'os-blocks-editor-style' );
    wp_enqueue_style( 'os-blocks-styles' );
}

add_action( 'wp_enqueue_scripts', 'os_blocks_init' );
