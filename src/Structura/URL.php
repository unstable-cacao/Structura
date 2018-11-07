<?php
namespace Structura;


use Objection\Exceptions\LiteObjectException;
use Objection\LiteObject;
use Objection\LiteSetup;


/**
 * @property string	$Scheme
 * @property string	$Host
 * @property int	$Port
 * @property string	$User
 * @property string	$Pass
 * @property string	$Path
 * @property array	$Query
 * @property string	$Fragment
 */
class URL extends LiteObject
{
	public const DEFAULT_PORTS = [
		'http' 	=> 80,
		'https' => 443
	];
	
	
	private function parseQueryString(string $query): array 
	{
		$paramPairs = explode('&', $query);
		$result = [];
		
		foreach ($paramPairs as $paramPair)
		{
			$parts = explode('=', $paramPair);
			
			if (Strings::isEndsWith($parts[0], '[]'))
				$result[$parts[0]][] = $parts[1] ?? '';
			else
				$result[$parts[0]] = $parts[1] ?? '';
		}
		
		return $result;
	}
	
	private function assembleQueryString(): string 
	{
		$params = [];
		
		foreach ($this->Query as $key => $value)
		{
			if (is_array($value))
			{
				foreach ($value as $item)
				{
					$params[] = "$key=$item";
				}
			}
			else
				$params[] = "$key=$value";
		}
		
		return implode('&', $params);
	}
	
	private function shouldUsePort(): bool 
	{
		return !($this->Scheme && 
			isset(self::DEFAULT_PORTS[$this->Scheme]) && 
			self::DEFAULT_PORTS[$this->Scheme] == $this->Port);
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
				throw new LiteObjectException('Port is not in valid range');
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
			$result[] = $this->assembleQueryString();
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
		$this->Scheme 	= parse_url($url, PHP_URL_SCHEME);
		$this->Host 	= parse_url($url, PHP_URL_HOST);
		$this->Port 	= parse_url($url, PHP_URL_PORT);
		$this->User 	= parse_url($url, PHP_URL_USER) ?: null;
		$this->Pass 	= parse_url($url, PHP_URL_PASS);
		$this->Path 	= parse_url($url, PHP_URL_PATH);
		
		$query = parse_url($url, PHP_URL_QUERY);
		
		if ($query)
			$this->Query = $this->parseQueryString($query);
		
		$this->Fragment = parse_url($url, PHP_URL_FRAGMENT);
	}
}