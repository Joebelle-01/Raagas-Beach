<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 8px; }
        .header { background: #1a365d; color: #fff; padding: 20px; border-radius: 8px 8px 0 0; text-align: center; }
        .content { padding: 30px; }
        .booking-details { background: #f9f9f9; padding: 20px; border-radius: 4px; margin: 20px 0; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
        .btn { display: inline-block; padding: 10px 20px; background: #3182ce; color: #fff; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Raagas Beach Resort</h1>
        </div>
        <div class="content">
            <h2>{{ $title }}</h2>
            <p>Hello {{ $booking->customer_name }},</p>
            <p>{{ $messageText }}</p>
            
            <div class="booking-details">
                <p><strong>Reference Number:</strong> {{ $booking->reference_number }}</p>
                <p><strong>Cottage:</strong> {{ $booking->cottage->name }}</p>
                <p><strong>Check-in:</strong> {{ $booking->check_in }}</p>
                <p><strong>Check-out:</strong> {{ $booking->check_out }}</p>
                <p><strong>Total Price:</strong> ₱ {{ number_format($booking->total_price, 2) }}</p>
                <p><strong>Status:</strong> <span style="text-transform: capitalize;">{{ $booking->status }}</span></p>
            </div>

            <p>Thank you for choosing Raagas Beach Resort!</p>
            <p>If you have any questions, please contact us at support@raagasbeach.com</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Raagas Beach Resort. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
