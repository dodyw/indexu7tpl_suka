<?php  
  function html_menu($id) {
    global $lep;

    $query = "select html_class, html_id from lep_menu_group where group_id = '$id'";
    $rs = $lep->db->Execute($query);
    $menu_attributes = $rs->FetchRow();

    $query = "select * from lep_menu where group_id = '$id' order by order_num";
    $rs = $lep->db->Execute($query);
    $menu = $rs->GetRows();

    $html = "<ul id=\"main-nav\">";

    foreach ($menu as $k => $v) {
      
      $show = false;
      
      if ($v['user'] && login_check_user()) {
        $show = true;
      }
      
      if ($v['admin'] && login_check_admin()) {
        $show = true;
      }

      if ($v['anonymous'] && !login_check_user() && !login_check_admin()) {
        $show = true;
      }
      
      if ($show) {
        // remove these menu items
        if ($v['title']=='My Account') {
         
        }
        else {
          $html .= "<li class=\"page_item\">";

          $url = chop(menu_get_url($v['type'],$v['value']));

          if ($url=='logout.php') {
            if ($lep->fbcookie!='') {
              $html .= "<a href=\"javascript:\" onclick=\"logoutFacebookUser();\">"._t($v['title'])."</a>";
            }
            else {
              $html .= "<a rel=\"{$v['rel']}\" href=\"".$url."\" title=\""._t($v['title'])."\">"._t($v['title'])."</a>";
            }
          }
          else {
            $html .= "<a rel=\"{$v['rel']}\" href=\"".$url."\" title=\""._t($v['title'])."\">"._t($v['title'])."</a>";
          }

          $html .= "</li>";          
        }
      }
    }

    $html .= "</ul>";
    return $html;
  }
?>