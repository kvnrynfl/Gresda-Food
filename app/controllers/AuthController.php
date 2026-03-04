<?php

/**
 * Authentication Controller
 * 
 * Handles:
 * - Login (with rate limiting + remember me)
 * - Registration (with email verification)
 * - Logout
 * - Forgot Password (token-based reset)
 * - Email Verification
 * - Password Reset
 */
class AuthController extends Controller
{
    // ═══════════════════════════════════════════════════════════════
    // LOGIN
    // ═══════════════════════════════════════════════════════════════

    public function login()
    {
        // If already logged in, redirect
        if ($this->isLoggedIn()) {
            $this->redirect($_SESSION['role'] === 'admin' ? '/admin/dashboard' : '/');
        }

        // Check for remember me cookie
        if (isset($_COOKIE['remember_token'])) {
            $userModel = $this->model('UserModel');
            $user = $userModel->findByRememberToken($_COOKIE['remember_token']);
            if ($user && $user['email_verified_at']) {
                $this->createSession($user);
                return;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->view('auth/login', [
                'login_id' => '',
                'error' => '',
                'success' => $_SESSION['flash_success'] ?? '',
            ]);
            unset($_SESSION['flash_success']);
            return;
        }

        // POST — Process Login
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->view('auth/login', ['error' => 'Sesi tidak valid. Silakan coba lagi.', 'login_id' => '']);
            return;
        }

        $_POST = Sanitize::array($_POST);
        $loginId = trim($_POST['login_id'] ?? $_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember_me']);

        if (empty($loginId) || empty($password)) {
            $this->view('auth/login', ['error' => 'Email/username dan kata sandi wajib diisi.', 'login_id' => $loginId]);
            return;
        }

        // Rate limiting check
        $rateLimiter = new RateLimiter();
        if ($rateLimiter->isBlocked($loginId)) {
            $remaining = $rateLimiter->getRemainingLockoutTime($loginId);
            $minutes = ceil($remaining / 60);
            $this->view('auth/login', [
                'error' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$minutes} menit.",
                'login_id' => $loginId
            ]);
            return;
        }

        $userModel = $this->model('UserModel');
        $user = $userModel->findByUsernameOrEmail($loginId);

        if (!$user || !password_verify($password, $user['password'])) {
            $rateLimiter->recordFailedAttempt($loginId);
            $attemptsLeft = $rateLimiter->getRemainingAttempts($loginId);

            $errorMsg = 'Email/username atau kata sandi salah.';
            if ($attemptsLeft > 0 && $attemptsLeft <= 3) {
                $errorMsg .= " ({$attemptsLeft} percobaan tersisa)";
            }

            $this->view('auth/login', ['error' => $errorMsg, 'login_id' => $loginId]);
            return;
        }

        // Check if account is active
        if (!$user['is_active']) {
            $this->view('auth/login', ['error' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.', 'login_id' => $loginId]);
            return;
        }

        // Check email verification
        if (empty($user['email_verified_at'])) {
            $_SESSION['pending_verification_user_id'] = $user['id'];
            $_SESSION['pending_verification_email'] = $user['email'];
            
            // Generate new OTP and send
            $verificationModel = $this->model('EmailVerificationModel');
            $otp = $verificationModel->createOtp($user['id'], $user['email']);
            Mailer::sendVerificationOtp($user['email'], $user['full_name'], $otp);
            
            $_SESSION['flash_info'] = 'Email Anda belum diverifikasi. Kami telah mengirim kode OTP baru ke email Anda.';
            $this->redirect('/auth/verifyEmail');
            return;
        }

        // Successful login
        $rateLimiter->recordSuccess($loginId);
        $userModel->updateLastLogin($user['id']);

        // Remember me
        if ($remember) {
            $token = UUID::token(32);
            $userModel->setRememberToken($user['id'], $token);
            setcookie('remember_token', $token, [
                'expires' => time() + (30 * 24 * 60 * 60), // 30 days
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Strict',
                'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
            ]);
        }

        $this->createSession($user);
    }

    // ═══════════════════════════════════════════════════════════════
    // REGISTRATION
    // ═══════════════════════════════════════════════════════════════

    public function register()
    {
        if ($this->isLoggedIn()) {
            $this->redirect('/');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->view('auth/register', ['error' => '', 'old' => []]);
            return;
        }

        // POST — Process Registration
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->view('auth/register', ['error' => 'Sesi tidak valid. Silakan coba lagi.', 'old' => $_POST]);
            return;
        }

        $_POST = Sanitize::array($_POST);

        // Validation
        $errors = [];
        $fullName = trim($_POST['full_name'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (empty($fullName) || strlen($fullName) < 3) {
            $errors[] = 'Nama lengkap minimal 3 karakter.';
        }
        if (empty($username) || strlen($username) < 3) {
            $errors[] = 'Username minimal 3 karakter.';
        }
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            $errors[] = 'Username hanya boleh mengandung huruf, angka, dan underscore.';
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Format email tidak valid.';
        }
        if (strlen($password) < 8) {
            $errors[] = 'Kata sandi minimal 8 karakter.';
        }
        if (!preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
            $errors[] = 'Kata sandi harus mengandung huruf besar dan angka.';
        }
        if ($password !== $confirmPassword) {
            $errors[] = 'Konfirmasi kata sandi tidak cocok.';
        }

        $userModel = $this->model('UserModel');

        if ($userModel->emailExists($email)) {
            $errors[] = 'Email sudah terdaftar.';
        }
        if ($userModel->usernameExists($username)) {
            $errors[] = 'Username sudah digunakan.';
        }

        if (!empty($errors)) {
            $this->view('auth/register', ['error' => implode('<br>', $errors), 'old' => $_POST]);
            return;
        }

        // Create user
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        $userId = $userModel->create([
            'full_name' => $fullName,
            'username' => $username,
            'email' => $email,
            'phone' => $phone,
            'password' => $hashedPassword,
        ]);

        // Send OTP verification email
        $verificationModel = $this->model('EmailVerificationModel');
        $otp = $verificationModel->createOtp($userId, $email);
        Mailer::sendVerificationOtp($email, $fullName, $otp);

        // Store user info in session for the OTP page
        $_SESSION['pending_verification_user_id'] = $userId;
        $_SESSION['pending_verification_email'] = $email;

        $this->redirect('/auth/verifyEmail');
    }

    // ═══════════════════════════════════════════════════════════════
    // EMAIL VERIFICATION
    // ═══════════════════════════════════════════════════════════════

    public function verifyEmail()
    {
        $userId = $_SESSION['pending_verification_user_id'] ?? null;
        $email = $_SESSION['pending_verification_email'] ?? null;

        if (!$userId || !$email) {
            $this->redirect('/auth/login');
            return;
        }

        // Mask email for display: k***n@gmail.com
        $parts = explode('@', $email);
        $name = $parts[0];
        if (strlen($name) <= 2) {
            $maskedEmail = $name[0] . '***@' . $parts[1];
        } else {
            $maskedEmail = $name[0] . str_repeat('*', strlen($name) - 2) . substr($name, -1) . '@' . $parts[1];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->view('auth/verify_email', [
                'status' => 'form',
                'masked_email' => $maskedEmail,
                'error' => '',
                'info' => $_SESSION['flash_info'] ?? '',
            ]);
            unset($_SESSION['flash_info']);
            return;
        }

        // POST — Validate OTP
        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->view('auth/verify_email', [
                'status' => 'form',
                'masked_email' => $maskedEmail,
                'error' => 'Sesi tidak valid. Silakan coba lagi.',
                'info' => '',
            ]);
            return;
        }

        $otpInput = trim($_POST['otp'] ?? '');

        if (empty($otpInput) || strlen($otpInput) !== 6 || !ctype_digit($otpInput)) {
            $this->view('auth/verify_email', [
                'status' => 'form',
                'masked_email' => $maskedEmail,
                'error' => 'Masukkan kode OTP 6 digit yang valid.',
                'info' => '',
            ]);
            return;
        }

        $verificationModel = $this->model('EmailVerificationModel');
        $record = $verificationModel->findByOtp($userId, $otpInput);

        if (!$record) {
            $this->view('auth/verify_email', [
                'status' => 'form',
                'masked_email' => $maskedEmail,
                'error' => 'Kode OTP salah atau sudah kedaluwarsa. Silakan minta kode baru.',
                'info' => '',
            ]);
            return;
        }

        // Verify the email
        $userModel = $this->model('UserModel');
        $userModel->verifyEmail($record['user_id']);
        $verificationModel->markVerified($record['id']);

        // Clean session
        unset($_SESSION['pending_verification_user_id']);
        unset($_SESSION['pending_verification_email']);

        $this->view('auth/verify_email', ['status' => 'success', 'masked_email' => '', 'error' => '', 'info' => '']);
    }

    public function resendVerification()
    {
        $userId = $_SESSION['pending_verification_user_id'] ?? null;

        if (!$userId) {
            $this->redirect('/auth/login');
            return;
        }

        $userModel = $this->model('UserModel');
        $user = $userModel->findById($userId);

        if (!$user || $user['email_verified_at']) {
            unset($_SESSION['pending_verification_user_id']);
            unset($_SESSION['pending_verification_email']);
            $this->redirect('/auth/login');
            return;
        }

        $verificationModel = $this->model('EmailVerificationModel');
        $otp = $verificationModel->createOtp($user['id'], $user['email']);
        Mailer::sendVerificationOtp($user['email'], $user['full_name'], $otp);

        $_SESSION['flash_info'] = 'Kode OTP baru telah dikirim ke email Anda.';
        $this->redirect('/auth/verifyEmail');
    }

    // ═══════════════════════════════════════════════════════════════
    // FORGOT PASSWORD
    // ═══════════════════════════════════════════════════════════════

    public function forgotPassword()
    {
        if ($this->isLoggedIn()) {
            $this->redirect('/');
        }

        $this->view('auth/forgot_password', ['error' => '', 'success' => '']);
    }

    public function sendResetLink()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/auth/forgotPassword');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->view('auth/forgot_password', ['error' => 'Sesi tidak valid.', 'success' => '']);
            return;
        }

