
function deleteItem_handler(elem){
	var $this = $(elem);
	var a = confirm("Da li ste sigurni da zelite da obisete stavku?");
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
	getPartnerAddress();
	getPartnerContact();
	getPartnerDocuments();
	getPartnerTransactions();
	getPartnerCategoryRebate();
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
				$('.partnerInfoName').text(' - '+a.name);
				$('.partnerName').val(a.name);
				$('.partnerType').val(a.partnertype);
				$('.partnerActive').val(a.active);
				//$('.partnerActive').find('option[value="'+a.active+'"]').attr('selected','selected');
				$('.partnerSort').val(a.sort);
				$('.partnerIdent').val(a.id);
				$('.partnerCode').val(a.code);
				$('.partnerNumber').val(a.number);
				$('.partnerEmail').val(a.email);
				$('.partnerPhone').val(a.phone);
				$('.partnerFax').val(a.fax);
				$('.partnerWebsite').val(a.website);
				$('.partnerAddress').val(a.address);
				$('.partnerCity').val(a.city);
				$('.partnerZip').val(a.zip);
				$('.partnerImage').val(a.img);
				$('.partnerContactPerson').val(a.contactperson);
				$('.partnerResponsiblePerson').val(a.responsibleperson);
				$('.partnerDescription').val(a.description);
				$('.partnerRebatePercent').val(a.rebatepercent);
				$('.partnerValuteDays').val(a.valutedays);
				$('.partnerCreditLimit').val(a.creditlimit);
				if(a.responsibleperson=='' || a.responsibleperson==null){
					$('.partnerUser').val('Sinhronizer');
				} else {
					$('.partnerUser').val(a.responsibleperson);
				}
				
				$('.partnerTimestamp').val(a.ts);






				// $(".addChangeLangCont").html('');
				
				// $(".positionSelect").val(a.position);
				// $(".titleBanner").val(a.name);
				// for(var i = 0; i < (a.lang).length; i++){
					
				// 	var clone = $(".langGroupContTemplate").clone(true).removeClass('hide').removeClass('langGroupContTemplate').attr('defaultlang', a.lang[i].default).attr('langid', a.lang[i].langid);
				// 	$(clone).find("h3.langname").html(a.lang[i].langname);
				// 	$(clone).find(".ckcont").attr('id', 'ckeditor'+a.lang[i].langid);
					
				// 	$(clone).appendTo($(".addChangeLangCont"));	
				// 	CKEDITOR.replace( 'ckeditor'+a.lang[i].langid );
				// 	CKEDITOR.instances['ckeditor'+a.lang[i].langid].setData(a.lang[i].value);
				// }
				
				$(".loadingIcon").addClass("hide");	
				$(".addChangeCont").removeClass('hide');
			}
		});
	}
	else{
		//$('.partnerInfoName').text(' - '+a.name);
		
		$('.partnerAddressTab').addClass('hide');
		$('.partnerContactTab').addClass('hide');
		$('.partnerDocumentsTab').addClass('hide');
		$('.partnerTransactionsTab').addClass('hide');

				$('.partnerName').val('');
				$('.partnerType').val('');
				$('.partnerActive').val('n');
				//$('.partnerActive').find('option[value="'+a.active+'"]').attr('selected','selected');
				$('.partnerSort').val('0');
				$('.partnerIdent').val('');
				$('.partnerCode').val('');
				$('.partnerNumber').val('');
				$('.partnerEmail').val('');
				$('.partnerPhone').val('');
				$('.partnerFax').val('');
				$('.partnerWebsite').val('');
				$('.partnerAddress').val('');
				$('.partnerCity').val('');
				$('.partnerZip').val('');
				$('.partnerImage').val('');
				$('.partnerContactPerson').val('');
				$('.partnerResponsiblePerson').val('');
				$('.partnerDescription').val('');
				$('.partnerRebatePercent').val('0');
				$('.partnerValuteDays').val('0');
				$('.partnerCreditLimit').val('0');
				
				$('.partnerCreditDebitInfo').addClass('hide');
				$('.partnerLastEditInfo').addClass('hide');
				
				$(".loadingIcon").addClass("hide");	
				$(".addChangeCont").removeClass('hide');
	}
}
//PARTNER APPLICATIONS FORM
function createPartnerApplicationsForm(){
	getPartnerApplications();
}
function getPartnerApplications(){
		$("#partnerApplicationsListTable").DataTable({
			stateSave: true,
			"processing": true,
        	"serverSide": true,
        "ajax":{
                url :"modules/"+moduleName+"/library/functions.php", // json datasource
                type: "post",  // method  , by default get
                data: ({action : 'getpartnerapplications'
				}),
                error: function(){  // error handling
                    $(".partnerApplicationsListTable-grid-error").html("");
                    $("#partnerApplicationsListTable").append('<tbody class="employee-grid-error"><tr><th colspan="3">Nema pronađenih podataka</th></tr></tbody>');
                    $("#partnerApplicationsListTable-grid_processing").css("display","none");
                },
				dataSrc: function(a){
					//console.log(d);
					for(var i = 0; i < a.aaData.length;i++)
					{

					var infoBTN = '<button class="btn btn-primary disabled " disabled="disabled">Info. o korisniku</button> ';
					var delBTN = '';
					if(a.aaData[i][97]>0){
						if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('change') == '1'))
						{
							var infoBTN = '';//<button class="btn btn-primary userInfoBTN" userid="'+a.aaData[i][97]+'">Info. o korisniku</button> ';

							
						}
					}

					if(a.aaData[i][98]==0 || a.aaData[i][98]=='NULL' || a.aaData[i][98]==''){
						delBTN = '<button class="btn btn-danger  deletePartnerApplicationBTN" userid="'+a.aaData[i][97]+'" partnerapplicationid="'+a.aaData[i][99]+'">Obriši</button> ';
					}
					var createPartnerBTN = '<button class="btn btn-warning disabled " disabled="disabled">Odobri partnerski nalog</button> ';
					
					if(a.aaData[i][98]==0 || a.aaData[i][98]=='NULL' || a.aaData[i][98]==''){
						var createPartnerBTN = '<button class="btn btn-warning createPartnerBTN" userid="'+a.aaData[i][97]+'" partnerapplicationid="'+a.aaData[i][99]+'" >Odobri partnerski nalog</button> ';
					}
					// if(a.aaData[i][13]=='n'){
					// 	a.aaData[i][13]='Čeka se potvrda';
					// }
					// if(a.aaData[i][13]=='o'){
					// 	a.aaData[i][13]='Odobren';
					// }
					a.aaData[i][13] = '' ;
					a.aaData[i][14] = delBTN +'<br><br>'+createPartnerBTN;

					}

				 	$(".loadingIcon").addClass("hide");	
					$(".runReportCont").removeClass('hide');
					
					return a.aaData;
				}
            },
			"language": {
           		"emptyTable":     "Nema podataka za prikaz",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
				"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
				"infoFiltered":   "(filtrirano od _MAX_ podataka)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikaži _MENU_ podataka",
				"loadingRecords": "Učitavanje...",
				"processing":     "Obrada...",
				"search":         "Pretraga:",
				"zeroRecords":    "Nema rezultata za zadati kriterijum",
				"paginate": {
					"first":      "Prva",
					"last":       "Poslednja",
					"next":       "Sledeća",
					"previous":   "Predhodna"
				}
        	}
        }).on('click','.userInfoBTN', function(){
			var userid=$(this).attr('userid');
			if(userid !='' && userid>0 ){
				var getUrl = window.location;
				var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1]+"/user/change/"+userid;
				var win = window.open(baseUrl, '_blank');
  				win.focus();
			} else {
				alert('Došlo je do greške. LOCATE_USER_0001');
			}
		}).on('click','.createPartnerBTN', function(){
			var userid=$(this).attr('userid');
			var partnerapplicationid=$(this).attr('partnerapplicationid');
			alert("kreiraj partnera");
			if(userid>0 && partnerapplicationid>0){
				createPartnerFromPartnerApplication(userid,partnerapplicationid);	
			} else {
				alert('Korisnički nalog nije validan.');
			}
			
			// if(userid !='' && userid>0 ){
			// 	var getUrl = window.location;
			// 	var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1]+"/user/change/"+userid;
			// 	var win = window.open(baseUrl, '_blank');
  	// 			win.focus();
			// } else {
			// 	alert('Došlo je do greške. LOCATE_USER_0001');
			// }
		}).on('click','.deletePartnerApplicationBTN', function(){
			var userid=$(this).attr('userid');
			var partnerapplicationid=$(this).attr('partnerapplicationid');
			//alert(userid);
			//alert(partnerapplicationid);
			if(userid>0 && partnerapplicationid>0){
				deletePartnerFromPartnerApplication(userid,partnerapplicationid);	
			} else {
				alert('Ne možete obrisati zahtev.');
			}

		});
}
//PARTNER APPLICATIONS FORM END
function createPartnerFromPartnerApplication(userid,partnerapplicationid){
	var passdata = {action: "createpartnerfrompartnerapplication",
					userid: userid,
					partnerapplicationid: partnerapplicationid,
					};
					
		
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: (passdata),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
			if(response==1){
				if($(".content-wrapper").attr('currentid') != '')
				{
					$(".loadingIcon").addClass("hide");	
					document.location.reload();
				}
				else{
					//window.location.href = 'partner';
					document.location.reload();
				}
			}
			}
		});
}

