<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Administrator</title>

        <!-- Bootstrap Core CSS -->
        <link  rel="stylesheet" href="assets/css/bootstrap.min.css"/>

        <!-- MetisMenu CSS -->
        <link href="assets/js/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="assets/css/sb-admin-2.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="mailer/Text-Editor/editor.css" type="text/css" rel="stylesheet"/>
        <!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css"> -->
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel="stylesheet" type="text/css" href="assets/DataTables/datatables.min.css"/>
        <script src="assets/js/jquery.min.js" type="text/javascript"></script>
        <script src="mailer/Text-Editor/editor.js"></script>
        <!-- for datatable -->
        <script src="assets/js/bootstrap.min.js"></script>
        <!-- Metis Menu Plugin JavaScript -->
        <script src="assets/js/metisMenu/metisMenu.min.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="assets/js/sb-admin-2.js"></script>
        <script src="assets/js/jquery.validate.min.js"></script>
        <!-- Data Table function -->
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <!-- <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.colVis.min.js"></script> -->
    
        <script type="text/javascript" src="assets/DataTables/datatables.min.js"></script>
        <script src="assets/js/function.js"></script>
        <script src="mailer/Text-Editor/editor.js"></script>
    </head>

    <body>

        <div id="wrapper">
            <!-- Navigation -->
            <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true): ?>
                <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="">Administrator</a>
                    </div>
                    <!-- /.navbar-header -->

                    <ul class="nav navbar-top-links navbar-right">
                        <!-- /.dropdown -->

                        <!-- /.dropdown -->
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i></a>
                            <ul class="dropdown-menu dropdown-user">
                                <li>
                                    <a href="edit_admin.php?admin_user_id=
                                    <?php echo($_SESSION['user_id']); ?>
                                    &operation=edit">
                                        <i class="fa fa-user fa-fw">
                                        </i>
                                        <?php echo (isset($admin_data['user_name'])? $admin_data['user_name'] : 'User Profile');?>
                                        </a>
                                    </li>
                                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a></li>
                                <li class="divider"></li>
                                <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                            </ul>
                            <!-- /.dropdown-user -->
                        </li>
                        <!-- /.dropdown -->
                    </ul>
                    <!-- /.navbar-top-links -->

                    <div class="navbar-default sidebar" role="navigation">
                        <div class="sidebar-nav navbar-collapse">
                            <ul class="nav" id="side-menu">
                                <li><a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
                                <li><a href="user_tasks.php"><i class="fa fa-list fa-fw"></i> Asign Task</a></li>
                                <li><a href="proposal.php"><i class="fa fa-file-text fa-fw"></i>Proposal</a></li>
                                <?php if($users->CheckifSuperuser()){?>
                                 <li><a href="counter.php"><i class="fa fa-braille fa-fw"></i> Mail counter</a></li>
                                 <li><a href="database.php"><i class="fa fa-database fa-fw"></i> Database</a></li>
                                <?php } ?>
                                <?php if($users->CheckAdmin()){?>
                                 <li><a href="account.php"><i class="fa fa-building-o fa-fw"></i> Accounts</a></li>
                                <?php } ?>
                                <li><a href="admin_users.php"><i class="fa fa-users fa-fw"></i> Users</a></li>
                                <li><a href="mail_list.php"><i class="fa fa-cog fa-fw"></i> Email Settings</a></li>
                                <li><a href="mailer"><i class="fa fa-envelope fa-fw"></i> Bulk mailer</a></li>
                            </ul>
                        </div>
                        <!-- /.sidebar-collapse -->
                    </div>
                    <!-- /.navbar-static-side -->
                </nav>
            <?php endif; ?>
            <!-- The End of the Header -->
