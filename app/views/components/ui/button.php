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

// Variant styles matching the new premium aesthetic
$variants = [
    'primary' => 'bg-indigo-600 text-white hover:bg-indigo-700 shadow-[0_4px_14px_0_rgba(79,70,229,0.39)] hover:shadow-[0_6px_20px_rgba(79,70,229,0.23)] hover:-translate-y-0.5 focus:ring-indigo-500',
    'secondary' => 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50 hover:text-slate-900 shadow-sm focus:ring-slate-500',
    'danger' => 'bg-rose-500 text-white hover:bg-rose-600 shadow-sm hover:shadow-rose-500/25 focus:ring-rose-500',
    'outline' => 'border-2 border-indigo-100 text-indigo-600 hover:bg-indigo-50 hover:border-indigo-200 focus:ring-indigo-500',
    'ghost' => 'text-slate-500 hover:bg-slate-100/80 hover:text-slate-900 focus:ring-slate-500',
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
