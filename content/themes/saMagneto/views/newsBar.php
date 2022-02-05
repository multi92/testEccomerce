<div id="news-bar">
    <marquee direction="left" scrollamount="5" behavior="scroll" onmouseover="this.stop()" onmouseout="this.start()">
	<?php //foreach($trackbarnews[1] AS $k=>$tval) { ?>
        <!--<a href="<?php //echo $tval->category[0]['name'];?>/<?php //echo $tval->id;?>"><?php //echo $tval->title;?></a>
        <span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>-->
	<?php //} ?>
	<?php foreach($shops AS $k=>$sval) { ?>
        <a><?php echo $sval->name." ".$language["kontakt"][4].": ".$sval->address." ".$sval->cityname." ".$language["kontakt"][5].": ".$sval->phone;?> </a>
        <span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	<?php } ?>
    </marquee>     
</div>  