<?php
$class_version["javne"] = array('class', '1.0.0.0.1', 'Nema opisa');

class Javneitem{
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

class Javne
{
    public $id;
    public $number;
    public $predmet;
    public $vrsta;
	public $items;

    public function __construct($id, $number,$predmet, $vrsta, $items)
    {
        $this->id = $id;
        $this->number = $number;
        $this->predmet = $predmet;
        $this->vrsta = $vrsta;
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
		global $theme_conf;
				
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");

        $data=array();
        $datacont=array();

		$querylimit = '';
        if($limit != 0 && $theme_conf["show_all_javne"]['1'] != 1){
            $start = ($page - 1) * $limit;
            $end = $limit;
            $querylimit = " LIMIT ".$start.", ".$end;
        }

        if($sort)
        {
            $sortingString=" ORDER BY j.`adddate` DESC" ;
        }else{
            $sortingString=" ORDER BY j.`adddate` ASC" ;
        }
		
		$lang = " and ntr.langid =". $_SESSION['langid'];
		if($theme_conf["search_all_lang"][1] == 1){
			$lang = "";	
		}
		
		$yearlimit = "";
		if($theme_conf["separate_per_year_javne"]['1'] == 1){
			$yearlimit = " AND adddate between '".$year."-00-00 00:00:00' AND '".($year+1)."-00-00 00:00:00' "; 	
		}
		
        $q="SELECT SQL_CALC_FOUND_ROWS j.id, j.number, j.predmet, j.vrsta, j.adddate, jtr.number as numbertr, jtr.predmet as predmettr, jtr.vrsta as vrstatr FROM javne j
            LEFT JOIN javne_tr jtr ON j.id = jtr.javneid
            WHERE j.status = 'v' ".$yearlimit." AND (jtr.langid =". $_SESSION['langid']. " OR jtr.langid is null)" . $sortingString . $querylimit;
        $res= $mysqli->query($q);
		
		$sQuery = "SELECT FOUND_ROWS()";
		$sRe = $mysqli->query($sQuery);
		$aRe = $sRe->fetch_array();
		$foundproducts = $aRe[0];
				
        if($res->num_rows > 0)
        {
          while($data=$res->fetch_assoc())
          {
			  $number = $data['number'];
			  if($data['numbertr'] != NULL && $data['numbertr'] != "" ) $number = $data['numbertr'];
			  
			  $predmet = $data['predmet'];
			  if($data['predmettr'] != NULL && $data['predmettr'] != "" ) $predmet = $data['predmettr'];
			  
			  $vrsta = $data['vrsta'];
			  if($data['vrstatr'] != NULL && $data['vrstatr'] != "" ) $vrsta = $data['vrstatr'];
			  
              $datacont[] = new Javne($data['id'], $number, $predmet, $vrsta, Javne::getJavne($data['id']));
          }
        }

        return array($foundproducts, $datacont);
    }
	
	public static function getJavne($id){
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		$data = array();
		
		$q = "SELECT ji.*, jitr.value as valuetr FROM javneitem ji 
		LEFT join javneitem_tr jitr ON ji.id = jitr.javneitemid
		WHERE (jitr.langid =". $_SESSION['langid']. " OR jitr.langid is null) AND ji.javneid=".$id." ORDER BY position ASC, active DESC";
		$res = $mysqli->query($q);

		while($row = $res->fetch_assoc()){
			$value = $row['value'];
			if($row['valuetr'] != NULL){
				$value = $row['valuetr'];
			}
			array_push($data, new Javneitem($value, $row['position'], $row['adddate'], $row['active']));	
		}
		
		return $data;
	}
	
	public static function allYearList($sort = true){
		
		/*
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
		
		$q="SELECT DISTINCT YEAR(adddate) as year FROM javne ".$sortingString;
        $res= $mysqli->query($q);
		while ($row = $res->fetch_assoc()) {
			array_push($datacont, $row['year']);	
		}
		
		return $datacont;
		
	}
}
?>