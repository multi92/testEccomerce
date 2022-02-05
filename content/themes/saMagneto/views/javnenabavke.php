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
<section class="jav_nab">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="after"><?php echo $language["javnenabavke"][1];?></h2>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive myTable">
                        <table class="table table-bordered">
                            <tr>
                                <th><?php echo ucfirst($language["javnenabavke"][2]); //Opis javne nabavke?></th>
                                <th><?php echo ucfirst($language["javnenabavke"][3]); //Poziv?></th> 
								<th><?php echo ucfirst($language["javnenabavke"][4]); //Konkursna?></th>
                                <th><?php echo ucfirst($language["javnenabavke"][5]); //Pitanja i odgovori?></th>
                                <th><?php echo ucfirst($language["javnenabavke"][6]); //Obavestenja?></th>
                                <th><?php echo ucfirst($language["javnenabavke"][10]);//Odluke ?></th>
                            </tr>
							
							<?php foreach($javne as $k=>$v){ ?>
                            <tr>
                                <td>
                                    <small><strong><?php echo ucfirst($language["javnenabavke"][7]); ?></strong><?php echo $v->number;?></small><br>
                                    <small><strong><?php echo ucfirst($language["javnenabavke"][8]); ?></strong><?php echo $v->predmet;?></small><br>  
                                    <small><strong><?php echo ucfirst($language["javnenabavke"][9]); ?></strong><?php echo $v->vrsta;?></small><br>
									
									<?php   if($v->adddate != ''){ 
											$myDateTime1 = strtotime($v->adddate);
											$newDateString1 = date('d.m.Y', $myDateTime1);
									?>
									<small><strong><?php echo ucfirst($language["javnenabavke"][15]); ?></strong><?php echo $newDateString1;?></small><br>
									<?php } ?>
									<?php   if($v->rok != ''){ 
											$myDateTime = strtotime($v->rok);
											$newDateString = date('d.m.Y', $myDateTime);
									?>
									<small><strong><?php echo ucfirst($language["javnenabavke"][14]); ?></strong><?php echo $newDateString;?></small><br>
									<?php } ?>
                                </td>
								<?php $string = '';
                                      $position = 1;
                                      $active = 1;
                                      $class = "";
                                      $type = 'file';
								
									    for($i = 1; $i <= 5; $i++){
											echo "<td>";
											$string = "";
													
											foreach($v->items as $key=>$val){

												$extension='';
												$extension = pathinfo($val->value, PATHINFO_EXTENSION);
												$ext='';
												if($extension=='pdf'){
													$ext="views/theme/img/icons/pdf.png";
												} else if($extension=='doc'){
													$ext="views/theme/img/icons/doc.png";
												} else if($extension=='xls'){
													$ext="views/theme/img/icons/xls.png";
												} else if($extension=='xlsx'){
													$ext="views/theme/img/icons/xlsx.png";
												} else if($extension=='txt'){
													$ext="views/theme/img/icons/txt.png";
												} else {
													$ext="views/theme/img/icons/file.png";
												}
												if($i == $val->position){
															if($i == $val->position){
																$class = "";
																$position = $val->position;
																$type = 'file';
															}
															
															if($val->active == 0){
																$string .= "<hr />";
																$class = "transparent50";
																$type = 'file-o';
															}
															
															//$string .= '<a href="'.$val->value.'" target="_blank"><i class="fa fa-'.$type.' fa-2x '.$class.' folder_doc javneIcon"></i></a>';
															$string .= '<a href="'.$val->value.'" target="_blank"><img src="'.$ext.'" alt="'.urldecode(basename($val->value))."-".$val->adddate.'" class="img-responsive" title="'.urldecode(basename($val->value))."-".$val->adddate.'"></a>';
												}
											}
													
											$string = substr($string, 0, -4);
													
											echo $string;
											echo "</td>";
									    }
								?>
							<?php } ?>
                          
                        </table>
                    </div>
					
			</div>
		</div>
		<?php if($user_conf["show_all_javne"][1] == 0) { ?>
					<div class="row">
					<div class="col-md-12" >
						<nav aria-label="Page navigation">
							<ul class="pagination">
							<?php
							if($pagination[0] != '') echo '<li><a href="javne/'.$command[1].'?p='.$pagination[0].'">&laquo;</a></li>';
							if($pagination[1] != '') echo '<li><a href="javne/'.$command[1].'?p='.$pagination[1].'"><</a></li>';
							if($pagination[2] != '') echo '<li><a href="javne/'.$command[1].'?p='.$pagination[2].'">'.$pagination[2].'</a></li>';
							if($pagination[3] != '') echo '<li><a href="javne/'.$command[1].'?p='.$pagination[3].'">'.$pagination[3].'</a></li>';
							if($pagination[4] != '') echo '<li class="active"><a href="javne/'.$command[1].'?p='.$pagination[4].'">'.$pagination[4].'</a></li>';
							if($pagination[5] != '') echo '<li><a href="javne/'.$command[1].'?p='.$pagination[5].'">'.$pagination[5].'</a></li>';
							if($pagination[6] != '') echo '<li><a href="javne/'.$command[1].'?p='.$pagination[6].'">'.$pagination[6].'</a></li>';
							if($pagination[7] != '') echo '<li><a href="javne/'.$command[1].'?p='.$pagination[7].'">></a></li>';
							if($pagination[8] != '') echo '<li><a href="javne/'.$command[1].'?p='.$pagination[8].'">&raquo;</a></li>';
							?>
							</ul>
						</nav>
					</div>
        <?php } ?>
	</div>
</section>