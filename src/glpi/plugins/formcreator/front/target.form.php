<?php
include ("../../../inc/includes.php");

Session::checkRight("entity", UPDATE);

// Check if plugin is activated...
$plugin = new Plugin();
if ($plugin->isActivated("formcreator")) {
   $target = new PluginFormcreatorTarget();

   // Add a new target
   if (isset($_POST["add"]) && !empty($_POST['plugin_formcreator_forms_id'])) {
      $target->add($_POST);
      Html::back();

      // Delete a target
   } else if (isset($_POST["delete_target"])) {
      $target->delete($_POST);
      Html::redirect($CFG_GLPI["root_doc"] . '/plugins/formcreator/front/form.form.php?id=' . $_POST['plugin_formcreator_forms_id']);

   } else if (isset($_GET['id'])) {
      $target->getFromDB($_GET['id']);
      Html::redirect(Toolbox::getItemTypeFormURL($target->fields['itemtype']) . '?id=' . $_GET['id']);
   } else {
      Html::back();
   }

   // Or display a "Not found" error
} else {
   Html::displayNotFoundError();
}
