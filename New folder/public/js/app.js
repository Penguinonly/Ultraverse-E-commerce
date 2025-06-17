import './bootstrap';

// Handle alert dismissal
document.addEventListener('DOMContentLoaded', function() {
    // Close alert messages
    document.querySelectorAll('.close-alert').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.alert').remove();
        });
    });

    // Auto-hide alerts after 5 seconds
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });

    // Handle icon tooltips
    const icons = document.querySelectorAll('.icon');
    icons.forEach(icon => {
        const title = icon.getAttribute('title');
        if (title) {
            icon.addEventListener('mouseenter', function(e) {
                const tooltip = document.createElement('div');
                tooltip.className = 'tooltip';
                tooltip.textContent = title;
                document.body.appendChild(tooltip);

                const rect = icon.getBoundingClientRect();
                const tooltipRect = tooltip.getBoundingClientRect();
                
                tooltip.style.left = rect.left + (rect.width - tooltipRect.width) / 2 + 'px';
                tooltip.style.top = rect.bottom + 8 + 'px';
            });

            icon.addEventListener('mouseleave', function() {
                const tooltip = document.querySelector('.tooltip');
                if (tooltip) {
                    tooltip.remove();
                }
            });
        }
    });

    // Handle active states for navigation
    const currentPath = window.location.pathname;
    document.querySelectorAll('.sidebar-icons .icon, .sidebar-bottom .icon').forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });

    // Add scroll shadow to main content
    const mainContent = document.querySelector('.main-content');
    if (mainContent) {
        mainContent.addEventListener('scroll', function() {
            if (this.scrollTop > 0) {
                this.classList.add('scrolled');
            } else {
                this.classList.remove('scrolled');
            }
        });
    }

    // Handle property card save buttons
    document.querySelectorAll('.btn-secondary').forEach(button => {
        button.addEventListener('click', function() {
            this.classList.toggle('saved');
            if (this.classList.contains('saved')) {
                this.style.backgroundColor = '#FFF8E1';
                this.style.color = '#FFD700';
                this.textContent = 'Tersimpan';
            } else {
                this.style.backgroundColor = '#F3F4F6';
                this.style.color = '#374151';
                this.textContent = 'Simpan';
            }
        });
    });
});
