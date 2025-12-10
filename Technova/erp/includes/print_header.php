<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gate Pass Print</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @media print {
            body {
                font-size: 12pt;
            }
            .container {
                width: 100%;
                max-width: 100%;
            }
            .print-container {
                padding: 20px;
            }
            .card {
                border: 1px solid #ddd;
                margin-bottom: 15px;
            }
            .card-header {
                background-color: #f8f9fa;
                border-bottom: 1px solid #ddd;
                padding: 10px;
            }
            .card-body {
                padding: 15px;
            }
            .signature-box {
                height: 80px;
                margin-top: 30px;
            }
            .border-top {
                border-top: 1px solid #000 !important;
            }
            /* Hide unnecessary elements when printing */
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>
