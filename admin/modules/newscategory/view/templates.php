<div class="col-sm-4 newCatNameHolderTemplate hide" langid="'.$v['id'].'" defaultlang="'.$v['default'].'">
    <div class="form-group">
   		<label class="jq_label_name">Naziv</label>
    	<input type="text" class="form-control categoryName" />
    </div>
    <div class="form-group">
    	<label class="jq_label_description">Opis</label>
		<textarea class="form-control categoryDescription"></textarea>
    </div>
</div>


<!--	category attr template -->
<li class="list-group-item hide categoryAttrTemplate">
    <span>New</span>
    <span class="pull-right"><button class="btn btn-xs btn-danger deleteAttrCategory">X</button></span>
    <span class="pull-right selectIsMandatoryHolder">obavezan : <input type="checkbox" class="selectIsMandatory" /></span>
</li>