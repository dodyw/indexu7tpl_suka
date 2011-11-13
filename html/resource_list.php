<?php 
  function html_resource_list($where, $param) {
    global $lep;

    (!$param['nrow']) ? $param['nrow'] = 10 : false;
    ($param['order_by']) ? $param['order_by'] = ' order by '.$param['order_by'] : false;

    $query = "select * from lep_resource where {$where} {$param['order_by']}";

    $rs = $lep->db->PageExecute($query, $param['nrow'], $param['page']);
    $res = $rs->GetRows();
    $num_rows = count($lep->tpl["resources"]);

    // add img alt

    $cf = cf_get_custom_fields('resource');
    $pattern = $lep->config['alt_image_pattern'];

    foreach ($res as $k => $v) {
      foreach($cf as $k2 => $v2) {

        if ($v2['type']=='inputFile') {
          $image_fieldname = $v2['name'];

          $img_alt['title'] = $res[$k]['title'];
          $img_alt['category'] = get_category_name($res[$k]['category_id']);
          $img_alt['filename'] = substr($res[$k][$image_fieldname],0,-4);
          $res[$k][$image_fieldname.'_alt'] = htmlentities(seo_alt_image($pattern, $img_alt));
        }
      }
    }

    $lep->tpl["resources"] = $res;

    if ($param['paging']) {

      $query = "select count(res_id) from lep_resource where {$where}";
      $num_rows = $lep->db->GetOne($query);

      $lep->tpl["num_of_res"] = $num_rows;

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
    }

    return $html;
  } 
?>