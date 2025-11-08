let Auth = {
    module: () => 'auth',

    moduleApi: () => 'api/' + Auth.module(),

    signIn: (e) => {
        e.preventDefault(); // cegah reload

        let link_url = url.base_url(Auth.moduleApi()) + 'login';
        let params = {
            username: $('#username').val(),
            password: $('#password').val()
        };

        let form = $('#loginForm')[0];

        // 🔹 Jalankan validasi Bootstrap
        if (form.checkValidity() === false) {
            e.stopPropagation();
            form.classList.add('was-validated');
            return false;
        }

        $.ajax({
            type: "POST",
            url: link_url,
            data: params,
            dataType: "json",
            beforeSend: () => {
                message.loadingProses('Proses Simpan Data...');
            },
            success: function (response) {
                message.closeLoading();

                if (response.is_valid) {
                    // Simpan token & data user di localStorage
                    localStorage.setItem('auth_token', response.token);
                    localStorage.setItem('auth_user', JSON.stringify(response.data));

                    //  post ke web.php save_session
                    $.ajax({
                        type: "POST",
                        url: url.base_url('auth') + 'save_session',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        data: {
                            token: response.token,
                            user: JSON.stringify(response.data)
                        },
                        dataType: "json",
                        success: function (response) {
                            if (response.is_valid) {
                                window.location.href = url.base_url('dashboard');
                            }
                        }
                    })

                } else {
                    message.sweetError('Informasi', response.message || 'Login gagal!');
                }
            },
            error: function (xhr) {
                message.closeLoading();

                // 🧠 Ambil pesan dari response JSON (jika ada)
                let msg = 'Terjadi kesalahan pada server.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                } else if (xhr.statusText) {
                    msg = xhr.statusText;
                }

                console.log('Error:', xhr);
                message.sweetError('Informasi', msg);
            }
        });
    },

    signOut: () => {
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin logout?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Hapus data auth
                localStorage.removeItem('auth_token');
                localStorage.removeItem('auth_user');

                // Tampilkan pesan sukses lalu redirect
                Swal.fire({
                    title: 'Berhasil',
                    text: 'Anda telah logout.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });

                setTimeout(() => {
                    window.location.href = url.base_url('auth/login');
                }, 1500);
            }
        });
    }


};

$(function () {
    $('#loginForm').on('submit', Auth.signIn);
});
