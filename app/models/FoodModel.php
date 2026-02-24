<?php

class FoodModel extends Database {

    public function __construct() {
        parent::__construct();
    }

    public function getAll($limitOffset = "") {
        $this->query("SELECT * FROM tbl_food ORDER BY food_id DESC " . $limitOffset);
        return $this->resultSet();
    }

    public function getActive($limitOffset = "") {
        $this->query("SELECT * FROM tbl_food WHERE active = 'Yes' ORDER BY rand() " . $limitOffset);
        return $this->resultSet();
    }

    public function countActive() {
        $this->query("SELECT COUNT(*) as total FROM tbl_food WHERE active = 'Yes'");
        return $this->single()['total'];
    }

    public function getById($id) {
        $this->query("SELECT * FROM tbl_food WHERE food_id = :id");
        $this->bind(':id', $id);
        return $this->single();
    }

    public function getByCategory($category_slug) {
        $this->query("SELECT * FROM tbl_food WHERE category = :category AND active='Yes'");
        $this->bind(':category', $category_slug);
        return $this->resultSet();
    }

    public function getFiltered($keyword = '', $categorySlug = 'all', $sort = 'newest') {
        $sql = "SELECT * FROM tbl_food WHERE active = 'Yes'";
        
        // Add category filter if not 'all'
        if ($categorySlug !== 'all') {
            $sql .= " AND category = :category";
        }
        
        // Add search keyword filter
        if (!empty($keyword)) {
            $sql .= " AND (name LIKE :keyword OR description LIKE :keyword)";
        }
        
        // Add sorting
        switch ($sort) {
            case 'price_asc':
                $sql .= " ORDER BY price ASC";
                break;
            case 'price_desc':
                $sql .= " ORDER BY price DESC";
                break;
            case 'newest':
            default:
                $sql .= " ORDER BY created_at DESC, food_id DESC";
                break;
        }

        $this->query($sql);
        
        // Bind parameters safely
        if ($categorySlug !== 'all') {
            $this->bind(':category', $categorySlug);
        }
        
        if (!empty($keyword)) {
            $this->bind(':keyword', '%' . $keyword . '%');
        }

        return $this->resultSet();
    }

    public function create($data) {
        $food_id = UUID::v4();
        $this->query("INSERT INTO tbl_food (food_id, category, name, price, description, image_name, active) VALUES (:food_id, :category, :name, :price, :description, :image_name, :active)");
        $this->bind(':food_id', $food_id);
        $this->bind(':category', $data['category']);
        $this->bind(':name', $data['name']);
        $this->bind(':price', $data['price']);
        $this->bind(':description', $data['description']);
        $this->bind(':image_name', $data['image_name']);
        $this->bind(':active', $data['active']);
        return $this->execute();
    }

    public function update($id, $data) {
        $this->query("UPDATE tbl_food SET category = :category, name = :name, price = :price, description = :description, image_name = :image_name, active = :active WHERE food_id = :id");
        $this->bind(':category', $data['category']);
        $this->bind(':name', $data['name']);
        $this->bind(':price', $data['price']);
        $this->bind(':description', $data['description']);
        $this->bind(':image_name', $data['image_name']);
        $this->bind(':active', $data['active']);
        $this->bind(':id', $id);
        return $this->execute();
    }

    public function delete($id) {
        $this->query("DELETE FROM tbl_food WHERE food_id = :id");
        $this->bind(':id', $id);
        return $this->execute();
    }

    public function getTopSelling($limit = 10) {
        $this->query("
            SELECT f.*, COALESCE(SUM(d.qty), 0) as total_sold
            FROM tbl_food f
            LEFT JOIN tbl_order_details d ON f.food_id = d.food_id
            LEFT JOIN tbl_orders o ON d.order_id = o.order_id AND o.status != 'Pending'
            WHERE f.active = 'Yes'
            GROUP BY f.food_id
            ORDER BY total_sold DESC
            LIMIT :limit
        ");
        $this->bind(':limit', $limit);
        return $this->resultSet();
    }
}
