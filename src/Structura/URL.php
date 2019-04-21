<?php
namespace Structura;


use Objection\LiteObject;
use Objection\LiteSetup;
use Structura\Exceptions\URLException;


/**
 * @property string|null	$Scheme
 * @property string|null	$Host
 * @property int|null		$Port
 * @property string|null	$User
 * @property string|null	$Pass
 * @property string|null	$Path
 * @property array|null		$Query
 * @property string|null	$Fragment
 */
class URL extends LiteObject
{
	public const DEFAULT_PORTS = [
		'http' 	=> 80,
		'https' => 443
	];
	
	
	private function assembleQueryString(array $query): string 
	{
		$params = [];
		
		foreach ($query as $key => $value)
		{
			if (is_array($value))
			{
				foreach ($value as $item)
				{
					$params[] = Strings::endWith($key, '[]') . "=$item";
				}
			}
			else
				$params[] = "$key=$value";
		}
		
		return implode('&', $params);
	}
	
	private function shouldUsePort(): bool 
	{
		return !($this->Scheme && (self::DEFAULT_PORTS[$this->Scheme] ?? -1) == $this->Port);
	}
	
	
	/**
	 * @return array
	 */
	protected function _setup()
	{
		return [
			'Scheme'	=> LiteSetup::createString(null),
			'Host'		=> LiteSetup::createString(null),
			'Port'		=> LiteSetup::createInt(null),
			'User'		=> LiteSetup::createString(null),
			'Pass'		=> LiteSetup::createString(null),
			'Path'		=> LiteSetup::createString(null),
			'Query'		=> LiteSetup::createArray(null),
			'Fragment'	=> LiteSetup::createString(null)
		];
	}
	
	
	public function __construct(?string $url = null)
	{
		parent::__construct();
		
		if ($url)
			$this->setUrl($url);
	}
	
	public function __toString()
	{
		return $this->url();
	}
	
	public function __set($name, $value)
	{
		if ($name == 'Port')
		{
			if ($value < 0 || $value > 65535)
				throw new URLException('Port is not in valid range. Got: ' . (int)$value);
		}
		
		parent::__set($name, $value);
	}
	
	
	public function setQueryParams(array $params): void
	{
		$this->Query = $params;
	}
	
	public function addQueryParams(array $params): void
	{
		$this->Query = array_merge($this->Query, $params);
	}
	
	public function addQueryParam(string $key, string $value): void
	{
		$this->Query[$key] = $value;
	}
	
	public function url(): string 
	{
		$result = [];
		
		if ($this->Scheme) 
		{
			$result[] = $this->Scheme;
			$result[] = '://';
		}
		
		if ($this->User && $this->Pass)
		{
			$result[] = $this->User;
			$result[] = ':';
			$result[] = $this->Pass;
			$result[] = '@';
		}
		else if ($this->User)
		{
			$result[] = $this->User;
			$result[] = '@';
		}
		
		if ($this->Host)
			$result[] = $this->Host;
		
		if ($this->Port && $this->shouldUsePort())
		{
			$result[] = ':';
			$result[] = $this->Port;
		}
			
		if ($this->Path)
			$result[] = Strings::startWith($this->Path, '/');
		
		if ($this->Query)
		{
			$result[] = '?';
			$result[] = $this->assembleQueryString($this->Query);
		}
		
		if ($this->Fragment)
		{
			$result[] = '#';
			$result[] = $this->Fragment;
		}
		
		return implode('', $result);
	}
	
	public function setUrl(string $url): void
	{
		$parsedUrl = parse_url($url);
		
		$this->Scheme 	= $parsedUrl['scheme'] ?? null;
		$this->Host 	= $parsedUrl['host'] ?? null;
		$this->Port 	= $parsedUrl['port'] ?? null;
		$this->User 	= isset($parsedUrl['user']) && $parsedUrl['user'] ? $parsedUrl['user'] : null;
		$this->Pass 	= $parsedUrl['pass'] ?? null;
		$this->Path 	= $parsedUrl['path'] ?? null;
		
		$query = $parsedUrl['query'] ?? null;
		
		if ($query)
		{
			parse_str($query, $result);
			$this->Query = $result;
		}
		
		$this->Fragment = $parsedUrl['fragment'] ?? null;
	}
}