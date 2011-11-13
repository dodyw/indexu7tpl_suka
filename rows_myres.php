<?php if (count($lep->tpl["resources"])) : ?>

  <?php foreach ($lep->tpl["resources"] as $k => $v) { ?>

    <article class="post row_spacing">
      <h2 class="title"><a title="<?php print $v['title'] ?>" rel="bookmark" href="<?php print seo_detail_url2($v['res_id'], $v['title']) ?>"><?php print $v['title'] ?></a></h2>

      <section class="article-content ninecol">
        
        <a href="<?php print seo_detail_url2($v['res_id'], $v['title']) ?>" alt="<?php print $v['title'] ?>">
        <img class="thumbnail alignleft" src="http://open.thumbshots.org/image.aspx?url=<?php print $v['url'] ?>" alt="<?php print $v['title'] ?>" style="border:1px solid #777;"></a>
          
        <?php if ($v['description']): ?>
          <p><?php print $v['description'] ?></p>
        <?php endif ?>
        
      </section><!--/.article-content-->

      <aside class="threecol meta last">
        <ul>
          <li class="date"><?php print date('F d, Y',$v['created_at']) ?></li>

          <?php if ($v['user_id']): ?>
            <li class="author"><?php print $v['user_id'] ?></li>
          <?php endif ?>
          
          <li class="category"><?php print cat_get_category_path_url($v['category_id']); ?></li>
          <li class="comments"><a title="View Detail" href="<?php print seo_detail_url2($v['res_id'], $v['title']) ?>">View Detail</a></li>
          <li class="tags"><a href="<?php print $v['url'] ?>" name="link_<?php print $v['res_id'] ?>" title="Visit <?php print $v['title'] ?>">Visit website</a></li></li>
          <li class="tags"><a href="usercp/res_edit.php?id=<?php print $v['res_id']?>"><?php print _t('Edit') ?></a></li>
          <li class="tags"><a href="upgrade.php?id=<?php print $v['res_id']?>"><?php print _t('Upgrade') ?></a></li>
        </ul>
        
      </aside><!--/.meta-->

      <section>
        <a class="woo-sc-button small silver" href="<?php print URL.'usercp/image.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Upload image') ?></a>
        <a class="woo-sc-button small silver" href="<?php print URL.'usercp/video.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Upload video') ?></a>
        <a class="woo-sc-button small silver" href="<?php print URL.'usercp/promo.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Add promo') ?></a>
        <a class="woo-sc-button small silver" href="<?php print URL.'usercp/event.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Add event') ?></a>
        <a class="woo-sc-button small silver" href="<?php print URL.'usercp/product.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Add product') ?></a>
        <a class="woo-sc-button small silver" href="<?php print URL.'usercp/document.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Add document') ?></a>
        <a class="woo-sc-button small silver" href="<?php print URL.'usercp/news.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Add news') ?></a>
        <a class="woo-sc-button small silver" href="<?php print URL.'usercp/article.php?act=add&res_id='.$v['res_id'] ?>"><?php print _t('Add article') ?></a>
      </section>
    </article> <!--/.post -->
  
  <?php } ?>

<?php endif; ?>
