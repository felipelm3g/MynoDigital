<?php
//Parametros
$emp = "";
$prd = "";

//Dados do cliente
$cliente = [];

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

if (isset($_GET['prod'])) {
    if (!empty($_GET['prod'])) {
        $prd = $_GET['prod'];
    } else {
        header("Location: 404");
        exit();
    }
} else {
    header("Location: 404");
    exit();
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
    header("Location: ../../404");
    exit();
}
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Produto - <?php echo $configs->name; ?></title>

        <link rel="apple-touch-icon" sizes="57x57" href="../../gestor/<?php echo $configs->icons[0]->{"57"}; ?>">
        <link rel="apple-touch-icon" sizes="60x60" href="../../gestor/<?php echo $configs->icons[0]->{"60"}; ?>">
        <link rel="apple-touch-icon" sizes="72x72" href="../../gestor/<?php echo $configs->icons[0]->{"72"}; ?>">
        <link rel="apple-touch-icon" sizes="76x76" href="../../gestor/<?php echo $configs->icons[0]->{"76"}; ?>">
        <link rel="apple-touch-icon" sizes="114x114" href="../../gestor/<?php echo $configs->icons[0]->{"114"}; ?>">
        <link rel="apple-touch-icon" sizes="120x120" href="../../gestor/<?php echo $configs->icons[0]->{"120"}; ?>">
        <link rel="apple-touch-icon" sizes="144x144" href="../../gestor/<?php echo $configs->icons[0]->{"144"}; ?>">
        <link rel="apple-touch-icon" sizes="152x152" href="../../gestor/<?php echo $configs->icons[0]->{"152"}; ?>">
        <link rel="apple-touch-icon" sizes="180x180" href="../../gestor/<?php echo $configs->icons[0]->{"180"}; ?>">
        <link rel="icon" type="image/png" sizes="192x192"  href="../../gestor/<?php echo $configs->icons[0]->{"192"}; ?>">
        <link rel="icon" type="image/png" sizes="32x32" href="../../gestor/<?php echo $configs->icons[0]->{"32"}; ?>">
        <link rel="icon" type="image/png" sizes="96x96" href="../../gestor/<?php echo $configs->icons[0]->{"96"}; ?>">
        <link rel="icon" type="image/png" sizes="16x16" href="../../gestor/<?php echo $configs->icons[0]->{"16"}; ?>">
        <link rel="manifest" href="../../gestor/<?php echo $configs->manifest; ?>">
        <meta name="msapplication-TileColor" content="../../gestor/<?php echo $configs->themecolor; ?>">
        <meta name="msapplication-TileImage" content="../../gestor/<?php echo $configs->icons[0]->{"144"}; ?>">
        <meta name="theme-color" content="../../gestor/<?php echo $configs->themecolor; ?>">

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
            .divimgprod {
                width: 100%;
                margin: 0px;
                padding: 0px;
            }
            .imgprod {
                width: 100%;
                height: 250px;
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                background-image: url('../../gestor/img/produtos/produto-1.png');
            }
            .nomeprod {
                width: 100%;
                font-size: 1.4em;
                margin-top: 12px;
                margin-bottom: 5px;
            }
            .descprod {
                width: 100%;
                font-size: 1.0em;
                margin-bottom: 5px;
                opacity: 0.6;
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
            .btnback {
                width: 50px;
                margin: 0px;
                margin-right: 5px;
            }
            .btnadd {
                width: calc(100% - 60px);
                margin: 0px;
                margin-left: 0px;
            }
        </style>
    </head>
    <body>
        <div class="principal">
            <div class="container-md">
                <div class="row">
                    <div class="col divimgprod">
                        <div class='imgprod'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h1 class="nomeprod">Produto Teste</h1>
                    <p class="descprod">Descrição do produto com alguma coisa que o cliente queria escrever</p>
                    <h5 class="text-success"><small class="text-muted"><s>R$ 10,00</s></small> &nbsp;R$ 9,00</h5>
                    <hr>
                </div>
            </div>
        </div>

        <div class="footer">
            <button onclick="AbrirLink('../../<?php echo $emp; ?>');" type="button" class="btnback btn btn-secondary"><i class="fa-solid fa-arrow-left"></i></button>
            <button type="button" class="btnadd btn btn-primary"><i class="fa-solid fa-cart-arrow-down"></i>&nbsp; Adicionar</button>
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