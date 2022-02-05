<!-- SEARCH INPUT SEKCIJA -->
    <div id="search-input-holder" class="transition" style="overflow-y: scroll;">
        <a id="close"><img src="<?php echo $system_conf["theme_path"][1]; ?>img/icons/cross-symbol.png" alt="close"></a>
        <div class="container">
            <div class="row marginBottom30">
                <img src="<?php echo $user_conf["sitelogo"][1];?>" alt="logo" class="img-responsive logo-search">
            </div>
            <div class="row marginBottom30 text-center">
                <div class="col-md-12">
				<form action="" id="cms_searchForm">
					<input type="text" id="mysearch-input" class="cms_searchFormInput" placeholder="<?php echo $language["search_modal"][9]; // Brza pretraga ?>">
					<button class="sa-button mysearch-button cms_searchFormButton"><?php echo $language["search_modal"][1]; // Pretrazi ?></button>
					<button class="sa-button mysearch-button cms_searchFilterButton" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><?php echo $language["search_modal"][2]; // Napredna pretraga ?></button>
				</form>
                </div>
            </div>
            <div class="row marginBottom30">
                <div class="collapse mycollapse" id="collapseExample">
                    <div class="row">
                        <div class="col-sm-4">
                            <p><?php echo $language["search_modal"][3]; // Filtriraj brendove ?></p>
                            <select class="js-example-basic-multiple cms_searchFilterBrend" multiple="multiple">
                                <optgroup label="Brendovi">
                                    <option value=""></option>
								<?php 
									$q = 'SELECT b.*, btr.name as nametr FROM brend b
											LEFT JOIN brend_tr btr ON b.id = btr.brendid';
									$res = $mysqli->query($q);
									if($res->num_rows > 0){
										while($row = $res->fetch_assoc()){
											$name = $row['name'];
											if($row['nametr'] != '' && $row['nametr'] != NULL){
												$name = $row['nametr'];
											}
											echo '<option value="'.$row['id'].'">'.$name.'</option>';	
										}
									}
								?>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <p><?php echo $language["search_modal"][4]; // Filtriraj kategorije ?></p>
                            <select class="js-example-basic-multiple cms_searchFilterCategory" multiple="multiple">
                                <optgroup label="Kategorije">
                                    <option value=""></option>
								<?php 
									$q = 'SELECT c.name as topname, c2.name as name, c2.id FROM category c
										LEFT JOIN category c2 ON c.id = c2.parentid
										WHERE c.parentid = 0 ';
									$res = $mysqli->query($q);
									if($res->num_rows > 0){
										while($row = $res->fetch_assoc()){
											echo '<option value="'.$row['id'].'">'.$row['topname'].' > '.$row['name'].'</option>';	
										}
									}
								?>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <p><?php echo $language["search_modal"][5]; // Filtriraj atribute ?></p>
                            <select class="js-example-basic-multiple cms_searchFilterAttrval" multiple="multiple">
                                <optgroup label="Atributi">
                                    <option value=""></option>
								<?php 
									$q = 'SELECT a.name as attrname, av.id, av.value FROM attr a
LEFT JOIN attrval av ON a.id = av.attrid';
									$res = $mysqli->query($q);
									if($res->num_rows > 0){
										while($row = $res->fetch_assoc()){
											echo '<option value="'.$row['id'].'">'.$row['attrname'].' > '.$row['value'].'</option>';	
										}
									}
								?>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
			<div class="col-md-12 cms_searchFoundTotalCont">
				<p><?php echo $language["search_modal"][6]; // Pronadjeno je ?> <span class="cms_searchFoundTotalHolder"></span> <?php echo $language["search_modal"][7]; // proizvoda ?></p>
			</div>
			<i class="fa fa-spinner fa-spin cms_searchLoadingIcon hide" style="font-size:38px; text-align: center; width: 100%;"></i>
			<div class="cms_searchResultCont">
				
			</div>
			
			
		</div>
		<div class="row">
		   <div class="col-md-12">
				<h4 class="sve-rez marginTop30 cms_searchAllResultsButton hide"><a href="#"><i class="fa fa-angle-double-left" aria-hidden="true"></i> <?php echo $language["search_modal"][8]; // Pogledajte sve rezultate ?></a></h4>
		   </div>
		</div>
        </div>
    </div>
    <!-- .SEARCH INPUT SEKCIJA -->