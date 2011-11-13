<?php  
  function html_inquiry_list($where, $param) {
    global $lep;
    
    (!$param['nrow']) ? $param['nrow'] = 100 : false;
    ($param['order_by']) ? $param['order_by'] = ' order by '.$param['order_by'] : false;

    $query = "select * from lep_inquiry where {$where}";// {$param['order_by']}";
    
    $rs = $lep->db->PageExecute($query, $param['nrow'], $param['page']);
    $lep->tpl["inquiries"] = $rs->GetRows();

    $query = "select count(inquiry_id) from lep_inquiry where {$where}";
    $num_rows = $lep->db->GetOne($query);

    $lep->tpl["num_of_inquiry"] = $num_rows;
    
    if ($param['paging']) {
      $paging = new vpag;
      $paging->param = $param['paging_param'];   

      $total_page = ceil($num_rows / $param['nrow']);
    }
    
    ob_start();    
    include TPL_PATH.$param['template'];
    $html = ob_get_contents();
    ob_end_clean();

      if ($param['paging']) {
      ($page_nav = $paging->render($param['page'], $total_page)) ? $html .= $page_nav : false;
    }
    
    if ($num_rows>0 || !$param['hide_if_no_listing']) {
      ($param['show_title']) ? $html = "<h3>"._t($param['title'])."</h3>" . $html : false;
      $html = "<div class=\"content_box_full\">$html</div>";
    }

    return $html;
  }
?>