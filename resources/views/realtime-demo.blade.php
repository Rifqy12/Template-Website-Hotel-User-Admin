<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Updates - Hotel Paradise</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .notification {
            background: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            animation: slideIn 0.3s ease;
        }
        @keyframes slideIn {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h1>Real-Time Booking Updates</h1>
    <div id="notifications"></div>

    <script>
        // Simulated WebSocket connection for real-time updates
        // In production, this would use Pusher or Laravel WebSockets
        
        function addNotification(booking, type) {
            const notif = document.createElement('div');
            notif.className = 'notification';
            notif.innerHTML = `
                <strong>${type === 'created' ? 'Booking Baru!' : 'Update Booking'}</strong><br>
                Booking #${booking.id} - ${booking.room.type} Kamar ${booking.room.number}<br>
                Status: <span class="status status-${booking.status}">${booking.status}</span><br>
                <small>Tamu: ${booking.user.name}</small>
            `;
            document.getElementById('notifications').prepend(notif);
        }

        // Simulate receiving updates every 30 seconds
        setInterval(() => {
            console.log('Checking for new bookings...');
            // In production, this would listen to WebSocket events
        }, 30000);

        // Example: Fetch updates from API
        async function checkForUpdates() {
            try {
                const response = await fetch('/api/bookings');
                const data = await response.json();
                // Process new bookings
            } catch (error) {
                console.error('Error fetching updates:', error);
            }
        }

        // Start checking for updates
        checkForUpdates();
        setInterval(checkForUpdates, 30000);
    </script>
</body>
</html>
