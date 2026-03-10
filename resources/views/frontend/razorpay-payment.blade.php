<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Test Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa, #e4ecfb);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .payment-wrapper {
            width: 100%;
            max-width: 420px;
        }

        .payment-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .payment-header {
            background: linear-gradient(135deg, #528ff0, #2b6de9);
            color: #fff;
            padding: 30px 25px;
            text-align: center;
        }

        .payment-header h2 {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .payment-header p {
            font-size: 14px;
            opacity: 0.95;
        }

        .payment-body {
            padding: 30px 25px;
        }

        .amount-box {
            background: #f8faff;
            border: 1px solid #dbe7ff;
            border-radius: 14px;
            padding: 18px;
            text-align: center;
            margin-bottom: 25px;
        }

        .amount-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }

        .amount-value {
            font-size: 34px;
            font-weight: bold;
            color: #1d4ed8;
        }

        .payment-info {
            margin-bottom: 25px;
        }

        .payment-info .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 15px;
            color: #444;
        }

        .payment-info .row span:last-child {
            font-weight: 600;
            color: #111;
        }

        .pay-btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #528ff0, #2b6de9);
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .pay-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(43, 109, 233, 0.25);
        }

        .pay-btn:active {
            transform: translateY(0);
        }

        .note {
            margin-top: 18px;
            font-size: 13px;
            color: #777;
            text-align: center;
            line-height: 1.6;
        }

        .success-box {
            margin-top: 20px;
            padding: 14px;
            background: #ecfdf3;
            border: 1px solid #bbf7d0;
            color: #15803d;
            border-radius: 12px;
            display: none;
            font-size: 14px;
            line-height: 1.6;
        }

        .hidden-form {
            display: none;
        }
    </style>
</head>
<body>

    <div class="payment-wrapper">
        <div class="payment-card">
            <div class="payment-header">
                <h2>Test Payment</h2>
                <p>Razorpay integration in Laravel</p>
            </div>

            <div class="payment-body">
                <div class="amount-box">
                    <div class="amount-label">Amount to Pay</div>
                    <div class="amount-value">₹{{ number_format($amount / 100, 2) }}</div>
                </div>

                <div class="payment-info">
                    <div class="row">
                        <span>Merchant</span>
                        <span>{{ $name }}</span>
                    </div>
                    <div class="row">
                        <span>Description</span>
                        <span>{{ $description }}</span>
                    </div>
                    <div class="row">
                        <span>Currency</span>
                        <span>INR</span>
                    </div>
                    <div class="row">
                        <span>Status</span>
                        <span>Test Mode</span>
                    </div>
                </div>

                <button id="rzp-button1" class="pay-btn">Pay with Razorpay</button>

                <div class="note">
                    This is a Razorpay test payment page.<br>
                    No real money will be deducted in test mode.
                </div>

                <div class="success-box" id="success-box"></div>

                <form action="{{ route('razorpay.success') }}" method="POST" id="payment-success-form" class="hidden-form">
                    @csrf
                    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                    <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
                    <input type="hidden" name="razorpay_signature" id="razorpay_signature">
                </form>
            </div>
        </div>
    </div>

    <script>
        var options = {
            "key": "{{ $razorpayKey }}",
            "amount": "{{ $amount }}",
            "currency": "INR",
            "name": "{{ $name }}",
            "description": "{{ $description }}",
            "image": "https://cdn.razorpay.com/logos/GhRQcyean79PqE_medium.png",
            "order_id": "{{ $orderId }}",
            "handler": function (response) {
                document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                document.getElementById('razorpay_signature').value = response.razorpay_signature;

                document.getElementById('success-box').style.display = 'block';
                document.getElementById('success-box').innerHTML =
                    "<strong>Payment Success!</strong><br>" +
                    "Payment ID: " + response.razorpay_payment_id;

                setTimeout(function () {
                    document.getElementById('payment-success-form').submit();
                }, 1200);
            },
            "prefill": {
                "name": "{{ $customerName ?? 'Test User' }}",
                "email": "{{ $customerEmail ?? 'test@example.com' }}",
                "contact": "{{ $customerPhone ?? '9999999999' }}"
            },
            "theme": {
                "color": "#2b6de9"
            },
            "modal": {
                "ondismiss": function () {
                    console.log("Payment popup closed");
                }
            }
        };

        var rzp1 = new Razorpay(options);

        document.getElementById('rzp-button1').onclick = function (e) {
            rzp1.open();
            e.preventDefault();
        };
    </script>

</body>
</html>