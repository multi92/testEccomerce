function resetForm(){
	$(".addChangeCont").find("input").each(function(){
		$(this).val("");
		$(".loaded").attr('id', "");
		for(var i in CKEDITOR.instances)
		{
			CKEDITOR.instances[i].setData('')
		}
		$('input[name=reportside]:checked').prop('checked', false)	
	});	
}
function showLoadingIcon(){
	$(".loadingIcon").removeClass("hide");	
}
function hideLoadingIcon(){
	$(".loadingIcon").addClass("hide");	
}

var initTableDefault=0;


function populateFilterPartnerType(){
	var returnValue = false ;
	$.ajax({
						type:"POST",
						async: false,
						url:"modules/"+moduleName+"/library/functions_modal.php",
						data: ({action : 'getpartnertype' }),
						error:function(XMLHttpRequest, textStatus, errorThrown){
							alert("Došlo je do greške!!! FPAT_GET_001!!!");
							return returnValue;                           
						},
						success:function(response){
							var a = JSON.parse(response);
							for(var i = 0; i < a.length; i++){
								//alert(a[i].partnertype);
								var selected='';
								if(a[i].selected=='y'){
									selected='selected="selected"';
								}
								$(".filterPartnerType").append('<option class="option" value="'+a[i].partnertype+'" '+selected+'>'+a[i].partnertype+'</option>');
							}
						
					}
				});
}





