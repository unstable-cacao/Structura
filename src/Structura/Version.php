<?php
namespace Structura;


class Version
{
	private $major	= 0;
	private $minor	= 0;
	private $build	= 0;
	private $patch	= 0;
	private $flag	= null;
	
	
	public function __construct(string $version)
	{
		$this->fromString($version);
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
	
	public function setFlag(int $flag): void
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
			$this->minor === $to->minor && 
			$this->build === $to->build && 
			$this->patch === $to->patch && 
			$this->flag === $to->flag; 
	}
	
	public function isLower(Version $to): bool
	{
		return 
			$this->major < $to->major || 
			$this->minor < $to->minor || 
			$this->build < $to->build || 
			$this->patch < $to->patch;
	}
	
	public function isHigher(Version $to): bool
	{
		return 
			$this->major > $to->major || 
			$this->minor > $to->minor || 
			$this->build > $to->build || 
			$this->patch > $to->patch;
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
	
	public function __toString()
	{
		return $this->format();
	}
	
	public function fromString(string $value): void
	{
		$result = explode('.', $value);
		
		$this->major = $result[0] ?? 0;
		$this->minor = $result[1] ?? 0;
		$this->build = $result[2] ?? 0;
		$this->patch = $result[3] ?? 0;
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
}