
function deleteItem_handler(elem){
	var $this = $(elem);
	var a = confirm("Da li ste sigurni da zelite da obisete stranicu?");
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

function populateReportUserGroup(groupid){
	var returnValue = false ;
	$.ajax({
						type:"POST",
						async: false,
						url:"modules/"+moduleName+"/library/functions_modal.php",
						data: ({action : 'getusergroup' }),
						error:function(XMLHttpRequest, textStatus, errorThrown){
							alert("Došlo je do greške!!! RUG_GET_001!!!");
							return returnValue;                           
						},
						success:function(response){
							var a = JSON.parse(response);
							for(var i = 0; i < a.length; i++){
								var selected='';
								if(a[i].usergroupid==groupid){
									selected='selected="selected"';
								}
								$(".reportUserGroup").append('<option class="option" value="'+a[i].usergroupid+'" '+selected+'>'+a[i].name+'</option>');
							}
						
					}
				});
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
				$(".addChangeReportCont").html('');
				
				$(".reportCode").val(a.code);
				$(".reportName").val(a.name);
				$(".reportUserGroup").val(a.groupid);
				$(".reportDescription").val(a.description);
				$(".reportText").val(a.report);
				$(".loadingIcon").addClass("hide");	
				$(".addChangeCont").removeClass('hide');
				populateReportUserGroup(a.groupid);
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
				
				$(".addChangeReportCont").html('');
				
				$(".reportCode").val('');
				$(".reportName").val('');
				$(".reportUserGroup").val('---');
				$(".reportDescription").val('');
				$(".reportText").val('');
				$(".loadingIcon").addClass("hide");	
				$(".addChangeCont").removeClass('hide');
				populateReportUserGroup(0);
			}
		});	
	}
}



function createPrepareReportForm(){
	if($(".content-wrapper").attr('currentid') != '')
	{
		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action : 'preparereport',
					id : $(".content-wrapper").attr('currentid')}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			success:function(response){
				var a = JSON.parse(response);
				
				//$(".runReportCont").html('');
				$(".reportCode").text("Šifra: "+a.code);
				$(".reportName").text("Naziv: "+a.name);
				$(".reportDescription").text("Opis: "+a.description);
				if(a.reportinputs.length>0){
					
					$(".report-parameters").removeClass('hide');
				}
				for(var i = 0; i < a.reportinputs.length; i++){
					//alert(a.reportinputs[i].inputName);
					if(a.reportinputs[i].inputType=='string'){
						var clone = $(".stringInputContTemplate").clone(true).removeClass('hide').removeClass('stringInputContTemplate').attr('report-input-name', a.reportinputs[i].inputName).attr('report-input-mask', a.reportinputs[i].inputMask);
						$(clone).find(".stringInputName").text(a.reportinputs[i].inputName);
						$(clone).find(".stringInputValue").attr('placeholder','Unesite '+a.reportinputs[i].inputName.toString().toLowerCase());
						//$(clone).find(".ckcont").attr('id', 'ckeditor'+a[i].id);
					
						$(clone).appendTo($(".reportInputData"));
					}
					else if(a.reportinputs[i].inputType=='float'){
						//DEFINE FLOAT INPUT
					}
					else if(a.reportinputs[i].inputType=='date'){
						//DEFINE DATE INPUT
					}	
					else if(a.reportinputs[i].inputType=='partner.id'){
						var clone = $(".partnerInputContTemplate").clone(true).removeClass('hide').removeClass('partnerInputContTemplate').attr('report-input-name', a.reportinputs[i].inputName).attr('report-input-mask', a.reportinputs[i].inputMask);
						$(clone).find(".partnerInputName").text(a.reportinputs[i].inputName);
						$(clone).find(".partnerInputValue").attr('placeholder','Odaberite klikom na dugme "..."');
						$(clone).find(".selectPartnerButton").attr('data-target',"#"+a.reportinputs[i].inputName.toString().replace(" ", ""));
						//$(clone).find(".selectPartnerModal").attr('id',a.reportinputs[i].inputName.toString().replace(" ", ""));
						//$(clone).find(".ckcont").attr('id', 'ckeditor'+a[i].id);
					
						$(clone).appendTo($(".reportInputData"));
					}
					else if(a.reportinputs[i].inputType=='product.id'){
						//DEFINE product.id INPUT
					}
					else if(a.reportinputs[i].inputType=='product.ids'){
						//DEFINE product.ids INPUT
					}
					else if(a.reportinputs[i].inputType=='categorypr.ids'){
						//DEFINE categorypr.ids INPUT
					}
					else if(a.reportinputs[i].inputType=='document.id'){
						//DEFINE document.id INPUT
					}
					else if(a.reportinputs[i].inputType=='warehouse.id'){
						//DEFINE warehouse.id INPUT
					}
					else if(a.reportinputs[i].inputType=='user.id'){
						//DEFINE user.id INPUT
					}
					else if(a.reportinputs[i].inputType=='loggeduser.id'){
						//DEFINE loggeduser.id INPUT
					}
					else if(a.reportinputs[i].inputType=='loggeduser.username'){
						//DEFINE loggeduser.username INPUT
					}
					else if(a.reportinputs[i].inputType=='document.documenttype'){
						//DEFINE document.documenttype INPUT
					}
					else if(a.reportinputs[i].inputType=='bankstatement.statementtype'){
						//DEFINE bankstatement.statementtype INPUT
					}
					else if(a.reportinputs[i].inputType=='partner.partnertype'){
						//DEFINE partner.partnertype INPUT
					} else {
						$(".report-parameters").addClass('hide');
						alert("Izveštaj sadrži nevalidne ulazne parametre!!!");
					}
					
				}

				
				
				$(".loadingIcon").addClass("hide");	
				$(".runReportCont").removeClass('hide');
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
				
				$(".runReportCont").html('');
				
				
				
				$(".loadingIcon").addClass("hide");	
				$(".addChangeCont").removeClass('hide');
			}
		});	
	}
}


