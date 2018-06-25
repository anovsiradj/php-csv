<?php
require 'reader.php';

$csv = new anovsiradj\csv\Reader('nabire-wanggar-wiraska.csv', array(
	'line_delimiter' => ';',
	'line_enclosure' => '"',
));

$i = 0;
foreach($csv->stream(10,10) as $buffer) {
	$index = '[' . $i . ']';

	echo $index, implode(',', $buffer), PHP_EOL;

	$i++; if ($i >= 100) break;
}

$csv->close();
