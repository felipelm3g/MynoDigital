<?php
//Parametros
$emp = "";
$tel = "";
$nome = "";

//Montar os back no caso de redirecionamento
$back = "";

if (isset($_GET['emp'])) {
    if (!empty($_GET['emp'])) {
        $emp = $_GET['emp'];
    } else {
        header("Location: 404");
        exit();
    }
} else {
    header("Location: 404");
    exit();
}

if (isset($_GET['tel'])) {
    if (!empty($_GET['tel'])) {
        $tel = $_GET['tel'];
        $back = $back . "../";
    }
}

if (isset($_GET['nome'])) {
    if (!empty($_GET['nome'])) {
        $nome = $_GET['nome'];
        $back = $back . "../";
    }
}

$configs = file_get_contents("configs.json");
$configs = json_decode($configs);

require_once "class/Database.php";

$conn = Database::conectar();

$sql = "SELECT * FROM T_EMPRESAS WHERE EMP_CARD = '{$emp}';";
$stmt = $conn->query($sql);
$empresa = $stmt->fetch(PDO::FETCH_ASSOC);

$conn = Database::desconectar();

if (empty($empresa)) {
    header("Location: " . $back . "404");
    exit();
}

$conn = Database::conectar();

$sql = "SELECT * FROM T_CONFIG WHERE CFG_CODE = '{$empresa['EMP_CODG']}';";
$stmt = $conn->query($sql);
$cfg = $stmt->fetch(PDO::FETCH_ASSOC);

if (empty($cfg)) {

    $stmt = $conn->prepare("INSERT INTO T_CONFIG (CFG_CODE) VALUES (:CODE)");
    $stmt->bindParam(':CODE', $empresa['EMP_CODG']);
    $stmt->execute();

    $sql = "SELECT * FROM T_CONFIG WHERE CFG_CODE = '{$empresa['EMP_CODG']}';";
    $stmt = $conn->query($sql);
    $cfg = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($cfg)) {
        header("Location: " . $back . "404");
        exit();
    }
}

