<?php 
  function w_dir_stat($option) {
    global $lep;
    
    $param = etc_read_option($option);

    // if custom widget file, load the file
    if ($param['custom_widget_file']) {
      if (file_exists(TPL_PATH . 'widget/' . $param['custom_widget_file'])) {
        include_once TPL_PATH . 'widget/' . $param['custom_widget_file'];
        return $html;
      }
    }
    
    $query = "select count(res_id) as count from lep_resource where status = 1 and suspended = 0";
    $active_links = $lep->db->GetOne($query);

    $query = "select count(res_id) as count from lep_resource where status = 0";
    $pending_links = $lep->db->GetOne($query);

    $last_24h = strtotime("-1 day");
    $query = "select count(res_id) as count from lep_resource where created_at > '{$last_24h}'";
    $last_24h_links = $lep->db->GetOne($query); 

    $query = "select count(category_id) as count from lep_category where status = 1";
    $categories = $lep->db->GetOne($query);
    
    ob_start();    
    ?>
      <div class="widget">
        <?php if ($param['show_title']) : ?>
        <h3><?php print _t($param['title']); ?></h3>
        <?php endif; ?>
        <div>
          <ul>
            <li><?php print _t('Links') ?>: <?php print $active_links; ?></li>
            <li><?php print _t('Pending') ?>: <?php print $pending_links; ?></li>
            <li><?php print _t('New submission in 24h') ?>: <?php print $last_24h_links; ?></li>
            <li><?php print _t('Categories') ?>: <?php print $categories; ?></li>
          </ul>
        </div>
      </div>
    <?php
    $html = ob_get_contents();
    ob_end_clean();  

    return $html;
  } 
?>
