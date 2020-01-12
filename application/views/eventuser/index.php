<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Festmitarbeiter verwalten
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard/') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Festmitarbeiter</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12 col-xs-12">

                <div id="messages"></div>

                <?php if (in_array('createEventuser', $user_permission)) : ?>
                    <button id="btnAdd" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Festmitarbeiter hinzufügen</button>
                    <br /> <br />

                <?php endif; ?>


                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Festmitarbeiter verwalten</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="manageTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Mitarbeiter</th>
                                    <th>Funktion</th>
                                    <th>Nummer</th>
                                    <th>Festtag</th>
                                    <th>Aktuelle Summe [€]</th>
                                    <th>Status</th>
                                    <!-- <th>Kategorie</th> -->
                                    <?php if (in_array('updateEventuser', $user_permission) || in_array('deleteEventuser', $user_permission)) : ?>
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

<?php if (in_array('createEventuser', $user_permission)) : ?>
    <!-- create modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Festmitarbeiter hinzufügen</h4>
                </div>

                <form role="form" action="<?php echo base_url('eventuser/create') ?>" method="post" id="createForm">

                    <div class="modal-body">

                        <div class="form-group">
                            <label for="eventuser">Mitarbeiter *</label>
                            <select class="form-control" id="eventuser" name="eventuser">
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="eventfunction">Festfunktion *</label>
                            <select class="form-control" id="eventfunction" name="eventfunction">
                                <?php foreach ($eventfunction as $k => $v) : ?>
                                    <option value="<?php echo $v['id'] ?>"><?php echo $v['bezeichnung'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="number">Nummer</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <input type="text" class="form-control" id="number" name="number" placeholder="Mitarbeiternummer eintragen" autocomplete="off" readonly="readonly">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="eventday">Festtag *</label>
                            <select class="form-control" id="eventday" name="eventday">
                                <?php foreach ($eventdayEvent as $k => $v) : ?>
                                    <option value="<?php echo $v['id'] ?>"><?php echo $v['fest'] . " / " . $v['festtag'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <p>* notwendige Felder</label>
                        </div>

                        <!-- <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                      <option value="1">Ausser Dienst</option>
                      <option value="2">In Dienst</option>
                      <option value="3">Abgerechnet</option>
                    </select>
                  </div> -->

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

<?php if (in_array('updateEventuser', $user_permission)) : ?>
    <!-- edit modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Festmitarbeiter bearbeiten</h4>
                </div>

                <form role="form" action="<?php echo base_url('eventuser/update') ?>" method="post" id="updateForm">

                    <div class="modal-body">
                        <div id="messages"></div>

                        <div class="form-group">
                            <label for="edit_user">Mitarbeiter</label>
                            <select class="form-control" id="edit_user" name="edit_user" disabled="disabled">
                                <?php foreach ($users as $k => $v) : ?>
                                    <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] . " " . $v['vorname'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="edit_eventfunction">Festfunktion</label>
                            <select class="form-control" id="edit_eventfunction" name="edit_eventfunction">
                                <?php foreach ($eventfunction as $k => $v) : ?>
                                    <option value="<?php echo $v['id'] ?>"><?php echo $v['bezeichnung'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="edit_number">Nummer</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <input type="text" class="form-control" id="edit_number" name="edit_number" placeholder="Mitarbeiternummer eintragen" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_eventday">Festtag</label>
                            <select class="form-control" id="edit_eventday" name="edit_eventday" disabled="disabled">
                                <?php foreach ($eventdayEvent as $k => $v) : ?>
                                    <option value="<?php echo $v['id'] ?>"><?php echo $v['festtag'] . " / " . $v['fest'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <!-- <div class="form-group">
                    <label for="edit_status">Status</label>
                    <select class="form-control" id="edit_status" name="edit_status">
                      <option value="1">Ausser Dienst</option>
                      <option value="2">In Dienst</option>
                      <option value="3">Abgerechnet</option>
                    </select>
                  </div> -->

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

<?php if (in_array('updateEventuser', $user_permission)) : ?>
    <!-- activate modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="activateModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Festmitarbeiter in Dienst stellen</h4>
                </div>

                <form role="form" action="<?php echo base_url('eventuser/startservice') ?>" method="post" id="activateForm">

                    <div class="modal-body">
                        <div id="messages"></div>

                        <div class="form-group">
                            <label for="activate_user">Mitarbeiter</label>
                            <select class="form-control" id="activate_user" name="activate_user" disabled="disabled">
                                <?php foreach ($users as $k => $v) : ?>
                                    <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] . " " . $v['vorname'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="activate_money">Wechselgeld</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-eur"></i>
                                </div>
                                <input type="text" class="form-control" id="activate_money" name="activate_money">
                            </div>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Schliessen</button>
                        <button type="submit" class="btn btn-primary">In Dienst setzen</button>
                    </div>

                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>

<?php if (in_array('updateEventuser', $user_permission)) : ?>
    <!-- cashup modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="cashupModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Festmitarbeiter abrechnen</h4>
                </div>

                <form role="form" action="<?php echo base_url('eventuser/cashupservice') ?>" method="post" id="cashupForm">

                    <div class="modal-body">
                        <div id="messages"></div>

                        <div class="form-group">
                            <label for="cashup_user">Mitarbeiter</label>
                            <select class="form-control" id="cashup_user" name="cashup_user" disabled="disabled">
                                <?php foreach ($users as $k => $v) : ?>
                                    <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] . " " . $v['vorname'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="cashup_money">Aktuelle Summe</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-eur"></i>
                                </div>
                                <input type="text" class="form-control" id="cashup_money" name="cashup_money">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cashup_status">Abrechnungsvorgang</label>
                            <select class="form-control" id="cashup_status" name="cashup_status">
                                <option value="1">Zwischenrechnen</option>
                                <option value="2">Abrechnen</option>
                            </select>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Schliessen</button>
                        <button type="submit" class="btn btn-primary">Abrechnen</button>
                    </div>

                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>

<?php if (in_array('updateEventuser', $user_permission)) : ?>
    <!-- undo modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="undoModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Festmitarbeiter wieder in Dienst stellen</h4>
                </div>

                <form role="form" action="<?php echo base_url('eventuser/undoservice') ?>" method="post" id="undoForm">

                    <div class="modal-body">
                        <div id="messages"></div>

                        <div class="form-group">
                            <label for="undo_user">Mitarbeiter</label>
                            <select class="form-control" id="undo_user" name="undo_user" disabled="disabled">
                                <?php foreach ($users as $k => $v) : ?>
                                    <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] . " " . $v['vorname'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="undo_money">Wechselgeld</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-eur"></i>
                                </div>
                                <input type="text" class="form-control" id="undo_money" name="undo_money">
                            </div>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Schliessen</button>
                        <button type="submit" class="btn btn-primary">In Dienst setzen</button>
                    </div>

                </form>


            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php endif; ?>

<?php if (in_array('deleteEventuser', $user_permission)) : ?>
    <!-- remove modal -->
    <div class="modal modal-danger fade" tabindex="-1" role="dialog" id="removeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Festmitarbeiter löschen</h4>
                </div>

                <form role="form" action="<?php echo base_url('eventuser/remove') ?>" method="post" id="removeForm">
                    <div class="modal-body">
                        <p>Wollen sie den Festmitarbeiter tatsächlich löschen?</p>
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
    let btnAdd = document.getElementById("btnAdd");
    let selectUser = document.getElementById("eventuser");

    $(document).ready(function() {
        $('#userMainNav').addClass('active');
        $('#eventuserSubMenu').addClass('active');

        // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + 'eventuser/fetchData',
            'order': []
        });

        btnAdd.addEventListener('click', loadUser, false);


        // submit the create from 
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

    function loadUser() {

        //Select Mitarbeiter loeschen
        while (selectUser.firstChild !== null) {
            selectUser.removeChild(selectUser.firstChild);
        }

        //Abfrage Mitarbeiterdaten
        $.ajax({
            url: base_url + 'eventuser/getRemainingUser',
            type: 'post',
            dataType: 'json',
            success: function(response) {
                let option = document.createElement("option");
                option.text = 'Bitte Mitarbeiter auswählen';
                option.value = 0;
                selectUser.add(option);
                selectUser.setAttribute

                for (let i = 0; i < response.length; i++) {
                    let option = document.createElement("option");
                    option.text = response[i].name + ' ' + response[i].vorname;
                    option.value = response[i].id;
                    selectUser.add(option);
                }
            }

        });
    }
    // edit function
    function editFunc(id) {
        $.ajax({
            url: base_url + 'eventuser/fetchDataById/' + id,
            type: 'post',
            dataType: 'json',
            success: function(response) {

                $("#edit_user").val(response.idMitarbeiter);
                $("#edit_eventfunction").val(response.idFestfunktion);
                $("#edit_number").val(response.nummer);
                $("#edit_eventday").val(response.idFesttag);
                // $("#edit_money").val(response.wechselgeld);
                // $("#edit_status").val(response.status);
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

    // activate function
    function activateFunc(id) {
        $.ajax({
            url: base_url + 'eventuser/fetchDataById/' + id,
            type: 'post',
            dataType: 'json',
            success: function(response) {

                $("#activate_user").val(response.idMitarbeiter);
                // $("#activate_eventfunction").val(response.idFestfunktion);
                // $("#activate_number").val(response.nummer);
                // $("#activate_eventday").val(response.idFesttag);
                $("#activate_money").val(response.aktSumme);
                // $("#activate_status").val(response.status);
                // $("#created").val(response.created);
                // $("#createdBy").val(response.createdBy);
                $("#updated").val(response.updated);
                // $("#updatedBy").val(response.updatedBy);

                // submit the edit from 
                $("#activateForm").unbind('submit').bind('submit', function() {
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
                                $("#activateModal").modal('hide');
                                // reset the form 
                                $("#activateForm .form-group").removeClass('has-error').removeClass('has-success');

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

    // cashup function
    function cashupFunc(id) {
        $.ajax({
            url: base_url + 'eventuser/fetchDataById/' + id,
            type: 'post',
            dataType: 'json',
            success: function(response) {

                $("#cashup_user").val(response.idMitarbeiter);
                // $("#cashup_eventfunction").val(response.idFestfunktion);
                // $("#cashup_number").val(response.nummer);
                // $("#cashup_eventday").val(response.idFesttag);
                $("#cashup_money").val(response.aktSumme);
                // $("#cashup_status").val(response.status);
                // $("#created").val(response.created);
                // $("#createdBy").val(response.createdBy);
                // $("#updated").val(response.updated);
                // $("#updatedBy").val(response.updatedBy);

                // submit the edit from 
                $("#cashupForm").unbind('submit').bind('submit', function() {
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
                                $("#cashupModal").modal('hide');
                                // reset the form 
                                $("#cashupForm .form-group").removeClass('has-error').removeClass('has-success');

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

    // undo function
    function undoFunc(id) {
        $.ajax({
            url: base_url + 'eventuser/fetchDataById/' + id,
            type: 'post',
            dataType: 'json',
            success: function(response) {

                $("#undo_user").val(response.idMitarbeiter);
                // $("#undo_eventfunction").val(response.idFestfunktion);
                // $("#undo_number").val(response.nummer);
                // $("#undo_eventday").val(response.idFesttag);
                $("#undo_money").val(response.aktSumme);
                // $("#undo_status").val(response.status);
                // $("#created").val(response.created);
                // $("#createdBy").val(response.createdBy);
                // $("#updated").val(response.updated);
                // $("#updatedBy").val(response.updatedBy);

                // submit the edit from 
                $("#undoForm").unbind('submit').bind('submit', function() {
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
                                $("#undoModal").modal('hide');
                                // reset the form 
                                $("#undoForm .form-group").removeClass('has-error').removeClass('has-success');

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
                        eventuser_id: id
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