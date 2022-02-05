<?php $viewtype=''; if($currentview=='change'){ $viewtype='- Promena podataka'; } else if($currentview=='add'){ $viewtype='- Novi unos'; }; ?>
<div class="content-wrapper newsData" currentview='<?php echo $currentview; ?>' currentid="<?php echo $command[2]; ?>">
 	<section class="content-header -breadcrumbColor">
 		<h1>
 			<i class="fa fa-bookmark"></i> Extra detalj <?php echo $viewtype;?>
 		</h1>
 		<ol class="breadcrumb">
 			<li><a href="dashboard"><i class="fa fa-dashboard"></i> Pocetna</a></li>
 			<li><a href="extradetail"><i class="fa fa-bookmark"></i> Lista extra detalja</a></li>
 			<li class="active"> Extra detalj <?php echo $viewtype;?></li>
 		</ol>
 	</section>
 	<!-- Main content -->
 	<section class="content">
 
 		<i class="fa fa-refresh fa-spin fa-2x loadingIcon "></i>
 		
         <div class="row">
             <div class="col-sm-12 verticalMargin10">
                 <button class="btn btn-primary" id="listButton">Lista extra detalja</button>
             </div>
         </div>
         
         <div class="row addChangeCont hide">
             <div class="col-xs-12">
 				<div class="box">
 					<div class="box-header"></div>
                     <div class="box-body">
                     	<div class="row addChangeLangCont">
                         	
                         </div>
					 	
                        <div class="form-group">
                            <label>Sort</label>
                            <input type="number" class="form-control extradetailSortInput" />
                        </div>
                        <div class="form-group showInWelcomepageExtraDetailCont ">
                        <label>Prikaži na početnoj</label>
                        <select class="form-control showInWelcomepageExtraDetail">
                                <option value="y">Da</option>
                                <option value="n">Ne</option>
                        </select>
                        </div>
                        <div class="form-group showInWebShopExtraDetailCont ">
                            <label>Prikaži u webshop-u</label>
                            <select class="form-control showInWebShopExtraDetail">
                                    <option value="y">Da</option>
                                    <option value="n">Ne</option>
                            </select>
                        </div>
                        <div class="form-group banerExtraDetailCont ">
                        <label>Baner</label>
                        <select class="form-control banerExtraDetail">
                                <option value="0">---</option>
                                <?php
                            $query = "SELECT * FROM banner";
                            $re = mysqli_query($conn, $query);
                            while($arow = mysqli_fetch_assoc($re))
                            {?>
                                <option value="<?php echo $arow['id']; ?>"><?php echo $arow['name']; ?></option>
                            <?php }
                        ?>
                        </select>
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
 
 