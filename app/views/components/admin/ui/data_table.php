<?php
/**
 * Generic Admin DataTables Wrapper Component
 * 
 * Variables:
 * - $headers: (array) An array of arrays for the table headers.
 *   Format: [['text' => 'ID', 'class' => 'w-16'], ['text' => 'Name', 'class' => '']]
 * - $slot: (string) The pre-rendered <tbody> HTML content (rows).
 * - $empty_icon: (string) FontAwesome class for empty state (default: 'fas fa-folder-open')
 * - $empty_title: (string) Title for empty state
 * - $empty_message: (string) Message for empty state
 * - $is_empty: (bool) Whether the table has no data
 */

$headers = $headers ?? [];
$slot = $slot ?? '';
$is_empty = $is_empty ?? false;
$empty_icon = $empty_icon ?? 'fas fa-folder-open';
$empty_title = $empty_title ?? 'Tidak Ada Data';
$empty_message = $empty_message ?? 'Saat ini belum ada data untuk ditampilkan di tabel ini.';
?>

    <table class="w-full text-left datatable-override <?= !$is_empty ? 'datatable' : '' ?>">
        <thead>
            <tr>
                <?php foreach($headers as $th): ?>
                    <th class="<?= htmlspecialchars($th['class'] ?? '') ?>"><?= htmlspecialchars($th['text']) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php if(!$is_empty): ?>
                
                <?= $slot ?>
                
            <?php else: ?>
                <tr>
                    <td colspan="<?= count($headers) ?>" class="px-6 py-24 text-center">
                        <div class="mx-auto w-20 h-20 bg-slate-50 border border-slate-100 rounded-3xl flex items-center justify-center mb-5 rotate-3 hover:rotate-0 transition-transform">
                            <i class="<?= htmlspecialchars($empty_icon) ?> text-[32px] text-slate-300 drop-shadow-sm"></i>
                        </div>
                        <h3 class="text-xl font-black text-slate-800 mb-2 tracking-tight"><?= htmlspecialchars($empty_title) ?></h3>
                        <p class="text-sm font-medium text-slate-500 max-w-sm mx-auto"><?= htmlspecialchars($empty_message) ?></p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
