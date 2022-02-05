<?php

$class_version["router"] = array('module', '1.0.0.0.1', 'Nema opisa');

class Router {
	
	public $page;
	public $id;
	public $p;

	public function __construct() {

		if(isset($_GET['page']))
		{
			if($_GET['page']=='kategorija' || $_GET['page']=='korpa' || $_GET['page']=='mojnalog'  )
			{
				if(!isset($_SESSION['id']))
					$this->page ="home";
				else
					$this->page = (isset($_GET['page']) ? $_GET['page'] : "home");
			}
			elseif ($_GET['page'] == 'proizvodi'){
				if(isset($_GET['id'])){
					if(Helper::isLastCategory($_GET['id'])){
						$this->page = 'proizvodi';
					}
					else{
						$this->page = 'kategorije';
					}
				}
				else{
					$this->page = 'kategorije';
					$_GET['id'] = '0';
				}

			}
			else{

				$this->page = (isset($_GET['page']) ? $_GET['page'] : "home");

			}
			$this->id = (isset($_GET['id']) ? $_GET['id'] : $this->id = NULL);
			$this->p = (isset($_GET['p']) ? $_GET['p'] : $this->p = 1);
		}else{
			$this->page ="home";
		}




		//$this->page = (file_exists("views/" . $this->page . ".php") ? $this->page : "home");
	}
	
	public function RenderPage($view,$ctrl,$method) {

		$controller=new $ctrl();
		$data=$controller->$method($this);

		include ('views/includes/header.php');
		include ("views/" . $view . ".php");
		include ('views/includes/footer.php');
	}

	
}

?>