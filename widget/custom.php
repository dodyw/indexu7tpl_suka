<?php 
  function w_custom($option) {
    global $lep;

    $param = etc_read_option($option);

    // if custom widget file, load the file
    if ($param['custom_widget_file']) {
      if (file_exists(TPL_PATH . 'widget/' . $param['custom_widget_file'])) {
        include_once TPL_PATH . 'widget/' . $param['custom_widget_file'];
        return $html;
      }
    }

    // if custom widget file, load the file
    if ($param['custom_widget_file']) {
      if (file_exists(TPL_PATH . 'widget/' . $param['custom_widget_file'])) {
        include_once TPL_PATH . 'widget/' . $param['custom_widget_file'];
        return $html;
      }
    }
        
    if (SCRIPT_ID == 'categorypage') {
      $category_range = cat_get_children($param['category_id']);
      $category_range[] = $param['category_id'];

      if (in_array($lep->input['id'],$category_range)) {
        $custom = $param['custom_output'];

        $custom_output = _t($custom);

        ($param['show_title']) ? $html = "<div class=\"block_large_title\">"._t($param['title'])."</div>" : false;

        $html .= $custom_output;

        return $html;
      }
    }
    else {
      $custom = $param['custom_output'];

      $custom_output = _t($custom);

        ($param['show_title']) ? $html = "<div class=\"block_large_title\">"._t($param['title'])."</div>" : false;

      $html .= $custom_output;

      return $html;
    }
  } 
?>