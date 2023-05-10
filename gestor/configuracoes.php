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

    $cfg = $login->getConfig();
}

$container = new Container();
if (!$container->TestAcess('configuracoes')) {
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
        <title>Configurações - <?php echo $configs->name; ?></title>

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
        <script src="js/editconfig.js"></script>

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
            #myTable2_wrapper {

            }
            #myTable2_filter {
                display: none;
            }
            .card-img-top {
                width: 100%;
                height: auto;
                border-radius: 3px;
            }
            .dt-buttons {
                margin-bottom: 5px;
            }
            .conteudo .dropdown-toggle::after {
                display: none;
            }
            .lead {
                font-size: 1.0em;
            }
            .nostyle {
                text-decoration: none;
            }
            .menuconfig .nav-link{
                opacity: 0.5;
                color: #000;
                font-weight: bold;
            }
            .menuconfig .nav-link:hover {
                opacity: 1;
                color: #000;
            }
            .menuconfig .active {
                opacity: 1;
                color: #000;
            }
            .notfic {
                position: fixed;
                right: 20px;
                bottom: 5px;
                width: 200px;
            }
            .imglayout {
                width: 100%;
                border-radius: 5px;
                cursor: pointer;
                box-sizing: border-box;
                opacity: 0.7;
            }
            .layoutselected {
                border: 3px solid #28a745;
                opacity: 1.0;
            }
        </style>
        <script>
            function AbrirLink(link) {
                $('#ModalLoading').modal('show');
                window.location.href = link;
            }
            function Cancelar() {
                document.getElementById("inputEmpresa").disabled = true;
                document.getElementById("CheckMesa").disabled = true;
                document.getElementById("CheckCozinha").disabled = true;
                document.getElementById("CheckEntreg").disabled = true;
                document.getElementById("CheckIntreg").disabled = true;

                let html = "";
                html += "<br>";
                html += "<button type='button' onclick='Editar();' class='btn btn-primary'><i class='fa-solid fa-pen-to-square'></i> Editar</button>";
                document.getElementById("grid-btn").innerHTML = html;
            }
            function Salvar() {
                $('#ModalLoading').modal('show');
                document.location.reload(true);
            }
            function Editar() {
                document.getElementById("inputEmpresa").disabled = false;
                document.getElementById("CheckMesa").disabled = false;
                document.getElementById("CheckCozinha").disabled = false;
                document.getElementById("CheckEntreg").disabled = false;
                document.getElementById("CheckIntreg").disabled = false;

                let html = "";
                html += "<br>";
                html += "<button type='button' onclick='Salvar();' class='btn btn-primary me-2'><i class='fa-solid fa-floppy-disk'></i> Salvar Alterações</button>";
                html += "<button type='button' onclick='Cancelar();' class='btn btn-secondary'><i class='fa-solid fa-xmark'></i> Cancelar</button>";
                document.getElementById("grid-btn").innerHTML = html;
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
                echo $container->WriteMenu('configuracoes');
                ?>
                <hr>
                <?php
                echo $container->WriteMenuUser();
                ?>
            </div>

            <div class="conteudo">
                <h4><small><i class="bi pe-none me-2 fa-solid fa-gear text-muted"></i></small>Configurações</h4>
                <hr>
                <div class="container">
                    <ul class="nav nav-tabs menuconfig" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nostyle" href="#viewperfil"><button class="nav-link" id="perfil-tab" data-bs-toggle="tab" data-bs-target="#perfil" type="button" role="tab" aria-controls="perfil" aria-selected="false">Perfil Empresa</button></a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nostyle" href="#viewacessos"><button class="nav-link" id="acessos-tab" data-bs-toggle="tab" data-bs-target="#acessos" type="button" role="tab" aria-controls="acessos" aria-selected="false">Acessos</button></a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nostyle" href="#viewfaturas"><button class="nav-link" id="faturas-tab" data-bs-toggle="tab" data-bs-target="#faturas" type="button" role="tab" aria-controls="faturas" aria-selected="false">Faturas</button></a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nostyle" href="#viewsistema"><button class="nav-link" id="sistema-tab" data-bs-toggle="tab" data-bs-target="#sistema" type="button" role="tab" aria-controls="faturas" aria-selected="false">Sistema</button></a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade" id="perfil" role="tabpanel" aria-labelledby="perfil-tab">
                            <br>
                            <form style="max-width: 500px;">
                                <div class="col-md-6 mb-4">
                                    <label for="inputEmpresa" class="form-label"><small><i class="fa-solid fa-image text-muted"></i></small> &nbsp;<b>Logo</b></label>
                                    <img class='card-img-top' src='img/empresas/default.png' alt='Logo Empresa'>
                                    <div class="container text-center" style="margin-top: 5px;">
                                        <div class="row">
                                            <div class="col">
                                                <a href="#"><i class="fa-regular fa-image"></i> Alterar</a>
                                            </div>
                                            <div class="col">
                                                <a href="#"><i class="fa-regular fa-trash-can"></i> Remover</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="inputEmpresa" class="form-label"><small><i class="fa-solid fa-building text-muted"></i></small> &nbsp;<b>Empresa</b></label>
                                    <input type="text" class="form-control" id="inputNameEmpresa" onchange="onChange(this);" autocomplete="off" placeholder="Nome da Empresa" required value="<?php echo $_SESSION['USER']['EMPR']['NOME']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label"><small><i class="fa-solid fa-cube text-muted"></i></small> &nbsp;<b>Extensões</b></label>
                                    <div class="form-check">
                                        <?php
                                        if ($_SESSION['USER']['EMPR']['MESA']) {
                                            echo "<input class='form-check-input' type='checkbox' id='CheckMesa' onchange='onChange(this);' checked>";
                                        } else {
                                            echo "<input class='form-check-input' type='checkbox' id='CheckMesa' onchange='onChange(this);'>";
                                        }
                                        ?>
                                        <label class="form-check-label" for="CheckMesa">
                                            Controle de Mesas <small class="text-muted">(R$ 0.00)</small>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <?php
                                        if ($_SESSION['USER']['EMPR']['COZI']) {
                                            echo "<input class='form-check-input' type='checkbox' id='CheckCozinha' onchange='onChange(this);' checked>";
                                        } else {
                                            echo "<input class='form-check-input' type='checkbox' id='CheckCozinha' onchange='onChange(this);'>";
                                        }
                                        ?>
                                        <label class="form-check-label" for="CheckCozinha">
                                            Gestor de Cozinha <small class="text-muted">(R$ 0.00)</small>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <?php
                                        if ($_SESSION['USER']['EMPR']['ENTR']) {
                                            echo "<input class='form-check-input' type='checkbox' id='CheckEntreg' onchange='onChange(this);' checked>";
                                        } else {
                                            echo "<input class='form-check-input' type='checkbox' id='CheckEntreg' onchange='onChange(this);'>";
                                        }
                                        ?>
                                        <label class="form-check-label" for="CheckEntreg">
                                            Gestão de Entregadores <small class="text-muted">(R$ 0.00)</small>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <?php
                                        if ($_SESSION['USER']['EMPR']['INTG']) {
                                            echo "<input class='form-check-input' type='checkbox' id='CheckIntreg' onchange='onChange(this);' checked>";
                                        } else {
                                            echo "<input class='form-check-input' type='checkbox' id='CheckIntreg' onchange='onChange(this);'>";
                                        }
                                        ?>
                                        <label class="form-check-label" for="CheckIntreg">
                                            Integrações com outros sistemas <small class="text-muted">(R$ 0.00)</small>
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="acessos" role="tabpanel" aria-labelledby="acessos-tab">
                            <br>
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <p class="h6">Categorias de usuário</p>
                                        <div class="card">
                                            <div class="card-body">
                                                <p class="h6">CEO</p>
                                                <p class="lead m-0">Acesso completo ao sistema. Deve existir pelo menos 1 usuário nessa categoria</p>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="card">
                                            <div class="card-body">
                                                <p class="h6">Gestor(a)</p>
                                                <p class="lead m-0">Acesso quase que completo ao sistema, com exceção do menu <i>Dashboard</i></p>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="card">
                                            <div class="card-body">
                                                <p class="h6">Atendente</p>
                                                <p class="lead m-0">Acesso ao menu <i>Pedidos</i>, <i>Clientes</i> e <i>Mesas</i></p>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="card">
                                            <div class="card-body">
                                                <p class="h6">Cozinheiro(a)</p>
                                                <p class="lead m-0">Acesso ao menu <i>Cozinha</i></p>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="card">
                                            <div class="card-body">
                                                <p class="h6">Garçom/Garçonete</p>
                                                <p class="lead m-0">Acesso ao menu <i>Mesas</i></p>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="card">
                                            <div class="card-body">
                                                <p class="h6">Entregador(a)</p>
                                                <p class="lead m-0">Acesso ao <i>Portal dos Entregadores</i></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-grid">
                                                    <button type="button" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Adicionar Usuário</button>
                                                    <br>
                                                </div>
                                                <table id="myTable" class="display">
                                                    <thead>
                                                        <tr>
                                                            <th>Nome</th>
                                                            <th>Usuário</th>
                                                            <th>E-mail</th>
                                                            <th>Nivel</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Felipe</td>
                                                            <td>felipelm3g</td>
                                                            <td><small class="text-muted">felipe@hotmail.com.br</small></td>
                                                            <td><span class="badge text-bg-success">CEO</span></td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-pen-to-square text-muted"></i>Editar</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-arrows-rotate text-muted"></i>Alterar Cargo</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-regular fa-trash-can text-danger"></i>Deletar</a></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Karine Leal</td>
                                                            <td>lealk</td>
                                                            <td><small class="text-muted">karine.kay11@gmail.com</small></td>
                                                            <td><span class="badge text-bg-success">Gestor(a)</span></td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-pen-to-square text-muted"></i>Editar</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-arrows-rotate text-muted"></i>Alterar Cargo</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-regular fa-trash-can text-danger"></i>Deletar</a></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Lorena Cordeiro</td>
                                                            <td>loriscordeiro</td>
                                                            <td><small class="text-muted">lorena.cordeira_2022@gmail.com</small></td>
                                                            <td><span class="badge text-bg-secondary">Cozinheiro(a)</span></td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-pen-to-square text-muted"></i>Editar</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-arrows-rotate text-muted"></i>Alterar Cargo</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-regular fa-trash-can text-danger"></i>Deletar</a></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Luis Adriano</td>
                                                            <td>luisadriano</td>
                                                            <td><small class="text-muted">luisadriano12@gmail.com</small></td>
                                                            <td><span class="badge text-bg-secondary">Entregador(a)</span></td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-pen-to-square text-muted"></i>Editar</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-arrows-rotate text-muted"></i>Alterar Cargo</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-regular fa-trash-can text-danger"></i>Deletar</a></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Ana Paula</td>
                                                            <td>Paulinha93</td>
                                                            <td><small class="text-muted">ana.paula93@gmail.com</small></td>
                                                            <td><span class="badge text-bg-secondary">Atendente</span></td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-pen-to-square text-muted"></i>Editar</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-arrows-rotate text-muted"></i>Alterar Cargo</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-regular fa-trash-can text-danger"></i>Deletar</a></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>João Gomes</td>
                                                            <td>joaozinho91</td>
                                                            <td><small class="text-muted">joao_gomes@hotmail.com.br</small></td>
                                                            <td><span class="badge text-bg-secondary">Garçom/Garçonete</span></td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-pen-to-square text-muted"></i>Editar</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-solid fa-arrows-rotate text-muted"></i>Alterar Cargo</a></li>
                                                                        <li><a class="dropdown-item" href="#"><i class="bi pe-none me-2 fa-regular fa-trash-can text-danger"></i>Deletar</a></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Nome</th>
                                                            <th>Usuário</th>
                                                            <th>E-mail</th>
                                                            <th>Nivel</th>
                                                            <th></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="faturas" role="tabpanel" aria-labelledby="faturas-tab">
                            <br>
                            <table id="myTable2" class="display">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Ref</th>
                                        <th>Descrição</th>
                                        <th>Status</th>
                                        <th>Valor</th>
                                        <th>Desc</th>
                                        <th>Total</th>
                                        <th>Link</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>22050317171</th>
                                        <td>05/2023</td>
                                        <td>Mensalidade Plano 2</td>
                                        <td><span class="badge text-bg-secondary">Em dia</span></td>
                                        <td>R$ 49.00</td>
                                        <td class="text-muted"><s>R$ 0.00</s></td>
                                        <th class="text-success">R$ 49.00</th>
                                        <td><button type="button" class="btn btn-secondary btn-sm"><i class="fa-solid fa-hand-holding-dollar"></i>&nbsp;Pagar</button></td>
                                    </tr>
                                    <tr>
                                        <th>220503171712</th>
                                        <td>04/2023</td>
                                        <td>Mensalidade Plano 2</td>
                                        <td><span class="badge text-bg-danger">Atrasado</span></td>
                                        <td>R$ 49.00</td>
                                        <td class="text-muted"><s>R$ 0.00</s></td>
                                        <th class="text-success">R$ 49.00</th>
                                        <td><button type="button" class="btn btn-danger btn-sm"><i class="fa-solid fa-hand-holding-dollar"></i>&nbsp;Pagar</button></td>
                                    </tr>
                                    <tr class="text-muted">
                                        <th>220503171713</th>
                                        <td>03/2023</td>
                                        <td>Mensalidade Plano 2</td>
                                        <td></td>
                                        <td>R$ 49.00</td>
                                        <td><s>R$ 0.00</s></td>
                                        <th>R$ 49.00</th>
                                        <td><span class="badge text-bg-success">Pago</span></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Código</th>
                                        <th>Ref</th>
                                        <th>Descrição</th>
                                        <th>Status</th>
                                        <th>Valor</th>
                                        <th>Desc</th>
                                        <th>Total</th>
                                        <th>Link</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="sistema" role="tabpanel" aria-labelledby="sistema-tab">
                            <br>
                            <p><b>Cardápio</b></p>
                            <hr>
                            <div class="row">
                                <label for="InputNome" class="form-label"><small>Layout Banner</small></label>
                                <div class="row" style="max-width: 600px;">
                                    <?php
                                    if ($cfg['CFG_LTCD'] == 0) {
                                        echo "<div class='col'>";
                                        echo "<img class='imglayout layoutselected' src='img/layout/1.png' alt='Layout 1' />";
                                        echo "</div>";
                                        echo "<div class='col'>";
                                        echo "<img onclick='AbrirLink(\"form/editlayout.php?lyt=1\");' class='imglayout' src='img/layout/2.png' alt='Layout 2' />";
                                        echo "</div>";
                                    }
                                    if ($cfg['CFG_LTCD'] == 1) {
                                        echo "<div class='col'>";
                                        echo "<img onclick='AbrirLink(\"form/editlayout.php?lyt=0\");' class='imglayout' src='img/layout/1.png' alt='Layout 1' />";
                                        echo "</div>";
                                        echo "<div class='col'>";
                                        echo "<img class='imglayout layoutselected' src='img/layout/2.png' alt='Layout 2' />";
                                        echo "</div>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <br>
                            <p><b>Clientes</b></p>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="InputNome" class="form-label"><small>Exibição lista de clientes</small></label>
                                    <select class="form-select" id="configviewcliente" onchange="onChange(this);">
                                        <?php
                                        switch ($cfg['CFG_CEXB']) {
                                            case 0:
                                                echo "<option value='0' selected>Somente Endereço</option>";
                                                echo "<option value='1'>Endereço e Bairro</option>";
                                                echo "<option value='2'>Endereço, Bairro e Cidade</option>";
                                                echo "<option value='3'>Endereço, Bairro, Cidade e UF</option>";
                                                break;
                                            case 1:
                                                echo "<option value='0'>Somente Endereço</option>";
                                                echo "<option value='1' selected>Endereço e Bairro</option>";
                                                echo "<option value='2'>Endereço, Bairro e Cidade</option>";
                                                echo "<option value='3'>Endereço, Bairro, Cidade e UF</option>";
                                                break;
                                            case 2:
                                                echo "<option value='0'>Somente Endereço</option>";
                                                echo "<option value='1'>Endereço e Bairro</option>";
                                                echo "<option value='2' selected>Endereço, Bairro e Cidade</option>";
                                                echo "<option value='3'>Endereço, Bairro, Cidade e UF</option>";
                                                break;
                                            case 3:
                                                echo "<option value='0'>Somente Endereço</option>";
                                                echo "<option value='1'>Endereço e Bairro</option>";
                                                echo "<option value='2'>Endereço, Bairro e Cidade</option>";
                                                echo "<option value='3' selected>Endereço, Bairro, Cidade e UF</option>";
                                                break;
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Notificações -->
        <div class="notfic" id="notfic">
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

        <script type="text/javascript">
            // recupera o fragmento da URL
            var hash = window.location.hash;

            // se o hash corresponde a uma guia, ative-a
            if (hash === '#viewacessos') {
                document.getElementById('acessos-tab').classList.add('active');
                document.getElementById('acessos').classList.add('active', 'show');
            } else if (hash === '#viewfaturas') {
                document.getElementById('faturas-tab').classList.add('active');
                document.getElementById('faturas').classList.add('active', 'show');
            } else if (hash === '#viewsistema') {
                document.getElementById('sistema-tab').classList.add('active');
                document.getElementById('sistema').classList.add('active', 'show');
            } else {
                document.getElementById('perfil-tab').classList.add('active');
                document.getElementById('perfil').classList.add('active', 'show');
                window.location.hash = '#viewperfil';
            }
        </script>

        <script src="js/datatables_sembtns.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>
    </body>
</html>