function prepareAndCollectReportInputData(){
	//var returnValue=false;
	$.ajax({
						type:"POST",
						async: false,
						url:"modules/"+moduleName+"/library/functions.php",
						data: ({action : 'prepareforcolectinputdata' }),
						error:function(XMLHttpRequest, textStatus, errorThrown){
							alert("Došlo je do greške!!! RQ_EMPTY_001!!!");
							return returnValue;                           
						},
						success:function(response){
							var a = JSON.parse(response);
							if(a=='true'){
								collectReportInputData();
								//returnValue=true;	
								//return returnValue;
							} else {
								alert("Došlo je do greške!!! RQ_COLECT_001!!!");
							}
						
					}
				});

	
}




//SAKUPLJA PODATKE INPUTA I VRSI PROVERE DA LI SU SVI PARAMETRI UNETI POZIVA SE U SCRIPT JS NA DUGMETU ZA POKRENI IZVESTAJ
function collectReportInputData(){
	var returnValue=false;

	var hasInputs=false;
	var hasInputCnt=0;
	$( ".reportInput" ).each(function() {
		if(!$( this ).hasClass("hide")){
			hasInputCnt++;
		}
	});	
	//$hasInputs=$(".runReportCont").hasClass("hide");
	var inputCount=0;
	var inputPopulated=0;

	if(hasInputCnt>0){

		var colecteddata = {
			values : [] 
		};


		$( ".reportInput" ).each(function() {
			if(!$( this ).hasClass("hide")){
				$inputType = $( this ).attr( "report-input-type" );
				$inputName = $( this ).attr( "report-input-name" );
				$inputMask = $( this ).attr( "report-input-mask" );
				$inputValue = $( this ).attr("report-input-value");
				
				console.log( $inputType+" *** "+$inputName+" *** "+$inputMask+" *** "+$inputValue );	
				if($inputType !="" && $inputName !="" && $inputMask !="" && $inputValue !=""){

					inputCount++;
					inputPopulated++;

					//push
					colecteddata['values'].push({
						inputType : $inputType,
						inputName : $inputName,
						inputMask : $inputMask,
						inputValue : $inputValue

					});

					

				} else {
					inputCount++;
				}

			} //else{
				//NO INPUT DATA
			//}			

		}
		);

		$.ajax({
		type:"POST",
		url:"modules/"+moduleName+"/library/functions.php",
		data: ({action : 'updatecolectedinputdata',
			colecteddata: colecteddata }),
		error:function(XMLHttpRequest, textStatus, errorThrown){
			//returnValue=false;
			//return returnValue;
			alert("Došlo je do greske u parsiranju podataka!!! RQ_COLECT_002!!!");

		},
		success:function(response){
			//var a = JSON.parse(response);
			

		}
	});






	} 

	


	if(hasInputCnt==0){
				window.location.href = window.location.pathname+'/run';	
			} else if(hasInputCnt>0 && inputCount==inputPopulated){
				window.location.href = window.location.pathname+'/run';	
			}else if(hasInputCnt>0 && inputCount!=inputPopulated){
				alert("Niste uneli sve ulazne parametre!");
			}
}



