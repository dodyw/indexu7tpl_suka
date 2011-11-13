<?php
$this->layouts = Array(
  'tabular' => Array(
      'container'  => "<table cellpadding=\"5\" cellspacing=\"0\" border=\"0\">\n%s\n</table>\n",
      'element'    => "<tr>
                         <td width=\"120\" align=\"right\" valign=\"top\" class=\"form_field\">
                           <label for=\"%id%\">%displayname%</label>
                         </td>
                         <td valign=\"top\" class=\"form_value %errorstyle%\">
                          %prefix%%element%%postfix% <br />%errordiv%
                         </td>
                        </tr>\n",
      'buttonrow'  => '<tr><td></td><td>%s</td></tr>',
      'button'     => '<input class="submit button" type="submit" value="%s" />',
      'errordiv'   => '<span id="%divid%" style="display: none; visibility: hidden; color:#f00;font-size:90%;"></span>',
    ),
);

$this->messageprefix  = ''; // shown above error messages
$this->messagecontainerlayout = '%s';
$this->messagelayout  = '<div class="woo-sc-box alert">%s</div>';

?>