function deletePartnerFromPartnerApplication(userid,partnerapplicationid){
	var passdata = {action: "deletepartnerfrompartnerapplication",
					userid: userid,
					partnerapplicationid: partnerapplicationid,
					};
					
		
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: (passdata),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
			if(response==1){
				if($(".content-wrapper").attr('currentid') != '')
				{
					$(".loadingIcon").addClass("hide");	
					document.location.reload();
				}
				else{
					//window.location.href = 'partner';
					document.location.reload();
				}
			}
			}
		});
}
//PARTNER APPLICATIONS FORM END
function savePartnerInfo(){
	var partnerid = "";
	if($(".content-wrapper").attr('currentid') != "")
	{
		partnerid = $(".content-wrapper").attr('currentid');
	}
	
	var noerror = true;
	if($(".partnerName").val() == "")
	{
		$('.partnerName').parent().addClass("has-error");
		noerror = false;
	}
	
	if($(".partnerType").val() == "")
	{
		$('.partnerType').parent().addClass("has-error");
		noerror = false;
	}

	if($(".partnerCode").val() == "")
	{
		$('.partnerCode').parent().addClass("has-error");
		noerror = false;
	}

	if($(".partnerNumber").val() == "")
	{
		$('.partnerNumber').parent().addClass("has-error");
		noerror = false;
	}

	if($(".partnerEmail").val() == "")
	{
		$('.partnerEmail').parent().addClass("has-error");
		noerror = false;
	}

	if($(".partnerPhone").val() == "")
	{
		$('.partnerPhone').parent().addClass("has-error");
		noerror = false;
	}

	if($(".partnerAddress").val() == "")
	{
		$('.partnerAddress').parent().addClass("has-error");
		noerror = false;
	}

	if($(".partnerCity").val() == "")
	{
		$('.partnerCity').parent().addClass("has-error");
		noerror = false;
	}

	if($(".partnerZip").val() == "")
	{
		$('.partnerZip').parent().addClass("has-error");
		noerror = false;
	}
	
	if($(".partnerContactPerson").val() == "")
	{
		$('.partnerContactPerson').parent().addClass("has-error");
		noerror = false;
	}

	if(!noerror){ alert('Popunite obavezna polja'); $(".loadingIcon").addClass("hide");	}

	if(noerror)
	{
		/*	objecty to pass	 */
		var passdata = {action: "savepartnerinfo",
					partnerid: partnerid,
					name: $(".partnerName").val(),
					partnertype: $(".partnerType").val(),
					active: $(".partnerActive").val(),
					sort: $(".partnerSort").val(),
					code: $(".partnerCode").val(),
					number: $(".partnerNumber").val(),
					email: $(".partnerEmail").val(),
					phone: $(".partnerPhone").val(),
					fax: $(".partnerFax").val(),
					website: $(".partnerWebsite").val(),
					address: $(".partnerAddress").val(),
					city: $(".partnerCity").val(),
					zip: $(".partnerZip").val(),
					img: $(".partnerImage").val(),
					contactperson: $(".partnerContactPerson").val(),
					description: $(".partnerDescription").val(),
					rebatepercent: $(".partnerRebatePercent").val(),
					valutedays: $(".partnerValuteDays").val(),
					creditlimit: $(".partnerCreditLimit").val()
					};
					
		
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: (passdata),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				if($(".content-wrapper").attr('currentid') != '')
				{
					$(".loadingIcon").addClass("hide");	
					document.location.reload();
				}
				else{
					//window.location.href = 'partner';
					document.location.reload();
				}
			}
		});
	}		
}
//PARTNER ADDRESS ###################################################################################################################
function getPartnerAddress(){
	var partnerid = "";
	if($(".content-wrapper").attr('currentid') != "")
	{
		partnerid = $(".content-wrapper").attr('currentid');

		$("#partnerAddressTable").DataTable({
			stateSave: true,
			"processing": true,
        	"serverSide": true,
        "ajax":{
                url :"modules/"+moduleName+"/library/functions.php", // json datasource
                type: "post",  // method  , by default get
                data: ({action : 'getpartneraddress',
					partnerid : partnerid
				}),
                error: function(){  // error handling
                    $(".partnerAddressTable-grid-error").html("");
                    $("#partnerAddressTable").append('<tbody class="employee-grid-error"><tr><th colspan="3">Nema pronadjenih podataka</th></tr></tbody>');
                    $("#partnerAddressTable-grid_processing").css("display","none");
                },
				dataSrc: function(a){
					//console.log(d);
					for(var i = 0; i < a.aaData.length;i++)
					{

					var changeBTN = '<button class="btn btn-primary disabled " disabled="disabled">Izmeni</button> ';
						if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('change') == '1'))
						{
							var changeBTN = '<button class="btn btn-primary changePartnerAddressBTN" partneraddressid="'+a.aaData[i][99]+'">Izmeni</button> ';
						}
					var deleteBTN = "";
						if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('delete') == '1'))
						{
							deleteBTN = '<button class="btn btn-danger deletePartnerAddressBTN" partneraddressid="'+a.aaData[i][99]+'">Obriši</button> ';
						}

					a.aaData[i][9] = changeBTN + deleteBTN;

					}

				 	$(".loadingIcon").addClass("hide");	
					$(".runReportCont").removeClass('hide');
					
					return a.aaData;
				}
            },
			"language": {
           		"emptyTable":     "Nema podataka za prikaz",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
				"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
				"infoFiltered":   "(filtrirano od _MAX_ podataka)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikaži _MENU_ podataka",
				"loadingRecords": "Učitavanje...",
				"processing":     "Obrada...",
				"search":         "Pretraga:",
				"zeroRecords":    "Nema rezultata za zadati kriterijum",
				"paginate": {
					"first":      "Prva",
					"last":       "Poslednja",
					"next":       "Sledeća",
					"previous":   "Predhodna"
				}
        	}
		}).on('click','.changePartnerAddressBTN', function(){
		
			partnerid = $(".content-wrapper").attr('currentid');
			var partneraddressid=$(this).attr('partneraddressid');
			if(partnerid !='' && partnerid>0 && partneraddressid!='' && partneraddressid>0){
				changePartnerAddress(partnerid, partneraddressid);
			} else {
				alert('Došlo je do greške.');
			}
			
		}).on('click','.deletePartnerAddressBTN', function(){
		
			partnerid = $(".content-wrapper").attr('currentid');
			var partneraddressid=$(this).attr('partneraddressid');
			if(partnerid !='' && partnerid>0 && partneraddressid!='' && partneraddressid>0){
				deletePartnerAddress(partnerid, partneraddressid);
			} else {
				alert('Došlo je do greške.');
			}
			
		});;

	} else {
		$("#partnerAddressTable").DataTable({ 
			"language": {
           		"emptyTable":     "Nema podataka za prikaz",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
				"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
				"infoFiltered":   "(filtrirano od _MAX_ podataka)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikaži _MENU_ podataka",
				"loadingRecords": "Učitavanje...",
				"processing":     "Obrada...",
				"search":         "Pretraga:",
				"zeroRecords":    "Nema rezultata za zadati kriterijum",
				"paginate": {
					"first":      "Prva",
					"last":       "Poslednja",
					"next":       "Sledeća",
					"previous":   "Predhodna"
				}
        	}
		});
	}
}

