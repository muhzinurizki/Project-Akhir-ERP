import './bootstrap';
import '../css/app.css';
import 'flowbite';

// Import semua ikon dari lucide
import { createIcons, icons } from 'lucide';

document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});

// Buat ikon dengan menyertakan objek ikon
createIcons({ icons });

import Swal from 'sweetalert2';

window.Swal = Swal;


import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
