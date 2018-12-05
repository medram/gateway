<?php

/**
* 	@author: Mohammed Ramouchy (MR4Web)
*	@copyright: 2018 MR4Web
* 	@start: 30/11/2018
* 	@end: 01/12/2018
* 	@Description: streaming big files via HTTP protocol easily
*	@link: http://www.mr4web.com
*	@version: 1.0
*/

namespace MR4Web\Utils;

class FileStream
{
	private $_path;
	private $_name;
	private $_filesize;
	private $_stream;
	private $_start;
	private $_end;
	private $_config = [
		'bufferSize' 	=> 50*1024, // 500KB
		'chunked'		=> true,	// resume download
		'sleep'			=> 200, 	// 200ms
	];
	private $_mimeTypes = array(
		'ai'      => 'application/postscript',
		'aif'     => 'audio/x-aiff',
		'aifc'    => 'audio/x-aiff',
		'aiff'    => 'audio/x-aiff',
		'asc'     => 'text/plain',
		'atom'    => 'application/atom+xml',
		'atom'    => 'application/atom+xml',
		'au'      => 'audio/basic',
		'avi'     => 'video/x-msvideo',
		'bcpio'   => 'application/x-bcpio',
		'bin'     => 'application/octet-stream',
		'bmp'     => 'image/bmp',
		'cdf'     => 'application/x-netcdf',
		'cgm'     => 'image/cgm',
		'class'   => 'application/octet-stream',
		'cpio'    => 'application/x-cpio',
		'cpt'     => 'application/mac-compactpro',
		'csh'     => 'application/x-csh',
		'css'     => 'text/css',
		'csv'     => 'text/csv',
		'dcr'     => 'application/x-director',
		'dir'     => 'application/x-director',
		'djv'     => 'image/vnd.djvu',
		'djvu'    => 'image/vnd.djvu',
		'dll'     => 'application/octet-stream',
		'dmg'     => 'application/octet-stream',
		'dms'     => 'application/octet-stream',
		'doc'     => 'application/msword',
		'dtd'     => 'application/xml-dtd',
		'dvi'     => 'application/x-dvi',
		'dxr'     => 'application/x-director',
		'eps'     => 'application/postscript',
		'etx'     => 'text/x-setext',
		'exe'     => 'application/octet-stream',
		'ez'      => 'application/andrew-inset',
		'gif'     => 'image/gif',
		'gram'    => 'application/srgs',
		'grxml'   => 'application/srgs+xml',
		'gtar'    => 'application/x-gtar',
		'hdf'     => 'application/x-hdf',
		'hqx'     => 'application/mac-binhex40',
		'htm'     => 'text/html',
		'html'    => 'text/html',
		'ice'     => 'x-conference/x-cooltalk',
		'ico'     => 'image/x-icon',
		'ics'     => 'text/calendar',
		'ief'     => 'image/ief',
		'ifb'     => 'text/calendar',
		'iges'    => 'model/iges',
		'igs'     => 'model/iges',
		'jpe'     => 'image/jpeg',
		'jpeg'    => 'image/jpeg',
		'jpg'     => 'image/jpeg',
		'js'      => 'application/x-javascript',
		'json'    => 'application/json',
		'kar'     => 'audio/midi',
		'latex'   => 'application/x-latex',
		'lha'     => 'application/octet-stream',
		'lzh'     => 'application/octet-stream',
		'm3u'     => 'audio/x-mpegurl',
		'man'     => 'application/x-troff-man',
		'mathml'  => 'application/mathml+xml',
		'me'      => 'application/x-troff-me',
		'mesh'    => 'model/mesh',
		'mid'     => 'audio/midi',
		'midi'    => 'audio/midi',
		'mif'     => 'application/vnd.mif',
		'mov'     => 'video/quicktime',
		'movie'   => 'video/x-sgi-movie',
		'mp2'     => 'audio/mpeg',
		'mp3'     => 'audio/mpeg',
		'mpe'     => 'video/mpeg',
		'mpeg'    => 'video/mpeg',
		'mpg'     => 'video/mpeg',
		'mpga'    => 'audio/mpeg',
		'ms'      => 'application/x-troff-ms',
		'msh'     => 'model/mesh',
		'mxu'     => 'video/vnd.mpegurl',
		'nc'      => 'application/x-netcdf',
		'oda'     => 'application/oda',
		'ogg'     => 'application/ogg',
		'pbm'     => 'image/x-portable-bitmap',
		'pdb'     => 'chemical/x-pdb',
		'pdf'     => 'application/pdf',
		'pgm'     => 'image/x-portable-graymap',
		'pgn'     => 'application/x-chess-pgn',
		'png'     => 'image/png',
		'pnm'     => 'image/x-portable-anymap',
		'ppm'     => 'image/x-portable-pixmap',
		'ppt'     => 'application/vnd.ms-powerpoint',
		'ps'      => 'application/postscript',
		'qt'      => 'video/quicktime',
		'ra'      => 'audio/x-pn-realaudio',
		'ram'     => 'audio/x-pn-realaudio',
		'ras'     => 'image/x-cmu-raster',
		'rdf'     => 'application/rdf+xml',
		'rgb'     => 'image/x-rgb',
		'rm'      => 'application/vnd.rn-realmedia',
		'roff'    => 'application/x-troff',
		'rss'     => 'application/rss+xml',
		'rtf'     => 'text/rtf',
		'rtx'     => 'text/richtext',
		'sgm'     => 'text/sgml',
		'sgml'    => 'text/sgml',
		'sh'      => 'application/x-sh',
		'shar'    => 'application/x-shar',
		'silo'    => 'model/mesh',
		'sit'     => 'application/x-stuffit',
		'skd'     => 'application/x-koan',
		'skm'     => 'application/x-koan',
		'skp'     => 'application/x-koan',
		'skt'     => 'application/x-koan',
		'smi'     => 'application/smil',
		'smil'    => 'application/smil',
		'snd'     => 'audio/basic',
		'so'      => 'application/octet-stream',
		'spl'     => 'application/x-futuresplash',
		'src'     => 'application/x-wais-source',
		'sv4cpio' => 'application/x-sv4cpio',
		'sv4crc'  => 'application/x-sv4crc',
		'svg'     => 'image/svg+xml',
		'svgz'    => 'image/svg+xml',
		'swf'     => 'application/x-shockwave-flash',
		't'       => 'application/x-troff',
		'tar'     => 'application/x-tar',
		'tcl'     => 'application/x-tcl',
		'tex'     => 'application/x-tex',
		'texi'    => 'application/x-texinfo',
		'texinfo' => 'application/x-texinfo',
		'tif'     => 'image/tiff',
		'tiff'    => 'image/tiff',
		'tr'      => 'application/x-troff',
		'tsv'     => 'text/tab-separated-values',
		'txt'     => 'text/plain',
		'ustar'   => 'application/x-ustar',
		'vcd'     => 'application/x-cdlink',
		'vrml'    => 'model/vrml',
		'vxml'    => 'application/voicexml+xml',
		'wav'     => 'audio/x-wav',
		'wbmp'    => 'image/vnd.wap.wbmp',
		'wbxml'   => 'application/vnd.wap.wbxml',
		'wml'     => 'text/vnd.wap.wml',
		'wmlc'    => 'application/vnd.wap.wmlc',
		'wmls'    => 'text/vnd.wap.wmlscript',
		'wmlsc'   => 'application/vnd.wap.wmlscriptc',
		'wrl'     => 'model/vrml',
		'xbm'     => 'image/x-xbitmap',
		'xht'     => 'application/xhtml+xml',
		'xhtml'   => 'application/xhtml+xml',
		'xls'     => 'application/vnd.ms-excel',
		'xml'     => 'application/xml',
		'xpm'     => 'image/x-xpixmap',
		'xsl'     => 'application/xml',
		'xslt'    => 'application/xslt+xml',
		'xul'     => 'application/vnd.mozilla.xul+xml',
		'xwd'     => 'image/x-xwindowdump',
		'xyz'     => 'chemical/x-xyz',
		'zip'     => 'application/zip'
	);

