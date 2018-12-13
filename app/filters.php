<?php

namespace App;

/**
 * Cache des morceaux de l'admin wp qui ne sont pas utilisés
 * avec un site détaché
 *
 * source : https://wordpress.stackexchange.com/questions/125800/hide-permalink-and-preview-button-and-link-on-custom-post
 */

/**
 * Cache le permalien sous le titre de l'article
 *
 * @param [type] $return
 * @return void
 */
function wpse_125800_sample_permalink($return)
{
  $return = '';

  return $return;
}
add_filter('get_sample_permalink_html', __NAMESPACE__ . '\\wpse_125800_sample_permalink');


/**
 * Cache le lien 'View' sur les page, post et custom post type
 *
 * @param [type] $actions
 * @param [type] $post
 * @return void
 */
function wpse_125800_row_actions($actions, $post)
{
  unset($actions['inline hide-if-no-js']);
  unset($actions['view']);

  return $actions;
}

$post_types = get_post_types(['public'=>true, '_builtin' => false], 'names');

foreach ($post_types as $post_type) {
  add_filter("{$post_type}_row_actions", __NAMESPACE__ . '\\wpse_125800_row_actions', 10, 2);
}
add_filter('page_row_actions', __NAMESPACE__ . '\\wpse_125800_row_actions', 10, 2);
add_filter('post_row_actions', __NAMESPACE__ . '\\wpse_125800_row_actions', 10, 2);

/**
 * Réduit les options disponibles dans la boite 'publish'
 */
function wpse_125800_custom_publish_box() {
  if (!is_admin()) {
      return;
  }

  $style = '';
  $style .= '<style type="text/css">';
  $style .= '#edit-slug-box, #minor-publishing-actions, #visibility, .num-revisions';
  $style .= '{display: none; }';
  $style .= '</style>';

  echo $style;
}

global $pagenow;

if ('post.php' == $pagenow || 'post-new.php' == $pagenow) {
  add_action('admin_head', __NAMESPACE__ . '\\wpse_125800_custom_publish_box');
}

/**
 * Return `null` if an empty value is returned from ACF.
 *
 * @param mixed $value
 * @param mixed $post_id
 * @param array $field
 *
 * @return mixed
 */
function acf_nullify_empty($value, $post_id, $field) {
    if (empty($value)) {
        return null;
    }
    return $value;
}
add_filter('acf/format_value', 'acf_nullify_empty', 100, 3);

/**
 * Add "Styles" drop-down content or classes
 */
function tuts_mcekit_editor_settings($settings) {
    $style_formats = array(
        array(
            'title' => 'Column',
            'block' => 'div',
            'classes' => 'flex-item',
            'wrapper' => true
        ),
        array(
            'title' => 'Column Container',
            'block' => 'div',
            'classes' => 'flex-container',
            'wrapper' => true
        ),
        array(
            'title' => 'Lien discret',
            'selector' => 'a',
            'classes' => 'link--discreet',
            'wrapper' => false
        ),
    );

    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;
}

add_filter('tiny_mce_before_init', __NAMESPACE__ . '\\tuts_mcekit_editor_settings');

remove_filter( 'the_excerpt', 'wpautop' );
