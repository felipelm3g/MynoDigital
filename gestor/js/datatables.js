$(document).ready(function () {

    let configs = {
        dom: 'Bfrtip',
        ordering: false,
        responsive: true,
        columnDefs: [],
        buttons: {
            dom: {
                button: {className: "btn btn-primary btn-sm"},
                buttonLiner: {tag: null}
            },
            buttons: [
                {
                    text: '<i class="fa-solid fa-plus"></i>',
                    titleAttr: 'Novo',
                    className: 'btn-success',
                    action: function () {
                        try {
                            BtnNovo();
                        } catch (e) {

                        }
                    }
                },
                {
                    extend: 'copy',
                    text: '<i class="fa-regular fa-clone"></i>',
                    titleAttr: 'Copiar',
                    orientation: 'landscape'
                },
                {
                    extend: 'csv',
                    text: '<i class="fa-solid fa-file-csv"></i>',
                    titleAttr: 'Gerar CSV',
                    orientation: 'landscape'
                },
                {
                    extend: 'excel',
                    text: '<i class="fa-solid fa-table"></i>',
                    titleAttr: 'Gerar Tabela Excel',
                    orientation: 'landscape'
                },
                {
                    extend: 'pdf',
                    text: '<i class="fa-solid fa-file-pdf"></i>',
                    titleAttr: 'Gerar PDF',
                    orientation: 'landscape'
                },
                {
                    extend: 'print',
                    text: '<i class="fa-solid fa-print"></i>',
                    titleAttr: 'Imprimir',
                    orientation: 'landscape'
                }
            ]
        },
        initComplete: function () {
            this.api()
                    .columns()
                    .every(function () {
                        var that = this;
                    });
            $('.dataTables_wrapper').find('.paginate_button').addClass('btn btn-primary');
            $('.dataTables_wrapper').find('.paginate_button').addClass('btn-sm');
            $('.dataTables_wrapper').find('.paginate_button').addClass('me-2');
            $('.dataTables_wrapper').find('.paginate_button').removeClass('paginate_button');
            $('input[type="search"]').attr('id', 'mySearchInput');
            $('input[type="search"]').attr('class', 'form-control-sm');
        },
        drawCallback: function () {
            $('.dataTables_wrapper').find('.paginate_button').addClass('btn btn-primary');
            $('.dataTables_wrapper').find('.paginate_button').addClass('btn-sm');
            $('.dataTables_wrapper').find('.paginate_button').addClass('me-2');
            $('.dataTables_wrapper').find('.paginate_button').removeClass('paginate_button');
            $('input[type="search"]').attr('id', 'mySearchInput');
            $('input[type="search"]').attr('class', 'form-control-sm');
        },
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json"
        }

    };

    let table = $('#myTable').DataTable(configs);
});