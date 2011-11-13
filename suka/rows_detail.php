<?php if (count($lep->tpl["resources"])) : ?>
  <?php foreach ($lep->tpl["resources"] as $k => $v) { ?>

  <?php 
    $a = explode(',', $v['tag']);
    
    foreach ($a as $k2 => $v2) {      
      $colors = "0123456789ABCDE";
      $tag_color = "#";
      
      for ($ii = 1; $ii <= 6; $ii++) {
        $tag_color .= $colors[rand(0, 14)];
      }
        
      $v2 = trim($v2);
      $v2_url = str_replace(' ','+',$v2);

      if ($v2) {
        $tag_temp[] = "<a style=\"color:{$tag_color}\" href=\"".URL."tag/{$v2_url}\">$v2</a>";
      }
    }     

    if (is_array($tag_temp)) {
      $v['tag_url'] = implode(", ", $tag_temp);
    }
    
    $featured_listing = false;

    if ($v['featured']=='1' and $v['featured_expired'] > time()) {
      $featured_listing = true;
    }
  ?>

  <article class="post">  
    <h3><?php print $v['title'] ?> <span class="featured_tag">Featured</span></h3>
    <table class="listing_detail_sheet">
      <col class="m_col"></col>
      <col></col>
      <tbody>
        <tr>
          <td><?php print _t('Listing ID') ?></td>
          <td>
            <div>
              <div style="float:left;width:30%;"><?php print $v['res_id'] ?></div>
              <div style="float:right;text-align:right;width:70%;">
                
                <?php if (!$featured_listing) : ?>
                <a href="upgrade.php?id=<?php print $v['res_id'] ?>" title="" class="woo-sc-button small orange"><?php print _t('Upgrade') ?></a>
                <?php endif; ?>

                <a href="usercp/claim.php?act=claim&id=<?php print $v['res_id'] ?>" title="" class="woo-sc-button small silver"><?php print _t('Claim') ?></a>

                <a href="report.php?id=<?php print $v['res_id'] ?>" title="" class="woo-sc-button small red"><?php print _t('Report') ?></a>

              </div>
              <div style="clear:both;"></div>
            </div>

            </td>
        </tr>

        <!-- content generated from custom fields data according to fields order -->

        <?php  
        $cf = cf_get_custom_fields('resource');

        foreach ($cf as $k2 => $v2) {
          $cf_names[] = $v2['name'];
          $cf_texts[$v2['name']] = $v2['text'];
        }

        // foreach ($cf_names as $k2 => $v2) { 
        foreach ($cf_names as $k2 => $v2) { 

          // manually handle data if necessary
          if ($v2=='category_id') {
            $v[$v2] = cat_get_category_path_url($v['category_id']);
          }

          if ($v2=='url') {
            $url_temp = $v[$v2];
            $v[$v2] = "<a href=\"{$v['url']}\" name=\"link_{$v['res_id']}\">{$v['url']}</a>";
          }

          if ($v2=='tag') {
            $v[$v2] = $v['tag_url'];
          }

          if ($v2=='owner_name') {
            $cf_texts[$v2] = _t('Owner');
          }
          
          if ($v2=='email') {
            $cf_texts[$v2] = _t('Email');
            $v[$v2] = "<a href=\"inquiry.php?id={$v['res_id']}\" class=\"woo-sc-button small blue\">"._t("Send an inquiry")."</a>";
          }

          // detect image fields
          if ($cf[$k2]['type']=='inputFile') {
            if (strtolower(substr($v[$v2], -4, 4))=='.jpg' || strtolower(substr($v[$v2], -4, 4))=='.png' || strtolower(substr($v[$v2], -4, 4))=='.gif') {
              $v[$v2] = "<img src=\"upload/{$v[$v2]}\" />";
            }
          }

          // detect checkboxgroup
          if ($cf[$k2]['type']=='inputCheckboxDynamic') {
            $cbg_divide  = $cf[$k2]['num_column']; 
            $cbg_divider = "</tr><tr>\n"; 
            $cbg_wrapper = '<table class="checkboxgroup"><tr>%s</tr></table>'; 
            $cbg_item_layout = "<td>%checkbox% %label%</td>\n"; 

            $cbg_data_all = cf_val_opt($cf[$k2]['val']);
            $cbg_data_val = explode('|', $v[$v2]);

            unset($html);

            if (is_array($cbg_data_all)) {
              foreach ($cbg_data_all as $k3 => $v3) {
                // print "[x] $v3";
                if ( $cbg_divide && $counter && ( ( $counter % $cbg_divide ) == 0 ) )
                  $html .= $cbg_divider;

                $label    = $v3;

                if (in_array($v3, $cbg_data_val)) {
                  $checkbox = "<img src=\"".TPL_URL."images/icons/icon_tick.png\" style=\"position:relative;top:5px\" />";
                }
                else {
                  $checkbox = "<img src=\"".TPL_URL."images/icons/icon_cross_small.png\" style=\"position:relative;top:8px\" />";
                }
                
                $replace = Array( 
                  "%checkbox%" => $checkbox, 
                  "%label%"    => $label
                );

                $html .= strtr( $cbg_item_layout, $replace );
                $counter++;
              }
            }
            $html = sprintf($cbg_wrapper, $html);
            $v[$v2] = $html;
          }
          ?>
          <!-- begin html code here for each custom fields data -->
          <?php if ($v2!='title' && $v2!='image'): ?> <!-- exclude some fields -->
            <?php if ($v[$v2]): ?> <!-- remove empty fields -->
              <tr>
                <td><?php print _t($cf_texts[$v2]) ?></td>
                <td><?php print $v[$v2] ?></td>
              </tr>                
            <?php endif ?>
          <?php endif ?>  

        <?php
            // return to original value, if necessary
            if ($v2=='url') {
              $v[$v2] = $url_temp;
            }
          }
        ?>

        <tr>
          <td><?php print _t('Date Added') ?></td>
          <td><?php print date("F d, Y",$v['created_at']) ?></td>
        </tr>

        <!-- ajax rating -->
        <tr>
          <td><?php print _t('Visitor Rating') ?></td>
          <td>
            <?php include "ajaxrating/ajaxrating.php" ?>
          </td>
        </tr>

        <tr>
          <td><img src="http://open.thumbshots.org/image.aspx?url=<?php print $v['url'] ?>" alt="<?php print $v['title'] ?>" style="border:1px solid #777;float:left;"></td>
          <td>
            <div>
              <!-- google one plus -->
              <g:plusone size="medium"></g:plusone>
            </div>
            
            <!-- fb like -->
            <?php if ($lep->config['facebook_enable']) { ?>
         		  <div style="margin-top:10px"><fb:like layout="button_count" show_faces="true" width="450"></fb:like></div>
            <?php } ?>
            
            <!-- digg button -->
            <div style="margin-top:10px">
              <!-- dig -->
              <script type="text/javascript">
                (function() {
                var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
                s.type = 'text/javascript';
                s.async = true;
                s.src = 'http://widgets.digg.com/buttons.js';
                s1.parentNode.insertBefore(s, s1);
                })();
              </script>
              <!-- Compact Button -->
              <a class="DiggThisButton DiggCompact"></a>
            </div>
            
            <!-- reddit button -->
            <div style="margin-top:10px">
              <script type="text/javascript" src="http://www.reddit.com/static/button/button1.js"></script>                
            </div>

            <!-- additional socialbookmark, set in admin panel -->
            <div style="margin-top:10px">
              <?php print etc_print_social_bookmarking($v['res_id']); ?>
            </div>
            
          </td>
        </tr>
    </table>
  </article>

  <!-- google map -->
  <?php $address_test = $v['address'].$v['city'].$v['state'].$v['zip'].$v['country']; ?>
  <?php if ($lep->config['enable_google_map'] && $address_test) { ?>
    <article class="post">  
      <div id="map_canvas" style="border:5px solid #aaa;width: 610px;  height: 300px; margin: 20px 0;"></div>
    </article>
  <?php } ?>
  
  
  <!-- tabbed content -->
  <?php $detail_url = seo_detail_url2($v['res_id'], $v['title']) ?>

  <article class="post">  
    <div id="usual1" class="usual"> 
      <?php
        $query = "select * from lep_image where status = '1' and res_id = '{$v['res_id']}'";
        $rs = $lep->db->Execute($query);
        $images = $rs->GetRows();  
        
        $query = "select * from lep_video where status = '1' and res_id = '{$v['res_id']}'";
        $rs = $lep->db->Execute($query);
        $videos = $rs->GetRows();  
        
        $query = "select * from lep_promo where status = '1' and res_id = '{$v['res_id']}'";
        $rs = $lep->db->Execute($query);
        $promos = $rs->GetRows();
        
        $query = "select * from lep_event where status = '1' and res_id = '{$v['res_id']}'";
        $rs = $lep->db->Execute($query);
        $events = $rs->GetRows();
        
        $query = "select * from lep_product where status = '1' and res_id = '{$v['res_id']}'";
        $rs = $lep->db->Execute($query);
        $products = $rs->GetRows();
        
        $query = "select * from lep_document where status = '1' and res_id = '{$v['res_id']}'";
        $rs = $lep->db->Execute($query);
        $documents = $rs->GetRows();

        $query = "select * from lep_news where status = '1' and res_id = '{$v['res_id']}'";
        $rs = $lep->db->Execute($query);
        $news = $rs->GetRows();
        
        $query = "select * from lep_article where status = '1' and res_id = '{$v['res_id']}'";
        $rs = $lep->db->Execute($query);
        $articles = $rs->GetRows();
      ?>
      <ul> 
        <li><a class="selected" href="<?php print $detail_url ?>#tab1"><?php print _t("Images")." (".count($images).")" ?></a></li> 
        <li><a href="<?php print $detail_url ?>#tab2"><?php print _t("Videos")." (".count($videos).")" ?></a></li> 
        <li><a href="<?php print $detail_url ?>#tab3"><?php print _t("Promos")." (".count($promos).")" ?></a></li> 
        <li><a href="<?php print $detail_url ?>#tab4"><?php print _t("Events")." (".count($events).")" ?></a></li> 
        <li><a href="<?php print $detail_url ?>#tab5"><?php print _t("Products")." (".count($products).")" ?></a></li> 
        <li><a href="<?php print $detail_url ?>#tab6"><?php print _t("Documents")." (".count($documents).")" ?></a></li> 
        <li><a href="<?php print $detail_url ?>#tab7"><?php print _t("News")." (".count($news).")" ?></a></li> 
        <li><a href="<?php print $detail_url ?>#tab8"><?php print _t("Articles")." (".count($articles).")" ?></a></li> 
      </ul>
      
      <!-- images --> 
      <div id="tab1" class="tabbed">
        <?php
          if (count($images)) {
            foreach($images as $k2 => $v2) {
            ?>
            <a href="<?php print URL.'upload/'.$v2['filename'] ?>"
               rel="prettyPhoto"><img src="<?php print 'lib/timthumb/timthumb.php?h=90&src='.

                        'upload/'.$v2['filename'] ?>"
                   alt="<?php print $v2['title'] ?>"
                   name="<?php print $v2['title'] ?>" /></a>
            <?php
            }
          ?>
            <div style="margin-top:10px">
              <p><a class="woo-sc-button small silver" href="<?php print URL.'usercp/image.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Upload image') ?></a></p></div>
          <?php
          }
          else {
          ?>
            <div>
              <p><?php print _t('There is no image for this listing.') ?></p>           
              <p><a class="woo-sc-button small silver" href="<?php print URL.'usercp/image.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Upload image') ?></a></p>
            </div>
          <?php
          }
        ?>
      </div> 

      <!-- videos --> 
      <div id="tab2" class="tabbed">
        <?php
          if (count($videos)) {
            foreach($videos as $k2 => $v2) {
            ?>
            <a href="<?php print 'http://www.youtube.com/watch?v='.$v2['youtube_id'] ?>"
               rel="prettyPhoto"><img src="http://i1.ytimg.com/vi/<?php print $v2['youtube_id'] ?>/default.jpg" /></a>
            <?php
            }
          ?>
            <div style="margin-top:10px">
              <p><a class="woo-sc-button small silver" href="<?php print URL.'usercp/video.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Upload video') ?></a></p>
            </div>
          <?php
          }
          else {
          ?>
            <div>
              <p><?php print _t('There is no video for this listing.') ?></p>
              <p><a class="woo-sc-button small silver" href="<?php print URL.'usercp/video.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Upload video') ?></a></p>
            </div>
          <?php
          }
        ?>
      </div> 

      <!-- promos --> 
      <div id="tab3" class="tabbed">
        <?php
          if (count($promos)) {

            foreach($promos as $k2 => $v2) {
            ?>
              <?php print nl2br($v2['promo']) ?>
            <?php
            }

            ?>
            <div style="margin-top:10px">
              <p><a class="woo-sc-button small silver" href="<?php print URL.'usercp/promo.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Add promo') ?></a></p>
            </div>
            <?php
          }
          else {
          ?>
            <div>
              <p><?php print _t('There is no promo for this listing.') ?></p> 
              <p><a class="woo-sc-button small silver" href="<?php print URL.'usercp/promo.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Add promo') ?></a></p>
            </div>
          <?php
          }
        ?>
      </div> 

      <!-- events --> 
      <div id="tab4" class="tabbed">
        <?php
          if (count($events)) {

           foreach($events as $k2 => $v2) {
            ?>
              <b><span style="text-decoration:underline;"><?php print $v2['title'] ?></span></b> -
              <?php print $v2['event'] ?>
              <br /><strong>Date:</strong> <?php print etc_ts2date($v2['date']) ?>
            <?php
            }
            ?>
            <div style="margin-top:10px">
              <p><a class="woo-sc-button small silver" href="<?php print URL.'usercp/event.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Add event') ?></a></p>
            </div>
            <?php          }
          else {
          ?>
            <div>
              <p><?php print _t('There is no event for this listing.') ?></p> 
              <p><a class="woo-sc-button small silver" href="<?php print URL.'usercp/event.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Add event') ?></a></p>
            </div>
          <?php
          }
        ?>
      </div> 

      <!-- products --> 
      <div id="tab5" class="tabbed">
        <?php
          if (count($products)) {

            foreach($products as $k2 => $v2) {
            ?>
            <div style='margin-bottom:10px;'>
              <div style="float:left;">
                <?php if ($v2['image']) : ?>
                <a rel="prettyPhoto" href="<?php print 'upload/'.$v2['image'] ?>"><img
                     src="<?php print URL.'lib/timthumb/timthumb.php?w=90&src='.
                          'upload/'.$v2['image'] ?>"
                     alt="<?php print $v2['title'] ?>"
                     name="<?php print $v2['title'] ?>" /></a>
                <?php else : ?>
                <img src="<?php print TPL_URL ?>/images/no_prod_image.jpg"
                     alt="<?php print $v2['title'] ?>"
                     name="<?php print $v2['title'] ?>" />
                <?php endif; ?>
              </div>
              <div style="float:left; margin-left:10px;width: 560px;">
                <div><b><?php print $v2['title'] ?></b></div>
                <?php if ($v2['description']) : ?><div style="margin-top:7px;"><?php print $v2['description'] ?></div><?php endif; ?>
                <?php if ($v2['price']) : ?><div style="margin-top:10px;"><?php print _t('Price') ?>: <?php print $v2['price'] ?></div><?php endif; ?>
              </div>
              <div style="clear:both;"></div>
            </div>
            <?php
            }

          ?>
            <div style="margin-top:10px">
              <p><a class="woo-sc-button small silver" href="<?php print URL.'usercp/product.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Add product') ?></a></p>
            </div>
          <?php
          }
          else {
          ?>
            <div>
              <p><?php print _t('There is no product for this listing.') ?></p> 
              <p><a class="woo-sc-button small silver" href="<?php print URL.'usercp/product.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Add product') ?></a></p>
            </div>
          <?php
          }
        ?>
      </div> 

      <!-- documents --> 
      <div id="tab6" class="tabbed">
        <?php
          if (count($documents)) {

            foreach($documents as $k2 => $v2) {
            ?>
            <p>
              <a href="<?php print 'upload/'.$v2['filename'] ?>"><?php print $v2['title'] ?></a>
            </p>
            <?php
            }
            ?>
            <div>
              <p><a class="woo-sc-button small silver" href="<?php print URL.'usercp/document.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Add document') ?></a></p>
            </div>
            <?php
          }
          else {
          ?>
            <div>
              <p><?php print _t('There is no document for this listing.') ?></p>
              <p><a class="woo-sc-button small silver" href="<?php print URL.'usercp/document.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Add document') ?></a></p>
            </div>
          <?php
          }
        ?>
      </div> 

      <!-- news --> 
      <div id="tab7" class="tabbed">
        <?php
          if (count($news)) {

            foreach($news as $k2 => $v2) {
            ?>
              <p><b><?php print $v2['title'] ?></b> -
              <?php print $v2['news'] ?></p>
            <?php
            }

            ?>
            <div>
              <p><a class="woo-sc-button small silver" href="<?php print URL.'usercp/news.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Add news') ?></a></p>
            </div>
            <?php            }
          else {
          ?>
            <div>
              <p><?php print _t('There is no news for this listing') ?></p> 
              <p><a class="woo-sc-button small silver" href="<?php print URL.'usercp/news.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Add news') ?></a></p>
            </div>
          <?php
          }
        ?>
      </div> 

      <!-- articles --> 
      <div id="tab8" class="tabbed">
        <?php
          if (count($articles)) {

            foreach($articles as $k2 => $v2) {
            ?>
              <h4 style="font-size:13px;margin:20px 0;"><?php print $v2['title'] ?></h4>
              <?php print $v2['content'] ?>
            <?php
            }

            ?>
            <div>
              <p><a class="woo-sc-button small silver" href="<?php print URL.'usercp/article.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Add article') ?></a></p>
            </div>
            <?php            }
          else {
          ?>
            <div>
              <p><?php print _t('There is no article for this listing.') ?></p>
              <p><a class="woo-sc-button small silver" href="<?php print URL.'usercp/article.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Add article') ?></a></p>
            </div>
          <?php
          }
        ?>
      </div> 
    </div> 
  </article>
  
  <script type="text/javascript" src="<?php print URL."lib/js/jquery.idTabs.min.js" ?>"></script> 
  <script type="text/javascript"> 
    $("#usual1 ul").idTabs(); 
  </script>
  
  <!-- load prettyphoto js -->
  <script type="text/javascript" src="<?php print URL."lib/js/prettyPhoto/js/jquery.prettyPhoto.js" ?>"></script> 
  <link rel="stylesheet" href="<?php print URL."lib/js/prettyPhoto/css/prettyPhoto.css" ?>" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
  <script type="text/javascript" charset="utf-8">
		$(document).ready(function(){
			$("a[rel^='prettyPhoto']").prettyPhoto();
		});
	</script>
	
	
  <?php } ?>
<?php else : ?>
  <?php print _t('Sorry you hit wrong page.') ?>
<?php endif; ?>