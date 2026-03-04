<?php

/**
 * Password Reset Model
 * 
 * Manages password reset tokens for forgot password flow.
 */
class PasswordResetModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create a password reset token for an email
     * @param string $email User email
     * @return string Plain token (to be sent in email)
     */
    public function createToken($email)
    {
        // Invalidate any existing tokens for this email
        $this->deleteByEmail($email);

        $id = UUID::v4();
        $token = UUID::token(32); // 64 hex chars
        $expiresAt = date('Y-m-d H:i:s', time() + 3600); // 1 hour

        $this->query("INSERT INTO tbl_password_resets (id, email, token, expires_at) 
                       VALUES (:id, :email, :token, :expires_at)");
        $this->bind(':id', $id);
        $this->bind(':email', $email);
        $this->bind(':token', hash('sha256', $token)); // Store hashed
        $this->bind(':expires_at', $expiresAt);
        $this->execute();

        return $token; // Return plain token
    }

    /**
     * Find a valid (non-expired, non-used) reset record by token
     * @param string $token Plain token
     * @return array|false Reset record
     */
    public function findByToken($token)
    {
        $hashedToken = hash('sha256', $token);

        $this->query("SELECT * FROM tbl_password_resets 
                       WHERE token = :token AND expires_at > NOW() AND used_at IS NULL");
        $this->bind(':token', $hashedToken);
        return $this->single();
    }

    /**
     * Mark a reset token as used
     * @param string $id Record ID
     */
    public function markUsed($id)
    {
        $this->query("UPDATE tbl_password_resets SET used_at = NOW() WHERE id = :id");
        $this->bind(':id', $id);
        return $this->execute();
    }

    /**
     * Delete all tokens for an email
     * @param string $email
     */
    public function deleteByEmail($email)
    {
        $this->query("DELETE FROM tbl_password_resets WHERE email = :email");
        $this->bind(':email', $email);
        return $this->execute();
    }

    /**
     * Delete expired tokens
     */
    public function deleteExpired()
    {
        $this->query("DELETE FROM tbl_password_resets WHERE expires_at < NOW()");
        return $this->execute();
    }
}
