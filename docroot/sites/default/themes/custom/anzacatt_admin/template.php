<?php

/**
 * @file
 * template.php
 */

define('ANZACATT_MEMBERSONLY_VALUE', 'membersonly');

/**
 * Implements hook_pathauto_pattern_alter().
 */
function anzacatt_admin_pathauto_pattern_alter(&$alias, $context) {
  if (empty($context['data']['node'])) {
    return;
  }

  $node = $context['data']['node'];

  if (empty($node->field_member_only_access)) {
    return;
  }

  try {
    $node_wrapper = entity_metadata_wrapper('node', $node);
  }
  catch (Exception $e) {
    watchdog_exception('ANZACATT', $e);
    return;
  }

  // Check if the membersonly field is set to membersonly and update node
  // path alias accordingly.
  if ($node_wrapper->field_member_only_access->value() == ANZACATT_MEMBERSONLY_VALUE) {
    $alias = ANZACATT_MEMBERSONLY_VALUE . '/[node:title]';
  }
  else {
    $alias = '/[node:title]';
  }
}

/**
 * Implements hook_form_alter().
 */
function anzacatt_admin_form_alter(&$form, &$form_state) {
  if (!empty($form['#node_edit_form'])) {
    $form['#submit'][] = 'anzacatt_admin_node_form_submit';
  }
  if ($form_id === 'member_profile_node_form') {
    // Hide the node title field on the Member Profile add/edit form. It will be
    // auto-populated by concatenating the values of the name_title, first_name
    // and last_name fields.
    $form['title']['#access'] = FALSE;
  }
}

/**
 * Submit handler for node forms.
 */
function anzacatt_admin_node_form_submit($form, &$form_state) {
  if (_anzacatt_admin_check_members_only_path_reset_required($form_state)) {
    $form_state['values']['path']['pathauto'] = 1;
  }
  elseif (_anzacatt_admin_check_public_path_reset_required($form_state)) {
    // The form is public only but the URL alias still starts with
    // membersonly. Update the URL alias to remove it.
    $form_state['values']['path']['pathauto'] = 1;
  }

  if ($form_state['values']['type'] === 'member_profile') {
    $name_title = $form_state['values']['field_name_title']['und']['0']['tid'];
    $first_name = $form_state['values']['field_first_name']['und']['0']['value'];
    $last_name = $form_state['values']['field_last_name']['und']['0']['value'];
    // The node title field for Member Profiles is hidden from the form.
    // Construct it by concatenating the first_name and last_name fields.
    $full_name =  $first_name . " " . $last_name;
    if ($name_title) {
      // Prepend name_title if it was provided (optional field).
      $term = taxonomy_term_load($name_title);
      $name_title = $term->name;
      $full_name = $name_title . " " . $full_name;
    }
    $form_state['values']['title'] = $full_name;
  }
}

/**
 * Checks if URL alias needs to be forcefully set to ensure no public access.
 *
 * @param array $form_state
 *   Node edit form submitted values.
 *
 * @return bool
 *   TRUE if the URL alias has to be reset or FALSE.
 */
function _anzacatt_admin_check_members_only_path_reset_required(array $form_state) {
  return _anzacatt_admin_node_is_members_only((object) $form_state['values']) && substr($form_state['values']['path']['alias'], 0, strlen(ANZACATT_MEMBERSONLY_VALUE)) != ANZACATT_MEMBERSONLY_VALUE;
}

/**
 * Checks if URL alias needs to be forcefully set to ensure public access.
 *
 * @param array $form_state
 *   Node edit form submitted values.
 *
 * @return bool
 *   TRUE if the URL alias has to be reset or FALSE.
 */
function _anzacatt_admin_check_public_path_reset_required(array $form_state) {
  return !_anzacatt_admin_node_is_members_only((object) $form_state['values']) && substr($form_state['values']['path']['alias'], 0, strlen(ANZACATT_MEMBERSONLY_VALUE)) == ANZACATT_MEMBERSONLY_VALUE;
}

/**
 * Checks if a node is considered members only.
 *
 * @param \stdClass $node
 *   Node object.
 *
 * @return bool
 *   TRUE if the node is members only or FALSE.
 */
function _anzacatt_admin_node_is_members_only(stdClass $node) {
  return !empty($node->field_member_only_access) && $node->field_member_only_access[$node->language][0]['value'] == ANZACATT_MEMBERSONLY_VALUE;
}
