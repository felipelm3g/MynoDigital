<?php

class Container {

    public function __construct() {
        
    }

    public function TestAcess($pag) {

        $return = false;

        switch ($pag) {
            case "main":
                if (intval($_SESSION['USER']['EMPR']['NIVL']) == 0) {
                    $return = true;
                }
                break;

            case "pedidos":
                if (intval($_SESSION['USER']['EMPR']['NIVL']) == 0 ||
                        intval($_SESSION['USER']['EMPR']['NIVL']) == 1 ||
                        intval($_SESSION['USER']['EMPR']['NIVL']) == 2) {
                    $return = true;
                }
                break;

            case "mesas":
                if (intval($_SESSION['USER']['EMPR']['NIVL']) == 0 ||
                        intval($_SESSION['USER']['EMPR']['NIVL']) == 1 ||
                        intval($_SESSION['USER']['EMPR']['NIVL']) == 4) {
                    $return = true;
                }
                break;

            case "cozinha":
                if (intval($_SESSION['USER']['EMPR']['NIVL']) == 0 ||
                        intval($_SESSION['USER']['EMPR']['NIVL']) == 1 ||
                        intval($_SESSION['USER']['EMPR']['NIVL']) == 3) {
                    $return = true;
                }
                break;

            case "clientes":
                if (intval($_SESSION['USER']['EMPR']['NIVL']) == 0 ||
                        intval($_SESSION['USER']['EMPR']['NIVL']) == 1 ||
                        intval($_SESSION['USER']['EMPR']['NIVL']) == 2) {
                    $return = true;
                }
                break;

            case "produtos":
                if (intval($_SESSION['USER']['EMPR']['NIVL']) == 0 ||
                        intval($_SESSION['USER']['EMPR']['NIVL']) == 1) {
                    $return = true;
                }
                break;

            case "promos":
                if (intval($_SESSION['USER']['EMPR']['NIVL']) == 0 ||
                        intval($_SESSION['USER']['EMPR']['NIVL']) == 1) {
                    $return = true;
                }
                break;

            case "entregadores":
                if (intval($_SESSION['USER']['EMPR']['NIVL']) == 0 ||
                        intval($_SESSION['USER']['EMPR']['NIVL']) == 1) {
                    $return = true;
                }
                break;

            case "avaliacoes":
                if (intval($_SESSION['USER']['EMPR']['NIVL']) == 0 ||
                        intval($_SESSION['USER']['EMPR']['NIVL']) == 1) {
                    $return = true;
                }
                break;

            case "integracoes":
                if (intval($_SESSION['USER']['EMPR']['NIVL']) == 0 ||
                        intval($_SESSION['USER']['EMPR']['NIVL']) == 1) {
                    $return = true;
                }
                break;

            case "profile":
                $return = true;
                break;

            case "configuracoes":
                if (intval($_SESSION['USER']['EMPR']['NIVL']) == 0) {
                    $return = true;
                }
                break;
        }
        return $return;
    }

