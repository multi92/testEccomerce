<?php

$class_version["slideritem"] = array('class', '1.0.0.0.1', 'Nema opisa');

class SliderItem
{
    public $id;
    public $item;
    public $galleryid;
	public $type;
	public $text;
	public $title;
	public $link;
    public $sort;
    public $status;
    public $info_position;
    public $info_img;
    public $show_info;

    public function __construct($id, $item, $galleryid, $type, $text, $title, $link, $sort, $status,$info_position,$info_img,$show_info)
    {
        $this->id=$id;
        $this->item=$item;
        $this->galleryid=$galleryid;
        $this->type=$type;
        $this->text=$text;
        $this->title=$title;
        $this->link=$link;
        $this->sort=$sort;
        $this->status=$status;
        $this->info_position=$info_position;
        $this->info_img=$info_img;
        $this->show_info=$show_info;
    }
	public static function GetSliderListById($GalleryId){

    	$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");	
		
		$sliders = array();
		
		$query="SELECT gi.*, gitr.text AS `texttr` , gitr.title AS `titletr`  FROM galleryitem gi 
		LEFT JOIN gallery g ON gi.galleryid = g.id
		LEFT JOIN galleryitem_tr gitr ON gi.id = gitr.galleryitemid
		WHERE g.id = ".$GalleryId." AND gi.type = 'img' AND (gitr.langid =". $_SESSION['langid'] . " OR gitr.langid IS NULL) ORDER BY gi.sort ASC";
		$res = $mysqli->query($query);
		if($res && $res->num_rows > 0){
			while($row = $res->fetch_assoc()){
				$text='';
				$title='';
				$text=$row['text'];
				if($row['texttr'] != '' and $row['texttr'] != NULL){
					$text=$row['texttr'];
				}
				$title=$row['title'];
				if($row['titletr'] != '' and $row['titletr'] != NULL){
					$title=$row['titletr'];
				}
				array_push($sliders, array("id"=>$row['id'],
				                           "item"=>$row['item'],
										   "galleryid"=>$row['galleryid'],										   
				                           "type"=>$row['type'],										   
				                           "text"=>$text,										   
				                           "title"=>$title,										   
				                           "link"=>$row['link'],										   
				                           "sort"=>$row['sort'],										   
				                           "status"=>$row['status'],
				                           "info_position"=>$row['info_position'],
				                           "info_img"=>$row['info_img'],
				                           "show_info"=>$row['show_info']
										   ));
			}
		}
		return $sliders;
	}
}