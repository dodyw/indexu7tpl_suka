<?php 
  function w_tag_cloud($option) {
    global $lep;
    
    $param = etc_read_option($option);
    
    // if custom widget file, load the file
    if ($param['custom_widget_file']) {
      if (file_exists(TPL_PATH . 'widget/' . $param['custom_widget_file'])) {
        include_once TPL_PATH . 'widget/' . $param['custom_widget_file'];
        return $html;
      }
    }
    
    (!$param['nrows']) ? $param['nrows'] = 1000 : false;

    if (SCRIPT_ID == 'categorypage') {
      $where_c[] = "category_id = {$lep->input['id']}";

      $children = cat_get_children($lep->input['id']);

      if (is_array($children)) {
        foreach ($children as $k => $v) {
          $where_c[] = "category_id = $v";
        }
      }

      $where_c_string = implode(' or ', $where_c); 
      $where_c_string = '('.$where_c_string.') and '; 
    }
    
    $query = "select tag, sum(total) as total from lep_tag where $where_c_string total > 0 group by (tag) order by total asc limit {$param['nrows']}";
    $rs = $lep->db->Execute($query);
    $tags = $rs->GetRows();
    
    $total = count($tags);
    $t_min = $tags[0]['total'];
    $t_sma = $tags[$total*0.25]['total'];    
    $t_med = $tags[$total*0.5]['total'];    
    $t_lar = $tags[$total*0.75]['total'];    
    $t_max = $tags[$total-1]['total'];

    $query = "select tag, sum(total) as total from lep_tag where $where_c_string total > 0 group by (tag) order by rand() limit {$param['nrows']}";
    $rs = $lep->db->Execute($query);
    $tags = $rs->GetRows();
    
    if (count($tags)) {
      
      $html = "<div class=\"widget\">";
      
      ($param['show_title']) ? $html .= '<h3>'._t($param['title']).'</h3>' : false;
    
      $html .= "<div><ul id=\"popular_tags\">";
    
      foreach ($tags as $k => $v) {
      
        if ($v['total']==$t_min) $t_class = 'smallest_tag';
        elseif ($v['total']<=$t_sma) $t_class = 'small_tag';
        elseif ($v['total']==$t_med) $t_class = 'medium_tag';
        elseif ($v['total']==$t_max) $t_class = 'large_tag';
        elseif ($v['total']>=$t_lar) $t_class = 'largest_tag';
        
        $colors = "0123456789ABCDE";
        $tag_color = "#";
        for ($ii = 1; $ii <= 6; $ii++) {
          $tag_color .= $colors[rand(0, 14)];
        }              

        if ($lep->config['enable_seo_url_tag']) {
          $query = "select seo_title from lep_tag_seo where tag = '{$v['tag']}'";
          $v['tag_url'] = $lep->db->GetOne($query);
        }
        else {
          $v['tag_url'] = str_replace(' ','+',$v['tag']);
        }

        $html .= "    <li class='{$t_class}'>";
        $html .= "    <a style=\"color:$tag_color;\" href=\"".URL."tag/{$v['tag_url']}\">{$v['tag']}</a><span>{$v['total']}</span>";
        $html .= "    </li>";
      }
      
      $html .= "</ul></div></div>";
    }

    return $html;
  } 
?>