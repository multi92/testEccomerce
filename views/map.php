<?php if(strlen($system_conf["map_external_link"][1])>0 && strlen($system_conf["map_latitude"][1])>0 && strlen($system_conf["map_longitude"][1])>0 && strlen($system_conf["pointer_latitude"][1])>0 && strlen($system_conf["pointer_longitude"][1])>0 ) { ?>
<div class="container hide">
    <div class="row marginBottom30">
        <div class="col-md-12">
            <div class="select-holder-mi">
                <h4><?php echo $language["kontakt"][16]; //Pronadji radnju ?></h4>
                <select name="select-map" id="cms_select_map">
                <?php $i=0; ?>
                <?php foreach($shops as $sval){ ?>
                <option value="<?php echo $sval->coordinate; ?>" 
                        sortid="<?php echo $i; ?>"
                        shoplogo="<?php echo $user_conf["sitelogo"][1]; ?>" 
                        shopname="<?php echo str_replace('"', '', $sval->name); ?>"
                        shopaddress="<?php echo str_replace('"', '', str_replace('"', '', $sval->address.", ".$sval->cityname)); ?>" 
                        shopphone="<?php echo str_replace('"', '', $sval->phone." ".$sval->cellphone); ?>"

                        shopemail="<?php echo str_replace('"', '', $sval->email); ?>"
                        sortid="<?php echo $i; ?>"
                        ><?php echo $sval->name; ?></option>
                <?php $i++;} ?>
                </select> 
            </div>
        </div>
    </div>
</div>

<div id="map">
 
</div>

<script src="<?php echo $system_conf["map_external_link"][1];?>"></script>
<script>
var map;
var markers = [];
var infowindows = [];
function initialize() {

    //var map_cord1 = new google.maps.LatLng(<?php echo $system_conf["pointer_latitude"][1];?>, <?php echo $system_conf["pointer_longitude"][1];?>);
	<?php $i=0; foreach($shops as $sval){ $i++; 
			echo "var map_cord".$i." = new google.maps.LatLng(".$sval->coordinate.");";
	 } ?>
    var mapCanvas = document.getElementById('map');
    var mapOptions = {
        center: new google.maps.LatLng(<?php echo $system_conf["map_latitude"][1];?>, <?php echo $system_conf["map_longitude"][1];?>),
        zoom: 18,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: false,
        styles: [
    {
        "featureType": "all",
        "stylers": [
            {
                "saturation": 0
            },
            {
                "hue": "#e7ecf0"
            }
        ]
    },
    {
        "featureType": "road",
        "stylers": [
            {
                "saturation": -70
            }
        ]
    },
    {
        "featureType": "transit",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "poi",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "water",
        "stylers": [
            {
                "visibility": "simplified"
            },
            {
                "saturation": -60
            }
        ]
    }
]

    }
     map = new google.maps.Map(mapCanvas, mapOptions);
	<?php $i=0; foreach($shops as $sval){ $i++;?>
    var contentString<?php echo $i;?> = '<div id="content">' +
        '<b><?php  echo $sval->name ;?></b> <br> ' +
		'<b><?php echo $sval->address.", ".$sval->cityname; ?>, Srbija</b> <br> ' +
		'<b><?php echo $sval->phone." ".$sval->cellphone; ?></b> <br> ' +
		'<b><?php echo $sval->email; ?></b> <br> ' +
        '</div>';

    var infowindow<?php echo $i;?> = new google.maps.InfoWindow({
        content: contentString<?php echo $i;?>
    });

    var marker<?php echo $i;?> = new google.maps.Marker({
        position: map_cord<?php echo $i;?>,
        map: map,
        title: '<?php  echo $sval->name ;?>'
    });
    markers.push(marker<?php echo $i;?>);
    
    marker<?php echo $i;?>.addListener('click', function() {
        //hideAllInfoWindows(map);
        infowindow<?php echo $i;?>.open(map, marker<?php echo $i;?>);
    });
    infowindows.push(infowindow<?php echo $i;?>);
	<?php } ?>
    // google.maps.event.trigger(markers[0], 'click');
}
/*function hideAllInfoWindows(mapa) {
   markers.forEach(function(markerr) {
     marker.infowindow.close(mapa, markerr);
  }); 
}*/
google.maps.event.addDomListener(window, 'load', initialize);

</script>
<?php } ?>