        $email = Sanitize::email($_POST['email'] ?? '');

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->view('auth/forgot_password', ['error' => 'Masukkan alamat email yang valid.', 'success' => '']);
            return;
        }

        // Always show success message to prevent email enumeration
        $successMsg = 'Jika email terdaftar, kami telah mengirim link reset kata sandi. Silakan cek kotak masuk Anda.';

        $userModel = $this->model('UserModel');
        $user = $userModel->findByEmail($email);

        if ($user) {
            $resetModel = $this->model('PasswordResetModel');
            $token = $resetModel->createToken($email);
            $resetUrl = BASEURL . '/auth/resetPassword/' . $token;

            Mailer::sendPasswordReset($email, $user['full_name'], $resetUrl);
        }

        $this->view('auth/forgot_password', ['error' => '', 'success' => $successMsg]);
    }

    public function resetPassword($token = '')
    {
        if (empty($token)) {
            $this->redirect('/auth/forgotPassword');
            return;
        }

        $resetModel = $this->model('PasswordResetModel');
        $record = $resetModel->findByToken($token);

        if (!$record) {
            $this->view('auth/forgot_password', [
                'error' => 'Link reset tidak valid atau sudah kedaluwarsa. Silakan minta link baru.',
                'success' => ''
            ]);
            return;
        }

        $this->view('auth/reset_password', ['token' => $token, 'email' => $record['email'], 'error' => '']);
    }

    public function processReset()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/auth/forgotPassword');
            return;
        }

        if (!CSRF::verifyToken($_POST['csrf_token'] ?? '')) {
            $this->redirect('/auth/forgotPassword');
            return;
        }

        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Validate token again
        $resetModel = $this->model('PasswordResetModel');
        $record = $resetModel->findByToken($token);

        if (!$record) {
            $this->view('auth/forgot_password', [
                'error' => 'Link reset sudah kedaluwarsa. Silakan minta link baru.',
                'success' => ''
            ]);
            return;
        }

        // Validate password
        if (strlen($password) < 8) {
            $this->view('auth/reset_password', [
                'token' => $token,
                'email' => $record['email'],
                'error' => 'Kata sandi minimal 8 karakter.'
            ]);
            return;
        }

        if ($password !== $confirmPassword) {
            $this->view('auth/reset_password', [
                'token' => $token,
                'email' => $record['email'],
                'error' => 'Konfirmasi kata sandi tidak cocok.'
            ]);
            return;
        }

        // Update password
        $userModel = $this->model('UserModel');
        $user = $userModel->findByEmail($record['email']);

        if ($user) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
            $userModel->updatePassword($user['id'], $hashedPassword);
            $resetModel->markUsed($record['id']);

            // Clear all remember tokens for this user
            $userModel->setRememberToken($user['id'], null);
        }

        $_SESSION['flash_success'] = 'Kata sandi berhasil direset. Silakan login dengan kata sandi baru Anda.';
        $this->redirect('/auth/login');
    }

    // ═══════════════════════════════════════════════════════════════
    // LOGOUT
    // ═══════════════════════════════════════════════════════════════

    public function logout()
    {
        // Clear remember me token
        if (isset($_SESSION['user_id'])) {
            $userModel = $this->model('UserModel');
            $userModel->setRememberToken($_SESSION['user_id'], null);
        }

        // Remove remember me cookie
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', [
                'expires' => time() - 3600,
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Strict',
            ]);
        }

        session_unset();
        session_destroy();
        $this->redirect('/');
    }

    // ═══════════════════════════════════════════════════════════════
    // HELPERS
    // ═══════════════════════════════════════════════════════════════

    private function createSession($user)
    {
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['img_user'] = $user['img_user'] ?? 'default.jpg';
        $_SESSION['logged_in_at'] = time();

        if ($user['role'] === 'admin') {
            $this->redirect('/admin/dashboard');
        } else {
            $this->redirect('/');
        }
    }
}
