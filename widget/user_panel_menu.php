<?php  
  function w_user_panel_menu($option) {
    global $lep;
    
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
      <div class="widget">
        <?php if ($param['show_title']) : ?>
        <h3><?php print _t($param['title']); ?></h3>
        <?php endif; ?>
        
        <div>
          <ul>
            <li><a href="usercp/index.php"><?php print _t('Main'); ?></a></li>
            <li><a href="add.php"><?php print _t('Submit New Listing'); ?></a></li>
            <li><a href="usercp/claim.php"><?php print _t('Claim a Listing'); ?></a></li>
            <li><a href="usercp/myres.php"><?php print _t('My Listing'); ?></a></li>
            <li><a href="usercp/profile.php"><?php print _t('My Profile'); ?></a></li>
            <li><a href="usercp/password.php"><?php print _t('Change Password'); ?></a></li>
          </ul>
        </div>
      </div>
    <?php
    $html = ob_get_contents();
    ob_end_clean();  

    return $html;
  }
?>