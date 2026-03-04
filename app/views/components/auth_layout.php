<?php
/**
 * Auth Layout Component
 * Centralizes the background image wrapper, blurred overlay, and animated white card for Registration and Login pages.
 * 
 * Expected variables from parent view:
 * - $title: (string) Current page title
 * - $auth_heading: (string) Displayed header title inside the card
 * - $auth_subheading: (string) Displayed subtext below the heading
 * - $slot: (string) The captured HTML form content using ob_get_clean()
 */

if (!isset($auth_heading)) $auth_heading = $title ?? 'Autentikasi';
if (!isset($auth_subheading)) $auth_subheading = '';

// 1. Include global nav header
include '../app/views/layouts/header.php'; 
?>

<div class="min-h-screen bg-slate-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Premium Ambient Background -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-indigo-500/10 blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-violet-500/10 blur-[100px] pointer-events-none"></div>
        <div class="absolute top-[20%] right-[10%] w-[20%] h-[20%] rounded-full bg-emerald-500/5 blur-[80px] pointer-events-none"></div>
        <!-- Grid Pattern -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjEiIGZpbGw9InJnYmEoMTQ4LDE2MywxODQsMC4wNSkiLz48L3N2Zz4=')] [mask-image:linear-gradient(to_bottom,white,transparent)]"></div>
    </div>
    
    <!-- Auth Card Panel -->
    <div class="relative z-10 sm:mx-auto sm:w-full sm:max-w-[440px] animate-fade-in-up">
        
        <!-- Header Text Above Card -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-white rounded-[16px] shadow-sm border border-slate-200/60 mx-auto mb-6 flex items-center justify-center">
                <i class="fas fa-utensils text-[24px] text-indigo-600"></i>
            </div>
            <h2 class="text-[28px] font-black text-slate-900 tracking-tight leading-none mb-2"><?= htmlspecialchars($auth_heading) ?></h2>
            <?php if ($auth_subheading): ?>
                <p class="text-[14px] text-slate-500 font-medium px-4">
                    <?= htmlspecialchars($auth_subheading) ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="bg-white/80 backdrop-blur-xl py-10 px-6 sm:px-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-[24px] border border-slate-200/60 relative overflow-hidden">
            
            <!-- Structural Top Decoration -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 via-violet-500 to-fuchsia-500"></div>

            <!-- Error Handling -->
            <?php if (!empty($error)): ?>
                <div class="bg-rose-50 border border-rose-200/60 p-4 mb-8 rounded-[12px] flex items-start gap-3">
                    <i class="fas fa-exclamation-circle text-rose-500 mt-0.5"></i>
                    <p class="text-[13px] text-rose-700 font-bold leading-relaxed">
                        <?= $error ?>
                    </p>
                </div>
            <?php endif; ?>

            <!-- Injected Form Content -->
            <?= $slot ?>

        </div>
        
        <!-- Trust Indicators Footer -->
        <div class="mt-8 text-center">
            <p class="text-[12px] font-medium text-slate-400 flex items-center justify-center gap-2">
                <i class="fas fa-shield-alt"></i> Koneksi Terenkripsi & Aman
            </p>
        </div>
    </div>
</div>

<?php 
// 2. Include global footer
include '../app/views/layouts/footer.php'; 
?>
