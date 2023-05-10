<?php
$configs = file_get_contents("../configs.json");
$configs = json_decode($configs);

session_start();
if (!isset($_SESSION['USER'])) {
    session_destroy();
} else {
    if (empty($_SESSION['USER']['EMPR'])) {
        header("Location: empresas");
        exit();
    } else {
        switch (intval($_SESSION['USER']['EMPR']['NIVL'])) {
            //CEO
            case 0:
                header("Location: main");
                exit();
                break;

            //Gestor(a)
            case 1:
                header("Location: pedidos");
                exit();
                break;

            //Atendente
            case 2:
                header("Location: pedidos");
                exit();
                break;

            //Cozinheiro(a)
            case 3:
                header("Location: cozinha");
                exit();
                break;

            //Garçom/Garçonete
            case 4:
                header("Location: mesas");
                exit();
                break;

            //Entregador(a)
            case 5:
                header("Location: entregas");
                exit();
                break;

            default:
                echo "Erro interno - Entrar em contato com suporte <b>contato@ldesistemas.com</b>";
                exit();
                break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Login - <?php echo $configs->name; ?></title>

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

        <link rel="stylesheet" href="css/login.css">

        <script src="js/windowmsg.js"></script>
        <script src="js/login.js"></script>

        <script>
            criandoconta = false;
            function AbrirLink(link) {
                $('#ModalLoading').modal('show');
                window.location.href = link;
            }
        </script>
    </head>
    <body>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card cntlog">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-4"><i class="fa-sharp fa-solid fa-utensils text-primary"></i> &nbsp; Login</h5>
                            <form>
                                <div class="mb-3">
                                    <label for="inputUser" class="form-label"><small><i class="fa-solid fa-user text-muted"></i></small> &nbsp;<b>Usuário</b> <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control" id="inputUser" autocomplete="off" placeholder="Digite seu Usuário" required>
                                </div>
                                <div class="mb-3">
                                    <label for="inputPassword" class="form-label"><small><i class="fa-solid fa-lock text-muted"></i></small> &nbsp;<b>Senha</b> <small class="text-danger">*</small></label>
                                    <input type="password" class="form-control" id="inputPassword" autocomplete="off" placeholder="Digite sua Senha" required>
                                </div>
                                <div class="d-grid">
                                    <button type="button" onclick="FazerLogin();" class="btn btn-primary">Login</button>
                                    <a onclick="AbrirLink('esquecisenha');" href="#" class="linklogin"><small>Já tenho conta mas esqueci minha senha</small></a>
                                    <a onclick="AbrirLink('criarconta');" href="#" class="linklogin"><small>Não tem conta? Criar conta</small></a>
                                </div>
                            </form>
                            <p class="text-muted w-100 text-center" style="margin: 0px;margin-top: 10px;"><small><?php echo $configs->name; ?> ©</small></p>
                        </div>
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
