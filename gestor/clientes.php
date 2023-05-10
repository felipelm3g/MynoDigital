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

    $cfg = $login->getConfig();
}

$container = new Container();
if (!$container->TestAcess('clientes')) {
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
        <title>Clientes - <?php echo $configs->name; ?></title>

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
        <script src="js/criarcliente.js"></script>

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
            .listdetal {
                list-style: none;
                margin-top: 5px;
            }
        </style>
        <script>

            function BtnNovo() {
                $('#ModalCriarCliente').modal('show');
                LimparFormNewCli();
            }
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
                echo $container->WriteMenu('clientes');
                ?>
                <hr>
                <?php
                echo $container->WriteMenuUser();
                ?>
            </div>

            <div class="conteudo">
                <h4><small><i class="bi pe-none me-2 fa-solid fa-user text-muted"></i></small>Clientes</h4>
                <hr>
                <table id="myTable" class="display">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <?php
                            switch ($cfg['CFG_CEXB']) {
                                case 0:
                                    echo "<th>Endereço</th>";
                                    break;
                                case 1:
                                    echo "<th>Endereço</th>";
                                    echo "<th>Bairro</th>";
                                    break;
                                case 2:
                                    echo "<th>Endereço</th>";
                                    echo "<th>Bairro</th>";
                                    echo "<th>Cidade</th>";
                                    break;
                                case 3:
                                    echo "<th>Endereço</th>";
                                    echo "<th>Bairro</th>";
                                    echo "<th>Cidade</th>";
                                    echo "<th>UF</th>";
                                    break;
                            }
                            ?>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $clientes = [];

                        $codigoemp = $_SESSION['USER']['EMPR']['CODG'];

                        $conn = Database::conectar();

                        $consulta = $conn->query("SELECT * FROM T_CLIENTE WHERE CLI_CODE = '{$codigoemp}';");
                        while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                            $clientes[] = $linha;
                        }

                        $conn = Database::desconectar();

                        $format = new Formatacoes();

                        $cnt = 0;
                        foreach ($clientes as $c) {
                            $cnt++;
                            echo "<tr>";
                            echo "<th>" . $cnt . ".</th>";
                            echo "<th><a href='cliente/" . $c['CLI_CODG'] . "'>" . $c['CLI_CODG'] . "</a></th>";
                            echo "<td>" . $c['CLI_NOME'] . "</td>";
                            echo "<td>" . $format->formartTel($c['CLI_TELF']) . "</td>";

                            switch ($cfg['CFG_CEXB']) {
                                case 0:
                                    if (!empty($c['CLI_ADRS']) && !empty($c['CLI_NUMB'])) {

                                        if (empty($c['CLI_CPLT'])) {
                                            echo "<td><a target='_blank' href='https://www.google.com.br/maps/search/" . $c['CLI_ADRS'] . ", " . $c['CLI_NUMB'] . " - " . $c['CLI_CITY'] . "'><small>" . $c['CLI_ADRS'] . ", " . $c['CLI_NUMB'] . "</small></a></td>";
                                        } else {
                                            echo "<td><a target='_blank' href='https://www.google.com.br/maps/search/" . $c['CLI_ADRS'] . ", " . $c['CLI_NUMB'] . " - " . $c['CLI_CITY'] . "'><small>" . $c['CLI_ADRS'] . ", " . $c['CLI_NUMB'] . " - " . $c['CLI_CPLT'] . "</small></a></td>";
                                        }
                                    } else {
                                        echo "<td></td>";
                                    }
                                    break;
                                case 1:
                                    if (!empty($c['CLI_ADRS']) && !empty($c['CLI_NUMB'])) {

                                        if (empty($c['CLI_CPLT'])) {
                                            echo "<td><a target='_blank' href='https://www.google.com.br/maps/search/" . $c['CLI_ADRS'] . ", " . $c['CLI_NUMB'] . " - " . $c['CLI_CITY'] . "'><small>" . $c['CLI_ADRS'] . ", " . $c['CLI_NUMB'] . "</small></a></td>";
                                        } else {
                                            echo "<td><a target='_blank' href='https://www.google.com.br/maps/search/" . $c['CLI_ADRS'] . ", " . $c['CLI_NUMB'] . " - " . $c['CLI_CITY'] . "'><small>" . $c['CLI_ADRS'] . ", " . $c['CLI_NUMB'] . " - " . $c['CLI_CPLT'] . "</small></a></td>";
                                        }
                                    } else {
                                        echo "<td></td>";
                                    }
                                    echo "<td>" . $c['CLI_BAIR'] . "</td>";
                                    break;
                                case 2:
                                    if (!empty($c['CLI_ADRS']) && !empty($c['CLI_NUMB'])) {

                                        if (empty($c['CLI_CPLT'])) {
                                            echo "<td><a target='_blank' href='https://www.google.com.br/maps/search/" . $c['CLI_ADRS'] . ", " . $c['CLI_NUMB'] . " - " . $c['CLI_CITY'] . "'><small>" . $c['CLI_ADRS'] . ", " . $c['CLI_NUMB'] . "</small></a></td>";
                                        } else {
                                            echo "<td><a target='_blank' href='https://www.google.com.br/maps/search/" . $c['CLI_ADRS'] . ", " . $c['CLI_NUMB'] . " - " . $c['CLI_CITY'] . "'><small>" . $c['CLI_ADRS'] . ", " . $c['CLI_NUMB'] . " - " . $c['CLI_CPLT'] . "</small></a></td>";
                                        }
                                    } else {
                                        echo "<td></td>";
                                    }
                                    echo "<td>" . $c['CLI_BAIR'] . "</td>";
                                    echo "<td>" . $c['CLI_CITY'] . "</td>";
                                    break;
                                case 3:
                                    if (!empty($c['CLI_ADRS']) && !empty($c['CLI_NUMB'])) {

                                        if (empty($c['CLI_CPLT'])) {
                                            echo "<td><a target='_blank' href='https://www.google.com.br/maps/search/" . $c['CLI_ADRS'] . ", " . $c['CLI_NUMB'] . " - " . $c['CLI_CITY'] . "'><small>" . $c['CLI_ADRS'] . ", " . $c['CLI_NUMB'] . "</small></a></td>";
                                        } else {
                                            echo "<td><a target='_blank' href='https://www.google.com.br/maps/search/" . $c['CLI_ADRS'] . ", " . $c['CLI_NUMB'] . " - " . $c['CLI_CITY'] . "'><small>" . $c['CLI_ADRS'] . ", " . $c['CLI_NUMB'] . " - " . $c['CLI_CPLT'] . "</small></a></td>";
                                        }
                                    } else {
                                        echo "<td></td>";
                                    }
                                    echo "<td>" . $c['CLI_BAIR'] . "</td>";
                                    echo "<td>" . $c['CLI_CITY'] . "</td>";
                                    echo "<td>" . $c['CLI_ESTD'] . "</td>";
                                    break;
                            }

                            echo "<td>";
                            echo "<div class='dropdown'>";
                            echo "<button class='btn btn-secondary dropdown-toggle btn-sm' type='button' data-bs-toggle='dropdown' aria-expanded='false'>";
                            echo "<i class='fa-solid fa-ellipsis-vertical'></i>";
                            echo "</button>";
                            echo "<ul class='dropdown-menu'>";
                            echo "<li><a class='dropdown-item' href='cliente/" . $c['CLI_CODG'] . "'><i class='bi pe-none me-2 fa-solid fa-eye text-muted'></i>Ver</a></li>";
                            echo "<li><a class='dropdown-item' href='#'><i class='bi pe-none me-2 fa-solid fa-file text-muted'></i>Criar pedido</a></li>";
                            echo "<li><a class='dropdown-item' href='#'><i class='bi pe-none me-2 fa-regular fa-trash-can text-danger'></i>Deletar</a></li>";
                            echo "</ul>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
<!--                        <tr>
                            <th>1.</th>
                            <th><a href="cliente">220503171711</a></th>
                            <td>Felipe Lopes</td>
                            <td>+55 (85) 9 8820-6336</td>
                            <td>Rua nossa senhora aparecida, 730 - Casa 26</td>
                            <td>Urucunema</td>
                            <td>Eusebio</td>
                            <td>CE</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="cliente"><i class="bi pe-none me-2 fa-solid fa-eye text-muted"></i>Ver</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-file text-muted"></i>Criar pedido</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-regular fa-trash-can text-danger"></i>Deletar</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>-->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <?php
                            switch ($cfg['CFG_CEXB']) {
                                case 0:
                                    echo "<th>Endereço</th>";
                                    break;
                                case 1:
                                    echo "<th>Endereço</th>";
                                    echo "<th>Bairro</th>";
                                    break;
                                case 2:
                                    echo "<th>Endereço</th>";
                                    echo "<th>Bairro</th>";
                                    echo "<th>Cidade</th>";
                                    break;
                                case 3:
                                    echo "<th>Endereço</th>";
                                    echo "<th>Bairro</th>";
                                    echo "<th>Cidade</th>";
                                    echo "<th>UF</th>";
                                    break;
                            }
                            ?>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </main>

        <!-- Modal Cliente -->
        <div class="modal fade" id="ModalCriarCliente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar novo cliente</h1>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md mb-2">
                                    <label for="InputNome" class="form-label form-label-sm">Nome</label>
                                    <input type="text" class="form-control form-control-sm" oninput="onInput(this);" onchange="onChange(this);" id="InputNome" value="">
                                    <div id="ValidInputNome" class="invalid-feedback">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="InputTelefone" class="form-label form-label-sm">Telefone</label>
                                    <input type="text" class="form-control form-control-sm" oninput="onInput(this);" onchange="onChange(this);" id="InputTelefone" value="">
                                    <div id="ValidInputTelefone" class="invalid-feedback">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <label for="InputCep" class="form-label form-label-sm">CEP</label>
                                    <input type="text" class="form-control form-control-sm" maxlength="9" oninput="onInput(this);" onchange="onChange(this);" id="InputCep" value="">
                                    <div id="ValidInputCep" class="invalid-feedback">
                                    </div>
                                </div>
                                <div class="col-md mb-2">
                                    <hr style="margin-top: 45px;margin-bottom: 0px;">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md mb-2">
                                    <label for="InputRua" class="form-label form-label-sm">Rua</label>
                                    <input type="text" class="form-control form-control-sm" id="InputRua" oninput="onInput(this);" onchange="onChange(this);" value="">
                                    <div id="ValidInputRua" class="invalid-feedback">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <label for="InputNumb" class="form-label form-label-sm">Numero</label>
                                    <input type="text" class="form-control form-control-sm" id="InputNumb" oninput="onInput(this);" onchange="onChange(this);" value="">
                                    <div id="ValidInputNumb" class="invalid-feedback">
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label for="InputComplt" class="form-label form-label-sm">Complemento</label>
                                    <input type="text" class="form-control form-control-sm" id="InputComplt" oninput="onInput(this);" onchange="onChange(this);" value="">
                                    <div id="ValidInputComplt" class="invalid-feedback">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <label for="InputRef" class="form-label form-label-sm">Ponto de referência</label>
                                    <input type="text" class="form-control form-control-sm" id="InputRef" oninput="onInput(this);" onchange="onChange(this);" value="">
                                    <div id="ValidInputRef" class="invalid-feedback">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="InputBairro" class="form-label form-label-sm">Bairro</label>
                                    <input type="text" class="form-control form-control-sm" id="InputBairro" oninput="onInput(this);" onchange="onChange(this);" value="">
                                    <div id="ValidInputBairro" class="invalid-feedback">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="InputCity" class="form-label form-label-sm">Cidade</label>
                                    <input type="text" class="form-control form-control-sm" id="InputCity" oninput="onInput(this);" onchange="onChange(this);" value="">
                                    <div id="ValidInputCity" class="invalid-feedback">
                                    </div>
                                </div>
                                <div class="col-md-1 mb-2">
                                    <label for="InputUf" class="form-label form-label-sm">UF</label>
                                    <input type="text" maxlength="2" class="form-control form-control-sm" id="InputUf" oninput="onInput(this);" onchange="onChange(this);" value="">
                                    <div id="ValidInputUf" class="invalid-feedback">
                                    </div>
                                </div>
                                <ul class="listdetal">
                                    <li><small class="text-muted">Para maior precisão, preencha os dados do cliente usando CEP</small></li>
                                </ul>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="CriarCliente();" class="btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i> Salvar</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cancelar</button>
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

        <script src="js/datatables.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
    </body>
</html>