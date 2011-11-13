<?php  
  function w_breadcrumb() {
    global $lep;

    $param = etc_read_option($option);

    ob_start();    
    ?>
      <div class="breadcrumb breadcrumbs woo-breadcrumbs">
        <div class="breadcrumb-trail">
          <span class="trail-before">
            <span class="breadcrumb-title"><?php print _t('You are here') ?>:</span>
          </span> 
          <a class="trail-begin" rel="home" title="<?php print DIR_NAME ?>" href="<?php print URL ?>"><?php print _t('Home') ?></a> 
          <span class="sep">&gt;</span> 
          <span class="trail-end">
            <?php print $lep->breadcrumb; ?>          
          </span>
        </div>
      </div>    
      <div class="fix"></div>
    <?php    
    $html = ob_get_contents();
    ob_end_clean();  

    return $html;
  }
?>

