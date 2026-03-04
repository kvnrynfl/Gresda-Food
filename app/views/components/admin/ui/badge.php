<?php
/**
 * Generic Admin Status Badge Component
 * 
 * Variables:
 * - $text: (string) The text to display inside the badge
 * - $color: (string) The base color namespace ('green', 'blue', 'orange', 'cyan', 'red', 'indigo', 'gray', 'yellow')
 * - $icon: (string|bool) Optional FontAwesome class (e.g., 'fas fa-check-circle'). If not provided, no icon is shown.
 * - $pulse: (bool) Whether the badge should have a pulsing animation (good for pending states)
 * - $ring: (bool) Whether the badge should have a subtle border ring
 */

$text = $text ?? 'Status';
$color = $color ?? 'gray';
$icon = $icon ?? false;
$pulse = $pulse ?? false;
$ring = $ring ?? true; // Default to true in the new design

// Refined Pastel + Ring Color Map
$colorMap = [
    'green'  => 'bg-emerald-50 text-emerald-700 ring-emerald-500/20',
    'blue'   => 'bg-blue-50 text-blue-700 ring-blue-500/20',
    'orange' => 'bg-orange-50 text-orange-700 ring-orange-500/20',
    'cyan'   => 'bg-cyan-50 text-cyan-700 ring-cyan-500/20',
    'red'    => 'bg-rose-50 text-rose-700 ring-rose-500/20',
    'indigo' => 'bg-indigo-50 text-indigo-700 ring-indigo-500/20',
    'gray'   => 'bg-slate-50 text-slate-700 ring-slate-500/20',
    'yellow' => 'bg-amber-50 text-amber-700 ring-amber-500/20'
];

$c = $colorMap[$color] ?? $colorMap['gray'];

$baseClasses = "inline-flex items-center gap-1.5 px-2.5 py-1 rounded-[8px] font-extrabold text-[11px] tracking-wide uppercase transition-colors";
if ($pulse) $baseClasses .= " animate-pulse border border-transparent";
if ($ring && !$pulse) $baseClasses .= " ring-1 ring-inset";

$finalClass = trim("$baseClasses $c");
?>

<span class="<?= $finalClass ?>">
    <?php if($icon): ?><i class="<?= htmlspecialchars($icon) ?> opacity-75 mr-0.5"></i><?php endif; ?>
    <?= htmlspecialchars($text) ?>
</span>
