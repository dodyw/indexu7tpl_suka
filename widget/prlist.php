<?php 
  function w_prlist($option) {
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
          <?php 
            $i = 9;
            while ($i>=$param['min_pr']) {
              $query = "select count(res_id) as c from lep_resource where status = 1 and ss_googlepr='$i'";
              $total = $lep->db->GetOne($query);
        
              if ($total == '0' && $param['hide_empty']) {
              }
              else {
                ($total < 2) ? $w = _t("website") : $w = _t("websites");
                
                print "<li>";
                print 'PR '.$i.'';
                print '<img style="vertical-align:top;margin: 0 10px;margin-top:5px" src="'.TPL_URL.'/images/pr/'.$i.'.gif" alt="" />';
                print '<span><a href="'.URL.'/prlist.php?pr='.$i.'">'.$total.' site(s)</a></span>';
                print "</li>";                  
              }          
                              
              $i--;
            }                      
          ?>
        </ul>
        </div>
      </div>
    <?php
    
    $html = ob_get_contents();
    ob_end_clean();  
    
    return $html;
  } 
?>
