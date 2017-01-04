<?php
/**
 * @file
 * govcms_ui_kit.features.inc
 */

/**
 * Implements hook_image_default_styles().
 */
function govcms_ui_kit_image_default_styles() {
  $styles = array();

  // Exported image style: govcms_ui_kit_banner.
  $styles['govcms_ui_kit_banner'] = array(
    'label' => 'govCMS UI-KIT - Banner',
    'effects' => array(
      1 => array(
        'name' => 'image_scale_and_crop',
        'data' => array(
          'width' => 1650,
          'height' => 440,
        ),
        'weight' => 1,
      ),
    ),
  );

  return $styles;
}
