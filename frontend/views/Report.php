<?php
namespace themes\shemshad\views;

use packages\base\{View, db};

class Report extends View {
	protected $transactions;
	protected $bills;
	protected $incomes;
	protected $lastTransaction;
	protected $lastBill;
	protected $lastIncome;
	
	public function __construct() {
		$this->transactions = db::orderBy("id", "ASC")->get("shemshad_transactions");
		$this->bills = db::orderBy("id", "ASC")
						->join("shemshad_transactions", "shemshad_transactions.id=shemshad_bills.transaction")
						->get("shemshad_bills", null, ["shemshad_bills.*", "shemshad_transactions.pay_at"]);
		$this->incomes = db::orderBy("id", "ASC")
							->join("shemshad_transactions", "shemshad_transactions.id=shemshad_incomes.transaction")
							->get("shemshad_incomes", null, ["shemshad_incomes.*", "shemshad_transactions.pay_at"]);
		$this->lastTransaction = strtotime(max(array_column($this->transactions, 'pay_at')));
		$this->lastBill = strtotime(max(array_column($this->bills, 'pay_at')));
		$this->lastIncome = strtotime(max(array_column($this->incomes, 'pay_at')));
	}
}
