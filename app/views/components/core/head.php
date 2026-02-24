<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?? 'Gresda Food & Beverage' ?></title>

<!-- Modern Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- FontAwesome & Boxicons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<!-- SweetAlert2 Global -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Tailwind CSS (CDN for rapid delivery as requested) -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: { sans: ['Inter', 'sans-serif'] },
                colors: {
                    primary: '#06b6d4',
                    secondary: '#2D3748'
                }
            }
        }
    }
</script>
