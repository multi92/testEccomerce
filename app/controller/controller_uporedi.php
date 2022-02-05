<?php
//include("app/class/Product.php");
$compareprods = GlobalHelper::getCompareProdInfo();

$attrs = array();
$addedattrid = array();

foreach ($compareprods as $cp) {
	
    foreach ($cp->attrs as $attr) {
		

		if($attr['mandatory']==0 && !in_array($attr['attrid'], $addedattrid)){

            array_push($addedattrid, $attr['attrid']);
            $key = array_search($attr['attrid'], $addedattrid);
            $attrs[$key] = array();
            $attrs[$key]['attrid'] = $attr['attrid'];
            $attrs[$key]['name'] = $attr['name'];
        }
		
    }
}

$attrproddata = array();
$attrprodsdata = array();
foreach ($attrs as $attrc) {
    $attrproddata['attrid'] = $attrc['attrid'];
    $attrproddata['name'] = $attrc['name'];
    $attrproddata['attrvals'] = array();
    foreach ($compareprods as $cp) {
            $haveattr = false;
        foreach ($cp->attrs as $attr) {
            if(!$attr['mandatory'] && $attr['attrid'] == $attrc['attrid'] && !empty($attr['value'])){
                array_push($attrproddata['attrvals'], $attr['value'][0]['attr_val_name']);
                $haveattr = true;
            }
        }
        if(!$haveattr){
            array_push($attrproddata['attrvals'], " - ");
        }
    }
    array_push($attrprodsdata, $attrproddata);

}
include($system_conf["theme_path"][1]."views/compare.php");

?>