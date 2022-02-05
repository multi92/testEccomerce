<?php $viewtype=''; if($currentview=='change'){ $viewtype='- Promena podataka'; } else if($currentview=='add'){ $viewtype='- Novi unos'; }; ?>
<div class="content-wrapper newsData" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
  <section class="content-header -breadcrumbColor" >
     <h1>
        <i class="fa fa-cogs"></i> Učitani atributi <?php echo $viewtype;?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
        <li><a href="city"><i class="fa fa-building-o"></i> Lista učitanih atributa</a></li>
        <li class="active"> Grad</li>
    </ol>

</section>

<!-- Main content -->
<section class="content">

 <i class="fa fa-refresh fa-spin fa-2x loadingIcon "></i>

 <div class="row">
   <div class="col-sm-12 verticalMargin10">
       <button class="btn btn-primary" id="listButton">Lista učitanih atributa</button>
   </div>
</div>

<div class="row addChangeCont hide">
   <div class="col-xs-12">
       <div class="box">
          <div class="box-body">
          <?php 
		  	$q = "SELECT * FROM attr_external WHERE id = ".$command[2];
			$res = mysqli_query($conn, $q);
			$row = mysqli_fetch_assoc($res);
		  
		  ?>
          <h2>Promena atributa - <?php echo $row['name']; ?></h2>
          <hr> 
           
          <table id="listtable_attrval" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Redni broj</th>
                    <th>Učitani vrednost atributa</th>
                    <th>Lokalna vrednost atributa</th>
                    
                    <th>Izmeni</th>
                </tr>
            </thead>
         </table>

     <br>                       
 </div>
</div><!-- /.box -->
</div><!-- /.col -->
</div>



</div>

</section>
<!-- /.content -->
</div>

