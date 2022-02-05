<?php 

	//echo microtime(true) - $starttime;
	$starttime = microtime(true);
	
	//ini_set('display_errors', 0); 
	/*ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(-1);
	///*/
	///error_reporting(0);
	///ini_set('display_errors', 0);

	//set encoding to utf8

	mb_internal_encoding("UTF-8");
	session_start();
	

	define("CATEGORY_SUFIX", "");
	
	//var_dump(CATEGORY_SUFIX);*/
	$todo = array();
	/*	system configuration	*/

	if(!isset($_SESSION['splashscreen'])){
		$_SESSION['splashscreen']='off';
	}

	if(!isset($_SESSION['acceptcookies'])){
		$_SESSION['acceptcookies']='off';
	}

	include("app/configuration/system.configuration.php");
	include($system_conf["theme_path"][1]."config/user.configuration.php");
	include($system_conf["theme_path"][1]."config/theme.configuration.php");
	include($system_conf["theme_path"][1]."config/theme.configuration.extended.php");
	include($system_conf["theme_path"][1]."config/socialnetworks.configuration.php");
	/*set module version array*/
	$class_version = array();
	$controller_version = array();

	/*set test mode*/
	$sitetestmode=true;
	if($system_conf["site_in_progress"][1]==0){
		$sitetestmode=false;
	}
	//var_dump(gethostbyname('softart.ddns.net'));

	//var_dump($_SERVER['REMOTE_ADDR']);
	if(gethostbyname('softart.ddns.net') == $_SERVER['REMOTE_ADDR'])
	{
		$sitetestmode=false;
		//var_dump(gethostbyname('softart.ddns.net'));
		//var_dump($_SERVER['REMOTE_ADDR']);
	}
	//var_dump($sitetestmode);
	/* core class	*/

	

	include("app/class/core/Session.php");
	include("app/class/core/Database.php");
	include("app/class/core/EmailTemplate.php");
	include("app/class/core/GlobalHelper.php");
	include("app/class/core/User.php");
	include("app/class/core/PostRequestHandler.php");
	include("app/class/core/OrderingHelper.php");
	include("app/class/ShopHelper.php");
	include("app/class/Category.php");
	include("app/class/NewsCategory.php");
    include("app/class/Product.php");
	include("app/class/Invoice.php");
	
	GlobalHelper::setLang();
	include($system_conf["theme_path"][1].'lang/'.GlobalHelper::getLangShortname().'.php');
	GlobalHelper::setCurrency();
	/*IMPORTANT CYRRENCY OVERRIDE*/
	$language["moneta"][1] = $_SESSION["currencycode"];

	$system_minimal_order_limit=$user_conf["minimal_order_limit"][1];
	$user_conf["minimal_order_limit"][1]=strval(Round(floatval($system_minimal_order_limit/floatval($_SESSION["currencyvalue"])),2));
	
	$system_free_delivery_from=$user_conf["free_delivery_from"][1];
	$user_conf["free_delivery_from"][1]=strval(Round(floatval($system_free_delivery_from/floatval($_SESSION["currencyvalue"])),2));
	
	$system_delivery_cost=$user_conf["delivery_cost"][1];
	$user_conf["delivery_cost"][1] = strval(Round(floatval($system_delivery_cost/floatval($_SESSION["currencyvalue"])),2));
	/*IMPORTANT CYRRENCY OVERRIDE END*/
	GlobalHelper::setShoptype();

	if(!isset($_SESSION['warehouseid'])) $_SESSION['warehouseid'] = $user_conf["b2cwh"][1];
	//if(!isset($_SESSION['shopcart'])) $_SESSION['shopcart'] = array();
	//if(!isset($_SESSION['shopcartB2B'])) $_SESSION['shopcartB2B'] = array();
	
	//SET VIEWTYPE
	if(isset($_SESSION['type'])  && ($_SESSION['type']=='partner')&& (!isset($_SESSION['viewtype']) || (isset($_SESSION['viewtype']) && $_SESSION['viewtype']== 2))) $_SESSION['viewtype'] = 3;
	if(isset($_SESSION['type'])  && ($_SESSION['type']=='commerc')) $_SESSION['viewtype'] = 3;
	if(!isset($_SESSION['viewtype']) && (isset($_SESSION['loginstatus']) && $_SESSION['loginstatus'] == 'logged')) $_SESSION['viewtype'] = 2;
	if(!isset($_SESSION['viewtype'])) $_SESSION['viewtype'] = 1;

	
	if($_SERVER['REQUEST_METHOD'] == 'POST' && ($_SERVER["REQUEST_URI"] != '/checkout_finished' && $_SERVER["REQUEST_URI"] != '/checkout_finished_fail')){
		include("app/class/Shop.php");
		$post_handle=new PostRequestHandler();
		die();
	}

	/* parse url */
	
	$requestURI = explode('/',$_SERVER['REQUEST_URI']);
	$scriptName = explode('/',$_SERVER['SCRIPT_NAME']);

	#var_dump($requestURI);
	
	for($i= 0;$i < sizeof($scriptName);$i++)
	{
	  if ($requestURI[$i] == $scriptName[$i])
		{
			unset($requestURI[$i]);
		}
	}
	
	$command=array();
	$commandget=array();
	foreach ($requestURI as $req) {
		$a = preg_match_all("/[(\?|\&)]([^=]+)\=([^&#]+)/", $req, $regcont);
		if($a > 0){
			/* postoje GET parametri */	
			$req = substr($req, 0, strpos($req, '?'));
		}
		if($req != ""){
			 $str = strlen($req);
			 if(strpos($req,"?")) $str = strpos($req,"?");
			 array_push($command, substr($req, 0, $str));
		}
	}
	

	/*	routing 	*/
	#var_dump($command);

	
	if(!isset($command[0]) || $command[0] == "")
	{
		if($system_conf["site_in_progress"][1]==1){
			$command[0] = "inprogress";
		} else {
			$command[0] = "pocetna";
		}
			
	}
	elseif(!isset($command[0]) || $command[0] == ""){
		if($system_conf["site_in_progress"][1]==1){
			$command[0] = "inprogress";
		} else {
			$command[0] = "pocetna";
		}	
	}
	
	$get = '?';
	$getnopage = '';
	foreach($_GET as $k=>$v){
		if(is_array($v)){
			foreach($v as $gk=>$gv){
				$get .= $k."[]=".$gv."&"; 		
				$getnopage .= $k."[]=".$gv."&"; 
			}
		}
		else{
			if($k != 'p'){
				$getnopage .= $k."=".$v."&"; 	
			}
			$get .= $k."=".$v."&"; 	
		}
	}
	$get = substr($get, 0, -1);
	$getnopage = substr($getnopage, 0, -1);
		
	if(isset($_COOKIE['username']) && $_COOKIE['username']!='' && isset($_COOKIE['h264']) && $_COOKIE['h264']!=''){
		
		User::login($_COOKIE['username'], $_COOKIE['h264'], true);
	}		
		
	if(!isset($_SESSION['loginstatus'])){
		if(isset($_GET['user']) && isset($_GET['pass'])){
			User::login($_GET['user'], $_GET['pass']);	
		}
	}
	
	
	if(isset($_GET['logout'])){
		User::logout();
	}

	if(isset($_GET['forgotpass'])){
		var_dump(User::forgotPass('info@softart.rs'));
	}
	if(isset($_GET['passreq'])){
		if(User::changePassConf($_GET['passreq'])){
			$_SESSION['success_notifications'][] = 'Nova lozinka vam je poslata na mail.';
			echo '<script type="text/javascript">',
			'setTimeout(function(){
                    window.location.href = "";
                },3500);',
			'</script>'
			;
		}

	}
