<?php
	$bannersright = array();

	$q="SELECT b.*, btr.value as valuetr FROM banner b
		LEFT JOIN banner_tr btr ON b.id = btr.bannerid
		WHERE b.position = 'l' AND page='".$command[0]."' AND status = 'v' AND (btr.langid = ". $_SESSION['langid']. " OR btr.langid is null) 
		ORDER BY sort ASC";
	$res = $mysqli->query($q);
	if($res && $res->num_rows > 0){
		while($row = $res->fetch_assoc())
		array_push($bannersright, array("id"=>$row['id'], 'name'=>$row['name'], 'value'=>(($row['valuetr'] == NULL)? $row['value']:$row['valuetr']) ));
	}
	$q="SELECT b.*, btr.value as valuetr FROM banner b
		LEFT JOIN banner_tr btr ON b.id = btr.bannerid
		WHERE b.position = 'l' AND page='' AND status = 'v' AND (btr.langid = ". $_SESSION['langid']. " OR btr.langid is null) 
		ORDER BY sort ASC";
	$res = $mysqli->query($q);
	if($res && $res->num_rows > 0){
		while($row = $res->fetch_assoc())
		array_push($bannersright, array("id"=>$row['id'], 'name'=>$row['name'], 'value'=>(($row['valuetr'] == NULL)? $row['value']:$row['valuetr']) ));
	}
	
	include("views/banner_left.php");
?>