<!-- Mobile Sidebar Overlay (Alpine) -->
<div x-show="sidebarOpen" 
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden"
     @click="sidebarOpen = false"
     x-cloak></div>

<!-- Advanced Sidebar Structure: Premium Dark Mode -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed lg:static inset-y-0 left-0 z-50 w-[280px] bg-slate-950 border-r border-slate-800 shadow-2xl lg:shadow-none transform transition-transform duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] flex flex-col h-full lg:translate-x-0 print:hidden selection:bg-indigo-500/30">
    
    <!-- Bold Branding -->
    <div class="h-20 flex items-center px-8 shrink-0 border-b border-slate-800/60">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-cyan-400 flex items-center justify-center text-white shadow-lg shadow-indigo-500/20 mr-4 ring-1 ring-white/10">
            <i class="fas fa-layer-group text-xl"></i>
        </div>
        <div class="flex flex-col">
            <span class="text-xl font-black text-white tracking-tight leading-tight">Gresda<span class="text-indigo-400">Hub</span></span>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none mt-1">Admin Portal</span>
        </div>
    </div>

    <!-- Scrollable Navigation Core -->
    <div class="flex-1 overflow-y-auto px-4 py-6 scrollbar-hide">
        <nav class="space-y-1">
            <?php 
                $current_uri = $_SERVER['REQUEST_URI'];
                
                $nav_items = [
                    ['url' => '/admin/dashboard', 'icon' => 'fa-border-all', 'label' => 'Dasbor Utama'],
                    ['url' => '/admin/orders', 'icon' => 'fa-inbox', 'label' => 'Pesanan Masuk', 'badge' => 'Baru'],
                    ['url' => '/admin/categories', 'icon' => 'fa-folder-tree', 'label' => 'Kategori Menu'],
                    ['url' => '/admin/foods', 'icon' => 'fa-burger', 'label' => 'Daftar Menu'],
                    ['url' => '/admin/paymentMethods', 'icon' => 'fa-credit-card', 'label' => 'Metode Pembayaran'],
                ];
                
                $user_items = [
                    ['url' => '/admin/users', 'icon' => 'fa-users', 'label' => 'Daftar Pelanggan'],
                    ['url' => '/admin/admins', 'icon' => 'fa-user-shield', 'label' => 'Bagan Admin'],
                ];
                
                $comm_items = [
                    ['url' => '/admin/reviews', 'icon' => 'fa-star-half-stroke', 'label' => 'Ulasan Bisnis'],
                    ['url' => '/admin/contacts', 'icon' => 'fa-message', 'label' => 'Pesan Masuk'],
                ];

                function renderNavElements($items, $current_uri) {
                    foreach($items as $item) {
                        $isActive = strpos($current_uri, $item['url']) !== false;
                        
                        // Ultra premium dark mode active states
                        $activeClasses = $isActive 
                            ? 'bg-indigo-500/10 text-indigo-400 ring-1 ring-indigo-500/20 shadow-[inset_0_1px_0_0_rgba(255,255,255,0.05)]' 
                            : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 font-medium';
                            
                        $iconColor = $isActive ? 'text-indigo-400 drop-shadow-[0_0_8px_rgba(99,102,241,0.5)]' : 'text-slate-500 group-hover:text-slate-300';
                        
                        echo '<a href="'.BASEURL.$item['url'].'" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-300 '.$activeClasses.' mb-1.5 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 relative overflow-hidden">';
                        if($isActive) {
                            echo '<div class="absolute left-0 top-1/2 -translate-y-1/2 w-1.5 h-6 bg-indigo-500 rounded-r-full shadow-[0_0_10px_rgba(99,102,241,0.8)]"></div>';
                        }
                        echo '<div class="w-8 flex justify-center"><i class="fas '.$item['icon'].' text-[16px] transition-all duration-300 '.$iconColor.'"></i></div>';
                        echo '<span class="ml-2 text-[13.5px] font-semibold tracking-wide">'.htmlspecialchars($item['label']).'</span>';
                        if(isset($item['badge']) && $isActive) {
                            echo '<span class="ml-auto bg-indigo-500 text-white py-0.5 px-2 rounded font-black text-[9px] uppercase tracking-widest shadow-sm">'.$item['badge'].'</span>';
                        }
                        echo '</a>';
                    }
                }
            ?>
            
            <div class="px-5 pb-2 pt-2">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Katalog & Penjualan</p>
            </div>
            <?php renderNavElements($nav_items, $current_uri); ?>
            
            <div class="px-5 pb-2 pt-6">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Akses & Privilese</p>
            </div>
            <?php renderNavElements($user_items, $current_uri); ?>
            
            <div class="px-5 pb-2 pt-6">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Interaksi & Monitoring</p>
            </div>
            <?php renderNavElements($comm_items, $current_uri); ?>
        </nav>
    </div>

    <!-- Action Base -->
    <div class="p-5 border-t border-slate-800/60 bg-slate-900/30">
        <a href="<?= BASEURL ?>/auth/logout" class="flex items-center justify-center gap-3 w-full py-3 px-4 rounded-xl font-bold text-sm text-slate-300 bg-slate-800/80 hover:bg-rose-500/10 hover:text-rose-400 hover:ring-1 hover:ring-rose-500/30 transition-all duration-300 group">
            <i class="fas fa-power-off group-hover:animate-pulse"></i> <span>Akhiri Sesi</span>
        </a>
    </div>
</aside>
