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
        $query = "SELECT * FROM notice_cat";
        $re = mysqli_query($conn, $query);
        $selected = false;
        while ($row = mysqli_fetch_assoc($re)) {

            $res[] = array("id" => $row['id'], "parent" => "#", "text" => $row['name'], 'state' => array('opened' => true, 'disabled' => false, $selected ? "" : "selected" => true));
            $selected = true;

        }

        return $res;
    }

    public function data($id)
    {
        global $conn, $lang;
        $data = array();
        $data['id'] = $id;
        $data['notice'] = array();



        $banners = "select * from notice where n_cat='".$id."'";

        $result = mysqli_query($conn, $banners);
        if ($result && mysqli_num_rows($result) > 0) {

            while ($n = mysqli_fetch_assoc($result)) {
                $data['notice'][] =$n;
            }

        }


        return $data;
    }

    public function create($id)
    {

    }

    public function rename($id, $name)
    {
        $dir = $this->path($id);
        if ($dir === $this->base) {
            throw new Exception('Cannot rename root');
        }
        if (preg_match('([^ a-zа-я-_0-9.]+)ui', $name) || !strlen($name)) {
            throw new Exception('Invalid name: ' . $name);
        }
        $new = explode(DIRECTORY_SEPARATOR, $dir);
        array_pop($new);
        array_push($new, $name);
        $new = implode(DIRECTORY_SEPARATOR, $new);
        if ($dir !== $new) {
            if (is_file($new) || is_dir($new)) {
                throw new Exception('Path already exists: ' . $new);
            }
            rename($dir, $new);
        }
        return array('id' => $this->id($new));
    }

    public function remove($id)
    {
        global $conn;

        foreach ($lang as $val) {
            $query = "DELETE FROM `" . $val . "_categorypr` WHERE id = " . $id;
            mysqli_query($conn, $query);
        }
        return array('status' => 'OK');
    }

    public function move($id, $par)
    {

        global $conn, $lang;

        $parent = 0;
        $sameparent = false;

        if ($_GET['parent']) $parent = $_GET['parent'];
        if ($_GET['oldparent'] == $_GET['parent']) $sameparent = true;

        $pos = $_GET['position'];
        $query = "SELECT * FROM `lat_categorypr` WHERE parentid = " . $parent . " ORDER BY sort ASC";
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
                //var_dump($k ." => ".$v);
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


        foreach ($lang as $val) {
            /*	update moved item	*/

            if (!$sameparent) {
                $query = "UPDATE `" . $val . "_categorypr` SET `parentid`=" . $parent . ", `sort`=" . $pos . " WHERE id=" . $_GET['id'];
                mysqli_query($conn, $query);
            }

            /*	update other items	*/

            foreach ($sortarray as $k => $v) {
                $query = "UPDATE `" . $val . "_categorypr` SET `sort`=" . $v . " WHERE id=" . (int)$k;
                mysqli_query($conn, $query);
            }
        }

        return array('id' => $_GET['id']);
    }

    public function copy($id, $par)
    {
        $dir = $this->path($id);
        $par = $this->path($par);
        $new = explode(DIRECTORY_SEPARATOR, $dir);
        $new = array_pop($new);
        $new = $par . DIRECTORY_SEPARATOR . $new;
        if (is_file($new) || is_dir($new)) {
            throw new Exception('Path already exists: ' . $new);
        }
        if (is_dir($dir)) {
            mkdir($new);
            foreach (array_diff(scandir($dir), array(".", "..")) as $f) {
                $this->copy($this->id($dir . DIRECTORY_SEPARATOR . $f), $this->id($new));
            }
        }
        if (is_file($dir)) {
            copy($dir, $new);
        }
        return array('id' => $this->id($new));
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