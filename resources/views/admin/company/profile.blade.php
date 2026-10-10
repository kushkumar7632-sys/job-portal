<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Company Profile</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            margin: 0;
        }

        .header {
            background: #2563eb;
            color: white;
            padding: 20px 10%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .container {
            width: 80%;
            margin: 40px auto;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .row {
            margin-bottom: 20px;
        }

        .label {
            font-weight: bold;
            color: #555;
        }

        .value {
            margin-top: 5px;
            font-size: 17px;
        }
    </style>
</head>

<body>

<div class="header">
    <h2>Company Profile</h2>

    <a href="{{ route('company.dashboard') }}"
       style="color:white;text-decoration:none;">
        Back to Dashboard
    </a>
</div>

<div class="container">

    <div class="card">

        <div class="row">
            <div class="label">Company Name</div>
            <div class="value">{{ $company->company_name }}</div>
        </div>

        <div class="row">
            <div class="label">Owner Name</div>
            <div class="value">{{ $company->owner_name }}</div>
        </div>

        <div class="row">
            <div class="label">Email</div>
            <div class="value">{{ $company->email }}</div>
        </div>

        <div class="row">
            <div class="label">Phone</div>
            <div class="value">{{ $company->phone }}</div>
        </div>

        <div class="row">
            <div class="label">Website</div>
            <div class="value">
                {{ $company->website ?? 'Not provided' }}
            </div>
        </div>

        <div class="row">
            <div class="label">Industry</div>
            <div class="value">{{ $company->industry }}</div>
        </div>

        <div class="row">
            <div class="label">Address</div>
            <div class="value">{{ $company->address }}</div>
        </div>

    </div>

</div>

</body>
</html>