$(document).ready(function(e) {

	if(performance.navigation.type == 2){
   		location.reload(true);
	}


	populateFilterPartnerType();

	
	// $('#reportDataTable').DataTable({
		
 //        "language": {
 //           		"emptyTable":     "Nema pronađenih podataka za zadate parametre",
	// 			"info":           "Prikaz _START_ do _END_ od _TOTAL_ podataka",
	// 			"infoEmpty":      "Prikaz 0 do 0 od 0 podataka",
	// 			"infoFiltered":   "(filtrirano od _MAX_ podataka)",
	// 			"infoPostFix":    "",
	// 			"thousands":      ",",
	// 			"lengthMenu":     "Prikaži _MENU_ podataka",
	// 			"loadingRecords": "Učitavanje...",
	// 			"processing":     "Obrada...",
	// 			"search":         "Pretraga:",
	// 			"zeroRecords":    "Nema rezultata za zadati kriterijum",
	// 			"paginate": {
	// 				"first":      "Prva",
	// 				"last":       "Poslednja",
	// 				"next":       "Sledeca",
	// 				"previous":   "Predhodna"
	// 			}
 //        	}

	// 	});
	//MODAL SELECT PARTNER
	var tableModalSelectPartnerDataTable = $('#modalSelectPartnerDataTable').not('.initialized').addClass('initialized').DataTable({
		
        "language": {
           		"emptyTable":     "Nema pronađenih partnera za zadate parametre",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ partnera",
				"infoEmpty":      "Prikaz 0 do 0 od 0 partnera",
				"infoFiltered":   "(filtrirano od _MAX_ partnera)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikaži _MENU_ partnera",
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

	
    $('#modalSelectPartnerDataTable tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
           // tableModalSelectPartnerDataTable.$('tr.selected').removeClass('selected');
            $('#modalSelectPartnerDataTable tbody tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
    
    $('.selectPartnerButton').mousedown( function () {
    	target=$(this).attr('data-target').toString().replace("#", "");
    	$(".selectPartnerModal").attr('id',target);
    } );
    $('.exportToCsvReportButton').click( function () {
    	//alert('Izvozi podatke');
    	showLoadingIcon();

    	var returnValue = false ;
		
    	var table=$('#reportDataTable').DataTable();
    	//alert(table.data());
    	
    	//alert($('#reportDataTable').DataTable().columns());
    	//var tabledata=[];
    	 var tableexportdata=[];
    	 var thdata=[];
    	 var tddata=[];
    	$("#reportDataTable thead tr th").each(function(){
        	thdata.push(this.innerHTML);
        //alert(this.innerHTML); //This executes once per column showing your column names!
    	});

    	// $("#reportDataTable tbody tr td").each(function(){
     //    	tddata.push(this.innerHTML);
     //    //alert(this.innerHTML); //This executes once per column showing your column names!
    	// });

        var tdata={
        	 tableheader:JSON.stringify(thdata),
        	 tabledata:JSON.stringify(table.data())
        };
        tableexportdata.push(thdata);
        table.rows().eq(0).each( function ( index ) {
    		var row = table.row( index );
    		var data = row.data();
    		var rowArr=[];
    		for (i = 0; i < data.length; i++) {
 			 rowArr.push(data[i]);
 			}
 			tableexportdata.push(rowArr);
 		} );

 
		console.log(thdata);
		console.log(tddata);
		var now = new Date();
    	var day = ("0" + now.getDate()).slice(-2);
    	var month = ("0" + (now.getMonth() + 1)).slice(-2);
    	//var today = now.getFullYear() + "-" + (month) + "-" + (day);
		var curentDate=(day) + "_" + (month) + "_" + now.getFullYear();
		var fileName=$('.reportNameInfo').text()+"_"+curentDate+".csv";
		convertToCsv(fileName,tableexportdata);
		hideLoadingIcon();
    	
    });
    $('.modalPartnerSelectedButton').click( function () {
    	var table = $('#modalSelectPartnerDataTable').DataTable();
    	//alert();

    	var count = table.rows('.selected').data().length;
    	if(count>0){
    		
    		var d = table.rows('.selected').data();
    		var selectedRow=d[0];
    		selectedPartnerId=selectedRow[0];
    		selectedPartnerName=selectedRow[1];
    		//dodati proveru gde se upisuje
    		$('.selectPartnerModal').attr("selectedPartnerId",selectedPartnerId);
    		$('.selectPartnerModal').attr("selectedPartnerName",selectedPartnerName);
    		inputNameId='#'+$('.selectPartnerModal').attr("id");
    		
    		//$(".partnerInputCont").hasAttr("")
    		//var el = $(".runReportCont").find(".partnerInputCont [report-input-name='" + inputNameId + "']"); 
    		////el.find('.partnerInputValue').val(selectedPartnerName);
    		//el.find('.partnerInputValue').attr("selectedPartnerId",selectedPartnerId);
    		//el.attr('report-input-value',selectedPartnerId);
    		$.each($('.selectPartnerButton'), function() { 
    			if($(this).attr('data-target')==inputNameId){
    				$(this).parent().parent().find('.partnerInputValue').val(selectedPartnerName);
		    		$(this).parent().parent().find('.partnerInputValue').attr("selectedPartnerId",selectedPartnerId);
		    		$(this).parent().parent().parent().attr("report-input-value",selectedPartnerId);	

    			}
			  // console.log($(this).val());
 			});
    		//$(".selectPartnerButton").parent().parent().find('.partnerInputValue').val(selectedPartnerName);
    		//$(".selectPartnerButton").parent().parent().find('.partnerInputValue').attr("selectedPartnerId",selectedPartnerId);	


    		$(".selectPartnerModal").modal("hide");
    		


    		//$(".selectPartnerModal").attr('id',a.reportinputs[i].inputName.toString().replace(" ", ""));

    	} else {
    		alert('Niste izabrali partnera!');
    	}
    	table.destroy();
        
    } );
    /*$('#example tbody').on( 'click', 'button', function () {
        var data = table.row( $(this).parents('tr') ).data();
        alert( data[0] +"'s salary is: "+ data[ 5 ] );
    } );*/
    $(".clearFilterPartnerButton").on('click', function(e) {
    	 $(".filterPartnerName").val('');
    	 $(".filterPartnerCode").val('');
    	 $(".filterPartnerType option[value='---']").prop('selected', true);
    	 $(".filterPartnerNumber").val('');
    	 $(".filterPartnerCity").val('');
    	 $(".filterPartnerZip").val('');
    	 $(".filterPartnerActive option[value='---']").prop('selected', true);
    	 $(".filterResponsiblePersonName").val('');
    	 $(".filterResponsiblePersonLastName").val('');
    	 $(".filterIdent").val('');
    	 $(".filterPartnerDescription").val('');
    	 var returnValue = false ;
    	 $.ajax({
						type:"POST",
						async: false,
						url:"modules/"+moduleName+"/library/functions_modal.php",
						data: ({action : 'clearfilterpartnermodal' }),
						error:function(XMLHttpRequest, textStatus, errorThrown){
							alert("Došlo je do greške!!! FPA_EMPTY_001!!!");
							return returnValue;                           
						},
						success:function(response){
							var a = JSON.parse(response);
								returnValue=a;
								return returnValue;
						
					}
				});
    });


    $(".filterPartnerButton").on('click', function(e) {
		//e.preventDefault();
		$('.selectPartnerModal').attr('initTableDefault','1');

		
		if($('#modalSelectPartnerDataTable').hasClass('initialized'))
			{
				var table = $('#modalSelectPartnerDataTable').DataTable({
		stateSave: true,
		"processing": true,
        "serverSide": true,
        "ajax":{
        			type:"POST",
					url:"modules/"+moduleName+"/library/functions_modal.php",
					data : function(d){
						d.action = "filterpartnermodal";
						d.initTable=$('.selectPartnerModal').attr('initTableDefault');
					    d.filterPartnerName = $(".filterPartnerName").val();
					    d.filterPartnerCode = $(".filterPartnerCode").val();
					    d.filterPartnerType = $( ".filterPartnerType option:selected" ).val();
					    d.filterPartnerNumber = $(".filterPartnerNumber").val();
					    d.filterPartnerCity =  $(".filterPartnerCity").val();
					    d.filterPartnerZip = $(".filterPartnerZip").val();
					    d.filterPartnerActive = $( ".filterPartnerActive option:selected" ).val();
					    d.filterResponsiblePersonName = $(".filterResponsiblePersonName").val();
					    d.filterResponsiblePersonLastName = $(".filterResponsiblePersonLastName").val();
					    d.filterIdent = $(".filterIdent").val();
					    d.filterPartnerDescription = $(".filterPartnerDescription").val();
					}/*
					data: { action: "filterpartnermodal",         
                		initTable:'1',//$('#selectPartnerModal').attr('initTableDefault'),
					    filterPartnerName : $(".filterPartnerName").val(),
					    filterPartnerCode : $(".filterPartnerCode").val(),
					    filterPartnerType : $(".filterPartnerType").val(),
					    filterPartnerNumber : $(".filterPartnerNumber").val(),
					    filterPartnerCity :  $(".filterPartnerCity").val(),
					    filterPartnerZip : $(".filterPartnerZip").val(),
					    filterPartnerActive : $(".filterPartnerActive").val(),
					    filterResponsiblePersonName : $(".filterResponsiblePersonName").val(),
					    filterResponsiblePersonLastName : $(".filterResponsiblePersonLastName").val(),
					    filterIdent : $(".filterIdent").val(),
					    filterPartnerDescription : $(".filterPartnerDescription").val()
								 }*/
			},
					
			error:function(XMLHttpRequest, textStatus, errorThrown){
			  alert("ERROR");                            
			},
			dataSrc: function(a){
				//var a = JSON.parse(response);
                //if($('#selectPartnerModal').attr('initTableDefault')=='1'){
					return a.aaData;
                //}
			
				
            },
        "language": {
           		"emptyTable":     "Nema pronađeni partnera za zadate parametre",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ partnera",
				"infoEmpty":      "Prikaz 0 do 0 od 0 partnera",
				"infoFiltered":   "(filtrirano od _MAX_ partnera)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikaži _MENU_ partnera",
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
				//table.clear().draw();
    			//table.fnClearTable();
    			//table.ajax.reload();

    			table.destroy();

    			
			}
		
		//$('#modalSelectPartnerDataTable').DataTable().destroy();
			
		//table.destroy();
		//$('#modalSelectPartnerDataTable').data.reload();
		//tableModalSelectPartnerDataTable.clear();

		//$('#modalSelectPartnerDataTable').DataTable().ajax.reload();
		//tableModalSelectPartnerDataTable.ajax.reload();
		//tableModalSelectPartnerDataTable.draw();
		//tableModalSelectPartnerDataTable.datatable.draw();
		//tableModalSelectPartnerDataTable.clear();
		//tableModalSelectPartnerDataTable.destroy();
		//tableModalSelectPartnerDataTable.data.reload();
		//tableModalSelectPartnerDataTable.ajax.reload(function ( json ) {
    	//	$('#modalSelectPartnerDataTable').val( json.lastInput );
		//});
		//tableModalSelectPartnerDataTable.fnDraw();

		

		
	});
 	//MODAL SELECT PARTNER END
	$("#example1").DataTable({
		stateSave: true,
		"processing": true,
        "serverSide": true,
        "ajax":{
                url :"modules/"+moduleName+"/library/getdata.php", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".employee-grid-error").html("");
                    $("#example1").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#employee-grid_processing").css("display","none");
                },
				dataSrc: function(d){
					//console.log(d);
					
					for(var i = 0; i < d.aaData.length;i++)
					{
						
						
						var bc = '<button class="btn btn-primary disabled " disabled="disabled">Izmeni</button> ';
						if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('change') == '1'))
						{
							var bc = '<button class="btn btn-primary changeViewButton" id="'+d.aaData[i][99]+'">Izmeni</button> ';
						}
						var bd = "";
						if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('delete') == '1'))
						{
							bd = '<button class="btn btn-danger deleteButton" id="'+d.aaData[i][99]+'">Obrisi</button> ';
						}
						d.aaData[i][4] = bc + bd;
						var brun = "";
						if($("body").attr("user") == "admin" || ($("body").attr("user") == "moderator" && $('.userpriv').data('delete') == '1'))
						{
							brun = '<button class="btn btn-primary runButton" id="'+d.aaData[i][99]+'">Izaberi</button> ';
						}
						d.aaData[i][5] = brun;
										
					}
					return d.aaData;
				}
            },
        "language": {
           		"emptyTable":     "No data available in table",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ izveštaja",
				"infoEmpty":      "Prikaz 0 do 0 od 0 izveštaja",
				"infoFiltered":   "(filtrirano od _MAX_ izveštaja)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikaži _MENU_ izveštaja",
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
	
	$('#example1 tbody').on('click', '.deleteButton', function () {
      	var $this = $(this);
		var a = confirm("Da li ste sigurni da zelite da obisete izveštaj?");
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
	 }).on('click', '.runButton', function () {
      	window.location.href = window.location.pathname+'/prepare/'+$(this).attr('id');
    }).on('click', '.changeViewButton', function () {
      	window.location.href = window.location.pathname+'/change/'+$(this).attr('id');
		
    }).on('change', '.selectStatus', function () {
      	showLoadingIcon();
		$this = $(this);
		if($(this).attr("currentStatus") != $(this).val())
		{
			$.ajax({
			  method: "POST",
			  url: "modules/"+moduleName+"/library/functions.php",
			  data: { action: "changestatus", id: $this.attr("id"), status:$(this).val() }
			}).done(function(result){
				$this.removeClass("background-"+$this.attr("currentStatus")).addClass("background-"+$this.val()).attr("currentStatus", $this.val());
				
				hideLoadingIcon();
			});
			
		}
    }).on('change', '.sort', function () {
      	showLoadingIcon();
		$this = $(this);
		if($(this).attr("currentSort") != $(this).val())
		{
			$.ajax({
			  method: "POST",
			  url: "modules/"+moduleName+"/library/functions.php",
			  data: { action: "changesort", id: $this.attr("id"), sort:$(this).val() }
			}).done(function(result){
				hideLoadingIcon();
			});
			
		}
    });
	
	
	
	$("#addButton").on("click", function(){
		window.location.href = window.location.pathname+'/add';
	});
	
	$("#listButton").on("click", function(){
		window.location.href = 'report';		
	});
	$(".runReportButton").on("click", function(){
		prepareAndCollectReportInputData();
		//	window.location.href = window.location.pathname+'/run';	
	    
	    //	alert("Niste uneli sve ulazne parametre!");
	    

	});
	
	$(document).on("change",".dateInputValue", function(){
		//alert($(this).val());
		//var e = $(this);
		$(this).parents('.dateInputCont').attr('report-input-value',$(this).val());
	    

	});

	$(document).on("change",".floatInputValue", function(){
		//alert($(this).val());
		//var e = $(this);
		$(this).parents('.floatInputCont').attr('report-input-value',$(this).val());
	    

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
	}
	
	if($(".content-wrapper").attr('currentview') == 'add'){
		createAddChangeForm();	
		
		$(".saveAddChange").on('click', function(){
			showLoadingIcon();
			saveAddChange();
		});
	}
	if($(".content-wrapper").attr('currentview') == 'prepare'){
		createPrepareReportForm();	
	}
	if($(".content-wrapper").attr('currentview') == 'run'){

		createRunReportForm();	
	}
	

	$(document).on("change paste keyup",".stringInputValue", function() {
   		//alert($(this).val()); 
   		$(this).parent().parent().parent().attr('report-input-value',$(this).val());
	});
	//TREBA DODATI CHANGE EVENT I ZA OSTALE TIPOVE
	

	 //$(".stringInputName").change(function() { 
	// 	alert($(this).val());  
	 //}); 

	//MODALS
	//selectPArtnerModal

	//REPORT INPUT BUTTONS
	$(".endReport").on("click", function(){
		var cursorPos = $('.reportText').prop('selectionStart');
    	var v = $('.reportText').val();
    	var textBefore = v.substring(0,  cursorPos);
    	var textAfter  = v.substring(cursorPos, v.length);
    	$('.reportText').val(textBefore + '###' + textAfter);	
	});
	$(".stringReportInput").on("click", function(){
		var cursorPos = $('.reportText').prop('selectionStart');
    	var v = $('.reportText').val();
    	var textBefore = v.substring(0,  cursorPos);
    	var textAfter  = v.substring(cursorPos, v.length);
    	$('.reportText').val(textBefore + '[string:Parametar]' + textAfter);	
	});
	$(".floatReportInput").on("click", function(){
		var cursorPos = $('.reportText').prop('selectionStart');
    	var v = $('.reportText').val();
    	var textBefore = v.substring(0,  cursorPos);
    	var textAfter  = v.substring(cursorPos, v.length);
    	$('.reportText').val(textBefore + '[float:Parametar]' + textAfter);	
	});
	$(".dateReportInput").on("click", function(){
		var cursorPos = $('.reportText').prop('selectionStart');
    	var v = $('.reportText').val();
    	var textBefore = v.substring(0,  cursorPos);
    	var textAfter  = v.substring(cursorPos, v.length);
    	$('.reportText').val(textBefore + '[date:Datum]' + textAfter);	
	});
	$(".productReportInput").on("click", function(){
		var cursorPos = $('.reportText').prop('selectionStart');
    	var v = $('.reportText').val();
    	var textBefore = v.substring(0,  cursorPos);
    	var textAfter  = v.substring(cursorPos, v.length);
    	$('.reportText').val(textBefore + '[product.id:Proizvod]' + textAfter);	
	});
	$(".productsReportInput").on("click", function(){
		var cursorPos = $('.reportText').prop('selectionStart');
    	var v = $('.reportText').val();
    	var textBefore = v.substring(0,  cursorPos);
    	var textAfter  = v.substring(cursorPos, v.length);
    	$('.reportText').val(textBefore + '[product.ids:Proizvodi]' + textAfter);	
	});
	$(".partnerReportInput").on("click", function(){
		var cursorPos = $('.reportText').prop('selectionStart');
    	var v = $('.reportText').val();
    	var textBefore = v.substring(0,  cursorPos);
    	var textAfter  = v.substring(cursorPos, v.length);
    	$('.reportText').val(textBefore + '[partner.id:Partner]' + textAfter);	
	});
	$(".partnersReportInput").on("click", function(){
		var cursorPos = $('.reportText').prop('selectionStart');
    	var v = $('.reportText').val();
    	var textBefore = v.substring(0,  cursorPos);
    	var textAfter  = v.substring(cursorPos, v.length);
    	$('.reportText').val(textBefore + '[partner.ids:Partneri]' + textAfter);	
	});
	$(".partnerTypeReportInput").on("click", function(){
		var cursorPos = $('.reportText').prop('selectionStart');
    	var v = $('.reportText').val();
    	var textBefore = v.substring(0,  cursorPos);
    	var textAfter  = v.substring(cursorPos, v.length);
    	$('.reportText').val(textBefore + '[partner.partnertype:Tip partnera]' + textAfter);	
	});
	$(".documentReportInput").on("click", function(){
		var cursorPos = $('.reportText').prop('selectionStart');
    	var v = $('.reportText').val();
    	var textBefore = v.substring(0,  cursorPos);
    	var textAfter  = v.substring(cursorPos, v.length);
    	$('.reportText').val(textBefore + '[document.id:Tip partnera]' + textAfter);	
	});
	$(".documentTypeReportInput").on("click", function(){
		var cursorPos = $('.reportText').prop('selectionStart');
    	var v = $('.reportText').val();
    	var textBefore = v.substring(0,  cursorPos);
    	var textAfter  = v.substring(cursorPos, v.length);
    	$('.reportText').val(textBefore + '[document.documenttype:Tip partnera]' + textAfter);	
	});
	$(".warehouseReportInput").on("click", function(){
		var cursorPos = $('.reportText').prop('selectionStart');
    	var v = $('.reportText').val();
    	var textBefore = v.substring(0,  cursorPos);
    	var textAfter  = v.substring(cursorPos, v.length);
    	$('.reportText').val(textBefore + '[warehouse.id:Tip partnera]' + textAfter);	
	});
	$(".userReportInput").on("click", function(){
		var cursorPos = $('.reportText').prop('selectionStart');
    	var v = $('.reportText').val();
    	var textBefore = v.substring(0,  cursorPos);
    	var textAfter  = v.substring(cursorPos, v.length);
    	$('.reportText').val(textBefore + '[user.id:Tip partnera]' + textAfter);	
	});
	$(".loggedUserReportInput").on("click", function(){
		var cursorPos = $('.reportText').prop('selectionStart');
    	var v = $('.reportText').val();
    	var textBefore = v.substring(0,  cursorPos);
    	var textAfter  = v.substring(cursorPos, v.length);
    	$('.reportText').val(textBefore + '[loggeduser.id:Tip partnera]' + textAfter);	
	});
	//REPORT INPUT BUTTONS END



	
	
});