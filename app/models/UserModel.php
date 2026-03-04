<?php

/**
 * User Model
 * 
 * Handles all user-related database operations including
 * customer and admin users (merged from old AdminModel).
 * 
 * Table: tbl_users
 */
class UserModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    // ─── Create ─────────────────────────────────────────────────────

    /**
     * Create a new user
     */
    public function create($data)
    {
        $id = UUID::v4();
        $this->query("INSERT INTO tbl_users (id, full_name, username, email, password, phone, address, role) 
                       VALUES (:id, :full_name, :username, :email, :password, :phone, :address, :role)");

        $this->bind(':id', $id);
        $this->bind(':full_name', $data['full_name'] ?? $data['username']);
        $this->bind(':username', $data['username']);
        $this->bind(':email', $data['email']);
        $this->bind(':password', $data['password']); // Must be hashed before calling
        $this->bind(':phone', $data['phone'] ?? null);
        $this->bind(':address', $data['address'] ?? null);
        $this->bind(':role', $data['role'] ?? 'customer');

        $this->execute();
        return $id;
    }

    // ─── Find ───────────────────────────────────────────────────────

    /**
     * Find user by ID
     */
    public function findById($id)
    {
        $this->query("SELECT * FROM tbl_users WHERE id = :id");
        $this->bind(':id', $id);
        return $this->single();
    }

    /**
     * Find user by email
     */
    public function findByEmail($email)
    {
        $this->query("SELECT * FROM tbl_users WHERE email = :email");
        $this->bind(':email', $email);
        return $this->single();
    }

    /**
     * Find user by username or email (for login)
     */
    public function findByUsernameOrEmail($login)
    {
        $this->query("SELECT * FROM tbl_users WHERE email = :login1 OR username = :login2");
        $this->bind(':login1', $login);
        $this->bind(':login2', $login);
        return $this->single();
    }

    /**
     * Find user by remember token
     */
    public function findByRememberToken($token)
    {
        $hashedToken = hash('sha256', $token);
        $this->query("SELECT * FROM tbl_users WHERE remember_token = :token AND is_active = 1");
        $this->bind(':token', $hashedToken);
        return $this->single();
    }

    /**
     * Check if email exists (for registration validation)
     */
    public function emailExists($email, $excludeId = null)
    {
        if ($excludeId) {
            $this->query("SELECT id FROM tbl_users WHERE email = :email AND id != :id");
            $this->bind(':id', $excludeId);
        } else {
            $this->query("SELECT id FROM tbl_users WHERE email = :email");
        }
        $this->bind(':email', $email);
        return $this->single() ? true : false;
    }

    /**
     * Check if username exists
     */
    public function usernameExists($username, $excludeId = null)
    {
        if ($excludeId) {
            $this->query("SELECT id FROM tbl_users WHERE username = :username AND id != :id");
            $this->bind(':id', $excludeId);
        } else {
            $this->query("SELECT id FROM tbl_users WHERE username = :username");
        }
        $this->bind(':username', $username);
        return $this->single() ? true : false;
    }

    // ─── Update ─────────────────────────────────────────────────────

    /**
     * Update user password
     */
    public function updatePassword($id, $newPassword)
    {
        $this->query("UPDATE tbl_users SET password = :password WHERE id = :id");
        $this->bind(':password', $newPassword);
        $this->bind(':id', $id);
        return $this->execute();
    }

    /**
     * Update user profile
     */
    public function updateProfile($id, $data)
    {
        $sql = "UPDATE tbl_users SET full_name = :full_name, username = :username, email = :email, phone = :phone, address = :address";

        if (isset($data['img_user'])) {
            $sql .= ", img_user = :img_user";
        }

        $sql .= " WHERE id = :id";

        $this->query($sql);
        $this->bind(':full_name', $data['full_name']);
        $this->bind(':username', $data['username']);
        $this->bind(':email', $data['email']);
        $this->bind(':phone', $data['phone'] ?? null);
        $this->bind(':address', $data['address'] ?? null);

        if (isset($data['img_user'])) {
            $this->bind(':img_user', $data['img_user']);
        }

        $this->bind(':id', $id);
        return $this->execute();
    }

    /**
     * Verify email (set email_verified_at)
     */
    public function verifyEmail($id)
    {
        $this->query("UPDATE tbl_users SET email_verified_at = NOW() WHERE id = :id");
        $this->bind(':id', $id);
        return $this->execute();
    }

    /**
     * Set remember me token
     */
    public function setRememberToken($id, $token)
    {
        $hashedToken = $token ? hash('sha256', $token) : null;
        $this->query("UPDATE tbl_users SET remember_token = :token WHERE id = :id");
        $this->bind(':token', $hashedToken);
        $this->bind(':id', $id);
        return $this->execute();
    }

    /**
     * Update last login timestamp
     */
    public function updateLastLogin($id)
    {
        $this->query("UPDATE tbl_users SET last_login_at = NOW() WHERE id = :id");
        $this->bind(':id', $id);
        return $this->execute();
    }

    /**
     * Toggle user active status
     */
    public function setActive($id, $active)
    {
        $this->query("UPDATE tbl_users SET is_active = :active WHERE id = :id");
        $this->bind(':active', $active ? 1 : 0);
        $this->bind(':id', $id);
        return $this->execute();
    }

    // ─── List / Query ───────────────────────────────────────────────

    /**
     * Get all customers
     */
    public function getAllCustomers()
    {
        $this->query("SELECT * FROM tbl_users WHERE role = 'customer' ORDER BY created_at DESC");
        return $this->resultSet();
    }

    /**
     * Get all customers with order count
     */
    public function getAllCustomersWithOrderCount()
    {
        $this->query("
            SELECT u.*, COUNT(o.id) as total_orders 
            FROM tbl_users u 
            LEFT JOIN tbl_orders o ON u.id = o.user_id AND o.status IN ('confirmed', 'delivering', 'finished') 
            WHERE u.role = 'customer' 
            GROUP BY u.id 
            ORDER BY u.created_at DESC
        ");
        return $this->resultSet();
    }

    /**
     * Get all admin users
     */
    public function getAllAdmins()
    {
        $this->query("SELECT * FROM tbl_users WHERE role = 'admin' ORDER BY created_at ASC");
        return $this->resultSet();
    }

    /**
     * Find admin by username
     */
    public function findAdminByUsername($username)
    {
        $this->query("SELECT * FROM tbl_users WHERE username = :username AND role = 'admin'");
        $this->bind(':username', $username);
        return $this->single();
    }

    /**
     * Count users by role
     */
    public function countByRole($role = 'customer')
    {
        $this->query("SELECT COUNT(*) as total FROM tbl_users WHERE role = :role");
        $this->bind(':role', $role);
        $result = $this->single();
        return $result['total'] ?? 0;
    }

    // ─── Delete ─────────────────────────────────────────────────────

    /**
     * Delete user by ID
     */
    public function delete($id)
    {
        $this->query("DELETE FROM tbl_users WHERE id = :id");
        $this->bind(':id', $id);
        return $this->execute();
    }
}
