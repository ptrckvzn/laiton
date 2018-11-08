<?php

namespace App;

add_action( 'init', function() {
  register_extended_post_type( 'project', [
      'publicly_queryable' => true,
      'rest_base' => 'projects',
      'show_in_rest' => true,
      'hierarchical' => false,
      'rewrite' => ['slug' => 'project'],
      'supports' => ['title', 'thumbnail', 'page-attributes']
  ] );

  register_taxonomy_for_object_type( 'category', 'project' );

  unregister_taxonomy_for_object_type( 'post_tag', 'post' );
  unregister_taxonomy_for_object_type( 'category', 'post' );
});
