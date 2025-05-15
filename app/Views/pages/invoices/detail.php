<div class="invoice-details">
    <div class="row mb-4">
        <div class="col-md-6">
            <h5>Detail Invoice</h5>
            <table class="table table-sm">
                <tr>
                    <th>No. Invoice</th>
                    <td>: <?= $invoice['invoice_number'] ?></td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>: <?= date('d/m/Y', strtotime($invoice['created_at'])) ?></td>
                </tr>
                <tr>
                    <th>Staff</th>
                    <td>: <?= $invoice['staff_name'] ?></td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <h5>Ditagihkan Kepada</h5>
            <table class="table table-sm">
                <tr>
                    <th>Perusahaan</th>
                    <td>: <?= $invoice['company_to'] ?></td>
                </tr>
                <tr>
                    <th>Attention</th>
                    <td>: <?= $invoice['attention_to'] ?></td>
                </tr>
            </table>
        </div>
    </div>

    <h5>Item Invoice</h5>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($items as $item): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $item['product_code'] ?></td>
                    <td><?= $item['product_name'] ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= $item['unit'] ?></td>
                    <td class="text-right"><?= number_format($item['price'], 0, ',', '.') ?></td>
                    <td class="text-right"><?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6" class="text-right">Total:</th>
                    <th class="text-right"><?= number_format($totalAmount, 0, ',', '.') ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div> 