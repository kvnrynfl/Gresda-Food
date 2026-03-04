<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Portal' ?> - Gresda Food</title>
    
    <!-- Modern Geometry Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Solid & Clean Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DataTables & SweetAlert -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    
    <!-- Tailwind CSS configuration -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    colors: { 
                        primary: '#4f46e5', // High-end Indigo
                        secondary: '#0f172a'
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js interaction handler -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        /* Clean, Minimal Custom Webkit Scrollbars */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
        
        /* Ultimate Premium DataTables Modifications - Solid Rows Approach */
        table.dataTable.no-footer { border-bottom: none !important; }
        
        /* Main Table Container */
        .dataTables_wrapper .dataTables_scroll {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        table.dataTable { 
            border-collapse: collapse !important; 
            width: 100% !important; 
            margin-top: 1rem !important; 
            margin-bottom: 0 !important;
            border-radius: 12px;
            border-style: hidden;
            box-shadow: 0 0 0 1px #e2e8f0;
        }
        
        table.dataTable thead th { 
            background: #f8fafc !important; 
            border-bottom: 2px solid #e2e8f0 !important; 
            font-weight: 800; 
            color: #64748b; 
            text-transform: uppercase; 
            font-size: 0.75rem; 
            letter-spacing: 0.05em; 
            padding: 1rem 1.5rem !important;
        }
        
        /* Individual Row Styling - Solid Rows */
        table.dataTable tbody tr { 
            background: #ffffff;
            transition: background-color 0.2s ease;
        }
        
        table.dataTable tbody tr:hover { 
            background: #f8fafc;
        }

        /* Table Cells */
        table.dataTable tbody td { 
            padding: 1rem 1.5rem !important; 
            border-bottom: 1px solid #e2e8f0 !important;
            border-top: none !important;
            border-left: none !important;
            border-right: none !important;
            color: #1e293b; 
            font-size: 0.875rem;
            vertical-align: middle;
            background: transparent !important;
        }
        
        /* Remove bottom border on the very last row's cells */
        table.dataTable tbody tr:last-child td {
            border-bottom: none !important;
        }

        /* Pagination custom wrapper styling */
        .dataTables_wrapper .dataTables_paginate { margin-top: 1rem; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current, 
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #4f46e5 !important; color: white !important; border: none; border-radius: 10px; 
            box-shadow: 0 4px 10px -2px rgba(79, 70, 229, 0.4); font-weight: 800; font-size: 0.875rem; padding: 0.5rem 1rem;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button { 
            border-radius: 10px; border: transparent; transition: all 0.2s; padding: 0.5rem 1rem; font-weight: 700; font-size: 0.875rem; color: #64748b !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current) { 
            background: #f1f5f9 !important; color: #0f172a !important; border: transparent; 
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled { opacity: 0.5; }
        
        /* Interactive Filter & Length Menu */
        .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_info {
            color: #64748b; font-size: 0.8125rem; font-weight: 500;
        }
        .dataTables_wrapper .dataTables_length select {
            border: 2px solid #e2e8f0; border-radius: 10px; padding: 0.5rem 2.25rem 0.5rem 1rem; outline: none; margin: 0 0.75rem; transition: all 0.2s; background-color: #ffffff;
            -webkit-appearance: none; -moz-appearance: none; appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat; background-position: right 0.8rem center; background-size: 1.1em; font-weight: 700; font-size: 0.875rem; color: #1e293b; cursor: pointer;
        }
        .dataTables_wrapper .dataTables_length select:focus {
             border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); 
        }
        .dataTables_wrapper .dataTables_filter {
            color: #64748b; font-weight: 700; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em;
        }
        .dataTables_wrapper .dataTables_filter input { 
            border: 2px solid #e2e8f0; border-radius: 12px; padding: 0.6rem 1.25rem; outline: none; margin-left: 0.75rem; transition: all 0.3s; font-size: 0.875rem; background-color: #ffffff; font-weight: 600; min-width: 260px; text-transform: none; letter-spacing: normal;
        }
        .dataTables_wrapper .dataTables_filter input:focus { 
            border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        /* Global Focus outlines */
        *:focus-visible { outline: 2px solid rgba(79, 70, 229, 0.5); outline-offset: 1px; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased font-sans flex items-start h-screen overflow-hidden selection:bg-indigo-500/30 selection:text-indigo-900" x-data="{ sidebarOpen: false }">

    <!-- Sidebar Inclusion -->
    <?php include __DIR__ . '/sidebar.php'; ?>

    <!-- Master Layout Wrapper -->
    <div class="flex-1 flex flex-col h-screen relative w-full bg-slate-50 print:bg-white print:block print:h-auto print:overflow-visible">
        
        <!-- Top Navigation Inclusion -->
        <?php include __DIR__ . '/topbar.php'; ?>

        <!-- Active View Content Injection -->
        <main class="flex-1 overflow-x-hidden relative print:block print:overflow-visible overflow-y-auto" id="layout-main-content">
            <div class="p-6 sm:p-8 lg:p-10 max-w-[1700px] mx-auto w-full transition-all print:p-0 mt-0">
                <?= $slot ?? '' ?>
            </div>
            
            <!-- Global Footer text -->
            <footer class="text-center py-8 text-[13px] text-slate-400 font-bold tracking-wide mt-auto">
                &copy; <?= date('Y') ?> Gresda Food & Beverage.
            </footer>
        </main>
    </div>

    <!-- Essential Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    
    <!-- Central Setup Script -->
    <script>
        $(document).ready(function() {
            // Initiate unified DataTables
            if ($('.datatable').length > 0) {
                $('.datatable').DataTable({
                    responsive: true,
                    language: {
                        search: "Pencarian Pintar:",
                        lengthMenu: "Tampilkan _MENU_ entri",
                        info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                        infoEmpty: "Data table kosong",
                        infoFiltered: "(disaring dari _MAX_ total data)",
                        paginate: { first: "Awal", last: "Akhir", next: "&rarr;", previous: "&larr;" },
                        zeroRecords: "Pencarian tidak menemukan kecocokan di basis data"
                    },
                    pageLength: 10,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
                    dom: '<"flex flex-col sm:flex-row justify-between items-end mb-6 px-1 gap-4"<"text-[13px] font-bold text-slate-500 uppercase tracking-widest"l><"mt-2 sm:mt-0"f>>rt<"flex flex-col sm:flex-row justify-between items-center mt-8 px-1"<"text-[13px] font-bold text-slate-500 uppercase tracking-wide"i><"mt-4 sm:mt-0"p>>'
                });
            }
            // Universal Deletion Alert (Use Event Delegation for DataTables)
            $(document).on('submit', '.delete-form', function(e) {
                e.preventDefault();
                const form = this;
                const itemName = $(this).data('name') || 'item ini';
                
                Swal.fire({
                    title: 'Konfirmasi Destruktif',
                    html: `Tindakan ini permanen. Apakah Anda 100% yakin ingin menghapus <strong class="text-slate-800">${itemName}</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#f43f5e',
                    cancelButtonColor: '#f1f5f9',
                    confirmButtonText: 'Ya, Hapus Permanen!',
                    cancelButtonText: '<span class="text-slate-600 font-bold">Batal</span>',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-3xl shadow-2xl border border-slate-100 p-6',
                        title: 'text-2xl font-black text-slate-900',
                        htmlContainer: 'text-slate-500 font-medium',
                        confirmButton: 'px-6 py-3.5 rounded-xl font-bold hover:shadow-lg hover:shadow-rose-500/20 transition-all',
                        cancelButton: 'px-6 py-3.5 rounded-xl hover:bg-slate-200 transition-all mr-3'
                    }
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });

            // Modern Floating Toasts
            <?php if (isset($_SESSION['flash_msg'])): ?>
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    customClass: { 
                        popup: 'rounded-2xl shadow-xl border border-slate-100 mb-6 mr-6 !p-4',
                        title: 'text-[14px] leading-tight mt-0.5'
                    },
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                Toast.fire({
                    icon: '<?= $_SESSION['flash_type'] ?? 'success' ?>',
                    title: '<span class="font-bold text-slate-800 tracking-wide"><?= addslashes($_SESSION['flash_msg']) ?></span>'
                });
                <?php unset($_SESSION['flash_msg'], $_SESSION['flash_type']); ?>
            <?php endif; ?>
        });
    </script>
</body>
</html>
