<?php // $> php tests/loop.php

require __DIR__ . '/../vendor/autoload.php';

$csv = new anovsiradj\csv\Reader(__DIR__ . '/states.csv');

/* HEADER - https://secure.php.net/manual/en/generator.current.php */
// $header = $csv->stream(0,1)->current();
// echo '[ ' , implode(' | ', $header) , ' ]', PHP_EOL;

/* CONTENTS (first 10 entries) */
foreach ($csv->stream(9,3) as $buffer) {
	echo '[ ' , implode(' | ', $buffer) , ' ]', PHP_EOL;
}

$csv->close();
