<?php
/**
 * Generic Badge Component
 * 
 * Variables from $props array:
 * - text: (string) Badge text
 * - variant: (string) 'success', 'warning', 'danger', 'info', 'gray' (default: 'gray')
 * - icon: (string) FontAwesome class (optional)
 * - class: (string) Additional classes
 */
extract($props ?? []);

$text = $text ?? '';
$variant = $variant ?? 'gray';
$icon = $icon ?? '';
$class = $class ?? '';

$variants = [
    'success' => 'bg-green-100 text-green-700 border-green-200',
    'warning' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
    'danger' => 'bg-red-100 text-red-700 border-red-200',
    'info' => 'bg-cyan-100 text-primary border-cyan-200',
    'gray' => 'bg-gray-100 text-gray-700 border-gray-200',
];

$variantClasses = $variants[$variant] ?? $variants['gray'];
$finalClass = trim("inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border shadow-sm $variantClasses $class");
?>
<span class="<?= $finalClass ?>">
    <?php if($icon): ?><i class="<?= $icon ?>"></i><?php endif; ?>
    <?= htmlspecialchars($text) ?>
</span>
