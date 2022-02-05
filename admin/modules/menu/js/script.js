function resetForm(){
	$(".langInputCont").html("");
	$(".linkTypeMenu").find("option").each(function(){
		$(this).removeAttr('selected');	
	});	
	$(".menuType").find("option").each(function(){
		$(this).removeAttr('selected');	
	});
	$(".menuLink").val('');
	$(".sortMenuNumber").val('');
	$(".meniDataCont").attr("id", '').attr('parentid', '');
}
function showLoadingIcon(){
	$(".loadingIcon").removeClass("hide");	
}
function hideLoadingIcon(){
	$(".loadingIcon").addClass("hide");	
}
$(document).ready(function (e) {
	
	/*	tree start	*/
	
	var handlerpath = "modules/" + moduleName + "/library/tree_handler.php";
    $(window).resize(function () {
        var h = Math.max($(window).height() - 0, 420);
        $('#container, #data,  #data .content').height(h).filter('.default').css('lineHeight', h + 'px');
    }).resize();
	
	 $('#tree')
        .jstree({
            'core': {
                'data': {
                    'url': handlerpath + '?operation=get_node',
                    'data': function (node) {
                        //console.log("---------");
                        //console.log(node);
                        return {'id': node.id};
                    },
                    'success': function (re) {
                        //console.log(re);
                    }
                },
                'check_callback': true,
                'force_text': false,
                'themes': {
                    'responsive': false,
                    'variant': 'small',
                    'stripes': true
                }
            },
            'contextmenu': {
                'items': function (node) {
                    

                    var tmp = $.jstree.defaults.contextmenu.items();
                    delete tmp.rename;
                    delete tmp.create;
                    delete tmp.ccp;




                    if (this.get_type(node) === "file") {
                        delete tmp.create;
                    }
                    //alert(JSON.stringify(tmp, null, 4));
                    tmp.remove.label="Obriši";
                    tmp.custom_entry = { 
                                            "separator_before": true,
                                            "separator_after": false,
                                            "label": "Kreiraj podmeni",
                                            "action": function (obj) {
                                                 //alert('test');   
                                               // tree.delete_node($node);
                                               var underMenuButton = document.getElementById("addMenusButton");
                                                underMenuButton.click();
                                                }
                                           
                                        };



                    //alert(JSON.stringify(tmp, null, 4));
                    return tmp;
                }
            },
            'sort': function (a, b) {
                return parseInt(this.get_node(a).original.sort) > parseInt(this.get_node(b).original.sort) ? 1 : -1;
            },
            'types': {
                'default': {'icon': 'folder'},
                'file': {'valid_children': [], 'icon': 'file'}
            },
            'unique': {
                'duplicate': function (name, counter) {
                    return name + ' ' + counter;
                }
            },
            'plugins': ['state', 'sort', 'types', 'contextmenu', 'unique', 'dnd']
        })
        .on('delete_node.jstree', function (e, data) {
            var a = confirm("Da li ste sigurni da zelite da obrisete stavku?");
            if (a) {
                $.get(handlerpath + '?operation=delete_node', {'id': data.node.id})
                    .done(function (d) {
                        data.instance.set_id(data.node, d.id);
                        clearMenuData();
                        $(".menuid").attr('parentid', "");
                        $(".menuid").attr('menuid', "");

                    })
                    .fail(function () {
                        data.instance.refresh();
                    });
            }
        })
        .on('create_node.jstree', function (e, data) {
            $.get(handlerpath + '?operation=create_node', {
                'type': data.node.type,
                'id': data.node.parent,
                'text': data.node.text
            })
                .done(function (d) {
                    data.instance.set_id(data.node, d.id);
                })
                .fail(function () {
                    data.instance.refresh();
                });
        })
        .on('rename_node.jstree', function (e, data) {
            $.get(handlerpath + '?operation=rename_node', {'id': data.node.id, 'text': data.text})
                .done(function (d) {
                    data.instance.set_id(data.node, d.id);
                })
                .fail(function () {
                    data.instance.refresh();
                });
        })
        .on('move_node.jstree', function (e, data) {
            $.get(handlerpath + '?operation=move_node',
                {
                    'id': data.node.id,
                    'parent': data.parent,
                    'position': data.position,
                    'oldparent': data.old_parent,
                    'oldposition': data.old_position
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
            $.get(handlerpath + '?operation=copy_node', {'id': data.original.id, 'parent': data.parent})
                .done(function (d) {
                    //data.instance.load_node(data.parent);
                    data.instance.refresh();
                })
                .fail(function () {
                    data.instance.refresh();
                });
        })
        .on('changed.jstree', function (e, data) {
            if (data && data.selected && data.selected.length && data.action == "select_node") {
                var id = data.selected.join(':');
                $.get(handlerpath + '?operation=get_content&id=' + id, function (d) {
                    if (d) {
                        console.log(d);
						
						resetForm();
						
						$(".meniDataCont").attr("id", d.id).attr('parentid', d.parentid);
						
						for(var i = 0; i < d.lang.length; i++)
						{
							var clone = $(".langInputTemplate").clone(true).removeClass('hide').removeClass('langInputTemplate').attr('id', d.lang[i].langid).attr("defaultlang", d.lang[i].default);
							$(clone).find('.langname').html(d.lang[i].name);
							$(clone).find('.langValue').val(d.lang[i].value);
							$(clone).appendTo($(".langInputCont"));
						}
						
						$(".statusMenu").val(d.status);
						$(".sortMenuNumber").val(d.sort);
						$(".linkTypeMenu").find("option[value='"+d.linktype+"']").attr('selected', 'selected');
						$(".menuType").val(d.menutype);
						$(".menuLink").val(d.link);
						$(".menuImageInput").val(d.image);
						
                        

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
		
		
		/*	tree end	*/
		
		$('.saveMenuData').on("click", function(){
			addSave();
		});
		
		$("#addMenusButton").on("click", function(){
			resetForm();
			$(".meniDataCont").attr("id", '').attr('parentid', $("#tree").jstree("get_selected"));
			$.ajax({
				type:"POST",
				url:"modules/"+moduleName+"/library/functions.php",
				data: ({action: 'getlanguageslist'}),
				error:function(XMLHttpRequest, textStatus, errorThrown){
				  alert("ERROR");                            
				},
				success:function(response){
					var a = JSON.parse(response);
					console.log(a);
					for(var i = 0; i < a.length; i++){
						var clone = $(".langInputTemplate").clone(true).removeClass('hide').removeClass('langInputTemplate').attr('id', a[i].id).attr("defaultlang", a[i].default);
						$(clone).find('.langname').html(a[i].name);
						$(clone).find('.langValue').val('');
						$(clone).appendTo($(".langInputCont"));	
					}
				}
			});
		});

});