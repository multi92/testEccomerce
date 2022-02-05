<ol class="breadcrumb">
    <li><a href="pocetna"><?php echo $language["global"][3];?></a></li>
  	<li><a href="javne"><?php echo $language["javnenabavke"][1];?></a></li>
    <?php 
                                $path = "";
								$i=0;
                                foreach($command as $k=>$v){
                                    $path .= $v."/";
									if($i>0){
										echo '<li><a href="'.$path.'">'.rawurldecode($v).'</a></li>';
									}
									$i++;
                                }
    ?>
</ol>
<section>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="after"><?php echo $language["javnenabavke"][1];?></h2>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
                <div class="entry-widget">
                    <h5 class="widget-title"><?php echo $language["javnenabavke"][11];?></h5>
                    <!-- Accordion  -->
                    <div class="accordion dokumenta">
                       <div class="row">
                            <?php 
                                foreach($cont as $k=>$v){
                                    echo '<div class="col-sm-4 text-xs-center">
                                            <a href="'.implode("/", $command).'/'.$v.'" class="btn button">'.$v.'</a>
                                        </div>';
                                }
                            ?>
                            <div class="col-sm-4">
                                <a href=""></a>
                            </div>
                        </div> 
                    </div>
                </div>
			</div>
		</div>
	</div>
</section>