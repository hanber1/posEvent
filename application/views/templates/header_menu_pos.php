<header class="main-header">
    <!-- Logo -->
    <div class="Label">
            <a href="#" class="navbar-brand">
                <span class=""><b>POS</b></span>
            </a>
        </div>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">

        <div class="organisation">
            <a href="#" class="navbar-brand">
                <span class=""><b><?php echo $organisation; ?></b></span>
            </a>
        </div>

        <div class="eventday">
            <a href="#" class="navbar-brand">
                <span class=""><b><?php echo $eventdayEventData; ?></b></span>
            </a>
        </div>

        <!-- Test für Menü -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Aktive Festmitarbeiter-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user-o"></i>
                        <?php 
                        if ($eventuser_count == 0) { ?>
                        <span class="label label-danger"><?php echo $eventuser_count;  ?> </span>
                        <?php 
                      } else { ?>
                        <span class="label label-success"><?php echo $eventuser_count;  ?> </span>
                        <?php 
                      }; ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Aktive Festmitarbeiter</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    <!-- start message -->
                                    <?php 
                                    if ($eventuser) {
                                      foreach ($eventuser as $k => $v) : ?>
                                    <a href="<?php echo base_url('eventuser') ?>">
                                        <h4><?php echo $v['name']; ?>
                                            <p><small> <?php echo $v['funktion']; ?></small></p>
                                            <p><small> <?php echo $v['aktSumme']; ?> €</small></p>
                                        </h4>
                                    </a>
                                    <?php endforeach ?>
                                    <?php 
                                  } else { ?>
                                    <a href="#">
                                        <p><small>Keine aktiven Festmitarbeiter vorhanden</small></p>
                                    </a>
                                    <?php 
                                  } ?>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="<?php echo base_url('eventuser') ?>">Zur Festmitarbeiterübersicht</a></li>
                    </ul>
                </li>

                <!-- Aktive Festkassen-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-money"></i>
                        <?php 
                        if ($eventcashregister_count == 0) { ?>
                        <span class="label label-danger"><?php echo $eventcashregister_count;  ?> </span>
                        <?php 
                      } else { ?>
                        <span class="label label-success"><?php echo $eventcashregister_count;  ?> </span>
                        <?php 
                      }; ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Aktive Festkassen</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    <!-- start message -->
                                    <?php 
                                    if ($eventcashregister) {
                                      foreach ($eventcashregister as $k => $v) : ?>
                                    <a href="<?php echo base_url('eventcashregister') ?>">
                                        <h4><?php echo $v['bezeichnung']; ?>
                                            <!-- <p><small> <?php  ?></small></p> -->
                                        </h4>
                                    </a>
                                    <?php endforeach ?>
                                    <?php 
                                  } else { ?>
                                    <a href="#">
                                        <p><small>Keine aktiven Festkassen vorhanden</small></p>
                                    </a>
                                    <?php 
                                  } ?>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="<?php echo base_url('eventcashregister') ?>">Zur Festkassenübersicht</a></li>
                    </ul>
                </li>

                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="text"><?php echo $act_user_name; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-body">
                            <p>
                                Benutzergruppe:
                                <p><small><?php echo $act_user_group; ?></small></p>
                            </p>

                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?php if (in_array('viewProfile', $user_permission)) : ?>
                                <a href="<?php echo base_url('users/profile/') ?>" class="btn btn-default btn-flat">Profil</a>
                                <?php endif; ?>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo base_url('auth/logout') ?>" class="btn btn-default btn-flat">Logout</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>




    </nav>

</header>
<!-- Left side column. contains the logo and sidebar --> 