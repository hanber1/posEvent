

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Benutzergruppe bearbeiten
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard/') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url('groups/') ?>">Benutzergruppe</a></li>
        <li class="active">bearbeiten</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">
          
          <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('success'); ?>
            </div>
          <?php elseif($this->session->flashdata('error')): ?>
            <div class="alert alert-error alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('error'); ?>
            </div>
          <?php endif; ?>

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Benutzergruppe bearbeiten</h3>
            </div>
            <form role="form" action="<?php base_url('groups/update') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="form-group">
                  <label for="group_name">Gruppenname</label>
                  <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Gruppenname eintragen" value="<?php echo $group_data['bezeichnung']; ?>" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="permission">Berechtigungen</label>

                  <?php $serialize_permission = unserialize($group_data['permission']); ?>
                  
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
                        <td> - </td>
                        <td> - </td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewPos" <?php 
                        if($serialize_permission) {
                          if(in_array('viewPos', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td> - </td>
                      </tr>

                      <tr><!-- Mitarbeiter -->
                        <td>Mitarbeiter</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createUser" <?php if($serialize_permission) {
                          if(in_array('createUser', $serialize_permission)) { echo "checked"; } 
                        } ?> ></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateUser" <?php 
                        if($serialize_permission) {
                          if(in_array('updateUser', $serialize_permission)) { echo "checked"; } 
                        }
                        ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewUser" <?php 
                        if($serialize_permission) {
                          if(in_array('viewUser', $serialize_permission)) { echo "checked"; }   
                        }
                        ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteUser" <?php 
                        if($serialize_permission) {
                          if(in_array('deleteUser', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                      </tr>
                      <tr><!-- Benutzergruppen -->
                        <td>Benutzergruppe</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createGroup" <?php 
                        if($serialize_permission) {
                          if(in_array('createGroup', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateGroup" <?php 
                        if($serialize_permission) {
                          if(in_array('updateGroup', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewGroup" <?php 
                        if($serialize_permission) {
                          if(in_array('viewGroup', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteGroup" <?php 
                        if($serialize_permission) {
                          if(in_array('deleteGroup', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                      </tr>
                      <tr><!-- Festmitarbeiter -->
                        <td>Festmitarbeiter</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createEventuser" <?php if($serialize_permission) {
                          if(in_array('createEventuser', $serialize_permission)) { echo "checked"; } 
                        } ?> ></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateEventuser" <?php 
                        if($serialize_permission) {
                          if(in_array('updateEventuser', $serialize_permission)) { echo "checked"; } 
                        }
                        ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewEventuser" <?php 
                        if($serialize_permission) {
                          if(in_array('viewEventuser', $serialize_permission)) { echo "checked"; }   
                        }
                        ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteEventuser" <?php 
                        if($serialize_permission) {
                          if(in_array('deleteEventuser', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                      </tr>
                      <tr><!-- Festfunktion -->
                        <td>Festfunktion</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createEventfunction" <?php if($serialize_permission) {
                          if(in_array('createEventfunction', $serialize_permission)) { echo "checked"; } 
                        } ?> ></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateEventfunction" <?php 
                        if($serialize_permission) {
                          if(in_array('updateEventfunction', $serialize_permission)) { echo "checked"; } 
                        }
                        ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewEventfunction" <?php 
                        if($serialize_permission) {
                          if(in_array('viewEventfunction', $serialize_permission)) { echo "checked"; }   
                        }
                        ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteEventfunction" <?php 
                        if($serialize_permission) {
                          if(in_array('deleteEventfunction', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                      </tr>
                      <tr><!-- Kassa -->
                        <td>Kassa</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createCashregister" <?php if($serialize_permission) {
                          if(in_array('createCashregister', $serialize_permission)) { echo "checked"; } 
                        } ?> ></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateCashregister" <?php 
                        if($serialize_permission) {
                          if(in_array('updateCashregister', $serialize_permission)) { echo "checked"; } 
                        }
                        ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewCashregister" <?php 
                        if($serialize_permission) {
                          if(in_array('viewCashregister', $serialize_permission)) { echo "checked"; }   
                        }
                        ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteCashregister" <?php 
                        if($serialize_permission) {
                          if(in_array('deleteCashregister', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                      </tr>
                      <tr><!-- Festkassa -->
                        <td>Festkassa</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createEventcashregister" <?php if($serialize_permission) {
                          if(in_array('createEventcashregister', $serialize_permission)) { echo "checked"; } 
                        } ?> ></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateEventcashregister" <?php 
                        if($serialize_permission) {
                          if(in_array('updateEventcashregister', $serialize_permission)) { echo "checked"; } 
                        }
                        ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewEventcashregister" <?php 
                        if($serialize_permission) {
                          if(in_array('viewEventcashregister', $serialize_permission)) { echo "checked"; }   
                        }
                        ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteEventcashregister" <?php 
                        if($serialize_permission) {
                          if(in_array('deleteEventcashregister', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                      </tr>
                      <tr><!-- Artikel -->
                        <td>Artikel</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createArticle" <?php 
                        if($serialize_permission) {
                          if(in_array('createArticle', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateArticle" <?php 
                        if($serialize_permission) {
                          if(in_array('updateArticle', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewArticle" <?php 
                        if($serialize_permission) {
                          if(in_array('viewArticle', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteArticle" <?php 
                        if($serialize_permission) {
                          if(in_array('deleteArticle', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                      </tr>
                      <tr><!-- Artikelkategorien -->
                        <td>Artikelkategorien</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createCategory" <?php 
                        if($serialize_permission) {
                          if(in_array('createCategory', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateCategory" <?php 
                        if($serialize_permission) {
                          if(in_array('updateCategory', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewCategory" <?php 
                        if($serialize_permission) {
                          if(in_array('viewCategory', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteCategory" <?php 
                        if($serialize_permission) {
                          if(in_array('deleteCategory', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                      </tr>
                      <tr><!-- Artikeleinheiten -->
                        <td>Artikeleinheiten</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createUnit" <?php 
                        if($serialize_permission) {
                          if(in_array('createUnit', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateUnit" <?php 
                        if($serialize_permission) {
                          if(in_array('updateUnit', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewUnit" <?php 
                        if($serialize_permission) {
                          if(in_array('viewUnit', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteUnit" <?php 
                        if($serialize_permission) {
                          if(in_array('deleteUnit', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                      </tr>
                      <tr><!-- Festartikel -->
                        <td>Festartikel</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createEventarticle" <?php 
                        if($serialize_permission) {
                          if(in_array('createEventarticle', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateEventarticle" <?php 
                        if($serialize_permission) {
                          if(in_array('updateEventarticle', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewEventarticle" <?php 
                        if($serialize_permission) {
                          if(in_array('viewEventarticle', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteEventarticle" <?php 
                        if($serialize_permission) {
                          if(in_array('deleteEventarticle', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                      </tr>
                      <tr><!-- Fest -->
                        <td>Fest</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createEvent" <?php 
                        if($serialize_permission) {
                          if(in_array('createEvent', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateEvent" <?php 
                        if($serialize_permission) {
                          if(in_array('updateEvent', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewEvent" <?php 
                        if($serialize_permission) {
                          if(in_array('viewEvent', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteEvent" <?php 
                        if($serialize_permission) {
                          if(in_array('deleteEvent', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        </tr>
                      <tr><!-- Festtag -->
                        <td>Festtag</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createEventday" <?php 
                        if($serialize_permission) {
                          if(in_array('createEventday', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateEventday" <?php 
                        if($serialize_permission) {
                          if(in_array('updateEventday', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewEventday" <?php 
                        if($serialize_permission) {
                          if(in_array('viewEventday', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteEventday" <?php 
                        if($serialize_permission) {
                          if(in_array('deleteEventday', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                      </tr>
                      <tr><!-- Festtyp -->
                        <td>Festtyp</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createEventtype" <?php 
                        if($serialize_permission) {
                          if(in_array('createEventtype', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateEventtype" <?php 
                        if($serialize_permission) {
                          if(in_array('updateEventtype', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewEventtype" <?php 
                        if($serialize_permission) {
                          if(in_array('viewEventtype', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteEventtype" <?php 
                        if($serialize_permission) {
                          if(in_array('deleteEventtype', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                      </tr>

                      <tr>
                        <td>Bestellung</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createOrder" <?php 
                        if($serialize_permission) {
                          if(in_array('createOrder', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateOrder" <?php 
                        if($serialize_permission) {
                          if(in_array('updateOrder', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewOrder" <?php 
                        if($serialize_permission) {
                          if(in_array('viewOrder', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteOrder" <?php 
                        if($serialize_permission) {
                          if(in_array('deleteOrder', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                      </tr>
                      <tr>
                        <td>Kassabuch</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createCashbook" <?php 
                        if($serialize_permission) {
                          if(in_array('createCashbook', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateCashbook" <?php 
                        if($serialize_permission) {
                          if(in_array('updateCashbook', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewCashbook" <?php 
                        if($serialize_permission) {
                          if(in_array('viewCashbook', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteCashbook" <?php 
                        if($serialize_permission) {
                          if(in_array('deleteCashbook', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                      </tr>
                      <tr>
                        <td>Kunden</td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createCustomer" <?php 
                        if($serialize_permission) {
                          if(in_array('createCustomer', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateCustomer" <?php 
                        if($serialize_permission) {
                          if(in_array('updateCustomer', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewCustomer" <?php 
                        if($serialize_permission) {
                          if(in_array('viewCustomer', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteCustomer" <?php 
                        if($serialize_permission) {
                          if(in_array('deleteCustomer', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                      </tr>
                      <tr>
                        <td>Report</td>
                        <td> - </td>
                        <td> - </td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewReport" <?php 
                        if($serialize_permission) {
                          if(in_array('viewReport', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td> - </td>
                      </tr>
                      <tr>
                        <td>Organisation</td>
                        <td> - </td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateOrganisation" <?php 
                        if($serialize_permission) {
                          if(in_array('updateOrganisation', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td> - </td>
                        <td> - </td>
                      </tr>
                      <tr>
                        <td>Profil</td>
                        <td> - </td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateProfile" <?php 
                        if($serialize_permission) {
                          if(in_array('updateProfile', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>>
                         </td>
                        <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewProfile" <?php 
                        if($serialize_permission) {
                          if(in_array('viewProfile', $serialize_permission)) { echo "checked"; }  
                        }
                         ?>></td>
                        <td> - </td>
                      </tr>
                    </tbody>
                  </table>
                  
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Änderungen speichern</button>
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
      radioClass   : 'iradio_minimal-blue'
      });

    });
  </script>  

