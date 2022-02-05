<?php $viewtype=''; if($currentview=='change'){ $viewtype='- Promena podataka'; } else if($currentview=='add'){ $viewtype='- Novi unos'; }; ?>
<div class="content-wrapper newsData" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
  <section class="content-header -breadcrumbColor" >
     <h1>
        <i class="fa fa-building-o"></i> Gradovi <?php echo $viewtype;?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
        <li><a href="city"><i class="fa fa-building-o"></i> Lista gradova</a></li>
        <li class="active"> Grad</li>
    </ol>

</section>

<!-- Main content -->
<section class="content">

 <i class="fa fa-refresh fa-spin fa-2x loadingIcon "></i>

 <div class="row">
   <div class="col-sm-12 verticalMargin10">
       <button class="btn btn-primary" id="listButton">Lista gradova</button>
   </div>
</div>

<div class="row addChangeCont hide">
   <div class="col-xs-12">
       <div class="box">
          <div class="box-header"></div>
          <div class="box-body">
            <h2>Opšte informacije</h2>
            <hr> 
           <div class="row addChangeLangCont">

           </div> 
           <div class="row">
             <div class="col-sm-6">
                <div class="form-group">
                   <div class="input-group">
                      <label class="input-group-btn">
                         <span class="btn btn-default">Lokacija</span>
                     </label>
                     <input type="text" class="form-control citycoordinates" id="location" name="location" readonly="">
                 </div>
             </div>
             <div id="map-canvas" style="width:100%; height: 400px;margin-top: 30px;"></div>
         </div>
     </div>



     <br>
     <a class="btn btn-primary saveAddChange">Snimi</a>                       
 </div>
</div><!-- /.box -->
</div><!-- /.col -->
</div>



</div>

</section>
<!-- /.content -->
</div>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeSRCR9d2uNS0tnuSIUFE-BRnWKI7B5VE&sensor=false&libraries=geometry,places&ext=.js" type="text/javascript"></script>

<script>
    var map;
    var markers = [];
    
    function initialize() {
        var myLatlng = new google.maps.LatLng(43.3185214, 21.9119148);

        var myOptions = {
           zoom: 8,
           center: myLatlng,
           mapTypeId: google.maps.MapTypeId.ROADMAP
       }
       map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);

       google.maps.event.addListener(map, 'click', function(event) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(null);
      }
      $(".citycoordinates").val(event.latLng);

      var marker = new google.maps.Marker({
       draggable: true,
       position: event.latLng,
       map: map,
       title: "Grad"
   });
      markers.push(marker);
            //alert(event.latLng);
            
        });

       google.maps.event.addListenerOnce(map, 'idle', function(){
        $(".loading").addClass('hide');
        $("#form_komunalac").css('height', 'auto');
    });
   }

   google.maps.event.addDomListener(window, 'load', initialize);

   function addMarker(cords) {

      setTimeout(function(){

         var contentString = '';
         var infowindow = new google.maps.InfoWindow({
            content: contentString
        });
         cords = cords.split(',');
			//alert(cords);
			var marker = new google.maps.Marker({
				draggable: true,
				position: new google.maps.LatLng(cords[0], cords[1]),
				map: map
			});
			markers.push(marker);
			google.maps.event.addListener(marker, 'click', function() {
				infowindow.open(map,marker);
			});
		}, 100);
  }

</script>