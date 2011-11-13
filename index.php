<?php include TPL_PATH."header.php"; ?>

  <div class="content-wrapper">
    <div class="wrapper main-content row visible">

      <section id="content" class="eightcol" role="content">
        <?php print html_content("main"); ?>
      </section><!--/#content-->

      <aside id="sidebar" class="fourcol last" role="complementary">
        <div class="primary">
          <?php print html_content("sidebar"); ?>
        </div>
      </aside><!--/#sidebar-->

      <div class="clear"></div>
    </div><!--/.wrapper-->
  </div><!--/.content-wrapper-->
			
<?php include TPL_PATH."footer.php"; ?>