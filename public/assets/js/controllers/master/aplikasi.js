// make a global variable const update dan const delete
const update = $('#update').val();
const del = $('#delete').val();

let Aplikasi = {
    module: () => 'master/aplikasi',
    moduleApi: () => 'api/' + Aplikasi.module(),

    add: () => {
        let _url = url.base_url(Aplikasi.module()) + 'create';
        window.location.href = _url;
    },
    edit: (id) => {
        let _url = url.base_url(Aplikasi.module()) + 'edit/' + id;
        window.location.href = _url;
    },
    detail: (id) => {
        let _url = url.base_url(Aplikasi.module()) + 'detail/' + id;
        window.location.href = _url;
    },
    back: () => {
        let _url = url.base_url(Aplikasi.module());
        window.location.href = _url;
    },

    getData: () => {
        let params = {};
        params.subsidiary = $('#f-subsidiary').val();
        params.department = $('#f-department').val();
        params.job_title = $('#f-job_title').val();

        if ($.fn.DataTable.isDataTable('#data-table')) {
            $('#data-table').DataTable().destroy();
        }

        let table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            destroy: true,
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: ["copy", "csv", "excel", "pdf", "print"],
            aLengthMenu: [[25, 50, 100], [25, 50, 100]],
            ajax: {
                url: url.base_url(Aplikasi.moduleApi()) + 'getData',
                type: 'POST',
                headers: { 'Authorization': 'Bearer ' + Token.get() },
                data: params,
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
                        window.location.href = url.base_url('auth') + 'logout';
                    }
                }
            },
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-center align-middle',
                    render: function (data, type, row) {
                        return `<input type="checkbox" class="row-checkbox form-check-input" value="${row.id}">`;
                    }
                },
                { data: 'DT_RowIndex', searchable: false, orderable: false },
                { data: 'nama' },
                { data: 'keterangan' },
                { data: 'created_at' },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center align-middle',
                    render: function (data, type, row) {
                        let button_action = '';
                        if (update == 1) {
                            button_action += `
                            <button class="btn btn-sm btn-info" title="Detail" onclick="Aplikasi.detail(${row.id})">
                                <i class="bx bx-detail"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" title="Edit" onclick="Aplikasi.edit(${row.id})">
                                <i class="bx bx-edit"></i>
                            </button>`;
                        }
                        if (del == 1) {
                            button_action += `
                            <button class="btn btn-sm btn-danger" title="Hapus" data-id="${row.id}" onclick="Aplikasi.delete(this,event)">
                                <i class="bx bx-trash"></i>
                            </button>`;
                        }
                        return `<div class="d-flex justify-content-center gap-1">${button_action}</div>`;
                    }
                }
            ],
            order: [[1, 'asc']],
            drawCallback: function () {
                // Reset select-all saat redraw (pindah halaman, search, dll)
                $('#select-all').prop('checked', false);
                $('#data-table tbody tr').removeClass('selected');
            }
        });

        // === EVENT: Select All ===
        $('#data-table').off('change', '#select-all').on('change', '#select-all', function () {
            let checked = this.checked;
            $('.row-checkbox').prop('checked', checked);
            $('#data-table tbody tr').toggleClass('selected', checked);
        });

        // === EVENT: Row Checkbox ===
        $('#data-table').off('change', '.row-checkbox').on('change', '.row-checkbox', function () {
            let $row = $(this).closest('tr');
            $row.toggleClass('selected', this.checked);

            // Update select-all jika semua terpilih
            let total = $('.row-checkbox').length;
            let checked = $('.row-checkbox:checked').length;
            $('#select-all').prop('checked', total === checked && total > 0);
        });

        // === Cegah klik di tombol action ikut select ===
        $('#data-table').off('click', 'button, a').on('click', 'button, a', function (e) {
            e.stopPropagation();
        });
    },

    getPostData: () => {
        let data = {
            id: $('#id').val(),
            nama: $('#nama').val(),
            keterangan: $('#keterangan').val(),
        };
        return data;
    },
    submit: () => {
        let params = Aplikasi.getPostData();
        let _url = url.base_url(Aplikasi.moduleApi()) + 'submit';
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
                        Aplikasi.back();
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

        let _url = url.base_url(Aplikasi.moduleApi()) + 'delete/' + id;

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
                        if (typeof Aplikasi.getData === 'function') {
                            Aplikasi.getData();
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

    exportData: (elm) => {
        let params = {};
        params.format = $(elm).attr('format');
        params.subsidiary = $('#f-subsidiary').val();
        params.department = $('#f-department').val();
        params.job_title = $('#f-job_title').val();

        let _url = url.base_url(Aplikasi.module()) + 'export';

        window.location.href = _url + '?' + $.param(params);
    },
    deleteAll: () => {
        let $checked = $('.row-checkbox:checked');

        if ($checked.length === 0) {
            message.sweetError('Pilih data dulu!', 'Centang baris yang ingin dihapus.');
            return;
        }

        let ids = $checked.map(function () {
            return $(this).val();
        }).get();
        // return console.log(ids);

        Swal.fire({
            title: `Hapus ${ids.length} data?`,
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url.base_url(Aplikasi.moduleApi()) + 'delete_all',
                    type: 'POST',
                    data: { ids: ids },
                    dataType: 'json',
                    headers: { 'Authorization': 'Bearer ' + Token.get() },
                    success: function (res) {
                        message.sweetSuccess(res.message || 'Data berhasil dihapus');
                        Aplikasi.getData();
                    },
                    error: function (xhr) {
                        let msg = xhr.responseJSON?.message || 'Gagal menghapus data';
                        message.sweetError('Error', msg);
                    }
                });
            }
        });
    }


};

$(function () {
    Aplikasi.getData();
    $('.select2').select2({
        // theme: 'bootstrap4',
        // placeholder: "Select Parent Employee",
        // allowClear: true,
        width: '100%'
    });

    // $("#data-table").on("click", "tr", function () {
    //     $(this).toggleClass("selected");
    // });
});
