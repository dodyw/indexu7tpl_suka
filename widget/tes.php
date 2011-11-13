<?php 
  $query = 'select * from lep_category where status = 1 and parent_id = 0 order by order_num, title';
  $rs = $lep->db->Execute($query);
  $categories = $rs->GetRows();
  
  ob_start();    
  ?>    
    <div class="widget">
      <?php if ($param['show_title']) : ?>
      <h3><?php print _t($param['title']); ?></h3>
      <?php endif; ?>
      <div>
        <ul>
          <?php 
            foreach ($categories as $k => $v) {
              print '<li>x. <a href="'.cat_get_seo_title($v['category_id']).'">'.get_category_name($v['category_id']).'</a></li>';
            }
          ?>
        </ul>
      </div>
    </div>  
    
  <?php
  $html = ob_get_contents();
  ob_end_clean();  
?>