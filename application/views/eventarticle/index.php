<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Festartikel verwalten
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard/') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Festartikel</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12 col-xs-12">

                <div id="messages"></div>

                <?php if (in_array('createEventarticle', $user_permission)) : ?>
                    <button id="btnAdd" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Festartikel hinzufügen</button>
                    <br /> <br />

                <?php endif; ?>


                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Festartikel verwalten</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="manageTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Artikel</th>
                                    <!-- <th>Kategorie</th> -->
                                    <th>Festtag</th>
                                    <th>Preis</th>
                                    <!-- <th>Kategorie</th> -->
                                    <?php if (in_array('updateEventarticle', $user_permission) || in_array('deleteEventarticle', $user_permission)) : ?>
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

<?php if (in_array('createEventarticle', $user_permission)) : ?>
    <!-- create modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Festartikel hinzufügen</h4>
                </div>

                <form role="form" action="<?php echo base_url('eventarticle/create') ?>" method="post" id="createForm">

                    <div class="modal-body">

                        <div class="form-group">
                            <label for="eventarticle">Artikel *</label>
                            <select class="form-control" id="eventarticle" name="eventarticle">
                            </select>
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
                            <label for="price">Preis (Bitte Komma mit Punkt eingeben) *</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-eur"></i>
                                </div>
                                <input type="text" class="form-control" id="price" name="price" placeholder="Preis eintragen" autocomplete="off">
                            </div>
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

<?php if (in_array('updateEventarticle', $user_permission)) : ?>
    <!-- edit modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Festartikel bearbeiten</h4>
                </div>

                <form role="form" action="<?php echo base_url('eventarticle/update') ?>" method="post" id="updateForm">

                    <div class="modal-body">
                        <div id="messages"></div>

                        <div class="form-group">
                            <label for="edit_eventarticle">Artikel</label>
                            <select class="form-control" id="edit_eventarticle" name="edit_eventarticle" disabled="disabled">
                                <?php foreach ($articleUnit as $k => $v) : ?>
                                    <option value="<?php echo $v['id'] ?>"><?php echo $v['einheit'] . " " . $v['artikel'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="edit_eventday">Festtag</label>
                            <select class="form-control" id="edit_eventday" name="edit_eventday" disabled="disabled">
                                <?php foreach ($eventdayEvent as $k => $v) : ?>
                                    <option value="<?php echo $v['id'] ?>"><?php echo $v['festtag'] . " / " . $v['fest'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="edit_price">Preis</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-eur"></i>
                                </div>
                                <input type="text" class="form-control" id="edit_price" name="edit_price" placeholder="Preis eintragen" autocomplete="off">
                            </div>
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

<?php if (in_array('deleteEventarticle', $user_permission)) : ?>
    <!-- remove modal -->
    <div class="modal modal-danger fade" tabindex="-1" role="dialog" id="removeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Festartikel löschen</h4>
                </div>

                <form role="form" action="<?php echo base_url('eventarticle/remove') ?>" method="post" id="removeForm">
                    <div class="modal-body">
                        <p>Wollen sie den Festartikel tatsächlich löschen?</p>
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
    let selectArticle = document.getElementById("eventarticle");


    $(document).ready(function() {
        $('#articleMainNav').addClass('active');
        $('#eventArticleSubMenu').addClass('active');

        // initialize the datatable 
        manageTable = $('#manageTable').DataTable({
            'ajax': base_url + 'eventarticle/fetchData',
            'order': []
        });

        btnAdd.addEventListener('click', loadArticle, false);


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
            url: base_url + 'eventarticle/fetchDataById/' + id,
            type: 'post',
            dataType: 'json',
            success: function(response) {

                $("#edit_eventarticle").val(response.idArtikel);
                $("#edit_eventday").val(response.idFesttag);
                $("#edit_price").val(response.preis);
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

    function loadArticle() {

        //Select Artikel loeschen
        while (selectArticle.firstChild !== null) {
            selectArticle.removeChild(selectArticle.firstChild);
        }

        //Abfrage Artikeldaten
        $.ajax({
            url: base_url + 'eventarticle/getRemainingArticle',
            type: 'post',
            dataType: 'json',
            success: function(response) {
                let option = document.createElement("option");
                option.text = 'Bitte Artikel auswählen';
                option.value = 0;
                selectArticle.add(option);
                selectArticle.setAttribute

                for (let i = 0; i < response.length; i++) {
                    let option = document.createElement("option");
                    option.text = response[i].einheit + ' ' + response[i].artikel;
                    option.value = response[i].id;
                    selectArticle.add(option);
                }
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
                        eventarticle_id: id
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