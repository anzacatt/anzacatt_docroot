<?php
/**
 * @file
 * govcms_slideshow.features.inc
 */

/**
 * Implements hook_ctools_plugin_api().
 */
function govcms_slideshow_ctools_plugin_api($module = NULL, $api = NULL) {
  if ($module == "strongarm" && $api == "strongarm") {
    return array("version" => "1");
  }
}

/**
 * Implements hook_views_api().
 */
function govcms_slideshow_views_api($module = NULL, $api = NULL) {
  return array("api" => "3.0");
}

/**
 * Implements hook_image_default_styles().
 */
function govcms_slideshow_image_default_styles() {
  $styles = array();

  // Exported image style: feature_article.
  $styles['feature_article'] = array(
    'effects' => array(
      7 => array(
        'name' => 'image_scale_and_crop',
        'data' => array(
          'width' => 640,
          'height' => 280,
        ),
        'weight' => 2,
      ),
    ),
    'label' => 'feature_article',
  );

  // Exported image style: slideshow_reorder.
  $styles['slideshow_reorder'] = array(
    'effects' => array(
      2 => array(
        'name' => 'image_scale_and_crop',
        'data' => array(
          'width' => 320,
          'height' => 140,
        ),
        'weight' => 1,
      ),
    ),
    'label' => 'slideshow_reorder',
  );

  return $styles;
}

/**
 * Implements hook_node_info().
 */
function govcms_slideshow_node_info() {
  $items = array(
    'slide' => array(
      'name' => t('Slide'),
      'base' => 'node_content',
      'description' => t('Content to be displayed in the slideshow.'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  drupal_alter('node_info', $items);
  return $items;
}
