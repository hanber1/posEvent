<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Mitarbeiter hinzufügen
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard/') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('users/') ?>">Mitarbeiter</a></li>
            <li class="active">hinzufügen</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12 col-xs-12">

                <?php if ($this->session->flashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php elseif ($this->session->flashdata('error')) : ?>
                    <div class="alert alert-error alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Mitarbeiter hinzufügen</h3>
                    </div>
                    <form role="form" action="<?php base_url('users/create') ?>" method="post">
                        <div class="box-body">

                            <?php echo validation_errors(); ?>

                            <div class="form-group">
                                <label for="firstname">Vorname</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Vorname" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="lastname">Nachname *</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Nachname" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="email">E-Mail *</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="E-Mail" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="groups">Benutzergruppe *</label>
                                <select class="form-control" id="groups" name="groups">
                                    <option value="">Benutzergruppe wählen</option>
                                    <?php foreach ($group_data as $k => $v) : ?>
                                        <option value="<?php echo $v['id'] ?>"><?php echo $v['bezeichnung'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="birthday">Geburtsdatum</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="birthday" name="birthday" placeholder="Datum eintragen" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone">Telefon</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Telefonnummer" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="gender">Geschlecht</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="gender" id="male" value="1">
                                        Männlich
                                    </label>
                                    <label>
                                        <input type="radio" name="gender" id="female" value="2">
                                        Weiblich
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="1">Aktiv</option>
                                    <option value="2">Inaktiv</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="password">Passwort [mindestens 4 Zeichen]*</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Passwort" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="cpassword">Passwort wiederholen *</label>
                                <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Passwort wiederholen" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <p>* notwendige Felder</label>
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Speichern</button>
                            <a href="<?php echo base_url('users/') ?>" class="btn btn-warning">Zurück</a>
                        </div>
                    </form>
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


        $('#birthday').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd"
        });



        //$("#groups").select2();

        $("#userMainNav").addClass('active');
        $("#createUserSubNav").addClass('active');

    });
</script>