function clearAddChangePartnerAddress(){
	$(".partnerAddressObjectName").val('');	
	$(".partnerAddressObjectType").val('');
	$(".partnerAddressAddress").val('');
	$(".partnerAddressCity").val('');
	$(".partnerAddressZip").val('');
	$(".partnerAddressRegion").val('');
	$(".partnerAddressDeliveryCode").val('');
	$(".partnerAddressSalesSource").val('');	
}

function savePartnerAddress(){
	var partnerid = "";
	if($(".content-wrapper").attr('currentid') != "")
	{
		partnerid = $(".content-wrapper").attr('currentid');
	}

	var partneraddressid = "";
	if($(".addPartnerAddressCont").attr('partneraddressid') != "")
	{
		partneraddressid = $(".addPartnerAddressCont").attr('partneraddressid');
	}
	
	var noerror = true;
	if($(".partnerAddressObjectName").val() == "")
	{
		$('.partnerAddressObjectName').parent().addClass("has-error");
		noerror = false;
	}
	
	if($(".partnerAddressObjectType").val() == "")
	{
		$('.partnerAddressObjectType').parent().addClass("has-error");
		noerror = false;
	}

	if($(".partnerAddressAddress").val() == "")
	{
		$('.partnerAddressAddress').parent().addClass("has-error");
		noerror = false;
	}

	if($(".partnerAddressCity").val() == "")
	{
		$('.partnerAddressCity').parent().addClass("has-error");
		noerror = false;
	}

	if($(".partnerAddressZip").val() == "")
	{
		$('.partnerAddressZip').parent().addClass("has-error");
		noerror = false;
	}

	if($(".partnerAddressRegion").val() == "")
	{
		$('.partnerAddressRegion').parent().addClass("has-error");
		noerror = false;
	}
	

	if(!noerror){ alert('Popunite obavezna polja'); $(".loadingIcon").addClass("hide");	}

	if(noerror)
	{
		/*	objecty to pass	 */
		var passdata = {action: "savepartneraddress",
					partnerid: partnerid,
					partneraddressid: partneraddressid,
					objectname: $(".partnerAddressObjectName").val(),
					objecttype: $(".partnerAddressObjectType").val(),
					address: $(".partnerAddressAddress").val(),
					city: $(".partnerAddressCity").val(),
					zip: $(".partnerAddressZip").val(),
					region: $(".partnerAddressRegion").val(),
					deliverycode: $(".partnerAddressDeliveryCode").val(),
					salessource: $(".partnerAddressSalesSource").val()
					};
					
		
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: (passdata),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				if($(".content-wrapper").attr('currentid') != '')
				{
					$(".loadingIcon").addClass("hide");	
					$(".addPartnerAddressCont").addClass('hide');
					clearAddChangePartnerAddress();
					$(".addPartnerAddressBTN").removeClass('hide');	
					var table = $('#partnerAddressTable').DataTable();
					table.ajax.reload();
				}
			}
		});
	}		
}

