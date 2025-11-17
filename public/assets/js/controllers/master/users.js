// make a global variable const update dan const delete
const update = $('#update').val();
const del = $('#delete').val();

let Users = {
    module: () => 'master/users',
    moduleApi: () => 'api/' + Users.module(),

    moduleEmployee: () => 'master/employee',
    moduleEmployeeApi: () => 'api/' + Users.moduleEmployee(),


    add: () => {
        let _url = url.base_url(Users.module()) + 'create';
        window.location.href = _url;
    },
    edit: (id) => {
        let _url = url.base_url(Users.module()) + 'edit/' + id;
        window.location.href = _url;
    },
    detail: (id) => {
        let _url = url.base_url(Users.module()) + 'detail/' + id;
        window.location.href = _url;
    },
    back: () => {
        let _url = url.base_url(Users.module());
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
                url: url.base_url(Users.moduleApi()) + 'getData',
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
                            btn += `<button class="btn btn-sm btn-info" onclick="Users.detail(${row.id})"><i class="bx bx-detail"></i></button> `;
                            btn += `<button class="btn btn-sm btn-warning" onclick="Users.edit(${row.id})"><i class="bx bx-edit"></i></button> `;
                        }
                        if (del == 1) {
                            btn += `<button class="btn btn-sm btn-danger" onclick="Users.delete(this,event)" data-id="${row.id}"><i class="bx bx-trash"></i></button>`;
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
        let params = Users.getPostData();
        let _url = url.base_url(Users.moduleApi()) + 'submit';
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
                        Users.back();
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

        let _url = url.base_url(Users.moduleApi()) + 'delete/' + id;

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
                        if (typeof Users.getData === 'function') {
                            Users.getData();
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

    showDataKaryawan: (elm) => {
        let params = {};

        $.ajax({
            type: 'POST',
            dataType: 'html',
            data: params,
            url: url.base_url(Users.moduleApi()) + "showDataKaryawan",

            headers: {
                'Authorization': 'Bearer ' + Token.get(),
            },

            beforeSend: () => {
                message.loadingProses('Proses Pengambilan Data');
            },

            error: function () {
                message.closeLoading();
                message.sweetError('Informasi', 'Gagal');
            },

            success: function (resp) {
                message.closeLoading();
                $('#content-modal-form').html(resp);
                $('#btn-show-modal').trigger('click');
                Users.getDataEmployee();
            }
        });
    },

    getDataEmployee: () => {
        let params = {};
        params.subsidiary = $('#f-subsidiary').val();
        params.department = $('#f-department').val();
        params.job_title = $('#f-job_title').val();

        if ($.fn.DataTable.isDataTable('#data-table')) {
            $('#data-table').DataTable().destroy();
        }

        let table = $('#data-table-employee').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            destroy: true,
            aLengthMenu: [[25, 50, 100], [25, 50, 100]],
            ajax: {
                url: url.base_url(Users.moduleEmployeeApi()) + 'getData',
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
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    className: 'text-center align-middle',
                    render: function (data, type, row) {
                        let button_action = `<button type="button" name="${row.name}" onclick="Users.pilihData(this, event)" data_code_employee="${row.employee_code}" class="btn btn-info editable-submit btn-sm waves-effect waves-light"><i class="bx bx-edit"></i></button>&nbsp;`;
                        return `<div class="d-flex justify-content-center gap-1">${button_action}</div>`;
                    }
                },
                { data: 'DT_RowIndex', searchable: false, orderable: false },
                { data: 'employee_code' },
                { data: 'name' },
                { data: 'job_title' },
                { data: 'company' },
                { data: 'department' },
                { data: 'contact' },
                { data: 'email' },
                { data: 'address' },
                { data: 'created_at' }

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

    pilihData: (elm, e) => {
        e.preventDefault();
        let name = $(elm).attr('name');
        let employee_code = $(elm).attr('data_code_employee');

        $('#employee').val(employee_code);
        $('#name').val(name);
        $('button.btn-close').trigger('click');
    },






};

$(function () {
    Users.getData();
    $('.select2').select2({
        // theme: 'bootstrap4',
        // placeholder: "Select Parent Users",
        // allowClear: true,
        width: '100%'
    });
});
