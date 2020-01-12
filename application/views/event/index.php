<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Fest verwalten
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard/') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Fest</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12 col-xs-12">

                <div id="messages"></div>

                <?php if (in_array('createEvent', $user_permission)) : ?>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">Fest hinzufügen</button>
                    <br /> <br />

                <?php endif; ?>


                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Fest verwalten</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="manageTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Fest</th>
                                    <th>Zeitraum</th>
                                    <th>Festtyp</th>
                                    <?php if (in_array('updateEvent', $user_permission) || in_array('deleteEvent', $user_permission)) : ?>
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

<?php if (in_array('createEvent', $user_permission)) : ?>
    <!-- create modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Fest hinzufügen</h4>
                </div>

                <form role="form" action="<?php echo base_url('event/create') ?>" method="post" id="createForm">

                    <div class="modal-body">

                        <div class="form-group">
                            <label for="event_name">Festname *</label>
                            <input type="text" class="form-control" id="event_name" name="event_name" placeholder="Festname eintragen" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="daterange">Zeitraum</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="daterange" name="daterange" placeholder="Zeitraum eintragen" autocomplete="off">
                            </div>
                            <!-- <input type="text" class="form-control" id="daterange" name="daterange" placeholder="Zeitraum eintragen" autocomplete="off"> -->
                        </div>

                        <div class="form-group">
                            <label for="eventtype">Festtyp *</label>
                            <select class="form-control" id="eventtype" name="eventtype">
                                <option selected>Festtyp auswählen ....</option>
                                <?php foreach ($eventtype_data as $k => $v) : ?>
                                    <option value="<?php echo $v['id'] ?>"><?php echo $v['bezeichnung'] ?></option>
                                <?php endforeach ?>
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

<?php if (in_array('updateEvent', $user_permission)) : ?>
    <!-- edit modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Fest bearbeiten</h4>
                </div>

                <form role="form" action="<?php echo base_url('event/update') ?>" method="post" id="updateForm">

                    <div class="modal-body">
                        <div id="messages"></div>

                        <div class="form-group">
                            <label for="edit_event_name">Festname</label>
                            <input type="text" class="form-control" id="edit_event_name" name="edit_event_name" placeholder="Festname eintragen" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="edit_daterange">Zeitraum</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="edit_daterange" name="edit_daterange" placeholder="Zeitraum eintragen" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit_eventtype">Festtyp</label>
                            <select class="form-control" id="edit_eventtype" name="edit_eventtype">
                                <?php foreach ($eventtype_data as $k => $v) : ?>
                                    <option value="<?php echo $v['id'] ?>"><?php echo $v['bezeichnung'] ?></option>
                                <?php endforeach ?>
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

<?php if (in_array('deleteEvent', $user_permission)) : ?>
    <!-- remove modal -->
    <div class="modal modal-danger fade" tabindex="-1" role="dialog" id="removeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Fest löschen</h4>
                </div>

                <form role="form" action="<?php echo base_url('event/remove') ?>" method="post" id="removeForm">
                    <div class="modal-body">
                        <p>Wollen sie das Fest tatsächlich löschen?</p>
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
        $('#eventMainNav').addClass('active');
        $('#eventSubMenu').addClass('active');

        // initialize Daterangepicker
        $('#daterange').daterangepicker({
            showWeekNumbers: true,
            autoApply: true,
            "locale": {
                "format": "YYYY-MM-DD",
                "applyLabel": "Fertig",
                "cancelLabel": "Abbrechen",
                "daysOfWeek": [
                    "So",
                    "Mo",
                    "Di",
                    "Mi",
                    "Do",
                    "Fr",
                    "Sa"
                ],
                "monthNames": [
                    "Jänner",
                    "Februar",
                    "März",
                    "April",
                    "Mai",
                    "Juni",
                    "Juli",
                    "August",
                    "September",
                    "Oktober",
                    "November",
                    "Dezember"
                ],
                "firstDay": 1
            },
        });

        // initialize Daterangepicker
        $('#edit_daterange').daterangepicker({
            showWeekNumbers: true,
            autoApply: true,
            "locale": {
                "format": "YYYY-MM-DD",
                "applyLabel": "Fertig",
                "cancelLabel": "Abbrechen",
                "daysOfWeek": [
                    "So",
                    "Mo",
                    "Di",
                    "Mi",
                    "Do",
                    "Fr",
                    "Sa"
                ],
                "monthNames": [
                    "Jänner",
                    "Februar",
                    "März",
                    "April",
                    "Mai",
                    "Juni",
                    "Juli",
                    "August",
                    "September",
                    "Oktober",
                    "November",
                    "Dezember"
                ],
                "firstDay": 1
            },
        });

        // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + 'event/fetchData',
            'order': []
        });

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

    // edit function
    function editFunc(id) {
        $.ajax({
            url: base_url + 'event/fetchDataById/' + id,
            type: 'post',
            dataType: 'json',
            success: function(response) {

                $("#edit_event_name").val(response.bezeichnung);
                $("#edit_daterange").val(response.zeitraum);
                $("#edit_eventtype").val(response.idFesttyp);
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
                        event_id: id
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