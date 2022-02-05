<select class="productcodeContTemplate hide form-control">
    <option value=""></option>
    <?php
        $q = "SELECT * FROM productcode";
        $respc= mysqli_query($conn, $q);
        while($rowpc = mysqli_fetch_assoc($respc)){
            echo "<option value='".$rowpc['id']."'>".$rowpc['name']."</option>";	
        }
    ?>
</select>

<div class="col-sm-4 productNameHolderTemplate hide" langid='' defaultlang=''>
    <div class="form-group">
    <label></label>
    <input type="text" class="form-control productName" required/>
    </div>
</div>

<div class="col-sm-4 productUnitNameHolderTemplate hide" langid='' defaultlang=''>
    <div class="form-group">
    <label></label>
    <input type="text" class="form-control productUnitName" required/>
    </div>
</div>

<div class="col-sm-4 productManufnameHolderTemplate hide" langid='' defaultlang=''>
    <div class="form-group">
    <label></label>
    <input type="text" class="form-control productManufname" />
    </div>
</div>

<div class="col-sm-4 productSearchwordsHolderTemplate hide" langid='' defaultlang=''>
    <div class="form-group">
    <label></label>
    <textarea class="form-control productSearchwords"></textarea>
    </div>
</div>

<div class="col-sm-4 productCharacteristicsHolderTemplate hide" langid='' defaultlang=''>
    <div class="form-group">
    <label></label>
    <textarea class="form-control productCharacteristics"></textarea>
    </div>
</div>

<div class="col-sm-4 productDescriptionHolderTemplate hide" langid='' defaultlang=''>
    <div class="form-group">
    <label></label>
    <textarea class="form-control productDescription" required></textarea>
    </div>
</div>

<div class="col-sm-4 productModelHolderTemplate hide" langid='' defaultlang=''>
    <div class="form-group">
    <label></label>
    <textarea class="form-control productModel"></textarea>
    </div>
</div>

<div class="col-sm-4 productSpecificationHolderTemplate hide" langid='' defaultlang=''>
    <div class="form-group">
    <label></label>
    <textarea class="form-control productSpecification"></textarea>
    </div>
</div>

<div class="col-md-4 extradetailNameHolderTemplate hide" langid='' defaultlang=''>
	<h4></h4>
    <div class="form-group">
        <label>Ime</label>
        <input type="text" class="form-control nameExtraDetail"	 />
    </div>
    <div class="form-group">
        <label>Slika</label>
        <input type="text" class="form-control imageExtraDetail"	 />
    </div>
</div>


<div class="col-md-4 relationsNameHolderTemplate hide" langid='' defaultlang=''>
	<h4></h4>
    <div class="form-group ">
        <label>Ime</label>
        <input type="text" class="form-control nameRelations"	 />
		
    </div>
</div>

<li class="navTabsItemTemplate hide"><a data-toggle="tab" href=""></a></li>

<div id="" class="tab-pane fade in relationsTabHolderTemplate hide" relationsid='' >
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group relative">
                <label>Sifra proizvoda</label>
                <input class="form-control relationsProCodeInput" />
				<div class="relationsSearchResultCont hide"><a class="btn btn-danger btn-xs relationsCloseButton">X</a></div>  
            </div>
        </div>
        <div class="col-sm-4">
            <button class="btn btn-primary addProRelationsButton">Dodaj</button>
        </div>
        <div class="clearfix"></div>
     </div>
     <div class="row">
        <div class="col-sm-3">
            <ul class="list-group relationsTabItemCont">
            	
            </ul>
        </div>
    </div>
</div>

<li class="list-group-item relationsTabItemTemplate hide" relatedproid=''>
    <a class="btn btn-danger btn-xs pull-right relationsTabItemDeleteButton" >X</a>
    <h4 class="pull-left relationsProductName"></h4>
    <div class="clearfix"></div>
    <p class="pull-left relationsProductCode"></p>
    <div class="clearfix"></div>
</li>
