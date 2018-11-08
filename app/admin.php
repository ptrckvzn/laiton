<?php

namespace App;

// Cleanup wp-admin for js app
add_action('admin_menu', function () {
  if (WP_ENV !== 'development') {
      remove_menu_page('edit-comments.php');
      remove_submenu_page('themes.php', 'widgets.php');
  }
});
