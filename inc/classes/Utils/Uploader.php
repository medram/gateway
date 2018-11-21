<?php

namespace MR4Web\Utils;

use MR4Web\Utils\Uploader\Exception;
use MR4Web\Utils\Uploader\File;

/*
try {
	$uploader = new Uploader([
		'fieldName': '',
		'uploadsDir': '/users/54454254dg/products/',
		'fileName': 'adlkjdfkgjdfkgdfg45f.zip',
		'maxSize': 200*1024, // in KB.
		'allowedTypes': ['rar', 'zip'],
		'multiple': true, // upload multiple files. 
	]);
	
	if ($uploader->doUpload())
	{
		$info = $uploader->getInfo(); // array of infos
	}
} catch (UploaderException $e) {
	echo $e->getErrors();
}

*/

class Uploader
{
	private $_handle;
	private $_files = [];
	private $_totalFilesNum = 0;

	private $_configs = [
		'fieldName'		=> '',
		'uploadsDir'	=> '',
		'maxSize'		=> 1024, // 1MB Default value.
		'allowedTypes'	=> [],
		'override'		=> false, // override files at destination folder if it's TRUE. 
	];

	public function __construct(array $configs)
	{
		/*
		echo '<pre>';
		print_r($_FILES);
		echo '</pre>';
		*/
		$this->init($configs);
		$this->_handle = $_FILES[$this->_configs['fieldName']];
		$this->_isMultiple = is_array($this->_handle['name']);
		$this->_totalFilesNum = $this->_isMultiple ? count($this->_handle['name']) : 1 ;
	}

	private function init(array &$configs)
	{
		if (!count($configs))
			throw new Exception("Messing necessary configuration!");

		foreach ($this->_configs as $key => $value)
		{
			if (array_key_exists($key, $configs))
			{
				$this->_configs[$key] = $configs[$key];
			}
		}
	}

	public function doUpload()
	{
		if ($this->_isMultiple)
		{
			for ($i = 0; $i < $this->_totalFilesNum; ++$i)
			{
				$file = new File($this->_handle['name'][$i]);
				$file->tmp_name = $this->_handle['tmp_name'][$i];
				$file->size = $this->_handle['size'][$i];
				$file->savePath = $this->_configs['uploadsDir'];
				$file->error = $this->_handle['error'][$i];

				$this->_files[] = $file;
			}
		}
		else
		{
			$file = new File($this->_handle['name']);
			$file->tmp_name = $this->_handle['tmp_name'];
			$file->size = $this->_handle['size'];
			$file->savePath = $this->_configs['uploadsDir'];
			$file->error = $this->_handle['error'];
			
			$this->_files[] = $file;
		}

		// check the allowed extensions
		foreach ($this->_files as $file)
		{
			if (count($this->_configs['allowedTypes']) && !in_array($file->ext, $this->_configs['allowedTypes']))
			{
				throw new Exception("Invalide file extension \"{$file->ext}\".");
				break;
			}
		}

		// upload file.
		foreach ($this->_files as $file)
		{
			if (!$file->doUpload($this->_configs['override']))
			{
				throw new Exception("File \"{$file->name}\" cannot be uploaded");
				return false;
			}
			else
				$this->_info[] = $file->getInfo();
		}

		return true;
	}

	public function getInfo()
	{
		return $this->_info;
	}
}

namespace MR4Web\Utils\Uploader;

class File {
	public $name;
	public $tmp_name;
	public $size;
	public $ext; // extension
	public $error;
	public $savePath;
	private $_fileDestination;

	public function __construct($name)
	{
		$this->name = self::filterName($name);
		$this->ext = end(explode('.', $this->name));
	}

	public static function filterName($str)
	{
		return preg_replace("/[^a-z0-9_\.\-\(\)]+/i", '_', $str);
	}

	public function doUpload($override = false)
	{
		$this->_fileDestination = $this->savePath.$this->name;

		if ($this->error)
			throw new Exception("file \"".$this->name."\" wasn't uploaded properly (Error Number: {$this->error})");

		if (!is_uploaded_file($this->tmp_name))
			return false;

		if ($override || !file_exists($this->_fileDestination))
		{
			return move_uploaded_file($this->tmp_name, $this->_fileDestination);
		}
		else
		{
			$this->_fileDestination = preg_replace("/(\.{$this->ext})+$/i", "", $this->savePath.$this->name).'_'.time().'.'.$this->ext;
			$this->name = basename($this->_fileDestination);
			return move_uploaded_file($this->tmp_name, $this->_fileDestination);
		}
	}

	public function getInfo()
	{
		return [
			'fileName'	=> $this->name,
			'size'		=> $this->size,
			'type'		=> $this->ext,
			'savePath'	=> $this->savePath,
			'path'		=> $this->getfileDestination()
		];
	}

	public function getfileDestination()
	{
		return $this->_fileDestination; 
	}
}

class Exception extends \Exception
{
	public function __construct($message = NULL)
	{
		parent::__construct("Uploader Error: ".$message);
	}
}

?>