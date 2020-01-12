<!-- Content Wrapper. Contains page content -->
<div class="wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Verkauf
            <!-- <small> <?php
                            ?> </small> -->
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Menüleiste -->
        <div class="row">
            <div class="col-lg-6 col-sm-6 left-button-columns">
                <div>Aktueller Festtag: <strong><?php echo $eventdayEventData; ?></strong></div>
                <p></p>
                <button type="button" id="btnWaiter" class="btn btn-sm btn-default"><i class=" fa fa-user"></i> Kellner </button>
                <button type="button" id="btnCustomer" class="btn btn-sm btn-default"><i class="fa fa-users"></i> Kunde </button>
                <button type="button" id="btnCashregister" class="btn btn-sm btn-default"><i class="fa fa-money"></i> Kasse </button>
            </div>
            <div class="col-lg-6 col-sm-6 left-button-columns">
                <div>Angemeldeter Benutzer: <strong><?php echo $act_user_name; ?></strong></div>
                <p></p>
                <button type="button" id="btnDash" class="btn btn-sm btn-default"><i class="fa fa-home"></i> Verwaltung </button>
                <button type="button" id="btnLogout" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-log-out"></i> Abmelden </button>
            </div>
        </div>

        <div class="row">

            <!-- links -->
            <!-- Small boxes (Stat box) -->
            <div class="col-lg-6 col-sm-6 left-button-columns">
                <p></p>

                <div class="box">
                    <div class="box mb-0" id="cart-details-wrapper">
                        <!-- <div class="box-header with-border" id="cart-header"> -->
                        <form role="form" action="<?php echo base_url('pos/create') ?>" method="post" id="orderForm">
                            <div class="box-header with-border" id="cart-header">
                                <div class="input-group">
                                    <span class="col-lg-5 col-sm-5">
                                        <label id="lblPerson" for="selectPerson"></label>
                                        <select class="form-control" id="selectPerson" name="selectPerson"></select>
                                    </span>
                                    <span class="col-lg-3 col-sm-3">
                                        <label id="lblKellnernummer" for="inpWaiterNum">Kellnernummer</label>
                                        <input type="text" class="form-control" id="inpWaiterNum" name="inpWaiterNum" autocomplete="off">
                                    </span>
                                    <span class="col-lg-4 col-sm-4">
                                        <div>
                                            <label id="lblPrint" for="chkPrint"><input type="checkbox" class="minimal" id="chkPrint" name="chkPrint">
                                                Gutscheine drucken
                                            </label>
                                        </div>

                                        <div>
                                            <label id="lblPrintReceipt" for="chkPrintReceipt"><input type="checkbox" class="minimal" id="chkPrintReceipt" name="chkPrintReceipt">
                                                Beleg drucken
                                            </label>
                                        </div>
                                    </span>
                                </div>
                                <!-- <div class="input-group">
                                        <span class="col-lg-6 col-sm-6">
                                            <label id="lblPrint" for="chkPrint">Gutscheine drucken</label>
                                            <input type="checkbox" class="flat-red" id="chkPrint" name="chkPrint">
                                        </span>
                                        <span class="col-lg-6 col-sm-6">
                                            <label id="lblPrintReceipt" for="chkPrintReceipt">Beleg drucken</label>
                                            <input type="checkbox" class="flat-red" id="chkPrintReceipt" name="chkPrintReceipt">
                                        </span>
                                    </div> -->
                                <p></p>
                                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-default btn-lg" id="btnDeleteOrder"><i class="fa fa-refresh"></i>
                                            <span class="hidden-xs">Bestellung löschen</span>
                                        </button>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-default btn-lg" id="btnOrder"> <i class="fa fa-money"></i>
                                            <span class="hidden-xs">Bestellung buchen</span>
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" id="hidBuchungstyp" name="hidBuchungstyp" value="">
                            </div>
                            <div class="box-body">
                                <table class="table" id="cart-item-table">
                                    <thead>
                                        <tr class="active">
                                            <td width="50%" class="text-left">Artikel</td>
                                            <td width="10%" class="text-center hidden-xs">Artikelpreis</td>
                                            <td width="10%" class="text-center">Stück</td>
                                            <td width="20%" class="text-center">Positionspreis</td>
                                            <th width="10%">
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr class="success">
                                            <td></td>
                                            <td></td>
                                            <td class="text-right"><strong>
                                                    Gesamtsumme </strong></td>
                                            <td>
                                                <input type="text" name="gesamtPreis" id="gesamtPreis" class="form-control text-center" readonly>
                                                <input type="hidden" name="gesamtPreis_value" id="gesamtPreis_value" class="form-control">
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>

                            <!-- <div class="box-footer" id="cart-panel">
                                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-default btn-lg" id="btnDeleteOrder"><i class="fa fa-refresh"></i>
                                            <span class="hidden-xs">Bestellung löschen</span>
                                        </button>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-default btn-lg" id="btnOrder"> <i class="fa fa-money"></i>
                                            <span class="hidden-xs">Bestellung buchen</span>
                                        </button>
                                    </div>
                                </div>
                            </div> -->



                        </form>
                        <!-- </div> -->
                        <!-- /.box-header -->
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- col-md-12 -->

            <!-- rechts -->
            <!-- Small boxes (Stat box) -->
            <div class="col-lg-6 col-sm-6 left-button-columns">
                <p></p>
                <div class="box">
                    <div class="box mb-0" id="product-wrapper">
                        <div class="box-header with-border" id="product-header">
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- Festartikel in Tab einfuegen -->
                            <ul class="nav nav-tabs">
                                <!-- Festartikel in Kategorien Tab definieren -->
                                <?php
                                foreach ($category as $key => $value) {
                                    //Erste Kategorie auf active setzen
                                    if ($key === 0) { ?>
                                        <li class="active"><a data-toggle="tab" href="#<?php echo "tab" . $value['id']; ?>"><?php echo $value['bezeichnung'];  ?></a></li>
                                    <?php

                                    } else { ?>
                                        <li><a data-toggle="tab" href="#<?php echo "tab" . $value['id']; ?>"><?php echo $value['bezeichnung'];  ?></a></li>
                                    <?php
                                    }
                                } ?>
                                <!-- Alle Festartikeltab definieren -->
                                <li><a data-toggle="tab" href="#all">Alle</a></li>

                            </ul>

                            <?php  ?>
                            <!-- Tab Alle Festartikel einlesen -->
                            <div class="tab-content">
                                <div id="all" class="tab-pane fade in">
                                    <h3>Alle Artikel</h3>
                                    <p></p>
                                    <?php
                                    if ($article) {
                                        foreach ($article as $key => $value) { ?>
                                            <!-- Tab Festartikel in Kategorien -->
                                            <button class="btn btn-app" id="<?php echo "btnArtikel_" . $value['id']; ?>">
                                                <span class="badge bg-blue">€ <?php echo $value['preis']; ?></span>
                                                <p><?php echo $value['einheit'] ?></p><?php echo $value['name']; ?>
                                            </button>
                                        <?php
                                        }
                                    } else { ?>
                                        <h5>Keine Artikel zur Verfügung! Bitte Festartikel anlegen!</h5>
                                        <p></p>
                                    <?php } ?>

                                </div>
                                <!-- Festartikel in Kategorien Tab einlesen -->
                                <?php
                                foreach ($category as $keyC => $valueC) {
                                    if ($keyC === 0) {
                                        ?>
                                        <div id="<?php echo "tab" . $valueC['id']; ?>" class="tab-pane fade in active">
                                        <?php } else {
                                            ?>
                                            <div id="<?php echo "tab" . $valueC['id']; ?>" class="tab-pane fade in">
                                            <?php } ?>

                                            <h3><?php echo $valueC['bezeichnung'];  ?></h3>
                                            <p></p>
                                            <?php
                                            if ($article) {
                                                foreach ($article as $keyA => $valueA) {
                                                    if ($valueC['id'] == $valueA['idKategorie']) { ?>
                                                        <button class="btn btn-app" id="<?php echo "btnArtikel_" . $valueA['id']; ?>">
                                                            <span class="badge bg-blue">€ <?php echo $valueA['preis']; ?></span>
                                                            <p><?php echo $valueA['einheit'] ?></p><?php echo $valueA['name']; ?>
                                                        </button>
                                                    <?php
                                                    }
                                                }
                                            } else { ?>
                                                <h5>Keine Artikel zur Verfügung! Bitte Festartikel anlegen!</h5>
                                                <p></p>

                                            <?php } ?>


                                        </div>

                                    <?php
                                    } ?>

                                </div>

                                <div class="box-footer" id="product-panel">
                                </div>
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

