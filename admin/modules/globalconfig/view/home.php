<div class="content-wrapper">
	<section class="content-header -breadcrumbColor">
		<h1>
			<i class="fa fa-sliders"></i> Podešavanja
		</h1>
		<ol class="breadcrumb">
			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
			<li class="active"><i class="fa fa-sliders"></i> Podešavanja</li>
		</ol>
	</section>

	<section class="content-header">
		<div class="row">
			
		</div>
	</section>
	
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<ul class="nav nav-tabs">
					  <li class="globalconfigGeneralInforamtionTab active"><a href="#globalconfigGeneralInforamtion" data-toggle="tab" aria-expanded="true"><i class="fa fa-gear" style="font-size: 14px;"></i> Opšta podešavanja</a></li>
					  <li class="globalconfigTheme"><a href="#globalconfigTheme" data-toggle="tab" aria-expanded="false"><i class="fa fa-indent" style="font-size: 14px;"></i> Podešavanja teme</a></li>
					  <li class="globalconfigLanguageTab"><a href="#globalconfigLanguage" data-toggle="tab" aria-expanded="false"><i class="fa fa-globe" style="font-size: 14px;"></i> Jezici</a></li>
					  <li class="globalconfigCurrencyTab"><a href="#globalconfigCurrency" data-toggle="tab" aria-expanded="false"><i class="fa fa-eur" style="font-size: 14px;"></i> Valute</a></li>
					  
					  <li class="globalconfigPlugins"><a href="#globalconfigPlugins" data-toggle="tab" aria-expanded="false"><i class="fa fa-puzzle-piece" style="font-size: 14px;"></i> Plugins</a></li>
					  
					</ul>
					<i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i>
					<div class="box-body">
						<div class="tab-content">
							
							<!-- globalconfigGeneralInforamtion TAB START --> 
							<div class="tab-pane active" id="globalconfigGeneralInforamtion">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label>Pretraga</label>
											<input type="text" class="form-control searchInput"  />
										</div>
									</div>
								</div>
								
								<?php
									foreach($user_conf_edit as $k=>$v){
										echo '<div class="boxGroup" key="'.$k.'">
										<h3 class="groupName">'.ucfirst($k).'</h3>';		
										foreach($v as $key=>$val){
											echo '<div class="row groupItemRow" key="'.$val[0].'">
											<div class="col-sm-3">
											<p>'.str_replace("_", " ", $val[0]).'</p>
											</div>
											<div class="col-sm-4">
											<div class="form-group">
											<input type="text" class="form-control valueInput" value="'.$val[1].'" />
											</div>
											</div>
											<div class="col-sm-5">
											<div class="form-group">
											<input type="text" class="form-control commentInput" value="'.$val[2].'" />
											</div>
											</div>
											</div>';	
										}
			
										echo '</div>';
									}
			
								?>
								<div class="box-footer">
									<div class="col-xs-12">
										<a class="btn btn-primary saveUserConf">Snimi</a>
									</div>
								</div>
							</div>
							<!-- globalconfigGeneralInforamtion TAB END --> 
							<!-- globalconfigTheme TAB START --> 

							<div class="tab-pane" id="globalconfigTheme">
							<?php if(preg_match('/softart.rs/', $_SERVER['HTTP_HOST']) > 0) {?>
								<?php 
								function findColor($int_pos, $str_line) {
								    $str_temp = substr($str_line, $int_pos, 6);
								    $lst_temp = str_split($str_temp);
								    $lst_end = array(',', ';', ')', '}', ' ');
								    $hex_color = '#';
								    foreach ($lst_temp as $i => $c) {
								        if (!in_array($c, $lst_end) && ($i < 6)) $hex_color .= $c;
								        else break;
								    }
								    return $hex_color;
								}
								
								
								?>
								<div class="row hide">
									<div class="col-sm-12">
										<div class="form-group clearfix">
											<label>Theme Color list - CMS</label>
											<br>
											<br>
											<?php 
												$file = fopen("../cdn/css/cms.css", "r");
												$css_lines = array();
												
												while (!feof($file)) {
												   $css_lines[] = fgets($file);
												}
												
												fclose($file);

												

												$arr_colors = array();    // This is the output array
												foreach ($css_lines as $int_no => $str_line) {
												    $lst_chars = str_split($str_line);
												    foreach ($lst_chars as $i => $c) {
												        if ($c == '#') {
												            $hex_col = findColor($i+1, $str_line);
												            $arr_colors[$hex_col][] = $int_no;
												        }
												    }
												}

												foreach ($arr_colors as $color =>$k ) {
													echo '<div style="border:1px solid #333; text-align:center; display:flex; align-items:center;width:55px; justify-content:center; height:55px; float:left; background-color:'.$color.'; margin-left:5px; margin-bottom:5px;">'.$color.'</div>';
												}


											?>
											
										</div>
									</div>
								</div>
								<hr>
								<div class="row hide">
									<div class="col-sm-12">
										<div class="form-group clearfix">
											<label>Theme Color list - Custom</label>
											<br>
											<br>
											<?php 
												$file = fopen("../".$system_conf['theme_path'][1]."cdn/css/custom.css", "r");
												$css_lines = array();
												
												while (!feof($file)) {
												   $css_lines[] = fgets($file);
												}
												
												fclose($file);

												

												$arr_colors = array();    // This is the output array
												foreach ($css_lines as $int_no => $str_line) {
												    $lst_chars = str_split($str_line);
												    foreach ($lst_chars as $i => $c) {
												        if ($c == '#') {
												            $hex_col = findColor($i+1, $str_line);
												            $arr_colors[$hex_col][] = $int_no;
												        }
												    }
												}

												foreach ($arr_colors as $color =>$k ) {
													echo '<div style="border:1px solid #333; text-align:center; display:flex; align-items:center;width:55px; justify-content:center; height:55px; float:left; background-color:'.$color.'; margin-left:5px; margin-bottom:5px;">'.$color.'</div>';
												}


											?>
											
										</div>
									</div>
								</div>
								<hr>
							<?php }?>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label>Pretraga</label>
											<input type="text" class="form-control searchThemeConfigInput"  />
										</div>
									</div>
								</div>
								
								<?php
									foreach($theme_conf_edit as $kk=>$vv){
										$hide='';
										if($kk[0]=='#'){
											$hide='hide';
										}
										echo '<div class="boxGroup '.$hide.'" key="'.$kk.'">
												<h3 class="groupName">'.ucfirst($kk).'</h3>';		
										foreach($vv as $key=>$val){
											$hideitem='';
											if($vv[0][0]=='#'){
												$hideitem='hide';
											}
											echo '<div class="row groupItemThemeRow '.$hideitem.'" key="'.$val[0].'">
														<div class="col-sm-3">
															<p>'.str_replace("_", " ", $val[0]).'</p>
														</div>
														<div class="col-sm-4">
															<div class="form-group">
																<input type="text" class="form-control valueInput" value="'.$val[1].'" />
															</div>
														</div>
														<div class="col-sm-5">
															<div class="form-group">
																<input type="text" class="form-control commentInput" value="'.$val[2].'" />
															</div>
														</div>
												</div>';	
										}
			
										echo '</div>';
									}
			
								?>
								<div class="box-footer">
									<div class="col-xs-12">
										<a class="btn btn-primary saveThemeConf">Snimi</a>
									</div>
								</div>
							</div>
							<!-- globalconfigTheme TAB END --> 
							<!-- globalconfigLanguage TAB START --> 
							<div class="tab-pane" id="globalconfigLanguage">
								<table id="globalconfigLanguageListTable" class="table table-bordered table-striped">
									<thead>
									  <tr>
										<th>Redni broj</th>
										<th>Šifra</th>
										<th>Naziv</th>
										<th>Kratko ime</th>
										<th>Ikona</th>										
										<th>Izmeni</th>
									  </tr>
									</thead>
								</table>
								
								<hr />
								
								<h4>Dodaj novi jezik</h4>
								
								<div class="row">
									<div class="col-sm-2">
										<div class="form-group jq_required">
											<label>Šifra jezika</label>
											<input class="form-control jq_newLanguageCodeInput" type="text" />
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group jq_required">
											<label>Naziv jezika</label>
											<input class="form-control jq_newLanguageNameInput" type="text" />
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group jq_required">
											<label>Kratko ime</label>
											<input class="form-control jq_newLanguageShortnameInput" type="text" />
										</div>
									</div>
									
									<div class="col-sm-2">
										<div class="form-group">
											<label>Ikona jezika</label>
											<input class="form-control jq_newLanguageFlagInput" type="text" />
										</div>
									</div>
                                    
                                    <div class="col-sm-2">
										<div class="form-group">
											<label>Vrednosti</label>
                                            <select class="form-control jq_newLanguageDefaultvaluesSelect">
                                            	<option value="0">Prazna polja</option>
                                                <?php 
													$q = 'SELECT * FROM languages';
													$res = mysqli_query($conn, $q);
													if(mysqli_num_rows($res) > 0){
														while($row = mysqli_fetch_assoc($res)){
															echo "<option value='".$row['id']."'>".$row['name']."</option>";
														}
													}
													
												?>
                                            </select>
										</div>
									</div>
									
									<div class="col-sm-2">
										<div class="form-group">
											<label>&nbsp;</label>
											<a class="btn btn-primary jq_newLanguageAddButton" disabled="disabled"><i class="fa fa-plus"></i>Dodaj</a>
										</div>
									</div>
								</div>
								
							</div>
							<!-- globalconfigLanguage TAB END -->
							<!-- globalconfigCurrency TAB  --> 
							<div class="tab-pane" id="globalconfigCurrency">
								<div class="row">
								</div>
								<div class="row">
									<div class="col-lg-9 table-responsive">
									<table id="globalconfigCurrencyTable" class="table table-bordered table-striped">
									<thead>
									  <tr>
										<th>Redni broj</th>
										<th>Šifra</th>
										<th>Naziv</th>
										<th>Vrednost</th>
										<th>Status</th>
										<th>Primarna</th>
										<th>Sort</th>										
										<th></th>
									  </tr>
									</thead>
									</table>
									</div>
									<div class="col-lg-3 ">
										<iframe src="https://kursna-lista.com/gedzeti/gadget1black.php" frameborder="0" height="200" scrolling="no" width="100%"></iframe>
									</div>
								</div>

							</div>
							<!-- globalconfigCurrency TAB END -->
							<div class="tab-pane" id="globalconfigPlugins">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Google analytcs Code</label>
											<?php 
											$googleAnalytcsToCode='';
											$handle = "../".$system_conf["theme_path"][1]."config/googleanalytics.configuration.php";
											
											if ($file = fopen($handle, "r")) {
											    while(!feof($file)) {
											        $line = fgets($file);
											        # do same stuff with the $line
											        $googleAnalytcsToCode.=$line;
											    }
											    fclose($file);
											}
											//$tawkToCode = file_get_contents($handle, true);

											?>
											<textarea type="text" rows="11" class="form-control googleAnalyticsToCode"><?php echo $googleAnalytcsToCode;?></textarea>
											<br>
											<a class="btn btn-primary saveGoogleAnalytics">Snimi</a>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Facebook Pixel Code</label>
											<?php 
											$facebookPixelToCode='';
											$handle = "../".$system_conf["theme_path"][1]."config/facebookpixel.configuration.php";
											
											if ($file = fopen($handle, "r")) {
											    while(!feof($file)) {
											        $line = fgets($file);
											        # do same stuff with the $line
											        $facebookPixelToCode.=$line;
											    }
											    fclose($file);
											}
											//$tawkToCode = file_get_contents($handle, true);

											?>
											<textarea type="text" rows="11" class="form-control facebookPixelToCode"><?php echo $facebookPixelToCode;?></textarea>
											<br>
											<a class="btn btn-primary saveFacebookPixel">Snimi</a>
										</div>
									</div>
									<?php if($user_conf["enable_tawkto_plugin"][1]==1){?>
									<div class="col-sm-6">
										<div class="form-group">
											<label>TawkTo Code</label>
											<?php 
											$tawkToCode='';
											$handle = "../".$system_conf["theme_path"][1]."config/tawkto.configuration.php";
											
											if ($file = fopen($handle, "r")) {
											    while(!feof($file)) {
											        $line = fgets($file);
											        # do same stuff with the $line
											        $tawkToCode.=$line;
											    }
											    fclose($file);
											}
											//$tawkToCode = file_get_contents($handle, true);

											?>
											<textarea type="text" rows="11" class="form-control tawkToCode"><?php echo $tawkToCode;?></textarea>
											<br>
											<a class="btn btn-primary saveTawkToCode">Snimi</a>
										</div>
									</div>
									<?php  }?>
									
								</div>
							</div>
							
							
						</div>
						
					</div>
					
				</div>
			</div>
		</div>
	</section>


</div>
