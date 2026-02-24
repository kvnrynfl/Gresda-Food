<?php
/**
 * Generic Input Component
 * 
 * Variables from $props array:
 * - name: (string) input name/id
 * - label: (string) Label text
 * - type: (string) Input type ('text', 'email', 'password', 'number', etc)
 * - placeholder: (string) Placeholder text
 * - icon: (string) FontAwesome class e.g., 'fas fa-user'
 * - value: (string) Default value
 * - required: (bool) Default false
 * - class: (string) Additional classes for the input field
 */
extract($props ?? []);

$name = $name ?? '';
$label = $label ?? '';
$type = $type ?? 'text';
$placeholder = $placeholder ?? '';
$icon = $icon ?? '';
$value = $value ?? '';
$required = isset($required) && $required ? 'required' : '';
$class = $class ?? '';

$hasIconClass = $icon ? 'pl-10' : 'pl-4';
?>

<div class="mb-4">
    <?php if($label): ?>
        <label for="<?= htmlspecialchars($name) ?>" class="block text-sm font-semibold text-gray-700 mb-1.5"><?= htmlspecialchars($label) ?></label>
    <?php endif; ?>
    
    <div class="relative">
        <?php if($icon): ?>
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="<?= $icon ?> text-gray-400"></i>
            </div>
        <?php endif; ?>
        
        <input 
            type="<?= htmlspecialchars($type) ?>" 
            id="<?= htmlspecialchars($name) ?>" 
            name="<?= htmlspecialchars($name) ?>" 
            class="w-full <?= $hasIconClass ?> pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors bg-gray-50/50 focus:bg-white text-gray-800 placeholder-gray-400 <?= $class ?>" 
            placeholder="<?= htmlspecialchars($placeholder) ?>" 
            value="<?= htmlspecialchars($value) ?>" 
            <?= $required ?>
        >
    </div>
</div>
