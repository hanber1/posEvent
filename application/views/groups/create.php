<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Benutzergruppe hinzufügen
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard/') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('groups/') ?>">Benutzergruppe</a></li>
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
                        <h3 class="box-title">Benutzergruppe hinzufügen</h3>
                    </div>
                    <form role="form" action="<?php base_url('groups/create') ?>" method="post">
                        <div class="box-body">

                            <?php echo validation_errors(); ?>

                            <div class="form-group">
                                <label for="group_name">Gruppenname *</label>
                                <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Gruppenname" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="permission">Berechtigungen</label>

                                <table class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Erstellen</th>
                                            <th>Ändern</th>
                                            <th>Sichtbar</th>
                                            <th>Löschen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Verkauf</td>
                                            <td></td>
                                            <td></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewPos"></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Mitarbeiter</td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createUser"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateUser"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewUser"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteUser"></td>
                                        </tr>
                                        <tr>
                                            <td>Benutzergruppe</td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createGroup"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateGroup"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewGroup"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteGroup"></td>
                                        </tr>
                                        <td>Festmitarbeiter</td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createEventuser"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateEventuser"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewEventuser"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteEventuser"></td>
                                        </tr>
                                        <td>Festfunktion</td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createEventtype"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateEventtype"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewEventtype"></td>
                                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteEventtype"></td>
                                        </tr>
                                        <tr>
                                            <td>Kassa</td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createCashregister"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateCashregister"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewCashregister"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteCashregister"></td>
                                        </tr>
                                        <tr>
                                            <td>Festkassa</td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createEventcashregister"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateEventcashregister"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewEventcashregister"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteEventcashregister"></td>
                                        </tr>
                                        <tr>
                                            <td>Artikel</td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createArticle"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateArticle"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewArticle"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteArticle"></td>
                                        </tr>
                                        <tr>
                                            <td>Artikelkategorie</td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createCategory"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateCategory"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewCategory"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteCategory"></td>
                                        </tr>
                                        <tr>
                                            <td>Artikeleinheit</td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createUnit"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateUnit"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewUnit"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteUnit"></td>
                                        </tr>
                                        <tr>
                                            <td>Festartikel</td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createEventarticle"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateEventarticle"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewEventarticle"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteEventarticle"></td>
                                        </tr>
                                        <tr>
                                            <td>Fest</td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createEvent"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateEvent"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewEvent"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteEvent"></td>
                                        </tr>
                                        <tr>
                                            <td>Festtag</td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createEventday"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateEventday"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewEventday"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteEventday"></td>
                                        </tr>
                                        <tr>
                                            <td>Festtyp</td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createEventtype"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateEventtype"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewEventtype"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteEventtype"></td>
                                        </tr>
                                        <tr>
                                            <td>Bestellungen</td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createOrder"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateOrder"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewOrder"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteOrder"></td>
                                        </tr>
                                        <tr>
                                            <td>Kassabuch</td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createCashbook"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateCashbook"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewCashbook"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteCashbook"></td>
                                        </tr>
                                        <tr>
                                            <td>Kunden</td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createCustomer"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateCustomer"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewCustomer"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteCustomer"></td>
                                        </tr>
                                        <tr>
                                            <td>Report</td>
                                            <td> - </td>
                                            <td> - </td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewReport"></td>
                                            <td> - </td>
                                        </tr>
                                        <tr>
                                            <td>Organisation</td>
                                            <td> - </td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateOrganisation"></td>
                                            <td> - </td>
                                            <td> - </td>
                                        </tr>
                                        <tr>
                                            <td>Profil</td>
                                            <td> - </td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateProfile"></td>
                                            <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewProfile"></td>
                                            <td> - </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="form-group">
                                <p>* notwendige Felder</label>
                            </div>

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Speichern</button>
                            <a href="<?php echo base_url('groups/') ?>" class="btn btn-warning">Zurück</a>
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
        $('#userMainNav').addClass('active');
        $('#groupSubMenu').addClass('active');

        $('input[type="checkbox"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });

    });
</script>