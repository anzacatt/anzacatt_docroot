<?php

$update_free_access = FALSE;
$drupal_hash_salt = 'Xa7NoAY3eJKYbg7YFylPQHE8-1vgaYYz07lOH_1f-dg';
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 200000);
ini_set('session.cookie_lifetime', 2000000);

// Acquia environment specific settings.
if (isset($_ENV['AH_SITE_ENVIRONMENT'])) {
  // Include Acquia specific settings files.
  if (file_exists('/var/www/site-php')) {
    require '/var/www/site-php/anzacatt.' . $_ENV['AH_SITE_ENVIRONMENT'] . '/D7-' . $_ENV['AH_SITE_ENVIRONMENT'] . '-anzacatt-settings.inc';
  }

  switch ($_ENV['AH_SITE_ENVIRONMENT']) {
    case 'dev':
      $conf['googleanalytics_account'] = 'UA-90532529-1';
      $conf['shield_enabled'] = 1;
      $conf['shield_user'] = 'anzacatt';
      $conf['shield_pass'] = 'anzacatt';
      break;

    case 'test':
      $conf['googleanalytics_account'] = 'UA-90532529-1';
      $conf['shield_enabled'] = 1;
      $conf['shield_user'] = 'anzacatt';
      $conf['shield_pass'] = 'anzacatt';
      break;

    case 'prod':
      $conf['googleanalytics_account'] = 'UA-90532529-1';
      $conf['shield_enabled'] = 0;
      $conf['shield_user'] = '';
      $conf['shield_pass'] = '';
      break;
  }
}
else {
  $conf['googleanalytics_account'] = 'UA-';
}

if (isset($_ENV['AH_SITE_GROUP']) && isset($_ENV['AH_SITE_ENVIRONMENT'])) {
  $conf['plupload_temporary_uri'] = "/mnt/gfs/{$_ENV['AH_SITE_GROUP']}.{$_ENV['AH_SITE_ENVIRONMENT']}/tmp";
}

if (isset($conf['memcache_servers'])) {
  $conf['cache_backends'][] = './sites/all/modules/contrib/memcache/memcache.inc';
  $conf['cache_default_class'] = 'MemCacheDrupal';
  $conf['cache_class_cache_form'] = 'DrupalDatabaseCache';
}

// Setting date and timezone preferences.
$conf['site_default_country'] = 'AU';
$conf['date_first_day'] = '1';
$conf['date_default_timezone'] = 'Australia/Melbourne';
$conf['configurable_timezones'] = '0';
$conf['user_default_timezone'] = '0';
$conf['search_cron_limit'] = 0;

ini_set('date.timezone', 'Australia/Melbourne');
date_default_timezone_set('Australia/Melbourne');

// Override for local dev environments.
if (!isset($_ENV['AH_SITE_ENVIRONMENT']) && file_exists(DRUPAL_ROOT . '/' . conf_path() . '/settings.local.php')) {
  include DRUPAL_ROOT . '/' . conf_path() . '/settings.local.php';
}
