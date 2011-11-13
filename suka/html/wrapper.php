<?php 
  function html_wrapper($html, $param) {
    $html = "<p>$html</p>";
    ($param['show_title']) ? $html = "<h3>"._t($param['title'])."</h3>$html" : false;
    $html = "<div class=\"post\">$html</div>";
    
    return $html;
  } 
?>