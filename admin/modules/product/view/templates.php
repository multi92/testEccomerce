<select class="form-control selectStatus hide selectStatusTemplate" id="" currentstatus="n">
     <option value="y" class="background-status-y">Aktivan</option>
     <option value="n" class="background-status-n">Neaktivan</option>
 </select>

 <select class="form-control selectProductApplicationStatus hide selectProductApplicationStatusTemplate" id="" currentstatus="h">
     <option value="v" class="background-status-v">Vidljiv</option>
     <option value="h" class="background-status-h">Sakriven</option>.
     <option value="a" class="background-status-a">Arhiviran</option>
 </select>

 <select class="form-control selectProductFileStatus hide selectProductFileStatusTemplate" id="" currentstatus="h">
     <option value="v" class="background-status-v">Vidljiv</option>
     <option value="h" class="background-status-h">Sakriven</option>.
     <option value="a" class="background-status-a">Arhiviran</option>
 </select>

 <select class="form-control selectProductDownloadStatus hide selectProductDownloadStatusTemplate" id="" currentstatus="h">
     <option value="v" class="background-status-v">Vidljiv</option>
     <option value="h" class="background-status-h">Sakriven</option>.
     <option value="a" class="background-status-a">Arhiviran</option>
 </select>

 <select class="form-control selectTypeShort hide selectTypeShortTemplate" id="" currenttype="0">
     <option value="n">---</option>
     <option value="r">REG</option>
     <option value="q">NU</option>
     <option value="vp">GP</option>
     <option value="vpi-r">Č-GP-REG</option>
     <option value="vpi-q">Č-GP-NU</option>
 </select>

 <select class="form-control selectType hide selectTypeTemplate" id="" currenttype="0">
     <option value="n">---</option>
     <option value="r">Regularan</option>
     <option value="q">Na upit</option>
     <option value="vp">Grupni</option>
     <option value="vpi-r">Član grupnog proizvoda - Regularan</option>
     <option value="vpi-q">Član grupnog proizvoda - Na upit</option>
 </select>
 
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

<div class="col-sm-4 productNameHolderTemplate hide" langid='' defaultlang='' >
    <div class="form-group">
    <label style="font-weight: 700;"></label>
    <input type="text" class="form-control productName" required/>
    </div>
</div>

<div class="col-sm-4 productAlterNameHolderTemplate hide" langid='' defaultlang='' >
    <div class="form-group">
    <label style="font-weight: 700;"></label>
    <input type="text" class="form-control productAlterName" required/>
    </div>
</div>

<div class="col-sm-4 productUnitNameHolderTemplate hide" langid='' defaultlang=''>
    <div class="form-group">
    <label style="font-weight: 700;"></label>
    <input type="text" class="form-control productUnitName" required/>
    </div>
</div>

<div class="col-sm-4 productManufnameHolderTemplate hide" langid='' defaultlang=''>
    <div class="form-group">
    <label style="font-weight: 700;"></label>
    <input type="text" class="form-control productManufname" />
    </div>
</div>

<div class="col-sm-4 productDeveloperHolderTemplate hide" langid='' defaultlang='' >
    <div class="form-group">
    <label style="font-weight: 700;"></label>
    <input type="text" class="form-control productDeveloper" required/>
    </div>
</div>

<div class="col-sm-4 productSearchwordsHolderTemplate hide" langid='' defaultlang=''>
    <div class="form-group">
    <label style="font-weight: 700;"></label>
    <textarea class="form-control productSearchwords"></textarea>
    </div>
</div>

<div class="col-sm-4 productCharacteristicsHolderTemplate hide" langid='' defaultlang=''>
    <div class="form-group">
    <label style="font-weight: 700;"></label>
    <textarea class="form-control productCharacteristics"></textarea>
    </div>
</div>

<div class="col-sm-4 productDescriptionHolderTemplate hide" langid='' defaultlang=''>
    <div class="form-group">
    <label style="font-weight: 700;"></label>
    <textarea class="form-control productDescription" required></textarea>
    </div>
</div>

<div class="col-sm-4 productModelHolderTemplate hide" langid='' defaultlang=''>
    <div class="form-group">
    <label style="font-weight: 700;"></label>
    <textarea class="form-control productModel"></textarea>
    </div>
</div>

<div class="col-sm-4 productSpecificationHolderTemplate hide" langid='' defaultlang=''>
    <div class="form-group">
    <label style="font-weight: 700;"></label>
    <textarea class="form-control productSpecification"></textarea>
    </div>
</div>

<div class="col-md-4 extradetailNameHolderTemplate hide" langid='' defaultlang=''>
     <h4></h4>
    <div class="form-group">
        <label>Ime</label>
        <input type="text" class="form-control nameExtraDetail"   />
    </div>
    <div class="form-group">
        <label>Slika</label>
        <input type="text" class="form-control imageExtraDetail"  />
    </div>
</div>


<div class="col-md-4 relationsNameHolderTemplate hide" langid='' defaultlang=''>
     <h4></h4>
    <div class="form-group ">
        <label>Ime</label>
        <input type="text" class="form-control nameRelations"     />
          
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

<div class="col-sm-3 productAtributeValueICheck productAtributeValueICheckHolderTemplate hide _productAttributeValue">
    <div class="form-group">
        <input type="checkbox" class="attributeValue" value="0" attrprodvalid="0">
        <label class="attributeName" >Naziv vrednosti atributa</label>
    </div>
</div>

 