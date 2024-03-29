<?php
/**
 * @file
 * govcms_blog.features.inc
 */

/**
 * Implements hook_ctools_plugin_api().
 */
function govcms_blog_ctools_plugin_api($module = NULL, $api = NULL) {
  if ($module == "strongarm" && $api == "strongarm") {
    return array("version" => "1");
  }
}

/**
 * Implements hook_views_api().
 */
function govcms_blog_views_api($module = NULL, $api = NULL) {
  return array("api" => "3.0");
}

/**
 * Implements hook_image_default_styles().
 */
function govcms_blog_image_default_styles() {
  $styles = array();

  // Exported image style: blog_teaser_thumbnail.
  $styles['blog_teaser_thumbnail'] = array(
    'effects' => array(
      2 => array(
        'name' => 'image_scale_and_crop',
        'data' => array(
          'width' => 64,
          'height' => 64,
        ),
        'weight' => 2,
      ),
    ),
    'label' => 'blog_teaser_thumbnail',
  );

  return $styles;
}

/**
 * Implements hook_node_info().
 */
function govcms_blog_node_info() {
  $items = array(
    'blog_article' => array(
      'name' => t('Blog Article'),
      'base' => 'node_content',
      'description' => t('Use <em>Blog articles</em> to reach your target audience directly. The top <em>Blog articles</em> will be displayed in the "From the blog" section on the Front Page.'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  drupal_alter('node_info', $items);
  return $items;
}