function createRunReportForm(){
	if($(".content-wrapper").attr('currentid') != '')
	{
		var table = $('#reportDataTable').DataTable({
			stateSave: true,
			"processing": true,
       		 "serverSide": true,
			"ajax":{
                url :"modules/"+moduleName+"/library/functions.php", // json datasource
                type: "post",  // method  , by default get
                data: ({action : 'runreport2',
					id : $(".content-wrapper").attr('currentid')}),
                error: function(){  // error handling
                    $(".reportDataTable-grid-error").html("");
                    $("#reportDataTable").append('<tbody class="employee-grid-error"><tr><th colspan="3">Nema pronadjenih podataka</th></tr></tbody>');
                    $("#reportDataTable-grid_processing").css("display","none");
                },
				dataSrc: function(a){
					//console.log(d);
					 
				 	$(".reportCodeInfo").text(a.code);
				 	$(".reportNameInfo").text(a.name);

				 	$tableHeader="";
				 for(var i = 0; i < a.tableheader.length; i++){
				 	//alert(a.tableheader[i]);
				 	$tableHeader+="<th>"+a.tableheader[i]+"</th>";
				 	
				 }
				 // table.clear();
				 $("#reportDataTable thead").html("");
				 $("#reportDataTable thead").append("<tr>"+$tableHeader+"</tr>");

				 	$(".loadingIcon").addClass("hide");	
					$(".runReportCont").removeClass('hide');
					
					return a.aaData;
				}
            },
            "language": {
           		"emptyTable":     "Nema pronađenih podataka za zadate parametre",
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
					"next":       "Sledeca",
					"previous":   "Predhodna"
				}
        	}
		});

		
	}
}







function createRunReportFormBKP(){
	if($(".content-wrapper").attr('currentid') != '')
	{
		var table = $('#reportDataTable').DataTable();

		$.ajax({
			type:"POST",
			url:"modules/"+moduleName+"/library/functions.php",
			data: ({action : 'runreport',
					id : $(".content-wrapper").attr('currentid')}),
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  		$(".reportDataTable-grid-error").html("");
                    $("#reportDataTable").append('<tbody class="employee-grid-error"><tr><th colspan="3">Nema pronadjenih podataka</th></tr></tbody>');
                    $("#reportDataTable-grid_processing").css("display","none");                           
			},
			success:function(response){

				 var a = JSON.parse(response);
				 $(".reportCodeInfo").text(a.code);
				 $(".reportNameInfo").text(a.name);





				 $tableHeader="";
				 for(var i = 0; i < a.tableheader.length; i++){
				 	//alert(a.tableheader[i]);
				 	$tableHeader+="<th>"+a.tableheader[i]+"</th>";
				 	
				 }
				 // table.clear();
				 $("#reportDataTable thead").html("");
				 $("#reportDataTable thead").append("<tr>"+$tableHeader+"</tr>");
				
				 //alert(a.tabledata[0]);
				 //table.data(a.tabledata);
				 alert(a.tabledata);
				 //table.data((a.tabledata));
				 table.rows.add(JSON.parse(a.tabledata));
   
				 for(var i = 0; i < a.tabledata.length; i++){
				 	 $tableDataRow=[];
				 	 $tableDataRowStr="";
				 	//alert(a.tabledata[i]);
				 	for(var j = 0; j < a.tabledata[i].length; j++){
				 		//alert(a.tabledata[i][j]);
				 		$tableDataRow.push(a.tabledata[i][j]);
				 		$tableDataRowStr+="<td>"+a.tabledata[i][j]+"</td>";
				 	
				 	}
				 	//$("#reportDataTable").append("<tbody>"+$tableDataRowStr+"</tbody>");
				 	//alert($tableDataRow);
				 	table.row.add($tableDataRow).draw();
				 	//tabledata.push({a.tabledata[i]});
				 	//$tableHeader+="<th>"+a.tableheader[i]+"</th>";
				 	
				 }
				  table.draw();

				 
				// //$(".runReportCont").html('');
				// $(".reportCode").text("Šifra: "+a.code);
				// $(".reportName").text("Naziv: "+a.name);
				// $(".reportDescription").text("Opis: "+a.description);
				// if(a.reportinputs.length>0){
					
				// 	$(".report-parameters").removeClass('hide');
				// }
				// for(var i = 0; i < a.reportinputs.length; i++){
					
				// 	var clone = $(".stringInputContTemplate").clone(true).removeClass('hide').removeClass('stringInputContTemplate').attr('report-input-name', a.reportinputs[i].inputName).attr('report-input-mask', a.reportinputs[i].inputMask);
				// 	$(clone).find(".stringInputName").text(a.reportinputs[i].inputName);
				// 	$(clone).find(".stringInputValue").attr('placeholder','Unesite '+a.reportinputs[i].inputName.toString().toLowerCase());
				// 	//$(clone).find(".ckcont").attr('id', 'ckeditor'+a[i].id);
					
				// 	$(clone).appendTo($(".reportInputData"));	
					
				// }

				
				
				$(".loadingIcon").addClass("hide");	
				$(".runReportCont").removeClass('hide');

			}
		});
	}
}

