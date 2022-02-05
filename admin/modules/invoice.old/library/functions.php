<?php

	include("../../../config/db_config.php"); 
	include("../../../config/config.php");
	include("../../userlog.php");
	
	session_start();
	
	if(isset($_POST['action']) && $_POST['action'] != "")
	{
		switch($_POST['action']){
			case "getitem" : get_item(); break;
			case "verifypath" : verifypath(); break;	
			case "getlanguageslist" : getLanguagesList(); break;
		}
	}
	
	function get_item(){
		global $conn, $lang;
		if(isset($_POST['id']) && $_POST['id'] != "")
		{
			$data = array();
							
			$query = "SELECT SQL_CALC_FOUND_ROWS d.id, 
		                           d.documentdate, 
								   d.valutedate, 
								   d.number, 
								   IF(d.status='p','Proknjižen','Neproknjižen') AS status, 
								   d.documenttype,
								   IF(u.type='partner','Pravno lice',IF(u.type='user','Fizičko lice',IF(u.type='admin','Administrator',''))) AS `usertype`,
								   IF(u.type='partner',p.name,IF(u.type='user',CONCAT(u.name,' ',u.surname ),IF(u.type='admin',CONCAT('Administrator',' - ',CONCAT(u.name,' ',u.surname )),CONCAT(u.name,' ',u.surname )))) AS `partneruser`,
								   IF(d.documentid=0 OR d.documentid IS NULL,'Ne', 'Da' ) AS `syncstatus`, 
								   IF(d.docreturn='y','Da','Ne') AS docreturn, 
								   w.name AS `warehousename`
		FROM   document as d
		LEFT JOIN partner as p ON d.partnerid=p.ID
		LEFT JOIN user AS u ON d.userid=u.ID
		LEFT JOIN warehouse AS w ON d.warehouseid=w.warehouseid 
		WHERE d.id=".$_POST['id'];
		
			$re = mysqli_query($conn, $query);
			$row = mysqli_fetch_assoc($re);
			
			$documenttype='';
			switch($row['documenttype'])
			{
			case 'E':
				$documenttype='Rezervacija';
				break;
			case 'R':
				$documenttype='Račun';
				break;
			case 'H':
				$documenttype='Gotovinski račun';
				break;
			case 'P':
				$documenttype='Predračun';
				break;
			}
			
			$data['id'] = $row['id'];
			$data['number'] = $row['number'];
			$data['documenttype'] = $documenttype;
			$data['documentdate'] = $row['documentdate'];
			$data['valutedate'] = $row['valutedate'];
			$data['usertype'] = $row['usertype'];
			$data['partneruser'] = $row['partneruser'];
			$data['warehousename'] = $row['warehousename'];
			$data['docreturn'] = $row['docreturn'];
			$data['syncstatus'] = $row['syncstatus'];
			$data['status'] = $row['status'];
			$data['comment'] = $row['comment'];			
			$data['documentitem'] = array();
			
			$total_value=0;
			$total_rebate=0;
			$total_value_rebate=0;
			$total_vat=0;
			$total_value_vat=0;
			
			$q = "SELECT di.*,
			             dia.ID as `documentattrvalueid`,
                         dia.attrvalue as `attrvalueids`,
                         dia.quantity AS `attrquantity`						 
				  FROM documentitem AS di
				  LEFT JOIN documentitemattr AS dia ON di.ID=dia.documentitemid 
				  WHERE di.documentid = ".$_POST['id']." ORDER BY di.ID ASC";
	
			$res = mysqli_query($conn, $q);
			if ($res && mysqli_num_rows($res) > 0) {
				while ($row = mysqli_fetch_assoc($res)) {
					$attrvalues='';
					$quantity=0;
					$itemvalue=0;
					$attrs='';
					

					
					if($row['attrquantity']!=NULL){
						
							$total_value=$total_value+($row['attrquantity']*$row['price']);
							$total_rebate=$total_rebate+($row['attrquantity']*$row['price']*($row['rebate']/100));
							$total_value_rebate=$total_value_rebate+($row['attrquantity']*$row['price']*(1-$row['rebate']/100));
							$total_vat=$total_vat+($row['attrquantity']*$row['price']*(1-$row['rebate']/100)*(($row['taxvalue']/100)));
							$total_value_vat=$total_value_vat+($row['attrquantity']*$row['price']*(1-$row['rebate']/100)*(1+($row['taxvalue']/100)));
							
							
							$quantity=$row['attrquantity'];
							$itemvalue=$row['attrquantity']*$row['price']*(1-$row['rebate']/100);
							$vat=($row['attrquantity']*$row['price']*(1-$row['rebate']/100)*(($row['taxvalue']/100)));
							$rebate_value=($row['attrquantity']*$row['price']*($row['rebate']/100));
							$itemvaluevat=($row['attrquantity']*$row['price']*(1-$row['rebate']/100)*(1+($row['taxvalue']/100)));

							$attrs=' - ';
							$q1 = "SELECT aval.*,
                                          a.name AS attrname							
									FROM attrval AS aval
								  LEFT JOIN attr AS a ON aval.attrid=a.id 
								  WHERE aval.id IN (".implode(",",explode(",",$row['attrvalueids'])).") 
								  ORDER BY a.ID ASC, aval.ID ASC";
							//var_dump($q1);
							$res1 = mysqli_query($conn, $q1);
							if ($res1 && mysqli_num_rows($res1) > 0) {
								while ($row1 = mysqli_fetch_assoc($res1)) {
									$attrs.=$row1['attrname'].": ".$row1['value']." ";
								}
							}
							
							
					} else {
							$quantity=$row['quantity'];
							$itemvalue=$row['quantity']*$row['price'];
							$vat=($row['quantity']*$row['price']*(1-$row['rebate']/100)*(($row['taxvalue']/100)));
							$rebate_value=($row['quantity']*$row['price']*($row['rebate']/100));
							$itemvaluevat=($row['quantity']*$row['price']*(1-$row['rebate']/100)*(1+($row['taxvalue']/100)));
													
							$total_value=$total_value+($row['quantity']*$row['price']);
							$total_rebate=$total_rebate+($row['quantity']*$row['price']*($row['rebate']/100));
							$total_value_rebate=$total_value_rebate+($row['quantity']*$row['price']*(1-$row['rebate']/100));;
							$total_vat=$total_vat+($row['quantity']*$row['price']*(1-$row['rebate']/100)*(($row['taxvalue']/100)));
							$total_value_vat=$total_value_vat+($row['quantity']*$row['price']*(1-$row['rebate']/100)*(1+($row['taxvalue']/100)));
							
							
					}
					array_push($data['documentitem'], array(
															'documentitemid'=>$row['id'], 
															'rebate'=>$row['rebate'],
															'price'=>$row['price'],
															'quantity'=>$quantity,
															'itemvalue'=>$itemvalue,
															'productid'=>$row['productid'],
															'productname'=>($row['productname'].$attrs),
															'taxvalue'=>$row['taxvalue'],
															'attributes'=>$attrs,
															'note'=>$row['note'],
															'vat'=>$vat,
															'rebatevalue'=>$rebate_value,
															'itemvaluevat'=>$itemvaluevat
					));
				}
			}

			
			$data['total_value'] = $total_value;
			$data['total_rebate'] = $total_rebate;
			$data['total_value_rebate'] = $total_value_rebate;
			$data['total_vat'] = $total_vat;
			$data['total_value_vat'] = $total_value_vat;
			
			echo json_encode($data);
		}
		
	}

	

	
	function verifypath(){
		if(file_exists("../../../../".rawurldecode($_POST['path']))){
			echo 1;	
		}
		else{
			echo 0;	
		}
	}
	function getLanguagesList(){
		global $conn;
		$data = array();
		
		$query = "SELECT * FROM languages";
		$res = mysqli_query($conn, $query);
		
		while($row = mysqli_fetch_assoc($res)){
			array_push($data, array("id"=>$row['id'], "name"=>$row['name'], "default"=>$row['default']));		
		}
		
		echo json_encode($data);
	}


?>