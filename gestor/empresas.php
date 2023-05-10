<?php
$configs = file_get_contents("../configs.json");
$configs = json_decode($configs);

date_default_timezone_set('America/Fortaleza');
session_start();
if (!isset($_SESSION['USER'])) {
    session_destroy();
    header("Location: index");
    exit;
}

require_once "../class/Database.php";

$empresas = [];

$conn = Database::conectar();
$sql = "SELECT * FROM T_ACESSO AS A INNER JOIN T_EMPRESAS AS B ON A.ACC_CODE = B.EMP_CODG WHERE A.ACC_CODU = {$_SESSION['USER']['CODG']};";
$stmt = $conn->query($sql);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $empresas[] = $row;
}
$conn = Database::desconectar();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Empresas - <?php echo $configs->name; ?></title>

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
        <style>
            .btnhid {
                opacity: 0.6;
            }
            .btnhid:hover {
                opacity: 1;
            }
        </style>
        <script>
            function SelectEmp(){
                let emp = document.getElementById("SelectEmpresa").value;
                AbrirLink("form/atribuirempresa.php?cod=" + emp);
            }
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
                            <?php
                            if (!empty($empresas)) {
                                echo "<h5 class='card-title text-center mb-4'>Selecione a Empresa</h5>";
                                echo "<form>";
                                echo "<div class='mb-3'>";
                                echo "<label for='inputEmpresa' class='form-label'><small><i class='fa-solid fa-building text-muted'></i></small> &nbsp;<b>Empresa</b></label>";
                                echo "<select id='SelectEmpresa' class='form-select'>";
                                echo "<option value='0' disabled='' selected=''>Selecione a empresa aqui...</option>";
                                foreach ($empresas as $e) {
                                    echo "<option value='" . $e['EMP_CODG'] . "'>" . $e['EMP_NOME'] . "</option>";
                                }
                                echo "</select>";
                                echo "</div>";
                                echo "<div class='d-grid'>";
                                echo "<button type='button' onclick='SelectEmp();' class='btn btn-primary mb-2'>Selecionar Empresa</button>";
                                echo "<button type='button' class='btnhid btn btn-secondary btn-sm'>Criar Nova Empresa</button>";
                                echo "</div>";
                                echo "</form>";
                            } else {
                                echo "<h5 class='card-title text-center mb-4'>Crie uma Empresa</h5>";
                                echo "<form>";
                                echo "<div class='d-grid'>";
                                echo "<button type='button' class='btn btn-secondary'>Criar Nova Empresa</button>";
                                echo "</div>";
                                echo "</form>";
                            }
                            ?>

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
