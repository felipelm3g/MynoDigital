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
if (!$container->TestAcess('produtos')) {
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
        <title>Produtos - <?php echo $configs->name; ?></title>

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
        <script src="js/produtos.js"></script>

        <style>
            .card-text {
                height: 100px;
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
                echo $container->WriteMenu('produtos');
                ?>
                <hr>
                <?php
                echo $container->WriteMenuUser();
                ?>
            </div>

            <div class="conteudo">
                <h4><small><i class="bi pe-none me-2 fa-solid fa-pizza-slice text-muted"></i></small>Produtos</h4>
                <hr>
                <div class="container text-center">
                    <div class="row">
                        <div class="col">
                            <div class="card cardprod" onclick="AbrirProduto();">
                                <div class="imgprod card-img-top" style="background-image: url('img/produtos/produto-1.png');">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Produto Teste</h5>
                                    <p class="card-text">Descrição pequena para o produto, para que possa ser compreendido de forma rapida e simples.</p>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="col">
                            <div class="card cardprod" onclick="AbrirProduto();">
                                <div class="imgprod card-img-top" style="background-image: url('img/produtos/produto-2.png');">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Produto Teste</h5>
                                    <p class="card-text">Descrição pequena para o produto, para que possa ser compreendido de forma rapida e simples.</p>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="col">
                            <div class="card cardprod" onclick="AbrirProduto();">
                                <div class="imgprod card-img-top" style="background-image: url('img/produtos/produto-3.png');">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Produto Teste</h5>
                                    <p class="card-text">Descrição pequena para o produto, para que possa ser compreendido de forma rapida e simples.</p>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="col">
                            <div class="card cardprod" onclick="AbrirProduto();">
                                <div class="imgprod card-img-top" style="background-image: url('img/produtos/produto-4.png');">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Produto Teste</h5>
                                    <p class="card-text">Descrição pequena para o produto, para que possa ser compreendido de forma rapida e simples.</p>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card cardprod" onclick="AbrirProduto();">
                                <div class="imgprod card-img-top" style="background-image: url('img/produtos/default.png');">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Produto Teste</h5>
                                    <p class="card-text">Descrição pequena para o produto, para que possa ser compreendido de forma rapida e simples.</p>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="col">
                            <div class="card cardprod" onclick="AbrirProduto();">
                                <div class="imgprod card-img-top" style="background-image: url('img/produtos/newprod.png');">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title text-muted">Novo Produto</h5>
                                    <p class="card-text text-muted">Clique aqui para criar um novo produto</p>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="col">
                        </div>
                        <div class="col">
                        </div>
                    </div>
                </div>
            </div>
        </main>


        <!-- Modal Produto -->
        <div class="modal fade" id="ModalProduto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Produto</h1>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="form-row p-1">
                                        <div class="form-group col">
                                            <label class="m-1">Nome *</label>
                                            <input type="text" class="form-control" id="inputNome">
                                            <div id="inputPropostaValid" class="invalid-feedback">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row p-1">
                                        <div class="form-group col">
                                            <label class="m-1">Descrição *</label>
                                            <textarea class="form-control" style="resize: none;" id="inputDescr" rows="3" maxlength="150"></textarea>
                                            <div id="inputPropostaValid" class="invalid-feedback">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row p-1">
                                        <label class="m-1">Peso</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">Kg</span>
                                            <input type="number" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row p-1">
                                        <label class="m-1">Serve <span id="numbpess" class="text-muted">até 1</span> pessoas</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-users text-muted"></i></span>
                                            <select id="selectQntPess" class="form-select" onchange="AlterouCampo(this);">
                                                <option value="1" selected>1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">+5</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-row p-1">
                                        <label class="m-1">Imagem</label>
                                        <div class="imgprod" style="border-radius: 5px;background-image: url('img/produtos/default.png');">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm">Salvar</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

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