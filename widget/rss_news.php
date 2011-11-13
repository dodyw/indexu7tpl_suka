<?php
  function w_rss_news($option) {
    global $lep;

    $param = etc_read_option($option);

    // if custom widget file, load the file
    if ($param['custom_widget_file']) {
      if (file_exists(TPL_PATH . 'widget/' . $param['custom_widget_file'])) {
        include_once TPL_PATH . 'widget/' . $param['custom_widget_file'];
        return $html;
      }
    }

    (!$param['nrows']) ? $param['nrows'] = 5 : false;

    define(MAGPIE_CACHE_DIR,PATH.'cache');
    require_once(PATH.'lib/magpierss/rss_fetch.inc');
    $rss = fetch_rss($param['rss_url']);

    ob_start();    
    ?>
    
      <div class="widget">
        <?php if ($param['show_title']) : ?>
        <h3><?php print _t($param['title']); ?></h3>
        <?php endif; ?>
        
        <div>
        <ul>
          <?php 
            $i=0;
            foreach ($rss->items as $item) {
              if ($i<$param['nrows']) {
                $href = $item['link'];
                $title = htmlentities($item['title']);
                
                if ($param['show_desc']) {
                  print "<li>
                           <a target='_blank' href='$href'>$title</a>
                           <br>{$item['description']}
                         </li>";
                }
                else {
                  print "<li>
                           <a target='_blank' href='$href'>$title</a>
                         </li>";
                }
              }
              $i++;
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