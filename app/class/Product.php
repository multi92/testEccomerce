<?php
$class_version["product"] = array('module', '1.0.0.0.1', 'Nema opisa');

class ProductSmall{
	public $id;
	public $code;
	public $barcode;
	public $image;
	public $name;
	public $categorypath;
	public $productlink;
	public $price;
	public $rebate;
	public $tax;
	public $amount;
	public $extradetail;
	public $visibleprice;
	public $pricevisibility;
	public $haveattr;
	public $desc;
	public $type;
	public $actionrebate;
	public $attr;
	public $quantityrebate;
	public $maxrebate;
	public $brendid;
	public $brendname;
	public $brendhasimage;
	public $brendimage;
	public $unitname;
	public $unitstep;

	public function __construct($id, $code, $barcode, $image, $name, $categorypath, $productlink, $price, $rebate, $tax, $amount, $extradetail, $visibleprice, $pricevisibility, $haveattr, $desc, $type, $actionrebate, $attr, $quantityrebate, $maxrebate, $brendid, $brendname, $brendhasimage,  $brendimage, $unitname,$unitstep){
		$this->id = $id;
		$this->code = $code;
		$this->barcode = $barcode;
		$this->image = $image;
		$this->name = $name;
		$this->categorypath = $categorypath;
		$this->productlink = $productlink;
		$this->price = $price;
		$this->rebate = $rebate;
		$this->tax = $tax;
		$this->amount = $amount;
		$this->extradetail = $extradetail;
		$this->visibleprice = $visibleprice;
		$this->pricevisibility = $pricevisibility;
		$this->haveattr = $haveattr;
		$this->desc = $desc;
		$this->type = $type;
		$this->actionrebate = $actionrebate;
		$this->attr =$attr;
		$this->quantityrebate =$quantityrebate;
		$this->maxrebate =$maxrebate;
		$this->brendid =$brendid;
		$this->brendname =$brendname;
		$this->brendhasimage =$brendhasimage;
		$this->brendimage =$brendimage;
		$this->unitname =$unitname;
		$this->unitstep =$unitstep;
	}
}

class ProductOG extends Product{

	public $id;
	public $code;
	public $pictures;
	public $name;
	public $nametr;
	public $type;
	public $categoryId;
	public $categorypath;
	public $productlink;
	public $description;
	public $unitname;
	public $unitstep;

	public function __construct($id){
		$this->id = $id;
		$data = self::getData();
		$this->id = $data['id'];
		$this->code = $data['code'];
		$this->pictures = self::getPicturesWithAttributesValue();
		$this->name = $data['name'];
		$this->nametr = $data['nametr'];
		$this->type = $data['type'];
		$this->categoryId = $data['categoryid'];
		$this->categorypath = Category::getCategoryPath($this->categoryId);
		$detaildata = self::getDescription();
		$this->description = $detaildata['description'];
		$this->unitname = $data['unitname'];
		$this->unitstep = $data['unitstep'];
		}
}

class Product{

	public $id;
	public $code;
	public $barcode;
	public $image;
	public $name;
	public $nametr;
	public $type;
	public $categorypath;
	public $productlink;
	public $price;
	public $rebate;
	public $tax;
	public $extradetail;
	public $manufname;
	public $amount;
	public $description;
	public $attrs;
	public $pictures;
	public $pricevisible;
	public $pricevisibility;
	public $haveAttr;
	public $active;
	public $relations;
	public $simularprod;
	public $watched;
	public $documents;
	public $videos;
	public $quantityrebate;
	public $brendid;
	public $brendname;
	public $brendhasimage;
	public $brendimage;
	public $unitname;
	public $unitstep;
	
	public function __construct($id){
		$this->id = $id;
		$data = self::getData();
		$this->id = $data['id'];
		$this->manufname = $data['manufname'];
		$this->active = $data['active'];
		$this->code = $data['code'];
		$this->name = $data['name'];
		$this->nametr = $data['nametr'];
		$this->type = $data['type'];
		$this->amount = $data['amount'];
		$this->categoryId = $data['categoryid'];
		$this->categorypath = Category::getCategoryPath($this->categoryId);
		$this->pricevisible = $data['pricevisible'];
		$this->pricevisibility = $data['pricevisibility'];
		$this->barcode = $data['barcode'];
		//ubaciti sve pa jedno po jedno
		
		$detaildata = self::getDescription();
		$this->description = $detaildata['description'];
		$this->characteristics = $detaildata['characteristics'];
		$this->specification = $detaildata['specification'];
		$this->model = $detaildata['model'];
		
		$ptr = Product::getProductPrice($id);
		$this->price = $ptr['price'];
		$this->tax = $ptr['tax'];
		$this->rebate = $ptr['rebate'];
		$this->actionrebate = $ptr['actionrebate'];
		$this->productlink = $this->categorypath.DIRECTORY_SEPARATOR.$id.'-'.rawurlencode($this->name);
		$this->haveAttr = Product::haveAttr($id);
		$this->pictures = self::getPicturesWithAttributesValue();
//		$this->pictures = self::getPictures();
		$this->attrs = self::getAttributes($this->id);
//		var_dump($this->attrs[0]);
		$this->extradetail = self::getExtraDetails();
		$this->documents = self::getProductFiles('doc');
		$this->videos = self::getProductFiles('yt');
		$this->quantityrebate =self::getProductQuantityRebate($id);
		$this->brendid = $data['brendid'];
		$this->brendname = $data['brendname'];
		$this->brendhasimage = $data['brendhasimage'];
		$this->brendimage = $data['brendimage'];
		$this->unitname = $data['unitname'];
		$this->unitstep = $data['unitstep'];
		$this->relations = self::getRelations();
		for($i = 0; $i < count($this->relations); $i++){
			
			$this->relations[$i]['prodata'] = array();
			$this->relations[$i]['prodata'] = Category::getCategoryProductDetail($this->relations[$i]['prodid'],1,1000,'','ASC','code',false,'','',3);
			$this->relations[$i]['prodata'] = array_slice($this->relations[$i]['prodata'], 0, 4);		
		}
//		$this->simularprod = Category::getCategoryProduct($this->categoryId, 1, 16, '', '', 'random', true, array(), false, array(), '', '');
		$this->simularprod = Category::getCategoryProductDetail(Category::getCategoryProduct($this->categoryId),1,16,'','ASC','random'); 
		$this->watched = 'napraviti';
	}

