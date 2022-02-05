function resetForm(){
		
}
function showLoadingIcon(){
	$(".loadingIcon").removeClass("hide");	
}
function hideLoadingIcon(){
	$(".loadingIcon").addClass("hide");	
}
$(document).ready(function (e) {
	$("#listtable").DataTable({
		stateSave: true,
		"processing": true,
        "serverSide": true,
        "ajax":{
                url :"modules/"+moduleName+"/library/getdata.php", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".employee-grid-error").html("");
                    $("#example1").append('<tbody class="employee-grid-error"><tr><th colspan="3">Nema vesti u bazi</th></tr></tbody>');
                    $("#employee-grid_processing").css("display","none");
                },
				dataSrc: function(d){
					//console.log(d);
					
					for(var i = 0; i < d.aaData.length;i++)
					{
						if(d.aaData[i][8] != null){
							var b = d.aaData[i][8].split("/");
							d.aaData[i][8] = "<a target='_blank' href='order/change/"+b[1]+"'>"+d.aaData[i][8]+"</a>";
						}else{
							if(d.aaData[i][10] == 'custom')
							{
								d.aaData[i][8] = 'Ručno dodat';	
							}else{
								d.aaData[i][8] = '';	
							}
						}
						
						if(d.aaData[i][9] != null)
						{
							var b = d.aaData[i][9].split("/");
							d.aaData[i][9] = "<a target='_blank' href='order/change/"+b[1]+"'>"+d.aaData[i][9]+"</a>";
						}else{
							d.aaData[i][9]
						}
						
						var bc = '<button class="btn btn-primary changeViewButton" id="'+d.aaData[i][99]+'">Izmeni</button> ';
						var bd = "";
						if($(".userpriv").data("delete") == 1 || $("body").attr("user") == "admin")
						{
							bd = '<button class="btn btn-danger deleteButton" id="'+d.aaData[i][99]+'">Obrisi</button> ';
						}
						d.aaData[i][10] =  bd;
						
						var lb = "";
						if(d.aaData[i][5] == 'u'){
							lb = '<span class="label label-success">Iskorišćen</span>';
						}
						d.aaData[i][5] = lb;
						
						
										
					}
					return d.aaData;
				}
            },
        "language": {
           		"emptyTable":     "No data available in table",
				"info":           "Prikaz _START_ do _END_ od _TOTAL_ vaučera",
				"infoEmpty":      "Prikaz 0 do 0 od 0 vaučera",
				"infoFiltered":   "(filtrirano od _MAX_ vaučera)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Prikazi _MENU_ vaučera",
				"loadingRecords": "Ucitavanje...",
				"processing":     "Obrada...",
				"search":         "Pretraga:",
				"zeroRecords":    "Nema rezultata za zadati kriterijum",
				"paginate": {
					"first":      "Prva",
					"last":       "Zadnja",
					"next":       "Sledeca",
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
			window.location.href = window.location.pathname+'/change/'+$(this).attr('id');
		});
		
		$("#addButton").on("click", function(){
			window.location.href = window.location.pathname+'/add';
		});
		
		$("#listButton").on("click", function(){
			window.location.href = 'vaucer';
		});
		$("#newsCategoryButton").on("click", function(){
			window.location.href = 'vaucer';
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
	
		$('.jq_newCouponAddButton').on('click', function(){
			addCoupon();
		});
		
		
});