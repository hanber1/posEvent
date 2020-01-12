<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Benutzerprofil
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard/') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Benutzerdaten</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-4 col-xs-8">
                <?php if (in_array('updateProfile', $user_permission)) : ?>
                <a href="<?php echo base_url('users/setting') ?>" class="btn btn-primary">Benutzerdaten bearbeiten</a>
                <br /> <br />
                <?php endif; ?>

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Benutzerprofil</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered table-condensed table-hovered">
                            <tr>
                                <th>Name</th>
                                <td><?php echo $user_data['vorname'] . " " . $user_data['name']; ?></td>
                            </tr>
                            <tr>
                                <th>E-Mail Adresse</th>
                                <td><?php echo $user_data['email']; ?></td>
                            </tr>
                            <tr>
                                <th>Telefon</th>
                                <td><?php echo $user_data['telefon']; ?></td>
                            </tr>
                            <tr>
                                <th>Geburtsdatum</th>
                                <td><?php echo $user_data['geburtsdatum']; ?></td>
                            </tr>
                            <tr>
                                <th>Benutzergruppe</th>
                                <td><span class="label label-info"><?php echo $user_group['bezeichnung']; ?></span></td>
                            </tr>
                            <tr>
                                <th>Geschlecht</th>
                                <td><?php echo ($user_data['geschlecht'] == 1) ? 'Männlich' : 'Weiblich'; ?></td>
                            </tr>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- col-md-12 -->
        </div>
        <!-- /.row -->


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
    $(document).ready(function() {
        $("#profileMainNav").addClass('active');
    });
</script> 