    public function WriteMenu($pag, $back = "") {
        $html = "";
        $html = $html . "<ul class='listopc nav nav-pills flex-column mb-auto'>";

        ///Relatorios - Acesso e Visualazição:
        //CEO
        if ($pag == "main") {
            $html = $html . "<li class='nav-item'><a onclick=\"AbrirLink('" . $back . "main');\" class='nav-link active'><i class='bi pe-none me-2 fa-solid fa-chart-pie'></i>Dashboard</a></li>";
        } else {
            if (intval($_SESSION['USER']['EMPR']['NIVL']) == 0) {
                $html = $html . "<li class='nav-item'><a onclick=\"AbrirLink('" . $back . "main');\" class='nav-link text-white'><i class='bi pe-none me-2 fa-solid fa-chart-pie'></i>Dashboard</a></li>";
            } else {
                $html = $html . "<li class='nav-item disabled'><a class='nav-link text-muted'><i class='bi pe-none me-2 fa-solid fa-chart-pie'></i>Dashboard</a></li>";
            }
        }

        //Pedidos - Acesso e Visualazição:
        //CEO
        //Gestor(a)
        //Atendente
        if ($pag == "pedidos") {
            $html = $html . "<li class='nav-item'><a onclick=\"AbrirLink('" . $back . "pedidos');\" class='nav-link active'><i class='bi pe-none me-2 fa-solid fa-note-sticky'></i> Pedidos</a></li>";
        } else {
            if (intval($_SESSION['USER']['EMPR']['NIVL']) == 0 ||
                    intval($_SESSION['USER']['EMPR']['NIVL']) == 1 ||
                    intval($_SESSION['USER']['EMPR']['NIVL']) == 2) {
                $html = $html . "<li class='nav-item'><a onclick=\"AbrirLink('" . $back . "pedidos');\" class='nav-link text-white'><i class='bi pe-none me-2 fa-solid fa-note-sticky'></i> Pedidos <small><span class='badge text-bg-danger'>4</span></small></a></li>";
            } else {
                $html = $html . "<li class='nav-item disabled'><a class='nav-link text-muted'><i class='bi pe-none me-2 fa-solid fa-note-sticky'></i> Pedidos</a></li>";
            }
        }

        //Mesa - Acesso e Visualazição:
        //CEO
        //Gestor(a)
        //Garçom
        if ($_SESSION['USER']['EMPR']['MESA']) {
            if ($pag == "mesas") {
                $html = $html . "<li class='nav-item'><a onclick=\"AbrirLink('" . $back . "mesas');\" class='nav-link active'><i class='bi pe-none me-2 fa-solid fa-border-all'></i> Mesas</a></li>";
            } else {
                if (intval($_SESSION['USER']['EMPR']['NIVL']) == 0 ||
                        intval($_SESSION['USER']['EMPR']['NIVL']) == 1 ||
                        intval($_SESSION['USER']['EMPR']['NIVL']) == 4) {
                    $html = $html . "<li class='nav-item'><a onclick=\"AbrirLink('" . $back . "mesas');\" class='nav-link text-white'><i class='bi pe-none me-2 fa-solid fa-border-all'></i> Mesas <small><span class='badge text-bg-danger'>1</span></small></a></li>";
                } else {
                    $html = $html . "<li class='nav-item disabled'><a class='nav-link text-muted'><i class='bi pe-none me-2 fa-solid fa-border-all'></i> Mesas</a></li>";
                }
            }
        }

        //Cozinha - Acesso e Visualazição:
        //CEO
        //Gestor(a)
        //Cozinheiro(a)
        if ($_SESSION['USER']['EMPR']['COZI']) {
            if ($pag == "cozinha") {
                $html = $html . "<li class='nav-item'><a onclick=\"AbrirLink('" . $back . "cozinha');\" class='nav-link active'><i class='bi pe-none me-2 fa-solid fa-utensils'></i> Cozinha</a></li>";
            } else {
                if (intval($_SESSION['USER']['EMPR']['NIVL']) == 0 ||
                        intval($_SESSION['USER']['EMPR']['NIVL']) == 1 ||
                        intval($_SESSION['USER']['EMPR']['NIVL']) == 3) {
                    $html = $html . "<li class='nav-item'><a onclick=\"AbrirLink('" . $back . "cozinha');\" class='nav-link text-white'><i class='bi pe-none me-2 fa-solid fa-utensils'></i> Cozinha</a></li>";
                } else {
                    $html = $html . "<li class='nav-item disabled'><a class='nav-link text-muted'><i class='bi pe-none me-2 fa-solid fa-utensils'></i> Cozinha</a></li>";
                }
            }
        }

        //Clientes - Acesso e Visualazição:
        //CEO
        //Gestor(a)
        //Atendente
        if ($pag == "clientes") {
            $html = $html . "<li class='nav-item'><a onclick=\"AbrirLink('" . $back . "clientes');\" class='nav-link active'><i class='bi pe-none me-2 fa-solid fa-user'></i> Clientes</a></li>";
        } else {
            if (intval($_SESSION['USER']['EMPR']['NIVL']) == 0 ||
                    intval($_SESSION['USER']['EMPR']['NIVL']) == 1 ||
                    intval($_SESSION['USER']['EMPR']['NIVL']) == 2) {
                $html = $html . "<li class='nav-item'><a onclick=\"AbrirLink('" . $back . "clientes');\" class='nav-link text-white'><i class='bi pe-none me-2 fa-solid fa-user'></i> Clientes</a></li>";
            } else {
                $html = $html . "<li class='nav-item disabled'><a class='nav-link text-muted'><i class='bi pe-none me-2 fa-solid fa-user'></i> Clientes</a></li>";
            }
        }

        //Produtos - Acesso e Visualazição:
        //CEO
        //Gestor(a)
        if ($pag == "produtos") {
            $html = $html . "<li class='nav-item'><a onclick=\"AbrirLink('" . $back . "produtos');\" class='nav-link active'><i class='bi pe-none me-2 fa-solid fa-pizza-slice'></i> Produtos</a></li>";
        } else {
            if (intval($_SESSION['USER']['EMPR']['NIVL']) == 0 ||
                    intval($_SESSION['USER']['EMPR']['NIVL']) == 1) {
                $html = $html . "<li class='nav-item'><a onclick=\"AbrirLink('" . $back . "produtos');\" class='nav-link text-white'><i class='bi pe-none me-2 fa-solid fa-pizza-slice'></i> Produtos</a></li>";
            } else {
                $html = $html . "<li class='nav-item disabled'><a class='nav-link text-muted'><i class='bi pe-none me-2 fa-solid fa-pizza-slice'></i> Produtos</a></li>";
            }
        }

        //Promoções - Acesso e Visualazição:
        //CEO
        //Gestor(a)
        if ($pag == "promos") {
            $html = $html . "<li class='nav-item'><a onclick=\"AbrirLink('" . $back . "promos');\" class='nav-link active'><i class='bi pe-none me-2 fa-solid fa-ticket'></i> Promoções</a></li>";
        } else {
            if (intval($_SESSION['USER']['EMPR']['NIVL']) == 0 ||
                    intval($_SESSION['USER']['EMPR']['NIVL']) == 1) {
                $html = $html . "<li class='nav-item'><a onclick=\"AbrirLink('" . $back . "promos');\" class='nav-link text-white'><i class='bi pe-none me-2 fa-solid fa-ticket'></i> Promoções</a></li>";
            } else {
                $html = $html . "<li class='nav-item disabled'><a class='nav-link text-muted'><i class='bi pe-none me-2 fa-solid fa-ticket'></i> Promoções</a></li>";
            }
        }

        //Entregadores - Acesso e Visualazição:
        //CEO
        //Gestor(a)
        if ($_SESSION['USER']['EMPR']['ENTR']) {
            if ($pag == "entregadores") {
                $html = $html . "<li class='nav-item'><a onclick=\"AbrirLink('" . $back . "entregadores');\" class='nav-link active'><i class='bi pe-none me-2 fa-solid fa-motorcycle'></i> Entregadores</a></li>";
            } else {
                if (intval($_SESSION['USER']['EMPR']['NIVL']) == 0 ||
                        intval($_SESSION['USER']['EMPR']['NIVL']) == 1) {
                    $html = $html . "<li class='nav-item'><a onclick=\"AbrirLink('" . $back . "entregadores');\" class='nav-link text-white'><i class='bi pe-none me-2 fa-solid fa-motorcycle'></i> Entregadores</a></li>";
                } else {
                    $html = $html . "<li class='nav-item disabled'><a class='nav-link text-muted'><i class='bi pe-none me-2 fa-solid fa-motorcycle'></i> Entregadores</a></li>";
                }
            }
        }

        //Avaliações - Acesso e Visualazição:
        //CEO
        //Gestor(a)
        if ($pag == "avaliacoes") {
            $html = $html . "<li class='nav-item'><a onclick=\"AbrirLink('" . $back . "avaliacoes');\" class='nav-link active'><i class='bi pe-none me-2 fa-sharp fa-solid fa-star'></i> Avaliações</a></li>";
        } else {
            if (intval($_SESSION['USER']['EMPR']['NIVL']) == 0 ||
                    intval($_SESSION['USER']['EMPR']['NIVL']) == 1) {
                $html = $html . "<li class='nav-item'><a onclick=\"AbrirLink('" . $back . "avaliacoes');\" class='nav-link text-white'><i class='bi pe-none me-2 fa-sharp fa-solid fa-star'></i> Avaliações</a></li>";
            } else {
                $html = $html . "<li class='nav-item disabled'><a class='nav-link text-muted'><i class='bi pe-none me-2 fa-sharp fa-solid fa-star'></i> Avaliações</a></li>";
            }
        }

        //Integrações - Acesso e Visualazição:
        //CEO
        //Gestor(a)
        if ($_SESSION['USER']['EMPR']['INTG']) {
            if ($pag == "integracoes") {
                $html = $html . "<li class='nav-item'><a onclick=\"AbrirLink('" . $back . "integracoes');\" class='nav-link active'><i class='bi pe-none me-2 fa-solid fa-network-wired'></i> Integrações</a></li>";
            } else {
                if (intval($_SESSION['USER']['EMPR']['NIVL']) == 0 ||
                        intval($_SESSION['USER']['EMPR']['NIVL']) == 1) {
                    $html = $html . "<li class='nav-item'><a onclick=\"AbrirLink('" . $back . "integracoes');\" class='nav-link text-white'><i class='bi pe-none me-2 fa-solid fa-network-wired'></i> Integrações</a></li>";
                } else {
                    $html = $html . "<li class='nav-item disabled'><a class='nav-link text-muted'><i class='bi pe-none me-2 fa-solid fa-network-wired'></i> Integrações</a></li>";
                }
            }
        }

        $html = $html . "</ul>";
        return $html;
    }