	protected function getDescription(){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$data = array();

		//pogledati slucaj kod proizvoda koji nemaju sve u productdetail_tr
		$query = "SELECT pd.description as description, pdtr.description as descriptiontr,
						pd.characteristics as characteristics, pdtr.characteristics as characteristicstr,
						pd.specification as specification, pdtr.specification as specificationtr,
						pd.model as model, pdtr.model as modeltr FROM product as p
					LEFT JOIN productdetail as pd ON p.id = pd.productid
					LEFT JOIN productdetail_tr as pdtr ON p.id = pdtr.productid
					WHERE p.id = ".$this->id." and (pdtr.langid = ".$_SESSION['langid']." OR pdtr.langid IS NULL)";
		
		$res = $mysqli->query($query);
		if($res->num_rows > 0){
			$row = $res->fetch_assoc();
			$data['description'] = $row['description'];
			$data['characteristics'] = $row['characteristics'];
			$data['specification'] = $row['specification'];
			$data['model'] = $row['model'];
			
			if($row['descriptiontr'] != '' && $row['descriptiontr'] != NULL){
				$data['description'] = $row['descriptiontr'];
			}
			if($row['characteristicstr'] != '' && $row['characteristicstr'] != NULL){
				$data['characteristics'] = $row['characteristicstr'];
			}
			if($row['specificationtr'] != '' && $row['specificationtr'] != NULL){
				$data['specification'] = $row['specificationtr'];
			}
			if($row['modeltr'] != '' && $row['modeltr'] != NULL){
				$data['model'] = $row['modeltr'];
			}
		}

		return $data;

	}
	public static function getDescriptiontest($id){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$description = '';

		//pogledati slucaj kod proizvoda koji nemaju sve u productdetail_tr
		$query = "SELECT pd.description as description, pdtr.description as descriptiontr FROM product as p
					LEFT JOIN productdetail as pd ON p.id = pd.productid
					LEFT JOIN productdetail_tr as pdtr ON p.id = pdtr.productid
					WHERE p.id = ".$id." and pdtr.langid = ".$_SESSION['langid'];
		$res = $mysqli->query($query);
		if($res->num_rows > 0){
			$row = $res->fetch_assoc();
			$description = $row['discription'];
			if($row['descriptiontr'] != '' && $row['descriptiontr'] != NULL){
				$description = $row['descriptiontr'];
			}
		}

		return $description;
	}
	
	/**
	 * @param $proid
	 * @return array{productid, price, rebate, multiplayer, tax}
     */
	public static function getProductPrice($proid){
		global $user_conf;
		
		$db = Database::getInstance();
        $mysqli = $db->getConnection();
        $mysqli->set_charset("utf8");
		
		if(isset($_SESSION['shoptype']) && $_SESSION['shoptype'] == "b2b"){
			$action_rebate_string = '((100-p.rebate)/100) * ';
			$web_rebate_string = '((100-'.intval($user_conf["webrebate"][1]).')/100) * ';
			$rebate_string = "CASE
								WHEN plih.rebate > '' THEN ((100-plih.rebate)/100)
								WHEN pli.rebate > '' THEN ((100-pli.rebate)/100)
								ELSE  
									CASE
										WHEN getRebateFunc(pc.categoryid, pac.partnerid) > '' THEN ((100-getRebateFunc(pc.categoryid, pac.partnerid))/100)
										WHEN getPartnerRebate(".$_SESSION['partnerid'].") > '' THEN ((100-getPartnerRebate(".$_SESSION['partnerid']."))/100)
										ELSE 0
									END 
							END * ";
			$tmpstring2 = '';
			if($user_conf["act_priority"][1] == 1){
				// action only
				if($user_conf["combine_act_web"][1] == 1){
					// action + web 
					$tmpstring = $action_rebate_string . $web_rebate_string;
					$tmpstring2 = $web_rebate_string;
				}else{
					// action	
					$tmpstring = $action_rebate_string;
				}
			}
			else{
				if($user_conf["combine_act_web"][1] == 1){
					// action + web + (plih.rebate > pl.rebate > pc.rebate > p.rebate	)
					$tmpstring = $action_rebate_string . $web_rebate_string . $rebate_string;
					$tmpstring2 = $web_rebate_string;
				}else{
					// action + (plih.rebate > pl.rebate > pc.rebate > p.rebate	)
					$tmpstring = $action_rebate_string . $rebate_string;
				}
			}
			
			$tmpstring = substr($tmpstring, 0, -3);
			$tmpstring2 .= $rebate_string;
			$tmpstring2 = substr($tmpstring2,0,-3);
			
			$q = "SELECT p.id, 
				p.code, 
				p.barcode, 
				p.name, 
				ptr.name as nametr, 
				p.rebate as actionrebate,
				getDefaultImage(p.id) as defaultimage, 
				getProductPriceWithMargin(p.id, ".$_SESSION['warehouseid'].") as pwprice , 
				t.value, 
				pd.maxrebate as maxrebate, 
				pli.rebate as pricelistrebate,
				pli.price as pricelistprice, 
				plih.rebate as inheritedrebate,
				plih.price as inheritedprice,
				getPartnerRebate(".$_SESSION['partnerid'].") as parrebate, 
				getRebateFunc_external(pc.categoryid, pac.partnerid) as catparrebate ,
				CASE
					WHEN p.rebate > 0 THEN
						/*	rabate politic	*/
						CASE
							WHEN ( ".$tmpstring." ) < ((100-IFNULL(pd.maxrebate,0))/100) THEN  ".$tmpstring."
							ELSE ((100-IFNULL(pd.maxrebate,0))/100)
						END	
						/*	end rabate politic	*/	
					ELSE	
						/*  proizvod nema akciju	*/
						CASE 
							WHEN( " .$tmpstring2." ) > ((100-IFNULL(pd.maxrebate,0))/100) THEN ((100-IFNULL(pd.maxrebate,0))/100)
							ELSE ( " .$tmpstring2.")
						END
				END as umnozak,
				(pw.price*(1+(t.value/100))) * 
				CASE
					WHEN p.rebate > 0 THEN
						/*	rabate politic	*/
						CASE
							WHEN ( ".$tmpstring." ) < ((100-IFNULL(pd.maxrebate,0))/100) THEN  ((100-IFNULL(pd.maxrebate,0))/100)
							ELSE ".$tmpstring."
						END	
						/*	end rabate politic	*/	
					ELSE	
						/*  proizvod nema akciju	*/
						CASE 
							WHEN( " .$tmpstring2." ) > ((100-IFNULL(pd.maxrebate,0))/100) THEN ((100-IFNULL(pd.maxrebate,0))/100)
							ELSE ( " .$tmpstring2.")
						END
				END as totalprice_pdv
			FROM product p
			LEFT JOIN product_tr ptr ON p.id = ptr.productid
			LEFT JOIN productdetail pd ON p.id = pd.productid
			LEFT JOIN productdetail_tr pdtr ON pd.productid = pdtr.productid
			LEFT JOIN product_file pf ON p.id = pf.productid
			LEFT JOIN productwarehouse pw ON p.id = pw.productid
			LEFT JOIN tax t ON p.taxid = t.id		
			LEFT JOIN productcategory pc ON p.id = pc.productid
			LEFT JOIN partnercategory pac ON pc.categoryid = pac.categoryid AND (pac.partnerid = ".$_SESSION['partnerid']." OR pac.partnerid IS NULL)  
			 
			LEFT JOIN partnerpricelist ppl ON  ppl.partnerid = ".$_SESSION['partnerid']."
			LEFT JOIN pricelist AS pl ON ppl.pricelistid=pl.id AND pl.status='v'
			LEFT JOIN pricelistitem pli ON pl.id=pli.pricelistid AND p.id = pli.productid 
			LEFT JOIN pricelistinherited plih ON p.id = plih.productid AND plih.partnerid = ".$_SESSION['partnerid']."
			WHERE pw.warehouseid = ".$_SESSION['warehouseid']."
			AND p.id IN (".$proid.") 
			
			AND ((ptr.langid = ". $_SESSION['langid']. " OR ptr.langid IS NULL) AND (pdtr.langid = ". $_SESSION['langid']. " OR pdtr.langid is NULL))
			
			
			GROUP BY p.id";
		}
		else{
			/*	-----------------------  B2C  --------------------------	*/	
			
			if($user_conf["combine_act_web"][1] == '1'){
				$pricetype = '( ((100-p.rebate)/100) * ((100-'.intval($user_conf["webrebate"][1]).')/100) )';	
			}
			else{
				$pricetype = ' 1-(p.rebate/100) ';	
			}
			
			$q = "SELECT SQL_CALC_FOUND_ROWS p.id,
			 p.code, 
			 p.barcode, 
			 p.name, 
			 getDefaultImage(p.id) as defaultimage,
			 ptr.name as nametr, 
			 p.rebate as actionrebate, 
			 getProductPriceWithMargin(p.id, ".$_SESSION['warehouseid'].") as pwprice,
			 t.value, 
			 pd.maxretailrebate as maxrebate, 
				CASE 
					WHEN ".$pricetype." < 1-(pd.maxretailrebate/100) THEN 1-(pd.maxretailrebate/100)
					ELSE ".$pricetype."
				END as umnozak,
				(pw.price*(1+(t.value/100))) * CASE 
					WHEN ".$pricetype." < 1-(pd.maxretailrebate/100) THEN 1-(pd.maxretailrebate/100)
					ELSE ".$pricetype."
				END as totalprice_pdv
				 
			FROM product p
			LEFT JOIN product_tr ptr ON p.id = ptr.productid
			LEFT JOIN productdetail pd ON p.id = pd.productid
			LEFT JOIN productdetail_tr pdtr ON pd.productid = pdtr.productid
			LEFT JOIN product_file pf ON p.id = pf.productid
			LEFT JOIN productwarehouse pw ON p.id = pw.productid
			LEFT JOIN tax t ON p.taxid = t.id
			WHERE 
				pw.warehouseid = ".$_SESSION['warehouseid']." AND 
				p.id IN (".$proid.")
				AND
				((ptr.langid = ". $_SESSION['langid']. " OR ptr.langid IS NULL) AND (pdtr.langid = ". $_SESSION['langid']. " OR pdtr.langid is NULL))
			 GROUP BY p.id  "; 
		}
		
		//$tmpres = $mysqli->query("SET @@sql_mode = ''");
		$tmpres = $mysqli->query("SET @@SESSION.max_sp_recursion_depth = 255");
		
		$data = array();
		$res = $mysqli->query($q);
		if($res->num_rows > 0){
			$row = $res->fetch_assoc();
			$data['id'] = $row['id'];
			$data['price'] = $row['pwprice']/floatval($_SESSION["currencyvalue"]);
			$data['rebate'] = ($row['umnozak'] == 0)? 0:((1-$row['umnozak'])*100);
			$data['actionrebate'] = $row['actionrebate'];
			$data['umnozak'] = $row['umnozak'];
			$data['tax'] = $row['value'];
		}
		//var_dump($data['price']);
		return $data;
	}

