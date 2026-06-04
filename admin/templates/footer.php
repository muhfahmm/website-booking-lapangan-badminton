            </div>

            <!-- Footer -->
            <div class="bg-white border-t border-slate-200 px-6 py-4 text-center text-slate-600 text-sm">
                <p>© 2024 Booking Lapangan Badminton. All rights reserved. | Admin Panel v1.0</p>
            </div>
        </div>
    </div>

    <script>
        // Add any admin panel scripts here
        document.addEventListener('DOMContentLoaded', function() {
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
    </script>
</body>
</html>