function changePartnerAddress(partnerid,partneraddressid){

	showLoadingIcon();
	clearAddChangePartnerAddress();
	$(".partneraddressAddChangeLabel").text('Izmena podataka');
	
	$(".addPartnerAddressCont").attr('partneraddressid',partneraddressid);
	if(!($(".addPartnerAddressBTN").hasClass('hide'))){
		$(".addPartnerAddressBTN").addClass('hide');
	}
	if(!($(".addPartnerAddressCont").hasClass('hide'))){
		$(".addPartnerAddressCont").addClass('hide');
	}
	var passdata = {action: "getselectedpartneraddress",
					partnerid: partnerid,
					partneraddressid: partneraddressid
					};
					
		
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: (passdata),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("Došlo je do greške.ERROR_NO_GPAADD001"); 
			  hideLoadingIcon();                           
			},
			success:function(response){
				var a = JSON.parse(response);	
				$(".addPartnerAddressCont").attr('partneraddressid',a.partneraddressid);
				$(".partnerAddressObjectName").val(a.objectname);	
				$(".partnerAddressObjectType").val(a.objecttype);
				$(".partnerAddressAddress").val(a.address);
				$(".partnerAddressCity").val(a.city);
				$(".partnerAddressZip").val(a.zip);
				$(".partnerAddressRegion").val(a.region);
				$(".partnerAddressDeliveryCode").val(a.deliverycode);
				$(".partnerAddressSalesSource").val(a.salessource);
				$(".addPartnerAddressCont").removeClass('hide');
				hideLoadingIcon();
			}
		});
	

}


