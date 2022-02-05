function resetForm(){
		
}
function showLoadingIcon(){
	$(".loadingIcon").removeClass("hide");	
}
function hideLoadingIcon(){
	$(".loadingIcon").addClass("hide");	
}
$(document).ready(function (e) {
	/*STICKY HEADER*/
	$(".cms_helpBTN").on('click', function(){
		if($(".sticky-header").hasClass("fixed")){
			$(".sticky-header").removeClass("fixed");
		} else {
			$(".sticky-header").addClass("fixed");
		}		
	});
	/*$(window).scroll(function(){
    	if ($(window).scrollTop() >= 100) {
    	   $('.sticky-header').addClass('fixed').removeClass('hide');
    	}
    	else {
    	   $('.sticky-header').removeClass('fixed').addClass('hide');
    	}
	});*/
	/*STICKEY HEADER END*/
	/*PRODUCT IMAGE*/
	if($(".content-wrapper").attr('currentview') == 'change'){
		var currentid =$(".content-wrapper").attr('currentid');
		if(currentid>0){
			$( "#sortable" ).sortable({
				placeholder: "ui-state-highlight",
				stop: function( event, ui ) {
					var data = [];
					$("#image_preview").children("ul").find("li").each(function(){
						data.push($(this).attr('imageid'))	
					});
					$.ajax({
						type:"POST",
						url:"modules/"+moduleName+"/library/functions.php",
						data: ({action: "updateProductImageSort",
								items: data,
								proid: currentid
								}),
						error:function(XMLHttpRequest, textStatus, errorThrown){
						  alert("ERROR");                            
						},
						success:function(response){
							//var a = JSON.parse(response);	
						}
					});		
					
				}
			});
    		$( "#sortable" ).disableSelection();
		}
	}

	$('.proidimage').change(function(e){
		$('.proidimageselectedpath').val($('.proidimage').val());

	}); 
	
	
	$("#uploadimage").on("submit", function(e){
			
		e.preventDefault();
		if($("#proidimage").val() != "")
		{
			formD = new FormData(this);
			formD.append('proid',$(".content-wrapper").attr('currentid'));
			$.ajax({
				url:"modules/"+moduleName+"/library/upload-product-image.php",
				type: "POST",           
				data: formD,
				contentType: false,      
				cache: false,            
				processData:false,    
				success: function(response)
				{
					var a = JSON.parse(response);
					if(a[0] == 0){
						var li = $(document.createElement("li")).addClass("list-group-item").attr('imageid', a[3]);
						$(document.createElement("img")).attr("src", a[1]+"?"+new Date().getTime()).attr("data-featherlight", a[2]+"?"+new Date().getTime()).addClass("img-responsive").addClass("verticalMargin10").appendTo($(li));
						$(document.createElement("buttom")).addClass("btn").addClass("btn-danger").addClass("btn-xs").addClass("deleteProductImageButton").html("X").appendTo($(li));	
						$(li).appendTo($("#image_preview").children("ul"));
						
						$("#file").val("");
					}
				}
			});
		}
		
	});
		
	$(document).on("click", ".deleteProductImageButton", function(){
		if(confirm("Da li ste sigurni da želite da obrišete sliku?"))
		{
			$this = $(this);
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "deleteProductImage",
						id: $($this).parents('.list-group-item').attr('imageid')
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					//var a = JSON.parse(response);
					$($this).parent().remove();
				}
			});	
		}
	});





	$(document).on("click", ".attrProductImageButton", function(){
			
		$("#imgAttrModal").attr("imageid", $(this).parents("li").attr("imageid")).modal();
		var attrid = $(this).attr('attrid');
		if (typeof attrid !== typeof undefined && attrid !== false) {
			$(".imgAttrModalSelect").val(attrid);
			$(".imgAttrModalSelect").attr('attrvalid',  $(this).attr('attrvalid')).trigger('change');
		}else{
			$(".imgAttrModalSelect").val('');
			$(".imgAttrValueModalSelect").hide();	
		}
			
	});
		
		$(".imgAttrModalSelect").on("change", function(){
			$(".imgAttrValueModalSelect").html("").hide();	
						
			if($(this).val() != ""){
				$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "getAttributeValues",
							attrid: $(this).val()
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						var a = JSON.parse(response);
						
						var option = $(document.createElement("option"));
						
						for(var i = 0; i < a.length; i++)
						{
							$(option).clone(true).attr("value", a[i]['attrvalid']).val(a[i]['id']).html(a[i]['value']).appendTo($(".imgAttrValueModalSelect"));	
						}
						
						var attrvalid = $(".imgAttrValueModalSelect").parents(".modal-body").find('.imgAttrModalSelect').attr('attrvalid');
						if (typeof attrvalid !== typeof undefined && attrvalid !== false) {
							//alert(attrid)
							$(".imgAttrValueModalSelect").val(attrvalid);
						}
						
						$(".imgAttrValueModalSelect").show();
					}
				});
			}		
		});
		
		$(".saveImgAttrValueButton").on("click", function(){
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "saveProductImageAttributeValue",
						attrvalid: $(".imgAttrValueModalSelect").val(),
						imageid : $("#imgAttrModal").attr("imageid")
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					$("#imgAttrModal").modal("hide");
					$(".imgAttrValueModalSelect").html("").hide();	
					$(".imgAttrModalSelect").val("");
				}
			});	
		});
		
	/*PRODUCT IMAGE END*/
	/*PRODUCT EXTRA DETAIL*/
	$('input[type=checkbox]').each(function(){
    	var self = $(this),
    	  label = self.next(),
    	  label_text = label.text();
	
	    	label.remove();
	    	self.iCheck({
	    	  checkboxClass: 'icheckbox_line-green',
	    	  radioClass: 'iradio_line-green',
	    	  insert: '<div class="icheck_line-icon"></div><label class="icheckboxname" style="margin-bottom: 0;">' + label_text+'</label>'
    	});
  	});
  	$("div[class$='_productExtraDetailItem']").each(function(){
			var edid = ($(this).attr("class").replace("col-sm-3 productExtraDetailICheck ","")).split("_");
			
			$this = $(this);
			$(this).on('ifClicked', function(event){
				if($(".content-wrapper").attr('currentview') == 'change'){
				var currentid =$(".content-wrapper").attr('currentid');
				$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "updateProductExtraDetail",
							proid: currentid,
							edid: edid[0],
							status: ($(this).find('.icheckbox_line-green').hasClass("checked"))? 0:1
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						
					}
				});
				}	
			});
			
		});
  	$(".productAtributeValueICheck").on("ifClicked", function(event){
			$this = $(this);
			$(this).iCheck('update');
			//var checked = ($(this).find('.icheckbox_line-green').hasClass("checked"))? 0:1;
			//alert(checked);
			var attrid = ($this.attr("attrprodval"));
			
				if($(".content-wrapper").attr('currentview') == 'change' ){
					var currentid =$(".content-wrapper").attr('currentid');
					//alert(currentid);
					//alert(edid);
					//alert(($this.is(":checked")) ? 1 : 0);
					if(currentid>0 && attrid>0){
						$.ajax({
						type:"POST",
						url:"modules/"+moduleName+"/library/functions.php",
						data: ({action: "updateProductAttrValue",
								proid: currentid,
								attrvalid: attrid,
								status: ($(this).find('.icheckbox_line-green').hasClass("checked"))? 0:1
								}),
						error:function(XMLHttpRequest, textStatus, errorThrown){
						  alert("ERROR");                            
						},
						success:function(response){
							
						}
						});
					} else {
						alert("Vrednost atributa nije validna.");
					}
					
				
				}
			
	});
  	
	
  	/*PRODUCT EXTRA DETAIL END*/
  	/*PRODUCT FILES*/
  	$(".selectFileType").select2();
  	if($(".content-wrapper").attr('currentview') == 'change'){
		var currentid =$(".content-wrapper").attr('currentid');
		if(currentid>0){
			$("#tableProductFiles").DataTable({
				"stateSave": true,
				"paging":true,
				"processing": true,
        		"serverSide": true,
        		"ajax":{
        		        url :"modules/"+moduleName+"/library/functions.php", // json datasource
        		        type: "post",  // method  , by default get
        		        data: ({action : 'getProductFiles', productid : currentid}),
        		        error: function(){  // error handling
        		            $(".tableProductFiles-grid-error").html("");
        		            $("#tableProductFiles").append('<tbody class="tableProductFiles-grid-error"><tr><th colspan="3">Nema podataka u bazi</th></tr></tbody>');
        		            $("#tableProductFiles-grid_processing").css("display","none");
        		        },
						dataSrc: function(d){
					//console.log(d);
							for(var i = 0; i < d.aaData.length;i++)
							{
								
								if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('activate') == '1'))
								{
									var clone = $(".selectProductFileStatusTemplate").clone(true).removeClass('hide').removeClass('selectProductFileStatusTemplate').addClass('background-status-'+d.aaData[i][4]).attr('id', d.aaData[i][99]).attr('currentStatus', d.aaData[i][4]);
									$(clone).find("option[value='"+d.aaData[i][4]+"']").attr('selected', 'selected');
								}else{
									var clone = $(".selectProductFileStatusTemplate").clone(true).removeClass('hide').removeClass('.selectProductFileStatusTemplate').attr('disabled', 'disabled');
									$(clone).find("option[value='"+d.aaData[i][4]+"']").attr('selected', 'selected');
								}	
								d.aaData[i][4] = $(clone).wrap('<div>').parent().html();	

								if($("body").attr("user") == "admin" )
								{
									bd = '<button class="btn btn-danger deleteproductfile" productid="'+d.aaData[i][98]+'" id="'+d.aaData[i][99]+'" style="width:80px;">Obriši</button> ';
								}
								d.aaData[i][6] = bd;
							}
							return d.aaData;
						}
           		 },
    	    	"language": {
    	    	   		"emptyTable":     "Nema podataka za prikaz",
						"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
						"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
						"infoFiltered":   "(filtrirano od _MAX_ podataka)",
						"infoPostFix":    "",
						"thousands":      ",",
						"lengthMenu":     "Prikazi _MENU_ podataka",
						"loadingRecords": "Učitavanje...",
						"processing":     "Obrada...",
						"search":         "Filter:",
						"zeroRecords":    "Nema rezultata za zadati kriterijum",
						"paginate": {
							"first":      "Prva",
							"last":       "Poslednja",
							"next":       "Sledeća",
							"previous":   "Predhodna"
						}
    	    		}
				}
			);
			$("#tableProductDownload").DataTable({
				"stateSave": true,
				"paging":true,
				"processing": true,
        		"serverSide": true,
        		"ajax":{
        		        url :"modules/"+moduleName+"/library/functions.php", // json datasource
        		        type: "post",  // method  , by default get
        		        data: ({action : 'getProductDownload', productid : currentid}),
        		        error: function(){  // error handling
        		            $(".tableProductDownload-grid-error").html("");
        		            $("#tableProductDownload").append('<tbody class="tableProductDownload-grid-error"><tr><th colspan="3">Nema podataka u bazi</th></tr></tbody>');
        		            $("#tableProductDownload-grid_processing").css("display","none");
        		        },
						dataSrc: function(d){
					//console.log(d);
							for(var i = 0; i < d.aaData.length;i++)
							{
								
								if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('activate') == '1'))
								{
									var clone = $(".selectProductDownloadStatusTemplate").clone(true).removeClass('hide').removeClass('selectProductDownloadStatusTemplate').addClass('background-status-'+d.aaData[i][4]).attr('id', d.aaData[i][99]).attr('currentStatus', d.aaData[i][4]);
									$(clone).find("option[value='"+d.aaData[i][4]+"']").attr('selected', 'selected');
								}else{
									var clone = $(".selectProductDownloadStatusTemplate").clone(true).removeClass('hide').removeClass('.selectProductDownloadStatusTemplate').attr('disabled', 'disabled');
									$(clone).find("option[value='"+d.aaData[i][4]+"']").attr('selected', 'selected');
								}	
								d.aaData[i][4] = $(clone).wrap('<div>').parent().html();	

								if($("body").attr("user") == "admin" )
								{
									bd = '<button class="btn btn-danger deleteproductdownload" productid="'+d.aaData[i][98]+'" id="'+d.aaData[i][99]+'" style="width:80px;">Obriši</button> ';
								}
								d.aaData[i][6] = bd;
							}
							return d.aaData;
						}
           		 },
    	    	"language": {
    	    	   		"emptyTable":     "Nema podataka za prikaz",
						"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
						"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
						"infoFiltered":   "(filtrirano od _MAX_ podataka)",
						"infoPostFix":    "",
						"thousands":      ",",
						"lengthMenu":     "Prikazi _MENU_ podataka",
						"loadingRecords": "Učitavanje...",
						"processing":     "Obrada...",
						"search":         "Filter:",
						"zeroRecords":    "Nema rezultata za zadati kriterijum",
						"paginate": {
							"first":      "Prva",
							"last":       "Poslednja",
							"next":       "Sledeća",
							"previous":   "Predhodna"
						}
    	    		}
				}
			);

		}
		
		$('#tableProductFiles tbody').on('change', '.selectProductFileStatus', function () {
			//showLoadingIcon();
			changeProductFileStatus_handler($(this));
		});
    	$('#tableProductFiles tbody').on('click', '.deleteproductfile', function () {
			deleteProductFile_handler($(this));
    	});


    	$('#tableProductDownload tbody').on('change', '.selectProductDownloadStatus', function () {
			//showLoadingIcon();
			changeProductDownloadStatus_handler($(this));
		});
    	$('#tableProductDownload tbody').on('click', '.deleteproductdownload', function () {
			deleteProductDownload_handler($(this));
    	});

    	$(".saveAddProductDownload").on('click', function(){
				var productid =$(".content-wrapper").attr('currentid');
				var type = $(".selectDownloadType").val();
				var content = $(".productDownloadContent").val();
				var contentface = $(".productDownloadContentFace").val();
				addProductDownload_handler(productid,type,content, contentface);
		});
    	
	};

	$("#uploadProductFile").on("submit", function(e){
			
		e.preventDefault();
		if($("#productFile").val() != "")
		{
			formD = new FormData(this);
			formD.append('proid',$(".content-wrapper").attr('currentid'));
			$.ajax({
				url:"modules/"+moduleName+"/library/upload-product-file.php",
				type: "POST",           
				data: formD,
				contentType: false,      
				cache: false,            
				processData:false,    
				success: function(response)
				{
					alert("Podaci su uspešno dodati!");
					$('#tableProductFiles').DataTable().ajax.reload();
				}
			});
		}
		
	});

  	/*PRODUCT FILES END*/

	$(".productActive").select2();
	$(".productType").select2();
	$(".productTax").select2();
	$(".productBrend").select2();
	$(".productCollection").select2();
	$(".productPriceVisibility").select2();
	$(".productCategory").select2();

	

	if($(".content-wrapper").attr('currentview') == 'change'){
		var currentid =$(".content-wrapper").attr('currentid');
		if(currentid>0){
			$("#tableProductWarehouse").DataTable({
				"stateSave": true,
				"paging":true,
				"processing": true,
        		"serverSide": true,
        		"ajax":{
        		        url :"modules/"+moduleName+"/library/functions.php", // json datasource
        		        type: "post",  // method  , by default get
        		        data: ({action : 'getProductWarehouse', productid : currentid}),
        		        error: function(){  // error handling
        		            $(".tableProductWarehouse-grid-error").html("");
        		            $("#tableProductWarehouse").append('<tbody class="tableProductWarehouse-grid-error"><tr><th colspan="3">Nema podataka u bazi</th></tr></tbody>');
        		            $("#tableProductWarehouse-grid_processing").css("display","none");
        		        },
						dataSrc: function(d){
					//console.log(d);
							for(var i = 0; i < d.aaData.length;i++)
							{
								///var location = window.location.origin+'/admin/fajlovi/member/'+d.aaData[i][2];
								//var bc = '<a href="'+location+'" target="_blank" class="btn btn-primary showDocumentFile" id="'+d.aaData[i][99]+'" >Pogledaj</a> ';
								//d.aaData[i][2] = bc;
								if($("body").attr("user") == "admin" )
								{
									var amount = '<input type="number" min="0" class="productpwamount " value="'+d.aaData[i][2]+'" productid="' + d.aaData[i][98] + '" warehouseid="'+d.aaData[i][99]+'" style="width:100%;" />';
									d.aaData[i][2] = amount;

									var s = '<input type="number" min="0" class="productpwprice " value="'+d.aaData[i][3]+'" productid="' + d.aaData[i][98] + '" warehouseid="'+d.aaData[i][99]+'" style="width:100%;" />';
									d.aaData[i][3] = s;
									
								}

								if($("body").attr("user") == "admin" )
								{
									bd = '<button class="btn btn-danger deleteproductwarehouse" productid="'+d.aaData[i][98]+'" warehouseid="'+d.aaData[i][99]+'" style="width:80px;">Obriši</button> ';
								}
								d.aaData[i][6] = bd;
							}
							return d.aaData;
						}
           		 },
    	    	"language": {
    	    	   		"emptyTable":     "Nema podataka za prikaz",
						"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
						"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
						"infoFiltered":   "(filtrirano od _MAX_ podataka)",
						"infoPostFix":    "",
						"thousands":      ",",
						"lengthMenu":     "Prikazi _MENU_ podataka",
						"loadingRecords": "Učitavanje...",
						"processing":     "Obrada...",
						"search":         "Filter:",
						"zeroRecords":    "Nema rezultata za zadati kriterijum",
						"paginate": {
							"first":      "Prva",
							"last":       "Poslednja",
							"next":       "Sledeća",
							"previous":   "Predhodna"
						}
    	    		}
				}
			);


		}
		
		$('#tableProductWarehouse tbody').on('change', '.productpwprice', function () {
			updateProductWarehousePrice_handler($(this));
    	});
    	$('#tableProductWarehouse tbody').on('change', '.productpwamount', function () {
			updateProductWarehouseAmount_handler($(this));
    	});
    	$('#tableProductWarehouse tbody').on('click', '.deleteproductwarehouse', function () {
			deleteProductWarehouse_handler($(this));
    	});
    	$(".addProductWarehouse").on('click', function(){
				var productid =$(".content-wrapper").attr('currentid');
				var warehouseid = $(".selectWarehouse").val();
				var newAmount = $(".newProductAmount").val();
				var newPrice = $(".newProductPrice").val();
				addProductWarehouse_handler(productid,warehouseid,newAmount,newPrice);
		});
	};
	if($(".content-wrapper").attr('currentview') == 'change'){
		var currentid =$(".content-wrapper").attr('currentid');
		if(currentid>0){
			$("#tableProductCategorys").DataTable({
				"stateSave": true,
				"paging":true,
				"processing": true,
        		"serverSide": true,
        		"ajax":{
        		        url :"modules/"+moduleName+"/library/functions.php", // json datasource
        		        type: "post",  // method  , by default get
        		        data: ({action : 'getProductCategorys', productid : currentid}),
        		        error: function(){  // error handling
        		            $(".tableProductCategorys-grid-error").html("");
        		            $("#tableProductCategorys").append('<tbody class="tableProductCategorys-grid-error"><tr><th colspan="3">Nema podataka u bazi</th></tr></tbody>');
        		            $("#tableProductCategorys-grid_processing").css("display","none");
        		        },
						dataSrc: function(d){
					//console.log(d);
							for(var i = 0; i < d.aaData.length;i++)
							{
								///var location = window.location.origin+'/admin/fajlovi/member/'+d.aaData[i][2];
								//var bc = '<a href="'+location+'" target="_blank" class="btn btn-primary showDocumentFile" id="'+d.aaData[i][99]+'" >Pogledaj</a> ';
								//d.aaData[i][2] = bc;
								if($("body").attr("user") == "admin" )
								{
									bd = '<button class="btn btn-danger deleteButton" productid="'+d.aaData[i][98]+'" categoryid="'+d.aaData[i][99]+'" style="width:80px;">Obrisi</button> ';
								}
								d.aaData[i][3] = bd;
							}
							return d.aaData;
						}
           		 },
    	    	"language": {
    	    	   		"emptyTable":     "Nema podataka za prikaz",
						"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
						"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
						"infoFiltered":   "(filtrirano od _MAX_ podataka)",
						"infoPostFix":    "",
						"thousands":      ",",
						"lengthMenu":     "Prikazi _MENU_ podataka",
						"loadingRecords": "Učitavanje...",
						"processing":     "Obrada...",
						"search":         "Filter:",
						"zeroRecords":    "Nema rezultata za zadati kriterijum",
						"paginate": {
							"first":      "Prva",
							"last":       "Poslednja",
							"next":       "Sledeća",
							"previous":   "Predhodna"
						}
    	    		}
				}
			);

			$("#tableProductExternalCategorys").DataTable({
				"stateSave": true,
				"paging":true,
				"processing": true,
        		"serverSide": true,
        		"ajax":{
        		        url :"modules/"+moduleName+"/library/functions.php", // json datasource
        		        type: "post",  // method  , by default get
        		        data: ({action : 'getProductExternalCategorys', productid : currentid}),
        		        error: function(){  // error handling
        		            $(".tableProductExternalCategorys-grid-error").html("");
        		            $("#tableProductExternalCategorys").append('<tbody class="tableProductExternalCategorys-grid-error"><tr><th colspan="3">Nema podataka u bazi</th></tr></tbody>');
        		            $("#tableProductExternalCategorys-grid_processing").css("display","none");
        		        },
						dataSrc: function(d){
					//console.log(d);
							for(var i = 0; i < d.aaData.length;i++)
							{
								///var location = window.location.origin+'/admin/fajlovi/member/'+d.aaData[i][2];
								//var bc = '<a href="'+location+'" target="_blank" class="btn btn-primary showDocumentFile" id="'+d.aaData[i][99]+'" >Pogledaj</a> ';
								//d.aaData[i][2] = bc;
								
							}
							return d.aaData;
						}
           		 },
    	    	"language": {
    	    	   		"emptyTable":     "Nema podataka za prikaz",
						"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
						"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
						"infoFiltered":   "(filtrirano od _MAX_ podataka)",
						"infoPostFix":    "",
						"thousands":      ",",
						"lengthMenu":     "Prikazi _MENU_ podataka",
						"loadingRecords": "Učitavanje...",
						"processing":     "Obrada...",
						"search":         "Filter:",
						"zeroRecords":    "Nema rezultata za zadati kriterijum",
						"paginate": {
							"first":      "Prva",
							"last":       "Poslednja",
							"next":       "Sledeća",
							"previous":   "Predhodna"
						}
    	    		}
				}
			);


		}
		
	};
	$('#tableProductCategorys tbody').on('click', '.deleteButton', function () {
			deleteProductCategory_handler($(this));
	});

	if($(".content-wrapper").attr('currentview') == 'change'){
		var currentid =$(".content-wrapper").attr('currentid');
		if(currentid>0){
			$("#tableProductApplication").DataTable({
				"stateSave": true,
				"paging":true,
				"processing": true,
        		"serverSide": true,
        		"ajax":{
        		        url :"modules/"+moduleName+"/library/functions.php", // json datasource
        		        type: "post",  // method  , by default get
        		        data: ({action : 'getProductApplications', productid : currentid}),
        		        error: function(){  // error handling
        		            $(".tableProductApplication-grid-error").html("");
        		            $("#tableProductApplication").append('<tbody class="tableProductApplication-grid-error"><tr><th colspan="3">Nema podataka u bazi</th></tr></tbody>');
        		            $("#tableProductApplication-grid_processing").css("display","none");
        		        },
						dataSrc: function(d){
					//console.log(d);
							for(var i = 0; i < d.aaData.length;i++)
							{
								if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('activate') == '1'))
								{
									var clone = $(".selectProductApplicationStatusTemplate").clone(true).removeClass('hide').removeClass('selectProductApplicationStatusTemplate').addClass('background-status-'+d.aaData[i][3]).attr('id', d.aaData[i][99]).attr('currentStatus', d.aaData[i][3]);
									$(clone).find("option[value='"+d.aaData[i][3]+"']").attr('selected', 'selected');
								}else{
									var clone = $(".selectProductApplicationStatusTemplate").clone(true).removeClass('hide').removeClass('.selectProductApplicationStatusTemplate').attr('disabled', 'disabled');
									$(clone).find("option[value='"+d.aaData[i][3]+"']").attr('selected', 'selected');
								}	
								d.aaData[i][3] = $(clone).wrap('<div>').parent().html();	

								if($("body").attr("user") == "admin" )
								{
									bd = '<button class="btn btn-danger deleteButton" productid="'+d.aaData[i][98]+'" id="'+d.aaData[i][99]+'" style="width:80px;">Obriši</button> ';
								}
								d.aaData[i][5] = bd;
							}
							return d.aaData;
						}
           		 },
    	    	"language": {
    	    	   		"emptyTable":     "Nema podataka za prikaz",
						"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
						"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
						"infoFiltered":   "(filtrirano od _MAX_ podataka)",
						"infoPostFix":    "",
						"thousands":      ",",
						"lengthMenu":     "Prikazi _MENU_ podataka",
						"loadingRecords": "Učitavanje...",
						"processing":     "Obrada...",
						"search":         "Filter:",
						"zeroRecords":    "Nema rezultata za zadati kriterijum",
						"paginate": {
							"first":      "Prva",
							"last":       "Poslednja",
							"next":       "Sledeća",
							"previous":   "Predhodna"
						}
    	    		}
				}
			);


		}

		$(".addProductApplication").on('click', function(){
				var productid =$(".content-wrapper").attr('currentid');
				var newtype = $(".selectApplicationType").val();
				var newLink = $(".newProductAppLink").val();
				addProductApplication_handler(productid,newtype,newLink);
		});
		
	};
	$('#tableProductApplication tbody').on('click', '.deleteButton', function () {
			deleteProductApplication_handler($(this));
	});
	$('#tableProductApplication tbody').on('change', '.selectProductApplicationStatus', function () {
			//showLoadingIcon();
			changeProductApplicationStatus_handler($(this));
	});


