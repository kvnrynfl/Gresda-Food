<?php

/**
 * Payment Method Model
 * 
 * CRUD operations for tbl_payment_methods
 * Table: tbl_payment_methods
 */
class PaymentMethodModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        $this->query("SELECT * FROM tbl_payment_methods ORDER BY sort_order ASC");
        return $this->resultSet();
    }

    public function getActive()
    {
        $this->query("SELECT * FROM tbl_payment_methods WHERE is_active = 1 ORDER BY sort_order ASC");
        return $this->resultSet();
    }

    public function getById($id)
    {
        $this->query("SELECT * FROM tbl_payment_methods WHERE id = :id");
        $this->bind(':id', $id);
        return $this->single();
    }

    public function create($data)
    {
        $id = UUID::v4();
        $this->query("INSERT INTO tbl_payment_methods (id, name, type, account_number, account_name, icon, instructions, is_active, sort_order) 
                       VALUES (:id, :name, :type, :acc_num, :acc_name, :icon, :instructions, :active, :sort)");
        $this->bind(':id', $id);
        $this->bind(':name', $data['name']);
        $this->bind(':type', $data['type']);
        $this->bind(':acc_num', $data['account_number']);
        $this->bind(':acc_name', $data['account_name']);
        $this->bind(':icon', $data['icon'] ?? null);
        $this->bind(':instructions', $data['instructions'] ?? null);
        $this->bind(':active', $data['is_active'] ?? 1);
        $this->bind(':sort', $data['sort_order'] ?? 0);
        return $this->execute();
    }

    public function update($id, $data)
    {
        $this->query("UPDATE tbl_payment_methods SET name = :name, type = :type, account_number = :acc_num, account_name = :acc_name, icon = :icon, instructions = :instructions, is_active = :active, sort_order = :sort WHERE id = :id");
        $this->bind(':name', $data['name']);
        $this->bind(':type', $data['type']);
        $this->bind(':acc_num', $data['account_number']);
        $this->bind(':acc_name', $data['account_name']);
        $this->bind(':icon', $data['icon'] ?? null);
        $this->bind(':instructions', $data['instructions'] ?? null);
        $this->bind(':active', $data['is_active'] ?? 1);
        $this->bind(':sort', $data['sort_order'] ?? 0);
        $this->bind(':id', $id);
        return $this->execute();
    }

    public function delete($id)
    {
        $this->query("DELETE FROM tbl_payment_methods WHERE id = :id");
        $this->bind(':id', $id);
        return $this->execute();
    }

    public function toggleActive($id)
    {
        $this->query("UPDATE tbl_payment_methods SET is_active = IF(is_active = 1, 0, 1) WHERE id = :id");
        $this->bind(':id', $id);
        return $this->execute();
    }

    public function countAll()
    {
        $this->query("SELECT COUNT(*) as total FROM tbl_payment_methods");
        $row = $this->single();
        return $row['total'] ?? 0;
    }
}
