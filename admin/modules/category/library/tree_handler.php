<?php
require("../../../config/db_config.php");
require("../../../config/config.php");
class fs
{
	protected $base = null;
	protected function real($path) {
		$temp = realpath($path);
		if(!$temp) { throw new Exception('Path does not exist: ' . $path); }
		if($this->base && strlen($this->base)) {
			if(strpos($temp, $this->base) !== 0) { throw new Exception('Path is not inside base ('.$this->base.'): ' . $temp); }
		}
		return $temp;
	}
	protected function path($id) {
		$id = str_replace('/', DIRECTORY_SEPARATOR, $id);
		$id = trim($id, DIRECTORY_SEPARATOR);
		$id = $this->real($this->base . DIRECTORY_SEPARATOR . $id);
		return $id;
	}
	protected function id($path) {
		$path = $this->real($path);
		$path = substr($path, strlen($this->base));
		$path = str_replace(DIRECTORY_SEPARATOR, '/', $path);
		$path = trim($path, '/');
		return strlen($path) ? $path : '/';
	}
	public function __construct() {
		
	}
	public function lst($id, $with_root = false) {
		global $conn;
		$res = array();
		$query = "SELECT * FROM category ";
		$re = mysqli_query($conn, $query);
		$selected = false;
		while($row = mysqli_fetch_assoc($re))
		{
			if($row['parentid'] == 0)
			{
				$res[] = array("id" => $row['id'], "parent" => "#", "text" => $row['name'], 'sort' => $row['sort'], 'state' => array('opened' => false, 'disabled' => false, $selected ? "" : "selected"=>true ));
				$selected = true;	
			}
			else
			{
				$res[] = array("id" => $row['id'], "parent" => $row['parentid'], "text" => $row['name'], 'sort' => $row['sort'], 'state' => array('opened' => false, 'disabled' => false)/*, "li_attr" => array("class" => "background-light-".$row["status"])*/);
			}	
		}

		return $res;
	}
	public function data($id) {
		global $conn, $lang;
		$data = array();
		$data['lang'] = array();
		
		$q = "SELECT * FROM languages l ORDER BY `default` ASC";
		$resl = mysqli_query($conn, $q);
		
		while($rowl = mysqli_fetch_assoc($resl)){
			$q = "SELECT c.*, (SELECT name FROM category_tr WHERE categoryid = ".$_GET['id']."  AND langid = ".$rowl['id'].") as nametr,
						(SELECT description FROM category_tr WHERE categoryid = ".$_GET['id']."  AND langid = ".$rowl['id'].") as descriptiontr FROM category c
						WHERE c.id = ".$_GET['id']."
						ORDER BY c.sort ASC";
						
			$res = mysqli_query($conn, $q);
			$rowcat = mysqli_fetch_assoc($res);
			
			array_push($data['lang'],array('langid'=>$rowl['id'],
												'langname'=>$rowl['name'],
												'default'=>$rowl['default'],
												'id'=>$rowcat['id'],
												'name'=>($rowcat['nametr'] == NULL && $rowl['default'] == 'y')? $rowcat['name']:$rowcat['nametr'],
												'description'=>($rowcat['descriptiontr'] == NULL && $rowl['default'] == 'y')? $rowcat['description']:$rowcat['descriptiontr']));
		}
				
		$query = "SELECT c.id, c.parentid, c.b2cvisible, c.b2cvisibleprice, c.b2bvisible, c.b2bvisibleprice, c.margin, c.slug FROM `category` c 
			WHERE c.id=".$_GET['id'];
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_assoc($result);	
			
		$data['id'] = $row['id'];
		$data['b2bprice'] = $row['b2bvisibleprice'];
		$data['b2cprice'] = $row['b2cvisibleprice'];
		$data['b2bcategory'] = $row['b2bvisible'];
		$data['b2ccategory'] = $row['b2cvisible']; 
		$data['margin'] = $row['margin']; 
		$data['slug'] = $row['slug']; 
		
		/* main color */
		
		$q = "SELECT * FROM category_file WHERE type = 'mc' AND categoryid=".$_GET['id'];
					$resm = mysqli_query($conn, $q);
					$rowmc = mysqli_fetch_assoc($resm);
					$contmc = array('content'=>$rowmc['content'], 
									'contentface'=>$rowmc['contentface'],
									'id'=>$rowmc['id'],
									'type'=>$rowmc['type']);
		$data['mc'] = $contmc;
		
		
		$query = "SELECT * FROM category_file WHERE categoryid=".$_GET['id']." ORDER BY type ASC, sort ASC";
		$result = mysqli_query($conn, $query);
		
		$data['detail'] = array();
		
		$row = mysqli_fetch_assoc($result);
		$type = $row['type'];
		mysqli_data_seek($result,0);
		
		$data['detail'][$type] = array();
		
		while($row = mysqli_fetch_assoc($result))
		{
			if($row['type'] != $type){
				$type = $row['type'];
				$data['detail'][$type] = array();	
			}
			array_push($data['detail'][$type], array(rawurldecode($row['content']), rawurldecode($row['contentface']), $row['sort'], $row['id']));	
		}
		
		$data['qtyrebate'] = array();
		
		$query = "SELECT * FROM categoryquantityrebate WHERE categoryid=".$_GET['id']." ORDER BY quantity ASC";
		$result = mysqli_query($conn, $query);
		
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($data['qtyrebate'], array('id'=>$row['id'], 'quantity'=>$row['quantity'], 'rebate'=>$row['rebate'], 'status'=>$row['status']));	
		}
		
