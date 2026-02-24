<?php

class MenuController extends Controller {

    public function index() {
        $this->processMenuRequest('all');
    }
    
    public function category($slug = '') {
        $this->processMenuRequest($slug);
    }

    private function processMenuRequest($categorySlug) {
        $categoryModel = $this->model('CategoryModel');
        $foodModel = $this->model('FoodModel');
        
        // Get Filters from URL
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

        // Set active category and fetch data
        if ($categorySlug !== 'all') {
            $category = $categoryModel->getByCategorySlug($categorySlug);
            $data['title'] = 'Kategori: ' . ($category['name'] ?? 'Tidak Ditemukan');
            // Fallback if category invalid
            if (!$category) $categorySlug = 'all';
        } else {
            $data['title'] = 'Temukan Menu Favoritmu';
        }

        $data['categories'] = $categoryModel->getActive();
        $data['active_category'] = $categorySlug;
        $data['search_keyword'] = $keyword;
        $data['active_sort'] = $sort;

        // Fetch filtered foods
        $data['foods'] = $foodModel->getFiltered($keyword, $categorySlug, $sort);

        $this->view('home/menu', $data);
    }
}
