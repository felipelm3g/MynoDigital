<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

?>
<!DOCTYPE html>
<html lang = "pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name = "viewport" content = "width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Documentação - API</title>

        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="0">
        
        <link rel="icon" type="image/png" href="favicon.png">

        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/4.18.1/swagger-ui.min.css" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

        <style>
            html, body {
                float: left;
                width: 100%;
                margin: 0px;
                padding: 0px;
            }
            .border-azul {
                border-color: #0D6EFD !important;
            }
            .bg-azul {
                background-color: #0D6EFD !important;
            }
            .version-stamp {
                background-color: #0D6EFD !important;
            }
        </style>
    </head>
    <body>
        <div id="swagger-ui"></div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/4.18.1/swagger-ui-bundle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/4.18.1/swagger-ui-standalone-preset.min.js"></script>
        <script>
            window.onload = function () {
                const ui = SwaggerUIBundle({
                    url: "openapi.json",
                    dom_id: '#swagger-ui',
                    deepLinking: true,
                    presets: [
                        SwaggerUIBundle.presets.apis,
                        SwaggerUIStandalonePreset
                    ],
                    plugins: [
                        SwaggerUIBundle.plugins.DownloadUrl
                    ],
                    layout: "StandaloneLayout",
                })
                window.ui = ui;

                var html = "";
                html += "<div class='wrapper'>";
                html += "<div class='topbar-wrapper'>";
                html += "<a rel='noopener noreferrer' class='link'>";
                html += "<img height='40' src='logo.png' alt='API - LDE Sistemas'>";
                html += "</a>";
                html += "<form class='download-url-wrapper'>";
                html += "<input class='download-url-input border-azul' type='text' value='' placeholder='Digite aqui'>";
                html += "<button onclick='' class='download-url-button bg-azul button'>Explorar</button>";
                html += "</form>";
                html += "</div>";
                html += "</div>";
                
                document.querySelector(".topbar").innerHTML = html;
            }
        </script>
    </body>
</html>
