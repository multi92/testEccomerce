<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header -breadcrumbColor">
        <h1>
            <i class="fa fa-picture-o"></i> Podešavanja
        </h1>
        <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> Početna</a></li>
            <li><a href="gallery"><i class="fa fa-picture-o"></i> Galerije</a></li>
            <li class="active"><i class="fa fa-cog"></i> Podešavanja</li>
            <i class="fa fa-picture-o"></i> Podešavanja
        </ol>

    </section>

   <!-- Main content -->
    <section class="content">
        
       


        <i class="fa fa-refresh fa-spin fa-2x loadingIcon hide"></i>
        
    
        <div class="row listCont">

            <div class="col-xs-12">
                <!-- /.box -->
                 <?php if ($command[1] == 'config' || $_SESSION['user_type'] == "admin") : ?>
               <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Podešavanja modula</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                       <!-- KONFIGURACIJA MODULA -->
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <?php endif; ?>
            <!-- /.col -->
        </div>

       <!-- Your Page Content Here -->

    </section>
    <!-- /.content -->
</div><!-- /.content-wrapper -->