function deletePartnerAddress(partnerid, partneraddressid){
	if (!($(".addPartnerAddressCont").hasClass('hide'))) {
		$(".addPartnerAddressCont").addClass('hide');
		clearAddChangePartnerAddress();
	}
		
	var passdata = {action: "deleteselectedpartneraddress",
					partnerid: partnerid,
					partneraddressid: partneraddressid
					};
					
		
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: (passdata),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("Došlo je do greške.ERROR_NO_DELPAADD001"); 
			  hideLoadingIcon();                           
			},
			success:function(response){
				if(response==1){
					var table = $('#partnerAddressTable').DataTable();
					table.ajax.reload();	
				} else {
					alert("Došlo je do greške.DELPADD_ERROR_NO_0001");
				}
				
				hideLoadingIcon();
			}
		});
	
}
//PARTNER ADDRESS END ###############################################################################################################
//PARTNER CONTACT ###################################################################################################################
function getPartnerContact(){
	var partnerid = "";
	if($(".content-wrapper").attr('currentid') != "")
	{
		partnerid = $(".content-wrapper").attr('currentid');

		$("#partnerContactTable").DataTable({
			stateSave: true,
			"processing": true,
        	"serverSide": true,
        "ajax":{
                url :"modules/"+moduleName+"/library/functions.php", // json datasource
                type: "post",  // method  , by default get
                data: ({action : 'getpartnercontact',
					partnerid : partnerid
				}),
                error: function(){  // error handling
                    $(".partnerContactTable-grid-error").html("");
                    $("#partnerContactTable").append('<tbody class="employee-grid-error"><tr><th colspan="3">Nema pronadjenih podataka</th></tr></tbody>');
                    $("#partnerContactTable-grid_processing").css("display","none");
                },
				dataSrc: function(a){
					//console.log(d);
					for(var i = 0; i < a.aaData.length;i++)
					{

					var changeBTN = '<button class="btn btn-primary disabled " disabled="disabled">Izmeni</button> ';
						if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('change') == '1'))
						{
							var changeBTN = '<button class="btn btn-primary changePartnerContactBTN" partnercontactid="'+a.aaData[i][99]+'">Izmeni</button> ';
						}
					var deleteBTN = "";
						if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('delete') == '1'))
						{
							deleteBTN = '<button class="btn btn-danger deletePartnerContactBTN" partnercontactid="'+a.aaData[i][99]+'">Obriši</button> ';
						}

					a.aaData[i][7] = changeBTN + deleteBTN;

					}

				 	$(".loadingIcon").addClass("hide");	
					$(".runReportCont").removeClass('hide');
					
					return a.aaData;
				}
            },
			"language": {
           		"emptyTable":     "Nema podataka za prikaz",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
				"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
				"infoFiltered":   "(filtrirano od _MAX_ podataka)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikaži _MENU_ podataka",
				"loadingRecords": "Učitavanje...",
				"processing":     "Obrada...",
				"search":         "Pretraga:",
				"zeroRecords":    "Nema rezultata za zadati kriterijum",
				"paginate": {
					"first":      "Prva",
					"last":       "Poslednja",
					"next":       "Sledeća",
					"previous":   "Predhodna"
				}
        	}
		}).on('click','.changePartnerContactBTN', function(){
		
			partnerid = $(".content-wrapper").attr('currentid');
			var partnercontactid=$(this).attr('partnercontactid');
			if(partnerid !='' && partnerid>0 && partnercontactid!='' && partnercontactid>0){
				changePartnerContact(partnerid, partnercontactid);
			} else {
				alert('Došlo je do greške.');
			}
			
		}).on('click','.deletePartnerContactBTN', function(){
		
			partnerid = $(".content-wrapper").attr('currentid');
			var partnercontactid=$(this).attr('partnercontactid');
			if(partnerid !='' && partnerid>0 && partnercontactid!='' && partnercontactid>0){
				deletePartnerContact(partnerid, partnercontactid);
			} else {
				alert('Došlo je do greške.');
			}
			
		});;

	} else {
		$("#partnerContactTable").DataTable({ 
			"language": {
           		"emptyTable":     "Nema podataka za prikaz",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
				"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
				"infoFiltered":   "(filtrirano od _MAX_ podataka)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikaži _MENU_ podataka",
				"loadingRecords": "Učitavanje...",
				"processing":     "Obrada...",
				"search":         "Pretraga:",
				"zeroRecords":    "Nema rezultata za zadati kriterijum",
				"paginate": {
					"first":      "Prva",
					"last":       "Poslednja",
					"next":       "Sledeća",
					"previous":   "Predhodna"
				}
        	}
		});
	}
}

function clearAddChangePartnerContact(){
	$(".partnerContactPosition").val('');	
	$(".partnerContactFirstName").val('');
	$(".partnerContactLastName").val('');
	$(".partnerContactPhone").val('');
	$(".partnerContactEmail").val('');
	$(".partnerContactNote").val('');
}

function savePartnerContact(){
	var partnerid = "";
	if($(".content-wrapper").attr('currentid') != "")
	{
		partnerid = $(".content-wrapper").attr('currentid');
	}

	var partnercontactid = "";
	if($(".addPartnerContactCont").attr('partnercontactid') != "")
	{
		partnercontactid = $(".addPartnerContactCont").attr('partnercontactid');
	}
	
	var noerror = true;
	if($(".partnerContactPosition").val() == "")
	{
		$('.partnerContactPosition').parent().addClass("has-error");
		noerror = false;
	}
	
	if($(".partnerContactFirstName").val() == "")
	{
		$('.partnerContactFirstName').parent().addClass("has-error");
		noerror = false;
	}

	if($(".partnerContactLastName").val() == "")
	{
		$('.partnerContactLastName').parent().addClass("has-error");
		noerror = false;
	}

	if($(".partnerContactPhone").val() == "")
	{
		$('.partnerContactPhone').parent().addClass("has-error");
		noerror = false;
	}

	if($(".partnerContactEmail").val() == "")
	{
		$('.partnerContactEmail').parent().addClass("has-error");
		noerror = false;
	}


	if(!noerror){ alert('Popunite obavezna polja'); $(".loadingIcon").addClass("hide");	}

	if(noerror)
	{
		/*	objecty to pass	 */
		var passdata = {action: "savepartnercontact",
					partnerid: partnerid,
				    partnercontactid: partnercontactid,
				    position: $(".partnerContactPosition").val(),
				    firstname: $(".partnerContactFirstName").val(),
				    lastname: $(".partnerContactLastName").val(),
				    phone: $(".partnerContactPhone").val(),
				    email: $(".partnerContactEmail").val(),
				    note: $(".partnerContactNote").val()
					};
					
		
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: (passdata),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				if($(".content-wrapper").attr('currentid') != '')
				{
					$(".loadingIcon").addClass("hide");	
					$(".addPartnerContactCont").addClass('hide');
					clearAddChangePartnerContact();
					$(".addPartnerContactBTN").removeClass('hide');	
					var table = $('#partnerContactTable').DataTable();
					table.ajax.reload();
				}
			}
		});
	}		
}