    public function WriteMenuUser($back = "") {

        $prefix = "img/users/";
        if (empty($_SESSION['USER']['IMAG'])) {
            $urlimg = $prefix . "default.png";
        } else {
            $urlimg = $prefix . $_SESSION['USER']['IMAG'];
        }

        $html = "";

        $html = $html . "<div class='dropdown'>";
        $html = $html . "<a href='#' class='d-flex align-items-center text-white text-decoration-none dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>";
        $html = $html . "<img src='" . $back . $urlimg . "' alt='" . $_SESSION['USER']['NICK'] . "' width='32' height='32' class='rounded-circle me-2'>";
        $html = $html . "<strong>" . $_SESSION['USER']['NICK'] . "</strong>";
        $html = $html . "</a>";
        $html = $html . "<ul class='dropdown-menu dropdown-menu-dark text-small shadow' style=''>";
        $html = $html . "<li><a class='dropdown-item cursor-pointer' onclick=\"AbrirLink('" . $back . "profile')\";><i class='bi pe-none me-2 fa-solid fa-user'></i>Perfil</a></li>";
        if (intval($_SESSION['USER']['EMPR']['NIVL']) == 0) {
            $html = $html . "<li><a class='dropdown-item cursor-pointer' onclick=\"AbrirLink('" . $back . "configuracoes')\";><i class='bi pe-none me-2 fa-solid fa-gear'></i>Configurações</a></li>";
        }
        $html = $html . "<li><a class='dropdown-item cursor-pointer' onclick=\"AbrirLink('" . $back . "empresas')\";><i class='bi pe-none me-2 fa-solid fa-arrows-rotate'></i>Alterar Empresa</a></li>";
        $html = $html . "<li><hr class='dropdown-divider'></li>";
        $html = $html . "<li><a class='dropdown-item cursor-pointer' onclick=\"AbrirLink('" . $back . "form/logout')\";><i class='bi pe-none me-2 fa-solid fa-right-from-bracket'></i>Sair</a></li>";
        $html = $html . "</ul>";
        $html = $html . "</div>";
        return $html;
    }

}