function saveAddChange(){
	var reportid = "";
	if($(".content-wrapper").attr('currentid') != "")
	{
		reportid = $(".content-wrapper").attr('currentid');
	}

	
	var noerror = true;
	if($(".reportCode").val() == "")
	{
		$('.reportCode').parent().addClass("has-error");
		noerror = false;
	}
	if($(".reportName").val() == "")
	{
		$('.reportName').parent().addClass("has-error");
		noerror = false;
	}
	if($(".reportUserGroup").val() == "")
	{
		$('.reportUserGroup').parent().addClass("has-error");
		noerror = false;
	}
	if($(".reportDescription").val() == "")
	{
		$('.reportDescription').parent().addClass("has-error");
		noerror = false;
	}
	if($(".reportText").val() == "")
	{
		$('.reportText').parent().addClass("has-error");
		noerror = false;
	}
	
	if(!noerror){ alert('Popunite obavezna polja'); $(".loadingIcon").addClass("hide");	}

	if(noerror)
	{
		/*	objecty to pass	 */
		var passdata = {action: "saveaddchange",
					reportid: reportid,
					code : $(".reportCode").val(),
					name : $('.reportName').val(),
					groupid : $('.reportUserGroup').val(),
					description : $('.reportDescription').val(),
					report : $('.reportText').val()
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
					window.location.href = 'report';
				}
			}
		});
	}		
}

function convertToCsv(fName, rows) {
        var csv = '';
        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];
            for (var j = 0; j < row.length; j++) {
                var val = row[j] === null ? '' : row[j].toString();
                val = val.replace(/\t/gi, " ");
                if (j > 0)
                    csv += '\t';
                csv += val;
            }
            csv += '\n';
        }

        // for UTF-16
        var cCode, bArr = [];
        bArr.push(255, 254);
        for (var i = 0; i < csv.length; ++i) {
            cCode = csv.charCodeAt(i);
            bArr.push(cCode & 0xff);
            bArr.push(cCode / 256 >>> 0);
        }

        var blob = new Blob([new Uint8Array(bArr)], { type: 'text/csv;charset=UTF-16LE;' });
        if (navigator.msSaveBlob) {
            navigator.msSaveBlob(blob, fName);
        } else {
            var link = document.createElement("a");
            if (link.download !== undefined) {
                var url = window.URL.createObjectURL(blob);
                link.setAttribute("href", url);
                link.setAttribute("download", fName);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                window.URL.revokeObjectURL(url);
            }
        }
    }