	/** stara funkicja bez (katalog)*/
	public static function get_price_tax_rebate($proid)
	{
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");


		global $user_conf;

		global $b2b_warehouse, $b2b_action_priority, $b2b_price_pdv, $b2b_show_action_rebate;

		global $b2c_warehouse, $b2c_action_priority;

		global $web_global_rebate;

		global $command;

		$b2c_warehouse = $user_conf['b2cwh'][1];
		$b2b_warehouse = $user_conf['b2bwh'][1];
		$b2b_action_priority = $user_conf['combine_act_web'][1] ? 'n' : 'y';
		$b2b_price_pdv = $user_conf['b2b_price_pdv'][1] ? 'y' : 'n';
		$b2b_show_action_rebate = $user_conf['b2b_show_action_rebate'][1] ? 'y' : 'n';
		$web_global_rebate = $user_conf['webrebate'][1];
		//testirati prvo ovako a zatim prepraviti kod kad proradi

		$warehouse = $b2c_warehouse;
		$max_rebate_string = 'maxretailrebate';
		$b2b = false;
		$rebate = 0;
//		$userType = Helper::GetUserType();//return 'b2b' or 'b2c' string
		$userType = $_SESSION['shoptype'] != '' ? $_SESSION['shoptype'] : 'b2c';

		if ($userType == 'b2b') {
			$warehouse = $b2b_warehouse;
			$max_rebate_string = 'maxrebate';
			$b2b = true;
		}
		$query = "SELECT pw.price, p.rebate, pd.maxrebate, pd.maxretailrebate, t.value
                  FROM product as p
                  LEFT JOIN productwarehouse as pw
                  ON p.id = pw.productid
                  LEFT JOIN productdetail as pd
                  ON p.id = pd.productid
                  LEFT JOIN tax as t ON p.taxid = t.id
                  WHERE p.id = " . $proid . " AND pw.warehouseid = " . $warehouse . " AND p.active = 'y'";

		$res = $mysqli->query($query);
		$row = $res->fetch_assoc();
		$price = $row['price'];
		$tax = $row['value'];
		$pdv_n=$row['value'];
		$actionrebate = $row['rebate'];
		$maxrebate = ($row[$max_rebate_string] == 0 ? 100 : $row[$max_rebate_string]);

		if ($b2b) {
			$super_cat_ids = self::get_super_categories_ids($proid);
			$query = "SELECT  pc.rebatepercent as catrebate, pc.categoryprid as category
                        FROM partner as p
                        LEFT JOIN partnercategorypr as pc ON p.partnerid = pc.partnerid
                        WHERE p.partnerid = (SELECT partnerid FROM user WHERE ID =" . $_SESSION['id'] . ")
                        AND pc.categoryprid IN (" . implode(",", $super_cat_ids) . ")";

			$q1="select  p.rebatepercent as parrebate from partner as p WHERE p.partnerid = (SELECT partnerid FROM user WHERE ID =" . $_SESSION['id'] . ")";
			$re = $mysqli->query($query);
			$tmp = array();
			if ($re) {
				while ($row = $re->fetch_assoc()) {
					array_push($tmp, $row);
				}
			}

			$partnerrebate = 0;
			$q1Res=$mysqli->query($q1);
			if($q1Res)
			{
				$row=$q1Res->fetch_assoc();
				$partnerrebate = $row['parrebate'] == null ? 0 : $row['parrebate'];
			}

			$partnercatrebate = 0;
			/*nikola dodao break flag da bi se prekinula prva petlja kad se nadje pravi rabat.
             u suprotnom uzima rabat nadkategorije*/
			$break=0;
			if (count($tmp) > 0) {
				for ($i = 0; $i < count($super_cat_ids); $i++) {
					for ($j = 0; $j < count($tmp); $j++) {
						if ($super_cat_ids[$i] == $tmp[$j]['category']) {
							//$partnerrebate = $tmp[$j]['parrebate'] == null ? 0 : $tmp[$j]['parrebate'];
							$partnercatrebate = $tmp[$j]['catrebate'] == null ? 0 : $tmp[$j]['catrebate'];
							$break=1;
							break;
						}
					}
					if($break==1)
					{
						break;
					}
				}
			}

			if ($b2b_price_pdv != "y")
				$tax = 0;
			$rebate = $actionrebate;
			if ($b2b_show_action_rebate != "y") {
				$rebate = 0;
			}
			if ($b2b_action_priority != "y") {
				$b2b_rebate = 0;
				if ($partnercatrebate > 0) {
					$b2b_rebate = $partnercatrebate;
				} elseif ($partnerrebate > 0) {
					$b2b_rebate = $partnerrebate;
				}
				$rebate = ($b2b_rebate + $rebate) - (($b2b_rebate * $rebate) / 100);
			}
		} else {
			$rebate = ($web_global_rebate + $actionrebate) - (($web_global_rebate * $actionrebate) / 100);
		}
		$rebate = min($rebate, $maxrebate);
		return array("price" => $price, "tax" => $tax, "rebate" => $rebate,"real_tax"=>$pdv_n);
	}
	protected function getData(){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		global $user_conf, $system_conf, $theme_conf;
		$userType = isset($_SESSION['shoptype']) && $_SESSION['shoptype'] != '' ? $_SESSION['shoptype'] : 'b2c';
		$warehouse = $user_conf['b2cwh'][1];
		if($userType == 'b2b'){
			$warehouse = $user_conf['b2bwh'][1];
		}
	
		/*if($system_conf["category_type"][1] == '1'){
			// aktivne relacije	
			$query = "SELECT p.id, p.barcode, p.manufname, p.active, p.code, p.name, ptr.name as nametr, p.type, pw.amount, ce.categoryid, p.brendid, br.name as brendname, brtr.name as brendnametr, br.image as brendimage, p.unitname, ptr.unitname as unitnametr, p.unitstep, p.pricevisibility
				FROM product as p
				LEFT JOIN productwarehouse as pw
				ON p.id = pw.productid
				LEFT JOIN tax as t ON p.taxid = t.id
				LEFT JOIN productcategory as pcat ON p.id = pcat.productid
				LEFT JOIN category_external ce ON pcat.categoryid = ce.id
				LEFT JOIN product_tr as ptr ON p.id = ptr.productid
				LEFT JOIN brend AS br ON p.brendid=br.id
				LEFT JOIN brend_tr AS brtr ON p.brendid=brtr.brendid
				WHERE p.id = ".$this->id."
				AND pw.warehouseid = ".$warehouse." AND  p.active = 'y' AND pw.price > 0 AND (ptr.langid = ".$_SESSION['langid']." OR ptr.langid IS NULL ) AND (brtr.langid = ". $_SESSION['langid']. " OR brtr.langid is NULL ) ";
		}else{
			$query = "SELECT p.id, p.barcode, p.manufname, p.active, p.code, p.name, ptr.name as nametr, p.type, pw.amount, pcat.categoryid, p.brendid, br.name as brendname, brtr.name as brendnametr, br.image as brendimage, p.unitname, ptr.unitname as unitnametr, p.unitstep, p.pricevisibility
				FROM product as p
				LEFT JOIN productwarehouse as pw
				ON p.id = pw.productid
				LEFT JOIN tax as t ON p.taxid = t.id
				LEFT JOIN productcategory as pcat ON p.id = pcat.productid
				LEFT JOIN product_tr as ptr ON p.id = ptr.productid
				LEFT JOIN brend AS br ON p.brendid=br.id
				LEFT JOIN brend_tr AS brtr ON p.brendid=brtr.brendid
				WHERE p.id = ".$this->id."
				AND pw.warehouseid = ".$warehouse." AND  p.active = 'y'  AND (ptr.langid = ".$_SESSION['langid']." OR ptr.langid IS NULL ) AND (brtr.langid = ". $_SESSION['langid']. " OR brtr.langid is NULL ) ";	//exception uklonjen uslov AND pw.price > 0 jer dusanfashion nema cene na sajtu
		}*/
		
		/*if($system_conf["category_type"][1] == '1'){
			// aktivne relacije	
			$query = "SELECT p.id, p.barcode, p.manufname, p.active, p.code, p.name, ptr.name as nametr, p.type, pw.amount, ce.categoryid, p.brendid, br.name as brendname, brtr.name as brendnametr, br.image as brendimage, p.unitname, ptr.unitname as unitnametr, p.unitstep, p.pricevisibility
				FROM product as p
				LEFT JOIN productwarehouse as pw ON p.id = pw.productid
				LEFT JOIN tax as t ON p.taxid = t.id
				LEFT JOIN productcategory_external as pce ON p.id = pce.productid
				LEFT JOIN category_external ce ON pce.categoryid = ce.id
				LEFT JOIN product_tr as ptr ON p.id = ptr.productid
				LEFT JOIN brend AS br ON p.brendid=br.id
				LEFT JOIN brend_tr AS brtr ON p.brendid=brtr.brendid
				WHERE p.id = ".$this->id."
				AND pw.warehouseid = ".$warehouse." AND  p.active = 'y' AND pw.price > 0 AND (ptr.langid = ".$_SESSION['langid']." OR ptr.langid IS NULL ) AND (brtr.langid = ". $_SESSION['langid']. " OR brtr.langid is NULL ) ";
				//echo $query;
		}else{
			$query = "SELECT p.id, p.barcode, p.manufname, p.active, p.code, p.name, ptr.name as nametr, p.type, pw.amount, pcat.categoryid, p.brendid, br.name as brendname, brtr.name as brendnametr, br.image as brendimage, p.unitname, ptr.unitname as unitnametr, p.unitstep, p.pricevisibility
				FROM product as p
				LEFT JOIN productwarehouse as pw
				ON p.id = pw.productid
				LEFT JOIN tax as t ON p.taxid = t.id
				LEFT JOIN productcategory as pcat ON p.id = pcat.productid
				LEFT JOIN product_tr as ptr ON p.id = ptr.productid
				LEFT JOIN brend AS br ON p.brendid=br.id
				LEFT JOIN brend_tr AS brtr ON p.brendid=brtr.brendid
				WHERE p.id = ".$this->id."
				AND pw.warehouseid = ".$warehouse." AND  p.active = 'y'  AND (ptr.langid = ".$_SESSION['langid']." OR ptr.langid IS NULL ) AND (brtr.langid = ". $_SESSION['langid']. " OR brtr.langid is NULL ) ";	//exception uklonjen uslov AND pw.price > 0 jer dusanfashion nema cene na sajtu
				echo $query;
		}*/
		
		/*	DUAL CATEGORY ORIGIN	*/	
		$query = "SELECT p.id, p.barcode, p.manufname, p.active, p.code, p.name, ptr.name as nametr, p.type, pw.amount, IF(pc.categoryid IS NOT NULL, pc.categoryid, ce.categoryid) as categoryid, p.brendid, br.name as brendname, brtr.name as brendnametr, br.image as brendimage, p.unitname, ptr.unitname as unitnametr, p.unitstep, p.pricevisibility
				FROM product as p
				LEFT JOIN productwarehouse as pw
				ON p.id = pw.productid
				LEFT JOIN tax as t ON p.taxid = t.id
				LEFT JOIN productcategory AS pc ON p.id = pc.productid
				LEFT JOIN productcategory_external as pce ON p.id = pce.productid
				LEFT JOIN category_external ce ON pce.categoryid = ce.id
				LEFT JOIN product_tr as ptr ON p.id = ptr.productid
				LEFT JOIN brend AS br ON p.brendid=br.id
				LEFT JOIN brend_tr AS brtr ON p.brendid=brtr.brendid
				WHERE p.id = ".$this->id."
				AND pw.warehouseid = ".$warehouse." AND p.active = 'y' AND pw.price > 0 AND (ptr.langid = ".$_SESSION['langid']." OR ptr.langid IS NULL ) AND (brtr.langid = ". $_SESSION['langid']. " OR brtr.langid is NULL ) ";
				
		$res = $mysqli->query($query);
		if($res->num_rows > 0){
			$row = $res->fetch_assoc();
			//echo $row['brendname'];
			/*if($system_conf["category_type"][1] == '1'){
				// aktivne relacije	
				$query2 = "SELECT ce.categoryid, c.".$userType."visibleprice as pricevisible FROM productcategory as pc
						INNER JOIN category_external as ce ON pc.categoryid = ce.id
						LEFT JOIN category as c ON ce.categoryid = c.id WHERE pc.productid = ".$this->id." ORDER BY pc.categoryid DESC";
			}else{
				$query2 = "SELECT pc.categoryid, c.".$userType."visibleprice as pricevisible FROM productcategory as pc
						INNER JOIN category as c ON c.id = pc.categoryid WHERE pc.productid = ".$this->id." ORDER BY pc.categoryid DESC";
			}*/
			
			/*	DUAL CATEGORY ORIGIN	*/	
			
			$query2 = "SELECT c.".$userType."visibleprice as pricevisible  FROM (
						SELECT IF(pc.categoryid IS NOT NULL, pc.categoryid, ce.categoryid) as categoryid 
						FROM product p 
						LEFT JOIN productcategory as pc ON p.id = pc.productid
						LEFT JOIN productcategory_external as pce ON p.id = pce.productid
						LEFT JOIN category_external as ce ON ce.id = pce.categoryid 
						WHERE p.id = ".$this->id."
						) as t1
					LEFT JOIN category as c ON c.id = t1.categoryid 
					ORDER BY t1.categoryid DESC";
			
			$brendname=$row['brendname'];
			if($row['brendnametr'] != '' && $row['brendnametr'] != NULL){
				$brendname = $row['brendnametr'];
			}
			$row['brendname']=$brendname;
			$brendimage=$row['brendimage'];
			$brendhasimage=1;
			if($row['brendimage']==''){
				$brendimage=$system_conf["theme_path"][1].$theme_conf["no_img"][1];
				$brendhasimage=0;
			}
			$row['brendhasimage']=$brendhasimage;
			$row['brendimage']=$brendimage;

			$row['name'] = ($row['nametr'] != NULL)? $row['nametr']:$row['name'];
			$row['unitname'] = ($row['unitnametr'] != NULL)? $row['unitnametr']:$row['unitname'];
					
			$categories = array();

			$res2 = $mysqli->query($query2);
			$deep_category = 0;
			$price_visible = 1;
			if($res2->num_rows > 0){
				while($row2 = $res2->fetch_assoc()){
					array_push($categories, $row2['categoryid']);
					if($deep_category < $row2['categoryid']){
						$price_visible = $row2['pricevisible'];
					}
					$row['pricevisible'] = $price_visible;

					return $row;
				}
			}
		}
		else{
			return 0;
		}

	}

	public static function getProductDataById($productid){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		global $user_conf, $system_conf, $theme_conf;
		$userType = isset($_SESSION['shoptype']) && $_SESSION['shoptype'] != '' ? $_SESSION['shoptype'] : 'b2c';
		$warehouse = $user_conf['b2cwh'][1];
		if($userType == 'b2b'){
			$warehouse = $user_conf['b2bwh'][1];
		}

		if($system_conf["category_type"][1] == '1'){
			// aktivne relacije	
			$query = "SELECT p.id, p.barcode, p.manufname, p.active, p.code, p.name, ptr.name as nametr, p.type, pw.amount, ce.categoryid, p.brendid, br.name as brendname, brtr.name as brendnametr, br.image as brendimage, p.unitname, ptr.unitname as unitnametr, p.unitstep, p.taxid, t.value AS `taxvalue`, p.pricevisibility
				FROM product as p
				LEFT JOIN productwarehouse as pw
				ON p.id = pw.productid
				LEFT JOIN tax as t ON p.taxid = t.id
				LEFT JOIN productcategory as pcat ON p.id = pcat.productid
				LEFT JOIN category_external ce ON pcat.categoryid = ce.id
				LEFT JOIN product_tr as ptr ON p.id = ptr.productid
				LEFT JOIN brend AS br ON p.brendid=br.id
				LEFT JOIN brend_tr AS brtr ON p.brendid=brtr.brendid
				WHERE p.id = ".$productid."
				AND pw.warehouseid = ".$warehouse." AND  p.active = 'y' AND pw.price > 0 AND (ptr.langid = ".$_SESSION['langid']." OR ptr.langid IS NULL ) AND (brtr.langid = ". $_SESSION['langid']. " OR brtr.langid is NULL ) ";
		}else{
			$query = "SELECT p.id, p.barcode, p.manufname, p.active, p.code, p.name, ptr.name as nametr, p.type, pw.amount, pcat.categoryid, p.brendid, br.name as brendname, brtr.name as brendnametr, br.image as brendimage, p.unitname, p.unitstep,p.taxid, t.value AS `taxvalue`, p.pricevisibility
				FROM product as p
				LEFT JOIN productwarehouse as pw
				ON p.id = pw.productid
				LEFT JOIN tax as t ON p.taxid = t.id
				LEFT JOIN productcategory as pcat ON p.id = pcat.productid
				LEFT JOIN product_tr as ptr ON p.id = ptr.productid
				LEFT JOIN brend AS br ON p.brendid=br.id
				LEFT JOIN brend_tr AS brtr ON p.brendid=brtr.brendid
				WHERE p.id = ".$productid."
				AND pw.warehouseid = ".$warehouse." AND  p.active = 'y'  AND (ptr.langid = ".$_SESSION['langid']." OR ptr.langid IS NULL ) AND (brtr.langid = ". $_SESSION['langid']. " OR brtr.langid is NULL ) ";	//exception uklonjen uslov AND pw.price > 0 jer dusanfashion nema cene na sajtu
		}
		//echo $query;
		$res = $mysqli->query($query);
		if($res->num_rows > 0){
			$row = $res->fetch_assoc();
			//echo $row['brendname'];
			if($system_conf["category_type"][1] == '1'){
				// aktivne relacije	
				$query2 = "SELECT ce.categoryid, c.".$userType."visibleprice as pricevisible FROM productcategory as pc
						INNER JOIN category_external as ce ON pc.categoryid = ce.id
						LEFT JOIN category as c ON ce.categoryid = c.id WHERE pc.productid = ".$productid." ORDER BY pc.categoryid DESC";
			}else{
				$query2 = "SELECT pc.categoryid, c.".$userType."visibleprice as pricevisible FROM productcategory as pc
						INNER JOIN category as c ON c.id = pc.categoryid WHERE pc.productid = ".$productid." ORDER BY pc.categoryid DESC";
			}
			//echo $query2;
			$brendname=$row['brendname'];
			if($row['brendnametr'] != '' && $row['brendnametr'] != NULL){
				$brendname = $row['brendnametr'];
			}
			$row['brendname']=$brendname;
			$brendimage=$row['brendimage'];
			$brendhasimage=1;
			if($row['brendimage']==''){
				$brendimage=$system_conf["theme_path"][1].$theme_conf["no_img"][1];
				$brendhasimage=0;
			}
			$row['brendhasimage']=$brendhasimage;
			$row['brendimage']=$brendimage;

			
			$categories = array();

			$res2 = $mysqli->query($query2);
			$deep_category = 0;
			$price_visible = 0;
			//$price_visible = 1;

			if($res2->num_rows > 0){
				while($row2 = $res2->fetch_assoc()){
					array_push($categories, $row2['categoryid']);
					if($deep_category < $row2['categoryid']){
						$price_visible = $row2['pricevisible'];
					}
					$row['pricevisible'] = $price_visible;

					return $row;
				}
			} else {
				$row['pricevisible'] = $price_visible;

				return $row;
			}
		}
		else{
			return 0;
		}

	}

	public static function productQtyInCartCheckByProductId($productid)
    {
        
        $ret = 0;
        if(isset($_SESSION['shopcart']) && $_SESSION['shopcart']!=''){
        foreach($_SESSION['shopcart'] as $val){
            //echo $val['id'].'='.$productid.'   -----';
            //var_dump($val['attr']);var_dump($attr);
            if($val['id']==$productid ){
                $ret=true;
                    return $val['qty'];
            }
        }
        }

        return $ret;
    }

	public static function haveAttr($prodid){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$query = "select count(attrvalid) as num from attrprodval where productid = ".$prodid;
		if($res=$mysqli->query($query)){
			if($res->num_rows > 0){
				$r = $res->fetch_assoc();
				$r = $r['num'];
				if($r > 0){
					return true;
				}
			}
		}
		return false;
	}
	
	
	public function getPictures(){

		global $system_conf, $user_conf, $theme_conf;

		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$arrayimg = array();

		$q="select content,attrvalid,sort from product_file where productid=".$this->id." AND type = 'img' ORDER BY sort ASC";
		$res=$mysqli->query($q);

		if($res && $res->num_rows > 0)
		{
			while($img=$res->fetch_assoc())
			{
				$arrayimg[]=$img['content'];
			}

		}else{
			$arrayimg[]=$system_conf["theme_path"][1].$theme_conf["no_img"][1];
		}

		return $arrayimg;


	}
	public function getProductFiles($type){

		global $system_conf, $user_conf, $theme_conf;

		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$docarray = array();

		$q="select content, contentface,sort from product_file where productid=".$this->id." AND type = '".$type."' ORDER BY sort ASC";
		$res=$mysqli->query($q);

		if($res && $res->num_rows > 0)
		{
			while($docrow=$res->fetch_assoc())
			{
				$doc = array('content' => $docrow['content'], 'contentface' => $docrow['contentface']);
				if($doc['contentface'] == '' || $doc['contentface'] == NULL){
					$doc['contentface'] = $system_conf["theme_path"][1].$theme_conf["no_img"][1];
				}
				$docarray[]=$doc;
			}

		}
		return $docarray;
	}
	
	public static function getProductFilesByProductId($prodid, $type=''){

		global $system_conf, $user_conf, $theme_conf;

		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$docarray = array();

		$q="select content, contentface,sort, type, status from product_file where productid=".$prodid;
		if(isset($type) && $type!=''){
			$q.=" AND type = '".$type."'";
		}
		$q.=" ORDER BY sort ASC";
		$res=$mysqli->query($q);

		if($res && $res->num_rows > 0)
		{
			while($docrow=$res->fetch_assoc())
			{
				$doc = array('content' => $docrow['content'], 'contentface' => $docrow['contentface'], 'type' => $docrow['type'], 'status' => $docrow['status']);
				if($doc['contentface'] == '' || $doc['contentface'] == NULL){
					$doc['contentface'] = $system_conf["theme_path"][1].$theme_conf["no_img"][1];
				}
				$docarray[]=$doc;
			}

		}
		return $docarray;
	}

	/**
	 * @return array - niz slika proizvoda sa atributima ako je neki atribut vezan za tu sliku
     */
	public function getPicturesWithAttributesValue(){

		global $system_conf, $user_conf, $theme_conf;

		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$arrayimg = array();

		$q="select content,pf.attrvalid,sort, at.value from product_file as pf
left join attrval_tr as at on pf.attrvalid = at.attrvalid
where productid=".$this->id." and (langid = ".$_SESSION['langid']." or langid is NULL) and type = 'img' ORDER BY sort ASC, pf.id ASC";
		
		$res=$mysqli->query($q);

		if($res && $res->num_rows > 0)
		{
			while($img=$res->fetch_assoc())
			{
				$arrayimg[]=array('img'=>$img['content'], 'attrvalname'=>$img['value'], 'attrvalid'=>$img['attrvalid']);
			}
		}else{
			$arrayimg[]=array('img'=>$system_conf["theme_path"][1].$theme_conf["no_img"][1], 'attrvalname'=>'');
		}
		return $arrayimg;
	}

	public static function getPicturesWithAttributesValueByProductId($productId){

		global $system_conf, $user_conf, $theme_conf;

		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$arrayimg = array();

		$q="select content,pf.attrvalid,sort, at.value from product_file as pf
left join attrval_tr as at on pf.attrvalid = at.attrvalid
where productid=".$productId." and (langid = ".$_SESSION['langid']." or langid is NULL) and type = 'img' ORDER BY pf.id ASC, sort ASC";
		//echo $q;
		$res=$mysqli->query($q);

		if($res && $res->num_rows > 0)
		{
			while($img=$res->fetch_assoc())
			{
				$arrayimg[]=array('img'=>$img['content'], 'attrvalname'=>$img['value'], 'attrvalid'=>$img['attrvalid']);
			}
		}else{
			$arrayimg[]=array('img'=>$system_conf["theme_path"][1].$theme_conf["no_img"][1], 'attrvalname'=>'');
		}
		return $arrayimg;
	}
	
	public static function getProductQuantityRebate($prodid){

		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$docarray = array();


		$q = "SELECT * FROM (SELECT pqr.id as id, 'pro' as type, pqr.attrvalid, IFNULL(IF(pqr.status = 'h', cqr.rebate, pqr.rebate), 0) as rebate, pqr.quantity  FROM productquantityrebate pqr
			LEFT JOIN categoryquantityrebate cqr ON pqr.quantity = cqr.quantity AND cqr.categoryid IN (SELECT categoryid FROM productcategory WHERE productid = ".$prodid.")
			WHERE pqr.productid = ".$prodid." AND (cqr.status != 'h' OR cqr.`status` IS NULL)
			UNION
			SELECT cqr.id as id, 'cat' as type, 0 as attrvalid, cqr.rebate, cqr.quantity FROM productquantityrebate pqr
			RIGHT JOIN categoryquantityrebate cqr ON pqr.quantity = cqr.quantity
			WHERE cqr.categoryid IN (SELECT categoryid FROM productcategory WHERE productid = ".$prodid.") AND pqr.id IS NULL) as t ORDER BY t.quantity ASC";
			
		$res=$mysqli->query($q);

		if($res && $res->num_rows > 0)
		{
			while($docrow=$res->fetch_assoc())
			{
				array_push($docarray,  array('id' => $docrow['id'], 
				             'type' => $docrow['type'], 
							 'attrvalid' => $docrow['attrvalid'], 
							 'quantity' => $docrow['quantity'], 
							 'rebate' => $docrow['rebate']));
			}
		}
		return $docarray;
	}

	/**
	 * @return array vraca niz adribuda proizvoda sa njihovim vrednostima
     */
	public static function getAttributes($productid){
		$prod_attributes = array();
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$prod_id = $productid;//$this->id;
		$lang_id = $_SESSION['langid'];
		$type = "b2b";
		if (isset($_SESSION['shoptype'])) {
			$type = $_SESSION['shoptype'];
		}
//		$query="select categoryid from productcategory where productid=".$prod_id." and status = 'v'";
		$query="select categoryid from productcategory as pc
 				LEFT JOIN category as c on pc.categoryid = c.id
 				where pc.productid=".$prod_id." and status = 'v' and c.".$type."visible = 1";
		$res = $mysqli->query($query);

		if ($res->num_rows > 0){

			$catidstring = '';
			while ($catid = $res->fetch_assoc()){
				$catidstring .= $catid['categoryid'].", ";
			}
			$catidstring = substr($catidstring, 0, -2);

			$query = "SELECT DISTINCT a.id  , ac.mandatory, ac.categoryid , ac.specification_flag FROM attr as a\n"
				. "LEFT JOIN attrcategory AS ac ON ac.attrid = a.id\n"
				. "WHERE ac.categoryid IN(".$catidstring.") ORDER BY ac.sort ASC, ac.attrid ASC";


			$re = $mysqli->query($query);

			$n = 0;
			while($nrow = $re->fetch_assoc())
			{
				if($nrow['id'] != null)
				{
					$tmp_array = array();
					array_push($prod_attributes, array('lang_id'=>$lang_id, 
						 							   'name'=>GlobalHelper::getAttrName($nrow['id']), 
						 							   'mandatory' => $nrow['mandatory'], 
						 							   'specification_flag' => $nrow['specification_flag'],
						 							   'attrid'=>$nrow['id'], 
						 							   'categoryid'=>$nrow['categoryid'], 
						 							   'value'=>$tmp_array
						 							)
							  );
					$query = "SELECT attrvalid FROM `attrprodval` WHERE productid = ".$prod_id; //id vrednosti atributa koji su povezati sa proizvodom sa tim id-om
					$r = $mysqli->query($query);
					$curentvals = array();
					if($r->num_rows > 0)
					{
						while($arow = $r->fetch_assoc()){
							array_push($curentvals, $arow['attrvalid']);
						}
					}
					$query = "SELECT * FROM `attrval` WHERE attrid = ".$nrow['id'];//vrednosti atributa
					
					
					/*$query = "SELECT DISTINCT av.* 
					          FROM productcategory AS pc 
							  LEFT JOIN attrcategory AS ac ON pc.categoryid=ac.categoryid 
							  LEFT JOIN attrval AS av ON ac.attrid=av.attrid 
						      WHERE productid=".$productid."  AND ac.attrid=".$nrow['id'];
					
					
					echo $query.";";
					*/
					$r = $mysqli->query($query);
					while($finrow = $r->fetch_assoc())
					{
						
						foreach($curentvals as $cval)
						{
							if($cval == $finrow['id'])
							{
	//                        var_dump('cval: '.$cval.' finrow-attrvalid: '.$finrow['attrvalid']);
								$q = "(SELECT type, content FROM attrval_file WHERE attrvalid =".$finrow['id']." AND type = 'mi')
										UNION
									  (SELECT type, content FROM attrval_file WHERE attrvalid =".$finrow['id']." AND type = 'mc')";
								
								$resf = $mysqli->query($q);
								$mi = '';
								$mc = '';
								while($rowf = $resf->fetch_assoc()){
									
									if($rowf['type'] == 'mi') $mi = $rowf['content'];
									if($rowf['type'] == 'mc') $mc = $rowf['content'];	
								}
								/*$exists=false;
								$exists=self::checkAttributeExistInOtherCategory($productid,$nrow['categoryid'],$nrow['id'],$finrow['id']);
								if(!$exists){
									$existscount++;
									array_push($prod_attributes[$n]['value'], array('attr_val_id'=>$finrow['id'], 'attr_val_name'=>GlobalHelper::getAttrValName($finrow['id']), 'mainimage'=>$mi, 'maincolor'=>$mc));
								}
								if($exists && $existscount==0){
									$existscount++;
									array_push($prod_attributes[$n]['value'], array('attr_val_id'=>$finrow['id'], 'attr_val_name'=>GlobalHelper::getAttrValName($finrow['id']), 'mainimage'=>$mi, 'maincolor'=>$mc));
								}*/
								array_push($prod_attributes[$n]['value'], array('attr_val_id'=>$finrow['id'], 'attr_val_name'=>GlobalHelper::getAttrValName($finrow['id']), 'mainimage'=>$mi, 'maincolor'=>$mc));
								
								
							}
						}
					}
					$n++;
				}
			}
		}
		//echo '<pre>';
		//var_dump($prod_attributes);
		//echo '</pre>';
		return $prod_attributes;
	}
	/*public static function checkAttributeExistInOtherCategory($productid,$categoryid,$attrid,$attrivalid){
		
		$exist=false;
		
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		
		$query="SELECT pc.productid,ac.attrid, pc.categoryid ,av.id
				FROM productcategory AS pc
				LEFT JOIN attrcategory AS ac ON pc.categoryid=ac.categoryid
				LEFT JOIN attrval AS av ON ac.attrid=av.attrid
				WHERE productid=".$productid." AND pc.categoryid!=".$categoryid." AND ac.attrid=".$attrid." AND av.id=".$attrivalid;
				
		echo $query.";";
		$res = $mysqli->query($query);
		
		if ($res->num_rows > 0){
			$exist=true;
		}

		return $exist;
	}*/

	/**
	 * @return array extra detelja proizvoda id, name, image (name i image ako nema u tr tabeli uzima iz extradetail tabele)
     */
	public function getExtraDetails(){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");



		$query = "SELECT ped.extradetailid FROM productextradetail as ped
					 INNER JOIN extradetail as ed ON ped.extradetailid = ed.id
					 where ped.productid = ".$this->id." AND status = 'v' ORDER BY ed.sort";
		$res = $mysqli->query($query);
		$extra_details = array();
		if($res->num_rows > 0){
			while($row = $res->fetch_assoc()){
				$query = "select ed.id, ed.name, ed.image, edtr.name as nametr, edtr.image as imagetr from extradetail as ed
inner join extradetail_tr as edtr on ed.id = edtr.extradetailid
where ed.id = ".$row['extradetailid']." and edtr.langid = ".$_SESSION['langid'];
				$res2 = $mysqli->query($query);
				if($res2->num_rows > 0){
					$row2 = $res2->fetch_assoc();
					$image = $row2['imagetr'];
					if($row2['imagetr'] == '' || $row2['imagetr'] == NULL){
						$image = $row2['image'];
					}
					$name = $row2['nametr'];
					if($row2['nametr'] == '' || $row2['nametr'] == NULL){
						$name = $row2['name'];
					}
					array_push($extra_details, array('id' => $row2['id'], 'name' => $name, 'image' => $image));

				}
			}
			return $extra_details;
		}
		return $extra_details;

	}
	private function getRelations(){
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$relations = array();


		$query = "SELECT DISTINCT pr.relationsid, r.name, rtr.name as nametr FROM productrelations as pr
					LEFT JOIN relations as r on pr.relationsid = r.id
					LEFT JOIN relations_tr as rtr on r.id = rtr.relationsid
					where pr.productid = ".$this->id." and(rtr.langid = ".$_SESSION['langid']." OR rtr.langid is NULL) ORDER BY pr.relatedproid ASC";
					
		$resrow = $mysqli->query($query);
		if($resrow->num_rows > 0){
			while($relrow = $resrow->fetch_assoc()){
				$relationtmp = array();
				$relationtmp['id'] = $relrow['relationsid'];
				$relationtmp['name'] = $relrow['name'];
				if($relrow['nametr'] != '' and $relrow['nametr'] != NULL){
					$relationtmp['name']=$relrow['nametr'];
				}
				$query = "SELECT relatedproid FROM productrelations
					where productid = ".$this->id." and relationsid = ".$relrow['relationsid']." ORDER BY relatedproid ASC";
				$res = $mysqli->query($query);
				$relationtmp['prodid'] = array();
				while($row = $res->fetch_assoc()){
					array_push($relationtmp['prodid'], $row['relatedproid']);
				}
				array_push($relations, $relationtmp);
			}
		}


		return $relations;
	}
	/**
	 * @param $prodid
	 * @return da li je pricevisible za tu kategoriju kojoj pripada proizvod
	 * --doraditi-- gledati da li je price visible za sam proizvod
	 */
	public static function isPriceVisible($prodid){

		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$userType = isset($_SESSION['shoptype']) ? $_SESSION['shoptype'] : 'b2c';
		$query2 = "SELECT pc.categoryid, c.".$userType."visibleprice as pricevisible FROM productcategory as pc
						INNER JOIN category as c ON c.id = pc.categoryid WHERE pc.productid = ".$prodid." ORDER BY pc.categoryid DESC";
		$categories = array();

		$res2 = $mysqli->query($query2);
		$deep_category = 0;
		$price_visible = 1;
		if($res2->num_rows > 0){
			while($row2 = $res2->fetch_assoc()){
				array_push($categories, $row2['categoryid']);
				if($deep_category < $row2['categoryid']){
					$price_visible = $row2['pricevisible'];
				}
			}
		}
		return $price_visible;
	}
	
	public static function getMaxRebate($prodid){

		$maxrebate=0;
		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");

		$query2 = "SELECT IFNULL(pd.maxrebate,0) as maxrebate FROM productdetail as pd
						 WHERE pd.productid = ".$prodid;
		
		$res2 = $mysqli->query($query2);
		
		if($res2->num_rows > 0){
			$r = $res2->fetch_assoc();
			$maxrebate = $r['maxrebate'];
		}
		return $maxrebate;
	}
	
	public static function req($arr, $k = 0){
		if(!isset($arr[$k])){
			return array();	
		}
		if($k == (count($arr) - 1)){
			//echo '555';
			return ($arr[$k]);	
		}
		$tmparr = self::req($arr, $k+1);
		$endarr = array();
		//var_dump($tmparr);
		if(count($arr[$k])>0){
		foreach($arr[$k] as $val){
			//var_dump($val);
			//var_dump($tmparr);
			foreach($tmparr as $v){
				if(is_array($v) && isset($v[0]) ) {
					$a = array_merge(array($val),($v));
					//array_push($a, array($val),($v) );
				}
				else{
				//	$a=array_merge(array($val),array($v));
					$a = array($val, $v);
				}
				
				array_push($endarr, $a );	
			}
		}

		} else {
			//var_dump($tmparr);
			foreach($tmparr as $v){
				if(is_array($v) && isset($v[0]) ) {
					$a = array_merge(array($v));
					//array_push($a, array($val),($v) );
				}
				else{
				//	$a=array_merge(array($val),array($v));
					$a = array($v);
				}
				
				array_push($endarr, $a );	
			}
		}



		return $endarr;
	}



	public static function getProductWarehouseAmount($prodid){

		global $system_conf, $user_conf, $theme_conf;

		$db = Database::getInstance();
		$mysqli = $db->getConnection();
		$mysqli->set_charset("utf8");
		$productamount=0;

		$q="SELECT pw.amount FROM productwarehouse AS pw WHERE pw.productid=".$prodid." AND pw.warehouseid = ".$_SESSION['warehouseid'];

		$res = $mysqli->query($q);

		if($res->num_rows > 0){
			$row = $res->fetch_assoc();
			$productamount = $row['amount'];
		}

		return $productamount;
	}

}
?>