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
