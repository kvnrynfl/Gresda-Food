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
$hasRightIconClass = ($type === 'password') ? 'pr-10' : 'pr-4';
?>

<div class="mb-4">
    <?php if($label): ?>
        <label for="<?= htmlspecialchars($name) ?>" class="block text-sm font-semibold text-gray-700 mb-1.5"><?= htmlspecialchars($label) ?></label>
    <?php endif; ?>
    
    <div class="relative group">
        <?php if($icon): ?>
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="<?= $icon ?> text-gray-400 group-hover:text-primary transition-colors duration-300"></i>
            </div>
        <?php endif; ?>
        
        <input 
            type="<?= htmlspecialchars($type) ?>" 
            id="<?= htmlspecialchars($name) ?>" 
            name="<?= htmlspecialchars($name) ?>" 
            class="w-full <?= $hasIconClass ?> <?= $hasRightIconClass ?> py-3 border border-gray-200 rounded-xl focus:ring-4 focus:ring-primary/10 focus:border-primary transition duration-300 bg-gray-50/50 hover:bg-gray-50 focus:bg-white text-gray-800 placeholder-gray-400 <?= $class ?>" 
            placeholder="<?= htmlspecialchars($placeholder) ?>" 
            value="<?= htmlspecialchars($value) ?>" 
            <?= $required ?>
        >
        
        <?php if($type === 'password'): ?>
            <button type="button" onclick="togglePasswordVisibility('<?= htmlspecialchars($name) ?>', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-primary transition-colors focus:outline-none" tabindex="-1">
                <i class="fas fa-eye"></i>
            </button>
        <?php endif; ?>
    </div>
</div>

<?php if($type === 'password' && !isset($GLOBALS['password_toggle_script_added'])): ?>
    <?php $GLOBALS['password_toggle_script_added'] = true; ?>
    <script>
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
<?php endif; ?>
