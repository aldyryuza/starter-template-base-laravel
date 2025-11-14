let Permission = {
    module: () => 'settings/permissions',
    moduleApi: () => 'api/' + Permission.module(),

    add: () => {
        let _url = url.base_url(Permission.module()) + 'create';
        window.location.href = _url;
    },
    edit: (id) => {
        let _url = url.base_url(Permission.module()) + 'edit/' + id;
        window.location.href = _url;
    },
    detail: (id) => {
        let _url = url.base_url(Permission.module()) + 'detail/' + id;
        window.location.href = _url;
    },
    back: () => {
        let _url = url.base_url(Permission.module());
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
            aLengthPermission: [
                [25, 50, 100],
                [25, 50, 100]
            ],
            ajax: {
                url: url.base_url(Permission.moduleApi()) + 'getData',
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
                { data: 'menu_name' },
                { data: 'roles_name' },
                { data: 'action' },
                { data: 'created_at' },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center align-middle',
                    render: function (data, type, row) {
                        return `
                    <div class="d-flex justify-content-center gap-1">
                        <button class="btn btn-sm btn-info" title="Detail" onclick="Permission.detail(${row.id})">
                            <i class="bx bx-detail"></i>
                        </button>
                        <button class="btn btn-sm btn-warning" title="Edit" onclick="Permission.edit(${row.id})">
                            <i class="bx bx-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" title="Hapus" data-id="${row.id}" onclick="Permission.delete(this,event)">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                `;
                    }
                }
            ],
            order: [[1, 'asc']]
        });

    },

    getPostData: () => {
        let data = {
            id: $('#id').val(),
            menu: $('#menu').val(),
            user_group: $('#user_group').val(),
            action: $('#action').val(),
        };
        return data;
    },
    submit: () => {
        let params = Permission.getPostData();
        let _url = url.base_url(Permission.moduleApi()) + 'submit';
        // return console.log(params);
        if (validation.run() === 1) {
            $.ajax({
                type: "POST",
                url: _url,
                data: params,
                dataType: "json",
                // token
                headers: {
                    'Authorization': 'Bearer ' + Token.get(),
                },
                beforeSend: () => {
                    message.loadingProses('Proses Simpan...');
                },
                success: function (response) {
                    message.closeLoading();
                    if (response.is_valid) {
                        message.sweetSuccess(response.message);
                        Permission.back();
                    } else {
                        message.sweetError(response.message);
                    }
                }
            });
        }
    },

    delete: (elm, e) => {
        let id = $(elm).attr('data-id');
        // return console.log(id);

        let _url = url.base_url(Permission.moduleApi()) + 'delete/' + id;

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus dan tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Lakukan request hapus (misal pakai AJAX)
                $.ajax({
                    url: _url,
                    type: 'DELETE',
                    dataType: 'json',
                    headers: {
                        'Authorization': 'Bearer ' + Token.get(),
                    },
                    success: function (res) {
                        Swal.fire({
                            title: 'Terhapus!',
                            text: res.message || 'Data berhasil dihapus.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        // contoh: reload data tabel
                        if (typeof Permission.getData === 'function') {
                            Permission.getData();
                        }
                    },
                    error: function (xhr) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan saat menghapus data.',
                            icon: 'error'
                        });
                    }
                });
            }
        });

        return false; // mencegah event default
    }






};

$(function () {
    Permission.getData();
    $('.select2').select2({
        // theme: 'bootstrap4',
        // placeholder: "Select Parent Permission",
        // allowClear: true,
        width: '100%'
    });
});