function changePartnerContact(partnerid,partnercontactid){

	showLoadingIcon();
	clearAddChangePartnerContact();
	$(".partnercontactAddChangeLabel").text('Izmena podataka');
	
	$(".addPartnerContactCont").attr('partnercontactid',partnercontactid);
	if(!($(".addPartnerContactBTN").hasClass('hide'))){
		$(".addPartnerContactBTN").addClass('hide');
	}
	if(!($(".addPartnerContactCont").hasClass('hide'))){
		$(".addPartnerContactCont").addClass('hide');
	}
	var passdata = {action: "getselectedpartnercontact",
					partnerid: partnerid,
					partnercontactid: partnercontactid
					};
					
		
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: (passdata),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("Došlo je do greške.ERROR_NO_GPAADD001"); 
			  hideLoadingIcon();                           
			},
			success:function(response){
				var a = JSON.parse(response);	
				$(".addPartnerContactCont").attr('partnercontactid',a.partnercontactid);
				$(".partnerContactPosition").val(a.position);	
				$(".partnerContactFirstName").val(a.firstname);
				$(".partnerContactLastName").val(a.lastname);
				$(".partnerContactPhone").val(a.phone);
				$(".partnerContactEmail").val(a.email);
				$(".partnerContactNote").val(a.note);
				$(".addPartnerContactCont").removeClass('hide');
				hideLoadingIcon();
			}
		});
	

}


function deletePartnerContact(partnerid, partnercontactid){
	if (!($(".addPartnerContactCont").hasClass('hide'))) {
		$(".addPartnerContactCont").addClass('hide');
		clearAddChangePartnerContact();
	}
		
	var passdata = {action: "deleteselectedpartnercontact",
					partnerid: partnerid,
					partnercontactid: partnercontactid
					};
					
		
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: (passdata),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("Došlo je do greške.ERROR_NO_DELPACONT001"); 
			  hideLoadingIcon();                           
			},
			success:function(response){
				if(response==1){
					var table = $('#partnerContactTable').DataTable();
					table.ajax.reload();	
				} else {
					alert("Došlo je do greške.DELPACONT_ERROR_NO_0001");
				}
				
				hideLoadingIcon();
			}
		});
	
}
//PARTNER CONTACT END ###############################################################################################################
//PARTNER DOCUMENTS #################################################################################################################

function getPartnerDocuments(){
	var partnerid = "";

	if($(".content-wrapper").attr('currentid') != "")
	{
		partnerid = $(".content-wrapper").attr('currentid');

		//$('#partnerDocumentsFromDateDateTimePicker').datetimepicker();
		//$('#partnerDocumentsToDateDateTimePicker').datetimepicker();

		$("#partnerDocumentsTable").DataTable({
			stateSave: true,
			"processing": true,
        	"serverSide": true,
        "ajax":{
                url :"modules/"+moduleName+"/library/functions.php", // json datasource
                type: "post",  // method  , by default get
                data: ({action : 'getpartnerdocuments',
					partnerid : partnerid,
					fromdate : function() { return $('.partnerDocumentsFromDate').val() },
					todate : function() { return $('.partnerDocumentsToDate').val() }
				}),
                error: function(){  // error handling
                    $(".partnerDocumentsTable-grid-error").html("");
                    $("#partnerDocumentsTable").append('<tbody class="employee-grid-error"><tr><th colspan="3">Nema pronadjenih podataka</th></tr></tbody>');
                    $("#partnerDocumentsTable-grid_processing").css("display","none");
                },
				dataSrc: function(a){
					//console.log(d);
					for(var i = 0; i < a.aaData.length;i++)
					{

					var infoBTN = '<button class="btn btn-primary disabled " disabled="disabled">Info</button> ';
						if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('change') == '1'))
						{
							var infoBTN = '<button class="btn btn-primary partnerDocumentMoreInfoBTN" documentid="'+a.aaData[i][99]+'">Info</button> ';
						}
					

					a.aaData[i][6] = infoBTN;

					}

				 	$(".loadingIcon").addClass("hide");	
					$(".runReportCont").removeClass('hide');
					
					return a.aaData;
				}
            },
			"language": {
           		"emptyTable":     "Nema podataka za prikaz",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
				"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
				"infoFiltered":   "(filtrirano od _MAX_ podataka)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikaži _MENU_ podataka",
				"loadingRecords": "Učitavanje...",
				"processing":     "Obrada...",
				"search":         "Pretraga:",
				"zeroRecords":    "Nema rezultata za zadati kriterijum",
				"paginate": {
					"first":      "Prva",
					"last":       "Poslednja",
					"next":       "Sledeća",
					"previous":   "Predhodna"
				}
        	}
		}).on('click','.partnerDocumentMoreInfoBTN', function(){
		
			var documentid=$(this).attr('documentid');
			if(documentid !='' && documentid>0 ){
				var getUrl = window.location;
				var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1]+"/invoice/change/"+documentid;
				var win = window.open(baseUrl, '_blank');
  				win.focus();
			} else {
				alert('Došlo je do greške. LOCATE_DOC_0001');
			}
			
		});

	} else {
		$("#partnerDocumentsTable").DataTable({ 
			"language": {
           		"emptyTable":     "Nema podataka za prikaz",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
				"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
				"infoFiltered":   "(filtrirano od _MAX_ podataka)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikaži _MENU_ podataka",
				"loadingRecords": "Učitavanje...",
				"processing":     "Obrada...",
				"search":         "Pretraga:",
				"zeroRecords":    "Nema rezultata za zadati kriterijum",
				"paginate": {
					"first":      "Prva",
					"last":       "Poslednja",
					"next":       "Sledeća",
					"previous":   "Predhodna"
				}
        	}
		});
	}
}
function filterPartnerDocuments(){
	var table = $('#partnerDocumentsTable').DataTable();
	table.ajax.reload();
}
//PARTNER DOCUMENTS END #############################################################################################################
//PARTNER TRANSACTIONS ##############################################################################################################

