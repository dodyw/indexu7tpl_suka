<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title><?php print html_head("title"); ?></title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="<?php print html_head("meta_keywords"); ?>" />
  <meta name="description" content="<?php print html_head("meta_description"); ?>" />

  <!-- js -->
  
  <script type="text/javascript" src="<?php print URL; ?>lib/js/jquery.js"></script>

  <?php print html_head("css"); ?>
  <?php print html_head("js"); ?>
  <?php print html_head("custom"); ?>

  <?php include TPL_PATH."indexu.js.php"; ?>

  <!-- Google Webfonts -->
  <link href="http://fonts.googleapis.com/css?family=Rokkitt|Cabin:400,400italic,700,700italic,|Schoolbell" rel="stylesheet" type="text/css" />

  <style type="text/css">
    body, h1, h2, h3, h4, h5, h6, .widget h3, .post .title, .section .post .title, .archive_header, .entry, .entry p, .post-meta, .feedback blockquote p, #post-entries, #breadcrumbs { font-family: 'Cabin', arial, sans-serif; }
    .shortcode-sticky { font-family: 'Schoolbell', arial, sans-serif; }
  </style>  
  
  <!-- css -->

  <link href="<?php print TPL_URL; ?>style.css" rel="stylesheet" type="text/css" />
  <link href="<?php print TPL_URL; ?>css/global.css?ver=3.2.1" rel="stylesheet" type="text/css" />
  <link href="<?php print TPL_URL; ?>css/layout.css?ver=3.2.1" rel="stylesheet" type="text/css" />
  <link href="<?php print TPL_URL; ?>functions/css/shortcodes.css" rel="stylesheet" type="text/css" />

  <!-- enable one of the following css for skin selection -->

  <link href="<?php print TPL_URL; ?>styles/default.css" rel="stylesheet" type="text/css" />

  <link href="<?php print TPL_URL; ?>indexu.css" rel="stylesheet" type="text/css" />
  <link href="<?php print TPL_URL; ?>custom.css" rel="stylesheet" type="text/css" />

  <!-- google one plus -->
  <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>

  <base href="<?php print URL; ?>" />
</head>

<?php if (SCRIPT_ID=='detail') : ?>
  <body onload="initialize()" class="home blog logged-in admin-bar layout-left-content theme-woostore gecko layout-left-content">
<?php else : ?>
  <body class="home blog logged-in admin-bar layout-left-content theme-woostore gecko layout-left-content">
<?php endif; ?>

<?php
  if ($lep->config['facebook_enable']) $fb->loadJsSDK();
?>

<body >

  <header id="header" class="row visible" role="banner">    
    <section class="top wrapper">
      <!-- Customer navigation -->
      <nav role="customer-navigation">        
      </nav>
      <div class="clear"></div>
    </section><!--/.top-wrapper-->  
  
    <div class="wrapper">
      <h1 class="logo eightcol">
        <a href="<?php print URL; ?>" title="<?php print DIR_NAME; ?>">
          <img src="<?php print TPL_URL; ?>images/logo.png" alt="<?php print DIR_NAME; ?>" />
        </a>
      </h1><!--/.logo-->
      
      <form role="search" method="get" id="searchform" class="searchform fourcol last" action="search.php">
        <label class="screen-reader-text" for="s">Search for:</label>
        <input type="text" value="" name="q" id="s"  class="field s" placeholder="Search for listing" />
        <input type="submit" class="submit button last" name="submit" value="Search">
      </form><!--/.searchform-->
        
      <!-- Main navigation -->
      <nav role="navigation" class="main-navigation">
        <ul class="mini-cart">
          <li>
            <a href="<?php print URL; ?>usercp/" title="My Account">Account</a>
          </li>
        </ul>

        <?php print html_content("menu1"); ?>
          
        <div class="clear"><!-- We need this for the drop downs --></div>
      </nav><!--/.navigation-->
    </div><!--/.wrapper-->
      
    <div class="clear"></div>
  </header>
