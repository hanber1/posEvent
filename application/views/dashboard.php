<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php if ($is_admin == true) { ?>

    <section class="content-header">
        <h1>
            Übersicht
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard/') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Übersicht</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->

        <!-- ./col -->
        <div class="col-lg-3 col-xs-5">
            <!-- small box -->
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3><?php echo $total_users; ?></h3>

                    <p>Anzahl Mitarbeiter</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <a href="<?php echo base_url('users/') ?>" class="small-box-footer">Mehr Info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3><?php echo $total_customer ?></h3>

                    <p>Anzahl Kunden</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="<?php echo base_url('customer/') ?>" class="small-box-footer">Mehr Info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->

        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?php echo $total_event ?></h3>

                    <p>Anzahl Feste</p>
                </div>
                <div class="icon">
                    <i class="fa fa-home"></i>
                </div>
                <a href="<?php echo base_url('event/') ?>" class="small-box-footer">Mehr Info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
</div>
<!-- /.row -->
<?php 
} else { ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Herzlich Willkommen bei der Festverrechnung!
        <small></small>
    </h1>
    <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard/') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Übersicht</li>
        </ol>
        <section class="content">
        <!-- Small boxes (Stat box) -->

        <!-- ./col -->
        <div class="col-lg-3 col-xs-5">
            <!-- small box -->
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3><?php echo $total_sum; ?></h3>

                    <p>Aktuelle Festtagsumme</p>
                </div>
                <div class="icon">
                    <i class="fa fa-money"></i>
                </div>
                <a href="#" class="small-box-footer">Mehr Info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?php echo $total_users ?></h3>

                    <p>Aktive Festmitarbeiter</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <a href="<?php echo base_url('eventuser/') ?>" class="small-box-footer">Mehr Info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>


        <!-- ./col -->
</div>

</section>

<?php 
} ?>


</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
    $(document).ready(function() {
        $("#dashboardMainMenu").addClass('active');
    });
</script> 