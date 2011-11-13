<?php 
  function w_top_resource($option) {
    global $lep;
    
    $param = etc_read_option($option);

    // if custom widget file, load the file
    if ($param['custom_widget_file']) {
      if (file_exists(TPL_PATH . 'widget/' . $param['custom_widget_file'])) {
        include_once TPL_PATH . 'widget/' . $param['custom_widget_file'];
        return $html;
      }
    }

    (!$param['nrows']) ? $param['nrows'] = 3 : false;
        
    $query = "select * from lep_resource where status = 1 and suspended = 0 and hits <> 0 order by hits desc limit {$param['nrows']}";
    $rs = $lep->db->Execute($query);
    $resources = $rs->GetRows();
    
    if (count($resources)) {
      ob_start();
      ?>

      <div class="widget">
        
        <?php if ($param['show_title']) : ?>
        <h3><?php print _t($param['title']); ?></h3>
        <?php endif; ?>
  
        <div>
          <ul>
            <?php foreach ($resources as $k => $v): ?>
              <li>
              <a href="<?php print seo_detail_url2($v['res_id'], $v['title']); ?>" name="link_<?php print $v['resource_id']; ?>"><?php print $v['title']; ?></a>
              </li>
            <?php endforeach ?>
          </ul>
        </div>
      </div>
      
      <?php
      $html .= ob_get_contents();
      ob_end_clean();
    }

    return $html;
  }
?>