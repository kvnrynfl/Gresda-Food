<?php
/**
 * Generic Page Header Component
 * 
 * Variables:
 * - $title: (string) Page Title
 * - $back_url: (string) URL for the back button (optional)
 */
$title = $title ?? 'Page Title';
$back_url = $back_url ?? '';
?>

<div class="flex items-center gap-4 mb-8">
    <?php if($back_url): ?>
        <a href="<?= htmlspecialchars($back_url) ?>" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-600 shadow-sm border border-gray-200 hover:bg-gray-50 hover:text-primary transition">
            <i class="fas fa-arrow-left"></i>
        </a>
    <?php endif; ?>
    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight"><?= htmlspecialchars($title) ?></h1>
</div>
