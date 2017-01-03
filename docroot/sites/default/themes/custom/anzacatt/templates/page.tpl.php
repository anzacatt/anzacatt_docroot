<?php

/**
 * @file
 * Returns the HTML for a single Drupal page.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728148
 */
?>

<header class="header" id="header" role="banner">
  <div class="header__inner">

    <?php if (!empty($secondary_menu)): ?>
      <nav class="header__secondary-menu" id="secondary-menu" role="navigation">
        <?php print $links__system_secondary_menu; ?>
      </nav>
    <?php endif; ?>

    <?php if ($logo): ?>
        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" class="header__logo" id="logo"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" class="header__logo-image" /></a>
    <?php endif; ?>

  <?php print render($page['header']); ?>
  </div>
</header>

<?php print render($page['navigation']); ?>

<div id="page">

  <?php print $breadcrumb; ?>

  <?php print render($page['highlighted']); ?>

  <div id="main" class="<?php print $main_class; ?>">

    <div id="content" class="column" role="main">

      <a href="#skip-link" id="skip-content" class="element-invisible">Go to top of page</a>

      <a id="main-content"></a>
      <?php print render($title_prefix); ?>
      <?php if ($title): ?>
        <h1 class="page__title title" id="page-title"><?php print $title; ?></h1>
      <?php endif; ?>
      <?php print render($title_suffix); ?>
      <?php print $messages; ?>
      <?php print render($tabs); ?>
      <?php print render($page['help']); ?>
      <?php if ($action_links): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; ?>
      <?php print render($page['content']); ?>
      <?php print $feed_icons; ?>
    </div>

    <?php if ($sidebar_first): ?>
      <aside class="sidebar-first" role="complementary">
        <?php print $sidebar_first; ?>
      </aside>
    <?php endif; ?>

    <?php if ($sidebar_second): ?>
      <aside class="sidebar-second" role="complementary">
        <?php print $sidebar_second; ?>
      </aside>
    <?php endif; ?>

  </div>

  <?php print render($page['bottom']); ?>
</div>
<div class="footer-region-wrapper">
  <?php print render($page['footer']); ?>
</div>
