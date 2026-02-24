<?php
/**
 * Generic Card Component
 * 
 * Variables:
 * - $title: (string) Card title (optional)
 * - $description: (string) Card description (optional)
 * - $icon: (string) FontAwesome class for title (optional)
 * - $class: (string) Additional classes for the card wrapper
 * - $body_class: (string) Additional classes for the card body
 */
$title = $title ?? '';
$description = $description ?? '';
$icon = $icon ?? '';
$class = $class ?? '';
$body_class = $body_class ?? 'p-6 sm:p-8';
?>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden <?= $class ?>">
    <?php if($title || $description || isset($header_action)): ?>
        <div class="px-6 py-5 sm:px-8 sm:py-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
            <div>
                <?php if($title): ?>
                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <?php if($icon): ?><i class="<?= $icon ?> text-primary"></i><?php endif; ?>
                        <?= htmlspecialchars($title) ?>
                    </h3>
                <?php endif; ?>
                <?php if($description): ?>
                    <p class="mt-1 text-sm text-gray-500"><?= htmlspecialchars($description) ?></p>
                <?php endif; ?>
            </div>
            
            <?php if(isset($header_action)): ?>
                <div>
                    <?= $header_action ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <div class="<?= $body_class ?>">
        <?= $slot ?? '' ?>
    </div>
</div>
