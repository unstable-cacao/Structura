<?php
namespace Structura;


use PHPUnit\Framework\TestCase;


class TimeTest extends TestCase
{
	private const WEEKS_TEST = [
		// [ expected week, given date ]
		[52, '2000-01-01'],
		[1, '2000-01-02'],
		[1, '2000-01-03'],
		[1, '2000-01-07'],
		[1, '2000-01-08'],
		[5, '2000-01-31'],
		[31, '2000-08-01'],
		[34, '2000-08-22'],
		[1, '2000-12-31'],
		
		[1, '2001-01-01'],
		[1, '2001-01-02'],
		[2, '2001-01-08'],
		[3, '2001-01-14'],
		[52, '2001-12-29'],
		[1, '2001-12-30'],
		[1, '2001-12-31'],
		
		[1, '2002-01-01'],
		[1, '2002-01-02'],
		[2, '2002-01-07'],
		[3, '2002-01-13'],
		[3, '2002-01-13'],
		[52, '2002-12-28'],
		[1, '2002-12-29'],
		[1, '2002-12-31'],
		
		[1, '2003-01-01'],
		[1, '2003-01-02'],
		[2, '2003-01-06'],
		[3, '2003-01-12'],
		[53, '2003-12-28'],
		[53, '2003-12-31'],
		
		[53, '2004-01-01'],
		[53, '2004-01-02'],
		[1, '2004-01-04'],
		[2, '2004-01-12'],
		[3, '2004-01-18'],
		[52, '2004-12-26'],
		[52, '2004-12-31'],
		
		[52, '2005-01-01'],
		[1, '2005-01-02'],
		[2, '2005-01-09'],
		[3, '2005-01-17'],
		[52, '2005-12-31'],
		
		[1, '2006-01-01'],
		[1, '2006-01-02'],
		[2, '2006-01-12'],
		[3, '2006-01-18'],
		[52, '2006-12-30'],
		[1, '2006-12-31'],
		
		[53, '2009-01-01'],
		[53, '2009-01-03'],
		[1, '2009-01-04'],
		[1, '2009-01-05'],
		[2, '2009-01-13'],
		[52, '2009-12-27'],
		[52, '2009-12-31'],
		
		[52, '2010-01-01'],
		[52, '2010-01-02'],
		[1, '2010-01-04'],
		[2, '2010-01-11'],
		[52, '2010-12-27'],
		[52, '2010-12-31']
	];
	
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
	
	public function test_get_FormatNotDefault()
	{
		self::assertEquals('2010-01-01', Time::get('2010-01-01 05:55:01', 'Y-m-d'));
	}
	
	public function test_weekOfYear_MondayBased()
	{
		self::assertEquals(1, Time::weekOfYear('2022-01-03'));
		self::assertEquals(2, Time::weekOfYear('2022-01-16'));
		self::assertEquals(51, Time::weekOfYear('2021-12-22'));
		self::assertEquals(52, Time::weekOfYear('2022-01-01'));
		self::assertEquals(53, Time::weekOfYear('2021-01-01'));
	}
	
	public function test_weekOfYear_SundayFirst()
	{
		self::assertEquals(1, Time::weekOfYear('2006-01-01', true));
	}
	
	public function test_weekOfYear_MondayFirst()
	{
		self::assertEquals(1, Time::weekOfYear('2001-01-01', true));
	}
	
	public function test_weekOfYear_TuesdayFirst()
	{
		self::assertEquals(1, Time::weekOfYear('2002-01-01', true));
	}
	
	public function test_weekOfYear_WednesdayFirst()
	{
		self::assertEquals(1, Time::weekOfYear('2003-01-01', true));
	}
	
	public function test_weekOfYear_ThursdayFirst()
	{
		self::assertEquals(53, Time::weekOfYear('2009-01-01', true));
	}
	
	public function test_weekOfYear_FridayFirst()
	{
		self::assertEquals(52, Time::weekOfYear('2010-01-01', true));
	}
	
	public function test_weekOfYear_SaturdayFirst()
	{
		self::assertEquals(52, Time::weekOfYear('2005-01-01', true));
	}
	
	public function test_weekOfYear()
	{
		foreach (self::WEEKS_TEST as $item)
		{
			self::assertEquals($item[0], Time::weekOfYear($item[1], true), "Failed asserting that week {$item[0]} is for {$item['1']}");
		}
	}
}