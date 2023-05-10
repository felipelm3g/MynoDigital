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

$container = new Container();
if (!$container->TestAcess('avaliacoes')) {
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
        <title>Avaliações - <?php echo $configs->name; ?></title>

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

        <style>
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
                echo $container->WriteMenu('avaliacoes');
                ?>
                <hr>
                <?php
                echo $container->WriteMenuUser();
                ?>
            </div>

            <div class="conteudo">
                <h4><small><i class="bi pe-none me-2 fa-sharp fa-solid fa-star text-muted"></i></small>Avaliações</h4>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">PED #123</h5>
                        <p class="card-text"><i>"Eu simplesmente amei a comida deste restaurante! Os sabores eram autênticos e deliciosos. E a entrega foi rápida e eficiente, sem falar na embalagem que protegeu muito bem os pratos. Com certeza vou pedir de novo!"</i><br><small class="text-muted"><i class="bi pe-none me-2 fa-solid fa-user"></i>Karine Leal</small></p>
                        <p class="card-text">
                            <i class="fa-solid fa-star text-warning"></i>
                            <i class="fa-solid fa-star text-warning"></i>
                            <i class="fa-solid fa-star text-warning"></i>
                            <i class="fa-solid fa-star text-warning"></i>
                            <i class="fa-solid fa-star text-warning"></i>
                        </p>
                    </div>
                    <div class="dropdown position-absolute btn-sm top-0 end-0 m-2">
                        <button class="btn btn-light dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis-vertical text-muted"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-reply text-muted"></i>Responder</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-eye-slash text-muted"></i>Ocultar</a></li>
                        </ul>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">PED #<small><i class="fa-solid fa-question text-muted"></i></small></h5>
                        <p class="card-text"><i>"O atendimento deste restaurante é excepcional! Desde o momento em que fiz o pedido até a entrega, fui tratado com muita cordialidade e presteza. E a comida estava incrível, um verdadeiro deleite para o paladar!"</i><br><small class="text-muted">(Anônimo)</small></p>
                        <p class="card-text">
                            <i class="fa-solid fa-star text-warning"></i>
                            <i class="fa-solid fa-star text-warning"></i>
                            <i class="fa-solid fa-star text-warning"></i>
                            <i class="fa-solid fa-star text-warning"></i>
                            <i class="fa-solid fa-star text-muted"></i>
                        </p>
                    </div>
                    <div class="dropdown position-absolute btn-sm top-0 end-0 m-2">
                        <button class="btn btn-light dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis-vertical text-muted"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-reply text-muted"></i>Responder</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-eye-slash text-muted"></i>Ocultar</a></li>
                        </ul>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">PED #187</h5>
                        <p class="card-text"><i>"Infelizmente, tive uma experiência ruim com esse restaurante. A comida estava fria e sem sabor, e o atendimento deixou a desejar. Não recomendo."</i><br><small class="text-muted"><i class="bi pe-none me-2 fa-solid fa-user"></i>Adriano</small></p>
                        <p class="card-text">
                            <i class="fa-solid fa-star text-muted"></i>
                            <i class="fa-solid fa-star text-muted"></i>
                            <i class="fa-solid fa-star text-muted"></i>
                            <i class="fa-solid fa-star text-muted"></i>
                            <i class="fa-solid fa-star text-muted"></i>
                        </p>
                    </div>
                    <div class="dropdown position-absolute btn-sm top-0 end-0 m-2">
                        <button class="btn btn-light dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis-vertical text-muted"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-reply text-muted"></i>Responder</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-eye-slash text-muted"></i>Ocultar</a></li>
                        </ul>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">PED #296</h5>
                        <p class="card-text"><i>"A entrega foi rápida, mas a comida estava um pouco fria. Apesar disso, o preço é razoável e o restaurante tem um ambiente agradável. Não foi a melhor experiência, mas também não foi a pior."</i><br><small class="text-muted"><i class="bi pe-none me-2 fa-solid fa-user"></i>Lorena</small></p>
                        <p class="card-text">
                            <i class="fa-solid fa-star text-warning"></i>
                            <i class="fa-solid fa-star text-warning"></i>
                            <i class="fa-solid fa-star text-warning"></i>
                            <i class="fa-solid fa-star text-muted"></i>
                            <i class="fa-solid fa-star text-muted"></i>
                        </p>
                    </div>
                    <div class="dropdown position-absolute btn-sm top-0 end-0 m-2">
                        <button class="btn btn-light dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis-vertical text-muted"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-reply text-muted"></i>Responder</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-eye-slash text-muted"></i>Ocultar</a></li>
                        </ul>
                    </div>
                </div>
                <br>
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
    </body>
</html>