<?php include '../app/views/layouts/header.php'; ?>

<!-- Page Header -->
<div class="relative bg-secondary text-white pt-32 pb-20 overflow-hidden">
    <!-- Decorative background blobs -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-20 pointer-events-none">
        <div class="absolute -top-[20%] -right-[10%] w-[50%] h-[150%] bg-gradient-to-b from-primary to-transparent rounded-full blur-3xl transform rotate-45"></div>
        <div class="absolute top-[40%] -left-[20%] w-[60%] h-[100%] bg-gradient-to-t from-cyan-600 to-transparent rounded-full blur-3xl transform -rotate-12"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center animate-fade-in-up z-10">
        <h1 class="text-5xl md:text-6xl font-black mb-6 tracking-tight drop-shadow-lg"><?= htmlspecialchars($title) ?></h1>
        <p class="text-gray-200 text-lg md:text-xl max-w-2xl mx-auto font-light mb-8">Jelajahi pilihan hidangan premium buatan kami yang dirancang untuk memberi Anda pengalaman kuliner yang tak terlupakan.</p>
    </div>
</div>

<!-- Main Layout -->
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Left Sidebar (Filters & Search) -->
            <div class="lg:w-1/4 flex-shrink-0 space-y-8">
                
                <!-- Search Box -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-widest mb-4">Cari Menu</h3>
                    <form action="<?= BASEURL ?>/menu<?= $active_category !== 'all' ? '/category/'.urlencode($active_category) : '' ?>" method="GET">
                        <div class="relative">
                            <input type="text" name="q" value="<?= htmlspecialchars($search_keyword ?? '') ?>" placeholder="Cari nama atau deskripsi..." class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition text-sm">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <?php if(!empty($active_sort)): ?>
                                <input type="hidden" name="sort" value="<?= htmlspecialchars($active_sort) ?>">
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="hidden">Cari</button>
                    </form>
                </div>

                <!-- Categories Vertical -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-widest mb-4">Kategori</h3>
                    <div class="space-y-2 flex flex-col">
                        <a href="<?= BASEURL ?>/menu<?= !empty($search_keyword) ? '?q='.urlencode($search_keyword).(!empty($active_sort) ? '&sort='.$active_sort : '') : (!empty($active_sort) ? '?sort='.$active_sort : '') ?>" class="block px-4 py-3 rounded-xl text-sm font-medium transition <?= ($active_category === 'all') ? 'bg-primary text-white shadow-md' : 'text-gray-600 hover:bg-cyan-50 hover:text-cyan-700' ?>">
                            Semua Menu
                        </a>
                        <?php foreach($categories as $cat): ?>
                            <a href="<?= BASEURL ?>/menu/category/<?= urlencode($cat['category']) ?><?= !empty($search_keyword) ? '?q='.urlencode($search_keyword).(!empty($active_sort) ? '&sort='.$active_sort : '') : (!empty($active_sort) ? '?sort='.$active_sort : '') ?>" class="block px-4 py-3 rounded-xl text-sm font-medium transition <?= ($active_category === $cat['category']) ? 'bg-primary text-white shadow-md' : 'text-gray-600 hover:bg-cyan-50 hover:text-cyan-700' ?>">
                                <?= htmlspecialchars($cat['name']) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Right Content (Top Controls & Food Grid) -->
            <div class="lg:w-3/4 flex-grow flex flex-col">
                
                <!-- Sort Controls & Result Count -->
                <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4 px-2">
                    <div class="text-gray-600 text-sm font-medium">
                        Menampilkan <span class="font-bold text-gray-900"><?= count($foods) ?></span> menu 
                        <?php if(!empty($search_keyword)): ?>
                            untuk pencarian "<span class="italic font-bold text-secondary"><?= htmlspecialchars($search_keyword) ?></span>"
                        <?php endif; ?>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <label class="text-sm text-gray-500 font-medium whitespace-nowrap">Urutkan:</label>
                        <select onchange="updateSort(this.value)" class="bg-white border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5 shadow-sm outline-none cursor-pointer">
                            <option value="newest" <?= $active_sort === 'newest' ? 'selected' : '' ?>>Terbaru</option>
                            <option value="price_asc" <?= $active_sort === 'price_asc' ? 'selected' : '' ?>>Harga: Rendah ke Tinggi</option>
                            <option value="price_desc" <?= $active_sort === 'price_desc' ? 'selected' : '' ?>>Harga: Tinggi ke Rendah</option>
                        </select>
                    </div>
                </div>

                <!-- Grid -->
                <?php if(empty($foods)): ?>
                    <div class="text-center py-20 text-gray-500 bg-white rounded-3xl border border-gray-100 shadow-sm flex-grow flex flex-col items-center justify-center">
                        <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-search text-4xl text-gray-300"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-700 mb-2">Menu tidak ditemukan</h3>
                        <p>Coba gunakan kata kunci lain atau hapus filter kategori.</p>
                        <a href="<?= BASEURL ?>/menu" class="mt-6 px-6 py-2.5 bg-primary text-white font-semibold rounded-full hover:bg-cyan-700 transition">Reset Pencarian</a>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach($foods as $food): ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100/50 hover:shadow-2xl hover:border-cyan-100 transition-all duration-300 flex flex-col overflow-hidden group transform hover:-translate-y-1 cursor-pointer food-card"
                         data-name="<?= htmlspecialchars($food['name']) ?>"
                         data-price="Rp <?= number_format($food['price'] ?? 0, 0, ',', '.') ?>"
                         data-image="<?= BASEURL ?>/images/foods/<?= htmlspecialchars($food['image_name']) ?>"
                         data-description="<?= htmlspecialchars($food['description']) ?>">
                        <div class="relative h-64 overflow-hidden bg-gray-100">
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-transparent to-transparent group-hover:from-gray-900/60 transition-all z-10"></div>
                            <img src="<?= BASEURL ?>/images/foods/<?= htmlspecialchars($food['image_name']) ?>" alt="<?= htmlspecialchars($food['name']) ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700 ease-in-out" onerror="this.src='https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=800&q=80'">
                            <div class="absolute bottom-4 left-4 z-20">
                                <span class="bg-white text-secondary font-black px-4 py-1.5 rounded-full shadow-lg text-lg ring-4 ring-white/30 truncate block max-w-full">
                                    Rp <?= number_format($food['price'] ?? 0, 0, ',', '.') ?>
                                </span>
                            </div>
                        </div>
                        <div class="p-6 flex-grow flex flex-col relative bg-white">
                            <div class="mb-4 flex-grow">
                                <h4 class="text-xl font-bold text-gray-800 leading-tight group-hover:text-cyan-700 transition-colors line-clamp-2"><?= htmlspecialchars($food['name']) ?></h4>
                                <!-- Deskripsi disembunyikan sesuai permintaan, ditampilkan di popup -->
                            </div>
                            <div class="mt-auto pt-4 border-t border-gray-50">
                                <form action="<?= BASEURL ?>/customer/addToCart" method="POST">
                                    <input type="hidden" name="food_id" value="<?= $food['food_id'] ?>">
                                    <input type="hidden" name="qty" value="1">
                                    <button type="submit" class="w-full py-2.5 bg-gray-50 border border-gray-200 text-secondary font-semibold text-sm rounded-xl hover:bg-primary hover:border-primary hover:text-white transition-all flex items-center justify-center gap-2 group/btn relative overflow-hidden">
                                        <span class="relative z-10 flex items-center gap-2"><i class="fas fa-cart-plus text-base"></i> Tambah Keranjang</span>
                                        <div class="absolute inset-0 h-full w-0 bg-primary transition-all duration-300 ease-out group-hover/btn:w-full z-0"></div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
    function updateSort(val) {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('sort', val);
        window.location.search = urlParams.toString();
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.food-card').forEach(card => {
            card.addEventListener('click', (e) => {
                // Ignore clicks on Add To Cart button
                if (e.target.closest('form')) return;

                const name = card.getAttribute('data-name');
                const price = card.getAttribute('data-price');
                const img = card.getAttribute('data-image');
                const desc = card.getAttribute('data-description');

                Swal.fire({
                    html: `
                        <div class="text-left mt-2">
                            <img src="${img}" class="w-full h-64 object-cover rounded-2xl mb-6 shadow-sm bg-gray-100" alt="${name}" onerror="this.src='https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=800&q=80'">
                            <h2 class="text-2xl font-black text-gray-800 mb-2">${name}</h2>
                            <p class="text-primary font-bold text-xl mb-4">${price}</p>
                            <div class="w-12 h-1 bg-gray-200 rounded-full mb-4"></div>
                            <p class="text-gray-600 leading-relaxed text-sm whitespace-pre-wrap">${desc}</p>
                        </div>
                    `,
                    showConfirmButton: true,
                    confirmButtonText: 'Tutup Detail',
                    confirmButtonColor: '#2D3748',
                    customClass: {
                        popup: 'rounded-[2rem] p-2',
                        confirmButton: 'rounded-full px-8 py-3 font-semibold'
                    }
                });
            });
        });
    });
</script>

<style>
    /* Hide scrollbar for category menu but allow scrolling */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
</style>

<?php include '../app/views/layouts/footer.php'; ?>
