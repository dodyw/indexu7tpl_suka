<?php
function w_login_box($option) {
  global $lep;

  $param = etc_read_option($option);

  // if custom widget file, load the file
  if ($param['custom_widget_file']) {
    if (file_exists(TPL_PATH . 'widget/' . $param['custom_widget_file'])) {
      include_once TPL_PATH . 'widget/' . $param['custom_widget_file'];
      return $html;
    }
  }
    
  if (login_check_user()) {
    ob_start();    
    ?>
    
      <div class="widget widget_shopping_cart">
        
        <?php if ($param['show_title']) : ?>
        <h3><?php print _t($param['title']); ?></h3>
        <?php endif; ?>
        
        <div>
          <ul style="margin-top:20px;margin-bottom:0px;margin-left:22px">
            <li>
              <?php $username = $_COOKIE['USERNAME'] ?>
              <em><?php printf(_t("You are now logged in as %s"),$username) ?></em>            
            </li>
            <li>
              <?php 
                if ($lep->fbcookie!='') {
                  print "<a href=\"javascript:\" onclick=\"logoutFacebookUser();\">"._t('Logout')."</a>";
                }
                else {
                  print "<a href=\"logout.php\">"._t('Logout')."</a>";
                }     
              ?>            
            </li>
          </ul>
        </div>
      </div>
      
  <?php
    $html = ob_get_contents();
    ob_end_clean();  
  }
  else {  
    ob_start();    
    ?>
      
      <div class="widget">
        
        <?php if ($param['show_title']) : ?>
        <h3><?php print _t($param['title']); ?></h3>
        <?php endif; ?>
        
        <div>
          <form style="margin-bottom:0" method="post" action="<?php print URL; ?>login.php">    
          <input type="hidden" value="login" name="act"> 
        
          <table style="margin-bottom:0;width:100%;background:none;">
            <tbody>
            <tr>
              <td><?php print _t('Username') ?></td>
              <td><input type="text" class="inputText" style="width:150px" name="username"></td>
            </tr>
            <tr>
              <td><?php print _t('Password') ?></td>
              <td><input type="password" class="inputText" style="width:150px" name="password"></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input type="submit" value="<?php print _t('Login') ?>" class="submit button"></td>
            </tr>
            </tbody>            
          </table>           
          </form>
          <?php if ($lep->config['facebook_enable']) : ?>
            <p><?php print $lep->fblogin; ?></p>            
          <?php endif; ?>
        </div>
      </div>
      
      
    <?php
    $html = ob_get_contents();
    ob_end_clean();    
  }        
  
  return $html;
}
?>
