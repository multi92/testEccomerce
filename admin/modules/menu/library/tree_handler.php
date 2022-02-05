<?php
require("../../../config/db_config.php");
require("../../../config/config.php");
session_start();

class fs
{
    protected $base = null;

    protected function real($path)
    {
        $temp = realpath($path);
        if (!$temp) {
            throw new Exception('Path does not exist: ' . $path);
        }
        if ($this->base && strlen($this->base)) {
            if (strpos($temp, $this->base) !== 0) {
                throw new Exception('Path is not inside base (' . $this->base . '): ' . $temp);
            }
        }
        return $temp;
    }

    protected function path($id)
    {
        $id = str_replace('/', DIRECTORY_SEPARATOR, $id);
        $id = trim($id, DIRECTORY_SEPARATOR);
        $id = $this->real($this->base . DIRECTORY_SEPARATOR . $id);
        return $id;
    }

    protected function id($path)
    {
        $path = $this->real($path);
        $path = substr($path, strlen($this->base));
        $path = str_replace(DIRECTORY_SEPARATOR, '/', $path);
        $path = trim($path, '/');
        return strlen($path) ? $path : '/';
    }

    public function __construct()
    {

    }

    public function lst($id, $with_root = false)
    {
        global $conn;
		$res = array();
		$query = "SELECT * FROM menu ORDER BY sort DESC";
		$re = mysqli_query($conn, $query);
		$selected = false;
		while($row = mysqli_fetch_assoc($re))
		{
			if($row['parentid'] == 0)
			{
				$res[] = array("id" => $row['id'], "parent" => "#", "text" => $row['value'], "sort" => $row['sort'], 'state' => array('opened' => false, 'disabled' => false, $selected ? "" : "selected"=>false ));
				$selected = true;	
			}
			else
			{
				$res[] = array("id" => $row['id'], "parent" => $row['parentid'], "sort" => $row['sort'], "text" => "<span class='pull-left'>".$row['sort']." </span> " . $row['value'], 'state' => array('opened' => false, 'disabled' => false)/*, "li_attr" => array("class" => "background-light-".$row["status"])*/);
			}	
		}

		return $res;
    }

    public function data($id)
    {
        global $conn;
        $data = array();
        $data['lang'] = array();
		
		$q = "SELECT * FROM menu WHERE id = ".$id;
		$res = mysqli_query($conn, $q);
		$row = mysqli_fetch_assoc($res);
		
		if($row['id'] != NULL) $data['id'] = $row['id'];
		if($row['parentid'] != NULL) $data['parentid'] = $row['parentid'];
		if($row['sort'] != NULL) $data['sort'] = $row['sort'];
		if($row['status'] != NULL) $data['status'] = $row['status'];
		if($row['link'] != NULL) $data['link'] = $row['link'];
		if($row['linktype'] != NULL) $data['linktype'] = $row['linktype'];
		if($row['menutype'] != NULL) $data['menutype'] = $row['menutype'];
		if($row['image'] != NULL) $data['image'] = $row['image'];
		$data['value'] = $row['value'];
		
		$q = "SELECT *, (SELECT value FROM menu_tr WHERE menuid = ".$id." AND langid = l.id ) as valuetr FROM languages l";
	
        $res = mysqli_query($conn, $q);
        if ($res && mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
				array_push($data['lang'], array('langid'=>$row['id'], 
						'name'=>$row['name'],
						'default'=>$row['default'],
						'value'=>($row['valuetr'] != NULL)? $row['valuetr']:'' ));
            }
        }
        return $data;
    }

    public function create($id)
    {

    }

    public function rename($id, $name)
    {
        
    }

    public function remove($id)
    {
        global $conn;
		
		$query = "DELETE FROM `menu` WHERE id = " . $id;
        mysqli_query($conn, $query);
		
		$query = "DELETE FROM `menu` WHERE parentid = " . $id;
        mysqli_query($conn, $query);
			
		$query = "DELETE FROM `menu_tr` WHERE menuid = " . $id;
        mysqli_query($conn, $query);
		
        return array('status' => 'OK');
    }

    public function move($id, $par)
    {

        global $conn;

        $parent = 0;
        $sameparent = false;

        if ($_GET['parent'] && $_GET['parent'] != "#") $parent = $_GET['parent'];
        if ($_GET['oldparent'] == $_GET['parent']) $sameparent = true;

        $pos = $_GET['position'];
        $query = "SELECT * FROM `menu` WHERE parentid = " . $parent . " ORDER BY sort ASC";
        $re = mysqli_query($conn, $query);
        $presortcont = array();

        $i = 0;
        while ($row = mysqli_fetch_assoc($re)) {
            if ($row['id'] != $_GET['id']) {
                $str = (string)$row['id'];
                $presortcont["$str"] = $i;
                $i++;
            }
        }

        $sortarray = array();

        if ($sameparent) {
            $added = false;
            foreach ($presortcont as $k => $v) {
                if ((int)$v >= (int)$_GET['position']) {
                    $str = (string)$_GET['id'];
                    $sortarray["$str"] = (int)$_GET['position'];
                    $added = true;
                }

                if ($added) {
                    $sortarray[$k] = $v + 1;
                } else {
                    $sortarray[$k] = $v;
                }
            }
            if (!$added) {
                $str = (string)$_GET['id'];
                $sortarray["$str"] = (int)$_GET['position'];
            }
        } else {
            $sortarray = $presortcont;
        }

		/*	update moved item	*/

		if (!$sameparent) {
			$query = "UPDATE `menu` SET `parentid`=" . $parent . ", `sort`=" . $pos . " WHERE id=" . $_GET['id'];
			mysqli_query($conn, $query);
		}

		/*	update other items	*/

		foreach ($sortarray as $k => $v) {
			$query = "UPDATE `menu` SET `sort`=" . $v . " WHERE id=" . (int)$k;
			mysqli_query($conn, $query);
		}

        return array('id' => $_GET['id']);
    }

    public function copy($id, $par)
    {
        
    }
}

if (isset($_GET['operation'])) {

    $fs = new fs();
    try {
        $rslt = null;
        switch ($_GET['operation']) {
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
    } catch (Exception $e) {
        header($_SERVER["SERVER_PROTOCOL"] . ' 500 Server Error');
        header('Status:  500 Server Error');
        echo $e->getMessage();
    }
    die();
}
?>