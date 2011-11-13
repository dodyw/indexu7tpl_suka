<?php 
  function w_search_box($option) {
    $param = etc_read_option($option);

    // if custom widget file, load the file
    if ($param['custom_widget_file']) {
      if (file_exists(TPL_PATH . 'widget/' . $param['custom_widget_file'])) {
        include_once TPL_PATH . 'widget/' . $param['custom_widget_file'];
        return $html;
      }
    }
        
    ob_start();    
    ?>
      <?php if ($param['show_title']) : ?>
      <table width="197" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td class="head" style="background-image: url(<?php print TPL_URL; ?>images/template_23.gif);">&nbsp;<?php print _t($param['title']); ?></td>
          <td width="31"><img alt="" src="<?php print TPL_URL; ?>images/template_24.gif"></td>
        </tr>
      </table>
      <?php endif; ?>
      
      <table width="197" cellspacing="0" cellpadding="5" border="0" class="panel-bg">
        <tr>
          <td>
            <form method="get" action="search.php">    
              <input type="text" name="q">    
              <input type="submit" value="<?php print _t('Search') ?>">    
            </form>
          </td>
        </tr>
      </table>
    <?php
    $html = ob_get_contents();
    ob_end_clean();  

    return $html;
  }
?>