<?php

function plugin_formcreator_update_2_6_1() {
   global $DB;

   // decode html entities in name of questions
   $request = [
      'SELECT' => ['glpi_plugin_formcreator_answers.*'],
      'FROM' => 'glpi_plugin_formcreator_answers',
      'INNER JOIN' => ['glpi_plugin_formcreator_questions' => [
         'FKEY' => [
            'glpi_plugin_formcreator_answers' => 'plugin_formcreator_questions_id',
            'glpi_plugin_formcreator_questions' => 'id'
         ]
      ]],
      'WHERE' => ['fieldtype' => 'textarea']
   ];
   foreach ($DB->request($request) as $row) {
      $answer = Toolbox::addslashes_deep(html_entity_decode($row['answer'], ENT_QUOTES|ENT_HTML5));
      $id = $row['id'];
      $DB->query("UPDATE `glpi_plugin_formcreator_answers` SET `answer`='$answer' WHERE `id` = '$id'");
   }

   $request = [
      'FROM' => 'glpi_plugin_formcreator_questions',
   ];
   foreach ($DB->request($request) as $row) {
      $id = $row['id'];
      $name = Toolbox::addslashes_deep(html_entity_decode($row['name'], ENT_QUOTES|ENT_HTML5));
      $id = $row['id'];
      $DB->query("UPDATE `glpi_plugin_formcreator_questions` SET `name`='$name' WHERE `id` = '$id'");
   }
}