<!-- Logout modal -->
<div class="modal modal-danger fade" tabindex="-1" role="dialog" id="logoutModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Abmelden</h4>
            </div>

            <form role="form" action="<?php echo base_url('auth/logout') ?>" method="post" id="logoutForm">
                <div class="modal-body">
                    <p>Wollen sie sich tatsächlich abmelden?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Nein</button>
                    <button type="submit" class="btn btn-danger">Abmelden</button>
                </div>
            </form>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<script type="text/javascript">
    let base_url = "<?php echo base_url(); ?>";

    let selectPerson = document.getElementById("selectPerson");
    let btnDash = document.getElementById("btnDash");
    let btnLogout = document.getElementById("btnLogout");
    let btnWaiter = document.getElementById("btnWaiter");
    let btnCustomer = document.getElementById("btnCustomer");
    let btnCashregister = document.getElementById("btnCashregister");
    let btnTest = document.getElementById("btnTest");
    let btnDeleteOrder = document.getElementById("btnDeleteOrder");
    let btnOrder = document.getElementById("btnOrder");
    let inpWaiterNum = document.getElementById("inpWaiterNum");
    let chkPrint = document.getElementById("chkPrint");
    let chkPrintReceipt = document.getElementById("chkPrintReceipt");
    let hidBuchungstyp = document.getElementById("hidBuchungstyp");
    let btnArticle = document.getElementsByClassName("btn btn-app");
    let formOrder = document.getElementById("orderForm");
    let lblPerson = document.getElementById("lblPerson");
    let gesamtPreis = document.getElementById("gesamtPreis_value");
    let orderEventArticle = [];
    let orderArticle = document.getElementsByName("artikel[]");
    let orderAmount = document.getElementsByName("menge[]");
    let orderPrice = document.getElementsByName("posPreis[]");

    $(document).ready(function() {

        // iCheck for checkbox and radio inputs
        // $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        //     checkboxClass: 'icheckbox_minimal-blue',
        //     // checkedClass: 'checked',
        //     // disabledClass: 'disabled',
        //     radioClass: 'iradio_minimal-blue'
        // })
        // //Red color scheme for iCheck
        // $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        //     checkboxClass: 'icheckbox_minimal-red',
        //     radioClass: 'iradio_minimal-red'
        // })
        // //Flat red color scheme for iCheck
        // $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        //     checkboxClass: 'icheckbox_flat-green',
        //     radioClass: 'iradio_flat-green'
        // })

        //Kellner aufrufen
        waiterFunc();

        //Eventlistener für Button Kellner
        btnWaiter.addEventListener('click', waiterFunc, false);

        //Eventlistener für Button Kunde
        btnCustomer.addEventListener('click', customerFunc, false);

        //Eventlistener für Button Bestellung buchen
        btnOrder.addEventListener('click', orderValidate, false);

        //Eventlistener für Button Kassen
        btnCashregister.addEventListener('click', cashRegisterFunc, false);

        //Eventlistener für Button Bestellung löschen
        btnDeleteOrder.addEventListener('click', pageRefreshFunc, false);

        inpWaiterNum.oninput = function(e) {
            fetchWaiterData(this.value);
        }

        //Eventlistener für Button Backend
        btnDash.addEventListener('click', dashboardFunc, false);

        //Eventlistener für Button Logout
        btnLogout.addEventListener('click', logoutFunc, false);

        //Eventlistener fuer Artikelbuttons registrieren
        let numBtnArticle = btnArticle.length;

        for (let i = 0; i < numBtnArticle; i++) {
            let attrId = btnArticle[i].getAttribute("id");
            let lenght = attrId.length;
            let posUl = attrId.indexOf("_");

            let id = attrId.slice(posUl + 1, lenght);

            btnArticle[i].addEventListener('click', function() {
                addArticleFunc(id);
            }, false);
        }


    });


    //Formularvalidierung
    function orderValidate(e) {

        //Kellnername fehlt
        if (selectPerson.value == 0 && hidBuchungstyp.value == 2) {
            $.alert({
                title: 'Fehler!',
                icon: 'fa fa-warning',
                content: 'Achtung Kellnername fehlt!',
                type: 'red',
                animation: 'scale',
                closeAnimation: 'bottom',
                theme: 'modern',
            });
            return;
        }
        //Kundenname fehlt
        if (selectPerson.value <= 0 && hidBuchungstyp.value == 4) {
            $.alert({
                title: 'Fehler!',
                icon: 'fa fa-warning',
                content: 'Achtung Kundenname fehlt!',
                type: 'red',
                animation: 'scale',
                closeAnimation: 'bottom',
                theme: 'modern',
            });
            return;
        }
        // //Kassenname fehlt
        if (selectPerson.value <= 0 && hidBuchungstyp.value == 3) {
            $.alert({
                title: 'Fehler!',
                icon: 'fa fa-warning',
                content: 'Achtung Kassenname fehlt!',
                type: 'red',
                animation: 'scale',
                closeAnimation: 'bottom',
                theme: 'modern',
            });
            return;
        }

        //Artikel fehlen
        //Artikelzeilen zaehlen
        var count_table_tbody_tr = $("#cart-item-table tbody tr").length;

        if (count_table_tbody_tr == 0) {
            $.alert({
                title: 'Fehler!',
                icon: 'fa fa-warning',
                content: 'Achtung Artikel fehlen!',
                type: 'red',
                animation: 'scale',
                closeAnimation: 'bottom',
                theme: 'modern',
            });
            return;
        }

        orderSubmit();

    }

    //Abfrage Confirm
    function orderSubmit() {


        let orderContent;

        orderContent = '<table class="table">' +
            '<thead>' +
            '<tr>' +
            '<td><strong>Artikel</strong></td>' +
            '<td><strong>Stück</strong></td>' +
            '<td><strong>Summe</strong></td>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';

        for (var i = 0; i < orderArticle.length; i++) {
            orderContent += '<tr>' +
                '<td>' + orderArticle[i].value + '</td>' +
                '<td>' + orderAmount[i].value + '</td>' +
                '<td>' + orderPrice[i].value + '</td>' +
                '</tr>';
            //const element = array[index];

        }

        orderContent += '</tbody>' +
            '<tfoot>' +
            '<tr>' +
            '<td></td>' +
            '<td>Gesamtsumme</td>' +
            '<td><strong>' + gesamtPreis.value + '</strong></td>' +
            '</tr>' +
            '</tfoot>' +
            '</table>';



        $.confirm({
            title: 'Bestellung für ' + selectPerson.options[selectPerson.selectedIndex].text + ' !',
            icon: 'fa fa-smile-o',
            content: orderContent,
            type: 'green',
            columnClass: 'large',
            animation: 'top',
            backgroundDismiss: true,
            closeAnimation: 'bottom',
            theme: 'dark',
            buttons: {
                // print: {
                //     text: 'Ja, mit drucken',
                //     btnClass: 'btn-blue',
                //     action: function() {
                //         $("#orderForm").submit();
                //     }
                // },
                ja: {
                    text: 'Ja',
                    btnClass: 'btn-green',
                    keys: ['enter'],
                    action: function() {
                        $("#orderForm").submit();
                    }
                },
                nein: {
                    text: 'Nein',
                    btnClass: 'btn-red',
                    action: function() {}
                }

            }
        });

    }

    // Add Article Function
    function addArticleFunc(id) {

        let articlename;
        let articleprice;
        let articleid;

        $.ajax({
            url: base_url + 'eventarticle/fetchArticleDataById/' + id,
            type: 'post',
            dataType: 'json',
            success: function(response) {

                articlename = response.einheit + " " + response.name;
                articleprice = response.preis;
                voucher = response.gutschein;

                if (typeof(orderEventArticle[id]) == "undefined") {
                    //console.log("Die Menge von " + id + " vorher ist noch nicht gesetzt");
                    orderEventArticle[id] = 1;
                    var count_table_tbody_tr = $("#cart-item-table tbody tr").length;
                    var table = $("#cart-item-table");
                    var row_id = count_table_tbody_tr + 1;

                    let html = '<tr id="row_' + id + '">' +
                        '<td><input type="text" name="artikel[]" id="artikel_' + id + '" class="form-control text-left" readonly value = "' + articlename + '"></td>' +
                        '<td><input type="text" name="preis[]" id="preis_' + id + '" class="form-control text-center hidden-xs" readonly value = "' + articleprice + '"></td>' +
                        '<td><input type="number" min="-10" max="20" step="1" value="1" name="menge[]" id="menge_' + id + '" class="form-control text-center" oninput="getTotal(' + id + ')"></td>' +
                        '<td><input type="text" name="posPreis[]" id="posPreis_' + id + '" class="form-control text-center" readonly><input type="hidden" name="posPreis_value[]" id="posPreis_value_' + id + '" class="form-control"></td></td>' +
                        '<input type="hidden" name="id[]" id="id_val_' + id + '" class="form-control" value = "' + id + '">' +
                        '<input type="hidden" name="gutschein[]" id="gutschein_' + id + '" class="form-control" value = "' + voucher + '">' +
                        '<td><button type="button" class="btn btn-default text-left" onclick="removeRow(\'' + id + '\')"><i class="fa fa-close"></i></button></td>' +
                        '</tr>';

                    if (count_table_tbody_tr >= 1) {
                        $("#cart-item-table tbody tr:last").after(html);
                    } else {
                        $("#cart-item-table tbody").html(html);
                    }
                    getTotal(id);

                } else {
                    orderEventArticle[id] += 1;

                    var tableProductLength = $("#cart-item-table tbody tr").length;

                    var tr_id = $("#id_val_" + id).val();

                    if (tr_id === id) {
                        var menge = Number($("#menge_" + id).val()) + 1;

                        $("#menge_" + id).val(menge);

                        getTotal(id);

                    }
                    // }
                }
            }
        });
    }

    // Positionspreis berechnen
    function getTotal(row = null) {
        if (row) {
            var total = Number($("#preis_" + row).val()) * Number($("#menge_" + row).val());
            total = total.toFixed(2);
            $("#posPreis_" + row).val(total);
            $("#posPreis_value_" + row).val(total);

            subAmount();

        } else {
            alert('no row !! please refresh the page');
        }
    }

    // Gesamtsumme der Bestellung berechnen 
    function subAmount() {

        let tableProductLength = $("#cart-item-table tbody tr").length;

        var totalSubAmount = 0;
        for (x = 0; x < tableProductLength; x++) {
            var tr = $("#cart-item-table tbody tr")[x];
            var count = $(tr).attr('id');
            count = count.substring(4);

            totalSubAmount = Number(totalSubAmount) + Number($("#posPreis_" + count).val());
        } // /for

        totalSubAmount = totalSubAmount.toFixed(2);

        // sub total
        $("#gesamtPreis").val(totalSubAmount);
        $("#gesamtPreis_value").val(totalSubAmount);

    } // /sub total amount

    // Load Waiter names
    function waiterFunc() {

        //Buttons Hintergrundfarbe anpassen
        btnWaiter.className = "btn btn-sm btn-primary";
        btnCustomer.className = "btn btn-sm btn-default";
        btnCashregister.className = "btn btn-sm btn-default";

        //Buchungstyp eintragen
        hidBuchungstyp.value = 2;

        //Eingabefelder deaktivieren/aktivieren
        // $("#inpWaiterNum").fadeIn('slow');
        // $("#lblKellnernummer").fadeIn('slow');

        selectPerson.removeAttribute('readonly');
        inpWaiterNum.removeAttribute('readonly');
        chkPrintReceipt.disabled = false;
        chkPrintReceipt.checked = false;
        chkPrint.disabled = true;
        chkPrint.checked = false;
        inpWaiterNum.focus();
        lblPerson.innerHTML = "Kellner";


        //Select Person loeschen
        while (selectPerson.firstChild !== null) {
            selectPerson.removeChild(selectPerson.firstChild);
        }

        //Abfrage Kellnerdaten
        $.ajax({
            url: base_url + 'eventuser/getActiveData',
            type: 'post',
            dataType: 'json',
            success: function(response) {
                let option = document.createElement("option");
                option.text = 'Bitte Kellner auswählen';
                option.value = 0;
                selectPerson.add(option);
                selectPerson.setAttribute

                for (let i = 0; i < response.length; i++) {
                    let option = document.createElement("option");
                    option.text = response[i].name;
                    option.value = response[i].id;
                    selectPerson.add(option);
                }
            }

        });

    }

    // Load Customer names
    function customerFunc() {

        //Buttons Hintergrundfarbe anpassen
        btnWaiter.className = "btn btn-sm btn-default";
        btnCustomer.className = "btn btn-sm btn-primary";
        btnCashregister.className = "btn btn-sm btn-default";

        //Buchungstyp eintragen
        hidBuchungstyp.value = 4;

        //Eingabefelder deaktivieren/aktivieren
        // $("#inpWaiterNum").hide('slow');
        // $("#lblKellnernummer").hide('slow');


        selectPerson.removeAttribute('readonly');
        inpWaiterNum.setAttribute('readonly', 'readonly');
        chkPrintReceipt.disabled = true;
        chkPrintReceipt.checked = false;
        chkPrint.disabled = true;
        chkPrint.checked = false;
        inpWaiterNum.value = "";
        lblPerson.innerHTML = "Kunde";
        //outpWaiterNum.value = "";

        //Select Person loeschen
        while (selectPerson.firstChild !== null) {
            selectPerson.removeChild(selectPerson.firstChild);
        }

        //Abfrage Kundendaten
        $.ajax({
            url: base_url + 'customer/getActiveData',
            type: 'post',
            dataType: 'json',
            success: function(response) {
                let option = document.createElement("option");
                option.text = 'Bitte Kunde auswählen';
                option.value = 0;
                selectPerson.add(option);
                selectPerson.setAttribute

                for (let i = 0; i < response.length; i++) {
                    let option = document.createElement("option");
                    option.text = response[i].name;
                    option.value = response[i].id;
                    selectPerson.add(option);
                }
            }

        });

    }

    // Load Cashfunction
    function cashFunc() {

        //Buttons Hintergrundfarbe anpassen
        btnWaiter.className = "btn btn-sm btn-default";
        btnCustomer.className = "btn btn-sm btn-default";
        btnCashregister.className = "btn btn-sm btn-default";

        //Buchungstyp eintragen
        hidBuchungstyp.value = 1;

        //Eingabefelder deaktivieren/aktivieren
        selectPerson.setAttribute('readonly', 'readonly');
        inpWaiterNum.setAttribute('readonly', 'readonly');
        inpWaiterNum.value = "";

        //Select Person loeschen
        while (selectPerson.firstChild !== null) {
            selectPerson.removeChild(selectPerson.firstChild);
        }

    }

    // Load Cashregisters
    function cashRegisterFunc() {

        //Buttons Hintergrundfarbe anpassen
        btnWaiter.className = "btn btn-sm btn-default";
        btnCustomer.className = "btn btn-sm btn-default";
        btnCashregister.className = "btn btn-sm btn-primary";

        //Buchungstyp eintragen
        hidBuchungstyp.value = 3;

        //Eingabefelder deaktivieren/aktivieren
        // $("#inpWaiterNum").hide('slow');
        // $("#lblKellnernummer").hide('slow');

        selectPerson.removeAttribute('readonly');
        inpWaiterNum.setAttribute('readonly', 'readonly');

        chkPrintReceipt.disabled = false;
        chkPrintReceipt.checked = false;
        chkPrint.disabled = false;
        chkPrint.checked = true;
        inpWaiterNum.value = "";
        lblPerson.innerHTML = "Kassa";

        //Select Person loeschen
        while (selectPerson.firstChild !== null) {
            selectPerson.removeChild(selectPerson.firstChild);
        }

        //Abfrage Kassendaten
        $.ajax({
            url: base_url + 'eventcashregister/getActiveData',
            type: 'post',
            dataType: 'json',
            success: function(response) {
                // let option = document.createElement("option");
                // option.text = 'Bitte Kassa auswählen';
                // option.value = 0;
                // selectPerson.add(option);
                // selectPerson.setAttribute

                for (let i = 0; i < response.length; i++) {
                    let option = document.createElement("option");
                    option.text = response[i].bezeichnung;
                    option.value = response[i].id;
                    selectPerson.add(option);
                }
            }

        });

    }

    // Wechsle ins Backend
    function dashboardFunc() {
        window.location = base_url + 'dashboard';
    }

    // Seite neu laden (Bestellung loeschen)
    function pageRefreshFunc() {
        location.reload();
    }

    // Abmelden
    function logoutFunc() {

        $.confirm({
            title: 'Abmelden!',
            content: 'Wollen Sie sich wirklich abmelden?',
            icon: 'fa fa-warning',
            type: 'red',
            animation: 'scale',
            closeAnimation: 'bottom',
            theme: 'modern',
            buttons: {
                ja: {
                    text: 'Ja',
                    btnClass: 'btn-red',
                    action: function() {
                        window.location = base_url + 'auth/logout';
                    }
                },
                nein: {
                    text: 'Nein',
                    btnClass: 'btn-green',
                    keys: ['enter'],
                    action: function() {

                    }
                }
            }
        });
    }

    //Kellnernummer auslesen
    function getWaiterNum(id) {


        //console.log("Die id des Mitarbeiters ist " + id);
        $.ajax({
            url: base_url + 'eventuser/fetchDataById/' + id,
            type: 'post',
            dataType: 'json',
            success: function(response) {

                //outpWaiterNum.value = response.nummer;
                //console.log("Die Kellnernummer ist " + response.nummer);
            }
        });
    }

    function fetchWaiterData(number) {

        if (number) {
            $.ajax({
                url: base_url + 'eventuser/fetchDataByNumber/' + number,
                type: 'post',
                dataType: 'json',
                success: function(response) {

                    if (response.id) {
                        $('#selectPerson').val(response.id);
                        //outpWaiterNum.value = response.id;
                        //console.log("Die Kellner ID ist " + response.id);
                    } else {
                        $('#selectPerson').val(0);
                    }
                }
            });

        } else {
            $('#selectPerson').val(0);

        }

    }

    function removeRow(tr_id) {
        $("#cart-item-table tbody tr#row_" + tr_id).remove();
        orderEventArticle[tr_id] = undefined;
        subAmount();
    }


    /* Get the documentElement (<html>) to display the page in fullscreen */
    var elem = document.documentElement;

    /* View in fullscreen */
    function openFullscreen() {
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.mozRequestFullScreen) {
            /* Firefox */
            elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullscreen) {
            /* Chrome, Safari and Opera */
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) {
            /* IE/Edge */
            elem.msRequestFullscreen();
        }
    }

    /* Close fullscreen */
    function closeFullscreen() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) {
            /* Firefox */
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
            /* Chrome, Safari and Opera */
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            /* IE/Edge */
            document.msExitFullscreen();
        }
    }
</script>