$conn = Database::desconectar();
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $empresa['EMP_NOME'] . " - " . $configs->name; ?></title>

        <link rel="apple-touch-icon" sizes="57x57" href="gestor/<?php echo $configs->icons[0]->{"57"}; ?>">
        <link rel="apple-touch-icon" sizes="60x60" href="gestor/<?php echo $configs->icons[0]->{"60"}; ?>">
        <link rel="apple-touch-icon" sizes="72x72" href="gestor/<?php echo $configs->icons[0]->{"72"}; ?>">
        <link rel="apple-touch-icon" sizes="76x76" href="gestor/<?php echo $configs->icons[0]->{"76"}; ?>">
        <link rel="apple-touch-icon" sizes="114x114" href="gestor/<?php echo $configs->icons[0]->{"114"}; ?>">
        <link rel="apple-touch-icon" sizes="120x120" href="gestor/<?php echo $configs->icons[0]->{"120"}; ?>">
        <link rel="apple-touch-icon" sizes="144x144" href="gestor/<?php echo $configs->icons[0]->{"144"}; ?>">
        <link rel="apple-touch-icon" sizes="152x152" href="gestor/<?php echo $configs->icons[0]->{"152"}; ?>">
        <link rel="apple-touch-icon" sizes="180x180" href="gestor/<?php echo $configs->icons[0]->{"180"}; ?>">
        <link rel="icon" type="image/png" sizes="192x192"  href="gestor/<?php echo $configs->icons[0]->{"192"}; ?>">
        <link rel="icon" type="image/png" sizes="32x32" href="gestor/<?php echo $configs->icons[0]->{"32"}; ?>">
        <link rel="icon" type="image/png" sizes="96x96" href="gestor/<?php echo $configs->icons[0]->{"96"}; ?>">
        <link rel="icon" type="image/png" sizes="16x16" href="gestor/<?php echo $configs->icons[0]->{"16"}; ?>">
        <link rel="manifest" href="gestor/<?php echo $configs->manifest; ?>">
        <meta name="msapplication-TileColor" content="gestor/<?php echo $configs->themecolor; ?>">
        <meta name="msapplication-TileImage" content="gestor/<?php echo $configs->icons[0]->{"144"}; ?>">
        <meta name="theme-color" content="gestor/<?php echo $configs->themecolor; ?>">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>

        <script type="text/javascript">
            function AbrirLink(link) {
                $('#ModalLoading').modal('show');
                window.location.href = link;
            }
        </script>

        <style>
            .principal {
                width: 100%;
                height: calc(100% - 75px);
                position: fixed;
                left: 0px;
                right: 0px;
                top: 0px;
                overflow: auto;
            }
            .footer {
                width: 100%;
                height: 75px;
                position: fixed;
                left: 0px;
                right: 0px;
                bottom: 0px;
                padding: 12px;
            }
            .btn {
                font-size: 1.2em;
                height: 50px;
            }

            .empresa1 {
                height: 156px;
                background-color: #e8e8e8;
                background-image: url("gestor/img/background.png");
                background-attachment: fixed;
                background-size: 100px;
                background-repeat: repeat;
            }
            .empresa2 {
                height: 120px;
                background-color: #e8e8e8;
                background-image: url("gestor/img/background.png");
                background-attachment: fixed;
                background-size: 100px;
                background-repeat: repeat;
            }
            .empresa1 .logo {
                background-color: #fff;
                border-radius: 100%;
                width: 70px;
                height: 70px;
                margin-left: calc(50% - 35px);
                margin-right: calc(50% - 35px);
                background-image: url("gestor/img/logo-card.png");
                background-size: cover;
                background-repeat: no-repeat;
                margin-top: 15px;
                margin-bottom: 10px;
                box-shadow: 1px 1px 5px 0px rgba(0, 0, 0, 0.5);
            }
            .empresa1 .nameemp {
                width: 100%;
                text-align: center;
                color: #fff;
                text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
                font-size: 1.2em;
                font-weight: normal;
                line-height: 20px;
            }
            .empresa2 .logo {
                background-color: #fff;
                border-radius: 100%;
                float: left;
                width: 80px;
                height: 80px;
                margin-left: 10px;
                background-image: url("gestor/img/logo-card.png");
                background-size: cover;
                background-repeat: no-repeat;
                margin-top: 20px;
                margin-bottom: 20px;
                box-shadow: 1px 1px 5px 0px rgba(0, 0, 0, 0.5);
            }
            .empresa2 .nameemp {
                float: left;
                width: calc(100% - 115px);
                height: 44px;
                margin: 0px;
                margin-left: 20px;
                margin-right: 5px;
                margin-top: 42px;
                text-align: left;
                color: #fff;
                text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
                font-size: 1.2em;
                font-weight: normal;
                line-height: 20px;
            }
            .produto {
                float: left;
                position: relative;
                width: 100%;
                border: 1px solid rgba(0, 0, 0, 0.2);
                border-radius: 8px;
                margin-bottom: 20px;
                box-shadow: 1px 1px 5px 0px rgba(0, 0, 0, 0.5);
            }
            .produto h5 {
                margin: 0px;
                padding: 0px;
                font-size: 1.2em;
                margin-bottom: 8px;
            }
            .produto p {
                margin: 0px;
                padding: 0px;
                font-size: 1.0em;
                height: 3.6em;
                line-height: 1.2em;
                overflow: hidden;
                opacity: 0.6;
            }
            .produto h6 {
                margin: 0px;
                padding: 0px;
                font-size: 1.1em;
                margin-top: 8px;
            }
            .tag {
                float: right;
                position: absolute;
                z-index: 999;
                right: 0px;
                border-radius: 0px 8px 0px 8px;
                text-align: center;
                font-size: 0.8em;
                margin-top: -1px;
                margin-right: -1px;
                padding: 0px 6px 0px 6px;
            }
            .promo {
                background-color: #28a745;
                color: #fff;
            }
            .indisp {
                background-color: #ea4335;
                color: #fff;
            }
            .img-prod {
                float: left;
                position: absolute;
                width: 100px;
                height: 100%;
                margin: 0px;
                padding: 0px;
                border-radius: 7px 0px 0px 7px;
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
                /*margin-top: -1px;*/
                /*margin-left: -1px;*/
                /*margin-bottom: -1px;*/
            }
            .prod-body {
                float: right;
                position: relative;
                width: calc(100% - 100px);
                margin: 0px;
                padding: 10px;
            }
        </style>
    </head>
    <body>
        <div class="principal">
            <div class="container-md">
                <?php
                if ($cfg['CFG_LTCD'] == 0) {
                    echo "<div class='row'>";
                    echo "<div class='col empresa1'>";
                    echo "<div class='logo'>";
                    echo "</div>";
                    echo "<h1 class='nameemp'><b>" . $empresa['EMP_NOME'] . "</b><br><small><small><small>Descrição</small></small></small></h1>";
                    echo "</div>";
                    echo "</div>";
                }
                if ($cfg['CFG_LTCD'] == 1) {
                    echo "<div class='row'>";
                    echo "<div class='col empresa2'>";
                    echo "<div class='logo'>";
                    echo "</div>";
                    echo "<h1 class='nameemp'><b>" . $empresa['EMP_NOME'] . "</b><br><small><small><small>Descrição</small></small></small></h1>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
                <br>
                <div class="row">
                    <div class="col-md-4">
                        <div class="produto" onclick="AbrirLink('<?php echo $emp; ?>/produto/15151');">
                            <div class="tag indisp">Esgotado</div>
                            <div class="img-prod" style="background-image: url('gestor/img/produtos/produto-1.png');">
                            </div>
                            <div class="prod-body">
                                <h5>Produto Teste</h5>
                                <p><i>(Sem descrição)</i></p>
                                <h6>R$ 10,00</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="produto" onclick="AbrirLink('<?php echo $emp; ?>/produto/15151');">
                            <div class="img-prod" style="background-image: url('gestor/img/produtos/produto-2.png');">
                            </div>
                            <div class="prod-body">
                                <h5>Produto Teste</h5>
                                <p>Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <h6>R$ 10,00</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="produto" onclick="AbrirLink('<?php echo $emp; ?>/produto/15151');">
                            <div class="tag promo">-10%</div>
                            <div class="img-prod" style="background-image: url('gestor/img/produtos/produto-3.png');">
                            </div>
                            <div class="prod-body">
                                <h5>Produto Teste</h5>
                                <p>Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <h6 class="text-success"><small class="text-muted"><s>R$ 10,00</s></small> &nbsp;R$ 9,00</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="produto" onclick="AbrirLink('<?php echo $emp; ?>/produto/15151');">
                            <div class="tag promo">Promoção</div>
                            <div class="img-prod" style="background-image: url('gestor/img/produtos/produto-4.png');">
                            </div>
                            <div class="prod-body">
                                <h5>Produto Teste</h5>
                                <p>Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <h6 class="text-success"><small class="text-muted"><s>R$ 10,00</s></small> &nbsp;R$ 9,00</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <button onclick="AbrirLink('<?php echo $emp; ?>/carrinho');" type="button" class="btnadd btn btn-primary w-100"><i class="fa-solid fa-cart-shopping"></i>&nbsp; Ver Carrinho &nbsp;<small><span class="badge text-primary bg-light">0</span></small></button>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </body>
</html>

