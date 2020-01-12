<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Benutzerdaten bearbeiten
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard/') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('users/profile') ?>">Benutzerdaten</a></li>
            <li class="active">bearbeiten</li>
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
                        <h3 class="box-title">Benutzerdaten bearbeiten</h3>
                    </div>
                    <!-- /.box-header -->
                    <form role="form" action="<?php base_url('users/setting') ?>" method="post">
                        <div class="box-body">

                            <?php echo validation_errors(); ?>


                            <div class="form-group">
                                <label for="firstname">Vorname</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Vorname" value="<?php echo $user_data['vorname'] ?>" autocomplete="off" disabled>
                            </div>

                            <div class="form-group">
                                <label for="lastname">Nachname</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Nachname" value="<?php echo $user_data['name'] ?>" autocomplete="off" disabled>
                            </div>


                            <div class="form-group">
                                <label for="email">E-Mail</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="E-Mail Adresse" value="<?php echo $user_data['email'] ?>" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="groups">Benutzergruppe</label>
                                <select class="form-control" disabled="disabled" id="groups" name="groups">
                                    <option value="">Benutzergruppe wählen</option>
                                    <?php foreach ($group_data as $k => $v) : ?>
                                    <option value="<?php echo $v['id'] ?>" <?php if ($user_group['id'] == $v['id']) {
                                                                              echo 'selected';
                                                                            } ?>><?php echo $v['bezeichnung'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="birthday">Geburtsdatum</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="birthday" name="birthday" placeholder="Datum eintragen" value="<?php echo $user_data['geburtsdatum'] ?>" autocomplete="off" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone">Telefon</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Telefonnummer" value="<?php echo $user_data['telefon'] ?>" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="gender">Geschlecht</label>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="gender" id="male" value="1" <?php if ($user_data['geschlecht'] == 1) {
                                                                                                echo "checked";
                                                                                              } ?> disabled>
                                        Männlich
                                    </label>
                                    <label>
                                        <input type="radio" name="gender" id="female" value="2" <?php if ($user_data['geschlecht'] == 2) {
                                                                                                  echo "checked";
                                                                                                } ?> disabled>
                                        Weiblich
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" disabled="disabled" id="status" name="status">
                                    <option <?php if ($user_data['status'] == 1) {
                                              echo 'selected="selected"';
                                            } ?> value="1">Aktiv</option>
                                    <option <?php if ($user_data['status'] == 2) {
                                              echo 'selected="selected"';
                                            } ?> value="2">Inaktiv</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="alert alert-info alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    Das Feld freilassen, sollte das Passwort nicht geändert werden!
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password">Passwort</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Passwort" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="cpassword">Passwortvergleich</label>
                                <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Passwortvergleich" autocomplete="off">
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Speichern</button>
                            <a href="<?php echo base_url('users/profile/') ?>" class="btn btn-warning">Zurück</a>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>

        </div>
        <!-- /.row -->


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
    $(document).ready(function() {
        //$("#settingMainNav").addClass('active');
    });
</script> 