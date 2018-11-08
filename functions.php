<?php

/**
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$laiton_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('Sage &rsaquo; Error', 'laiton');
    $footer = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};
/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7.1', phpversion(), '>=')) {
    $laiton_error(__('You must be using PHP 7.1 or greater.', 'laiton'), __('Invalid PHP version', 'laiton'));
}
/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')) {
    $laiton_error(__('You must be using WordPress 4.7.0 or greater.', 'laiton'), __('Invalid WordPress version', 'laiton'));
}

/**
 * Ensure dependencies are loaded
 */
if (!class_exists('Roots\\Sage\\Container')) {
    if (!file_exists($composer = __DIR__.'/vendor/autoload.php')) {
        $laiton_error(
            __('You must run <code>composer install</code> from the Sage directory.', 'laiton'),
            __('Autoloader not found.', 'laiton')
        );
    }
    require_once $composer;
}

/**
 * Required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($laiton_error) {
    $file = "./app/{$file}.php";
    if (!locate_template($file, true, true)) {
        $laiton_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'laiton'), $file), 'File not found');
    }
}, ['setup', 'actions', 'filters', 'post-types']);
