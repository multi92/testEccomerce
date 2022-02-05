<div class="content-wrapper" currentview='home'>
	<section class="content-header -breadcrumbColor">
		<h1>
			<i class="fa fa-files-o"></i> Fajlovi
		</h1>
		<ol class="breadcrumb">
			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
			<li class="active"><i class="fa fa-files-o"></i> Fajlovi</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">

		<i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i>
		
      	<div class="row">
        	<div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-body">
                        <h2 class="box-title">Fajlovi</h2>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="tree"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        	<div class="col-md-9" style="overflow-x: scroll;">
                <div class="box box-primary">
                    <div class="box-body">
                        <h3 class="box-title folderPath"></h3>
						<p class="folderPathEncoded" style="line-height:15px;"></p>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                               
                            




            	<div id="data">
				<div class="content code" style="display:none;"><textarea id="code" readonly></textarea></div>
				<div class="content folder" style="display:none;"></div>
				<div class="content image" style="display:none; position:relative;"><img src="" alt="" style="display:block; position:absolute; left:50%; top:50%; padding:0; max-height:90%; max-width:90%;" /></div>
				<div class="content default" style="text-align:center;">
                	<!---  jquery upload plugin start -->
                    
                    <form id="fileupload" action="" method="POST" enctype="multipart/form-data">
                        <div class="fileupload-buttonbar">
                            <div class="fileupload-buttons">
                                <span class="fileinput-button">
                                    <span>Dodaj fajlove...</span>
                                    <input type="file" name="files[]" />
                                </span>
                                <button type="submit" class="start">Start upload</button>
                                <button type="reset" class="cancel">Otkaži upload</button>
                                <span class="fileupload-process"></span>
                            </div>
                            <div class="fileupload-progress fade" style="display:none">
                                <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="progress-extended">&nbsp;</div>
                            </div>
                        </div>
                        <table role="presentation" class="table table-bordered ">
                        	<thead class="filesHeader">
                            	<th>Prikaz</th>
                                <th>Naziv</th>
                                <th>Veličina</th>
                                <th>Link</th>
                                <th></th>
                            </thead>
                            <tbody class="files"></tbody>
                        </table>
                    </form>
                    <br>
                    
                    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
                        <div class="slides"></div>
                        <h3 class="title"></h3>
                        <a class="prev">‹</a>
                        <a class="next">›</a>
                        <a class="close">×</a>
                        <a class="play-pause"></a>
                        <ol class="indicator"></ol>
                    </div>
                    <!-- The template to display files available for upload -->
                    <script id="template-upload" type="text/x-tmpl">
                    {% for (var i=0, file; file=o.files[i]; i++) { %}
                        <tr class="template-upload">
                            <td>
                                <span class="preview"></span>
                            </td>
                            <td>
                                <p class="name">{%=file.name%}</p>
                                <strong class="error"></strong>
                            </td>
                            <td>
                                <p class="size">Processing...</p>
                                <div class="progress"></div>
                            </td>
                            <td>
                                {% if (!i && !o.options.autoUpload) { %}
                                    <button class="start" disabled>Start</button>
                                {% } %}
                                {% if (!i) { %}
                                    <button class="cancel">Cancel</button>
                                {% } %}
                            </td>
                        </tr>
                    {% } %}
                    </script>
                    <!-- The template to display files available for download -->
                    <script id="template-download" type="text/x-tmpl">
                    {% for (var i=0, file; file=o.files[i]; i++) { %}
                        <tr class="template-download ">
                            <td>
                                <span class="preview">
                                    {% if (file.thumbUrl) { %}
                                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbUrl%}"></a>
                                    {% } %}
                                </span>
                            </td>
                            <td>
                                <p class="name">
                                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbUrl?'data-gallery':''%}>{%=file.name%}</a>
                                </p>
                                {% if (file.error) { %}
                                    <div><span class="error">Error</span> {%=file.error%}</div>
                                {% } %}
                            </td>
                            <td>
                                <span class="size">{%=o.formatFileSize(file.size)%}</span>
                            </td>
                            <td>
                                <button class="delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}></button>
                               <!-- <input type="checkbox" name="delete" value="1" class="toggle"> -->
                            </td>
                        </tr>
                    {% } %}
                    </script>
                    
                	<!---  jquery upload plugin end -->
                </div>
			</div>



</div>
                        </div>
                    </div>
                </div>






            </div>        	
        </div>
        
	</section>
	<!-- /.content -->
</div>
