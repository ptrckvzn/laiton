<?php

namespace App;

add_action('after_setup_theme', function () {
    register_nav_menus([
        'primary' => __('Primary Navigation', 'art')
    ]);

    add_theme_support('post-thumbnails', ['project']);
    add_theme_support('html5', ['caption']);
});
