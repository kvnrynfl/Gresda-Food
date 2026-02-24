<?php
/**
 * Master App Layout Component
 * Standardizes the 7xl container, white card wrapper, and header navigation.
 * 
 * Expected variables from parent view:
 * - $title: (string) Current page title
 * - $page_title: (string) Displayed header title (optional, defaults to $title)
 * - $back_link: (string) URL for the circular back button (optional, defaults to BASEURL.'/')
 * - $slot: (string) The captured HTML content using ob_get_clean()
 * - $hide_card: (bool) If true, renders $slot without the white card wrapper (default: false)
 */

if (!isset($page_title)) $page_title = $title ?? 'Gresda Food & Beverage';
if (!isset($back_link)) $back_link = BASEURL . '/';
if (!isset($hide_card)) $hide_card = false;

// 1. Include global nav header
include '../app/views/layouts/header.php'; 
?>

<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <?php if (!isset($hide_default_header) || !$hide_default_header): ?>
            <div class="flex justify-between items-center mb-8">
                <div class="w-full">
                    <?php 
                    // Temporarily alias $page_title to $title for the page_header component expectation
                    $title_cache = $title ?? '';
                    $title = $page_title;
                    $back_url = $back_link;
                    include '../app/views/components/ui/page_header.php';
                    $title = $title_cache; // Restore
                    ?>
                </div>
                <!-- Optional Header Action Slots (like Edit button) -->
                <?php if (isset($header_actions)): ?>
                    <div class="ml-4 flex-shrink-0">
                        <?= $header_actions ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Standardized Content Card -->
        <?php if ($hide_card): ?>
            <?= $slot ?>
        <?php else: ?>
            <?php 
            // The $slot is implicitly passed into card.php
            $class = "mb-6";
            include '../app/views/components/ui/card.php'; 
            ?>
        <?php endif; ?>
        
    </div>
</div>

<?php 
// 2. Include global footer
include '../app/views/layouts/footer.php'; 
?>
