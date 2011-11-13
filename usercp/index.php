<p><?php print _t('Welcome to user panel. Here you can manage your account and listings.') ?></p> 

<table class="usercp_main_tbl">
  <tr>
    <td><a href="add.php"><img src="<?php print TPL_URL ?>icons/paper_content_pencil_48.png"><br /><?php print _t('Submit New Listing') ?></a></td>
    <td><a href="usercp/claim.php"><img src="<?php print TPL_URL ?>icons/paper_content_48.png"><br /><?php print _t('Claim a Listing') ?></a></td>
    <td><a href="usercp/myres.php"><img src="<?php print TPL_URL ?>icons/tabs_48.png"><br /><?php print _t('My Listing') ?></a></td>
  </tr>
  <tr>
    <td><a href="usercp/profile.php"><img src="<?php print TPL_URL ?>icons/user_48.png"><br /><?php print _t('My Profile') ?></a></td>
    <td><a href="usercp/password.php"><img src="<?php print TPL_URL ?>icons/lock_open_48.png"><br /><?php print _t('Change Password') ?></a></td>
    <td></td>
  </tr>
</table>