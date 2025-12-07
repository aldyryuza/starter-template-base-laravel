// make a global variable const update dan const delete
const update = $('#update').val();
const del = $('#delete').val();

let Request = {
    module: () => 'my-request',
    moduleApi: () => 'api/' + Request.module(),


    add: () => {
        let _url = url.base_url(Request.module()) + 'create';
        window.location.href = _url;
    },
    edit: (id) => {
        let _url = url.base_url(Request.module()) + 'edit/' + id;
        window.location.href = _url;
    },
    detail: (id) => {
        let _url = url.base_url(Request.module()) + 'detail/' + id;
        window.location.href = _url;
    },
    back: () => {
        let _url = url.base_url(Request.module());
        window.location.href = _url;
    },

    getData: () => {
        if ($.fn.DataTable.isDataTable('#data-table')) {
            $('#data-table').DataTable().destroy();
        }

        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            pageLength: 25,

            // PERBAIKAN: lengthMenu (bukan alengthMenu!)
            lengthMenu: [
                [25, 50, 100, -1],
                [25, 50, 100, "All"]
            ],
            // PERBAIKAN: colReorder
            colReorder: true,
            fixedColumnsLeft: 1,
            fixedColumnsRight: 1,
            // DOM yang benar-benar rapi + ada jarak
            dom:
                "<'row g-3 mb-3'" +
                "<'col-sm-12 col-md-4'B>" +     // Buttons (kiri)
                "<'col-sm-12 col-md-4 text-center'l>" + // Length menu (tengah)
                "<'col-sm-12 col-md-4'f>" +     // Search (kanan)
                ">" +
                "<'row'" +
                "<'col-sm-12'tr>" +
                ">" +
                "<'row g-3 mt-3'" +
                "<'col-sm-12 col-md-5'i>" +
                "<'col-sm-12 col-md-7'p>" +
                ">",

            buttons: [
                { extend: 'copy', text: '<i class="bx bx-copy"></i>', titleAttr: 'Copy' },
                { extend: 'csv', text: '<i class="bx bx-file"></i>', titleAttr: 'CSV' },
                { extend: 'excel', text: '<i class="bx bxs-file-export"></i>', titleAttr: 'Excel' },
                { extend: 'pdf', text: '<i class="bx bxs-file-pdf"></i>', titleAttr: 'PDF' },
                { extend: 'print', text: '<i class="bx bx-printer"></i>', titleAttr: 'Print' },
                {
                    extend: 'colvis',
                    text: '<i class="bx bx-columns"></i> Column',
                    // className: 'btn btn-outline-secondary btn-sm',
                    columns: [1, 2, 3, 4] // sembunyikan No & Action dari opsi colvis
                }
            ],

            // language: {
            //     lengthMenu: "Tampilkan _MENU_ data per halaman",
            //     search: "Cari:",
            //     info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            //     paginate: {
            //         previous: "Sebelumnya",
            //         next: "Berikutnya"
            //     }
            // },

            ajax: {
                url: url.base_url(Request.moduleApi()) + 'getData',
                type: 'POST',
                headers: { 'Authorization': 'Bearer ' + Token.get() },
                dataSrc: json => json.data || [],
                error: xhr => {
                    if (xhr.status === 401) {
                        alert('Sesi habis, silakan login ulang.');
                        localStorage.removeItem('auth_token');
                        window.location.href = url.base_url('auth') + 'logout';
                    }
                }
            },

            columns: [
                { data: 'DT_RowIndex', searchable: false, orderable: false, className: 'text-center' },
                { data: 'name' },
                { data: 'username' },
                { data: 'roles_name' },
                { data: 'created_at' },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: (data, type, row) => {
                        let btn = '';
                        if (update == 1) {
                            btn += `<button class="btn btn-sm btn-info" onclick="Request.detail(${row.id})"><i class="bx bx-detail"></i></button> `;
                            btn += `<button class="btn btn-sm btn-warning" onclick="Request.edit(${row.id})"><i class="bx bx-edit"></i></button> `;
                        }
                        if (del == 1) {
                            btn += `<button class="btn btn-sm btn-danger" onclick="Request.delete(this,event)" data-id="${row.id}"><i class="bx bx-trash"></i></button>`;
                        }
                        return '<div class="d-flex justify-content-center gap-1">' + btn + '</div>';
                    }
                }
            ],

            order: [[1, 'asc']]
        });
    },

    getPostData: () => {
        let data = {
            id: $('#id').val(),
            username: $('#username').val(),
            password: $('#password').val(),
            employee: $('#employee').val(),
            name: $('#name').val(),
            user_group: $('#user_group').val(),
        };
        return data;
    },
    submit: () => {
        let params = Request.getPostData();
        let _url = url.base_url(Request.moduleApi()) + 'submit';
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
                        Request.back();
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

        let _url = url.base_url(Request.moduleApi()) + 'delete/' + id;

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
                        if (typeof Request.getData === 'function') {
                            Request.getData();
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
    },






};

$(function () {
    Request.getData();
    $('.select2').select2({
        // theme: 'bootstrap4',
        // placeholder: "Select Parent Users",
        // allowClear: true,
        width: '100%'
    });
});
