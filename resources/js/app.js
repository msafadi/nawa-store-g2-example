import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

Echo.private('Notifications.' + userId)
    .notification(function(msg) {
        console.log(msg);
        alert(msg.body);
    });
