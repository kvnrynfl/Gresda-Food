<?php
/**
 * Generic Button Component
 * 
 * Variables from $props array:
 * - text: (string) Button text
 * - type: (string) 'submit', 'button', 'a' (default: 'button')
 * - href: (string) URL if type is 'a'
 * - variant: (string) 'primary', 'secondary', 'danger', 'outline', 'ghost' (default: 'primary')
 * - icon: (string) FontAwesome class e.g., 'fas fa-plus'
 * - class: (string) Additional custom classes
 * - w_full: (bool) Whether the button should be full width (w-full)
 */

extract($props ?? []);

$text = $text ?? 'Button';
$type = $type ?? 'button';
$href = $href ?? '#';
$variant = $variant ?? 'primary';
$icon = $icon ?? '';
$class = $class ?? '';
$w_full = isset($w_full) && $w_full ? 'w-full' : '';

// Base styles
$baseClasses = "inline-flex items-center justify-center gap-2 font-medium rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 px-6 py-2.5";

// Variant styles
$variants = [
    'primary' => 'bg-primary text-white hover:bg-cyan-600 shadow-sm focus:ring-primary',
    'secondary' => 'bg-gray-100 text-gray-700 hover:bg-gray-200 focus:ring-gray-500',
    'danger' => 'bg-red-500 text-white hover:bg-red-600 shadow-sm focus:ring-red-500',
    'outline' => 'border-2 border-primary text-primary hover:bg-cyan-50 focus:ring-primary',
    'ghost' => 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:ring-gray-500',
];

$variantClasses = $variants[$variant] ?? $variants['primary'];
$finalClass = trim("$baseClasses $variantClasses $w_full $class");
?>

<?php if ($type === 'a'): ?>
    <a href="<?= htmlspecialchars($href) ?>" class="<?= $finalClass ?>">
        <?php if ($icon): ?><i class="<?= $icon ?>"></i><?php endif; ?>
        <?= htmlspecialchars($text) ?>
    </a>
<?php else: ?>
    <button type="<?= htmlspecialchars($type) ?>" class="<?= $finalClass ?>">
        <?php if ($icon): ?><i class="<?= $icon ?>"></i><?php endif; ?>
        <?= htmlspecialchars($text) ?>
    </button>
<?php endif; ?>
