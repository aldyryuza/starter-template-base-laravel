// Global permission
const update = $('#update').val();
const del = $('#delete').val();

let Routing = {
    currentRowId: null,

    // === MODULES ===
    module: () => 'settings/routing',
    moduleApi: () => 'api/' + Routing.module(),
    moduleDictionary: () => 'dictionary',
    moduleDictionaryApi: () => 'api/' + Routing.moduleDictionary(),
    moduleUsers: () => 'master/users',
    moduleUsersApi: () => 'api/' + Routing.moduleUsers(),

    // === NAVIGASI ===
    add: () => window.location.href = url.base_url(Routing.module()) + 'create',
    edit: (id) => window.location.href = url.base_url(Routing.module()) + 'edit/' + id,
    detail: (id) => window.location.href = url.base_url(Routing.module()) + 'detail/' + id,
    back: () => window.location.href = url.base_url(Routing.module()),

    // === INIT ===
    init() {
        this.bindEvents();
        this.getData();
        $('.select2').select2({ width: '100%' });
    },

    bindEvents() {
        const $body = $('#table-body');
        const $doc = $(document);

        // Tabel Utama
        $doc.on('click', '.btn-detail', (e) => Routing.detail($(e.currentTarget).data('id')));
        $doc.on('click', '.btn-edit', (e) => Routing.edit($(e.currentTarget).data('id')));
        $doc.on('click', '.btn-delete-main', (e) => Routing.delete(e.currentTarget, e));

        // Tabel Routing List
        $body.on('click', '.btn-add-row', () => this.addNewRow());
        $body.on('click', '.btn-delete-row', (e) => this.deleteRow(e.currentTarget));
        $body.on('click', '.btn-select-user', (e) => this.showDataUsers($(e.currentTarget).data('row')));
        $doc.on('click', '.btn-pick-user', (e) => this.pilihDataUsers(e.currentTarget));
    },

    // === DATATABLE UTAMA ===
    getData() {
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
            aLengthMenu: [[25, 50, 100], [25, 50, 100]],
            ajax: {
                url: url.base_url(Routing.moduleApi()) + 'getData',
                type: 'POST',
                headers: { 'Authorization': 'Bearer ' + Token.get() },
                dataSrc: (json) => json.data || [],
                error: (xhr) => {
                    if (xhr.status === 401) {
                        alert('Sesi habis. Login ulang.');
                        window.location.href = url.base_url('auth') + 'logout';
                    }
                }
            },
            columns: [
                { data: 'DT_RowIndex', searchable: false, orderable: false },
                { data: 'menu_name' },
                { data: 'remarks' },
                { data: 'subsidiary' },
                { data: 'department_name' },
                { data: 'created_at' },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: (data, type, row) => {
                        let btn = '';
                        if (update == 1) {
                            btn += `
                                <button class="btn btn-sm btn-info btn-detail" data-id="${row.id}" title="Detail">
                                    <i class="bx bx-detail"></i>
                                </button>
                                <button class="btn btn-sm btn-warning btn-edit" data-id="${row.id}" title="Edit">
                                    <i class="bx bx-edit"></i>
                                </button>`;
                        }
                        if (del == 1) {
                            btn += `
                                <button class="btn btn-sm btn-danger btn-delete-main" data-id="${row.id}" title="Hapus">
                                    <i class="bx bx-trash"></i>
                                </button>`;
                        }
                        return `<div class="d-flex justify-content-center gap-1">${btn}</div>`;
                    }
                }
            ],
            order: [[1, 'asc']]
        });
    },

    // === HAPUS DATA UTAMA ===
    delete(elm, e) {
        e.preventDefault();
        const id = $(elm).data('id');
        const _url = url.base_url(Routing.moduleApi()) + 'delete/' + id;

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus dan tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: _url,
                    type: 'DELETE',
                    headers: { 'Authorization': 'Bearer ' + Token.get() },
                    success: (res) => {
                        Swal.fire('Terhapus!', res.message || 'Data berhasil dihapus.', 'success');
                        Routing.getData();
                    },
                    error: (xhr) => {
                        Swal.fire('Gagal!', xhr.responseJSON?.message || 'Gagal menghapus.', 'error');
                    }
                });
            }
        });
    },

    // === TAMBAH BARIS BARU ===
    addNewRow() {
        const rowId = 'temp-' + Date.now(); // ID unik

        const rowHtml = `
        <tr class="temp-row" data-row-id="${rowId}">
            <td class="text-center">
                <select class="form-control select2 routing-type-select" style="width:100%" required>
                    <option value="">Loading...</option>
                </select>
            </td>
            <td class="text-center">
                <div class="input-group">
                    <button type="button" class="btn btn-success btn-select-user" data-row="${rowId}">
                        Select
                    </button>
                    <input type="text" class="form-control user-name" placeholder="Pilih user..." readonly>
                    <input type="hidden" class="user-id">
                </div>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm btn-delete-row">
                    <i class="bx bx-trash"></i>
                </button>
            </td>
        </tr>`;

        $('.add-row-placeholder').before(rowHtml);

        // Init Select2
        const $select = $(`[data-row-id="${rowId}"] .routing-type-select`).select2({
            placeholder: "Pilih Routing Type",
            allowClear: true
        });

        // Load data routing type
        this.loadRoutingTypes(rowId);
    },

    deleteRow(btn) {
        $(btn).closest('tr').remove();
    },

    // === MODAL USER ===
    showDataUsers(rowId) {
        this.currentRowId = rowId;
        // return console.log(rowId);
        $.ajax({
            url: url.base_url(Routing.moduleUsersApi()) + "showDataUsers",
            type: 'POST',
            headers: { 'Authorization': 'Bearer ' + Token.get() },
            beforeSend: () => message.loadingProses('Memuat data users...'),
            success: (resp) => {
                message.closeLoading();
                $('#content-modal-form').html(resp);
                $('#btn-show-modal').trigger('click');
                this.getDataUsers();
            },
            error: () => {
                message.closeLoading();
                alert('Gagal memuat data user.');
            }
        });
    },

    getDataUsers() {
        if ($.fn.DataTable.isDataTable('#data-table-users')) {
            $('#data-table-users').DataTable().destroy();
        }

        $('#data-table-users').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: url.base_url(Routing.moduleUsersApi()) + 'getData',
                type: 'POST',
                headers: { 'Authorization': 'Bearer ' + Token.get() },
                dataSrc: 'data'
            },
            columns: [
                {
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: (data) => `
                        <button class="btn btn-info btn-sm btn-pick-user"
                                data-id="${data.id}" data-name="${data.name}">
                            <i class="bx bx-check"></i>
                        </button>`
                },
                // { data: 'DT_RowIndex' },
                { data: 'name' },
                { data: 'username' },
                { data: 'roles_name' },
                { data: 'created_at' }
            ],
            order: [[1, 'asc']]
        });
    },

    pilihDataUsers(btn) {
        const userId = $(btn).data('id');
        const userName = $(btn).data('name');
        const rowId = this.currentRowId;

        if (!rowId) return alert('Error: Baris tidak ditemukan.');

        const $row = $(`[data-row-id="${rowId}"]`);
        $row.find('.user-name').val(userName);
        $row.find('.user-id').val(userId);

        $('button.btn-close').trigger('click');
    },

    loadRoutingTypes(rowId) {
        $.post({
            url: url.base_url(Routing.moduleDictionaryApi()) + 'getListApproval',
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            success: (res) => {
                if (res.is_valid && res.data?.length) {
                    let opts = '<option value="">-- Pilih Routing Type --</option>';
                    res.data.forEach(item => {
                        opts += `<option value="${item.term_id}">${item.keterangan}</option>`;
                    });
                    $(`[data-row-id="${rowId}"] .routing-type-select`).html(opts).val('').trigger('change');
                }
            },
            error: () => {
                $(`[data-row-id="${rowId}"] .routing-type-select`).html('<option value="">Gagal</option>');
            }
        });
    },

    // === AMBIL DATA UNTUK SIMPAN ===
    getPostData() {
        return {
            id: $('#id').val(),
            menu: $('#menu').val(),
            subsidiary: $('#subsidiary').val() || null,
            department: $('#department').val() || null,
            remarks: $('#remarks').val(),
            routing_list: this.getPostRoutingList()  // pasti array
        };
    },

    getPostRoutingList() {
        const list = [];

        $('#table-body tr').each(function () {
            const $row = $(this);

            // Skip placeholder/tombol add
            if ($row.hasClass('add-row-placeholder')) return;

            const routingType = $row.find('.routing-type-select').val();
            const userId = $row.find('.user-id').val();  // ini hidden input atau select2?

            // Hanya tambahkan jika keduanya terisi
            // Tapi kalau kosong, tetap lanjut (tidak error)
            if (routingType && userId) {
                const isNew = $row.hasClass('new-row');
                const detailId = isNew ? null : $row.data('routing-detail-id');

                list.push({
                    routing_detail_id: detailId,
                    routing_type_id: routingType,
                    user_id: userId
                });
            }
        });

        return list;  // selalu array, bisa kosong []
    },

    // === SIMPAN ===
    submit() {
        if (validation.run() !== 1) return;

        const params = this.getPostData();
        const _url = url.base_url(Routing.moduleApi()) + 'submit';

        $.ajax({
            url: _url,
            type: 'POST',
            data: params,
            headers: { 'Authorization': 'Bearer ' + Token.get() },
            beforeSend: () => message.loadingProses('Proses Simpan...'),
            success: (res) => {
                message.closeLoading();
                if (res.is_valid) {
                    message.sweetSuccess(res.message);
                    Routing.back();
                } else {
                    message.sweetError(res.message);
                }
            },
            error: (xhr) => {
                message.closeLoading();
                message.sweetError(xhr.responseJSON?.message || 'Gagal menyimpan.');
            }
        });
    }
};

// === JALANKAN ===
$(document).ready(() => Routing.init());
