function deleteItem_handler(elem){
	var $this = $(elem);
	var a = confirm("Da li ste sigurni da zelite da obisete vest?");
	if(a)
	{
		$.ajax({
		  method: "POST",
		  url: "modules/"+moduleName+"/library/functions.php",
		  data: { action: "delete", id: $this.attr("id") }
		}).done(function(result){
			alert("Uspesno obrisano!");
			document.location.reload();
		});		
	}	
}

function changestatus_handler(elem){
	$this = $(elem);
		if($(elem).attr("currentStatus") != $(elem).val())
		{
			$.ajax({
			  method: "POST",
			  url: "modules/"+moduleName+"/library/functions.php",
			  data: { action: "changestatus", id: $this.attr("id"), status:$(elem).val() }
			}).done(function(result){
				$this.removeClass("background-"+$this.attr("currentStatus")).addClass("background-"+$this.val()).attr("currentStatus", $this.val());
				hideLoadingIcon();
			});
			
		}	
}

function createAddChangeForm(){
	if($(".content-wrapper").attr('currentid') != '')
	{
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action : 'getitem',
					id : $(".content-wrapper").attr('currentid')}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				var a = JSON.parse(response);
				$(".addChangeLangCont").html('');
				
				$(".mainimage").val(a.thumb);
				$(".newsdate").val(a.adddate).datepicker({ format: "dd.mm.yyyy"});;
				$(".newsgallerycont").val(a.galleryid);
				for(var i = 0; i < (a.lang).length; i++){
					
					var clone = $(".langGroupContTemplate").clone(true).removeClass('hide').removeClass('langGroupContTemplate').attr('defaultlang', a.lang[i].default).attr('langid', a.lang[i].langid);
					$(clone).find("h3.langname").html(a.lang[i].langname);
					$(clone).find(".newsTitleInput").val(a.lang[i].title);
					$(clone).find(".shortNewsInput").html(a.lang[i].shortnews);
					$(clone).find(".searchwordsInput").val(a.lang[i].searchwords);
					$(clone).find(".ckcont").attr('id', 'ckeditor'+a.lang[i].langid);
					
					$(clone).appendTo($(".addChangeLangCont"));	
					CKEDITOR.replace( 'ckeditor'+a.lang[i].langid );
					CKEDITOR.instances['ckeditor'+a.lang[i].langid].setData(a.lang[i].body);
				}
				
				$(".loadingIcon").addClass("hide");	
				$(".addChangeCont").removeClass('hide');
				
				//$(".categorySelectHolder").first().find(".newscategorycont").attr('currentcat',a.categoryid[0]);
				$(".categorySelectHolder").first().find(".newscategorycont").val(a.categoryid[0]);
				for(var k = 1; k < (a.categoryid).length; k++){
					var clone = $(".categorySelectHolder").first().clone(true);	
					//alert(a.categoryid[k]);	
					$(clone).find(".newscategorycont").val(a.categoryid[k]);
					$(clone).insertAfter($(".categorySelectHolder").last());
				}
			}
		});
	}
	else{
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action : 'getlanguageslist'}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				var a = JSON.parse(response);
				
				$(".addChangeLangCont").html('');
				
				$(".newsdate").datepicker({ format: "dd.mm.yyyy"});
				$(".mainimage").val('');
				for(var i = 0; i < a.length; i++){
					
					var clone = $(".langGroupContTemplate").clone(true).removeClass('hide').removeClass('langGroupContTemplate').attr('defaultlang', a[i].default).attr('langid', a[i].id);
					$(clone).find("h3.langname").html(a[i].name);
					$(clone).find(".newsTitleInput").val('');
					$(clone).find(".shortNewsInput").html('');
					$(clone).find(".searchwordsInput").val('');
					$(clone).find(".ckcont").attr('id', 'ckeditor'+a[i].id);
					
					$(clone).appendTo($(".addChangeLangCont"));	
					CKEDITOR.replace( 'ckeditor'+a[i].id );
					
				}
				
				$(".loadingIcon").addClass("hide");	
				$(".addChangeCont").removeClass('hide');
				
				//$(".categorySelectHolder").first().find(".newscategorycont").attr('currentcat','0');
				$(".newscategorycont").val('0');				
				//$(".categorySelectHolder").first().find(".newscategorycont").val('0');
				//for(var k = 1; k < (a.categoryid).length; k++){
				//	var clone = $(".categorySelectHolder").first().clone(true);	
					//alert(a.categoryid[k]);	
				//	$(clone).find(".newscategorycont").val('0');
				//	$(clone).insertAfter($(".categorySelectHolder").last());
				//}
			}
		});	
	}
}

function saveAddChange(){
	var newsid = "";
	if($(".content-wrapper").attr('currentid') != "")
	{
		newsid = $(".content-wrapper").attr('currentid');
	}
	
	var noerror = true;
	if($('.galleryDataCont[defaultlang="y"]').find(".newsTitleInput").val() == "")
	{
		$('.newsTitleCont').addClass("has-error");
		noerror = false;
	}
	var catid= $(".categorySelectHolder").first().find(".newscategorycont").val();
	var prevcatid= $(".categorySelectHolder").first().find(".newscategorycont").attr('currentcat');
	if(catid == "0")
	{
		$(".categorySelectHolder").addClass("has-error");
		noerror = false;
	}
	
	if($('.langGroupCont[defaultlang="y"]').find(".shortNewsInput").val() == "")
	{
		$('.shortNewsCont').addClass("has-error");
		noerror = false;
	}
	
	if(!noerror){ alert('Popunite obavezna polja');}

	if(noerror)
	{
		/*	objecty to pass	 */
		var passdata = {action: "saveaddchange",
					newsid: newsid,
					thumb : $('.mainimage').val(),
					adddate: $(".newsdate").val(),
					catid: catid,
					prevcatid : prevcatid,
					galid : $('.newsgallerycont').val(),
					values : [] 
					};
					
		$(".langGroupCont:not(.langGroupContTemplate)").each(function(){
			passdata['values'].push({
				defaultlang : $(this).attr('defaultlang'),
				langid : $(this).attr('langid'),
				title : $(this).find('.newsTitleInput').val(),
				shortnews : $(this).find('.shortNewsInput').val(),
				searchwords : $(this).find('.searchwordsInput').val(),
				newsid: $(".newsData").attr("currentid"),
				catid: catid,
				prevcatid : prevcatid,
				'body' : CKEDITOR.instances[$(this).find('.ckcont').attr('id')].getData()
			});
		});	

		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: (passdata),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				var $this = $(".newscategorycont");
			
				
				var a = JSON.parse(response);
					if(a[0] == 0){
						if($($this).val() == 0){
							if($(".categorySelectHolder").length > 1){ $($this).parent().remove();	}
							else{
								$($this).val('0');	
							}
						}
					}
					else{
						alert('Greska.');
					}
				
				
				if($(".content-wrapper").attr('currentid') != '')
				{
					$(".loadingIcon").addClass("hide");	
					document.location.reload();
				}
				else{
					window.location.href = 'news';
				}
			}
		});
	}		
}