		return $data;
	}
	public function create($id) {

	}
	public function rename($id, $name) {
		$dir = $this->path($id);
		if($dir === $this->base) {
			throw new Exception('Cannot rename root');
		}
		if(preg_match('([^ a-zа-я-_0-9.]+)ui', $name) || !strlen($name)) {
			throw new Exception('Invalid name: ' . $name);
		}
		$new = explode(DIRECTORY_SEPARATOR, $dir);
		array_pop($new);
		array_push($new, $name);
		$new = implode(DIRECTORY_SEPARATOR, $new);
		if($dir !== $new) {
			if(is_file($new) || is_dir($new)) { throw new Exception('Path already exists: ' . $new); }
			rename($dir, $new);
		}
		return array('id' => $this->id($new));
	}
	public function remove($id) {
		global $conn, $lang;	
	
		$q = "SELECT id FROM category WHERE parentid = ".$id;
		$res = mysqli_query($conn, $q);
		if(mysqli_num_rows($res) > 0){
			return array('status' => 'FAIL', 'msg'=>'Kategorija ima podkategorije!');				
		}
		else{
			foreach($lang as $val)
			{
				$query = "DELETE FROM `category` WHERE id = ".$id;
				mysqli_query($conn, $query);
				$query = "DELETE FROM `category_tr` WHERE categoryid = ".$id;
				mysqli_query($conn, $query);
				$query = "DELETE FROM `category_file` WHERE categoryid = ".$id;
				mysqli_query($conn, $query);
				
				$query = "DELETE FROM `partnercategory` WHERE categoryid = ".$id;
				mysqli_query($conn, $query);
				$query = "DELETE FROM `productcategory` WHERE categoryid = ".$id;
				mysqli_query($conn, $query);
				$query = "DELETE FROM `attrcategory` WHERE categoryid = ".$id;
				mysqli_query($conn, $query);
				$query = "DELETE FROM `categoryquantityrebate` WHERE categoryid = ".$id;
				mysqli_query($conn, $query);

				
			}
			return array('status' => 'OK', 'msg'=>'');
		}
	}
	public function move($id, $par) {

		global $conn, $lang;
		
		$parent = 0;
		$sameparent = false;

		if(!$_GET['parent'] || (isset($_GET['parent']) && $_GET['parent'] == '#')) $_GET['parent'] = 0;
		$parent = $_GET['parent'];
		if($_GET['oldparent'] == $_GET['parent']) $sameparent = true;
		
		$pos = $_GET['position'];
		$query = "SELECT * FROM `category` WHERE parentid = ".$parent." ORDER BY sort ASC";
		$re = mysqli_query($conn, $query);
		$presortcont = array();
		
		$i = 0;
		while($row = mysqli_fetch_assoc($re))
		{
			if($row['id'] != $_GET['id']){				
				$str = (string)$row['id'];
				$presortcont["$str"] = $i;
				$i++;
			}
		}
		
		$sortarray = array();
		
		if($sameparent){
			$added = false;
			foreach($presortcont as $k=>$v)
			{
				//var_dump($k ." => ".$v);
				if((int)$v >= (int)$_GET['position'])
				{
					$str =(string)$_GET['id'];
					$sortarray["$str"] = (int)$_GET['position'];
					$added = true;
				}
				
				if($added)
				{
					$sortarray[$k] = $v+1;
				}
				else{
					$sortarray[$k] = $v;	
				}	
			}
			if(!$added){
				$str =(string)$_GET['id'];
				$sortarray["$str"] = (int)$_GET['position'];	
			}
		}
		else{
			$sortarray = $presortcont;
		}
		
				
		
		/*	update moved item	*/
		
		if(!$sameparent)
		{
			$query = "UPDATE `category` SET `parentid`=".$parent.", `sort`=".++$pos." WHERE id=".$_GET['id'];
			mysqli_query($conn, $query);
		}
		
		/*	update other items	*/
		
		foreach($sortarray as $k=>$v)
		{
			$query = "UPDATE `category` SET `sort`=".++$v." WHERE id=".(int)$k;
			mysqli_query($conn, $query);
		}
		
		/*	update 0 value	*/
		$q = "SELECT MAX(sort) as max FROM category WHERE `parentid` = ".$parent."";
		$res = mysqli_query($conn, $q);
		if(mysqli_num_rows($res) > 0){
			$maxrow = mysqli_fetch_assoc($res);	
			$max = intval($maxrow['max']);
			
			$q = "SELECT * FROM category WHERE `parentid` = ".$parent." AND `sort`=0 ORDER BY id ASC";
			$res = mysqli_query($conn, $q);
			if(mysqli_num_rows($res) > 0){
				while($row = mysqli_fetch_assoc($res)){
					$max = $max+1;
					$q = "UPDATE `category` SET `sort`=".$max." WHERE id=".(int)$row['id'];
					mysqli_query($conn, $q);
				}
			}
		}
		

		return array('id' => $_GET['id']);
	}
	public function copy($id, $par) {
		$dir = $this->path($id);
		$par = $this->path($par);
		$new = explode(DIRECTORY_SEPARATOR, $dir);
		$new = array_pop($new);
		$new = $par . DIRECTORY_SEPARATOR . $new;
		if(is_file($new) || is_dir($new)) { throw new Exception('Path already exists: ' . $new); }
		if(is_dir($dir)) {
			mkdir($new);
			foreach(array_diff(scandir($dir), array(".", "..")) as $f) {
				$this->copy($this->id($dir . DIRECTORY_SEPARATOR . $f), $this->id($new));
			}
		}
		if(is_file($dir)) {
			copy($dir, $new);
		}
		return array('id' => $this->id($new));
	}
}
if(isset($_GET['operation'])) {

	$fs = new fs();
	try {
		$rslt = null;
		switch($_GET['operation']) {
			case 'get_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
				$rslt = $fs->lst($node, (isset($_GET['id']) && $_GET['id'] === '#'));
				break;
			case "get_content":
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
				$rslt = $fs->data($node);
				break;
			case 'create_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
				$rslt = $fs->create($node);
				break;
			case 'rename_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
				$rslt = $fs->rename($node, isset($_GET['text']) ? $_GET['text'] : '');
				break;
			case 'delete_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
				$rslt = $fs->remove($node);
				break;
			case 'move_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
				$parn = isset($_GET['parent']) && $_GET['parent'] !== '#' ? $_GET['parent'] : '/';
				$rslt = $fs->move($node, $parn);
				break;
			case 'copy_node':
				$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
				$parn = isset($_GET['parent']) && $_GET['parent'] !== '#' ? $_GET['parent'] : '/';
				$rslt = $fs->copy($node, $parn);
				break;
			default:
				throw new Exception('Unsupported operation: ' . $_GET['operation']);
				break;
		}
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($rslt);
	}
	catch (Exception $e) {
		header($_SERVER["SERVER_PROTOCOL"] . ' 500 Server Error');
		header('Status:  500 Server Error');
		echo $e->getMessage();
	}
	die();
}
?>