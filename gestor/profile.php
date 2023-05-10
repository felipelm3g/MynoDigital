<?php
$configs = file_get_contents("../configs.json");
$configs = json_decode($configs);

$cargo = "";

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

$container = new Container();
if (!$container->TestAcess('profile')) {
    header("Location: index");
    exit();
}

switch (intval($_SESSION['USER']['EMPR']['NIVL'])) {
    //CEO
    case 0:
        $cargo = "CEO";
        break;

    //Gestor(a)
    case 1:
        $cargo = "Gestor(a)";
        break;

    //Atendente
    case 2:
        $cargo = "Atendente";
        break;

    //Cozinheiro(a)
    case 3:
        $cargo = "Cozinheiro(a)";
        break;

    //Garçom/Garçonete
    case 4:
        $cargo = "Garçom/Garçonete";
        break;

    //Entregador(a)
    case 5:
        $cargo = "Entregador(a)";
        break;

    default:
        $cargo = "N/A";
        break;
}

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Perfil - <?php echo $configs->name; ?></title>

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

        <link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>   
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js" crossorigin="anonymous"></script>
        <style>
            #myTable_wrapper {

            }
            #myTable_filter {
                margin-bottom: 5px;
            }
            .dt-buttons {
                margin-bottom: 5px;
            }
            .conteudo .dropdown-toggle::after {
                display: none;
            }

            .card {
                margin-top: 30px;
            }

            .card-img-top {
                width: 100%;
                height: auto;
                border-radius: 3px;
            }

            .btn-primary {
                margin-top: 20px;
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
                echo $container->WriteMenu('profile');
                ?>
                <hr>
                <?php
                echo $container->WriteMenuUser();
                ?>
            </div>

            <div class="conteudo">
                <h4><small><i class="bi pe-none me-2 fa-solid fa-user text-muted"></i></small>Perfil <small class="text-muted" style="font-weight: normal;">- <?php echo $cargo; ?></small></h4>
                <hr>
                <br>
                <div class="container">
                    <div class="row" style="max-width: 620px;">
                        <div class="col-md-5">
                            <?php
                            $prefix = "img/users/";
                            if (empty($_SESSION['USER']['IMAG'])) {
                                $urlimg = $prefix . "default.png";
                            } else {
                                $urlimg = $prefix . $_SESSION['USER']['IMAG'];
                            }
                            echo "<img class='card-img-top' src='" . $urlimg . "' alt='Foto de perfil'>";
                            ?>
                            <br>
                            <br>
                            <div class="container text-center">
                                <div class="row">
                                    <div class="col">
                                        <a href="#"><i class="fa-regular fa-image"></i> Alterar Imagem</a>
                                    </div>
                                    <div class="col">
                                        <a href="#"><i class="fa-regular fa-trash-can"></i> Remover Imagem</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <form>
                                <div class="mb-3">
                                    <label for="inputName" class="form-label"><small><i class="fa-solid fa-address-card text-muted"></i></small> &nbsp;<b>Nome</b></label>
                                    <input type="text" class="form-control" id="inputName" autocomplete="off" placeholder="Escreva seu Nome" required value="<?php echo $_SESSION['USER']['NOME']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="inputEmail" class="form-label"><small><i class="fa-solid fa-envelope text-muted"></i></small> &nbsp;<b>E-mail</b></label>
                                    <input type="text" class="form-control" id="inputEmail" autocomplete="off" placeholder="Escreva seu E-mail" required value="<?php echo $_SESSION['USER']['EMAL']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="inputUser" class="form-label"><small><i class="fa-solid fa-user text-muted"></i></small> &nbsp;<b>Usuário</b></label>
                                    <input type="text" class="form-control" id="inputUser" autocomplete="off" placeholder="Crie seu Usuário" required value="<?php echo $_SESSION['USER']['NICK']; ?>">
                                </div>
                                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- Modal Cliente -->

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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
    </body>
</html>