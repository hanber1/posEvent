<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Organisation bearbeiten
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard/') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Organisation</li>
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
                        <h3 class="box-title">Organisation bearbeiten</h3>
                    </div>
                    <form role="form" action="<?php base_url('organisation/update') ?>" method="post">
                        <div class="box-body">

                            <?php echo validation_errors(); ?>

                            <div class="form-group">
                                <label for="organisation_name">Organisationsname *</label>
                                <input type="text" class="form-control" id="organisation_name" name="organisation_name" placeholder="Organisation eintragen" value="<?php echo $organisation_data['name'] ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="address">Adresse</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Adresse eintragen" value="<?php echo $organisation_data['addresse'] ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="phone">Telefon</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Telefonnummer eintragen" value="<?php echo $organisation_data['telefon'] ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail Adresse</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="E-mail Adresse eintragen" value="<?php echo $organisation_data['email'] ?>" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="permission">Beschreibung</label>
                                <textarea class="form-control" id="message" name="message">
                     <?php echo $organisation_data['beschreibung'] ?>
                  </textarea>
                            </div>
                            <div class="form-group">
                                <label for="currency">Währung</label>
                                <?php  ?>
                                <select class="form-control" id="currency" name="currency">
                                    <!-- <option value="">~~SELECT~~</option> -->

                                    <?php foreach ($currency_symbols as $k => $v) : ?>
                                        <option value="<?php echo trim($k); ?>" <?php if ($organisation_data['waehrung'] == $k) {
                                                                                    echo "selected";
                                                                                } ?>><?php echo $k ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <p>* notwendige Felder</label>
                        </div>

                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Speichern</button>
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
        $("#organisationMainNav").addClass('active');
        $("#message").wysihtml5();
    });
</script>