<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/styles.css">
	<title>Document</title>
</head>
<body>
<header>
	<a href="#">Stamp Duty Calculater</a>
</header>
<div class="container">
	<form>
		<ul class="form_list">
			<li class="value">
				<label for="value" class="input_label">Property Value(£):</label>
				<input id="value" type="number" name="value" value="<?= $value ?>" >
			</li>
			<li class="type">
				<label for="type" class="input_label">Property Type:
					<div class="tooltip">
						<img class="hint" src="/question-mark-round.svg" alt="hint">
						<span class="tooltiptext">
							<a href="https://www.gov.uk/stamp-duty-land-tax/residential-property-rates" target="_blank">
								Click here for more details
							</a>
					</span>
					</div>
				</label>
				<input type="radio" id="type1" name="type" value="1" 
				<?php if ($isMain)print("checked=\"checked\"") ?>>
				<label for="type1" class="radio_styled">Main</label>
				<input type="radio" id="type2" name="type" value="0"
				<?php if (!$isMain)print("checked=\"checked\"") ?>>
				<label for="type2" class="radio_styled">Additional</label><br>
			</li>
			<li>
				<input type="submit" class="button" value="Calculate">
			</li>
	</form>

	<table width="100%">
	<?php if(count($table) > 0) { ?>
		<tr>
			<th>Range</th>
			<th>Percent</th>
			<th>Value</th>
			<th>Stamp Duty</th>
		</tr>
		<?php foreach($table as $index=>$row) { ?>
			<tr <?php if($index%2 === 1) print("class=\"odd\"") ?>>
				<td><?= $row['range'] ?></td>
				<td><?= $row['percent'] ?></td>
				<td><?= $row['value'] ?></td>
				<td><?= $row['stamp_duty'] ?></td>
			</tr>
		<?php } ?>
	</table>
	<?php } ?>
</div>
</body>
</html>