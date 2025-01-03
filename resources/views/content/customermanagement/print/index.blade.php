<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Customers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .page {
            width: 210mm;
            height: 297mm;
            margin: 0 auto;
            page-break-after: always;
            padding: 10mm;
        }
        .customer-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .customer-box {
            width: 48%; /* Two customers per row */
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            box-sizing: border-box;
        }
        .customer-box h4 {
            margin: 0 0 5px;
        }
        .customer-box p {
            margin: 0;
            font-size: 14px;
        }
        @media print {
            .page {
                page-break-after: always;
            }
        }
    </style>
</head>
<body>

    @foreach ($customersPerPage as $customers)
        <div class="page">
            <div class="customer-container">
                @foreach ($customers as $customer)
                    <div class="customer-box">
                        <h4>{{ $customer->first_name }}</h4>
                        <p><strong>Phone:</strong> {{ $customer->phone_number }}</p>
                        <p><strong>Address:</strong> {{ $customer->address }}</p>
                        <p><strong>Pincode:</strong> {{ $customer->pincode }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
    <script>
        window.print();
    </script>
</body>
</html>
