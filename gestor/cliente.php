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

    require_once "../class/Database.php";
    require_once "../class/Formatacoes.php";
    require_once "../class/Login.php";
    require_once "../class/Container.php";

    $login = new Login();
    $login->RefreshLogin();
}

$cod = "";
if (!isset($_GET['cod'])) {
    header("Location: clientes");
    exit();
} else {
    if (empty($_GET['cod'])) {
        header("Location: ../clientes");
        exit();
    }
}
$cod = $_GET['cod'];

$conn = Database::conectar();
$sql = "SELECT * FROM T_CLIENTE WHERE CLI_CODG = '{$cod}';";
$stmt = $conn->query($sql);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);
$conn = Database::desconectar();

if (empty($cliente)) {
    header("Location: clientes");
    exit();
}

$format = new Formatacoes();

$container = new Container();
if (!$container->TestAcess('clientes')) {
    header("Location: ../index");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title><?php echo $cliente['CLI_NOME'] . " - " . $configs->name; ?></title>

        <link rel="apple-touch-icon" sizes="57x57" href="../<?php echo $configs->icons[0]->{"57"}; ?>">
        <link rel="apple-touch-icon" sizes="60x60" href="../<?php echo $configs->icons[0]->{"60"}; ?>">
        <link rel="apple-touch-icon" sizes="72x72" href="../<?php echo $configs->icons[0]->{"72"}; ?>">
        <link rel="apple-touch-icon" sizes="76x76" href="../<?php echo $configs->icons[0]->{"76"}; ?>">
        <link rel="apple-touch-icon" sizes="114x114" href="../<?php echo $configs->icons[0]->{"114"}; ?>">
        <link rel="apple-touch-icon" sizes="120x120" href="../<?php echo $configs->icons[0]->{"120"}; ?>">
        <link rel="apple-touch-icon" sizes="144x144" href="../<?php echo $configs->icons[0]->{"144"}; ?>">
        <link rel="apple-touch-icon" sizes="152x152" href="../<?php echo $configs->icons[0]->{"152"}; ?>">
        <link rel="apple-touch-icon" sizes="180x180" href="../<?php echo $configs->icons[0]->{"180"}; ?>">
        <link rel="icon" type="image/png" sizes="192x192"  href="../<?php echo $configs->icons[0]->{"192"}; ?>">
        <link rel="icon" type="image/png" sizes="32x32" href="../<?php echo $configs->icons[0]->{"32"}; ?>">
        <link rel="icon" type="image/png" sizes="96x96" href="../<?php echo $configs->icons[0]->{"96"}; ?>">
        <link rel="icon" type="image/png" sizes="16x16" href="../<?php echo $configs->icons[0]->{"16"}; ?>">
        <link rel="manifest" href="../<?php echo $configs->manifest; ?>">
        <meta name="msapplication-TileColor" content="../<?php echo $configs->themecolor; ?>">
        <meta name="msapplication-TileImage" content="../<?php echo $configs->icons[0]->{"144"}; ?>">
        <meta name="theme-color" content="../<?php echo $configs->themecolor; ?>">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="../css/main.css">
        <script src="../js/windowmsg.js"></script>
        <script src="../js/editarcliente.js"></script>

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
                display: none;
            }
            .dt-buttons {
                margin-bottom: 5px;
            }
            .conteudo .dropdown-toggle::after {
                display: none;
            }
            .row {
                margin-bottom: 10px;
            }
        </style>
        <script>
            const codcliente = "<?php echo $cliente['CLI_CODG']; ?>";
            function AbrirLink(link) {
                $('#ModalLoading').modal('show');
                window.location.href = link;
            }
        </script>
    </head>
    <body onload="Inicializacao();">

        <main class="principal">
            <div class="p-3 text-bg-dark menulateral">
                <a href="main" class="d-flex align-items-center mb-3 mb-md-0 w-100 me-md-auto text-white text-decoration-none">
                    <span class="fs-4"><i class="fa-sharp fa-solid fa-utensils text-primary"></i> &nbsp;&nbsp; <?php echo $configs->name; ?></span> 
                </a>
                <hr>
                <?php
                echo $container->WriteMenu('clientes', '../');
                ?>
                <hr>
                <?php
                echo $container->WriteMenuUser('../');
                ?>
            </div>

            <div class="conteudo">
                <?php
                $btnwpp = "";
                if (!empty($cliente['CLI_TELF'])) {
                    $btnwpp = "<a href='https://api.whatsapp.com/send/?phone=55" . $format->converterTel($cliente['CLI_TELF']) . "' target='_blank' class='btn btn-success btn-sm float-end me-2'><i class='fa-brands fa-whatsapp'></i></a>";
                }
                $btnmaps = "";
                if (!empty($cliente['CLI_ADRS']) && !empty($cliente['CLI_NUMB'])) {
                    $btnmaps = "<a href='https://www.google.com.br/maps/search/" . $cliente['CLI_ADRS'] . ', ' . $cliente['CLI_NUMB'] . ' - ' . $cliente['CLI_CITY'] . "' target='_blank' class='btn btn-danger btn-sm float-end me-2'><i class='fa-solid fa-location-dot'></i></a>";
                }
                ?>
                <h4><small><i class="bi pe-none me-2 fa-solid fa-user text-muted"></i></small>Cadastro do Cliente <small class="text-muted">(#<?php echo $cliente['CLI_CODG']; ?>)</small><button onclick="Editar(this);" class="btn btn-secondary btn-sm float-end me-2"><i class="fa-solid fa-pen-to-square"></i> &nbsp;Editar</button><font id="btnsalvar"></font><?php echo $btnmaps . $btnwpp; ?></h4>
                <hr>
                <form>
                    <div class="row">
                        <div class="col-md">
                            <label for="InputNome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="InputNome" oninput="onInput(this);" onchange="onChange(this);" disabled="true" value="<?php echo $cliente['CLI_NOME']; ?>">
                            <div id="ValidInputNome" class="invalid-feedback">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="InputTelefone" class="form-label">Telefone <small class="text-muted">(WhatsApp)</small></label>
                            <?php
                            $telefone = $format->formartTel($cliente['CLI_TELF']);
                            ?>
                            <input type="text" class="form-control" id="InputTelefone" oninput="onInput(this);" onchange="onChange(this);" disabled="true" value="<?php echo $telefone; ?>">
                            <div id="ValidInputTelefone" class="invalid-feedback">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Fidelidade</label>
                            <input type="text" class="form-control" value="0" disabled="true">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Saldo <small class="text-muted">(CashBack)</small></label>
                            <div class="input-group">
                                <?php
                                if ($cliente['CLI_WALT'] > 0) {
                                    echo "<span style='font-weight: bold;' class='input-group-text text-success'>R$</span>";
                                    echo "<input type='text' style='font-weight: bold;' class='form-control text-success' disabled='true' value='" . $cliente['CLI_WALT'] . "'>";
                                } else {
                                    echo "<span class='input-group-text'>R$</span>";
                                    echo "<input type='text' class='form-control' disabled='true' value='" . $cliente['CLI_WALT'] . "'>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <label for="InputRua" class="form-label">Rua <small class="text-muted">(Sem abreviações)</small></label>
                            <input type="text" class="form-control" id="InputRua" oninput="onInput(this);" onchange="onChange(this);" disabled="true" value="<?php echo $cliente['CLI_ADRS']; ?>">
                            <div id="ValidInputRua" class="invalid-feedback">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="InputNumb" class="form-label">Numero</label>
                            <input type="text" class="form-control" id="InputNumb" oninput="onInput(this);" onchange="onChange(this);" disabled="true" value="<?php echo $cliente['CLI_NUMB']; ?>">
                            <div id="ValidInputNumb" class="invalid-feedback">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="InputComplt" class="form-label">Complemento</label>
                            <input type="text" class="form-control" id="InputComplt" oninput="onInput(this);" onchange="onChange(this);" disabled="true" value="<?php echo $cliente['CLI_CPLT']; ?>">
                            <div id="ValidInputComplt" class="invalid-feedback">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="InputRef" class="form-label">Ponto de referência</label>
                            <input type="text" class="form-control" id="InputRef" oninput="onInput(this);" onchange="onChange(this);" disabled="true" value="<?php echo $cliente['CLI_REFR']; ?>">
                            <div id="ValidInputRef" class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="InputBairro" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="InputBairro" oninput="onInput(this);" onchange="onChange(this);" disabled="true" value="<?php echo $cliente['CLI_BAIR']; ?>">
                            <div id="ValidInputBairro" class="invalid-feedback">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="InputCity" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="InputCity" oninput="onInput(this);" onchange="onChange(this);" disabled="true" value="<?php echo $cliente['CLI_CITY']; ?>">
                            <div id="ValidInputCity" class="invalid-feedback">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="InputUf" class="form-label">UF</label>
                            <input type="text" class="form-control" id="InputUf" oninput="onInput(this);" onchange="onChange(this);" disabled="true" value="<?php echo $cliente['CLI_ESTD']; ?>">
                            <div id="ValidInputUf" class="invalid-feedback">
                            </div>
                        </div>
                        <div class="col-md">
                            <?php
                            $cep = "";
                            if (intval($cliente['CLI_NCEP']) > 0) {
                                $cep = $format->formartCep($cliente['CLI_NCEP']);
                            }
                            ?>
                            <label for="InputCep" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="InputCep" oninput="onInput(this);" onchange="onChange(this);" disabled="true" value="<?php echo $cep; ?>">
                            <div id="ValidInputCep" class="invalid-feedback">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Rate</label>
                            <div class="input-group" style="min-height: 38px;">

                                <?php
                                $rate = $cliente['CLI_RATE'];
                                if ($rate > 0) {
                                    $rate = $rate / 2;
                                    $rate = number_format($rate, 2);
                                }
                                echo "<span title='" . $rate . "' class='input-group-text'>";
                                for ($i = 0; $i < 5; $i++) {
                                    if ($i < intval($rate)) {
                                        echo "<i class='fa-solid fa-star text-warning'></i>";
                                    } else {
                                        echo "<i class='fa-solid fa-star text-muted'></i>";
                                    }
                                }
                                echo "</span>";
                                ?>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <hr>
                <table id="myTable" class="display">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Pedido</th>
                            <th>Origem</th>
                            <th>Status</th>
                            <th>Valor</th>
                            <th>Acréscimos</th>
                            <th>Descontos</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>1.</th>
                            <th><a href="#">220503171711</a></th>
                            <td>Menu Digital</td>
                            <td><span class="badge text-bg-primary">Novo</span></td>
                            <td>R$ 45.00</td>
                            <td class="text-success">+R$ 5.00</td>
                            <td class="text-danger">-R$ 0.00</td>
                            <th>R$ 50.00</th>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-pen-to-square text-muted"></i>Editar</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-file text-muted"></i>Criar pedido</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-regular fa-trash-can text-danger"></i>Deletar</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Pedido</th>
                            <th>Origem</th>
                            <th>Status</th>
                            <th>Valor</th>
                            <th>Acréscimos</th>
                            <th>Descontos</th>
                            <th>Total</th>
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

        <script src="../js/datatables_sembtns.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
    </body>
</html>