function getPartnerTransactions(){
	var partnerid = "";

	if($(".content-wrapper").attr('currentid') != "")
	{
		partnerid = $(".content-wrapper").attr('currentid');

		//$('#partnerDocumentsFromDateDateTimePicker').datetimepicker();
		//$('#partnerDocumentsToDateDateTimePicker').datetimepicker();

		$("#partnerTransactionsTable").DataTable({
			stateSave: true,
			"processing": true,
        	"serverSide": true,
        "ajax":{
                url :"modules/"+moduleName+"/library/functions.php", // json datasource
                type: "post",  // method  , by default get
                data: ({action : 'getpartnertransactions',
					partnerid : partnerid,
					fromdate : function() { return $('.partnerTransactionsFromDate').val() },
					todate : function() { return $('.partnerTransactionsToDate').val() }
				}),
                error: function(){  // error handling
                    $(".partnerTransactionsTable-grid-error").html("");
                    $("#partnerTransactionsTable").append('<tbody class="employee-grid-error"><tr><th colspan="3">Nema pronadjenih podataka</th></tr></tbody>');
                    $("#partnerTransactionsTable-grid_processing").css("display","none");
                },
				dataSrc: function(a){
					//console.log(d);
					// for(var i = 0; i < a.aaData.length;i++)
					// {

					// var infoBTN = '<button class="btn btn-primary disabled " disabled="disabled">Info</button> ';
					// 	if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('change') == '1'))
					// 	{
					// 		var infoBTN = '<button class="btn btn-primary partnerDocumentMoreInfoBTN" documentid="'+a.aaData[i][99]+'">Info</button> ';
					// 	}
					

					// a.aaData[i][6] = infoBTN;

					// }

				 	$(".loadingIcon").addClass("hide");	
					$(".runReportCont").removeClass('hide');
					
					return a.aaData;
				}
            },
			"language": {
           		"emptyTable":     "Nema podataka za prikaz",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
				"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
				"infoFiltered":   "(filtrirano od _MAX_ podataka)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikaži _MENU_ podataka",
				"loadingRecords": "Učitavanje...",
				"processing":     "Obrada...",
				"search":         "Pretraga:",
				"zeroRecords":    "Nema rezultata za zadati kriterijum",
				"paginate": {
					"first":      "Prva",
					"last":       "Poslednja",
					"next":       "Sledeća",
					"previous":   "Predhodna"
				}
        	}
        });
		// }).on('click','.partnerDocumentMoreInfoBTN', function(){
		
		// 	var documentid=$(this).attr('documentid');
		// 	if(documentid !='' && documentid>0 ){
		// 		var getUrl = window.location;
		// 		var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1]+"/invoice/change/"+documentid;
		// 		var win = window.open(baseUrl, '_blank');
  // 				win.focus();
		// 	} else {
		// 		alert('Došlo je do greške. LOCATE_DOC_0001');
		// 	}
			
		// });

	} else {
		$("#partnerTransactionsTable").DataTable({ 
			"language": {
           		"emptyTable":     "Nema podataka za prikaz",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
				"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
				"infoFiltered":   "(filtrirano od _MAX_ podataka)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikaži _MENU_ podataka",
				"loadingRecords": "Učitavanje...",
				"processing":     "Obrada...",
				"search":         "Pretraga:",
				"zeroRecords":    "Nema rezultata za zadati kriterijum",
				"paginate": {
					"first":      "Prva",
					"last":       "Poslednja",
					"next":       "Sledeća",
					"previous":   "Predhodna"
				}
        	}
		});
	}
}
function filterPartnerTransactions(){
	var table = $('#partnerTransactionsTable').DataTable();
	table.ajax.reload();
}
//PARTNER TRANSACTIONS END ##########################################################################################################
//PARTNER CATEGORY REBATE ###################################################################################################################
function getPartnerCategoryRebate(){
	var partnerid = "";
	if($(".content-wrapper").attr('currentid') != "")
	{
		partnerid = $(".content-wrapper").attr('currentid');

		$("#partnerCategoryRebateTable").DataTable({
			stateSave: true,
			"processing": true,
        	"serverSide": true,
        	"ajax":{
                url :"modules/"+moduleName+"/library/functions.php", // json datasource
                type: "post",  // method  , by default get
                data: ({action : 'getpartnercategoryrebate',
					partnerid : partnerid
				}),
                error: function(){  // error handling
                    $(".partnerCategoryRebateTable-grid-error").html("");
                    $("#partnerCategoryRebateTable").append('<tbody class="employee-grid-error"><tr><th colspan="3">Nema pronadjenih podataka</th></tr></tbody>');
                    $("#partnerCategoryRebateTable-grid_processing").css("display","none");
                },
				dataSrc: function(a){
					//console.log(d);
					for(var i = 0; i < a.aaData.length;i++)
					{

					var deleteBTN = "";
						if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('delete') == '1'))
						{
							deleteBTN = '<button class="btn btn-danger deletePartnerCategoryRebateBTN" partnercategoryrebateid="'+a.aaData[i][99]+'">Obriši</button> ';
						}

					a.aaData[i][3] = deleteBTN;

					}

				 	$(".loadingIcon").addClass("hide");	
					$(".runReportCont").removeClass('hide');
					
					return a.aaData;
				}
            },
			"language": {
           		"emptyTable":     "Nema podataka za prikaz",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
				"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
				"infoFiltered":   "(filtrirano od _MAX_ podataka)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikaži _MENU_ podataka",
				"loadingRecords": "Učitavanje...",
				"processing":     "Obrada...",
				"search":         "Pretraga:",
				"zeroRecords":    "Nema rezultata za zadati kriterijum",
				"paginate": {
					"first":      "Prva",
					"last":       "Poslednja",
					"next":       "Sledeća",
					"previous":   "Predhodna"
				}
        	}
		}).on('click','.changePartnerAddressBTN', function(){
		
			partnerid = $(".content-wrapper").attr('currentid');
			var partneraddressid=$(this).attr('partneraddressid');
			if(partnerid !='' && partnerid>0 && partneraddressid!='' && partneraddressid>0){
				changePartnerAddress(partnerid, partneraddressid);
			} else {
				alert('Došlo je do greške.');
			}
			
		}).on('click','.deletePartnerCategoryRebateBTN', function(){
		
			partnerid = $(".content-wrapper").attr('currentid');
			var categoryid=$(this).attr('partnercategoryrebateid');
			if(partnerid !='' && partnerid>0 && categoryid!='' && categoryid>0){
				deletePartnerCategoryRebate(partnerid, categoryid);
			} else {
				alert('Došlo je do greške.');
			}
			
		});;

	} else {
		$("#partnerCategoryRebateTable").DataTable({ 
			"language": {
           		"emptyTable":     "Nema podataka za prikaz",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
				"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
				"infoFiltered":   "(filtrirano od _MAX_ podataka)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikaži _MENU_ podataka",
				"loadingRecords": "Učitavanje...",
				"processing":     "Obrada...",
				"search":         "Pretraga:",
				"zeroRecords":    "Nema rezultata za zadati kriterijum",
				"paginate": {
					"first":      "Prva",
					"last":       "Poslednja",
					"next":       "Sledeća",
					"previous":   "Predhodna"
				}
        	}
		});
	}
}

