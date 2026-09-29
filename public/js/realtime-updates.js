// Real-time booking updates using polling
// This is a simple implementation without WebSocket/Pusher dependencies

class BookingUpdates {
    constructor() {
        this.lastUpdateTime = null;
        this.updateInterval = 10000; // 10 seconds
        this.isActive = false;
    }

    start() {
        if (this.isActive) return;
        this.isActive = true;
        this.checkForUpdates();
        this.intervalId = setInterval(() => this.checkForUpdates(), this.updateInterval);
    }

    stop() {
        this.isActive = false;
        if (this.intervalId) {
            clearInterval(this.intervalId);
        }
    }

    async checkForUpdates() {
        try {
            const response = await fetch('/api/bookings', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) throw new Error('Network response was not ok');
            
            const bookings = await response.json();
            this.handleUpdates(bookings);
        } catch (error) {
            console.error('Error checking for updates:', error);
        }
    }

    handleUpdates(bookings) {
        // Process bookings and trigger notifications
        if (typeof window.onBookingUpdate === 'function') {
            window.onBookingUpdate(bookings);
        }

        // Update UI elements
        this.updateBookingStats(bookings);
        this.updateBookingTable(bookings);
    }

    updateBookingStats(bookings) {
        const stats = {
            total: bookings.length,
            pending: bookings.filter(b => b.status === 'pending').length,
            confirmed: bookings.filter(b => b.status === 'confirmed').length,
            cancelled: bookings.filter(b => b.status === 'cancelled').length
        };

        // Update stat cards if they exist
        const statElements = {
            total: document.querySelector('[data-stat="total"]'),
            pending: document.querySelector('[data-stat="pending"]'),
            confirmed: document.querySelector('[data-stat="confirmed"]'),
            cancelled: document.querySelector('[data-stat="cancelled"]')
        };

        Object.keys(stats).forEach(key => {
            if (statElements[key]) {
                statElements[key].textContent = stats[key];
            }
        });
    }

    updateBookingTable(bookings) {
        const tbody = document.getElementById('bookingsTableBody');
        if (!tbody) return;

        // Store current filter
        const activeFilter = document.querySelector('.filter-btn.active')?.dataset.filter || 'all';

        // Update rows
        bookings.forEach(booking => {
            const existingRow = tbody.querySelector(`[data-id="${booking.id}"]`);
            if (existingRow) {
                this.updateRow(existingRow, booking);
            }
        });
    }

    updateRow(row, booking) {
        // Update status badge
        const statusBadge = row.querySelector('.status-badge');
        if (statusBadge) {
            statusBadge.className = `status-badge status-${booking.status}`;
            statusBadge.textContent = booking.status.charAt(0).toUpperCase() + booking.status.slice(1);
        }

        // Update action buttons
        const actionButtons = row.querySelector('.action-buttons');
        if (actionButtons && booking.status !== 'pending') {
            const confirmBtn = actionButtons.querySelector('.btn-confirm');
            const cancelBtn = actionButtons.querySelector('.btn-cancel');
            if (confirmBtn) confirmBtn.remove();
            if (cancelBtn) cancelBtn.remove();
        }
    }

    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 1rem;">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'}" style="color: ${type === 'success' ? '#28a745' : '#0c5460'}; font-size: 1.5rem;"></i>
                <div style="flex-grow: 1;">${message}</div>
                <button onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 1.2rem; cursor: pointer;">×</button>
            </div>
        `;

        // Add to page
        let container = document.getElementById('notification-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'notification-container';
            container.style.cssText = 'position: fixed; top: 90px; right: 20px; z-index: 1000; max-width: 400px;';
            document.body.appendChild(container);
        }

        container.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
}

// Initialize real-time updates when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Only start on booking-related pages
    if (window.location.pathname.includes('/bookings') || 
        window.location.pathname === '/' ||
        document.getElementById('bookingsTableBody')) {
        
        window.bookingUpdates = new BookingUpdates();
        window.bookingUpdates.start();

        // Optional: Add visual indicator
        const indicator = document.createElement('div');
        indicator.className = 'real-time-indicator';
        indicator.innerHTML = `
            <div style="position: fixed; bottom: 20px; right: 20px; background: white; padding: 0.8rem 1.2rem; border-radius: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; z-index: 999;">
                <span class="pulse-dot" style="width: 8px; height: 8px; background: #28a745; border-radius: 50%; animation: pulse 2s infinite;"></span>
                <span>Real-time Active</span>
            </div>
        `;
        document.body.appendChild(indicator);
    }
});

// Stop updates when leaving page
window.addEventListener('beforeunload', function() {
    if (window.bookingUpdates) {
        window.bookingUpdates.stop();
    }
});
