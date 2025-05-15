<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Invoice #<?= $invoice['invoice_number'] ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css') ?>">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
        }

        .invoice-container {
            border: 1px solid #000;
            padding: 15px;
            max-width: 800px;
            margin: 0 auto;
        }

        .invoice-header {
            margin-bottom: 20px;
        }

        .company-name {
            font-weight: bold;
            font-size: 16px;
        }

        .company-address {
            font-size: 12px;
        }

        .invoice-number {
            margin-top: 10px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .table-items {
            width: 100%;
            border-collapse: collapse;
        }

        .table-items th,
        .table-items td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: middle;
        }

        .table-items th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 50%;
            text-align: center;
        }

        @media print {
            @page {
                size: A4;
                margin: 10mm;
            }

            .no-print {
                display: none !important;
            }

            body {
                margin: 0 !important;
                padding: 0 !important;
            }

            .invoice-container {
                border: 1px solid #000 !important;
                width: 100% !important;
                max-width: 100% !important;
                padding: 15px !important;
            }

            .row {
                display: flex !important;
                flex-wrap: wrap !important;
                margin-right: -7.5px !important;
                margin-left: -7.5px !important;
            }

            .col-md-6 {
                flex: 0 0 50% !important;
                max-width: 50% !important;
                position: relative !important;
                width: 50% !important;
                padding-right: 7.5px !important;
                padding-left: 7.5px !important;
            }
            
            .text-right {
                text-align: right !important;
            }
            
            .text-center {
                text-align: center !important;
            }
            
            .table-items {
                width: 100% !important;
                border-collapse: collapse !important;
            }
            
            .table-items th, 
            .table-items td {
                border: 1px solid #000 !important;
                padding: 8px !important;
            }
            
            .container {
                width: 100% !important;
                padding-right: 15px !important;
                padding-left: 15px !important;
                margin-right: auto !important;
                margin-left: auto !important;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="container my-4">
        <div class="no-print mb-4">
            <button class="btn btn-primary" onclick="window.print()">
                <i class="fas fa-print"></i> Print Invoice
            </button>
            <a href="<?= base_url('invoice') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="invoice-container">
            <!-- Header section with company info and recipient -->
            <div class="row invoice-header">
                <div class="col-md-6">
                    <div class="company-name">PT. Bhinneka Sangkuriang Transport</div>
                    <div class="company-address">
                        Jl. Gedebage Selatan No.121A,<br>
                        Cisaranten Kidul, Kec. Gedebage,<br>
                        Kota Bandung, Jawa Barat 40552
                    </div>
                </div>
                <div class="col-md-6 text-right">
                    <strong>Kepada Yth :</strong><br>
                    <strong><?= $invoice['company_to'] ?></strong><br>
                    <?= $invoice['company_address'] ?><br>
                    Up : <b><?= $invoice['attention_to'] ?></b>
                </div>
            </div>

            <!-- Invoice number -->
            <div class="invoice-number">
                No. Faktur : <?= $invoice['invoice_number'] ?>
            </div>

            <!-- Table of items -->
            <table class="table-items">
                <thead>
                    <tr>
                        <th style="width: 10%;">Kode</th>
                        <th style="width: 30%;">Nama</th>
                        <th style="width: 10%;">Satuan</th>
                        <th style="width: 10%;">Jumlah</th>
                        <th style="width: 15%;">Harga</th>
                        <th style="width: 25%;">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalQuantity = 0;
                    $totalPrice = 0;
                    foreach ($items as $item):
                        $totalQuantity += $item['quantity'];
                        $totalPrice += $item['price'];
                    ?>
                        <tr>
                            <td class="text-center"><?= $item['product_code'] ?></td>
                            <td><?= $item['product_name'] ?></td>
                            <td class="text-center"><?= $item['unit'] ?></td>
                            <td class="text-center"><?= $item['quantity'] ?></td>
                            <td class="text-right">Rp. <?= number_format($item['price'], 0, ',', '.') ?></td>
                            <td class="text-right">Rp. <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" class="text-center"><strong>TOTAL</strong></td>
                        <td class="text-center"><strong><?= $totalQuantity ?></strong></td>
                        <td class="text-right"><strong>Rp. <?= number_format($totalPrice, 0, ',', '.') ?></strong></td>
                        <td class="text-right"><strong>Rp. <?= number_format($totalAmount, 0, ',', '.') ?></strong></td>
                    </tr>
                </tbody>
            </table>

            <!-- Signature section -->
            <div class="row">
                <div class="col-md-6 text-center">
                    <div style="margin-top: 30px;">
                        <strong>Purchasing</strong>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <div style="margin-top: 30px;">
                        <?php
                        $location = '';
                        if (isset($invoice['location'])) {
                            $location = $invoice['location'];
                        } else {
                            $location = 'Cirebon';
                        }

                        // Format date to match "25 June 2024" format
                        $months = [
                            '01' => 'January',
                            '02' => 'February',
                            '03' => 'March',
                            '04' => 'April',
                            '05' => 'May',
                            '06' => 'June',
                            '07' => 'July',
                            '08' => 'August',
                            '09' => 'September',
                            '10' => 'October',
                            '11' => 'November',
                            '12' => 'December'
                        ];

                        $dateObj = new DateTime($invoice['created_at']);
                        $day = $dateObj->format('d');
                        $month = $months[$dateObj->format('m')];
                        $year = $dateObj->format('Y');
                        $formattedDate = "$day $month $year";
                        ?>
                        <?= $location ?>, <?= $formattedDate ?>
                    </div>
                </div>
            </div>

            <div class="signature-section">
                <div class="signature-box">
                    <div style="height: 80px;"></div>
                    <div>
                        <strong><?= $invoice['staff_name'] ?></strong>
                    </div>
                </div>
                <div class="signature-box">
                    <div style="height: 80px;"></div>
                    <div>
                        <strong><?= $invoice['attention_to'] ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>