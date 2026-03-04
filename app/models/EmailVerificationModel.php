<?php

/**
 * Email Verification Model
 * 
 * Manages OTP-based email verification for new user registrations.
 */
class EmailVerificationModel extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create a 6-digit OTP for a user
     * @param string $userId User UUID
     * @param string $email User email
     * @return string Plain OTP code (6 digits)
     */
    public function createOtp($userId, $email)
    {
        // Invalidate any existing tokens for this user
        $this->deleteByUserId($userId);

        $id = UUID::v4();
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = date('Y-m-d H:i:s', time() + 600); // 10 minutes

        $this->query("INSERT INTO tbl_email_verifications (id, user_id, email, token, otp_code, expires_at) 
                       VALUES (:id, :user_id, :email, :token, :otp_code, :expires_at)");
        $this->bind(':id', $id);
        $this->bind(':user_id', $userId);
        $this->bind(':email', $email);
        $this->bind(':token', ''); // No longer used, kept for compat
        $this->bind(':otp_code', hash('sha256', $otp));
        $this->bind(':expires_at', $expiresAt);
        $this->execute();

        return $otp; // Return plain OTP (to be sent in email)
    }

    /**
     * Find a valid (non-expired, non-used) verification by OTP for a specific user
     * @param string $userId User UUID
     * @param string $otp Plain OTP string
     * @return array|false Verification record
     */
    public function findByOtp($userId, $otp)
    {
        $hashedOtp = hash('sha256', $otp);

        $this->query("SELECT * FROM tbl_email_verifications 
                       WHERE user_id = :user_id AND otp_code = :otp_code 
                       AND expires_at > NOW() AND verified_at IS NULL");
        $this->bind(':user_id', $userId);
        $this->bind(':otp_code', $hashedOtp);
        return $this->single();
    }

    /**
     * Find a valid (non-expired, non-used) verification by token (legacy)
     * @param string $token Plain token string
     * @return array|false Verification record
     */
    public function findByToken($token)
    {
        $hashedToken = hash('sha256', $token);

        $this->query("SELECT * FROM tbl_email_verifications 
                       WHERE token = :token AND expires_at > NOW() AND verified_at IS NULL");
        $this->bind(':token', $hashedToken);
        return $this->single();
    }

    /**
     * Mark a verification token as used
     * @param string $id Verification record ID
     */
    public function markVerified($id)
    {
        $this->query("UPDATE tbl_email_verifications SET verified_at = NOW() WHERE id = :id");
        $this->bind(':id', $id);
        return $this->execute();
    }

    /**
     * Delete all tokens for a user (cleanup)
     * @param string $userId User UUID
     */
    public function deleteByUserId($userId)
    {
        $this->query("DELETE FROM tbl_email_verifications WHERE user_id = :user_id");
        $this->bind(':user_id', $userId);
        return $this->execute();
    }

    /**
     * Delete expired tokens (cleanup)
     */
    public function deleteExpired()
    {
        $this->query("DELETE FROM tbl_email_verifications WHERE expires_at < NOW()");
        return $this->execute();
    }
}
