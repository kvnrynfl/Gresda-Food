<?php
    // Fetch pending notifications for the topbar
    try {
        $db_notif = new Database();
        $db_notif->query("SELECT COUNT(*) as count FROM orders WHERE status IN ('pending_payment', 'confirmed')");
        $pending_count = $db_notif->single()['count'] ?? 0;
    } catch (Exception $e) {
        $pending_count = 0; // Fallback if Database class is not in scope
    }
?>
<!-- Ultra-Modern Minimalist Navigation -->
<header class="h-20 bg-slate-50/80 backdrop-blur-xl flex items-center justify-between px-6 sm:px-10 z-30 sticky top-0 no-print transition-all">
    <div class="flex items-center gap-5">
        
        <!-- Mobile Interactive Menu Toggle -->
        <button @click="sidebarOpen = true" class="p-2 -ml-3 rounded-xl text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 lg:hidden focus:outline-none focus:ring-2 focus:ring-indigo-500/40 transition-all">
            <i class="fas fa-bars-staggered text-xl"></i>
        </button>
        
        <!-- Elegant Breadcrumbs / Dynamic Header Area -->
        <div class="hidden sm:flex flex-col">
            <h1 class="text-2xl font-black text-slate-800 tracking-tight leading-none"><?= $title ?? 'Gresda Dasbor' ?></h1>
            <div class="flex items-center mt-1.5 opacity-90">
                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 block mr-2 shadow-[0_0_8px_rgba(99,102,241,0.8)]"></span>
                <p class="text-[11px] font-bold text-slate-500 uppercase tracking-widest"><?= date('l, d M Y') ?></p>
            </div>
        </div>
    </div>

    <!-- Action Clusters (Right Side) -->
    <div class="flex items-center gap-5 sm:gap-7">
        
        <!-- Notification Bubble -->
        <a href="<?= BASEURL ?>/admin/orders" class="relative p-2 rounded-xl text-slate-400 hover:bg-white hover:text-indigo-600 transition-all focus:outline-none flex items-center justify-center hover:shadow-sm" title="<?= $pending_count ?> Pesanan Terkini">
            <i class="far fa-bell text-[18px]"></i>
            <?php if($pending_count > 0): ?>
            <span class="absolute top-1 right-1 w-4 h-4 rounded-full bg-rose-500 ring-2 ring-slate-50 text-[9px] font-bold text-white flex items-center justify-center shadow-sm transform -translate-y-1 translate-x-1">
                <?= $pending_count > 99 ? '99+' : $pending_count ?>
            </span>
            <span class="absolute top-1 right-1 w-4 h-4 rounded-full bg-rose-500 animate-ping opacity-30 transform -translate-y-1 translate-x-1"></span>
            <?php endif; ?>
        </a>

        <!-- Divider -->
        <div class="h-5 w-[1px] bg-slate-200 hidden sm:block"></div>

        <!-- Sleek Profile Dropdown (Alpine powered) -->
        <div class="relative" x-data="{ userMenuOpen: false }">
            <button @click="userMenuOpen = !userMenuOpen" @click.outside="userMenuOpen = false" class="flex items-center gap-3 focus:outline-none cursor-pointer group rounded-full p-1 hover:bg-white hover:shadow-sm transition-all pr-4">
                <div class="relative">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['username'] ?? 'Admin') ?>&background=4f46e5&color=fff&bold=true&rounded=true&font-size=0.4" class="h-9 w-9 rounded-full object-cover">
                    <!-- Status dot indicator -->
                    <div class="absolute bottom-0 right-0 max-w-none w-2.5 h-2.5 bg-emerald-500 border-[1.5px] border-white rounded-full"></div>
                </div>
                <div class="text-left hidden md:block">
                    <p class="text-[13px] font-bold text-slate-700 leading-tight group-hover:text-indigo-600 transition-colors"><?= htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username'] ?? 'Administrator') ?></p>
                    <p class="text-[10px] text-slate-500 font-medium tracking-wide mt-0.5">Akses Penuh</p>
                </div>
                <i class="fas fa-chevron-down text-[10px] text-slate-300 group-hover:text-indigo-500 transition-transform duration-300 ml-1 block" :class="userMenuOpen ? 'rotate-180 text-indigo-500' : ''"></i>
            </button>

            <!-- Popover Dropmenu -->
            <div x-show="userMenuOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                 class="absolute right-0 mt-3 w-64 bg-white/95 backdrop-blur-3xl rounded-2xl shadow-[0_20px_60px_-15px_rgba(0,0,0,0.15)] border border-slate-100 overflow-hidden z-50 transform origin-top-right ring-1 ring-slate-900/5"
                 x-cloak>
                 
                <!-- Dropdown Header -->
                <div class="p-5 bg-gradient-to-br from-indigo-50/50 to-white border-b border-slate-100 flex flex-col items-center text-center">
                    <div class="w-14 h-14 bg-white border border-indigo-100 rounded-2xl flex items-center justify-center text-indigo-500 mb-3 shadow-sm rotate-3 hover:rotate-0 transition-transform">
                        <i class="fas fa-crown text-2xl drop-shadow-sm"></i>
                    </div>
                    <p class="text-[15px] text-slate-900 font-black truncate w-full tracking-tight">@<?= htmlspecialchars($_SESSION['username'] ?? 'admin') ?></p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Sesi Super Admin</p>
                </div>
                
                <!-- Dropdown Actions -->
                <div class="p-2 space-y-1">
                    <a href="<?= BASEURL ?>/admin/admins" class="flex items-center justify-between px-4 py-2.5 text-[13px] font-bold text-slate-600 rounded-xl hover:bg-slate-50 hover:text-indigo-600 transition-colors group">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-id-badge w-4 text-center text-slate-400 group-hover:text-indigo-500 transition-colors"></i> 
                            Pengaturan Akun
                        </div>
                        <i class="fas fa-angle-right text-[10px] text-slate-300 group-hover:text-indigo-500 group-hover:translate-x-1 transition-all"></i>
                    </a>
                </div>
                
                <!-- Quick Logout -->
                <div class="p-2 border-t border-slate-100 bg-slate-50/50">
                    <a href="<?= BASEURL ?>/auth/logout" class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-rose-600 rounded-xl hover:bg-rose-50 hover:text-rose-700 transition-colors font-extrabold group">
                        <i class="fas fa-power-off w-4 text-center group-hover:scale-110 transition-transform"></i>
                        Cabut Akses Sesi
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</header>
