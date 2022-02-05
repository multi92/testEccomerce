jQuery.fn.selectText = function(){
    var doc = document
        , element = this[0]
        , range, selection
    ;
    if (doc.body.createTextRange) {
        range = document.body.createTextRange();
        range.moveToElementText(element);
        range.select();
    } else if (window.getSelection) {
        selection = window.getSelection();        
        range = document.createRange();
        range.selectNodeContents(element);
        selection.removeAllRanges();
        selection.addRange(range);
    }
};
function insideObject(obj){
	var out = '';
    for (var i in obj) {
        out += i + ": " + obj[i] + "\n";
    }
	alert(out);	
}
function fileuploadform(path){
	//alert("start - " + path);
	$('#fileupload').fileupload({url: path}).bind('fileuploadadd', function (e, data) {
			//alert("inside");
			data.url = 'modules/files/library/index.php?path='+path;
		});
	
	$("tbody.files").html("");
	$('#fileupload').addClass('fileupload-processing');
	//alert($('#fileupload').fileupload('option', 'url'));
	//insideObject($('#fileupload')[0]);
	//alert($('#fileupload')[0]);
	
	$.ajax({	
		url: 'modules/files/library/index.php?path='+path,
		dataType: 'json',
		context: $('#fileupload')[0], 
		error: function(){alert("error 112");}
	}).always(function () {
		$(this).removeClass('fileupload-processing');
	}).done(function (result) {
		console.log(result);
		//insideObject(result.files[0]);
		//alert($(this).fileupload('option', 'done'));
		$(this).fileupload('option', 'done').call(this, $.Event('done'), {result: result});
		$(this).fileupload({url: path});
		
		/*	delete file	*/
		
		$('#fileupload').find(".delete").each(function(){	
			$(this).on('click', function (e) {
				var $link = $(this);	
				$.ajax({
					dataType: 'json',
					url: $link.data('url')+"&path="+path,
					type: 'DELETE',
					success: function(){
						$link.parents('.template-download').remove();
					},
					error: function(){
						alert("error");
					}
				});	
			});	
		});
		
		/*	add visible url	*/
		$('tbody.files').find("tr").each(function(){
			var str = $(this).find("p.name").children("a").prop("href");
			var arrstr = str.split("/");
			var outstr = "";
			var add = false;
			for(var i = 0; i < arrstr.length; i++)
			{
				if(arrstr[i] == "fajlovi"){
					add = true;
				}
				if(add){
					outstr += arrstr[i]+"/";	
				}
			}
			outstr = outstr.substring(0, outstr.length-1);
			var td = $(document.createElement("td")).css("color", "black").html(outstr ).click(function(){
				$(this).selectText();
			});
			
			$(td).insertBefore($(this).children("td").last());
		});
		
	});	

}

function testing(){
	return "custom text data";
}
$(document).ready(function(e) {
	// jstree start
	var handlerpath = "modules/files/library/tree_handler.php";
	$(window).resize(function () {
		var h = Math.max($(window).height() - 0, 420);
		$('#container, #data, #tree, #data .content').height(h).filter('.default').css('lineHeight', h + 'px');
	}).resize();
	$('#tree')
		.jstree({
			'core' : {
				'data' : {
					'url' : handlerpath+'?operation=get_node',
					'data' : function (node) {
						//console.log(node);
						return { 'id' : node.id };
					}
				},
				'check_callback' : function(o, n, p, i, m) {
					if(m && m.dnd && m.pos !== 'i') { return false; }
					if(o === "move_node" || o === "copy_node") {
						if(this.get_node(n).parent === this.get_node(p).id) { return false; }
					}
					return true;
				},
				'force_text' : true,
				'themes' : {
					'responsive' : false,
					'variant' : 'small',
					'stripes' : true
				}
			},
			'sort' : function(a, b) {
				return this.get_type(a) === this.get_type(b) ? (this.get_text(a) > this.get_text(b) ? 1 : -1) : (this.get_type(a) >= this.get_type(b) ? 1 : -1);
			},
			'contextmenu' : {
				'items' : function(node) {
					var tmp = $.jstree.defaults.contextmenu.items();
					delete tmp.create.action;
					if(node.id == "banners" || 
					   node.id == "brands" || 
					   node.id == "catalogs" || 
					   node.id == "documents" || 
					   node.id == "gallery"|| 
					   node.id == "icons"|| 
					   node.id == "news"|| 
					   node.id == "persons"|| 
					   node.id == "sliders"|| 
					   node.id == "socialnetworks" || 
					   node.id == "sitedata" ||
					   node.id == "product" 
					   )
					{
						tmp.rename._disabled = true;
						tmp.remove._disabled = true;	
						tmp.ccp._disabled = true;
					}
					tmp.rename.label="Preimenuj";
					tmp.remove.label="Obriši";
					tmp.create.label = "Novi";
					tmp.create.submenu = {
						"create_folder" : {
							"separator_after"	: true,
							"label"				: "Folder",
							"action"			: function (data) {
								var inst = $.jstree.reference(data.reference),
									obj = inst.get_node(data.reference);
								inst.create_node(obj, { type : "default" }, "last", function (new_node) {
									setTimeout(function () { inst.edit(new_node); },0);
								});
							}
						}
					};
					if(this.get_type(node) === "file") {
						delete tmp.create;
					}
					return tmp;
				}
			},
			"ui" : {
				"initially_select" : [ "dokumenta" ]
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
			'plugins' : ['state','sort','types','contextmenu','unique']
		})
		.on('delete_node.jstree', function (e, data) {
			$.get(handlerpath+'?operation=delete_node', { 'id' : data.node.id })
				.fail(function () {
					data.instance.refresh();
				});
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
			$.get(handlerpath+'?operation=move_node', { 'id' : data.node.id, 'parent' : data.parent })
				.done(function (d) {
					//data.instance.load_node(data.parent);
					data.instance.refresh();
				})
				.fail(function () {
					data.instance.refresh();
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
			//alert(data.selected);
			if(data && data.selected && data.selected.length) {	
				//alert("in --- "+data.selected.join(':'));	
				$.get(handlerpath+'?operation=get_content&id=' + data.selected.join(':'), function (d) {
					if(d && typeof d.type !== 'undefined') {
						//alert(data.selected);
						$('.folderPath').text(data.selected);
						$('.folderPathEncoded').text("fajlovi/"+encodeURI(data.selected));
						var str = data.selected+"/";
						fileuploadform(str);
					}
				});
				
			}
			
		}).on('ready.jstree', function (e, data) {
			 // data.instance.select_node(["dokumenta"]);
		});
		
		$('.folderPathEncoded').on('click', function(){
			$(this).selectText();
		});
		
});

