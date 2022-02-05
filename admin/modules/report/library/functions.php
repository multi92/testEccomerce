<?php

	include("../../../config/db_config.php");
	include("../../../config/config.php");
	include("../../userlog.php");
	$reportInputTypes=array();
	/*$reportInputTypes=array_push($reportInputTypes, array('string'=>'[string:%%%]',
														  'float'=>' [float:%%%]',
														  'date'=>'[date:%%%]',
														  'partner.id'=>'[partner.id:%%%]',
														  'product.id'=>'[product.id:%%%]',
														  'product.ids'=>'[product.ids:%%%]',
														  'categorypr.ids'=>'[categorypr.ids:%%%]',
														  'document.id'=>'[document.id:%%%]',
														  'warehouse.id'=>'[warehouse.id:%%%]',
														  'user.id'=>'[user.id:%%%]',
														  'loggeduser.id'=>'[loggeduser.id:%%%]',
														  'loggeduser.username'=>'[loggeduser.username:%%%]',
														  'document.documenttype'=>'[document.documenttype:%%%]',
														  'bankstatement.statementtype'=>'[bankstatement.statementtype:%%%]',
														  'partner.partnertype'=>'[partner.partnertype:%%%]'
														 
														 );*/




	session_start();
	
	if(isset($_POST['action']) && $_POST['action'] != "")
	{
		switch($_POST['action']){
			case "getitem" : get_item(); break;
			case "preparereport" : prepare_report(); break;
			case "runreport" : run_report(); break;
			case "prepareforcolectinputdata" : prepare_for_colect_input_data(); break ;
			case "updatecolectedinputdata" : update_colected_input_data(); break;
			case "saveaddchange" : save_add_change(); break;
			case "delete" : delete(); break;	
			case "changestatus" : change_status(); break;
			case "changesort" : change_sort(); break;
			case "getlanguageslist" : getLanguagesList(); break;	
			case "exportreporttoxls" : export_report_to_xls(); break;

		}
	}
	
	function get_item(){
		global $conn;
        $data = array();
        $data['lang'] = array();
        $data['inputs'] = array();
		
		$q = "SELECT * FROM report WHERE id = ".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$row = mysqli_fetch_assoc($res);
		
		if($row['id'] != NULL) $data['id'] = $row['id'];
		$data['code'] = $row['code'];
		$data['name'] = $row['name'];
		$data['description'] = $row['description'];
		$data['report'] = $row['report'];
		$data['groupid'] = $row['groupid'];
		
        echo json_encode($data);
	}
	function get_report_inputs($reportSQL){
		$inputArr=array();
		$startPos=0;
  		$endPos=0;
  		//echo $reportSQL;
		for ($i = 0; $i < strlen($reportSQL); $i++) { 
  			
  			if($reportSQL[$i]=="["){
  				$startPos=$i;
  			}
  			if($reportSQL[$i]=="]"){
  				$endPos=$i;
  				$inputStr=substr($reportSQL, $startPos,$endPos-$startPos+1);

  				//DOPUNITI I ZA OSTALE TIPOVE
  				$posEndType = strpos($inputStr, ':')-1;
  				$inputType=substr($inputStr,1,$posEndType);
  				//if($inputType=="string"){
  					//$inputType="string";
  				$inputName=str_replace("]", "",str_replace("[","",str_replace($inputType,"",str_replace(":","",$inputStr))) );//str_replace("]", "",substr($inputStr,8) );
  				$inputMask=$inputStr;
  				$inputValue='';
  				//}
  				if($inputType!="" && $inputName!=""){
  					if (!in_array(array("inputType"=>$inputType, "inputName"=>$inputName,"inputMask"=>$inputMask,"inputValue"=>$inputValue), $inputArr))
  					{
  						array_push($inputArr, array("inputType"=>$inputType, "inputName"=>$inputName,"inputMask"=>$inputMask,"inputValue"=>$inputValue));
  					}
  					
  				}
  				
  				
  			}
		} 

		return $inputArr;
	}

	function prepare_report(){
		global $conn;
        $data = array();
        $data['lang'] = array();
        $data['reportinputs'] = array();
        $reportArr=array();
		
		$q = "SELECT * FROM report WHERE id = ".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$row = mysqli_fetch_assoc($res);
		
		if($row['id'] != NULL) $data['id'] = $row['id'];
		//$data['type'] = $row['code'];
		$data['code'] = $row['code'];
		$data['name'] = $row['name'];
		$data['description'] = $row['description'];
		//$data['report'] = addslashes($row['report']);
		//$reportArr = explode(" ",$row['report']);
		//$pos = strpos("[string:", $row['report']);
		$data['reportinputs'] = get_report_inputs($row['report']);
		if(!isset($_SESSION['reportinputs'])){
			$_SESSION['reportinputs']=array();
		}
		$_SESSION['reportinputs'] = get_report_inputs($row['report']);


		$data['groupid'] = $row['groupid'];
		
        echo json_encode($data);
	}



	function run_report(){
		global $conn;
        $data = array();

        $data["tableheader"] = array();
        $data["tabledata"] = array();
        $data["tabledata2"] = array();

		
		$q = "SELECT * FROM report WHERE id = ".$_POST['id'];
		$res = mysqli_query($conn, $q);
		$row = mysqli_fetch_assoc($res);
		//array_push($data["reportinfo"], array('id'=>$row['id']));
		if($row['id'] != NULL) $data['id'] = $row['id'];
		//$data['type'] = $row['code'];
		$data['code'] = $row['code'];
		$data['name'] = $row['name'];
		$data['description'] = $row['description'];

		$reportData=$row['report'];
		$reportData=str_replace('%', '/%/', $reportData);
		 //echo $reportData;
		// $temo='%10%22';
		// echo $temo;
		
		foreach ($_SESSION['reportinputscolected'] as $key => $val) {

		 	$reportData=str_replace($val["inputMask"], $val["inputValue"], $reportData);
		 	//echo $reportData;
		 } 
		 $reportData=str_replace('###', ';', $reportData);
		 
		 $reportData=str_replace('/%/', '%', $reportData);
		 //var_dump( $reportData); 
		 if (mysqli_multi_query($conn, $reportData)) {

		 	do {

		 		if ($result = mysqli_store_result($conn)) {
		 			$fieldinfo=mysqli_fetch_fields($result);
            			 $columnCount=0;
        				foreach ($fieldinfo as $val) {
        					array_push($data["tableheader"], $val->name);
           
            
        	//echo '		<th class="th-sm">'.$val->name.'
        	//		<i class="fa fa-sort float-right" aria-hidden="true"></i>
        	//		</th>';

            //printf("Table:     %s\n",   $val->table);
            //printf("Max. Len:  %d\n",   $val->max_length);
            //printf("Length:    %d\n",   $val->length);
            //printf("charsetnr: %d\n",   $val->charsetnr);
            //printf("Flags:     %d\n",   $val->flags);
            //printf("Type:      %d\n\n", $val->type);
        	$columnCount++;
        }
            		while ($row = mysqli_fetch_row($result)) {
            			$rowArr = array();
            			$rowArr2 = array();
            			for ($i = 0; $i < $columnCount; $i++) {
    						array_push($rowArr, $row[$i]);
    						//echo $row[$i];
    						$rowArr2[$data["tableheader"][$i]]=$row[$i];
						}
            			array_push($data["tabledata"], $rowArr);
            			array_push($data["tabledata2"], $rowArr2);
            		}
            		mysqli_free_result($result);
        		}
        		/* print divider */
        		if (mysqli_more_results($link)) {
          			  echo "-----------------\n";
        		}

		 	} while (mysqli_next_result($conn));

		 	//echo $reportData;
		 }
		
		//$data["tabledata2"]=json_encode($data["tabledata2"]);
		 //var_dump($data);
		 echo json_encode($data);

	}

	function prepare_for_colect_input_data(){
		//var_dump($_SESSION['reportinputscolected']);
		if(isset($_SESSION['reportinputscolected'])){
			unset($_SESSION['reportinputscolected']);
			$_SESSION['reportinputscolected']=array();
		} else {
			$_SESSION['reportinputscolected']=array();
		} 
			
	
		echo json_encode('true');
		
	}

	function update_colected_input_data(){
		echo $_POST['colecteddata']["values"];
		$_SESSION['reportinputscolected']=$_POST['colecteddata']["values"];

	}

	function save_add_change(){
		global $conn;
		$lastid =$_POST['reportid'];
		
		$query = "INSERT INTO `report`(`id`, `code`, `name`, `description`, `report`,  `sort`, `groupid`, `ts`) VALUES ('".$_POST['reportid']."', 
		'".mysqli_real_escape_string($conn, $_POST['code'])."', 
		'".mysqli_real_escape_string($conn, $_POST['name'])."',
		'".mysqli_real_escape_string($conn, $_POST['description'])."',
		'".mysqli_real_escape_string($conn, $_POST['report'])."', 
		0,
		'".$_POST['groupid']."',
		CURRENT_TIMESTAMP) 
		ON DUPLICATE KEY UPDATE `code` = '".mysqli_real_escape_string($conn, $_POST['code'])."',
								`name` = '".mysqli_real_escape_string($conn, $_POST['name'])."',
								`description` = '".mysqli_real_escape_string($conn, $_POST['description'])."',
								`groupid` = '".mysqli_real_escape_string($conn, $_POST['groupid'])."',
								`report` = '".mysqli_real_escape_string($conn, $_POST['report'])."'";
						
		mysqli_query($conn, $query);
		
		$lastid = mysqli_insert_id($conn);
		if($lastid == '' || $lastid == 0) $lastid = $_POST['reportid'];
		
		if($_POST['reportid'] == ""){
			userlog($_SESSION['moduleid'], "", $lastid, $_SESSION['id'], "add");
		}else{
			userlog($_SESSION['moduleid'], "", $_POST['reportid'], $_SESSION['id'], "change");	
		}
	}
	
	function delete(){
		global $conn, $lang;
		if($_POST['id'] != "")
		{
			foreach($lang as $data)
			{
				$query = "DELETE FROM report WHERE id = ".$_POST['id'];
				mysqli_query($conn, $query);
			}
		}
	}
	function change_status(){
		global $conn, $lang;
		if($_POST['id'] != "")
		{
			foreach($lang as $data)
			{
				$query = "UPDATE `report` SET `status`='".$_POST['status']."' WHERE id = ".$_POST['id'];	
				mysqli_query($conn, $query);	
			}
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change status");
		}
	}
	function change_sort(){
		global $conn, $lang;
		if($_POST['id'] != "")
		{
			foreach($lang as $data)
			{
				$query = "UPDATE `report` SET `sort`='".$_POST['sort']."' WHERE id = ".$_POST['id'];	
				mysqli_query($conn, $query);	
			}
			userlog($_SESSION['moduleid'], "", $_POST['id'], $_SESSION['id'], "change sort");
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


function export_report_to_xls(){
 // $header = $_POST['tableheader'];	
  $data = $_POST['tabledata'];	
  $tableheader=json_decode($data['tableheader']);
  $tabledata=json_decode($data['tabledata']);

  $output=array();
  array_push($output, $tableheader);
  foreach($tabledata as $val) {
    array_push($output, $val);
  }
 /*		Treba json	*/
  //var_dump($tableheader);
  //$data = $_POST['tabledata'];

/*header("Content-Type:application/csv"); 
 header("Content-Disposition:attachment;filename=report.csv"); 
 $output = fopen("php://output",'w') or die("Can't open php://output");
 
 fputcsv($output, $tableheader);
 foreach($tabledata as $val) {
    fputcsv($output, $val);
 }
 fclose($output) or die("Can't close php://output");
*/
var_dump($output[3]);
 echo json_encode('true');
	

}

?>