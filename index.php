<?php
$configs = file_get_contents("configs.json");
$configs = json_decode($configs);
?>
<html lang="pt-br" data-bs-theme="auto">
    <head>

        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="description" content=""/>
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors"/>
        <meta name="generator" content="Hugo 0.111.3"/>
        <title><?php echo $configs->name; ?></title>

        <link rel="apple-touch-icon" sizes="57x57" href="gestor/<?php echo $configs->icons[0]->{"57"}; ?>"/>
        <link rel="apple-touch-icon" sizes="60x60" href="gestor/<?php echo $configs->icons[0]->{"60"}; ?>"/>
        <link rel="apple-touch-icon" sizes="72x72" href="gestor/<?php echo $configs->icons[0]->{"72"}; ?>"/>
        <link rel="apple-touch-icon" sizes="76x76" href="gestor/<?php echo $configs->icons[0]->{"76"}; ?>"/>
        <link rel="apple-touch-icon" sizes="114x114" href="gestor/<?php echo $configs->icons[0]->{"114"}; ?>"/>
        <link rel="apple-touch-icon" sizes="120x120" href="gestor/<?php echo $configs->icons[0]->{"120"}; ?>"/>
        <link rel="apple-touch-icon" sizes="144x144" href="gestor/<?php echo $configs->icons[0]->{"144"}; ?>"/>
        <link rel="apple-touch-icon" sizes="152x152" href="gestor/<?php echo $configs->icons[0]->{"152"}; ?>"/>
        <link rel="apple-touch-icon" sizes="180x180" href="gestor/<?php echo $configs->icons[0]->{"180"}; ?>"/>
        <link rel="icon" type="image/png" sizes="192x192"  href="gestor/<?php echo $configs->icons[0]->{"192"}; ?>"/>
        <link rel="icon" type="image/png" sizes="32x32" href="gestor/<?php echo $configs->icons[0]->{"32"}; ?>"/>
        <link rel="icon" type="image/png" sizes="96x96" href="gestor/<?php echo $configs->icons[0]->{"96"}; ?>"/>
        <link rel="icon" type="image/png" sizes="16x16" href="gestor/<?php echo $configs->icons[0]->{"16"}; ?>"/>
        <link rel="manifest" href="gestor/<?php echo $configs->manifest; ?>"/>
        <meta name="msapplication-TileColor" content="gestor/<?php echo $configs->themecolor; ?>"/>
        <meta name="msapplication-TileImage" content="gestor/<?php echo $configs->icons[0]->{"144"}; ?>"/>
        <meta name="theme-color" content="gestor/<?php echo $configs->themecolor; ?>"/>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"/>

        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }

            .b-example-divider {
                width: 100%;
                height: 3rem;
                background-color: rgba(0, 0, 0, .1);
                border: solid rgba(0, 0, 0, .15);
                border-width: 1px 0;
                box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
            }

            .b-example-vr {
                flex-shrink: 0;
                width: 1.5rem;
                height: 100vh;
            }

            .bi {
                vertical-align: -.125em;
                fill: currentColor;
            }

            .nav-scroller {
                position: relative;
                z-index: 2;
                height: 2.75rem;
                overflow-y: hidden;
            }

            .nav-scroller .nav {
                display: flex;
                flex-wrap: nowrap;
                padding-bottom: 1rem;
                margin-top: -1px;
                overflow-x: auto;
                text-align: center;
                white-space: nowrap;
                -webkit-overflow-scrolling: touch;
            }

            .btn-bd-primary {
                --bd-violet-bg: #712cf9;
                --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

                --bs-btn-font-weight: 600;
                --bs-btn-color: var(--bs-white);
                --bs-btn-bg: var(--bd-violet-bg);
                --bs-btn-border-color: var(--bd-violet-bg);
                --bs-btn-hover-color: var(--bs-white);
                --bs-btn-hover-bg: #6528e0;
                --bs-btn-hover-border-color: #6528e0;
                --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
                --bs-btn-active-color: var(--bs-btn-hover-color);
                --bs-btn-active-bg: #5a23c8;
                --bs-btn-active-border-color: #5a23c8;
            }
            .bd-mode-toggle {
                z-index: 1500;
            }
            body {
                background-image: linear-gradient(180deg, var(--bs-body-secondary-bg), var(--bs-body-bg) 100px, var(--bs-body-bg));
            }

            .container {
                max-width: 960px;
            }

            .pricing-header {
                max-width: 700px;
            }
        </style>

    </head>
    <body cz-shortcut-listen="true">

        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check" viewBox="0 0 16 16">
                <title>Check</title>
                <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"></path>
            </symbol>
        </svg>

        <div id="inicio" class="container py-3">
            <header>
                <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
                    <a href="/" class="d-flex align-items-center link-body-emphasis text-decoration-none">
                        <img src="gestor/<?php echo $configs->logo; ?>" height="32" class="me-2" viewBox="0 0 118 94" role="img"/>
                        <span class="fs-4"><?php echo $configs->name; ?></span>
                    </a>

                    <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
                        <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="#inicio">Início</a>
                        <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="#planos">Planos</a>
                        <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="#comparacao">Comparação</a>
                        <a class="py-2 link-body-emphasis text-decoration-none" target="_blank" href="#">Gestor</a>
                    </nav>
                </div>

                <div id="planos" class="pricing-header p-3 pb-md-4 mx-auto text-center">
                    <h1 class="display-4 fw-normal">Planos</h1>
                    <p class="fs-5 text-body-secondary">Escolha o plano de acordo com sua necessidade</p>
                </div>
            </header>

            <main>
                <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
                    <div class="col">
                        <div class="card mb-4 rounded-3 shadow-sm">
                            <div class="card-header py-3">
                                <h4 class="my-0 fw-normal">Grátis</h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title pricing-card-title">R$0<small class="text-body-secondary fw-light">/mês</small></h1>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>30 Pedidos por mês</li>
                                    <li>Sem acesso a API</li>
                                    <li>-</li>
                                </ul>
                                <button type="button" class="w-100 btn btn-lg btn-outline-primary">Criar conta</button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card mb-4 rounded-3 shadow-sm">
                            <div class="card-header py-3">
                                <h4 class="my-0 fw-normal">Iniciante</h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title pricing-card-title">R$49<small class="text-body-secondary fw-light">/mês</small></h1>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>Pedidos Ilimitados</li>
                                    <li>Sem acesso a API</li>
                                    <li>Automatização WhatsApp</li>
                                </ul>
                                <button type="button" class="w-100 btn btn-lg btn-primary">Contratar</button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card mb-4 rounded-3 shadow-sm border-primary">
                            <div class="card-header py-3 text-bg-primary border-primary">
                                <h4 class="my-0 fw-normal">Profissional</h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title pricing-card-title">R$69<small class="text-body-secondary fw-light">/mês</small></h1>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li>Pedidos Ilimitados</li>
                                    <li>Acesso a API</li>
                                    <li>Automatização WhatsApp</li>
                                </ul>
                                <button type="button" class="w-100 btn btn-lg btn-primary">Quero esse!</button>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 id="comparacao" class="display-6 text-center mb-4">Compare os planos</h2>

                <div class="table-responsive">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th style="width: 34%;"></th>
                                <th style="width: 22%;">Gratís</th>
                                <th style="width: 22%;">Iniciante</th>
                                <th style="width: 22%;">Profissional</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row" class="text-start">Cadastro de Clientes</th>
                                <td><svg class="bi text-success" width="24" height="24"><use xlink:href="#check"></use></svg></td>
                                <td><svg class="bi text-success" width="24" height="24"><use xlink:href="#check"></use></svg></td>
                                <td><svg class="bi text-success" width="24" height="24"><use xlink:href="#check"></use></svg></td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-start">Gestor de Pedidos</th>
                                <td><svg class="bi text-success" width="24" height="24"><use xlink:href="#check"></use></svg></td>
                                <td><svg class="bi text-success" width="24" height="24"><use xlink:href="#check"></use></svg></td>
                                <td><svg class="bi text-success" width="24" height="24"><use xlink:href="#check"></use></svg></td>
                            </tr>
                        </tbody>

                        <tbody>
                            <tr>
                                <th scope="row" class="text-start">Gerenciador de Mesas</th>
                                <td></td>
                                <td><svg class="bi text-success" width="24" height="24"><use xlink:href="#check"></use></svg></td>
                                <td><svg class="bi text-success" width="24" height="24"><use xlink:href="#check"></use></svg></td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-start">Entregadores</th>
                                <td></td>
                                <td><svg class="bi text-success" width="24" height="24"><use xlink:href="#check"></use></svg></td>
                                <td><svg class="bi text-success" width="24" height="24"><use xlink:href="#check"></use></svg></td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-start">Automatização WhatsApp</th>
                                <td></td>
                                <td><svg class="bi text-success" width="24" height="24"><use xlink:href="#check"></use></svg></td>
                                <td><svg class="bi text-success" width="24" height="24"><use xlink:href="#check"></use></svg></td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-start">Acesso a integrações via API</th>
                                <td></td>
                                <td></td>
                                <td><svg class="bi text-success" width="24" height="24"><use xlink:href="#check"></use></svg></td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-start">Suporte 24hr</th>
                                <td></td>
                                <td><svg class="bi text-success" width="24" height="24"><use xlink:href="#check"></use></svg></td>
                                <td><svg class="bi text-success" width="24" height="24"><use xlink:href="#check"></use></svg></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>

            <footer class="pt-4 my-md-5 pt-md-5 border-top">
                <div class="row">
                    <div class="col-12 col-md">
                        <img class="mb-2" src="gestor/<?php echo $configs->logo; ?>" height="19"/>
                        <small class="d-block mb-3 text-body-secondary">© 2023</small>
                        <ul class="list-unstyled text-small">
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Criar conta</a></li>
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Documentação API</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-md">
                        <h5>Features</h5>
                        <ul class="list-unstyled text-small">
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#inicio">Início</a></li>
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#planos">Planos</a></li>
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#comparacao">Comparação</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-md">
                        <h5>Recursos</h5>
                        <ul class="list-unstyled text-small">
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Gestor</a></li>
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Entregadores</a></li>
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Cozinha</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-md">
                        <h5>Sobre</h5>
                        <ul class="list-unstyled text-small">
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Suporte</a></li>
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Notícias</a></li>
                            <li class="mb-1"><a class="link-secondary text-decoration-none" href="#">Política de Privacidade</a></li>
                        </ul>
                    </div>
                </div>
            </footer>
        </div>


    </body>
</html>