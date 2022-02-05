<?php
$class_version["galleryitem"] = array('class', '1.0.0.0.1', 'Nema opisa');
/**
 * Created by PhpStorm.
 * User: SoftArt-Milos
 * Date: 15/7/2016
 * Time: 15:52
 */
class GalleryItem
{
    public $id;
    public $item;
    public $text;
    public $title;
    public $link;
    public $info_position;
    public $info_img;
    public $show_info;

    public function __construct($id, $item, $text, $title, $link,$info_position,$info_img,$show_info)
    {
        $this->id=$id;
        $this->item=$item;
        $this->text=$text;
        $this->title=$title;
        $this->link=$link;
        $this->info_position=$info_position;
        $this->info_img=$info_img;
        $this->show_info=$show_info;
    }
    public static function GetGalleryItems($galleryid, $page = 1, $limit = 0){
        /**
         * $galleryid - id galerije
         *
         * return - niz objekta GalleryItems
        */

        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        global $user_conf, $theme_conf ;
        $galleryItems = array();
        $querylimit = '';

        if($limit !=0 && $theme_conf["show_all_galleryitems"]['1'] !=1){
            $start = ($page - 1) * $limit;
            $end = $limit;
            $querylimit = "LIMIT ".$start.", ".$end;
        }

        $query = "select SQL_CALC_FOUND_ROWS gi.id, gi.item, gi.type, gi.link, gitr.text, gitr.title, gi.info_position, gi.show_info, gi.info_img from galleryitem gi
                    LEFT JOIN galleryitem_tr gitr ON gi.id = gitr.galleryitemid
                    WHERE gi.galleryid = ".$galleryid."
                    and gitr.langid = ".$_SESSION['langid']."
                    and gi.status = 'v'
                    ORDER BY sort asc " . $querylimit;


        $res=$mysqli->query($query);

        $sQuery = "SELECT FOUND_ROWS()";
        $sRe = $mysqli->query($sQuery);
        $aRe = $sRe->fetch_array();
        $foundproducts = $aRe[0];

        while($row = $res->fetch_assoc()){
            array_push($galleryItems, new GalleryItem($row['id'], $row['item'], $row['text'], $row['title'], $row['link'], $row['info_position'], $row['info_img'], $row['show_info']));
        }

        return array($foundproducts, $galleryItems);

    }

/*    private static function GetGalleryItems($Gallery_id,$limitV=false,$youtube=false)
    {
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        if($limitV)
        {
            $limit=' limit 6';
        }else{
            $limit="";
        }

        $query = "SELECT g.id, g.galleryid, g.type, gt.content, gt.title, g.link, g.itemlink
                  FROM galleryitem g
                  LEFT JOIN galleryitem_tr gt
                  ON g.id = gt.galleryitemid
                  WHERE galleryid = " . $Gallery_id . "
                  AND gt.lang_id = '" . Session::GetVarVal('langid') . "'
                  ORDER BY `order` ASC ".$limit;

        $result=$mysqli->query($query);

        if($result)
        {
            if($result->num_rows > 0)
            {
                while($g=$result->fetch_assoc())
                {
                    //ako se galerija stampa na pocetnoj strani, uzimaju se thumbnailovi
                    // video klipova a ne sami videoklipovi
                    if($youtube)
                    {
                        $g['itemlink']=static::GetYoutubeThumbnail($g['itemlink']);
                    }
                    $items[]= new GalleryItem($g['id'],$g['galleryid'],$g['type'],$g['title'],$g['content'],$g['link'],$g['itemlink']);
                }

                return $items;
            }
        }

    }*/
}