//?userregistration=1&email=test@email.com&password=test&password_r=test&ime=pera&prezime=peric&adresa=perastreet bb&mesto=petrovgrad&post_br=12345&telefon=123456
//	if(isset($_GET['userregistration']) && isset($_GET['email']) && isset($_GET['password']) && isset($_GET['password_r']) && isset($_GET['ime']) && isset($_GET['prezime']) && isset($_GET['adresa']) && isset($_GET['mesto']) && isset($_GET['post_br']) && isset($_GET['telefon'])){
//		User::register($_GET['email'], $_GET['password'], $_GET['password_r'], $_GET['ime'], $_GET['prezime'], $_GET['adresa'], $_GET['mesto'], $_GET['post_br'], $_GET['telefon']);
//	}
	if(isset($_GET['mailconf'])){
		if(User::emailConfirmByCode($_GET['mailconf'])){
			//echo 'uspesno potvrdjena email adresa';
			//doraditi npr nova strana sa informaciom ja je usposno potvrdjen mail
			echo '<script type="text/javascript">',
			'setTimeout(function(){
                    window.location.href = "login";
                },3500);',
			'</script>'
			;

		}
		else{
			echo 'Greska prilikom potvrde email adrese.';
		}
	}
	
	

	/* start page assamble	*/

	if($_SESSION['splashscreen']=='on'){
		include("app/controller/controller_splashscreen.php");
	} else {
		include("app/controller/controller_main.php");
	}
//echo '<br /><br />'.(microtime(true) - $starttime)."<br /><br />";
		$starttime = microtime(true); 
	
	#include("app/controller/controller_actionbirthday.php");

	
	if($_SERVER['REMOTE_ADDR'] == gethostbyname('softart.ddns.net') || $_SERVER['REMOTE_ADDR'] == gethostbyname('obicni.ddns.name'))
	{
		//include("views/includes/websiteprogress.php");
		echo "<pre>";
		echo "<br />-------------------------- DEVELOPER DATA - IGNORE THIS PART ------------------------------------------- <br /><br /> get";
		var_dump($_GET);
		echo "get";
		var_dump($get);
		echo "getnopage";
		var_dump($getnopage);
		echo "command";
		var_dump($command);
		echo "session";
		var_dump($_SESSION);
		echo "cookie";
		var_dump($_COOKIE);
		echo "________________________________________________________<br>";
		echo "<b>PAGE CONTROLLERS INFO</b><br>";
		echo "________________________________________________________<br>";
		foreach($controller_version as $key=>$val){
			echo '<b>CONTROLER ['.$key.']</b><br>&emsp; VERSION ['.$val[1].']<br>&emsp; COMMENT ['.$val[2].']<br>FILE PATH ['.$val[3].']';
			echo '<br>';
		}
		echo "________________________________________________________<br>";
		echo "TODO";
		var_dump($todo);
		echo "</pre>";


	
	}

	
?>