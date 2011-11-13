<?php if (count($lep->tpl["inquiries"])) : ?>

  <?php foreach ($lep->tpl["inquiries"] as $k => $v) { ?>

  <div class="inquiryReview">
    <div class="inquirymetadata">
      <b><?php print $v['subject'] ?></b>
      <br>

      <?php $name = $v['name'] ?>
      <?php $email = $v['email'] ?>
      <?php $date = date('M d, Y',$v['created_at']) ?>
      <span>
        <?php print _t("Sent by $name ($email) on $date") ?>
      </span>
      
    </div>
    <div class="inquiryBody">
      <p><?php print $v['inquiry'] ?></p>
    </div>
  </div>	  
    	      
  <?php } ?>

<?php endif; ?>