/*
	if($(".content-wrapper").attr('currentview') == 'change'){
		var currentid =$(".content-wrapper").attr('currentid');
		if(currentid>0){
			$("#tableMemberDocuments").DataTable({
				"stateSave": true,
				"paging":true,
				"processing": true,
        		"serverSide": true,
        		"ajax":{
        		        url :"modules/"+moduleName+"/library/functions.php", // json datasource
        		        type: "post",  // method  , by default get
        		        data: ({action : 'getMemberDocuments', memberid : currentid}),
        		        error: function(){  // error handling
        		            $(".tableMemberDocuments-grid-error").html("");
        		            $("#tableMemberDocuments").append('<tbody class="tableMemberDocuments-grid-error"><tr><th colspan="3">Nema podataka u bazi</th></tr></tbody>');
        		            $("#tableMemberDocuments-grid_processing").css("display","none");
        		        },
						dataSrc: function(d){
					//console.log(d);
							for(var i = 0; i < d.aaData.length;i++)
							{

								if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('activate') == '1'))
								{
									var clone = $(".selectDocumentStatusTemplate").clone(true).removeClass('hide').removeClass('selectDocumentStatusTemplate').addClass('background-documentstatus-'+d.aaData[i][4]).attr('id', d.aaData[i][99]).attr('currentStatus', d.aaData[i][4]).attr('disabled', 'disabled');
									$(clone).find("option[value='"+d.aaData[i][4]+"']").attr('selected', 'selected');
								}else{
									var clone = $(".selectDocumentStatusTemplate").clone(true).removeClass('hide').removeClass('selectDocumentStatusTemplate').attr('disabled', 'disabled');
									$(clone).find("option[value='"+d.aaData[i][4]+"']").attr('selected', 'selected');
								}	
								d.aaData[i][4] = $(clone).wrap('<div>').parent().html();				
		
								if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('activate') == '1'))
								{
									var clone = $(".selectSolvedStatusTemplate").clone(true).removeClass('hide').removeClass('selectSolvedStatusTemplate').addClass('background-solvedstatus-'+d.aaData[i][5]).attr('id', d.aaData[i][99]).attr('currentStatus', d.aaData[i][5]).attr('disabled', 'disabled');
									$(clone).find("option[value='"+d.aaData[i][5]+"']").attr('selected', 'selected');
								}else{
									var clone = $(".selectSolvedStatusTemplate").clone(true).removeClass('hide').removeClass('selectSolvedSolvedStatusTemplate').attr('disabled', 'disabled');
									$(clone).find("option[value='"+d.aaData[i][5]+"']").attr('selected', 'selected');
								}	
								d.aaData[i][5] = $(clone).wrap('<div>').parent().html();






								var bc = '<a href="document/change/'+d.aaData[i][99]+'" target="_blank" class="btn btn-primary showMemberDocument" id="'+d.aaData[i][99]+'" >Pogledaj</a> ';
								d.aaData[i][6] = bc;
							}
							return d.aaData;
						}
           		 },
    	    	"language": {
    	    	   		"emptyTable":     "Nema podataka za prikaz",
						"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
						"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
						"infoFiltered":   "(filtrirano od _MAX_ podataka)",
						"infoPostFix":    "",
						"thousands":      ",",
						"lengthMenu":     "Prikazi _MENU_ podataka",
						"loadingRecords": "Učitavanje...",
						"processing":     "Obrada...",
						"search":         "Filter:",
						"zeroRecords":    "Nema rezultata za zadati kriterijum",
						"paginate": {
							"first":      "Prva",
							"last":       "Poslednja",
							"next":       "Sledeća",
							"previous":   "Predhodna"
						}
    	    		}
				}
			);

		}
		
	};*/

	/*$("#importMemberFileForm").on("submit", function(e){
		e.preventDefault();
			if($(".memberFilePath").val() != "" && $(".memberFileName").val() != '')
			{
				formD = new FormData(this);
				formD.append('memberid',$(".content-wrapper").attr('currentid'));
				formD.append('memberfilename',$(".memberFileName").val());
				$.ajax({
					url:"modules/"+moduleName+"/library/import-file.php",
					type: "POST",           
					data: formD,
					contentType: false,      
					cache: false,            
					processData:false,    
					success: function(response)
					{
						alertify.success('Uspešno ste uplodovali fajl.');
						$('.memberFileName').val('');
						$('.memberFilePath').val('');
						
						$('#tableMemberFiles').DataTable().ajax.reload();
						//document.location.reload();	
					}
				});
			} else {
				alert('Sva polja su obavezna!');
			}	
	});*/

	/*$('.selectDistrict').select2();
	$(".reloadDistrict").on("click", function(){
		setDistinctSelect2Data('show');	
	});
	$('.selectCity').select2();
	$(".reloadCity").on("click", function(){
		setCitySelect2Data('show');	
	});
	$('.selectTownship').select2();
	$(".reloadTownship").on("click", function(){
		setTownshipSelect2Data('show');	
	});
	$('.selectStreet').select2();
	$(".reloadStreet").on("click", function(){
		setStreetSelect2Data('show');	
	});
	$('.selectLocalCommunity').select2();
	$(".reloadLocalCommunity").on("click", function(){
		setLocalCommunitySelect2Data('show');	
	});

	$('.selectPartyPossition').select2();

	$('.selectQualificationLevel').select2();
	*/
	/*SEARCH*/
	
	$('.searchProductActiveSelect').select2();
	$('.searchProductTypeSelect').select2();
	$('.searchProductWithImageSelect').select2();
	$('.searchProductWithCategorySelect').select2();
	$('.searchProductWithExtCategorySelect').select2();
	
	/*SEARCH END*/
	/*INITIALIZE SEARCH*/

	//$('.searchDistrictSelect').html('').select2({data: [{id: '0', text: '---'}]});
	//$('.searchCitySelect').html('').select2({data: [{id: '0', text: '---'}]});
	//$('.searchTownShipSelect').html('').select2({data: [{id: '0', text: '---'}]});
	//$('.searchStreetsSelect').html('').select2({data: [{id: '0', text: '---'}]});
	//$('.searchLocalCommunitySelect').html('').select2({data: [{id: '0', text: '---'}]});
	showLoadingIcon();
	//var search_districtid =$('.searchDistrictSelect').attr('selectedid');
	//var search_cityid =$('.searchCitySelect').attr('selectedid');
	//var search_townshipid =$('.searchTownShipSelect').attr('selectedid');
	//var search_streetid =$('.searchStreetsSelect').attr('selectedid');
	//var search_localcommunityid =$('.searchLocalCommunitySelect').attr('selectedid');

	//if(setSearchDistrictSelect2Data('reload')){
		//setSearchCitySelect2Data(search_districtid);
		//setSearchTownShipSelect2Data(search_cityid);
		//setSearchStreetSelect2Data(search_townshipid);
		//setSearchLocalCommunitySelect2Data(search_localcommunityid);
		
	//}




	hideLoadingIcon();
	/*INITIALIZE SEARCH END*/
	/*SET DEFAULT SEARCH VALUES*/
	//$('.searchDistrictSelect').val('21').trigger('change');
	
	/*SET DEFAULT SEARCH VALUES END*/
