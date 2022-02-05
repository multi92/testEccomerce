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
					  <li class="globalconfigGeneralInforamtionTab active"><a href="#globalconfigGeneralInforamtion" data-toggle="tab" aria-expanded="true"><i class="fa fa-gear" style="font-size: 18px;"></i> Opšta podešavanja</a></li>
					  <li class="globalconfigLanguageTab"><a href="#globalconfigLanguage" data-toggle="tab" aria-expanded="false"><i class="fa fa-globe" style="font-size: 18px;"></i> Jezici</a></li>
				
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
									foreach($user_conf as $k=>$v){
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
						</div>
						
					</div>
					
				</div>
			</div>
		</div>
	</section>


</div>
