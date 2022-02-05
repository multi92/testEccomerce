
<form action="product" method="POST" id="searchForm" name="searchForm" class="form-search">

<div class="tab-content">
	       <div class="row">
            <div class="col-sm-12 margSI">
              <!--  <a data-toggle="control-sidebar" class="btn detalj"><i class="fa fa-search" aria-hidden="true"></i> >></a> -->
               <button data-toggle="control-sidebar" class="btn btn-warning adv_sea detalj" type="submit" name="closeSearch" > Zatvori pretragu >>> </button>
            </div>
           </div>
           <hr>
           <div class="row">
            <div class="col-sm-12 search-scroll"> 
            <div class="row">
                <label class="col-sm-5 control-label margL">Status</label>
                <div class="col-sm-7 margSI">
                    <select class="form-control select2 input-sm margSI searchProductActiveSelect" 
                            id="active" 
                            data-name="searchProductActiveSelect" 
                            name="searchProductActiveSelect"
                            style="background-color:lightyellow; "
                            >
                       <option value="0" <?php if(isset($_SESSION['search']['product']['active']) && $_SESSION['search']['product']['active']=='0') { echo 'selected="selected"'; } ?>>---</option>
                       <option value="y" <?php if(isset($_SESSION['search']['product']['active']) && $_SESSION['search']['product']['active']=='y') { echo 'selected="selected"'; } ?>>Aktivan</option>
                       <option value="n" <?php if(isset($_SESSION['search']['product']['active']) && $_SESSION['search']['product']['active']=='n') { echo 'selected="selected"'; } ?>>Neaktivan</option> 
                    </select>        
                </div>       
            </div>
            <div class="row">
                <label class="col-sm-5 control-label margL">Tip proizvoda</label>
                <div class="col-sm-7 margSI">
                    <select class="form-control select2 input-sm margSI searchProductTypeSelect" 
                            id="producttype" 
                            data-name="searchProductTypeSelect" 
                            name="searchProductTypeSelect"
                            style="background-color:lightyellow; "
                            >
                        <option value="0" <?php if(isset($_SESSION['search']['product']['type']) && $_SESSION['search']['product']['type']=='0') { echo 'selected="selected"'; } ?> >---</option>
                        <option value="r" <?php if(isset($_SESSION['search']['product']['type']) && $_SESSION['search']['product']['type']=='r') { echo 'selected="selected"'; } ?>>Regularan</option>
                        <option value="q" <?php if(isset($_SESSION['search']['product']['type']) && $_SESSION['search']['product']['type']=='q') { echo 'selected="selected"'; } ?>>Na upit</option>
                        <option value="vp" <?php if(isset($_SESSION['search']['product']['type']) && $_SESSION['search']['product']['type']=='vp') { echo 'selected="selected"'; } ?>>Grupni proizvod</option>
                        <option value="vpi-r" <?php if(isset($_SESSION['search']['product']['type']) && $_SESSION['search']['product']['type']=='vpi-r') { echo 'selected="selected"'; } ?>>Član grupnog proizvoda - Regularan</option>
                        <option value="vpi-q" <?php if(isset($_SESSION['search']['product']['type']) && $_SESSION['search']['product']['type']=='vpi-q') { echo 'selected="selected"'; } ?>>Član grupnog proizvoda - Na upit</option>
                        
                    </select>        
                </div>       
            </div>


            <div class="row">
                <label for="inputProductCode" class="col-sm-5 control-label margL marginTop30">Šifra proizvoda</label>
                <div class="col-sm-7 margSI">
                    <input type="text" class="form-control input-sm searchProductCode" 
                                       id="inputProductCode"  
                                       data-name="searchProductCode" 
                                       placeholder="Šifra proizvoda"
                                       name="searchProductCode" 
                                       value="<?php if(isset($_SESSION["search"]["product"]["code"]) && $_SESSION["search"]["product"]["code"]!=''){ echo $_SESSION["search"]["product"]["code"];} ?>" 
                                       style="background-color:lightyellow; "
                                       >
                </div>
            </div>
            <div class="row">
                <label for="inputProductBarcode" class="col-sm-5 control-label margL">Barkod</label>
                <div class="col-sm-7 margSI">
                    <input type="text" class="form-control input-sm searchProductBarcode" 
                                       id="inputProductBarcode"  
                                       data-name="searchProductBarcode" 
                                       placeholder="Barkod" 
                                       name="searchProductBarcode" 
                                       value="<?php if(isset($_SESSION["search"]["product"]["barcode"]) && $_SESSION["search"]["product"]["barcode"]!=''){ echo $_SESSION["search"]["product"]["barcode"];} ?>"
                                       style="background-color:lightyellow; "
                                       >
                </div>
            </div>
            <div class="row">
                <label for="inputProductName" class="col-sm-5 control-label margL">Naziv</label>
                <div class="col-sm-7 margSI">
                    <input type="text" class="form-control input-sm searchProductName" 
                                       id="inputProductName" 
                                       data-name="searchProductName" 
                                       placeholder="Naziv"  
                                       name="searchProductName" 
                                       value="<?php if(isset($_SESSION["search"]["product"]["name"]) && $_SESSION["search"]["product"]["name"]!=''){ echo $_SESSION["search"]["product"]["name"];} ?>"
                                       style="background-color:lightyellow; "
                                       >
                </div>
            </div>
            <div class="row">
                <label for="inputProductManufcode" class="col-sm-5 control-label margL">Šifra proizvođača</label>
                <div class="col-sm-7 margSI">
                    <input type="text" class="form-control input-sm searchProductManufcode" 
                                       id="inputProductManufcode" 
                                       data-name="searchProductManufcode" 
                                       placeholder="Šifra proizvođača" 
                                       name="searchProductManufcode" 
                                       value="<?php if(isset($_SESSION["search"]["product"]["manufcode"]) && $_SESSION["search"]["product"]["manufcode"]!=''){ echo $_SESSION["search"]["product"]["manufcode"];} ?>"
                                       style="background-color:lightyellow; "
                                       >
                </div>
            </div>
            <div class="row">
                <label for="inputProductManufname" class="col-sm-5 control-label margL">Proizvođač</label>
                <div class="col-sm-7 margSI">
                    <input type="text" class="form-control input-sm searchProductManufname" 
                                       id="inputProductManufname" 
                                       data-name="searchProductManufname" 
                                       placeholder="Proizvođač" 
                                       name="searchProductManufname" 
                                       value="<?php if(isset($_SESSION["search"]["product"]["manufname"]) && $_SESSION["search"]["product"]["manufname"]!=''){ echo $_SESSION["search"]["product"]["manufname"];} ?>"
                                       style="background-color:lightyellow; "
                                       >
                </div>
            </div>

            <div class="row">
                <label for="inputIdProductB2CPriceFrom" class="col-sm-5 control-label margL">B2C cena od</label>
                <div class="col-sm-7 margSI">
                    <input type="number" class="form-control input-sm searchProductB2CPriceFrom" 
                                       id="inputIdProductB2CPriceFrom" 
                                       data-name="searchProductB2CPriceFrom" 
                                       placeholder="B2C cena od" 
                                       name="searchProductB2CPriceFrom" 
                                       value="<?php if(isset($_SESSION["search"]["product"]["b2cpricefrom"]) && $_SESSION["search"]["product"]["b2cpricefrom"]!=''){ echo $_SESSION["search"]["product"]["b2cpricefrom"];} ?>"
                                       style="background-color:lightyellow; "
                                       >
                </div>
            </div>
            <div class="row">
                <label for="inputIdProductB2CPriceTo" class="col-sm-5 control-label margL">B2C cena do</label>
                <div class="col-sm-7 margSI">
                    <input type="number" class="form-control input-sm searchProductB2CPriceTo" 
                                       id="inputIdProductB2CPriceTo" 
                                       data-name="searchProductB2CPriceTo" 
                                       placeholder="B2C cena do" 
                                       name="searchProductB2CPriceTo" 
                                       value="<?php if(isset($_SESSION["search"]["product"]["b2cpriceto"]) && $_SESSION["search"]["product"]["b2cpriceto"]!=''){ echo $_SESSION["search"]["product"]["b2cpriceto"];} ?>"
                                       style="background-color:lightyellow; "
                                       >
                </div>
            </div>
            <div class="row">
                <label for="inputIdProductB2BPriceFrom" class="col-sm-5 control-label margL">B2B cena od</label>
                <div class="col-sm-7 margSI">
                    <input type="number" class="form-control input-sm searchProductB2BPriceFrom" 
                                       id="inputIdProductB2BPriceFrom" 
                                       data-name="searchProductB2BPriceFrom" 
                                       placeholder="B2B cena od" 
                                       name="searchProductB2BPriceFrom" 
                                       value="<?php if(isset($_SESSION["search"]["product"]["b2bpricefrom"]) && $_SESSION["search"]["product"]["b2bpricefrom"]!=''){ echo $_SESSION["search"]["product"]["b2bpricefrom"];} ?>"
                                       style="background-color:lightyellow; "
                                       >
                </div>
            </div>
            <div class="row">
                <label for="inputIdProductB2BPriceTo" class="col-sm-5 control-label margL">B2B cena do</label>
                <div class="col-sm-7 margSI">
                    <input type="number" class="form-control input-sm searchProductB2BPriceTo" 
                                       id="inputIdProductB2BPriceTo" 
                                       data-name="searchProductB2BPriceTo" 
                                       placeholder="B2B cena do" 
                                       name="searchProductB2BPriceTo" 
                                       value="<?php if(isset($_SESSION["search"]["product"]["b2bpriceto"]) && $_SESSION["search"]["product"]["b2bpriceto"]!=''){ echo $_SESSION["search"]["product"]["b2bpriceto"];} ?>"
                                       style="background-color:lightyellow; "
                                       >
                </div>
            </div>
            <div class="row">
                <label for="inputIdProductAmountFrom" class="col-sm-5 control-label margL">Količina od</label>
                <div class="col-sm-7 margSI">
                    <input type="number" class="form-control input-sm searchProductAmountFrom" 
                                       id="inputIdProductAmountFrom" 
                                       data-name="searchProductAmountFrom" 
                                       placeholder="Količina od" 
                                       name="searchProductAmountFrom" 
                                       value="<?php if(isset($_SESSION["search"]["product"]["amountfrom"]) && $_SESSION["search"]["product"]["amountfrom"]!=''){ echo $_SESSION["search"]["product"]["amountfrom"];} ?>"
                                       style="background-color:lightyellow; "
                                       >
                </div>
            </div>
            <div class="row">
                <label for="inputIdProductAmountTo" class="col-sm-5 control-label margL">Količina do</label>
                <div class="col-sm-7 margSI">
                    <input type="number" class="form-control input-sm searchProductAmountTo" 
                                       id="inputIdProductAmountTo" 
                                       data-name="searchProductAmountTo" 
                                       placeholder="Količina do" 
                                       name="searchProductAmountTo" 
                                       value="<?php if(isset($_SESSION["search"]["product"]["amountto"]) && $_SESSION["search"]["product"]["amountto"]!=''){ echo $_SESSION["search"]["product"]["amountto"];} ?>"
                                       style="background-color:lightyellow; "
                                       >
                </div>
            </div>
            <div class="row">
                <label class="col-sm-5 control-label margL">Sa slikom</label>
                <div class="col-sm-7 margSI">
                    <select class="form-control select2 input-sm margSI searchProductWithImageSelect" 
                            id="active" 
                            data-name="searchProductWithImageSelect" 
                            name="searchProductWithImageSelect"
                            style="background-color:lightyellow; "
                            >
                       <option value="0" <?php if(isset($_SESSION['search']['product']['withimage']) && $_SESSION['search']['product']['withimage']=='0') { echo 'selected="selected"'; } ?>>---</option>
                       <option value="y" <?php if(isset($_SESSION['search']['product']['withimage']) && $_SESSION['search']['product']['withimage']=='y') { echo 'selected="selected"'; } ?>>Da</option>
                       <option value="n" <?php if(isset($_SESSION['search']['product']['withimage']) && $_SESSION['search']['product']['withimage']=='n') { echo 'selected="selected"'; } ?>>Ne</option> 
                    </select>        
                </div>       
            </div>
            <div class="row">
                <label class="col-sm-5 control-label margL">Sa kategorijom</label>
                <div class="col-sm-7 margSI">
                    <select class="form-control select2 input-sm margSI searchProductWithCategorySelect" 
                            id="active" 
                            data-name="searchProductWithCategorySelect" 
                            name="searchProductWithCategorySelect"
                            style="background-color:lightyellow; "
                            >
                       <option value="0" <?php if(isset($_SESSION['search']['product']['withcategory']) && $_SESSION['search']['product']['withcategory']=='0') { echo 'selected="selected"'; } ?>>---</option>
                       <option value="y" <?php if(isset($_SESSION['search']['product']['withcategory']) && $_SESSION['search']['product']['withcategory']=='y') { echo 'selected="selected"'; } ?>>Da</option>
                       <option value="n" <?php if(isset($_SESSION['search']['product']['withcategory']) && $_SESSION['search']['product']['withcategory']=='n') { echo 'selected="selected"'; } ?>>Ne</option> 
                    </select>        
                </div>       
            </div>
            <div class="row">
                <label class="col-sm-5 control-label margL">Sa Ext. kategorijom</label>
                <div class="col-sm-7 margSI">
                    <select class="form-control select2 input-sm margSI searchProductWithExtCategorySelect" 
                            id="active" 
                            data-name="searchProductWithExtCategorySelect" 
                            name="searchProductWithExtCategorySelect"
                            style="background-color:lightyellow; "
                            >
                       <option value="0" <?php if(isset($_SESSION['search']['product']['withextcategory']) && $_SESSION['search']['product']['withextcategory']=='0') { echo 'selected="selected"'; } ?>>---</option>
                       <option value="y" <?php if(isset($_SESSION['search']['product']['withextcategory']) && $_SESSION['search']['product']['withextcategory']=='y') { echo 'selected="selected"'; } ?>>Da</option>
                       <option value="n" <?php if(isset($_SESSION['search']['product']['withextcategory']) && $_SESSION['search']['product']['withextcategory']=='n') { echo 'selected="selected"'; } ?>>Ne</option> 
                    </select>        
                </div>       
            </div>
 
            

            <div class="row hide">
                <label class="col-sm-5 control-label margL  ">Mesni odbor</label>
                <div class="col-sm-7 margSI">
                    <?php $selectedID=0; 
                          if(isset($_SESSION['search']['product']['localcommunityid']) && $_SESSION['search']['product']['localcommunityid']!='0') { 
                                  $selectedID=$_SESSION['search']['product']['localcommunityid']; 
                          } ?>
                    <div class="input-groupSearchLocalCommunitySelect">
                    <select class="form-control select2 input-sm margSI  searchLocalCommunitySelect jq_searchLocalCommunitySelect " 
                            data-name="localcommunityid" 
                            name="localcommunityid" 
                            selectedid="<?php echo $selectedID;?>"
                            >
                        <option value="">---</option> 
                        
                    </select>
                    </div>
                </div>
            </div>
           

             
           
            <div class="row hide">
                <label class="col-sm-5 control-label margL">Stručna sprema</label>
                <div class="col-sm-7 margSI">
                    <div class="input-groupSearchQualificationLevelSelect">
                    <select class="form-control select2 input-sm margSI searchQualificationLevelSelect jq_searchQualificationLevelSelect" 
                            data-name="qualificationlevelid" 
                            name="qualificationlevelid" 
                            >
                        <option value="0">---</option>
                        
                    </select>
                    </div>       
                </div>       
            </div>        
            
            
            
            
            
            
           
            
            </div>
            </div>
            <hr>
            <div class="row">
               
                <div class="col-sm-12 margSI">
					           <input type="hidden" name="action" value="submitSearch" />
                    <button type="submit" name="submitSearch" class="btn btn-success  marginTop30">Pretraži</button>
                    <button type="button" name="clearSearch" class="btn btn-danger  marginTop30 clearSearch" style="float:right;">Očisti pretragu</button>
					
                </div>
            </div>
            </div>
</form>
