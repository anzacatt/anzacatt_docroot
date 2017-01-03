<?php

/**
 * @file
 * Outputs view fields with no wrapper, allowing for a table style.
 */
?>
<?php print $ds_content; ?>
<?php if (!empty($drupal_render_children)): ?>
  <?php print $drupal_render_children ?>
<?php endif; ?>
