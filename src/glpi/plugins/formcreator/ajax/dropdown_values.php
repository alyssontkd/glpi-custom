<?php
include ('../../../inc/includes.php');

Session::checkRight("entity", UPDATE);

if ($_REQUEST['dropdown_itemtype'] == '0' || !class_exists($_REQUEST['dropdown_itemtype'])) {
   Dropdown::showFromArray("dropdown_default_value", [], ['display_emptychoice'   => true]);
} else {
   Dropdown::show($_REQUEST['dropdown_itemtype'], [
      'name' => 'dropdown_default_value',
      'rand' => mt_rand(),
   ]);
}
