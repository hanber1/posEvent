<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Kunden verwalten
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard/') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Kunden</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12 col-xs-12">

                <div id="messages"></div>

                <?php if (in_array('createCustomer', $user_permission)) : ?>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Kunden hinzufügen</button>
                    <br /> <br />

                <?php endif; ?>


                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Kunden verwalten</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="manageTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Adresse</th>
                                    <th>Telefon</th>
                                    <th>E-Mail Adresse</th>
                                    <th>Status</th>
                                    <?php if (in_array('updateCustomer', $user_permission) || in_array('deleteCustomer', $user_permission)) : ?>
                                        <th>Aktion</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
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

<?php if (in_array('createCustomer', $user_permission)) : ?>
    <!-- create modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Kunde hinzufügen</h4>
                </div>

                <form role="form" action="<?php echo base_url('customer/create') ?>" method="post" id="createForm">

                    <div class="modal-body">

                        <div class="form-group">
                            <label for="name">Name *</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Kundenname eintragen" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="first_name">Vorname</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Vorname eintragen, falls vorhanden" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="phone">Telefonnummer</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Telefonnummer eintragen" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="email">E-Mailadresse</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="E-Mailadresse eintragen" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="adress">Adresse</label>
                            <input type="text" class="form-control" id="adress" name="adress" placeholder="Adresse eintragen" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1">Aktiv</option>
                                <option value="2">Inaktiv</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <p>* notwendige Felder</label>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Schliessen</button>
                        <button type="submit" class="btn btn-primary">Speichern</button>
                    </div>

                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>

<?php if (in_array('updateCustomer', $user_permission)) : ?>
    <!-- edit modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Kunde bearbeiten</h4>
                </div>

                <form role="form" action="<?php echo base_url('customer/update') ?>" method="post" id="updateForm">

                    <div class="modal-body">
                        <div id="messages"></div>
                        <div class="form-group">
                            <label for="edit_name">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="edit_name" placeholder="Kundenname eintragen" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="edit_first_name">Vorname</label>
                            <input type="text" class="form-control" id="edit_first_name" name="edit_first_name" placeholder="Vorname eintragen, falls vorhanden" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="edit_phone">Telefonnummer</label>
                            <input type="text" class="form-control" id="edit_phone" name="edit_phone" placeholder="Telefonnummer eintragen" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="edit_email">E-Mailadresse</label>
                            <input type="text" class="form-control" id="edit_email" name="edit_email" placeholder="E-Mailadresse eintragen" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="edit_adress">Adresse</label>
                            <input type="text" class="form-control" id="edit_adress" name="edit_adress" placeholder="Adresse eintragen" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="edit_status">Status</label>
                            <select class="form-control" id="edit_status" name="edit_status">
                                <option value="1">Aktiv</option>
                                <option value="2">Inaktiv</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Schliessen</button>
                        <button type="submit" class="btn btn-primary">Speichern</button>
                    </div>

                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>

<?php if (in_array('deleteCustomer', $user_permission)) : ?>
    <!-- remove modal -->
    <div class="modal modal-danger fade" tabindex="-1" role="dialog" id="removeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Kunde löschen</h4>
                </div>

                <form role="form" action="<?php echo base_url('customer/remove') ?>" method="post" id="removeForm">
                    <div class="modal-body">
                        <p>Wollen sie den Kunden tatsächlich löschen?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Schliessen</button>
                        <button type="submit" class="btn btn-danger">Löschen</button>
                    </div>
                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>



<script type="text/javascript">
    var manageTable;
    var base_url = "<?php echo base_url(); ?>";


    $(document).ready(function() {
        $('#customerMainNav').addClass('active');
        //$('#customerSubMenu').addClass('active');
        // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + 'customer/fetchData',
            'order': []
        });

        // submit the create form 
        $("#createForm").unbind('submit').on('submit', function() {
            var form = $(this);

            // remove the text-danger
            $(".text-danger").remove();

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize(), // /converting the form data into array and sending it to server
                dataType: 'json',
                success: function(response) {

                    manageTable.ajax.reload(null, false);

                    if (response.success === true) {
                        $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                            '</div>');


                        // hide the modal
                        $("#addModal").modal('hide');

                        // reset the form
                        $("#createForm")[0].reset();
                        $("#createForm .form-group").removeClass('has-error').removeClass('has-success');

                    } else {

                        if (response.messages instanceof Object) {
                            $.each(response.messages, function(index, value) {
                                var id = $("#" + index);

                                id.closest('.form-group')
                                    .removeClass('has-error')
                                    .removeClass('has-success')
                                    .addClass(value.length > 0 ? 'has-error' : 'has-success');

                                id.after(value);

                            });
                        } else {
                            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                                '</div>');
                        }
                    }
                }
            });

            return false;
        });

    });

    // edit function
    function editFunc(id) {
        $.ajax({
            url: base_url + 'customer/fetchDataById/' + id,
            type: 'post',
            dataType: 'json',
            success: function(response) {

                $("#edit_name").val(response.name);
                $("#edit_first_name").val(response.vorname);
                $("#edit_phone").val(response.telefon);
                $("#edit_email").val(response.email);
                $("#edit_adress").val(response.adresse);
                $("#edit_status").val(response.status);
                $("#created").val(response.created);
                $("#createdBy").val(response.createdBy);
                $("#updated").val(response.updated);
                $("#updatedBy").val(response.updatedBy);

                // submit the edit from 
                $("#updateForm").unbind('submit').bind('submit', function() {
                    var form = $(this);

                    // remove the text-danger
                    $(".text-danger").remove();

                    $.ajax({
                        url: form.attr('action') + '/' + id,
                        type: form.attr('method'),
                        data: form.serialize(), // /converting the form data into array and sending it to server
                        dataType: 'json',
                        success: function(response) {

                            manageTable.ajax.reload(null, false);

                            if (response.success === true) {
                                $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                                    '</div>');


                                // hide the modal
                                $("#editModal").modal('hide');
                                // reset the form 
                                $("#updateForm .form-group").removeClass('has-error').removeClass('has-success');

                            } else {

                                if (response.messages instanceof Object) {
                                    $.each(response.messages, function(index, value) {
                                        var id = $("#" + index);

                                        id.closest('.form-group')
                                            .removeClass('has-error')
                                            .removeClass('has-success')
                                            .addClass(value.length > 0 ? 'has-error' : 'has-success');

                                        id.after(value);

                                    });
                                } else {
                                    $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                        '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                                        '</div>');
                                }
                            }
                        }
                    });

                    return false;
                });

            }
        });
    }

    // remove functions 
    function removeFunc(id) {
        if (id) {
            $("#removeForm").on('submit', function() {

                var form = $(this);

                // remove the text-danger
                $(".text-danger").remove();

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: {
                        customer_id: id
                    },
                    dataType: 'json',
                    success: function(response) {

                        manageTable.ajax.reload(null, false);
                        // hide the modal
                        $("#removeModal").modal('hide');

                        if (response.success === true) {
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                                '</div>');



                        } else {

                            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                                '</div>');
                        }
                    }
                });

                return false;
            });
        }
    }
</script>