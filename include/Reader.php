<?php
namespace anovsiradj\csv;

class Reader {
	public static $cfg_default = array(
		'file_read_mode' => 'r',
		'line_delimiter' => ',',
		'line_enclosure' => '"',
		'line_buffer' => 4096
	);
	public $cfg = array();

	public $csv_context;

	public function __construct($file = null, $cfg = null) {
		$this->config_merge_set($cfg);
		$this->open($file);
	}

	public function config_merge()
	{
		foreach(self::$cfg_default as $k => $v) {
			$this->cfg[$k] = $v;
		}
	}
	public function config_merge_set($cfg)
	{
		$this->config_merge();

		if (is_array($cfg)) {
			foreach($cfg as $k => $v) {
				if (is_int($k) === false) {
					$this->cfg[$k] = $v;
				}
			}
		}
	}

	public function open($file = null) {
		if (empty($file) && isset($this->cfg['file'])) {
			$file = $this->cfg['file'];
		}

		if((empty($file) === false && file_exists($file))) {
			$this->cfg['file'] = $file;
			$this->csv_context = fopen($file, $this->cfg['file_read_mode']);
		}
	}

	public function close()
	{
		if ($this->csv_context) fclose($this->csv_context);
		$this->csv_context = null;
	}

	public function stream() {
		if ($this->csv_context === null) return;

		$args = func_get_args();

		if (isset($args[1])) {
			$min = (int)$args[0];
			$max = (int)$args[1];
			$max += $min;
		} elseif (isset($args[0])) {
			$min = 0;
			$max = (int)$args[0];
		} else {
			$min = 0;
			$max = PHP_INT_MAX;
		}

		// fseek($this->csv_context, $min, SEEK_SET);

		$i = 0;
		while (($data = fgetcsv($this->csv_context, $this->cfg['line_buffer'], $this->cfg['line_delimiter'], $this->cfg['line_enclosure'])) !== false) {
			if ($i >= $max) break;
			if ($i >= $min) yield $data;
			$i++;
		}
	}

	public static function config_default($cfg = null) {
		if($cfg === null) return self::$cfg_default;
		elseif(is_array($cfg)) {
			foreach($cfg as $k => $v) {
				if(is_string($k)) self::$cfg_default[$k] = $v;
			}
		}
	}

	public function __destruct()
	{
		$this->close();
	}
}
