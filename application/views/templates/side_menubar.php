<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

            <li id="dashboardMainMenu">
                <a href="<?php echo base_url('dashboard') ?>">
                    <i class="fa fa-dashboard"></i> <span>Übersicht</span>
                </a>
            </li>

            <?php if (in_array('viewPos', $user_permission)) : ?>
            <li id="posMainNav"><a href="<?php echo base_url('pos/') ?>"><i class="fa fa-shopping-cart"></i> <span>Verkauf</span></a></li>
            <?php endif; ?>

            <!-- Menuepunkt Mitarbeiter -->
            <?php if ($user_permission) : ?>
            <?php if (in_array('viewUser', $user_permission) || in_array('viewGroup', $user_permission) || in_array('viewEventuser', $user_permission) || in_array('viewEventfunction', $user_permission)) : ?>
            <li class="treeview" id="userMainNav">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>Mitarbeiter</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                    <?php if (in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)) : ?>
                    <li id="userSubMenu"><a href="<?php echo base_url('users') ?>"><i class="fa fa-circle-o"></i>Mitarbeiter</a></li>
                    <?php endif; ?>

                    <?php if (in_array('createGroup', $user_permission) || in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)) : ?>
                    <li id="groupSubMenu"><a href="<?php echo base_url('groups') ?>"><i class="fa fa-circle-o"></i>Benutzergruppen</a></li>
                    <?php endif; ?>

                    <?php if (in_array('createEventuser', $user_permission) || in_array('updateEventuser', $user_permission) || in_array('viewEventuser', $user_permission) || in_array('deleteEventuser', $user_permission)) : ?>
                    <li id="eventuserSubMenu"><a href="<?php echo base_url('eventuser') ?>"><i class="fa fa-circle-o"></i>Festmitarbeiter</a></li>
                    <?php endif; ?>

                    <?php if (in_array('createEventfunction', $user_permission) || in_array('updateEventfunction', $user_permission) || in_array('viewEventfunction', $user_permission) || in_array('deleteEventfunction', $user_permission)) : ?>
                    <li id="eventfunctionSubMenu"><a href="<?php echo base_url('eventfunction') ?>"><i class="fa fa-circle-o"></i>Festfunktionen</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <!-- Menuepunkt Kassen -->
            <?php if (in_array('viewCashregister', $user_permission) || in_array('viewEventcashregister', $user_permission)) : ?>
            <li class="treeview" id="cashregisterMainNav">
                <a href="#">
                    <i class="fa fa-money"></i>
                    <span>Kassen</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                    <?php if (in_array('createCashregister', $user_permission) || in_array('updateCashregister', $user_permission) || in_array('viewCashregister', $user_permission) || in_array('deleteCashregister', $user_permission)) : ?>
                    <li id="cashregisterSubMenu"><a href="<?php echo base_url('cashregister') ?>"><i class="fa fa-circle-o"></i>Kassa</a></li>
                    <?php endif; ?>

                    <?php if (in_array('createEventcashregister', $user_permission) || in_array('updateEventcashregister', $user_permission) || in_array('viewEventcashregister', $user_permission) || in_array('deleteEventcashregister', $user_permission)) : ?>
                    <li id="eventcashregisterSubMenu"><a href="<?php echo base_url('eventcashregister') ?>"><i class="fa fa-circle-o"></i>Festkassen</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <!-- Menuepunkt Artikel -->
            <?php if (in_array('viewArticle', $user_permission) || in_array('viewCategory', $user_permission) || in_array('viewUnit', $user_permission) || in_array('viewEventarticle', $user_permission)) : ?>
            <li class="treeview" id="articleMainNav">
                <a href="#">
                    <i class="fa fa-shopping-bag"></i>
                    <span>Artikel</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php if (in_array('viewArticle', $user_permission)) : ?>
                    <li id="articleSubMenu"><a href="<?php echo base_url('article/') ?>"><i class="fa fa-circle-o"></i> <span>Artikel</span></a></li>
                    <?php endif; ?>

                    <?php if (in_array('viewCategory', $user_permission)) : ?>
                    <li id="categorySubMenu"><a href="<?php echo base_url('category/') ?>"><i class="fa fa-circle-o"></i> <span>Artikelkategorie</span></a></li>
                    <?php endif; ?>

                    <?php if (in_array('viewUnit', $user_permission)) : ?>
                    <li id="unitSubMenu"><a href="<?php echo base_url('unit/') ?>"><i class="fa fa-circle-o"></i> <span>Artikeleinheit</span></a></li>
                    <?php endif; ?>

                    <?php if (in_array('viewEventarticle', $user_permission)) : ?>
                    <li id="eventArticleSubMenu"><a href="<?php echo base_url('eventarticle/') ?>"><i class="fa fa-circle-o"></i> <span>Festartikel</span></a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <!-- Menuepunkt Fest -->
            <?php if (in_array('viewEvent', $user_permission) || in_array('viewEventday', $user_permission) || in_array('viewEventtype', $user_permission)) : ?>
            <li class="treeview" id="eventMainNav">
                <a href="#">
                    <i class="fa fa-home"></i>
                    <span>Fest</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php if (in_array('createEvent', $user_permission) || in_array('updateEvent', $user_permission) || in_array('viewEvent', $user_permission) || in_array('deleteEvent', $user_permission)) : ?>
                    <li id="eventSubMenu"><a href="<?php echo base_url('event/') ?>"><i class="fa fa-circle-o"></i> <span>Fest</span></a></li>
                    <?php endif; ?>

                    <?php if (in_array('createEventday', $user_permission) || in_array('updateEventday', $user_permission) || in_array('viewEventday', $user_permission) || in_array('deleteEventday', $user_permission)) : ?>
                    <li id="eventdaySubMenu"><a href="<?php echo base_url('eventday/') ?>"><i class="fa fa-circle-o"></i> <span>Festtag</span></a></li>
                    <?php endif; ?>

                    <?php if (in_array('createEventtype', $user_permission) || in_array('updateEventtype', $user_permission) || in_array('viewEventtype', $user_permission) || in_array('deleteEventtype', $user_permission)) : ?>
                    <li id="eventtypeSubMenu"><a href="<?php echo base_url('eventtype/') ?>"><i class="fa fa-circle-o"></i> <span>Festtyp</span></a></li>
                    <?php endif; ?>

                </ul>
            </li>
            <?php endif; ?>

            <!-- Menuepunkt Bestellung -->
            <?php if (in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)) : ?>
            <li id="orderMainNav"><a href="<?php echo base_url('order/') ?>"><i class="fa fa-shopping-cart"></i> <span>Bestellungen</span></a></li>
            <?php endif; ?>


            <?php if (in_array('testOrder', $user_permission) || in_array('testOrder', $user_permission) || in_array('testOrder', $user_permission) || in_array('testOrder', $user_permission)) : ?>
            <li class="treeview" id="orderMainNav">
                <a href="#">
                    <i class="fa fa-shopping-cart"></i>
                    <span>Bestellungen</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php if (in_array('testOrder', $user_permission)) : //Vorlaufig deaktiviert ?>
                    <li id="createOrderSubMenu"><a href="<?php echo base_url('order/create') ?>"><i class="fa fa-circle-o"></i> Bestellungen hinzufügen</a></li>
                    <?php endif; ?>

                    <?php if (in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)) : ?>
                    <li id="manageOrderSubMenu"><a href="<?php echo base_url('order') ?>"><i class="fa fa-circle-o"></i> Bestellungen verwalten</a></li>
                    <?php endif; ?>

                </ul>
            </li>
            <?php endif; ?>

            <!-- Menuepunkt Kassabuch -->
            <?php if (in_array('createCashbook', $user_permission) || in_array('updateCashbook', $user_permission) || in_array('viewCashbook', $user_permission) || in_array('deleteCashbook', $user_permission)) : ?>
            <li id="cashbookMainNav"><a href="<?php echo base_url('cashbook/') ?>"><i class="fa fa-book"></i> <span>Kassabuch</span></a></li>
            <?php endif; ?>

            <!-- Menuepunkt Kunden -->
            <?php if (in_array('createCustomer', $user_permission) || in_array('updateCustomer', $user_permission) || in_array('viewCustomer', $user_permission) || in_array('deleteCustomer', $user_permission)) : ?>
            <li id="customerMainNav"><a href="<?php echo base_url('customer/') ?>"><i class="fa fa-users"></i> <span>Kunden</span></a></li>
            <?php endif; ?>

            <!-- Menuepunkt Report -->
            <?php if (in_array('viewReport', $user_permission)) : ?>
            <li class="treeview" id="ReportMainNav">
                <a href="#">
                    <i class="fa fa-line-chart"></i>
                    <span>Reports</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php if (in_array('viewReport', $user_permission)) : ?>
                    <li id="productReportSubMenu"><a href="<?php echo base_url('reports') ?>"><i class="fa fa-circle-o"></i> Product Wise</a></li>
                    <li id="storeReportSubMenu"><a href="<?php echo base_url('reports/storewise') ?>"><i class="fa fa-circle-o"></i> Total Store wise</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <?php if (in_array('updateOrganisation', $user_permission)) : ?>
            <li id="organisationMainNav"><a href="<?php echo base_url('organisation/') ?>"><i class="fa fa-building-o"></i> <span>Organisation</span></a></li>
            <?php endif; ?>

            <!-- Nur Testweise -->
            <?php if (in_array('updatePdf', $user_permission)) : ?>
            <li id="organisationMainNav"><a href="<?php echo base_url('pdfexample/') ?>"><i class="fa fa-building-o"></i> <span>PDF Test</span></a></li>
            <?php endif; ?>


            <?php endif; ?>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside> 