	public function __construct($pathName, array $config = [])
	{
		$this->_init($config);
		$this->_path = $pathName;
		$this->_start = -1;
		$this->_end = -1;
	}

	private function _init(array &$config)
	{
		foreach ($this->_config as $key => $value)
		{
			if (array_key_exists($key, $config) && $config[$key] != '')
			{
				$this->_config[$key] = $config[$key];
			}
		}
	}

	private function open()
	{
		if (!file_exists($this->_path))
		{
			//die('File Not Found');
			header('HTTP/1.1 404 Not Found');
			exit;
		}

		if (!($this->_stream = fopen($this->_path, 'rb')))
		{
			//die('Could not open stream for reading');
			header("HTTP/1.1 500 Internal Server Error");
			exit;
		}

		$this->_name = basename($this->_path);
		$this->_filesize = filesize($this->_path);
	}

	private function setHeader()
	{
		$this->_start = 0;
		$this->_end = $this->_filesize-1;
		
		// set header here
		header('Content-Disposition: attachment; filename="'.urlencode($this->_name).'"');
		header('Content-Type: '.$this->getContentType());
		//header('Content-Type: application/force-download');

		if ($this->_config['chunked'])
			header("Accept-Ranges: bytes");
		else
			header('Accept-Ranges: none');
		
		// To don't use the cache
		//header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' ); 
		header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' . filemtime($this->_path)) . ' GMT' ); 
		header( 'Cache-Control: no-store, no-cache, must-revalidate' );
		header( 'Cache-Control: post-check=0, pre-check=0', false ); 
		header( 'Pragma: no-cache' );

		if (isset($_SERVER['HTTP_RANGE']) && $this->_config['chunked'])
		{
			$rangeUnit = '';
			$rangeValue = '';
			$range = '';
			$extraRange = '';
			
			@list($rangeUnit, $rangeValue) = explode('=', $_SERVER['HTTP_RANGE'], 2);
			
			if (strtolower($rangeUnit) == 'bytes')
			{
				@list($range, $extraRange) = explode(',', $rangeValue, 2);
				@list($seekStart, $seekEnd) = explode('-', $range, 2);
				
				// correction the range.
				$seekEnd = empty($seekEnd)? $this->_filesize-1 : min(abs(intval($seekEnd)), $this->_filesize-1);
				$seekStart = empty($seekStart) || $seekStart > $seekEnd ? 0 : max(abs(intval($seekStart)), 0);

				if (($seekStart < $seekEnd && $seekStart < $this->_filesize) && $seekEnd < $this->_filesize)
				{
					$this->_start = $seekStart;
					$this->_end = $seekEnd;

					header('HTTP/1.1 206 Partial Content');
					header("Content-Range: bytes {$this->_start}-{$this->_end}/{$this->_filesize}");
					header("Content-Length: ".($this->_end-$this->_start+1));	
				}
				else
				{
					header('HTTP/1.1 416 Requested Range Not Satisfiable');
					header("Content-Range: {$this->_start}-{$this->_end}/{$this->_filesize}");
					exit;
				}
			}
			else
			{
				header('HTTP/1.1 416 Requested Range Not Satisfiable');
				header("Content-Range: {$this->_start}-{$this->_end}/{$this->_filesize}");
				exit;
			}
		}
		else
		{
			header("Content-Length: {$this->_filesize}");
			header('Etag: "'.md5_file($this->_path).'"');
		}
	}

	private function stream()
	{
		@set_time_limit(0);
		//@ini_set('memory_limit', '512M');

		fseek($this->_stream, $this->_start);

		$offset = $this->_start;
		$bytesToRead = $this->_config['bufferSize'];
		while (!feof($this->_stream) && $offset <= $this->_end)
		{
			// we added +1 to get the last tirm.
			if ($offset + $bytesToRead > $this->_end)
				$bytesToRead = $this->_end - $offset + 1;

			echo fread($this->_stream, $bytesToRead);
			ob_flush();
			flush();
			$offset += $bytesToRead;
			usleep($this->_config['sleep']*1000);
		}
		//logFile("offset=".$offset."|start=".$this->_start."|end=".$this->_end);
	}

	public function start()
	{
		$this->open();
		$this->setHeader();
		$this->stream();
		$this->end();
	}	

	private function end()
	{
		@fclose($this->_stream);
		exit;
	}

	private function getContentType()
	{
		$ext = strtolower(end(explode('.', $this->_name)));
		
		if (array_key_exists($ext, $this->_mimeTypes))
			return $this->_mimeTypes[$ext];
		else
			return 'application/octet-stream';
	}
}

?>