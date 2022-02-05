function checkImageExisting(path){
	var string = path;
	var ext = string.split('.').pop();
	if(ext == "jpg" || ext == "jpeg" || ext == "png" || ext == "gif")
	{
		var image = new Image(); 
		image.src = '../'+path;
		if (image.width == 0) {
		  return false;
		}else{
			return true;	
		}
	}
	else{
		return false;
	}
}

function clearCategoryDetail(){
	for(var i = 0; i < lang.length; i++)
	{
		$("."+lang[i][0]+"_categoryName").val("");	
	}
	$(".b2ccategory").prop("checked", false);	
	$(".b2bcategory").prop("checked", false);	
	$(".b2cprice").prop("checked", false);	
	$(".b2bprice").prop("checked", false);	
	
	$(".categoryMainImageCont").html("");
	
	$(".categoryDetailItemCont").html("");
	$(".categoryAttrCont").html("");
	
}
$(document).ready(function(e) {
	// jstree start
	var handlerpath = "modules/"+moduleName+"/library/tree_handler.php";
	$(window).resize(function () {
		var h = Math.max($(window).height() - 0, 420);
		$('#container, #data,  #data .content').height(h).filter('.default').css('lineHeight', h + 'px');
	}).resize();
	
	$('#tree')
		.jstree({
			'core' : {
				'data' : {
					'url' : handlerpath+'?operation=get_node',
					'data' : function (node) {
						//console.log("---------");
						//console.log(node);
						return { 'id' : node.id };
					},
					'success': function(re){
						
						//console.log(re);	
					}
				},
				'check_callback' : true,
				'force_text' : false,
				'themes' : {
					'responsive' : false,
					'variant' : 'small',
					'stripes' : true
				}
			},
			'contextmenu' : {
				'items' : function(node) {
					var tmp = $.jstree.defaults.contextmenu.items();
					delete tmp.rename;
					delete tmp.create;	
					delete tmp.ccp;
					
					tmp.remove.label="Obriši";
					if(this.get_type(node) === "file") {
						delete tmp.create;
					}
					return tmp;
				}
			},
			'sort' : function (a, b) { 
						return parseInt(this.get_node(a).original.sort) > parseInt(this.get_node(b).original.sort) ? 1 : -1; 
					},
			'types' : {
				'default' : { 'icon' : 'folder' },
				'file' : { 'valid_children' : [], 'icon' : 'file' }
			},
			'unique' : {
				'duplicate' : function (name, counter) {
					return name + ' ' + counter;
				}
			},
			'plugins' : ['state','sort','types', 'contextmenu','unique', 'dnd']
		})
		.on('delete_node.jstree', function (e, data) {
			var a = confirm("Da li ste sigurni da zelite da obrisete stavku?");
			if(a)
			{
				$.get(handlerpath+'?operation=delete_node', { 'id' : data.node.id })
					.done(function (d) {
						if(d.status == 'OK')
						{
							data.instance.set_id(data.node, d.id);
							clearMenuData();
							$(".menuid").attr('parentid', "");
							$(".menuid").attr('menuid', "");
						}else{
							alert(d.msg);
							data.instance.refresh();
						}						
					})
					.fail(function () {
						data.instance.refresh();
					});
			}
		})
		.on('create_node.jstree', function (e, data) {
			$.get(handlerpath+'?operation=create_node', { 'type' : data.node.type, 'id' : data.node.parent, 'text' : data.node.text })
				.done(function (d) {
					data.instance.set_id(data.node, d.id);
				})
				.fail(function () {
					data.instance.refresh();
				});
		})
		.on('rename_node.jstree', function (e, data) {
			$.get(handlerpath+'?operation=rename_node', { 'id' : data.node.id, 'text' : data.text })
				.done(function (d) {
					data.instance.set_id(data.node, d.id);
				})
				.fail(function () {
					data.instance.refresh();
				});
		})
		.on('move_node.jstree', function (e, data) {
			$.get(handlerpath+'?operation=move_node', 
					{
					'id' : data.node.id,
					'parent' : data.parent,
					'position' : data.position,
					'oldparent' : data.old_parent,
					'oldposition' : data.old_position
				 })
				.done(function (d) {
					//data.instance.load_node(data.parent);
					data.instance.refresh();
					//console.log(d);
				})
				.fail(function () {
					//data.instance.refresh();
					alert('fail');
				});
		})
		.on('copy_node.jstree', function (e, data) {
			$.get(handlerpath+'?operation=copy_node', { 'id' : data.original.id, 'parent' : data.parent })
				.done(function (d) {
					//data.instance.load_node(data.parent);
					data.instance.refresh();
				})
				.fail(function () {
					data.instance.refresh();
				});
		})
		.on('changed.jstree', function (e, data) {
			if(data && data.selected && data.selected.length && data.action == "select_node") {
				var id = data.selected.join(':');
				$.get(handlerpath+'?operation=get_content&id=' + data.selected.join(':'), function (d) {
					if(d) {
						
						clearCategoryDetail();
						$(".detailCategoryCont").attr("catid", d.id);
						$("#catID").val(d.id);
						
						$('#catMargin').val(d.margin);
						$('#catSlug').val(d.slug);
						
						$('.newCatNameCont').html('');
						for(var i = 0; i < (d.lang).length; i++){
							var clone = $(".newCatNameHolderTemplate").clone(true).removeClass('hide').removeClass('newCatNameHolderTemplate').addClass('newCatNameHolder').attr('langid', d.lang[i].langid).attr('defaultlang', d.lang[i].default)	
							
							$(clone).find('h4').html(d.lang[i].langname);
							$(clone).find('.categoryName').val(d.lang[i].name);
							$(clone).find('.categoryDescription').val(d.lang[i].description);
							
							$(clone).appendTo($('.newCatNameCont'));
						}
						
						if(d.b2cprice == 1) $(".b2cprice").prop('checked', true);
						if(d.b2bprice == 1) $(".b2bprice").prop('checked', true);
						if(d.b2ccategory == 1) $(".b2ccategory").prop('checked', true);	
						if(d.b2bcategory == 1) $(".b2bcategory").prop('checked', true);	
						
						// main color
						
						$(".categoryColorLink").val('');
						if(d.mc.content != null){
							$(".categoryColorLink").val(d.mc.content);
							$(".mainColorCont").find("span").addClass('hide');
						} else {
							$(".mainColorCont").find("span").removeClass('hide');
						}
						
						
						
						if(d.detail.hasOwnProperty('img')){
							for(var i = 0; i < d.detail.img.length; i++)
							{
								var clone = $(".categoryMainImageTemplate").clone(true);
								
								$(clone).children("img").attr("src","../"+d.detail.img[i][0]).attr("data-featherlight", "../"+d.detail.img[i][0]);
								if(d.detail.img[i][2] == 1)
								{
									$(clone).children("input").attr("checked", true);
								}
								$(clone).children("input").val(d.detail.img[i][3]);
								
								$(clone).removeClass("hide").removeClass("categoryMainImageTemplate").appendTo(".categoryMainImageCont");		
							}
						}
						
						
									
						for (var prop in d.detail) {
							if(prop != "img" && d.detail[prop].length > 0)
							{
								for(var j = 0; j < d.detail[prop].length; j++ )
								{
									var clone = $(".categoryDetailItemTemplate").clone(true);
									$(clone).attr("detailid",d.detail[prop][j][3] );
									if(prop == "doc"){
										$(clone).children('td').eq(0).html("Dokument");
										var file = d.detail[prop][j][0].split("/");
										$(clone).children('td').eq(1).html("<a href='../"+d.detail[prop][j][0]+"'>"+file[file.length-1]+"</a>");
										var img = "";
										if(d.detail[prop][j][1] != "")
										img = $(document.createElement("img")).attr("height", "50").attr("src", "../"+d.detail[prop][j][1]).attr("data-featherlight", "../"+d.detail[prop][j][1]);
										$(clone).children('td').eq(2).html(img);
									}
									if(prop == "icon"){
										$(clone).children('td').eq(0).html("Ikona");
									
										var img = "";
										if(d.detail[prop][j][0] != "")
										img = $(document.createElement("img")).attr("height", "50").attr("src", "../"+d.detail[prop][j][0]).attr("data-featherlight", "../"+d.detail[prop][j][0]);
										$(clone).children('td').eq(1).html(img);
										$(clone).children('td').eq(2).html("");	
									}
									if(prop == "yt"){
										$(clone).children('td').eq(0).html("Youtube");
										$(clone).children('td').eq(1).html('<iframe height="150" src="'+d.detail[prop][j][0]+'" frameborder="0" allowfullscreen></iframe>');
										$(clone).children('td').eq(2).html("");		
									}
									if(prop == "ext"){
										$(clone).children('td').eq(0).html("Externi");
										$(clone).children('td').eq(1).html("<a target='_blank' href='../"+d.detail[prop][j][0]+"'>"+d.detail[prop][j][0]+"</a>");
										$(clone).children('td').eq(2).html("");		
									}
									$(clone).removeClass("hide").removeClass("categoryDetailItemTemplate").appendTo(".categoryDetailItemCont");			
								}
							}
						}
						
						/*	get category atributes	*/
		
						
						$.ajax({
							type:"POST",
							url:"modules/"+moduleName+"/library/functions.php",
							data: ({action: "getcategoryatributes",
									catid: $(".detailCategoryCont").attr("catid")
									}),
							error:function(XMLHttpRequest, textStatus, errorThrown){
							  alert("ERROR");                            
							},
							success:function(response){
								var a = JSON.parse(response);
								
								if(a[0] == 0){
									for(var i = 0; i < a[1].length; i++)
									{
										var clone = $(".categoryAttrTemplate").clone(true);
										$(clone).attr("attrcatid", a[1][i][0]).children("span").eq(0).html(a[1][i][1]);
										$(clone).find('.selectIsMandatory').prop('checked', ((a[1][i][2] == 1)? true:false));
										$(clone).find('.selectSpecificationFlag').prop('checked', ((a[1][i][3] == 1)? true:false));
										
										$(clone).removeClass("hide").removeClass("categoryAttrTemplate").appendTo(".categoryAttrCont");	
									}
								}	
							}
						});	
						
						
						/*	QUANTITY REBATE	*/
						
						for(var i = 0; i < (d.qtyrebate).length; i++){
							var clone = $(".jq_categoryQuantityRebateTemplate").clone(true).removeClass('hide').removeClass('jq_categoryQuantityRebateTemplate').attr('itemid', d.qtyrebate[i]['id']);
							$(clone).find('.jq_categoryQuantityHolder').html(d.qtyrebate[i]['quantity']);
							$(clone).find('.jq_categoryRebateHolder').html(d.qtyrebate[i]['rebate']);
							$(clone).find('.jq_categoryStatusHolder').val(d.qtyrebate[i]['status']);
							
							$(clone).appendTo($('.jq_categoryQuantityRebateCont').find('tbody'));
						}
						
					}
					
				});
			}
			else {
				$('#data .content').hide();
				$('#data .default').html('Select a item from the tree.').show();
			}
			
			
		}).on('ready.jstree', function (e, data) {
			//alert(data.instance.get_selected());
			//$(".detailCategoryCont").attr("catid", data.instance.get_selected());
			//console.log(data.instance.get_selected());
			//data.instance.select_node(["dokumenta"]);
		});
		
		
		
		/* sort category atributes	*/
		
		$( "#sortable" ).sortable({
		  placeholder: "ui-state-highlight",
		  stop: function( event, ui ) {
			var data = [];
			$(".categoryAttrCont").find(".list-group-item").each(function(){
				data.push($(this).attr('attrcatid'))	
			});
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "updateattrcatsort",
						items: data,
						categoryid: $(".detailCategoryCont").attr("catid")
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
		
		/*	add main new image	*/
		
		$(".addNewCategoryImageButton").on("click", function(){
			var imgcheck = checkImageExisting($(".categoryNewImage").val());
			
			alert(imgcheck);
			
			if($(".categoryNewImage").val() != "" && imgcheck){
				$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "addnewcatdetail",
							type: "img",
							catid: $(".detailCategoryCont").attr("catid"),
							cont: $(".categoryNewImage").val(),
							contimg: ""
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						console.log(response);
						var a = JSON.parse(response);
						if(a[0] == 0){
							var clone = $(".categoryMainImageTemplate").clone(true);
							$(clone).attr("catdetaildid", a[1]).children("img").attr("src","../"+$(".categoryNewImage").val()).attr("data-featherlight", "../"+$(".categoryNewImage").val() );
							$(clone).children("input").val(a[1]);
							$(clone).removeClass("hide").removeClass("categoryMainImageTemplate").appendTo(".categoryMainImageCont");
						}
						else{
							alert("Greska prilikom dodavanja");
						}	
					}
				});	
				
				
			}
		});
		
		/*	change category prmary image	*/
		
		$('.primaryCategoryImage:radio[name="primaryCategoryImage"]').change(function() {
			var category = $(this).filter(':checked').val();
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "changecategorymainimage",
						catid: $(".detailCategoryCont").attr("catid"),
						primaryid: $(this).filter(':checked').val()
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					console.log(response);
					
				}
			});	
				
				
		});
		
		/*delete category image	*/
		
		$(".deleteMainImageButton").on("click", function(){
			var $this = $(this);
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "deletemainimage",
						id: $(this).parent().find("input").val()
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
					if(a[0] == 0)
					{
						$($this).parent().remove();	
					}
				}
			});
		});
		
		/*	add new categoory detail	*/
		
		$(".addCategoryDetail").on("click", function(){
			if($(".newCategoryDetailContent").val() != "")
			{
				$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "addnewcatdetail",
							type: $(".newCategoryDetailType").val(),
							catid: $(".detailCategoryCont").attr("catid"),
							cont: $(".newCategoryDetailContent").val(),
							contimg: $(".newCategoryDetailContentimg").val()
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						console.log(response);
						var a = JSON.parse(response);
						if(a[0] == 0){
							
							var prop = $(".newCategoryDetailType").val();
							var clone = $(".categoryDetailItemTemplate").clone(true);
							
							$(clone).attr("detailid",a[1] );
							
							if(prop == "doc"){
								$(clone).children('td').eq(0).html("Dokument");
							
								var file = $(".newCategoryDetailContent").val().split("/");
								$(clone).children('td').eq(1).html("<a href='../"+$(".newCategoryDetailContent").val()+"'>"+file[file.length-1]+"</a>");
								
								var img = "";
								if($(".newCategoryDetailContentimg").val() != "")
								img = $(document.createElement("img")).attr("height", "50").attr("src", "../"+$(".newCategoryDetailContentimg").val()).attr("data-featherlight", "../"+$(".newCategoryDetailContentimg").val());
								$(clone).children('td').eq(2).html(img);
							}
							
							if(prop == "yt"){
								$(clone).children('td').eq(0).html("Youtube");
							
								$(clone).children('td').eq(1).html('<iframe height="150" src="'+$(".newCategoryDetailContent").val()+'" frameborder="0" allowfullscreen></iframe>');
								$(clone).children('td').eq(2).html("");		
							}
							
							if(prop == "ext"){
								$(clone).children('td').eq(0).html("Externi");
	
								$(clone).children('td').eq(1).html("<a target='_blank' href='../"+$(".newCategoryDetailContent").val()+"'>"+d.detail[prop][j][0]+"</a>");
								$(clone).children('td').eq(2).html("");		
							}
							
							$(clone).removeClass("hide").removeClass("categoryDetailItemTemplate").appendTo(".categoryDetailItemCont");	
							
							$(".newCategoryDetailContent").val("");
							$(".newCategoryDetailContentimg").val("");
						}
						else{
							alert("Greska prilikom dodavanja");
						}	
					}
				});		
			}
		});
		
		/*	delete categoory detail	*/
		
		$(".deleteCategoryDetail").on("click", function(){
			var a = confirm("Da li sigurno zelite da obrisete stavku?");
			if(a){
				var $this = $(this);
				$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "deletecatdetail",
							id: $(this).parent().parent().attr("detailid")
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						var a = JSON.parse(response);
						if(a[0] == 0){
							$($this).parent().parent().remove();
						}
						
					}
				});
						
			}
		});
		
		/*	assignt new atribute to category	*/
		
		$(".addCategoryAttrButton").on("click", function(){
			var found = false;
			$(".categoryAttrCont").find('li[attrcatid="'+$(".allAttrList").val()+'"]').each(function() {
				found = true;
			});
			if(found){
				alert("Atribut je vec dodeljen kategoriji!");	
			}else{
				$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "addattrcategory",
							catid: $(".detailCategoryCont").attr("catid"),
							attrid: $(".allAttrList").val()
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						var a = JSON.parse(response);
						if(a[0] == 0){
							var clone = $(".categoryAttrTemplate").clone(true);
							$(clone).attr("attrcatid", $(".allAttrList").val()).children("span").eq(0).html($(".allAttrList option:selected").text());
							
							$(clone).removeClass("hide").removeClass("categoryAttrTemplate").appendTo(".categoryAttrCont");	
						}
						
					}
				});	
			}
				
		});
		
		/*	delete attr category	*/
		
		$(".deleteAttrCategory").on("click", function(){
			var a = confirm("Da li sigurno zelite da obrisete stavku?");
			if(a){
				var $this = $(this);
				$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "deleteattrcat",
							attrid: $(this).parent().parent().attr("attrcatid"),
							catid : $(".detailCategoryCont").attr("catid")
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						var a = JSON.parse(response);
						if(a[0] == 0){
							$($this).parent().parent().remove();
						}
						
					}
				});
						
			}
		});
		
		
		/*	save category 	*/
		
		$(".saveCategory").on("click", function(){
			var namedata = [];
			if( $("#catSlug").val()!=""){
			if($(".newCatNameCont").find(".newCatNameHolder[defaultlang='y']").find(".categoryName").val() != '')
			{
				$(".newCatNameCont").find(".newCatNameHolder").each(function(){
					var obj = {'langid': $(this).attr('langid'),
								'default' : $(this).attr('defaultlang'),
								'name' : $(this).find('.categoryName').val(),								
								'description' : $(this).find('.categoryDescription').val()};	
					namedata.push(obj);
				});
			}
			else{
				error = true;	
				alert("Unesite naziv");
				$(".newCatNameCont").find(".newCatNameHolder[defaultlang='y']").addClass('has-error');
			}
			
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "savecategory",
						id: $(".detailCategoryCont").attr("catid"),
						name: namedata,
						b2cp: $(".b2cprice").is(':checked') ? 1 : 0,
						b2cc: $(".b2ccategory").is(':checked') ? 1 : 0,
						b2bp: $(".b2bprice").is(':checked') ? 1 : 0,
						b2bc: $(".b2bcategory").is(':checked') ? 1 : 0,
						margin: parseFloat($("#catMargin").val()),
						slug: $("#catSlug").val()
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					console.log(response);
					var a = JSON.parse(response);
					if(a[0] == 0){
						alert("Uspesno snimljeno!");
						$('#tree').jstree("refresh");
					}
					
				}
			});
		} else {
			alert('URL ime je obavezno!');
		}
			
		});
		
		/*	add category 	*/
		
		$(".addCategory").on("click", function(){
			var namedata = [];
			
			if($(".newCatNameCont").find(".newCatNameHolder[defaultlang='y']").find(".categoryName").val() != '')
			{
				$(".newCatNameCont").find(".newCatNameHolder").each(function(){
					var obj = {'langid': $(this).attr('langid'),
								'default' : $(this).attr('defaultlang'),
								'name' : $(this).find('.categoryName').val(),
								'description' : $(this).find('.categoryDescription').val()};	
					namedata.push(obj);
				});
			}
			else{
				error = true;	
				alert("Unesite naziv");
				$(".newCatNameCont").find(".newCatNameHolder[defaultlang='y']").addClass('has-error');
			}
			
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "addcategory",
						id: $(".detailCategoryCont").attr("catid"),
						name: namedata,
						b2cp: $(".b2cprice").is(':checked') ? 1 : 0,
						b2cc: $(".b2ccategory").is(':checked') ? 1 : 0,
						b2bp: $(".b2bprice").is(':checked') ? 1 : 0,
						b2bc: $(".b2bcategory").is(':checked') ? 1 : 0
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					//console.log(response);
					var a = JSON.parse(response);
					if(a[0] == 0){
						$('#tree').jstree("refresh");
						//window.location.reload();
					}
					
				}
			});
			
		});
		
		/*	add main category 	*/

		$(".addCategoryMain").on("click", function(){
			var namedata = [];
			
			if($(".newCatNameCont").find(".newCatNameHolder[defaultlang='y']").find(".categoryName").val() != '')
			{
				$(".newCatNameCont").find(".newCatNameHolder").each(function(){
					var obj = {'langid': $(this).attr('langid'),
								'default' : $(this).attr('defaultlang'),
								'name' : $(this).find('.categoryName').val(),
								'description' : $(this).find('.categoryDescription').val()};	
					namedata.push(obj);
				});
			}
			else{
				error = true;	
				alert("Unesite naziv");
				$(".newCatNameCont").find(".newCatNameHolder[defaultlang='y']").addClass('has-error');
			}
			
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "addcategory",
						id: 0,
						name: namedata,
						b2cp: $(".b2cprice").is(':checked') ? 1 : 0,
						b2cc: $(".b2ccategory").is(':checked') ? 1 : 0,
						b2bp: $(".b2bprice").is(':checked') ? 1 : 0,
						b2bc: $(".b2bcategory").is(':checked') ? 1 : 0
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					//console.log(response);
					var a = JSON.parse(response);
					if(a[0] == 0){
						$('#tree').jstree("refresh");
						//window.location.reload();
					}
				
				}
			});
			
		});
		
		$(".selectIsMandatory").on("change", function(){
			var val = 0;
			if($(this).prop('checked')) val = 1;
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "changeismandatory",
						categoryid: $(".detailCategoryCont").attr("catid"),
						attrid: $(this).parents('li').attr('attrcatid'),
						value: val
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
				}
			});
		});
		
		$(".selectSpecificationFlag").on("change", function(){
			var val = 0;
			if($(this).prop('checked')) val = 1;
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "changespecificationflag",
						categoryid: $(".detailCategoryCont").attr("catid"),
						attrid: $(this).parents('li').attr('attrcatid'),
						value: val
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
				}
			});
		});
		
		$(".categoryColorLink").on("change", function(){
			saveCategoryMainColor_handler($(this));
			
		});
		
		/*	toggle extra detail	*/
	
		$("#toggleCategoryRelations").on("click", function(){
			$(".categoryRelationsCont").slideToggle(function(){
					
			});
		});
		
		$(".categoryList").on("change", function(){
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "changecategoryrelation",
						categoryid: $(this).val(),
						id: $(this).attr('pntcatid')
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
				}
			});
		});
		
		/*	QUANTITY REBATE	*/
		
		$('.jq_addCategoryQuantityReabateButton').on('click', function(){
			if($(".jq_categoryNewQuantityInput").val() != '' && $(".jq_categoryNewRebateInput").val() != ''){
				$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "addNewCategoryQuantity",
							catid: $(".detailCategoryCont").attr("catid"),
							quantity: $(".jq_categoryNewQuantityInput").val(),
							rebate: $(".jq_categoryNewRebateInput").val()
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						if(response > 0)
						{
							if($('.jq_categoryQuantityRebateCont').find('tbody').find('tr[itemid="'+response+'"]').length == 0)
							{
								var clone = $(".jq_categoryQuantityRebateTemplate").clone(true).removeClass('hide').removeClass('jq_categoryQuantityRebateTemplate').attr('itemid', response);
								$(clone).find('.jq_categoryQuantityHolder').html($(".jq_categoryNewQuantityInput").val());
								$(clone).find('.jq_categoryRebateHolder').html($(".jq_categoryNewRebateInput").val());
								$(clone).find('.jq_categoryStatusHolder').val('h');
								
								$(clone).appendTo($('.jq_categoryQuantityRebateCont').find('tbody'));
								
								$(".jq_categoryNewQuantityInput").val('');
								$(".jq_categoryNewRebateInput").val(''); 
							}else{
								$('.jq_categoryQuantityRebateCont').find('tbody').find('tr[itemid="'+response+'"]').find('.jq_categoryRebateHolder').html($(".jq_categoryNewRebateInput").val());
								$(".jq_categoryNewQuantityInput").val('');
								$(".jq_categoryNewRebateInput").val(''); 
							}
						}
					}
				});	
			}else{
				alert("Sva polja su obavezna");	
			}
		});
		
		$(".jq_categoryStatusHolder").on('change', function(){
			$this = $(this);
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "changecategoryquantitystatus",
						status: $(this).val(),
						id: $(this).parents('tr').attr('itemid')
						}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					console.log(response);
				}
			});	
		});
		
		$(".deleteCategoryQuantityRebateItem").on("click", function(){
			var a = confirm("Da li sigurno zelite da obrisete stavku?");
			if(a){
				var $this = $(this);
				$.ajax({
					type:"POST",
					url:"modules/"+moduleName+"/library/functions.php",
					data: ({action: "deletecatrebate",
							id: $(this).parents('tr').attr("itemid")
							}),
					error:function(XMLHttpRequest, textStatus, errorThrown){
					  alert("ERROR");                            
					},
					success:function(response){
						var a = JSON.parse(response);
						if(a[0] == 0){
							$($this).parent().parent().remove();
						}
						
					}
				});
						
			}
		});
		
});

