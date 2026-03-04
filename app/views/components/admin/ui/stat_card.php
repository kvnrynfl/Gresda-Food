<?php
/**
 * Generic Admin Statistics Card Component
 * 
 * Variables:
 * - $title: (string) The title/label of the stat (e.g., 'Total Pengguna')
 * - $value: (string|int) The numeric or string value to display
 * - $icon: (string) FontAwesome class (e.g., 'fas fa-users')
 * - $color: (string) The base color namespace ('blue', 'green', 'purple', 'cyan', 'red', 'orange', 'indigo')
 */

$title = $title ?? 'Statistik';
$value = $value ?? '0';
$icon = $icon ?? 'fas fa-chart-bar';
$color = $color ?? 'indigo';

// Refined, high-end Vercel/Stripe style color maps
$colorMap = [
    'indigo' => ['bg' => 'bg-indigo-50/50',  'text' => 'text-indigo-600',  'ring' => 'ring-indigo-100',  'hover' => 'group-hover:text-indigo-500'],
    'blue'   => ['bg' => 'bg-blue-50/50',    'text' => 'text-blue-600',    'ring' => 'ring-blue-100',    'hover' => 'group-hover:text-blue-500'],
    'green'  => ['bg' => 'bg-emerald-50/50', 'text' => 'text-emerald-600', 'ring' => 'ring-emerald-100', 'hover' => 'group-hover:text-emerald-500'],
    'purple' => ['bg' => 'bg-purple-50/50',  'text' => 'text-purple-600',  'ring' => 'ring-purple-100',  'hover' => 'group-hover:text-purple-500'],
    'cyan'   => ['bg' => 'bg-cyan-50/50',    'text' => 'text-cyan-600',    'ring' => 'ring-cyan-100',    'hover' => 'group-hover:text-cyan-500'],
    'red'    => ['bg' => 'bg-rose-50/50',    'text' => 'text-rose-600',    'ring' => 'ring-rose-100',    'hover' => 'group-hover:text-rose-500'],
    'orange' => ['bg' => 'bg-orange-50/50',  'text' => 'text-orange-600',  'ring' => 'ring-orange-100',  'hover' => 'group-hover:text-orange-500'],
];

$c = $colorMap[$color] ?? $colorMap['indigo'];
?>

<div class="bg-white rounded-[16px] border border-slate-200/80 p-6 flex flex-col relative overflow-hidden group hover:shadow-[0_4px_24px_rgba(0,0,0,0.03)] hover:border-slate-300 transition-all duration-300 cursor-default">
    
    <!-- Top Row: Icon & Ambient Glow -->
    <div class="flex justify-between items-start mb-4 relative z-10 w-full">
        <!-- Ambient Icon Background -->
        <div class="w-12 h-12 rounded-2xl <?= $c['bg'] ?> ring-1 <?= $c['ring'] ?> flex items-center justify-center <?= $c['text'] ?> group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)]">
            <i class="<?= htmlspecialchars($icon) ?> text-[20px] drop-shadow-sm"></i>
        </div>
        
        <!-- Subtle Decor line -->
        <div class="w-8 h-1 rounded-full bg-slate-100 group-hover:bg-slate-200 transition-colors duration-300"></div>
    </div>
    
    <!-- Data Area -->
    <div class="relative z-10 mt-auto">
        <h3 class="text-3xl font-black text-slate-800 tracking-tight leading-none mb-1 <?= $c['hover'] ?> transition-colors duration-300"><?= htmlspecialchars($value) ?></h3>
        <p class="text-[12px] font-bold text-slate-500 uppercase tracking-wider leading-none"><?= htmlspecialchars($title) ?></p>
    </div>

    <!-- Decorative Corner Gradient -->
    <div class="absolute -right-12 -bottom-12 w-32 h-32 rounded-full bg-slate-50 opacity-0 group-hover:opacity-100 group-hover:scale-[1.5] transition-all duration-700 ease-out z-0 pointer-events-none blur-2xl"></div>
</div>
