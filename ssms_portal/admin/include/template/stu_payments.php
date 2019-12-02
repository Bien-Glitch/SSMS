<?php include '../session.php'; ?>
<div class="overlay" id="view-all-overlay"></div>
<div id="all-payments" class="w3-card bg-light shadow" style="display: none; z-index: 2600; position: fixed; height: 90%;">
	<div class="card-header w3-blue">
		<div class="card-heading d-flex justify-content-between">
			<span><i class="fa fa-receipt"></i> ALL PAYMENT RECEIPTS</span>
			<div>
				<a class="text-danger j-link mx-1 close-all-payments" title="Close"><i class="far fa-times"></i></a>
			</div>
		</div>
	</div>

	<div class="card-body">
		<div class="alert alert-info py-1 w3-medium">
			<small>The <span class="w3-text-red w3-large">*</span> sign means the specified field is required!!!</small><br />
			<small>The <span class="w3-text-black w3-large">*</span> sign specifies current Session and/or Term!!!</small>
		</div>

		<div id="display-all-payments" class="s-border-right s-border-bottom"></div>
	</div>
</div>

<div class="w3-card bg-light shadow">
	<div class="card-header w3-deep-orange">
		<div class="card-heading d-flex justify-content-between">
			<span><i class="fa fa-receipt"></i> STUDENTS PAYMENT INFO</span>
			<div>
				<a class="text-warning j-link mx-1 refresh" title="Refresh"><i class="far fa-redo"></i></a>
				<a class="text-dark j-link mx-1 close" title="Close"><i class="far fa-times"></i></a>
			</div>
		</div>
	</div>

	<div class="card-body">
		<div class="alert alert-info py-1 w3-medium">
			<small>The <span class="w3-text-red w3-large">*</span> sign means the specified field is required!!!</small><br />
			<small>The <span class="w3-text-black w3-large">*</span> sign specifies current Session and/or Term!!!</small>
		</div>

		<div class="w3-black p-2 my-2 j-link" id="receipt-toggle">
			<div class="d-flex justify-content-between align-items-center">
				<span><i class="w3-text-green far fa-plus-circle"></i> Add New Payment Info</span>
				<i class="w3-text-red caret fa fa-caret-circle-down"></i>
				<i class="w3-text-red caret fa fa-caret-circle-up" style="display: none"></i>
			</div>
		</div>

		<form action="./include/classes/manage.php" method="post" id="receipt-number-form" style="display: none">
			<div class="row">
				<div class="col-md-3 col-6">
					<div class="form-group">
						<div class="d-flex align-items-center"><label for="session">Session: </label> <span class="w3-text-red w3-large mx-1">*</span></div>
						<div class="input-group">
							<i class="far fa-calendar-alt p-2"></i>
							<select name="session" id="session" class="form-control form-control-sm">
								<option value="" selected disabled>Select session...</option>
							</select>
						</div>
						<div id="sessionValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
							<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
						</div>
					</div>
				</div>

				<div class="col-md-3 col-6">
					<div class="form-group">
						<div class="d-flex align-items-center"><label for="term">Term: </label> <span class="w3-text-red w3-large mx-1">*</span></div>
						<div class="input-group">
							<i class="far fa-calendar-day p-2"></i>
							<select name="term" id="term" class="form-control form-control-sm" disabled>
								<option value="" selected disabled>Select a session first</option>
							</select>
						</div>
						<div id="termValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
							<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
						</div>
					</div>
				</div>

				<div class="col-md-3 col-6">
					<div class="form-group">
						<div class="d-flex align-items-center"><label for="receiptno">Receipt No.: </label> <span class="w3-text-red w3-large mx-1">*</span></div>
						<div class="input-group">
							<i class="far fa-receipt p-2"></i>
							<input type="text" name="receiptno" id="receiptno" class="form-control form-control-sm" placeholder="Select session and term first..." disabled>
						</div>
						<div id="receiptnoValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
							<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
						</div>
					</div>
				</div>

				<div class="col-md-3 col-6">
					<div class="form-group">
						<div class="d-flex align-items-center"><label for="amount_inp">Amount Paid: </label> <span class="w3-text-red w3-large mx-1">*</span></div>
						<div class="input-group">
							<span class="form-control form-control-sm w3-light-grey" style="max-width: 30px">&#x20A6;</span>
							<input type="text" name="amount" id="amount_inp" class="form-control form-control-sm" placeholder="Select session and term first..." disabled>
						</div>
						<div id="amount_inpValidate" class="valid-text ml-4 my-1 py-1 px-2 w3-round alert" style="display:none">
							<div class="d-flex justify-content-between"><span><i class="fa fa-times-circle"></i></span></div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-lock-alt"></i> Generate Pin</button>
					</div>
				</div>
			</div>
			<div id="mess" style="display: none">
				<i class="text-danger fa fa-exclamation-circle"></i> <span class="text-primary">Please Wait...</span>
			</div>
			<hr />
		</form>

		<div class="display-payment">
			<div class="w3-black p-2 my-2 j-link" id="payments-toggle">
				<div class="d-flex justify-content-between align-items-center">
					<span><i class="w3-text-green far fa-receipt"></i> View Payments</span>
					<i class="w3-text-red pay-caret fa fa-caret-circle-down" style="display: none"></i>
					<i class="w3-text-red pay-caret fa fa-caret-circle-up"></i>
				</div>
			</div>

			<div id="payments" class="s-border-right s-border-bottom"></div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		let card = $('.w3-card'),
			card_height = card.height(),
			screen_height = screen.height;

		function formatAmountInput() {
			let amount_inp = $('#amount_inp');

			amount_inp.blur(function () {
				let val = $(this).val();
				if (val !== '') {
					let amount = $(this).val(),
						new_amount = accounting.formatNumber(amount);

					$(this).val(new_amount, '');
					val = $(this).val();
					if (val === '0') {
						alert('Please input an amount!!!');
					}
				}
			});
		}

		card.css({
			'max-height': 'calc(' + screen_height + 'px - 100px)',
			'overflow': 'hidden'
		});

		$('#all-payments').css({
			'left': '25%',
			'height': 'calc(' + screen_height + 'px - 100px)',
			'overflow-y': 'auto'
		});

		$('.w3-card #payments').css({
			'max-height': 'calc(' + card_height + 'px + 377px)',
			'overflow-y': 'auto'
		});

		formatAmountInput()
	});
</script>