// Admin Panel JavaScript
document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin panel loaded');
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('[data-alert]');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.3s ease';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});
