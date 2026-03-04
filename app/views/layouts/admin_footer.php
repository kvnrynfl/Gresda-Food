        </main>
        <!-- Main section end -->
    </div>
    
    <!-- jQuery Core (Required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize all tables with the '.datatable' class
            if ($('.datatable').length > 0) {
                $('.datatable').DataTable({
                    responsive: true,
                    language: {
                        search: "Cari Data:",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                        infoFiltered: "(difilter dari _MAX_ total data)",
                        paginate: {
                            first: "Awal",
                            last: "Akhir",
                            next: "Selanjutnya",
                            previous: "Sebelumnya"
                        },
                        zeroRecords: "Tidak ditemukan data yang sesuai"
                    },
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]]
                });
            }

            // Global SweetAlert for Delete confirmations
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                const form = this;
                const itemName = $(this).data('name') || 'item ini';
                
                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    text: `Apakah Anda yakin ingin menghapus ${itemName}? Data yang dihapus tidak dapat dikembalikan!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#06b6d4', // cyan-500
                    cancelButtonColor: '#ef4444',  // red-500
                    confirmButtonText: 'Ya, Hapus Data!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'px-4 py-2 rounded-lg font-bold shadow-sm',
                        cancelButton: 'px-4 py-2 rounded-lg font-bold shadow-sm mr-3'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Handle Session Flash Messages for Toast Notifications
            <?php if (isset($_SESSION['flash_msg'])): ?>
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: '<?= $_SESSION['flash_type'] ?? 'success' ?>',
                    title: '<?= addslashes($_SESSION['flash_msg']) ?>'
                });
                
                <?php 
                    unset($_SESSION['flash_msg']);
                    unset($_SESSION['flash_type']); 
                ?>
            <?php endif; ?>
        });
    </script>
</body>
</html>
