<?php
$configs = file_get_contents("../configs.json");
$configs = json_decode($configs);
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Nova Senha - <?php echo $configs->name; ?></title>
        
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
    </head>
    <body>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card cntlog">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-4"><i class="fa-sharp fa-solid fa-utensils text-primary"></i> &nbsp; Nova Senha</h5>
                            <form>
                                <div class="mb-3">
                                    <label for="username" class="form-label"><small><i class="fa-solid fa-key text-muted"></i></small> &nbsp;<b>Código</b> <small class="text-danger">*</small></label>
                                    <input type="text" class="form-control" id="inputEmpresa" autocomplete="off" placeholder="Código Recebido" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label"><small><i class="fa-solid fa-lock text-muted"></i></small> &nbsp;<b>Senha</b> <small class="text-danger">*</small></label>
                                    <input type="password" class="form-control" id="inputPassword" autocomplete="off" placeholder="Crie sua Nova Senha" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label"><small><i class="fa-solid fa-lock text-muted"></i></small> &nbsp;<b>Confirmar Senha</b> <small class="text-danger">*</small></label>
                                    <input type="password" class="form-control" id="inputPassconf" autocomplete="off" placeholder="Confirme sua Nova Senha" required>
                                </div>
                                <div class="d-grid">
                                    <button type="button" class="btn btn-primary">Alterar Senha</button>
                                    <a href="#" class="linklogin"><small>Não recebeu código? Re-enviar</small></a>
                                </div>
                            </form>
                            <p class="text-muted w-100 text-center" style="margin: 0px;margin-top: 10px;"><small><?php echo $configs->name; ?> ©</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
