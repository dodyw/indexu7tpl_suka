<?php 
  function html_category_list($param, $parent) {
    global $lep;
    
    $query = "SELECT * FROM lep_category WHERE parent_id = $parent AND status = 1 ORDER BY order_num, title";
    $rs = $lep->db->Execute($query);
    $categories = $rs->GetRows();

    $categories_num = count($categories);
    
    $folder_img = '<img src="'.TPL_URL.'images/folder.gif" />';

    switch($param['columns']) {
      
      case "1":
      
        $html = "<ul>";
        foreach($categories as $k => $v) {

          $html .= "<li class=\"categ_item\">$folder_img <a href=\"".$v['seo_title']."\">{$v['title']}</a> <span>(<span>{$v['num_res']}</span>)</span>";

          if ($param['children']>0) {
            $query = "SELECT * FROM lep_category WHERE parent_id = {$v['category_id']} AND status = 1 ORDER BY order_num, title LIMIT {$param['children']}";
            $rs = $lep->db->Execute($query);
            $children = $rs->GetRows();
          
            $html .= "<ul>";
            
            foreach ($children as $k2 => $v2) {
              $html .= "<li><a href=\"".$v2['seo_title']."\">{$v2['title']}</a></li>";
            }
            
            $html .= "</ul>";
          }

          $html .= "</li>";
        }
        $html .= "</ul>";
        
        break;

      case "2":

        if ($categories_num>0) {
        
          if(is_odd($categories_num)) $categories_num++;
          $categories_split_num = $categories_num/2;
        
          $html = "<table id=\"category\"><tr>";
          $html .= "<td valign=\"top\" style='width:50%;'><ul class='category_list'>";
          
          for($i=0;$i<$categories_split_num;$i++) {
            $html .= "<li class=\"categ_item\">$folder_img <a href=\"".$categories[$i]['seo_title']."\">{$categories[$i]['title']}</a>  <span>(<span>{$categories[$i]['num_res']}</span>)</span>";

            if ($param['children']>0) {
              $query = "SELECT * FROM lep_category WHERE parent_id = {$categories[$i]['category_id']} AND status = 1 ORDER BY order_num, title LIMIT {$param['children']}";
              $rs = $lep->db->Execute($query);
              $children = $rs->GetRows();
          
              if ($children>0) {
                unset($children_arr);

                foreach ($children as $k2 => $v2) {
                  $children_arr[] = "<a href=\"".$v2['seo_title']."\">{$v2['title']}</a>";
                }

                if (is_array($children_arr)) {
                  $children_temp = implode(', ', $children_arr);
                  $html .= "<ul><li>$children_temp</li></ul>";
                }
              }
            }

            $html .= "</li>";
          }

          $html .= "</ul></td>";
          $html .= "<td valign=\"top\" style='width:50%;'><ul class='category_list'>";

          for($i=$categories_split_num;$i<$categories_num;$i++) {
          
            if ($categories[$i]['category_id']) {
              $html .= "<li class=\"categ_item\">$folder_img <a href=\"".$categories[$i]['seo_title']."\">{$categories[$i]['title']}</a>  <span>(<span>{$categories[$i]['num_res']}</span>)</span>";
  
              if ($param['children']>0) {
                $query = "SELECT * FROM lep_category WHERE parent_id = {$categories[$i]['category_id']} AND status = 1 ORDER BY order_num, title LIMIT {$param['children']}";
                $rs = $lep->db->Execute($query);
                $children = $rs->GetRows();
          
                if ($children>0) {
                  unset($children_arr);

                  foreach ($children as $k2 => $v2) {
                    $children_arr[] = "<a href=\"".$v2['seo_title']."\">{$v2['title']}</a>";
                  }

                  if (is_array($children_arr)) {
                    $children_temp = implode(', ', $children_arr);
                    $html .= "<ul><li>$children_temp</li></ul>";
                  }
                }
              }
            }

            $html .= "</li>";
          }
          
          $html .= "</ul></td>";
          $html .= "</tr></table>";
        }
        
        break;
        
      case "3":
      
        if ($categories_num>0) {
      
          $categories_split_num = floor($categories_num / 3);
          
          if ($categories_num % 3 > 0) {
            $col1 = $categories_split_num + 1;
            $col2 = $col1 + $categories_split_num + 1;
            $col3 = $categories_num;
          }
          else {
            $col1 = $categories_split_num;
            $col2 = $col1 + $categories_split_num;
            $col3 = $categories_num;
          }

          $html = "<table id=\"category\"><tr>";
          $html .= "<td valign=\"top\"><ul>";
      
          for($i=0;$i<$col1;$i++) {
            $html .= "<li class=\"categ_item\">$folder_img <a href=\"".$categories[$i]['seo_title']."\">{$categories[$i]['title']}</a>  <span>(<span>{$categories[$i]['num_res']}</span>)</span>";
      
            if ($param['children']>0) {
              $query = "SELECT * FROM lep_category WHERE parent_id = {$categories[$i]['category_id']} AND status = 1 ORDER BY order_num, title LIMIT {$param['children']}";
              $rs = $lep->db->Execute($query);
              $children = $rs->GetRows();
      
              if ($children>0) {
                unset($children_arr);

                foreach ($children as $k2 => $v2) {
                  $children_arr[] = "<a href=\"".$v2['seo_title']."\">{$v2['title']}</a>";
                }

                if (is_array($children_arr)) {
                  $children_temp = implode(', ', $children_arr);
                  $html .= "<ul><li>$children_temp</li></ul>";
                }
              }
            }
      
            $html .= "</li>";
          }
      
          $html .= "</ul></td>";
          $html .= "<td valign=\"top\"><ul>";
      
          for($i=$col1;$i<$col2;$i++) {
      
            if ($categories[$i]['category_id']) {
              $html .= "<li class=\"categ_item\">$folder_img <a href=\"".$categories[$i]['seo_title']."\">{$categories[$i]['title']}</a>  <span>(<span>{$categories[$i]['num_res']}</span>)</span>";
      
              if ($param['children']>0) {
                $query = "SELECT * FROM lep_category WHERE parent_id = {$categories[$i]['category_id']} AND status = 1 ORDER BY order_num, title LIMIT {$param['children']}";
                $rs = $lep->db->Execute($query);
                $children = $rs->GetRows();
      
                if ($children>0) {
                  unset($children_arr);

                  foreach ($children as $k2 => $v2) {
                    $children_arr[] = "<a href=\"".$v2['seo_title']."\">{$v2['title']}</a>";
                  }

                  if (is_array($children_arr)) {
                    $children_temp = implode(', ', $children_arr);
                    $html .= "<ul><li>$children_temp</li></ul>";
                  }
                }
              }
            }
      
            $html .= "</li>";
          }
      
          $html .= "</ul></td>";
          $html .= "<td valign=\"top\"><ul>";
      
          for($i=$col2;$i<$col3;$i++) {
      
            if ($categories[$i]['category_id']) {
              $html .= "<li class=\"categ_item\">$folder_img <a href=\"".$categories[$i]['seo_title']."\">{$categories[$i]['title']}</a>  <span>(<span>{$categories[$i]['num_res']}</span>)</span>";
      
              if ($param['children']>0) {
                $query = "SELECT * FROM lep_category WHERE parent_id = {$categories[$i]['category_id']} AND status = 1 ORDER BY order_num, title LIMIT {$param['children']}";
                $rs = $lep->db->Execute($query);
                $children = $rs->GetRows();
      
                if ($children>0) {
                  unset($children_arr);

                  foreach ($children as $k2 => $v2) {
                    $children_arr[] = "<a href=\"".$v2['seo_title']."\">{$v2['title']}</a>";
                  }

                  if (is_array($children_arr)) {
                    $children_temp = implode(', ', $children_arr);
                    $html .= "<ul><li>$children_temp</li></ul>";
                  }
                }
              }
            }
      
            $html .= "</li>";
          }
      
          $html .= "</ul></td>";            
          $html .= "</tr></table>";
        }
      
        break;
        
      case "4":
      
        if ($categories_num>0) {
      
          $categories_split_num = floor($categories_num / 4);
      
          if ($categories_num % 3 > 0) {
            $col1 = $categories_split_num + 1;
            $col2 = $col1 + $categories_split_num + 1;
            $col3 = $col2 + $categories_split_num + 1;
            $col4 = $categories_num;
          }
      
          $html = "<table style=\"width:100%\"><tr>";
          $html .= "<td valign=\"top\"><ul>";
      
          for($i=0;$i<$col1;$i++) {
            $html .= "<li class=\"categ_item\">$folder_img <a href=\"".$categories[$i]['seo_title']."\">{$categories[$i]['title']}</a>  <span>(<span>{$categories[$i]['num_res']}</span>)</span>";
                  
            if ($param['children']>0) {
              $query = "SELECT * FROM lep_category WHERE parent_id = {$categories[$i]['category_id']} AND status = 1 ORDER BY order_num, title LIMIT {$param['children']}";
              $rs = $lep->db->Execute($query);
              $children = $rs->GetRows();
      
              if ($children>0) {
                $html .= "<ul>";
      
                foreach ($children as $k2 => $v2) {
                  $html .= "<li><a href=\"".$v2['seo_title']."\">{$v2['title']}</a></li>";
                }
      
                $html .= "</ul>";
              }
            }
      
            $html .= "</li>";
          }

          $html .= "</ul></td>";
          $html .= "<td valign=\"top\"><ul>";
          
          for($i=$col1;$i<$col2;$i++) {
          
            if ($categories[$i]['category_id']) {
              $html .= "<li class=\"categ_item\">$folder_img <a href=\"".$categories[$i]['seo_title']."\">{$categories[$i]['title']}</a>  <span>(<span>{$categories[$i]['num_res']}</span>)</span>";
                      
              if ($param['children']>0) {
                $query = "SELECT * FROM lep_category WHERE parent_id = {$categories[$i]['category_id']} AND status = 1 ORDER BY order_num, title LIMIT {$param['children']}";
                $rs = $lep->db->Execute($query);
                $children = $rs->GetRows();
          
                if ($children>0) {
                  $html .= "<ul>";
          
                  foreach ($children as $k2 => $v2) {
                    $html .= "<li><a href=\"".$v2['seo_title']."\">{$v2['title']}</a></li>";
                  }
          
                  $html .= "</ul>";
                }
              }
            }
          
            $html .= "</li>";
          }

          $html .= "</ul></td>";
          $html .= "<td valign=\"top\"><ul>";
        
          for($i=$col2;$i<$col3;$i++) {

            if ($categories[$i]['category_id']) {
              $html .= "<li class=\"categ_item\">$folder_img <a href=\"".$categories[$i]['seo_title']."\">{$categories[$i]['title']}</a>  <span>(<span>{$categories[$i]['num_res']}</span>)</span>";        
              if ($param['children']>0) {
                $query = "SELECT * FROM lep_category WHERE parent_id = {$categories[$i]['category_id']} AND status = 1 ORDER BY order_num, title LIMIT {$param['children']}";
                $rs = $lep->db->Execute($query);
                $children = $rs->GetRows();
        
                if ($children>0) {
                  $html .= "<ul>";
        
                  foreach ($children as $k2 => $v2) {
                    $html .= "<li><a href=\"".$v2['seo_title']."\">{$v2['title']}</a></li>";
                  }
        
                  $html .= "</ul>";
                }
              }
            }
        
            $html .= "</li>";
          }
        
          $html .= "</ul></td>";    
          $html .= "<td valign=\"top\"><ul>";
        
          for($i=$col3;$i<$col4;$i++) {
        
            if ($categories[$i]['category_id']) {
              $html .= "<li class=\"categ_item\">$folder_img <a href=\"".$categories[$i]['seo_title']."\">{$categories[$i]['title']}</a>  <span>(<span>{$categories[$i]['num_res']}</span>)</span>";     
                 
              if ($param['children']>0) {
                $query = "SELECT * FROM lep_category WHERE parent_id = {$categories[$i]['category_id']} AND status = 1 ORDER BY order_num, title LIMIT {$param['children']}";
                $rs = $lep->db->Execute($query);
                $children = $rs->GetRows();
        
                if ($children>0) {
                  $html .= "<ul>";
        
                  foreach ($children as $k2 => $v2) {
                    $html .= "<li><a href=\"".$v2['seo_title']."\">{$v2['title']}</a></li>";
                  }
        
                  $html .= "</ul>";
                }
              }
            }
        
            $html .= "</li>";
          }
        
          $html .= "</ul></td>";        
          $html .= "</tr></table>";
        }
        
        break;

      case "5":
      
        if ($categories_num>0) {
      
          $categories_split_num = floor($categories_num / 5);
      
          if ($categories_num % 3 > 0) {
            $col1 = $categories_split_num + 1;
            $col2 = $col1 + $categories_split_num + 1;
            $col3 = $col2 + $categories_split_num + 1;
            $col4 = $col3 + $categories_split_num + 1;
            $col5 = $categories_num;
          }
      
          $html = "<table><tr>";
          $html .= "<td valign=\"top\"><ul>";
      
          for($i=0;$i<$col1;$i++) {
            $html .= "<li><a href=\"".$categories[$i]['seo_title']."\">{$categories[$i]['title']}</a>  <span>(<span>{$categories[$i]['num_res']}</span>)</span>";
      
            if ($param['children']>0) {
              $query = "SELECT * FROM lep_category WHERE parent_id = {$categories[$i]['category_id']} AND status = 1 ORDER BY order_num, title LIMIT {$param['children']}";
              $rs = $lep->db->Execute($query);
              $children = $rs->GetRows();
      
              if ($children>0) {
                $html .= "<ul>";
      
                foreach ($children as $k2 => $v2) {
                  $html .= "<li><a href=\"".$v2['seo_title']."\">{$v2['title']}</a></li>";
                }
      
                $html .= "</ul>";
              }
            }
      
            $html .= "</li>";
          }
      
          $html .= "</ul></td>";
          $html .= "<td valign=\"top\"><ul>";

          for($i=$col1;$i<$col2;$i++) {
      
            if ($categories[$i]['category_id']) {
              $html .= "<li><a href=\"".$categories[$i]['seo_title']."\">{$categories[$i]['title']}</a>  <span>(<span>{$categories[$i]['num_res']}</span>)</span>";
      
              if ($param['children']>0) {
                $query = "SELECT * FROM lep_category WHERE parent_id = {$categories[$i]['category_id']} AND status = 1 ORDER BY order_num, title LIMIT {$param['children']}";
                $rs = $lep->db->Execute($query);
                $children = $rs->GetRows();
      
                if ($children>0) {
                  $html .= "<ul>";
      
                  foreach ($children as $k2 => $v2) {
                    $html .= "<li><a href=\"".$v2['seo_title']."\">{$v2['title']}</a></li>";
                  }
      
                  $html .= "</ul>";
                }
              }
            }
      
            $html .= "</li>";
          }
      
          $html .= "</ul></td>";
          $html .= "<td valign=\"top\"><ul>";
      
          for($i=$col2;$i<$col3;$i++) {
      
            if ($categories[$i]['category_id']) {
              $html .= "<li><a href=\"".$categories[$i]['seo_title']."\">{$categories[$i]['title']}</a>  <span>(<span>{$categories[$i]['num_res']}</span>)</span>";

              if ($param['children']>0) {
                $query = "SELECT * FROM lep_category WHERE parent_id = {$categories[$i]['category_id']} AND status = 1 ORDER BY order_num, title LIMIT {$param['children']}";
                $rs = $lep->db->Execute($query);
                $children = $rs->GetRows();
      
                if ($children>0) {
                  $html .= "<ul>";
      
                  foreach ($children as $k2 => $v2) {
                    $html .= "<li><a href=\"".$v2['seo_title']."\">{$v2['title']}</a></li>";
                  }
      
                  $html .= "</ul>";
                }
              }
            }
      
            $html .= "</li>";
          }
      
          $html .= "</ul></td>";    
          $html .= "<td valign=\"top\"><ul>";
      
          for($i=$col3;$i<$col4;$i++) {
      
            if ($categories[$i]['category_id']) {
              $html .= "<li><a href=\"".$categories[$i]['seo_title']."\">{$categories[$i]['title']}</a>  <span>(<span>{$categories[$i]['num_res']}</span>)</span>";
      
              if ($param['children']>0) {
                $query = "SELECT * FROM lep_category WHERE parent_id = {$categories[$i]['category_id']} AND status = 1 ORDER BY order_num, title LIMIT {$param['children']}";
                $rs = $lep->db->Execute($query);
                $children = $rs->GetRows();

                if ($children>0) {
                  $html .= "<ul>";
      
                  foreach ($children as $k2 => $v2) {
                    $html .= "<li><a href=\"".$v2['seo_title']."\">{$v2['title']}</a></li>";
                  }
      
                  $html .= "</ul>";
                }
              }
            }
      
            $html .= "</li>";
          }
      
          $html .= "</ul></td>";        
          $html .= "<td valign=\"top\"><ul>";
      
          for($i=$col4;$i<$col5;$i++) {
      
            if ($categories[$i]['category_id']) {
              $html .= "<li><a href=\"".$categories[$i]['seo_title']."\">{$categories[$i]['title']}</a>  <span>(<span>{$categories[$i]['num_res']}</span>)</span>";
      
              if ($param['children']>0) {
                $query = "SELECT * FROM lep_category WHERE parent_id = {$categories[$i]['category_id']} AND status = 1 ORDER BY order_num, title LIMIT {$param['children']}";
                $rs = $lep->db->Execute($query);
                $children = $rs->GetRows();
      
                if ($children>0) {
                  $html .= "<ul>";
      
                  foreach ($children as $k2 => $v2) {
                    $html .= "<li><a href=\"".$v2['seo_title']."\">{$v2['title']}</a></li>";
                  }
      
                  $html .= "</ul>";
                }
              }
            }
      
            $html .= "</li>";
          }
      
          $html .= "</ul></td>";        
          $html .= "</tr></table>";
        }
      
        break;  

    // possible extend here by adding more case
    }

    if ($categories_num>0 || !$param['hide_if_no_listing']) {
      ($param['show_title']) ? $html = "<h3 style=\"margin:0;\">"._t($param['title'])."</h3>" . $html : false;
      $html = str_replace('{CATEGORY_NAME}',get_category_name($parent),$html);
    
      $html = "<div>".$html."</div>";
      $html = "<article class=\"post\">".$html."</article>";
    }
    
    return $html;
  } 
?>