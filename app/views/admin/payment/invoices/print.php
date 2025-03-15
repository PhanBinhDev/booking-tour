<?php

use App\Helpers\UrlHelper;
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hóa đơn #<?= $invoice['invoice_number'] ?></title>
  <link rel="stylesheet" href="<?= UrlHelper::css('print-invoices.css') ?>">
</head>

<body>
  <div class="no-print" style="text-align: center; padding: 20px;">
    <button class="print-button" onclick="window.print()">In hóa đơn</button>
  </div>

  <div class="invoice-container <?= $invoice['status'] === 'paid' ? 'status-paid' : '' ?>">
    <div class="invoice-header">
      <div class="company-info">
        <div class="company-name"><?= htmlspecialchars($companyInfo['name'] ?? 'Công ty Du lịch') ?></div>
        <div><?= htmlspecialchars($companyInfo['address'] ?? '123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh') ?></div>
        <div>Điện thoại: <?= htmlspecialchars($companyInfo['phone'] ?? '0123 456 789') ?></div>
        <div>Email: <?= htmlspecialchars($companyInfo['email'] ?? 'info@example.com') ?></div>
        <div>Mã số thuế: <?= htmlspecialchars($companyInfo['tax_id'] ?? '0123456789') ?></div>
      </div>
      <div>
        <div class="invoice-title">HÓA ĐƠN</div>
        <div class="invoice-details">
          <div class="invoice-id">Số: <?= htmlspecialchars($invoice['invoice_number']) ?></div>
          <div>Ngày: <?= date('d/m/Y', strtotime($invoice['created_at'])) ?></div>
          <?php if(!empty($invoice['paid_at'])): ?>
          <div>Ngày thanh toán: <?= date('d/m/Y', strtotime($invoice['paid_at'])) ?></div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="customer-supplier-info">
      <div class="customer-info">
        <div class="info-title">Thông tin khách hàng</div>
        <div class="info-content"><strong>Tên:</strong> <?= htmlspecialchars($invoice['customer_name']) ?></div>
        <div class="info-content"><strong>Email:</strong> <?= htmlspecialchars($invoice['customer_email']) ?></div>
        <?php if(!empty($invoice['customer_phone'])): ?>
        <div class="info-content"><strong>Điện thoại:</strong> <?= htmlspecialchars($invoice['customer_phone']) ?></div>
        <?php endif; ?>
        <?php if(!empty($invoice['customer_address'])): ?>
        <div class="info-content"><strong>Địa chỉ:</strong> <?= htmlspecialchars($invoice['customer_address']) ?></div>
        <?php endif; ?>
      </div>
      <div class="supplier-info">
        <div class="info-title">Thông tin thanh toán</div>
        <div class="info-content"><strong>Phương thức:</strong>
          <?= htmlspecialchars($invoice['payment_method'] ?? 'Không xác định') ?></div>
        <div class="info-content"><strong>Mã giao dịch:</strong> <?= htmlspecialchars($invoice['transaction_code']) ?>
        </div>
        <div class="info-content"><strong>Trạng thái:</strong>
          <?php
          switch($invoice['status']) {
            case 'paid':
              echo 'Đã thanh toán';
              break;
            case 'pending':
              echo 'Chờ thanh toán';
              break;
            case 'cancelled':
              echo 'Đã hủy';
              break;
            default:
              echo ucfirst($invoice['status']);
          }
          ?>
        </div>
      </div>
    </div>

    <table class="invoice-items">
      <thead>
        <tr>
          <th>STT</th>
          <th>Mô tả</th>
          <th>Số lượng</th>
          <th class="amount">Đơn giá</th>
          <th class="amount">Thành tiền</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $items = json_decode($invoice['items'] ?? '[]', true);
        $i = 1;
        foreach($items as $item): 
        ?>
        <tr>
          <td><?= $i++ ?></td>
          <td>
            <div><strong><?= htmlspecialchars($item['name'] ?? '') ?></strong></div>
            <?php if(!empty($item['description'])): ?>
            <div><?= htmlspecialchars($item['description'] ?? '') ?></div>
            <?php endif; ?>
          </td>
          <td><?= $item['quantity'] ?? 1 ?></td>
          <td class="amount"><?= number_format($item['price'] ?? 0, 0, ',', '.') ?> đ</td>
          <td class="amount"><?= number_format($item['total'] ?? 0, 0, ',', '.') ?> đ</td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <table class="invoice-total">
      <tr>
        <td class="label">Tạm tính:</td>
        <td class="amount"><?= number_format($invoice['amount'], 0, ',', '.') ?> đ</td>
      </tr>
      <tr>
        <td class="label">Thuế (<?= ($invoice['tax_amount'] / $invoice['amount'] * 100) ?>%):</td>
        <td class="amount"><?= number_format($invoice['tax_amount'], 0, ',', '.') ?> đ</td>
      </tr>
      <tr class="total-row">
        <td class="label">Tổng cộng:</td>
        <td class="amount"><?= number_format($invoice['total_amount'], 0, ',', '.') ?> đ</td>
      </tr>
    </table>

    <?php if(!empty($invoice['notes'])): ?>
    <div class="invoice-notes">
      <div class="info-title">Ghi chú</div>
      <div><?= nl2br(htmlspecialchars($invoice['notes'])) ?></div>
    </div>
    <?php endif; ?>

    <?php if(!empty($paymentTerms)): ?>
    <div class="invoice-notes">
      <div class="info-title">Điều khoản thanh toán</div>
      <div><?= nl2br(htmlspecialchars($paymentTerms)) ?></div>
    </div>
    <?php endif; ?>

    <div class="invoice-footer">
      <p>Cảm ơn quý khách đã sử dụng dịch vụ của chúng tôi!</p>
      <p>Hóa đơn này được tạo tự động và có giá trị pháp lý khi có đóng dấu của công ty.</p>
    </div>
  </div>
</body>

</html>