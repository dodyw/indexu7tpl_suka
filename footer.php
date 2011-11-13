  <footer id="footer" class="row">
    <div class="wrapper visible">

      <section id="footer-widgets" class="col-4">
        <div class="block footer-widget-1">
          <?php print html_content("footer1"); ?> 
        </div><!-- /.block footer-widget-1 -->

        <div class="block footer-widget-2">
          <?php print html_content("footer2"); ?> 
        </div><!-- /.block footer-widget-2 -->

        <div class="block footer-widget-3">
          <?php print html_content("footer3"); ?> 
        </div><!-- /.block footer-widget-3 -->

        <div class="block footer-widget-4">
          <?php print html_content("footer4"); ?> 
        </div><!-- /.block footer-widget-4 -->                    
                    
        <div class="fix"></div>
      </section><!-- /#footer-widgets -->
      
      <section class="basement col2-set">
        <p class="copyright sixcol">Suka &copy; 2011. All Rights Reserved.</p>
        <p class="promotion sixcol last">Powered by <a href="http://www.nicecoder.com">Indexu <?php print $lep->config['version']; ?></a></p>
      </section><!--/.basement-->
    
    </div><!--/.wrapper-->
  </footer><!--/#footer-->

  <script src="<?php print URL; ?>click.js.php"></script>
</body>
</html>