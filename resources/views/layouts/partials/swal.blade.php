<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{!! session('success') !!}",
                timer: 3000,
                showConfirmButton: false,
                background: '#fff',
                iconColor: '#16a34a',
                customClass: {
                    popup: 'rounded-xl shadow-xl border border-gray-100'
                }
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{!! session('error') !!}",
                confirmButtonColor: '#ef4444',
                customClass: {
                    popup: 'rounded-xl shadow-xl border border-gray-100'
                }
            });
        @endif

        document.body.addEventListener('submit', function(e) {
            const form = e.target.closest('.delete-form');

            if (!form || form.dataset.confirmed) return;

            e.preventDefault();
            e.stopImmediatePropagation();

            const message = form.getAttribute('data-message') ||
                "Data yang dihapus tidak dapat dikembalikan!";
            const confirmText = form.getAttribute('data-confirm-text') || "Ya, Hapus!";

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: confirmText,
                cancelButtonText: 'Batal',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    popup: 'rounded-xl',
                    confirmButton: 'px-4 py-2 rounded-lg font-medium',
                    cancelButton: 'px-4 py-2 rounded-lg font-medium'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.dataset.confirmed = true;

                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Mohon tunggu sebentar.',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    form.submit();
                }
            });
        }, true);
    });
</script>
