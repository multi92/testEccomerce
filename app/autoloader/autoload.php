<?php


include 'MyAutoLoader.php';
$app_classes = new MyAutoLoader('app/application');
$ctrl_classes = new MyAutoLoader('app/controller');
$model_classes = new MyAutoLoader('app/model');
$service_classes = new MyAutoLoader('app/services');

?>