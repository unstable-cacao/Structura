<?php
namespace Structura;


use PHPUnit\Framework\TestCase;


class TimeTest extends TestCase
{
	private function generateTimeValues(callable $callback, &$result): string
	{
		$before = date('Y-m-d H:i:s');
		$result = $callback();
		$after = date('Y-m-d H:i:s');
		
		if ($after != $before)
		{
			return $this->generateTimeValues($callback, $result);
		}
		
		return $before;
	}
	
	
	public function test_now()
	{
		$actualTime = $this->generateTimeValues(function()
			{
				return Time::now();
			},
			$result);
		
		self::assertEquals($actualTime, $result);
	}
	
	
	public function test_get_noParamPassed()
	{
		$actualTime = $this->generateTimeValues(function()
			{
				return Time::get();
			},
			$result);
		
		self::assertEquals($actualTime, $result);
	}
	
	public function test_get_PassInteger_TreatAsUnixTime()
	{
		$actualTime = $this->generateTimeValues(function()
			{
				return Time::get(time() - 60);
			},
			$result);
		
		self::assertEquals(strtotime("$actualTime -60 seconds"), strtotime($result));
	}
	
	public function test_get_PassString_TreatAsExpression()
	{
		$actualTime = $this->generateTimeValues(function()
			{
				return Time::get('-2 hour');
			},
			$result);
		
		self::assertEquals(strtotime("$actualTime -2 hour"), strtotime($result));
	}
	
	public function test_get_PassDateTimeObject_UseObjectsValue()
	{
		$actualTime = $this->generateTimeValues(function()
			{
				return Time::get(new \DateTime('+3 minutes'));
			},
			$result);
		
		self::assertEquals(strtotime("$actualTime +3 minutes"), strtotime($result));
	}
}