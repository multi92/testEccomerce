<?php
require_once("app/class/Shop.php");
include("app/class/Person.php");
global $user_conf;

$shops = Shop::getList();
$shops = $shops[1];
//var_dump($shops);
//var_dump(Shop::getALLShopsCities());


$persons = Person::getAllPersons();
$personspershop = Person::getPersonsByShops();

$page = 1;
if(isset($_GET['p']) && $_GET['p'] != ""){
    $page = $_GET['p'];
}

if(isset($command[1]) && $command[1] != ""){

}
else {

}
include ($system_conf["theme_path"][1]."views/contact.php");