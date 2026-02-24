<?php if(isset($_SESSION['flash_error']) || isset($_SESSION['flash_success'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if(isset($_SESSION['flash_error'])): ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?= addslashes($_SESSION['flash_error']) ?>',
            confirmButtonColor: '#06b6d4'
        });
        <?php unset($_SESSION['flash_error']); endif; ?>
        
        <?php if(isset($_SESSION['flash_success'])): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= addslashes($_SESSION['flash_success']) ?>',
            confirmButtonColor: '#06b6d4'
        });
        <?php unset($_SESSION['flash_success']); endif; ?>
    });
</script>
<?php endif; ?>
