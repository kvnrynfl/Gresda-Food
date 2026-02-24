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

<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-[url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80')] bg-cover bg-center relative">
    <!-- Blurred Overlay -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm z-0"></div>
    
    <!-- Header Text -->
    <div class="relative z-10 sm:mx-auto sm:w-full sm:max-w-md animate-fade-in-up">
        <h2 class="text-center text-4xl font-extrabold text-white mb-2"><?= htmlspecialchars($auth_heading) ?></h2>
        <?php if ($auth_subheading): ?>
            <p class="mt-2 text-center text-sm text-gray-200">
                <?= htmlspecialchars($auth_subheading) ?>
            </p>
        <?php endif; ?>
    </div>

    <!-- Auth Card Panel -->
    <div class="relative z-10 mt-8 sm:mx-auto sm:w-full sm:max-w-md animate-fade-in-up" style="animation-delay: 0.1s;">
        <div class="bg-white py-10 px-6 shadow-[0_20px_50px_rgba(0,0,0,0.3)] sm:rounded-2xl sm:px-10 border border-gray-100/50 relative overflow-hidden">
            
            <!-- Cyan accent line top -->
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-cyan-400 to-primary"></div>

            <!-- Error Handling -->
            <?php if (!empty($error)): ?>
                <div class="bg-cyan-50 border-l-4 border-cyan-500 p-4 mb-6 rounded shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-cyan-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-cyan-700 font-medium">
                                <?= htmlspecialchars($error) ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Injected Form Content -->
            <?= $slot ?>

        </div>
    </div>
</div>

<?php 
// 2. Include global footer
include '../app/views/layouts/footer.php'; 
?>
