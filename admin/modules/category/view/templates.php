<div class="col-sm-4 newCatNameHolderTemplate hide" langid="'.$v['id'].'" defaultlang="'.$v['default'].'">
    <h4>Lang</h4>
    <div class="form-group">
   		<label>Naziv kategorije</label>
    	<input type="text" class="form-control categoryName" />
    </div>
    <div class="form-group">
        <label>Opis kategorije</label>
    	<textarea class="form-control categoryDescription"></textarea>
    </div>
</div>


<!--	category attr template -->
<li class="list-group-item hide categoryAttrTemplate">
    <span class="bold"></span>
    <span class="pull-right"><button class="btn btn-xs btn-danger deleteAttrCategory">X</button></span>
    <span class="pull-right selectIsMandatoryHolder">obavezan : <input type="checkbox" class="selectIsMandatory" /></span>
	<span class="pull-right selectIsMandatoryHolder">specifikacija : <input type="checkbox" class="selectSpecificationFlag" /></span>
</li>