/*
	$('.searchDistrictSelect').on('select2:select', function (e) {
  			
  			var data = e.params.data;
  			if(data.id==''|| data.id=='0'|| data.id==0){
  				$('.searchCitySelect').val('0');
  				$('.searchCitySelect').trigger('change');
  				$('.searchTownShipSelect').val('0');
  				$('.searchTownShipSelect').trigger('change');
  				$('.searchLocalCommunitySelect').val('0');
  				$('.searchLocalCommunitySelect').trigger('change');
  				$('.searchStreetsSelect').val('0');
  				$('.searchStreetsSelect').trigger('change');

  				if($('.searchCitySelect').attr('disabled')!='disabled'){
  					$('.searchCitySelect').attr('disabled','disabled');	
  				}
  				if($('.searchTownShipSelect').attr('disabled')!='disabled'){
  					$('.searchTownShipSelect').attr('disabled','disabled');	
  				}
  				if($('.searchLocalCommunitySelect').attr('disabled')!='disabled'){
  					$('.searchLocalCommunitySelect').attr('disabled','disabled');	
  				}
  				if($('.searchStreetsSelect').attr('disabled')!='disabled'){
  					$('.searchStreetsSelect').attr('disabled','disabled');	
  				}
  			} else {
  				$('.searchCitySelect').removeAttr('disabled');
  				$('.searchCitySelect').val('0').trigger('change').attr('selectedid','0');
  				$('.searchTownShipSelect').val('0').trigger('change').attr('selectedid','0');
  				$('.searchLocalCommunitySelect').val('0').trigger('change').attr('selectedid','0');;
  				$('.searchStreetsSelect').val('0').trigger('change').attr('selectedid','0');

  				setSearchCitySelect2Data(data.id,'reload');

  				
  				
  				
  			}
	});

	$('.searchCitySelect').on('select2:select', function (e) {
  			
  			var data = e.params.data;
  			if(data.id==''|| data.id=='0'|| data.id==0){

  				$('.searchTownShipSelect').val('0');
  				$('.searchTownShipSelect').trigger('change');
  				$('.searchLocalCommunitySelect').val('0');
  				$('.searchLocalCommunitySelect').trigger('change');
  				$('.searchStreetsSelect').val('0');
  				$('.searchStreetsSelect').trigger('change');

  				if($('.searchTownShipSelect').attr('disabled')!='disabled'){
  					$('.searchTownShipSelect').attr('disabled','disabled');	
  				}
  				if($('.searchLocalCommunitySelect').attr('disabled')!='disabled'){
  					$('.searchLocalCommunitySelect').attr('disabled','disabled');	
  				}
  				if($('.searchStreetsSelect').attr('disabled')!='disabled'){
  					$('.searchStreetsSelect').attr('disabled','disabled');	
  				}
  			} else {
  				$('.searchTownShipSelect').removeAttr('disabled');
  				$('.searchTownShipSelect').val('0').trigger('change').attr('selectedid','0');
  				$('.searchLocalCommunitySelect').val('0').trigger('change').attr('selectedid','0');
  				$('.searchStreetsSelect').val('0').trigger('change').attr('selectedid','0');



  				setSearchTownShipSelect2Data(data.id,'reload');
  				
  			}
	});


	$('.searchTownShipSelect').on('select2:select', function (e) {
  			
  			var data = e.params.data;
  			if(data.id==''|| data.id=='0'|| data.id==0){


  				$('.searchLocalCommunitySelect').val('0');
  				$('.searchLocalCommunitySelect').trigger('change');
  				$('.searchStreetsSelect').val('0');
  				$('.searchStreetsSelect').trigger('change');

  				if($('.searchLocalCommunitySelect').attr('disabled')!='disabled'){
  					$('.searchLocalCommunitySelect').attr('disabled','disabled');	
  				}
  				if($('.searchStreetsSelect').attr('disabled')!='disabled'){
  					$('.searchStreetsSelect').attr('disabled','disabled');	
  				}
  			} else {
  				$('.searchLocalCommunitySelect').removeAttr('disabled');
  				$('.searchLocalCommunitySelect').val('0').trigger('change').attr('selectedid','0');
  				
  				$('.searchStreetsSelect').removeAttr('disabled');
  				$('.searchStreetsSelect').val('0').trigger('change').attr('selectedid','0');
  				setSearchLocalCommunitySelect2Data(data.id,'reload');
  				setSearchStreetSelect2Data(data.id,'reload');
  			}
	});
*/
	

	$("#listtable").DataTable({
		stateSave: true,
		"processing": true,
        "serverSide": true,
        "ajax":{
                url :"modules/"+moduleName+"/library/getdata.php", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".listtable-grid-error").html("");
                    $("#listtable").append('<tbody class="listtable-grid-error"><tr><th colspan="3">Nema podataka u bazi</th></tr></tbody>');
                    $("#listtable-grid_processing").css("display","none");
                },
				dataSrc: function(d){
					//console.log(d);
					
					for(var i = 0; i < d.aaData.length;i++)
					{
						
						var img = '<img src="'+d.aaData[i][3]+'" class="img-responsive" style="width:50px; height:50px;" /> ';
						d.aaData[i][3] = img;
						
						if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('activate') == '1'))
						{
							var clone = $(".selectTypeShortTemplate").clone(true).removeClass('hide').removeClass('.selectTypeShortTemplate').addClass('background-type-'+d.aaData[i][6]).attr('id', d.aaData[i][99]).attr('currentType', d.aaData[i][6]).attr('disabled', 'disabled');
							$(clone).find("option[value='"+d.aaData[i][6]+"']").attr('selected', 'selected');
						}else{
							var clone = $(".selectTypeShortTemplate").clone(true).removeClass('hide').removeClass('.selectTypeShortTemplate').attr('disabled', 'disabled');
							$(clone).find("option[value='"+d.aaData[i][6]+"']").attr('selected', 'selected');
						}	
						d.aaData[i][6] = $(clone).wrap('<div>').parent().html();


						if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('activate') == '1'))
						{
							var clone = $(".selectStatusTemplate").clone(true).removeClass('hide').removeClass('selectStatusTemplate').addClass('background-status-'+d.aaData[i][7]).attr('id', d.aaData[i][99]).attr('currentStatus', d.aaData[i][7]);
							$(clone).find("option[value='"+d.aaData[i][7]+"']").attr('selected', 'selected');
						}else{
							var clone = $(".selectStatusTemplate").clone(true).removeClass('hide').removeClass('.selectStatusTemplate').attr('disabled', 'disabled');
							$(clone).find("option[value='"+d.aaData[i][7]+"']").attr('selected', 'selected');
						}	
						d.aaData[i][7] = $(clone).wrap('<div>').parent().html();				


						

						var bc = '<button class="btn btn-primary disabled " disabled="disabled">Izmeni</button> ';
						if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('change') == '1'))
						{
							var bc = '<button class="btn btn-primary changeViewButton" style="width:80px;" id="'+d.aaData[i][99]+'">Izmeni</button> ';
						}
						var bd = "";
						if($("body").attr("user") == "admin" )
						{
							bd = '<button class="btn btn-danger deleteButton" id="'+d.aaData[i][99]+'" style="width:80px;">Obriši</button> ';
						}
						d.aaData[i][13] = bc + bd;





					}
					return d.aaData;
				}
            },
        "language": {
           		"emptyTable":     "Nema podataka za prikaz",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
				"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
				"infoFiltered":   "(filtrirano od _MAX_ podataka)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikazi _MENU_ podataka",
				"loadingRecords": "Učitavanje...",
				"processing":     "Obrada...",
				"search":         "Filter:",
				"zeroRecords":    "Nema rezultata za zadati kriterijum",
				"paginate": {
					"first":      "Prva",
					"last":       "Poslednja",
					"next":       "Sledeća",
					"previous":   "Predhodna"
				}
        	}
		});
		
		$('#listtable tbody').on('click', '.deleteButton', function () {
			deleteItem_handler($(this));
		}).on('change', '.selectStatus', function () {
			showLoadingIcon();
			changestatus_handler($(this));
		}).on('click', '.changeViewButton', function () {
			//window.location.href = window.location.pathname+'/change/'+$(this).attr('id');
			var win = window.open(window.location.pathname+'/change/'+$(this).attr('id'), '_blank');
  			win.focus();
		});
		
		$("#addButton").on("click", function(){
			window.location.href = window.location.pathname+'/add';
		});
		
		$("#listButton").on("click", function(){
			window.location.href = 'product';
		});
		

		if($(".content-wrapper").attr('currentview') == 'change'){
			createAddChangeForm();	
			
			$(".saveAddChange").on('click', function(){
					showLoadingIcon();
					saveAddChange();
			});
			
			$(".addButton").on("click", function(){
				window.location.href = window.location.pathname+'/add';
			});
			$(".addProductCategory").on('click', function(){
				//showLoadingIcon();
				//saveAddChange();
				var currentid =$(".content-wrapper").attr('currentid');
				addProductCategory_handler(currentid,$('.productCategory').val());
			});

		}
		
		if($(".content-wrapper").attr('currentview') == 'add'){
			createAddChangeForm();	
			
			$(".saveAddChange").on('click', function(){
				showLoadingIcon();
				saveAddChange();
			});

			
		}
		
		$("#searchForm").on("submit", function(event){
			event.preventDefault();
			dataSearch();
   			
 		});

 		$(".clearSearch").on("click", function(event){
			event.preventDefault();
			clearSearch();
   			
 		});


 		/*$('.selectDistrict').on('select2:select', function (e) {
  			
  			var data = e.params.data;
  			if(data.id==''|| data.id=='0'|| data.id==0){
  				$('.selectCity').html('').select2({data: [{id: '0', text: '---'}]});
  				$('.selectCity').val('0').trigger('change');
  				$('.selectCity').attr('disabled','disabled');

  				$('.selectTownship ').html('').select2({data: [{id: '0', text: '---'}]});
  				$('.selectTownship ').val('0').trigger('change');
  				$('.selectTownship ').attr('disabled','disabled');

  				$('.selectLocalCommunity  ').html('').select2({data: [{id: '0', text: '---'}]});
  				$('.selectLocalCommunity  ').val('0').trigger('change');
  				$('.selectLocalCommunity  ').attr('disabled','disabled');

  				$('.selectStreet  ').html('').select2({data: [{id: '0', text: '---'}]});
  				$('.selectStreet  ').val('0').trigger('change');
  				$('.selectStreet  ').attr('disabled','disabled');


  			} else {
  				setCitySelect2DataByDistrictId(data.id);
  				$('.selectCity').removeAttr('disabled');
  			}


		});*/


		/*$('.selectCity').on('select2:select', function (e) {
  			
  			var data = e.params.data;
  			if(data.id==''|| data.id=='0'|| data.id==0){
  				

  				$('.selectTownship').html('').select2({data: [{id: '0', text: '---'}]});
  				$('.selectTownship').val('0').trigger('change');
  				$('.selectTownship').attr('disabled','disabled');

  				$('.selectLocalCommunity').html('').select2({data: [{id: '0', text: '---'}]});
  				$('.selectLocalCommunity').val('0').trigger('change');
  				$('.selectLocalCommunity').attr('disabled','disabled');

  				$('.selectStreet').html('').select2({data: [{id: '0', text: '---'}]});
  				$('.selectStreet').val('0').trigger('change');
  				$('.selectStreet').attr('disabled','disabled');
  				

  			} else {
  				setTownshipSelect2DataByCityId(data.id);
  				$('.selectTownship').removeAttr('disabled');
  			}


		});*/

		/*$('.selectTownship').on('select2:select', function (e) {
  			
  			var data = e.params.data;
  			if(data.id==''|| data.id=='0'|| data.id==0){

  				$('.selectLocalCommunity').html('').select2({data: [{id: '0', text: '---'}]});
  				$('.selectLocalCommunity').val('0').trigger('change');
  				$('.selectLocalCommunity').attr('disabled','disabled');

  				$('.selectStreet').html('').select2({data: [{id: '0', text: '---'}]});
  				$('.selectStreet').val('0').trigger('change');
  				$('.selectStreet').attr('disabled','disabled');
  				

  			} else {
  				setStreetSelect2DataByTownshipId(data.id);
  				setLocalCommunitySelect2DataByTownshipId(data.id);
  				$('.selectStreet').removeAttr('disabled');
  				$('.selectLocalCommunity').removeAttr('disabled');
  			}


		});*/
		

		
});