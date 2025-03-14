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
            width: 190mm;
            height: 180mm; /* A4 size */
            margin: 0 auto;
            padding: 10mm;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            page-break-after: always;
        }

        .customer-container {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
        }

        .customer-box {
            width: calc(100% / 3 - 10px); /* 3 columns */
            height: calc((180mm - 20mm) / 3 - 5mm); /* 3 rows */
            margin: 5px;
            border: 1px solid #ccc;
            padding: 8px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .customer-box span {
            font-size: 14px;
            font-weight: bold;
        }

        .customer-box p {
            font-size: 12px;
            margin: 2px 0;
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
                        <span>{{ $customer->first_name . " " . $customer->last_name }}</span>
                        <p>
                            @if(!empty($customer->permanent_address))
                                @foreach(explode(',', $customer->permanent_address) as $line)
                                    {{ $line }} <br>
                                @endforeach
                            @endif
                        </p>
                        <p><strong>Pincode:</strong> {{ $customer->customerpincode->pin_code ?? '-' }}</p>
                        <p><strong>Phone:</strong> {{ $customer->phone_number }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
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
            width: 190mm;
            height: 160mm; /* A4 size */
            margin: 0 auto;
            padding: 10mm;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            page-break-after: always;
        }

        .customer-container {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
        }

        .customer-box {
            width: calc(100% / 3 - 10px); /* 3 columns */
            height: calc((160mm - 20mm) / 3 - 5mm); /* 3 rows */
            margin: 5px;
            border: 1px solid #ccc;
            padding: 8px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .customer-box span {
            font-size: 14px;
            font-weight: bold;
        }

        .customer-box p {
            font-size: 11px;
            margin: 2px 0;
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
                        <span>{{ $customer->first_name . " " . $customer->last_name }}</span>
                        <p>
                            @if(!empty($customer->permanent_address))
                                @foreach(explode(',', $customer->permanent_address) as $line)
                                    {{ $line }} <br>
                                @endforeach
                            @endif
                        </p>
                        <p><strong>Pincode:</strong> {{ $customer->customerpincode->pin_code ?? '-' }}</p>
                        <p><strong>Phone:</strong> {{ $customer->phone_number }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
