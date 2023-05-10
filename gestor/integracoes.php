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
    require_once "../class/Database.php";

    $login = new Login();
    $login->RefreshLogin();
}

if (!$_SESSION['USER']['EMPR']['INTG']) {
    header("Location: main");
    exit();
}

$conn = Database::conectar();
$sql = "SELECT * FROM T_EMPRESAS WHERE EMP_CODG = '{$_SESSION['USER']['EMPR']['CODG']}';";
$stmt = $conn->query($sql);
$empresa = $stmt->fetch(PDO::FETCH_ASSOC);
$conn = Database::desconectar();

if (empty($empresa)) {
    header("Location: index");
    exit();
}

//Recuperar o dominio da configuração
$dominio = $configs->dominio;
$dominio = str_replace("https://", "", $dominio);
$dominio = str_replace("http://", "", $dominio);

//Montar Link Cardapio
$urlcard = "";
if ($configs->ssl) {
    $urlcard = $urlcard . "https://";
} else {
    $urlcard = $urlcard . "http://";
}
$urlcard = $urlcard . $dominio . "/" . $empresa['EMP_CARD'];

$container = new Container();
if (!$container->TestAcess('integracoes')) {
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
        <title>Integração - <?php echo $configs->name; ?></title>

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
            .logo-api img {
                max-height: 60px;
            }
        </style>

        <script>
            function AbrirLink(link) {
                $('#ModalLoading').modal('show');
                window.location.href = link;
            }
            function copyToken() {
                let campo = document.getElementById("inputToken");
                campo.disabled = false;
                campo.select();
                document.execCommand("copy");
                campo.disabled = true;
            }
            function copyLink() {
                let campo = document.getElementById("inputLink");
                campo.disabled = false;
                campo.select();
                document.execCommand("copy");
                campo.disabled = true;
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
                echo $container->WriteMenu('integracoes');
                ?>
                <hr>
                <?php
                echo $container->WriteMenuUser();
                ?>
            </div>

            <div class="conteudo">
                <h4><small><i class="bi pe-none me-2 fa-solid fa-network-wired text-muted"></i></small>Integrações</h4>
                <hr>
                <p>Para que possar usar nossa API, é necessário informar seu token para autenticação. Agora atenção, esse token não pode ser compartilhado, usamos ele para vincular suas solicitações a sua empresa, uma vez que terceiros tenha acesso a esse token ele poderam acessar e manipular os dados da sua empresa via API.</p>
                <div class="row">
                    <div class="col">
                        <div class="card w-100" style="max-width: 485px;">
                            <div class="card-body">
                                <h5 class="card-title">API Token</h5>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" id="inputToken" value="<?php echo $empresa['EMP_TOKN']; ?>" disabled="true">
                                    <button class="btn btn-outline-primary" type="button" onclick="copyToken();"><i class="fa-regular fa-copy"></i></button>
                                    <p class="card-text w-100 mt-2">&nbsp;<i class="fa-solid fa-triangle-exclamation text-danger"></i> Não compartilhe com terceiros</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card w-100" style="max-width: 485px;">
                            <div class="card-body">
                                <h5 class="card-title">Link Cardápio</h5>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" id="inputLink" value="<?php echo $urlcard; ?>" disabled="true">
                                    <button class="btn btn-outline-primary" type="button" onclick="copyLink();"><i class="fa-regular fa-copy"></i></button>
                                    <p class="card-text w-100 mt-2">&nbsp;<small class="text-muted">Acesso rápido <?php echo $urlcard; ?>/{numero}/{nome}</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <a target="_blank" href="https://api.ldesistemas.com/" class="btn btn-primary mb-2"><i class="fa-solid fa-circle-nodes"></i> Acessar Documentação</a>
                <hr>
                <br>
                <div class="container text-center">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">BotConversa</h5>
                                    <div class="w-100 logo-api mb-3">
                                        <img src="img/integracoes/botconversa.png"/>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm">Conectar</button>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">iFood</h5>
                                    <div class="w-100 logo-api mb-3">
                                        <img src="img/integracoes/ifood-logo2.png"/>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm">Conectar</button>
                                </div>
                            </div>
                            <br>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Rappi</h5>
                                    <div class="w-100 logo-api mb-3">
                                        <img src="img/integracoes/rappi.png"/>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm">Conectar</button>
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