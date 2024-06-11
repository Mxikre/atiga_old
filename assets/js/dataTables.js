$(document).ready(function () {
    $('#data_table').DataTable({
        info: false,
        dom: 'Bfrtilp',
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All']
        ],
        buttons: [{
            extend: 'pdf',
            exportOptions: {
                columns: [':not(:last-child)']
            }
        },
        {
            extend: 'print',
            exportOptions: {
                columns: [':not(:last-child)']
            }

        },
        {
            extend: 'excel',
            exportOptions: {
                columns: [':not(:last-child)']
            }

        }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
        },
    });
});

