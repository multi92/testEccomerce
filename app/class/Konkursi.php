<?php
$class_version["konkursi"] = array('class', '1.0.0.0.2', 'Nema opisa');

class Konkursitem{
	public $value;
	public $position;
	public $adddate;
	public $active;	
	
	public function __construct($value, $position,$adddate, $active)
    {
        $this->value = $value;
        $this->position = $position;
        $this->adddate = $adddate;
        $this->active = $active;
    }
}

class Konkursi
{
    public $id;
    public $number;
    public $position;
    public $name;
	public $adddate;
	public $expiredate;
	public $items;

    public function __construct($id, $number,$position, $name, $adddate, $expiredate, $items)
    {
        $this->id = $id;
        $this->number = $number;
        $this->position = $position;
        $this->name = $name;
		$this->adddate = $adddate;
		$this->expiredate = $expiredate;
		$this->items = $items;
    }
	
	public static function getList($year, $page = 1, $limit = 0, $sort=true)
    {
		/**
		*	page - trenutna strana pocinje od 1
		*	limit - broj vesti po stranici
		*	sort - nacin sortiranja - true adddate DESC, false = adddate ASC
		*	year - grupisanje po godini - 1 - grupise, 0 - ne grupise 
		*/
		global $user_conf;
				
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        $data=array();
        $datacont=array();

		$querylimit = '';
        if($limit != 0 && $user_conf["show_all_konkursi"]['1'] != 1){
            $start = ($page - 1) * $limit;
            $end = $limit;
            $querylimit = " LIMIT ".$start.", ".$end;
        }

        if($sort)
        {
            $sortingString=" ORDER BY k.`adddate` DESC" ;
        }else{
            $sortingString=" ORDER BY k.`adddate` ASC" ;
        }
		
		$lang = " and ntr.langid =". $_SESSION['langid'];
		if($user_conf["search_all_lang"][1] == 1){
			$lang = "";	
		}
		
		$yearlimit = "";
		if($user_conf["separate_per_year_kokursi"]['1'] == 1){
			$yearlimit = " AND adddate between '".$year."-00-00 00:00:00' AND '".($year+1)."-00-00 00:00:00' "; 	
		}
		
        $q="SELECT SQL_CALC_FOUND_ROWS k.id, k.number, k.position, k.name, DATE_FORMAT(k.adddate,'%d.%m.%Y %T') as adddate, DATE_FORMAT(k.expiredate,'%d.%m.%Y %T') as expiredate FROM konkursi k
            WHERE k.status = 'v' ".$yearlimit." " . $sortingString . $querylimit;
        $res= $mysqli->query($q);
		
		$sQuery = "SELECT FOUND_ROWS()";
		$sRe = $mysqli->query($sQuery);
		$aRe = $sRe->fetch_array();
		$foundproducts = $aRe[0];
				
        if($res->num_rows > 0)
        {
          while($data=$res->fetch_assoc())
          {
              $datacont[] = new Konkursi($data['id'], $data['number'], $data['position'], $data['name'], $data['adddate'], $data['expiredate'], Konkursi::getKonkurs($data['id']));
          }
        }

        return array($foundproducts, $datacont);
    }
	
	public static function getKonkurs($id){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$data = array();
		
		$q = "SELECT ki.* FROM konkursiitem ki 
		WHERE ki.konkursiid=".$id." ORDER BY position, active ASC";
		$res = $mysqli->query($q);

		while($row = $res->fetch_assoc()){
			$value = $row['value'];
			
			array_push($data, new Konkursitem($value, $row['position'], $row['adddate'], $row['active']));	
		}
		
		return $data;
	}
	
	public static function allYearList($sort = true){
		
		/**
		*	sort - nacin sortiranja - true adddate DESC, false = adddate ASC
		*/
		
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");	

		$datacont = array();
		
		if($sort)
        {
            $sortingString=" ORDER BY `year` DESC" ;
        }else{
            $sortingString=" ORDER BY `year` ASC" ;
        }		
		
		$q="SELECT DISTINCT YEAR(adddate) as year FROM konkursi ".$sortingString;
        $res= $mysqli->query($q);
		while ($row = $res->fetch_assoc()) {
			array_push($datacont, $row['year']);	
		}
		
		return $datacont;
		
	}
}
?>