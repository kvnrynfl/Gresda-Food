<?php 
$status = $status ?? 'form';
$masked_email = $masked_email ?? '';
$error = $error ?? '';
$info = $info ?? '';

switch ($status) {
    case 'success':
        $page_title = "Email Berhasil Diverifikasi";
        break;
    default:
        $page_title = "Verifikasi Email";
        break;
}

$back_link = BASEURL . "/auth/login";
$hide_card = true;
ob_start(); 
?>

<div class="container mx-auto px-4 max-w-xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8">

            <?php if ($status === 'success'): ?>
                <!-- SUCCESS STATE -->
                <div class="text-center">
                    <div class="mb-6">
                        <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-green-100">
                            <i class="fas fa-check-circle text-4xl text-green-500"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Email Berhasil Diverifikasi!</h3>
                        <p class="text-gray-500">Selamat! Akun Anda telah aktif. Anda sekarang dapat login dan menikmati layanan Gresda Food.</p>
                    </div>
                    <a href="<?= BASEURL ?>/auth/login" class="w-full block bg-primary hover:bg-cyan-800 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-cyan-600/30 transition transform hover:-translate-y-0.5 active:translate-y-0">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login Sekarang
                    </a>
                </div>

            <?php else: ?>
                <!-- OTP FORM -->
                <?php if(!empty($error)): ?>
                    <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 flex items-center gap-3 text-sm">
                        <i class="fas fa-exclamation-circle text-lg flex-shrink-0"></i> 
                        <span><?= htmlspecialchars($error) ?></span>
                    </div>
                <?php endif; ?>

                <?php if(!empty($info)): ?>
                    <div class="bg-cyan-50 text-primary p-4 rounded-xl mb-6 flex items-center gap-3 text-sm">
                        <i class="fas fa-info-circle text-lg flex-shrink-0"></i> 
                        <span><?= htmlspecialchars($info) ?></span>
                    </div>
                <?php endif; ?>

                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-cyan-50 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-cyan-100">
                        <i class="fas fa-envelope-open-text text-3xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Masukkan Kode OTP</h3>
                    <p class="text-gray-500 text-sm">Kami telah mengirim kode verifikasi 6 digit ke</p>
                    <p class="text-primary font-bold text-sm mt-1"><?= htmlspecialchars($masked_email) ?></p>
                </div>

                <form action="<?= BASEURL ?>/auth/verifyEmail" method="POST" id="otp-form">
                    <?= CSRF::getTokenField() ?>
                    <input type="hidden" name="otp" id="otp-hidden" value="">

                    <!-- OTP Input Fields -->
                    <div class="flex justify-center gap-3 mb-8" id="otp-container">
                        <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-2xl font-bold border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary focus:outline-none transition bg-gray-50 focus:bg-white" data-index="0" inputmode="numeric" pattern="[0-9]" autocomplete="one-time-code">
                        <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-2xl font-bold border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary focus:outline-none transition bg-gray-50 focus:bg-white" data-index="1" inputmode="numeric" pattern="[0-9]">
                        <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-2xl font-bold border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary focus:outline-none transition bg-gray-50 focus:bg-white" data-index="2" inputmode="numeric" pattern="[0-9]">
                        <div class="flex items-center text-gray-300 font-bold text-xl">—</div>
                        <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-2xl font-bold border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary focus:outline-none transition bg-gray-50 focus:bg-white" data-index="3" inputmode="numeric" pattern="[0-9]">
                        <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-2xl font-bold border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary focus:outline-none transition bg-gray-50 focus:bg-white" data-index="4" inputmode="numeric" pattern="[0-9]">
                        <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-2xl font-bold border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary focus:outline-none transition bg-gray-50 focus:bg-white" data-index="5" inputmode="numeric" pattern="[0-9]">
                    </div>

                    <button type="submit" id="verify-btn" class="w-full bg-primary hover:bg-cyan-800 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-cyan-600/30 transition transform hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none" disabled>
                        <i class="fas fa-shield-alt mr-2"></i> Verifikasi
                    </button>
                </form>

                <!-- Resend OTP -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-500 mb-2">Tidak menerima kode?</p>
                    <a href="<?= BASEURL ?>/auth/resendVerification" id="resend-btn" class="inline-flex items-center gap-2 text-sm font-bold text-primary hover:text-cyan-700 transition">
                        <i class="fas fa-redo-alt"></i>
                        <span id="resend-text">Kirim Ulang OTP</span>
                    </a>
                    <p class="text-xs text-gray-400 mt-2" id="timer-text" style="display:none;">
                        Kirim ulang dalam <span id="countdown" class="font-bold text-primary">60</span> detik
                    </p>
                </div>

                <!-- Info -->
                <div class="mt-6 bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-info-circle text-gray-400 mt-0.5"></i>
                        <div class="text-xs text-gray-500 leading-relaxed">
                            <p class="mb-1"><strong>Kode berlaku selama 10 menit.</strong></p>
                            <p>Cek folder spam/junk jika email tidak ditemukan di kotak masuk. Jangan bagikan kode OTP kepada siapapun.</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if ($status !== 'success'): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.otp-input');
    const hiddenInput = document.getElementById('otp-hidden');
    const verifyBtn = document.getElementById('verify-btn');
    const form = document.getElementById('otp-form');
    const resendBtn = document.getElementById('resend-btn');
    const resendText = document.getElementById('resend-text');
    const timerText = document.getElementById('timer-text');
    const countdown = document.getElementById('countdown');

    // Focus first input
    inputs[0].focus();

    // Update hidden field and button state
    function updateOtp() {
        let otp = '';
        inputs.forEach(input => otp += input.value);
        hiddenInput.value = otp;
        verifyBtn.disabled = otp.length !== 6;
    }

    inputs.forEach((input, index) => {
        // Only allow digits
        input.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
            updateOtp();
        });

        // Handle backspace
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && this.value === '' && index > 0) {
                inputs[index - 1].focus();
                inputs[index - 1].value = '';
                updateOtp();
            }
        });

        // Handle paste
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '').slice(0, 6);
            if (pastedData.length > 0) {
                pastedData.split('').forEach((char, i) => {
                    if (inputs[i]) {
                        inputs[i].value = char;
                    }
                });
                const focusIndex = Math.min(pastedData.length, inputs.length - 1);
                inputs[focusIndex].focus();
                updateOtp();
            }
        });

        // Select all text on focus
        input.addEventListener('focus', function() {
            this.select();
        });
    });

    // Submit on form
    form.addEventListener('submit', function(e) {
        updateOtp();
        if (hiddenInput.value.length !== 6) {
            e.preventDefault();
        }
    });

    // Cooldown timer for resend
    let cooldown = 60;
    let timer = null;

    function startCooldown() {
        resendBtn.style.pointerEvents = 'none';
        resendBtn.style.opacity = '0.5';
        timerText.style.display = 'block';
        cooldown = 60;
        countdown.textContent = cooldown;

        timer = setInterval(function() {
            cooldown--;
            countdown.textContent = cooldown;
            if (cooldown <= 0) {
                clearInterval(timer);
                resendBtn.style.pointerEvents = 'auto';
                resendBtn.style.opacity = '1';
                timerText.style.display = 'none';
            }
        }, 1000);
    }

    // Start cooldown on page load
    startCooldown();

    // Handle resend click
    resendBtn.addEventListener('click', function(e) {
        if (cooldown > 0) {
            e.preventDefault();
        }
    });
});
</script>
<?php endif; ?>

<?php 
$slot = ob_get_clean();
include '../app/views/components/app_layout.php'; 
?>
