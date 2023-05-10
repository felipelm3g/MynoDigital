var htmlmodalerro = "<div class='modal fade' id='JanelaErroModal' data-bs-backdrop='static' data-bs-keyboard='false' data-backdrop='static' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
htmlmodalerro = htmlmodalerro + "<div class='modal-dialog modal-dialog-centered' role='document'>";
htmlmodalerro = htmlmodalerro + "<div class='modal-content'>";
htmlmodalerro = htmlmodalerro + "<div class='modal-header'>";
htmlmodalerro = htmlmodalerro + "<h5 class='modal-title' id='ModalMsgLabel'></h5>";
//htmlmodalerro = htmlmodalerro + "<button class='close' type='button' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>×</span></button>";
htmlmodalerro = htmlmodalerro + "</div>";
htmlmodalerro = htmlmodalerro + "<div class='modal-body' id='modalerrotext'></div>";
htmlmodalerro = htmlmodalerro + "<div class='modal-footer'>";
htmlmodalerro = htmlmodalerro + "<button class='btn btn-secondary btn-sm' type='button' data-bs-dismiss='modal' data-dismiss='modal'><i class='fa-solid fa-xmark'></i> Fechar</button>";
htmlmodalerro = htmlmodalerro + "</div>";
htmlmodalerro = htmlmodalerro + "</div>";
htmlmodalerro = htmlmodalerro + "</div>";
htmlmodalerro = htmlmodalerro + "</div>";

function ExibirErro(txt) {
    ExibirMsg(txt, "E");
}

function ExibirMsg(txt, typ, audio = true) {
    console.log(txt);
    switch (typ) {
        case "I":
            document.getElementById("ModalMsgLabel").innerHTML = "<i class='fa-solid fa-circle-info fa-beat-fade text-info'></i> Info";
            break;
        case "W":
            document.getElementById("ModalMsgLabel").innerHTML = "<i class='fa-solid fa-triangle-exclamation fa-beat-fade text-warning'></i> Alerta";
            break;
        case "E":
            document.getElementById("ModalMsgLabel").innerHTML = "<i class='fa-solid fa-triangle-exclamation fa-beat-fade text-danger'></i> Erro";
            break;
        case "S":
            document.getElementById("ModalMsgLabel").innerHTML = "<i class='fa-solid fa-check fa-beat-fade text-success'></i> Sucesso";
            break;
    }

    if (audio) {
        try {
            const synth = window.speechSynthesis;
            const utterance = new SpeechSynthesisUtterance(txt);
            utterance.voice = synth.getVoices().find(v => v.lang === 'pt-BR');
            synth.speak(utterance);
        } catch (e) {
            console.log(e);
        }
    }

    document.getElementById("modalerrotext").innerHTML = txt;
    $('#JanelaErroModal').modal('show');
}

$(document).ready(function () {
    try {
        document.body.innerHTML += htmlmodalerro;
        console.log("Carregou - Script de Janela de Mensagens.");
    } catch (e) {
        console.log("ERRO - Script de Janela de Mensagens.")
    }
});

