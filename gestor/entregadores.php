<?php
$configs = file_get_contents("../configs.json");
$configs = json_decode($configs);

date_default_timezone_set('America/Fortaleza');
session_start();
if (!isset($_SESSION['USER'])) {
    session_destroy();
    header("Location: index");
    exit();
} else {
    if (empty($_SESSION['USER']['EMPR'])) {
        header("Location: empresas");
        exit();
    }

    require_once "../class/Login.php";
    require_once "../class/Container.php";

    $login = new Login();
    $login->RefreshLogin();
}

if (!$_SESSION['USER']['EMPR']['ENTR']) {
    header("Location: main");
    exit();
}

$container = new Container();
if (!$container->TestAcess('entregadores')) {
    header("Location: index");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Entregadores - <?php echo $configs->name; ?></title>

        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $configs->icons[0]->{"57"}; ?>">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo $configs->icons[0]->{"60"}; ?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $configs->icons[0]->{"72"}; ?>">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $configs->icons[0]->{"76"}; ?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $configs->icons[0]->{"114"}; ?>">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $configs->icons[0]->{"120"}; ?>">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $configs->icons[0]->{"144"}; ?>">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $configs->icons[0]->{"152"}; ?>">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $configs->icons[0]->{"180"}; ?>">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo $configs->icons[0]->{"192"}; ?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $configs->icons[0]->{"32"}; ?>">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $configs->icons[0]->{"96"}; ?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $configs->icons[0]->{"16"}; ?>">
        <link rel="manifest" href="<?php echo $configs->manifest; ?>">
        <meta name="msapplication-TileColor" content="<?php echo $configs->themecolor; ?>">
        <meta name="msapplication-TileImage" content="<?php echo $configs->icons[0]->{"144"}; ?>">
        <meta name="theme-color" content="<?php echo $configs->themecolor; ?>">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="css/main.css">
        <script src="js/windowmsg.js"></script>

        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

        <style>
            #myTable_wrapper {
                margin-top: -65px;
            }
            #myTable_filter {
                margin-bottom: 18px;
            }
            .conteudo .dropdown-toggle::after {
                display: none;
            }
        </style>
        <script>
            function AbrirLink(link) {
                $('#ModalLoading').modal('show');
                window.location.href = link;
            }
        </script>
    </head>
    <body>

        <main class="principal">
            <div class="p-3 text-bg-dark menulateral">
                <a href="main" class="d-flex align-items-center mb-3 mb-md-0 w-100 me-md-auto text-white text-decoration-none">
                    <span class="fs-4"><i class="fa-sharp fa-solid fa-utensils text-primary"></i> &nbsp;&nbsp; <?php echo $configs->name; ?></span> 
                </a>
                <hr>
                <?php
                echo $container->WriteMenu('entregadores');
                ?>
                <hr>
                <?php
                echo $container->WriteMenuUser();
                ?>
            </div>

            <div class="conteudo">
                <h4><small><i class="bi pe-none me-2 fa-solid fa-motorcycle text-muted"></i></small>Entregadores</h4>
                <hr>
                <table id="myTable" class="display">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Veiculo</th>
                            <th>Placa</th>
                            <th>Entregas</th>
                            <th>Taxa</th>
                            <th>Diária</th>
                            <th>Fila</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>1.</th>
                            <th>João Paulo</th>
                            <td>CG150</td>
                            <td>HXP6463</td>
                            <td><span class="badge text-bg-success">3</span></td>
                            <td>R$ 2.00<small class="text-muted">/km</small></td>
                            <th>R$ 84.00</th>
                            <td><span class="badge text-bg-primary">1º</span></td>
                            <td><span class="badge text-bg-success">Online</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-pen-to-square text-muted"></i>Editar</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-toggle-off text-danger"></i>Offline</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-regular fa-trash-can text-danger"></i>Deletar</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>2.</th>
                            <th>Luis Adriano</th>
                            <td>FZ250</td>
                            <td>OSD2313</td>
                            <td><span class="badge text-bg-secondary">0</span></td>
                            <td>R$ 5.00<small class="text-muted">/ent</small></td>
                            <th>R$ 0.00</th>
                            <td><span class="badge text-bg-primary">2º</span></td>
                            <td><span class="badge text-bg-success">Online</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-pen-to-square text-muted"></i>Editar</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-toggle-off text-danger"></i>Offline</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-regular fa-trash-can text-danger"></i>Deletar</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>3.</th>
                            <th>Julio Cesar</th>
                            <td>CG160</td>
                            <td>HWQ7317</td>
                            <td><span class="badge text-bg-success">2</span></td>
                            <td>R$ 5.00<small class="text-muted">/ent</small></td>
                            <th>R$ 10.00</th>
                            <td><span class="badge text-bg-warning">Em rota</span></td>
                            <td><span class="badge text-bg-success">Online</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-pen-to-square text-muted"></i>Editar</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-toggle-off text-danger"></i>Offline</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-regular fa-trash-can text-danger"></i>Deletar</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>4.</th>
                            <th>Felipe Lopes</th>
                            <td>ZX400</td>
                            <td>PSD1441</td>
                            <td><span class="badge text-bg-secondary">0</span></td>
                            <td><small class="text-muted">(Padrão)</small></td>
                            <th></th>
                            <td></td>
                            <td><span class="badge text-bg-secondary">Offline</span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-pen-to-square text-muted"></i>Editar</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-toggle-on text-success"></i>Online</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-regular fa-trash-can text-danger"></i>Deletar</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Veiculo</th>
                            <th>Placa</th>
                            <th>Entregas</th>
                            <th>Taxa</th>
                            <th>Diária</th>
                            <th>Fila</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </main>

        <!-- Modal Loading -->
        <div class="modal fade" id="ModalLoading" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border: 0px;background: rgba(0,0,0,0.0);">
                    <div class="text-center">
                        <div class="spinner-border text-light" style="width: 4rem; height: 4rem;" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="js/datatables_sembtns.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
    </body>
</html>