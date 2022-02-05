<div style="position:absolute; width:50px; margin:auto; z-index:999999;" align="right"> 
<div id="topd" style="width:200px; background-color:#999; border-bottom:#FFF 1px solid; height:150px; display:none; " align="center">
<table>
    <tr>
        <td width="500" align="center"><?php 
			if(isset($_SESSION["status"]) == 'logged')
			{
				 include("welcome.php");
			}
			else
			{
				include("login_form.php"); 
			}
			?>
        </td>
    </tr>
</table>
</div>
<div style="width:100px; height:18px; margin:auto; float:right;" id="topb" align="center"><a><img src="exchange/login.png" width="80" height="18"  /></a></div>

</div>