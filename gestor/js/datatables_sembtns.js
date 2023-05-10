$(document).ready(function () {

    let configs = {
        dom: 'Bfrtip',
        ordering: false,
        responsive: true,
        columnDefs: [],
        autoWidth: true,
        buttons: {
            dom: {
                button: {className: "btn btn-primary btn-sm"},
                buttonLiner: {tag: null}
            },
            buttons: []
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

    let table1 = $('#myTable').DataTable(configs);
    
    try {
        let table2 = $('#myTable2').DataTable(configs);
    } catch (e) {

    }

});