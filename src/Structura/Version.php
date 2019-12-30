<?php
namespace Structura;


class Version
{
	private $major	= 0;
	private $minor	= 0;
	private $build	= 0;
	private $patch	= 0;
	private $flag	= null;
	
	
	public function __construct($version = '')
	{
		if ($version instanceof Version)
		{
			$this->major = $version->major;
			$this->minor = $version->minor;
			$this->build = $version->build;
			$this->patch = $version->patch;
			$this->flag = $version->flag;
		}
		else
		{
			$this->fromString($version);
		}
	}
	
	public function __toString()
	{
		return $this->format();
	}
	
	
	public function setMajor(int $major): void
	{
		$this->major = $major;
	}
	
	public function setMinor(int $minor): void
	{
		$this->minor = $minor;
	}
	
	public function setBuild(int $build): void
	{
		$this->build = $build;
	}
	
	public function setPatch(int $patch): void
	{
		$this->patch = $patch;
	}
	
	public function setFlag(string $flag): void
	{
		$this->flag = $flag;
	}
	
	
	public function getMajor(): int
	{
		return $this->major;
	}
	
	public function getMinor(): int
	{
		return $this->minor;
	}
	
	public function getBuild(): int
	{
		return $this->build;
	}
	
	public function getPatch(): int
	{
		return $this->patch;
	}
	
	public function getFlag(): ?string
	{
		return $this->flag;
	}
	
	
	public function isSame(Version $to): bool
	{
		return 
			$this->major == $to->major && 
			$this->minor == $to->minor && 
			$this->build == $to->build && 
			$this->patch == $to->patch; 
	}
	
	public function isLower(Version $to): bool
	{
		if ($this->major < $to->major)
			return true;
		else if ($this->major > $to->major)
			return false;
		
		if ($this->minor < $to->minor)
			return true;
		else if ($this->minor > $to->minor)
			return false;
		
		if ($this->build < $to->build)
			return true;
		else if ($this->build > $to->build)
			return false;
		
		if ($this->patch < $to->patch)
			return true;
		else if ($this->patch > $to->patch)
			return false;
		
		return false;
	}
	
	public function isHigher(Version $to): bool
	{
		return 
			!$this->isSame($to) &&
			!$this->isLower($to);
	}
	
	
	public function format(string $format = 'M.m.b.p'): string
	{
		$result = $format;
		
		$result = Strings::replace($result, 'M', $this->major);
		$result = Strings::replace($result, 'm', $this->minor ?? 0);
		$result = Strings::replace($result, 'b', $this->build ?? 0);
		$result = Strings::replace($result, 'p', $this->patch ?? 0);
		
		return $result;
	}
	
	public function fromString(string $value): void
	{
		$result = explode('.', $value);
		
		$this->major = (int)($result[0] ?? 0);
		$this->minor = (int)($result[1] ?? 0);
		$this->build = (int)($result[2] ?? 0);
		$this->patch = (int)($result[3] ?? 0);
	}
	
	public function toString(): string
	{
		return $this->__toString();
	}
	
	public function toArray(): array
	{
		return [
			$this->major,	
			$this->minor ?? 0,
			$this->build ?? 0,
			$this->patch ?? 0,
		];
	}
	
	/**
	 * Equivalent to $this <=> $to 
	 * @param Version $to
	 * @return int
	 */
	public function compare(Version $to): int
	{
		if ($this->isSame($to))
		{
			return 0;
		}
		else if ($this->isLower($to))
		{
			return -1;
		}
		else
		{
			return 1;
		}
	}
}