<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Bestellungen verwalten
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Bestellungen</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if ($this->session->flashdata('success')) : ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif ($this->session->flashdata('errors')) : ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('errors'); ?>
          </div>
        <?php endif; ?>

        <?php if (in_array('testOrder', $user_permission)) :
          ?>
          <a href="<?php echo base_url('order/create') ?>" class="btn btn-primary">Bestellung erstellen</a>
          <br /> <br />
        <?php endif; ?>

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Bestellungen verwalten</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Buchungszeitpunkt</th>
                  <th>Festtag</th>
                  <th>Wer</th>
                  <th>Typ</th>
                  <th>Anzahl Produkte</th>
                  <th>Gesamtsumme</th>
                  <th>Status</th>
                  <?php if (in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)) : ?>
                    <th>Aktion</th>
                  <?php endif; ?>
                </tr>
              </thead>

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

<?php if (in_array('viewOrder', $user_permission)) : ?>
  <!-- view modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="viewModal1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Bestelldetail</h4>
        </div>
        <div class="modal-body" id="viewBody">

          <table class="table" id="viewTable">
            <thead>
              <tr>
                <td><strong>Artikel</strong></td>
                <td><strong>Stück</strong></td>
                <td><strong>Summe</strong></td>
              </tr>
            </thead>
            <tbody>
              <!-- <tr>
                    <td>Portion Kotelett</td>
                    <td>1</td>
                    <td>8.70</td>
                  </tr>
                  <tr>
                    <td>Portion Kotelett</td>
                    <td>1</td>
                    <td>8.70</td>
                  </tr>
                  <tr>
                    <td>Portion Kotelett</td>
                    <td>1</td>
                    <td>8.70</td>
                  </tr>
                  <tr>
                    <td>Portion Kotelett</td>
                    <td>1</td>
                    <td>8.70</td>
                  </tr> -->
            </tbody>
            <tfoot>
              <!-- <tr>
                  <td></td>
                  <td>Gesamtsumme</td>
                  <td><strong>8.70</strong></td>
                </tr> -->
            </tfoot>
          </table>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Schliessen</button>
        </div>



      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<?php endif; ?>

<?php if (in_array('deleteOrder', $user_permission)) : ?>
  <!-- remove modal -->
  <div class="modal modal-danger fade" tabindex="-1" role="dialog" id="removeModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Bestellung löschen</h4>
        </div>

        <form role="form" action="<?php echo base_url('order/remove') ?>" method="post" id="removeForm">
          <div class="modal-body">
            <p>Wollen sie die Bestellung tatsächlich löschen?</p>
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

    $("#orderMainNav").addClass('active');

    // initialize the datatable 
    manageTable = $('#manageTable').DataTable({
      'ajax': base_url + 'order/fetchData',
      'order': []
    });

  });

  // view function
  function viewFunc(id) {
    if (id) {

      $.ajax({
          url: base_url + 'order/fetchDataDetail/' + id,
          type: 'post',
          dataType: 'json',
          success: function(response) {

            let data = response.data;

            let orderContent;

            orderContent = '<p>Erstellt von: ' + data[0][0] + '</p>' +
            '<p>Erstellt am: ' + data[0][1] + '</p>' +
            '<table class="table">' +
              '<thead>' +
              '<tr>' +
              '<td><strong>Artikel</strong></td>' +
              '<td><strong>Stück</strong></td>' +
              '<td><strong>Summe</strong></td>' +
              '</tr>' +
              '</thead>' +
              '<tbody>';

            for (var i = 0; i < data.length; i++) {
              orderContent += '<tr>' +
                '<td>' + data[i][3] + '</td>' +
                '<td>' + data[i][4] + '</td>' +
                '<td>' + data[i][5] + '</td>' +
                '</tr>';
              //const element = array[index];

            }

            orderContent += '</tbody>' +
              '<tfoot>' +
              '<tr>' +
              '<td></td>' +
              '<td>Gesamtsumme</td>' +
              '<td><strong>' + data[0][2] + '</strong></td>' +
              '</tr>' +
              '</tfoot>' +
              '</table>';



            $.confirm({
              title: 'Bestelldetails!',
              //icon: 'fa fa-smile-o',
              content: orderContent,
              type: 'blue',
              columnClass: 'large',
              animation: 'top',
              backgroundDismiss: true,
              closeAnimation: 'bottom',
              theme: 'bootstrap',
              buttons: {
                ja: {
                  text: 'Schliessen',
                  btnClass: 'btn-green',
                  keys: ['enter'],
                  action: function() {
                    
                  }
                }

              }
            });
          }

          });

      }
    }


    // function loadTotal(id) {
    //   if (id) {

    //     $.ajax({
    //       url: base_url + 'order/fetchDataDetail/' + id,
    //       type: 'post',
    //       dataType: 'json',
    //       success: function(response) {

    //         for (let i = 0; i < response.data.length; i++) {
    //           var html = '<tr>' +
    //             '<td>' + response.data[i][0] + '</td>' +
    //             '<td>' + response.data[i][1] + '</td>' +
    //             '<td>' + response.data[i][2] + '</td>' +
    //             '</tr>'

    //           $('#viewTable').append(html);

    //         }


    //       }
    //     });

    //   }
    // }


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
              order_id: id
            },
            dataType: 'json',
            success: function(response) {

              manageTable.ajax.reload(null, false);

              if (response.success === true) {
                $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                  '</div>');

                // hide the modal
                $("#removeModal").modal('hide');

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