function clearAddChangePartnerAddress(){
	$(".partnerAddressObjectName").val('');	
	$(".partnerAddressObjectType").val('');
	$(".partnerAddressAddress").val('');
	$(".partnerAddressCity").val('');
	$(".partnerAddressZip").val('');
	$(".partnerAddressRegion").val('');
	$(".partnerAddressDeliveryCode").val('');
	$(".partnerAddressSalesSource").val('');	
}

function savePartnerCategoryRebate(){
	$(".loadingIcon").removeClass("hide");	
	var partnerid = "";
	if($(".content-wrapper").attr('currentid') != "")
	{
		partnerid = $(".content-wrapper").attr('currentid');
	}
	var noerror = true;
	if($(".partnerCategoryRebate").val() == "" || $(".partnerCategoryRebate").val() == 0)
	{
		$('.partnerCategoryRebate').parent().removeClass('has-success').addClass("has-error");
		noerror = false;
	}else{
		$('.partnerCategoryRebate').parent().removeClass("has-error").addClass('has-success');		
	}
	if($(".partnerCategoryRebateCategorySelect").val() == "0")
	{
		$('.partnerCategoryRebateCategorySelect').parent().removeClass('has-success').addClass("has-error");
		noerror = false;
	}else{
		$('.partnerCategoryRebateCategorySelect').parent().removeClass("has-error").addClass('has-success');		
	}

	
	
	if(!noerror){ alert('Popunite obavezna polja'); $(".loadingIcon").addClass("hide");	}
	if(noerror)
	{
		/*	objecty to pass	 */
		var passdata = {action: "savepartnercategoryrebate",
					partnerid: partnerid,
					categoryid: $('.partnerCategoryRebateCategorySelect').val(),
					rebate: $(".partnerCategoryRebate").val()
					};
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: (passdata),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				if($(".content-wrapper").attr('currentid') != '')
				{
					$(".loadingIcon").addClass("hide");	
					$(".addPartnerCategoryRebateCont").addClass('hide');
					rebate: $(".partnerCategoryRebate").val('');
					$(".addPartnerCategoryRebateBTN").removeClass('hide');	
					var table = $('#partnerCategoryRebateTable').DataTable();
					table.ajax.reload();
				}
			}
		});
	}		
}



function deletePartnerCategoryRebate(partnerid, categoryid){
	if (!($(".addPartnerCategoryRebateCont").hasClass('hide'))) {
		$(".addPartnerCategoryRebateCont").addClass('hide');
		//clearAddChangePartnerAddress();
	}
		
	var passdata = {action: "deleteselectedpartnercategoryrebate",
					partnerid: partnerid,
					categoryid: categoryid
					};
					
		
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: (passdata),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("Došlo je do greške.ERROR_NO_DELPAADD001"); 
			  hideLoadingIcon();                           
			},
			success:function(response){
				if(response==1){
					var table = $('#partnerCategoryRebateTable').DataTable();
					table.ajax.reload();	
				} else {
					alert("Došlo je do greške.DELPADD_ERROR_NO_0001");
				}
				
				hideLoadingIcon();
			}
		});
	
}
//PARTNER CATEGORY REBATE END ###############################################################################################################
//PARTNER PRICELIST ###################################################################################################################
	
function savePartnerPricelist(){
	var passdata = {action: "savepartnerpricelist",
					partnerid: $('.content-wrapper').attr('currentid'),
					pricelistid: $('.jq_partnerPricelistSelect').val()
					};	
		
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: (passdata),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("Došlo je do greške.ERROR_NO_DELPAADD001"); 
			  hideLoadingIcon();                           
			},
			success:function(response){
				var a = JSON.parse(response);
				if(a['status'] == 'success'){
					$('.jq_partnerPricelistSelectedName').html($('.jq_partnerPricelistSelect option:selected').text());
					$('.jq_partnerPricelistRemoveButton').attr('pricelistid', $('.jq_partnerPricelistSelect').val()).removeClass('hide');
				}else{
					alert(a['msg']);
				}
				hideLoadingIcon();
			}
		});	
}

function partnerPricelistRemove(){
	if(confirm('Da li ste sigurni?'))
	{
		var passdata = {action: "partnerpricelistremove",
					partnerid: $('.content-wrapper').attr('currentid')
					};	
		
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: (passdata),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("Došlo je do greške.ERROR_NO_DELPAADD001"); 
			  hideLoadingIcon();                           
			},
			success:function(response){
				var a = JSON.parse(response);
				if(a['status'] == 'success'){
					$('.jq_partnerPricelistSelectedName').html('');
					$('.jq_partnerPricelistRemoveButton').attr('pricelistid', '').addClass('hide');
				}else{
					alert(a['msg']);
				}
				hideLoadingIcon();
			}
		});	
	}
}
//PARTNER PRICELIST END ###################################################################################################################