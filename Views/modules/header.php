<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Crediges<?php //echo SYSTEMNAME; ?></title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="Assets/css/app.min.css">

<!--Select picker-->
    <link rel="stylesheet" href="Assets/bundles/selectpicker/dist/css/bootstrap-select.min.css">
    <!-- Template CSS -->
        <!-- DATATABLES -->
    <link rel="stylesheet" href="Assets/bundles/datatables/datatables.min.css">
    <link rel="stylesheet" href="Assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="Assets/css/style.css">
    <link rel="stylesheet" href="Assets/css/components.css">

    <link rel='shortcut icon' type='image/x-icon' href='Assets/img/favicon.ico' />
</head>
<?php if($_GET["url"]=="newsale" || $_GET["url"]=="editsale" || $_GET["url"]=="newloan" || $_GET["url"]=="pagocredito"){
$class='sidebar-mini';
}
else{
    $class=' ';
}?>

<body class="<?php echo $class;?>">
    <!--<body class="dark dark-sidebar theme-black">-->

    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li>
                            <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn">
                                <i data-feather="align-justify"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link nav-link-lg fullscreen-btn">
                                <i data-feather="maximize"></i>
                            </a>
                        </li>
                        <li>
                            <div class="nav-link nav-link-lg">
                                <?php echo $_SESSION['nombreEmrpesa'];?>
                            </div>
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right">
                    <!-- <li class="dropdown dropdown-list-toggle">
                        <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg"><i
                                data-feather="bell"></i>
                            <span class="badge headerBadge2">
                                1 </span> </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">

                            <a href="#" class="dropdown-item">
                                <span class="dropdown-item-icon bg-orange text-white">
                                    <i class="fas fa-bell"></i>
                                </span>
                                <span class="dropdown-item-desc"> Sotck agotado</span>
                            </a>

                        </div>
                    </li>-->
                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="Assets/img/users/<?php echo $_SESSION['imagen']; ?>"
                                class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
                        <div class="dropdown-menu dropdown-menu-right pullDown">
                            <div class="dropdown-title"><?php echo $_SESSION['nombre']; ?></div>
                            <a href="#" class="dropdown-item has-icon"> <i class="far
										fa-user"></i> Perfil
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="salir" class="dropdown-item has-icon text-danger"> <i
                                    class="fas fa-sign-out-alt"></i>
                                Cerrar sesión
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>