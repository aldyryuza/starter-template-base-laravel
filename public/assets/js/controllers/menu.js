let Menu = {
    module: () => 'settings/menu',
    moduleApi: () => 'api/' + Menu.module(),

    add: () => {
        let _url = url.base_url(Menu.module()) + 'create';
        window.location.href = _url;
    },
    edit: () => {
        let _url = url.base_url(Menu.module()) + 'edit';
        window.location.href = _url;
    },
    detail: () => {
        let _url = url.base_url(Menu.module()) + 'detail';
        window.location.href = _url;
    },
    back: () => {
        let _url = url.base_url(Menu.module());
        window.location.href = _url;
    },

    getData: () => {
        // hancurkan datatable lama biar tidak conflict
        if ($.fn.DataTable.isDataTable('#data-table')) {
            $('#data-table').DataTable().destroy();
        }

        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            destroy: true,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: ["copy", "csv", "excel", "pdf", "print"],
            aLengthMenu: [
                [25, 50, 100],
                [25, 50, 100]
            ],
            ajax: {
                url: url.base_url(Menu.moduleApi()) + 'getData',
                type: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + Token.get(),
                },
                dataSrc: function (json) {
                    if (!json.data) {
                        console.error("Response tidak valid:", json);
                        return [];
                    }
                    return json.data;
                },
                error: function (xhr) {
                    console.error("Error DataTable:", xhr);
                    if (xhr.status === 401) {
                        alert('Token tidak valid atau sesi habis. Silakan login kembali.');
                        localStorage.removeItem('auth_token');
                        window.location.href = url.base_url('auth') + 'login';
                    }
                }
            },
            columns: [
                { data: 'DT_RowIndex', searchable: false, orderable: false },
                { data: 'name' },
                { data: 'icon' },
                { data: 'path' },
                { data: 'menu_code' },
                { data: 'created_at' },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center align-middle',
                    render: function (data, type, row) {
                        return `
                    <div class="d-flex justify-content-center gap-1">
                        <button class="btn btn-sm btn-info" title="Detail" onclick="Menu.detail(${row.id})">
                            <i class="bx bx-detail"></i>
                        </button>
                        <button class="btn btn-sm btn-warning" title="Edit" onclick="Menu.edit(${row.id})">
                            <i class="bx bx-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" title="Hapus" onclick="Menu.delete(${row.id})">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                `;
                    }
                }
            ],
            order: [[1, 'asc']]
        });

    }



};

$(function () {
    Menu.getData();
});
