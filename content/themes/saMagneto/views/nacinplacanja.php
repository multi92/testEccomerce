<div class="head-pic" style="background-image:url(<?php echo $system_conf["theme_path"][1];?>'img/kontakt.jpg');">
</div>
<div class="page-heading">

                <h2><?php echo $language["nacinplacanja"][1];?></h2>
                <ol class="breadcrumb">
                    <li><a href="<?php echo $language['global'][3]; ?>"><?php echo $language["global"][3]; ?></a></li>
					 <?php 
						$path = "";
						foreach($command as $k=>$v){
							$path .= $v."/"; 
							$var=rawurldecode($v);
							if ($var='nacinplacanja') {
								echo '<li class="active">'.$language["nacinplacanja"][1].'</li>';
							}else{
								echo '<li class="active">'.ucfirst(rawurldecode($v)).'</li>';	
							}								
						}
					?>
                </ol>

</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="nacin-holder">
                <div class="row marginBottom50 marginTop50">
                    <div class="col-sm-8 nacin-text">
                        <h4><?php echo $language["nacinplacanja"][2];?></h4>
                        <p>
                            <?php echo $language["nacinplacanja"][3];?>
							<span><a href="partneri"><?php echo $language["nacinplacanja"][4];?></a></span> 
							<?php echo $language["nacinplacanja"][5];?>
							<span><a href="partneri"><?php echo $language["nacinplacanja"][6];?></a></span> 
                        </p>
                    </div>
                    <div class="col-sm-4">
                        <div class="nacin-pic" style="background-image: url(<?php echo $system_conf["theme_path"][1];?>'img/zabrana1.jpg');"></div>
                    </div>
                </div>
                <div class="row marginTop50 marginBottom50">
                      <div class="col-sm-8 nacin-text">
                        <h4><?php echo $language["nacinplacanja"][7];?></h4>
                        <p>
						   <?php echo $language["nacinplacanja"][8];?>
                        </p>
                    </div>
                    <div class="col-sm-4">
                        <div class="nacin-pic" style="background-image: url(<?php echo $system_conf["theme_path"][1];?>'img/kartice1.jpg');"></div>
                    </div>
                </div>    
                <div class="row marginTop50 marginBottom50">
                     <div class="col-sm-8 nacin-text">
                        <h4><?php echo $language["nacinplacanja"][9];?></h4>
                        <p>
                          <?php echo $language["nacinplacanja"][10];?>
                        </p>
                    </div>
                    <div class="col-sm-4">
                        <div class="nacin-pic" style="background-image: url(<?php echo $system_conf["theme_path"][1];?>'img/cekovi1.jpg');"></div>
                    </div>
                </div>                 
            </div>
        </div>
    </div>
</div>

