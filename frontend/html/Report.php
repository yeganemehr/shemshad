<?php
use packages\base\{Date, db};
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ساختمان شمشاد</title>
	<?php $this->loadCSS(); ?>
</head>
<body class="rtl report">
<div class="page">
	<header>
		<div class="logo">
			ساختمان شمشاد
		</div>
		<div class="row">
			<div class="col title">
				گزارش وضعیت مالی
			</div>
			<div class="col details">
				<p><strong>آخرین بروزرسانی: </strong> <span class="ltr"><?php echo Date::format("Y/m/d H:i", $this->lastTransaction); ?></span></p>
			</div>
		</div>
		<hr>
	</header>
	<h2>تراکنش ها - از قدیم به جدید</h2>
	<div class="table-responsive">
		<table class="table table-striped table-sm table-hover">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center" style="width: 160px;">تاریخ</th>
					<th class="text-center" style="width: 180px;">مبلغ</th>
					<th class="text-center">توضیحات</th>
					<th class="text-center">موجودی</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($this->transactions as $transaction) {
				?>
				<tr>
					<td class="text-center"><?php echo $transaction['id']; ?></td>
					<td class="text-center"><?php echo Date::format("d F Y <br> H:i", strtotime($transaction['pay_at'])); ?></td>
					<td><?php
						if ($transaction['price'] < 0) {
							echo ("<span class=\"badge badge-warning\">هزینه</span> ");
						} else {
							echo ("<span class=\"badge badge-success\">درآمد</span> ");
						} echo number_format(abs($transaction['price']) / 10) . " تومان";
					?></td>
					<td><?php echo $transaction['title']; ?></td>
					<td><?php
						echo number_format(abs($transaction['balance']) / 10) . " تومان";

						if ($transaction['balance'] < 0) {
							echo ("<br><span class=\"badge badge-danger\">بدهکار</span>");
						}
					?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<div class="page">
	<header>
		<div class="logo">
			ساختمان شمشاد
		</div>
		<div class="row">
			<div class="col title">
				گزارش وضعیت مالی
			</div>
			<div class="col details">
				<p><strong>آخرین بروزرسانی: </strong> <span class="ltr"><?php echo Date::format("Y/m/d H:i", $this->lastBill); ?></span></p>
			</div>
		</div>
		<hr>
	</header>
	<h2>قبوض پرداخت شده</h2>
	<div class="table-responsive">
		<table class="table table-striped table-sm table-hover">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center" style="width: 160px;">تاریخ</th>
					<th class="text-center" style="width: 180px;">مبلغ</th>
					<th class="text-center">توضیحات</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($this->bills as $bill) {
				?>
				<tr>
					<td class="text-center"><?php echo $bill['id']; ?></td>
					<td class="text-center"><?php echo Date::format("d F Y <br> H:i", strtotime($bill['pay_at'])); ?></td>
					<td><?php echo number_format(abs($bill['price']) / 10) . " تومان"; ?></td>
					<td><?php echo $bill['title'] . "<br>" . nl2br($bill['description']); ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<div class="page">
	<header>
		<div class="logo">
			ساختمان شمشاد
		</div>
		<div class="row">
			<div class="col title">
				گزارش وضعیت مالی
			</div>
			<div class="col details">
				<p><strong>آخرین بروزرسانی: </strong> <span class="ltr"><?php echo Date::format("Y/m/d H:i", $this->lastIncome); ?></span></p>
			</div>
		</div>
		<hr>
	</header>
	<h2>وضعیت شارژ واحد ها</h2>
	<div class="table-responsive">
		<table class="table table-striped table-sm table-hover">
			<thead>
				<tr>
					<th></th>
					<?php
					for($x = 12; $x >= 0; $x--) {
						$time = strtotime("-{$x} months");
						$year = intval(Date::format("Y", $time)); 
						$month = intval(Date::format("m", $time)); 
						if ($year < 1397 or ($year == 1397 and $month < 7)) {
							continue;
						}
						echo ("<th class=\"text-center\">" . Date::format("F <br> Y", $time) . "</th>");
					}
					?>
				</tr>
			</thead>
			<tbody>
				<?php
				for ($door = 0; $door < 6; $door++) {
					echo ("<tr>");
					echo "<td class=\"text-center\">" . ($door == 0 ? "مغازه" : "واحد {$door}")."</td>";
					for($x = 12; $x >= 0; $x--) {
						$time = strtotime("-{$x} months");
						$year = intval(Date::format("Y", $time)); 
						$month = intval(Date::format("m", $time));
						if ($year < 1397 or ($year == 1397 and $month < 7)) {
							continue;
						}
						$found = false;
						foreach ($this->incomes as $income) {
							if (
								$income['door'] == $door and
								$income['year'] == $year and
								$income['year'] == $year and
								$income['month'] == $month
							) {
								$found = true;
								break;
							}
						}
						echo ("<th class=\"text-center\">" . ($found ? "<i class=\"fa fa-check-circle\"></i>" : "<i class=\"fa fa-times-circle\"></i>") . "</th>");
					}
					echo "</tr>";
				}
				?>
			</tbody>
		</table>
	</div>
</div>
</body>
</html>