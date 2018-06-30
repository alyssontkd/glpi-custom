<?php
if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access this file directly");
}

/**
 * @since 0.90-1.5
 */
class PluginFormcreatorForm_Validator extends CommonDBRelation {

      // From CommonDBRelation
   static public $itemtype_1          = 'PluginFormcreatorForm';
   static public $items_id_1          = 'plugin_formcreator_forms_id';

   static public $itemtype_2          = 'itemtype';
   static public $items_id_2          = 'items_id';
   static public $checkItem_2_Rights  = self::HAVE_VIEW_RIGHT_ON_ITEM;

   const VALIDATION_USER  = 1;
   const VALIDATION_GROUP = 2;

   public function prepareInputForAdd($input) {
      // generate a uniq id
      if (!isset($input['uuid'])
          || empty($input['uuid'])) {
         $input['uuid'] = plugin_formcreator_getUuid();
      }

      return $input;
   }

   /**
    * Import a form's validator into the db
    * @see PluginFormcreatorForm::importJson
    *
    * @param  integer $forms_id  id of the parent form
    * @param  array   $validator the validator data (match the validator table)
    * @return integer the validator's id
    */
   public static function import($forms_id = 0, $validator = []) {
      $item = new self;

      $validator['plugin_formcreator_forms_id'] = $forms_id;

      if ($validators_id = plugin_formcreator_getFromDBByField($item, 'uuid', $validator['uuid'])) {
         // add id key
         $validator['id'] = $validators_id;

         // update section
         $item->update($validator);
      } else {
         //create section
         $validators_id = $item->add($validator);
      }

      return $validators_id;
   }

   /**
    * Export in an array all the data of the current instanciated validator
    * @param boolean $remove_uuid remove the uuid key
    *
    * @return array the array with all data (with sub tables)
    */
   public function export($remove_uuid = false) {
      if (!$this->getID()) {
         return false;
      }

      $validator = $this->fields;

      // remove key and fk
      unset($validator['id'],
            $validator['plugin_formcreator_forms_id']);

      if (is_subclass_of($validator['itemtype'], 'CommonDBTM')) {
         $validator_obj = new $validator['itemtype'];
         if ($validator_obj->getFromDB($validator['items_id'])) {

            // replace id data
            $identifier_field = isset($validator_obj->fields['completename'])
                                 ? 'completename'
                                 : 'name';
            $validator['_item'] = $validator_obj->fields[$identifier_field];
         }
      }
      unset($validator['items_id']);

      if ($remove_uuid) {
         $validator['uuid'] = '';
      }

      return $validator;
   }
}
