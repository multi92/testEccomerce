<?php
$class_version["documents"] = array('module', '1.0.0.0.1', 'Nema opisa');

class File{
	public $name;
	public $showname;
	public $showimage;	
	public $ext;	
	public $size;	
	public $absolutepath;	
	public $relativepath;	
	public $created;	
	public $modified;
	
	public function __construct($name,$showname,$showimage,$ext,$size,$absolutepath,$relativepath,$created,$modified)
    {
        $this->name = $name;
		$this->showname = $showname;
		$this->showimage = $showimage;
		$this->ext = $ext;
		$this->size = $size;
		$this->absolutepath = $absolutepath;
		$this->relativepath = $relativepath;
		$this->created = date('d.m.Y H:i:s', $created);
		$this->modified = date('d.m.Y H:i:s', $modified);
		
    }	
};
class Folder{
	public $name;		
	public $absolutepath;	
	public $relativepath;		
	public $created;	
	public $modified;
	
	public function __construct($name,$absolutepath,$relativepath,$created,$modified)
    {
        $this->name = $name;
		$this->absolutepath = $absolutepath;
		$this->relativepath = $relativepath;
		$this->created = date('d.m.Y H:i:s', $created);
		$this->modified = date('d.m.Y H:i:s', $modified);
		
    }		
};
class Documents
{
    public function __construct($id)
    {
        $this->id = $id;
    }
	
	public static function getDirectory($path){
		/*
		*	vraca sve foldere i fajlove za prosledjeni direktorujum
		*/
		$pathraw = $path;
		$path = rawurldecode($path);
		
		global $system_conf, $user_conf, $theme_conf;
		$filecont = array();
		$dircont = array();
	
		if(Documents::isDirectoryValid($path)){
			$results = scandir(BASE_PATH.BASE_SUBPATH.'/'.$user_conf["documents_root"][1].'/'.$path);
			$localpath = BASE_PATH.BASE_SUBPATH.'/'.$user_conf["documents_root"][1].'/'.$path; 
			foreach ($results as $result) {
				$showimage = '';
				if ($result === '.' or $result === '..' or $result === 'big' or $result == 'medium' or $result == 'medium ' or $result === 'small' or $result === 'thumb') continue;
				
				if (is_dir($localpath .'/'. $result)) {
	
					$pathinfo = pathinfo($result);
					
					array_push($dircont, array(new Folder($pathinfo['filename'], $localpath .'/'. $result, $path.'/'.$result, filectime($localpath.'/'.$result), filemtime($localpath.'/'.$result))));

				}
				else{
					$pathinfo = pathinfo($result);
					
					$db = Database::getInstance();
        			$mysqli = $db->getConnection();
        			$mysqli->set_charset("utf8");
					
					$string = $mysqli->real_escape_string($user_conf["documents_root"][1].'/'.$pathraw.'/'.rawurlencode($result));
					
					$q = "select d.*, dtr.showname as shownametr FROM documents d 
							LEFT JOIN documents_tr dtr ON d.id = dtr.documentsid WHERE dtr.langid = ".$_SESSION['langid'] ." AND d.link = '".(rawurlencode($string))."'";
							
					$res= $mysqli->query($q);
					
					$showname = "";
					$showimage = "";
					$name = $pathinfo['filename'];
					if($res->num_rows > 0){
						$row = $res->fetch_assoc();
						$showname = $row['showname'];
						$showimage = $row['image'];
						if($row['shownametr'] != "" && $row['shownametr'] != NULL){
							$showname = $row['shownametr'];
						}
						if($showimage == "" OR $showimage == NULL){
							$showimage = $system_conf["theme_path"][1].$theme_conf["no_img"][1];
						}
					}
					if($showimage == "" OR $showimage == NULL){
						$showimage = $system_conf["theme_path"][1].$theme_conf["no_img"][1];
					}
					array_push($filecont, array(new File($pathinfo['filename'], $showname, $showimage, $pathinfo['extension'], filesize($localpath .'/'. $result), $localpath .'/'. $result, $path.'/'.$result, filectime($localpath.'/'.$result), filemtime($localpath.'/'.$result))	));
				}
			}
		}else{
			echo "error";
			/* error	*/
		}
		
		return array($dircont, $filecont);
	}
	
	
	
	public static function isDirectoryValid($path){
		global $user_conf;
		//echo BASE_PATH.BASE_SUBPATH.DIRECTORY_SEPARATOR.$system_conf["documents_root"][1].DIRECTORY_SEPARATOR.$path;
		return is_dir(BASE_PATH.BASE_SUBPATH.DIRECTORY_SEPARATOR.$user_conf["documents_root"][1].DIRECTORY_SEPARATOR.$path);
	}
}
?>