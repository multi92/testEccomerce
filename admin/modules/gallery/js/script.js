function showLoadingIcon() {
    $(".loadingIcon").removeClass("hide");
}

function hideLoadingIcon() {
    $(".loadingIcon").addClass("hide");
}

function clearadditemform() {
    for (var i = 0; i < lang.length; i++) {
        $(".newGalleryItemTitle").val('');
        $(".newGalleryItemDesc").val('');
    }
    $(".addGalleryItemLink").val('').parent().show();
    $(".addGalleryItemType").val('').parent().show();
    $(".addGalleryItemShowInfo").val('');
    $(".addGalleryItemInfoPosition").val('');
    $(".addGalleryItemInfoImg").val('');
    
    
    $(".addGalleryItemJumpLink").val('');

}
function add_detail_button(parent, id) {
    $(document.createElement("input")).attr("type", "button").addClass("btn").addClass("btn-danger").addClass("galleryItemDetailButton").addClass('topPosition').addClass('rightPosition').attr('giitemid', id).val("Detalji").appendTo(parent);
}

$(document).ready(function (e) {

	$(document).on('click', '.galleryItemDetailButton', function(e){
		e.stopImmediatePropagation();
		var id = $(this).parents('.galleryItemCont').find('.galleryItemButton').attr('itemid')
		var t = $(this);
        $.ajax({
            method: "POST",
            url: "modules/gallery/library/functions.php",
            data: {action: "getgalleryitemdata", id: id}
        }).done(function (result) {
            var idata = JSON.parse(result);
			
            for (var i = 0; i < (idata.lang).length; i++) {
                $(".newGalleryItemDescCont[langid='"+idata.lang[i].langid+"']").find('.newGalleryItemTitle').val(idata.lang[i].title);
                $(".newGalleryItemDescCont[langid='"+idata.lang[i].langid+"']").find('.newGalleryItemDesc').val(idata.lang[i].text);
            }
			
            $(".addGalleryItemLink").parent().hide();
            $(".addGalleryItemType").parent().hide();
            //$(".addGalleryItemShowInfo").parent().hide();
            //$(".addGalleryItemInfoPosition").parent().hide();
            $(".addGalleryItemJumpLink").val(idata.link);
            $('.addGalleryItemShowInfo').val(idata.show_info).prop('selected', true);
            $('.addGalleryItemInfoPosition').val(idata.info_position).prop('selected', true);
            $(".addGalleryItemInfoImg").val(idata.info_img);
            /*dodeli vrednost selektu */

            $("#sortnum").val(idata.sort);

            $(".addGalleryItem").hide();
            $(".saveGalleryItem").attr('galleryitemid', id).show();
            $(".addGalleryItemNewForm").show();


        });	
	});

    $("#toggleAddGallery").on("click", function(){
        $(".addNewGallery").slideToggle(function(){
            //clearNewDisplayForm();
        });
    });
    $("#galleryAddButton").on("click", function(){
        var ajax = false;

        var name = "";
        var position ="";
        var description = "";

        position =$( ".newGalleryPositionSelect option:selected" ).val();
        //alert(position);

        if($(".galleryNewName").val() != "" ){
            ajax = true;
            name = $(".galleryNewName").val();
        }

        if(ajax){
            $.ajax({
                type:"POST",
                url:"modules/"+moduleName+"/library/functions.php",
                data: ({action: "addnewgallery",
                    position: position,
                    name: name,
                    description: description
                }),
                error:function(XMLHttpRequest, textStatus, errorThrown){
                    alert("ERROR");
                },
                success:function(response){
                    if(response == 1){
                        $(".galleryNewName").val("");
                        $(".galleryNewDescription").val("");
                        $(".addNewGallery").slideToggle();
                        window.location.reload();
                    }
                    //var a = JSON.parse(response);
                }
            });
        }
    });
	
	
	
	$("#changeDesc").on('click',function(){
		saveAddChange();
		
    });

    $(".addGalleryItem").on("click", function () {
        if ($(".loadedgallery").attr("galleryid") != "") {
           /*	objecty to pass	*/
           var passdata = {
                action: "addgalleryitem",
                id: $(".content-wrapper").attr("currentid"),
                type: $(".addGalleryItemType").val(),
                link: $(".addGalleryItemLink").val(),
                jumplink: $(".addGalleryItemJumpLink").val(),
				values : []
            }
			
			$(".newGalleryItemDescCont").each(function(){
				passdata['values'].push({
					defaultlang : $(this).attr('defaultlang'),
					langid : $(this).attr('langid'),
					title : $(this).find('.newGalleryItemTitle').val(),
					desc : $(this).find('.newGalleryItemDesc').val()
				});
			});
			
            $.ajax({
                type: "POST",
                url: "modules/" + moduleName + "/library/functions.php",
                data: (passdata),
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("ERROR");
                },
                success: function (response) {

                    if ($(".addGalleryItemType").val() == "img") {
                        var elemdiv = $(document.createElement("div")).addClass("galleryItemCont");
                        var elema = $(document.createElement("a")).attr("href", "../" + $(".addGalleryItemLink").val());
                        var elemimg = $(document.createElement("img")).attr("src", "../" + $(".addGalleryItemLink").val()).attr("height", "100").appendTo(elema);
                        $(elema).appendTo(elemdiv);

                        var eleminput = $(document.createElement("input")).attr("type", "button").addClass("btn").addClass("btn-danger").addClass("galleryItemButton").val("X").appendTo(elemdiv);

                        /* gallery item detail button	*/
                        add_detail_button($(elemdiv), response);

                        $("#links").append(elemdiv);
                    }


					if ($(".addGalleryItemType").val() == "vid") {
						var elemdiv = $(document.createElement("div")).addClass("galleryItemCont");
                        var elemvideo = $(document.createElement("video")).css("width",'250px').css("height",'150px').attr('controls', true);
                        var elemsource = $(document.createElement("source")).attr("src", "../" + $(".addGalleryItemLink").val());
                        $(elemsource).appendTo(elemvideo);
						$(elemvideo).appendTo(elemdiv);

                        var eleminput = $(document.createElement("input")).attr("type", "button").addClass("btn").addClass("btn-danger").addClass("galleryItemButton").val("X").appendTo(elemdiv);

                        /* gallery item detail button	*/
                        add_detail_button($(elemdiv), response);

                        $("#links").append(elemvideo);
                    }

                    if ($(".addGalleryItemType").val() == "yt") {
                        var elemdiv = $(document.createElement("div")).addClass("galleryItemCont");
                        var elemframe = $(document.createElement("iframe")).attr("src", $(".addGalleryItemLink").val()).attr("height", "150").attr("width", "250").attr('frameborder', '0').appendTo(elemdiv);

                        var eleminput = $(document.createElement("input")).attr("type", "button").addClass("btn").addClass("btn-danger").addClass("galleryItemButton").addClass('topPosition').val("X").attr('itemid', response).on("click", function (e) {
                            e.stopImmediatePropagation();
                            var t = $(this);
                            $.ajax({
	                            method: "POST",
                                url: "modules/" + moduleName + "/library/functions.php",
                                data: {action: "deletegalleryitem", id : $(this).attr('itemid')}
                            }).done(function (result) {
                                if (result == '1') {
                                    $(t).parent().remove();
                                }
                            });
                        }).appendTo(elemdiv);

                        /* gallery item detail button	*/
                        add_detail_button($(elemdiv), response);
                        $("#links").append(elemdiv);
                    }
                    $(".addGalleryItemLink").val("");
                    window.location.reload();
                }
				

            });
        }
    });

    $("#example1").DataTable({
        stateSave: true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: "modules/" + moduleName + "/library/getdata.php", // json datasource
            type: "post",  // method  , by default get
            error: function () {  // error handling
                $(".employee-grid-error").html("");
                $("#example1").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                $("#employee-grid_processing").css("display", "none");
            },
            dataSrc: function (d) {
                //console.log(d);

                for (var i = 0; i < d.aaData.length; i++) {
                    var bc = '<button class="btn btn-primary changeViewButton" id="' + d.aaData[i][99] + '">Izmeni</button> ';
                    var bd = "";
                    if ($(".userpriv").data("delete") == 1 || $("body").attr("user") == "admin") {
						bd = '';
						if(d.aaData[i][7] == 1){
                        	bd = '<button class="btn btn-danger deleteButton" id="' + d.aaData[i][99] + '">Obriši</button> ';
						}
                    }
                    					
					if (d.aaData[i][7] == 1) {
						var s = '<input type="number" min="0" class="sortinput " value="'+d.aaData[i][6]+'" id="' + d.aaData[i][99] + '" style="width:60px;" />';
						d.aaData[i][7] = s;
					}else{
						d.aaData[i][7] = '';
					}
					
					d.aaData[i][8] = bc + bd;

                    if ($("body").attr("user") == "admin") {
                        var sel = '<select class="form-control selectStatus background-' + d.aaData[i][5] + '" id="' + d.aaData[i][99] + '" currentStatus="' + d.aaData[i][5] + '">';
                        sel += '<option value="v" ';
                        if (d.aaData[i][5] == "v") sel += " selected ";
                        sel += '>Vidljiva</option>';
                        sel += '<option value="h" ';
                        if (d.aaData[i][5] == "h") sel += " selected ";
                        sel += '>Sakrivena</option>';
                        sel += '<option value="a" ';
                        if (d.aaData[i][5] == "a") sel += " selected ";
                        sel += '>Arhivirano</option>';
                        sel += '</select>';
                        d.aaData[i][6] = sel;
                    } else {
                        d.aaData[i][6] = "";
                    }
                    d.aaData[i][5] = d.aaData[i][9];
                }
                return d.aaData;
            }
        },
        "language": {
            "emptyTable": "Nema podataka za prikaz",
            "info": "Prikaz _START_ do _END_ od _TOTAL_ galerija",
            "infoEmpty": "Prikaz 0 do 0 od 0 galerija",
            "infoFiltered": "(filtrirano od _MAX_ galerija)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Prikaži _MENU_ galerija",
            "loadingRecords": "Učitavanje...",
            "processing": "Obrada...",
            "search": "Pretraga:",
            "zeroRecords": "Nema rezultata za zadati kriterijum",
            "paginate": {
                "first": "Prva",
                "last": "Poslednja",
                "next": "Sledeća",
                "previous": "Predhodna"
            }
        }
    });

    $('#example1 tbody').on('click', '.deleteButton', function () {
        var $this = $(this);
        var a = confirm("Da li ste sigurni da zelite da obisete galeriju?");
        if (a) {
            $.ajax({
                method: "POST",
                url: "modules/" + moduleName + "/library/functions.php",
                data: {action: "delete", id: $this.attr("id")}
            }).done(function (result) {
                alert("Uspesno obrisano!");
                document.location.reload();
            });
        }

    }).on('click', '.changeViewButton', function () {
		window.location.href = window.location.pathname+'/change/'+$(this).attr('id');
    }).on('change', '.selectStatus', function () {
        showLoadingIcon();
        $this = $(this);
        
        if ($(this).attr("currentStatus") != $(this).val()) {
            $.ajax({
                method: "POST",
                url: "modules/gallery/library/functions.php",
                data: {action: "changestatus", id: $this.attr("id"), status: $(this).val()}
            }).done(function (result) {
                $this.removeClass("background-" + $this.attr("currentStatus")).addClass("background-" + $this.val()).attr("currentStatus", $this.val());
                alert("Uspesno izmenjeno");
                hideLoadingIcon();
            });

        }
    }).on('change', '.sortinput', function () {
        showLoadingIcon();
        $this = $(this);
		$.ajax({
			method: "POST",
			url: "modules/gallery/library/functions.php",
			data: {action: "updategallerysort", 
				id: $($this).attr("id"), 
				value: $($this).val()}
		}).done(function (result) {
			$this.removeClass("background-" + $this.attr("currentStatus")).addClass("background-" + $this.val()).attr("currentStatus", $this.val());
			alert("Uspesno izmenjeno");
			hideLoadingIcon();
		});

       
    });

    $("#addNewGalleryButton").on("click", function () {
        if ($(".newGallery_lat").val() != "" || $(".newGallery_cir").val() != "" || $(".newGallery_eng").val() != "") {
            /*	objecty to pass	*/
            var passdata = {
                action: "addgallery",
                position: $(".addNewGallerySelect").val()
            };

            for (var i = 0; i < lang.length; i++) {
                passdata['name' + lang[i][0]] = $(".newGallery_" + lang[i][0]).val();
                passdata['desc' + lang[i][0]] = $(".newGalleryDesc_" + lang[i][0]).val();
            }

            $.ajax({
                method: "POST",
                url: "modules/gallery/library/functions.php",
                data: passdata
            }).done(function (result) {
                document.location.reload();
            });
        }
        else {
            alert("Unesite naziv galerije.");
        }
    })

    $("#addButton").on("click", function(){
		window.location.href = window.location.pathname+'/add';
	});
	
	$("#listButton").on("click", function(){
		window.location.href = 'gallery';
	});

    $(".addGalleryItemNewForm").on("click", function () {
        clearadditemform();
        $(".saveGalleryItem").hide();
        $(".addGalleryItem").show();
        $(this).hide();
    });

    $(".saveGalleryItem").on("click", function () {
        /*	objecty to pass	*/
        var passdata = {
            action: "savegalleryitemdetail",
            itemid: $(this).attr("galleryitemid"),
            jumplink: $(".addGalleryItemJumpLink").val(),
            show_info: $(".addGalleryItemShowInfo option:selected").val(),
            info_position: $(".addGalleryItemInfoPosition option:selected").val(),
            info_img: $(".addGalleryItemInfoImg").val(),
            sort: $("#sortnum").val(),
			lang: []
        };
		
		$(".newGalleryItemDescCont").each(function(){
			var obj = {'langid': $(this).attr('langid'),
						'default' : $(this).attr('defaultlang'),
						'title' : $(this).find(".newGalleryItemTitle").val(),
						'desc' : $(this).find(".newGalleryItemDesc").val(),
						};	
			passdata['lang'].push(obj);	
		});
		
        $.ajax({
            method: "POST",
            url: "modules/gallery/library/functions.php",
            data: passdata,
            dataType: 'text'
        }).done(function (result) {

            if (result == '1') {

                alert("Uspesno snimljeno!");
                window.location.reload();
            } else {
                alert("Neuspesno snimljeno!");

            }
        });
    });
	
	$(document).on('click', '.galleryItemButton', function(e){
		e.stopImmediatePropagation();
		var t = $(this);
		$.ajax({
			method: "POST",
			url: "modules/" + moduleName + "/library/functions.php",
			data: {action: "deletegalleryitem", id: $(this).attr('itemid')}
		}).done(function (result) {
			if (result == '1') {
				$(t).parent().remove();
			}
            alert("Uspesno obrisano!");
            window.location.reload();
		});
	});
	
	$('.addGalleryItemLink').on('change keyup', function(){
		if(($(this).val()).indexOf('www.youtube') >= 0){
			$('.addGalleryItemType').val('yt');
		}	
	});
	
	$( ".sortable" ).sortable({
		stop: function( event, ui ) {
			var data = [];
			$(".sortable").find(".galleryItemCont").each(function(){
				data.push($(this).find('.galleryItemButton').attr('itemid'))	
			});
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: "updateimagesort",
						items: data,
						galleryid: $('.content-wrapper').attr("currentid")
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
    $( ".sortable" ).disableSelection();
	
});