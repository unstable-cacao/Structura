<?php
namespace Structura;


use PHPUnit\Framework\TestCase;


class URLTest extends TestCase
{
	public function test()
	{
		self::assertEquals('ftp://test:pass@hello.world.com:890/hi.php?a=3&b[]=1#abcdef', (string)(new URL('ftp://test:pass@hello.world.com:890/hi.php?a=3&b[]=1#abcdef')));
	}
	
	public function test_construct_UrlEmpty_ObjectPropertiesNotSet()
	{
		$subject = new URL('');
		
		self::assertNull($subject->Scheme);
		self::assertNull($subject->Host);
		self::assertNull($subject->Port);
		self::assertNull($subject->User);
		self::assertNull($subject->Pass);
		self::assertNull($subject->Path);
		self::assertNull($subject->Query);
		self::assertNull($subject->Fragment);
	}
	
	public function test_construct_UrlNull_ObjectPropertiesNotSet()
	{
		$subject = new URL();
		
		self::assertNull($subject->Scheme);
		self::assertNull($subject->Host);
		self::assertNull($subject->Port);
		self::assertNull($subject->User);
		self::assertNull($subject->Pass);
		self::assertNull($subject->Path);
		self::assertNull($subject->Query);
		self::assertNull($subject->Fragment);
	}
	
	public function test_construct_UrlSet_ObjectPropertiesSet()
	{
		$subject = new URL('ftp://test:pass@hello.world.com:890/hi.php?a=3#abcdef');
		
		self::assertEquals('ftp', $subject->Scheme);
		self::assertEquals('hello.world.com', $subject->Host);
		self::assertEquals(890, $subject->Port);
		self::assertEquals('test', $subject->User);
		self::assertEquals('pass', $subject->Pass);
		self::assertEquals('/hi.php', $subject->Path);
		self::assertEquals(['a' => '3'], $subject->Query);
		self::assertEquals('abcdef', $subject->Fragment);
	}
	
	
	/**
	 * @expectedException \Structura\Exceptions\InvalidURLException
	 */
	public function test_setUrl_ThrowExceptionForInvalidURL_ExceptionThrown()
	{
		$subject = new URL();
		$subject->setUrl('http://', true);
	}
	
	public function test_setUrl_ReturnFalseOnInvalidURL_FalseReturned()
	{
		$subject = new URL();
		self::assertFalse($subject->setUrl('http://', false));
	}
	
	public function test_setUrl_ValidURLReturnsTrue()
	{
		$subject = new URL();
		self::assertTrue($subject->setUrl('http://unstable-cacao.com'));
	}
	
	public function test_setUrl_InvalidURLPassed_NoParamsSet()
	{
		$subject = new URL();
		$subject->setUrl('http://');
		
		self::assertEmpty(array_filter($subject->toArray()));
	}
	
	public function test_setUrl_SchemaSet_SchemaPropertySet()
	{
		$subject = new URL();
		$subject->setUrl('https://test:pass@hello.world.com:890/hi.php?a=3#abcdef');
		
		self::assertEquals('https', $subject->Scheme);
	}
	
	public function test_setUrl_HostNotSet_SetNull()
	{
		$subject = new URL();
		$subject->setUrl('/hi.php?a=3#abcdef');
		
		self::assertNull($subject->Host);
	}
	
	public function test_setUrl_HostIP_HostPropertySet()
	{
		$subject = new URL();
		$subject->setUrl('http://22.11.101.3:890/hi.php?a=3#abcdef');
		
		self::assertEquals('22.11.101.3', $subject->Host);
	}
	
	public function test_setUrl_HostSet_HostPropertySet()
	{
		$subject = new URL();
		$subject->setUrl('http://hello.world.com:890/hi.php?a=3#abcdef');
		
		self::assertEquals('hello.world.com', $subject->Host);
	}
	
	public function test_setUrl_PortNotSet_SetNull()
	{
		$subject = new URL();
		$subject->setUrl('http://hello.world.com/hi.php?a=3#abcdef');
		
		self::assertNull($subject->Port);
	}
	
	/**
	 * @expectedException \Structura\Exceptions\URLException
	 */
	public function test_setUrl_PortNotValid_ExceptionThrown()
	{
		$subject = new URL();
		$subject->Port = 65536;
	}
	
	public function test_setUrl_PortSet_PortPropertySet()
	{
		$subject = new URL();
		$subject->setUrl('http://hello.world.com:80/hi.php?a=3#abcdef');
		
		self::assertEquals(80, $subject->Port);
	}
	
	public function test_setUrl_UserNotSet_SetNull()
	{
		$subject = new URL();
		$subject->setUrl('http://:pass@hello.world.com:890/hi.php?a=3#abcdef');
		
		self::assertNull($subject->User);
	}
	
	public function test_setUrl_PassNotSet_SetNull()
	{
		$subject = new URL();
		$subject->setUrl('http://test@hello.world.com:890/hi.php?a=3#abcdef');
		
		self::assertNull($subject->Pass);
	}
	
	public function test_setUrl_PassAndUserSet_PropertiesSet()
	{
		$subject = new URL();
		$subject->setUrl('http://test:pass@hello.world.com:890/hi.php?a=3#abcdef');
		
		self::assertEquals('test', $subject->User);
		self::assertEquals('pass', $subject->Pass);
	}
	
	public function test_setUrl_PathNotSet_SetNull()
	{
		$subject = new URL();
		$subject->setUrl('http://hello.world.com?a=3#abcdef');
		
		self::assertNull($subject->Path);
	}
	
	public function test_setUrl_PathFile_PathPropertySet()
	{
		$subject = new URL();
		$subject->setUrl('http://hello.world.com/hi.html?a=3#abcdef');
		
		self::assertEquals('/hi.html', $subject->Path);
	}
	
	public function test_setUrl_PathRegular_PathPropertySet()
	{
		$subject = new URL();
		$subject->setUrl('http://test:pass@hello.world.com/hi/hello/hi?a=3#abcdef');
		
		self::assertEquals('/hi/hello/hi', $subject->Path);
	}
	
	public function test_setUrl_QueryNotSet_SetNull()
	{
		$subject = new URL();
		$subject->setUrl('http://hello.world.com/hi#abcdef');
		
		self::assertNull($subject->Query);
	}
	
	public function test_setUrl_QueryHasArrayParams_ParamsNotOverridden()
	{
		$subject = new URL();
		$subject->setUrl('http://hello.world.com/hi.php?a[]=3&a[]=4#abcdef');
		
		self::assertEquals(['a' => ['3', '4']], $subject->Query);
	}
	
	public function test_setUrl_QuerySet_QueryPropertySet()
	{
		$subject = new URL();
		$subject->setUrl('http://hello.world.com/hi.php?a=3&b=4&c=hello#abcdef');
		
		self::assertEquals(['a' => '3', 'b' => '4', 'c' => 'hello'], $subject->Query);
	}
	
	public function test_setUrl_FragmentNotSet_SetNull()
	{
		$subject = new URL();
		$subject->setUrl('http://hello.world.com/hi.php?a=3');
		
		self::assertNull($subject->Fragment);
	}
	
	public function test_setUrl_FragmentSet_FragmentPropertySet()
	{
		$subject = new URL();
		$subject->setUrl('http://hello.world.com/hi.php?a=3#menu');
		
		self::assertEquals('menu', $subject->Fragment);
	}
	
	public function test_setUrl_NoHostAndPath_SetPath()
	{
		$subject = new URL();
		$subject->setUrl('/oktopost.com/home');
		
		self::assertEquals('oktopost.com/home', $subject->Path);
		self::assertNull($subject->Host);
	}
	
	public function test_setUrl_PathOrHostNotSet()
	{
		$subject = new URL();
		$subject->setUrl('http:');
		
		self::assertNull($subject->Path);
		self::assertNull($subject->Host);
		self::assertEquals('http', $subject->Scheme);
	}
	
	public function test_setUrl_Only2DotsPresent_NothingSet()
	{
		$subject = new URL();
		$subject->setUrl(':');
		
		self::assertNull($subject->Path);
		self::assertNull($subject->Host);
		self::assertNull($subject->Scheme);
	}
	
	public function test_setUrl_NoHostAndHostInPath_SetHost()
	{
		$subject = new URL();
		$subject->setUrl('oktopost.com/home');
		
		self::assertEquals('home', $subject->Path);
		self::assertEquals('oktopost.com', $subject->Host);
	}
	
	public function test_setUrl_NoHostNoSlashes_SetAsHost()
	{
		$subject = new URL();
		$subject->setUrl('oktopost.com');
		
		self::assertNull($subject->Path);
		self::assertEquals('oktopost.com', $subject->Host);
	}
	
	public function test_setUrl_NoHostMultipleSlashes_PathCorrect()
	{
		$subject = new URL();
		$subject->setUrl('oktopost.com/test/home');
		
		self::assertEquals('test/home', $subject->Path);
		self::assertEquals('oktopost.com', $subject->Host);
	}
	
	public function test_url_SchemaNotSet()
	{
		$subject = new URL();
		$subject->User		= 'test';
		$subject->Pass		= 'pass';
		$subject->Host		= 'hello.world.com';
		$subject->Port		= 89;
		$subject->Path		= '/hi.html';
		$subject->Query		= ['a' => 3];
		$subject->Fragment	= 'menu';
		
		self::assertEquals('test:pass@hello.world.com:89/hi.html?a=3#menu', $subject->url());
	}
	
	public function test_url_UserNotSet()
	{
		$subject = new URL();
		$subject->Scheme	= 'http';
		$subject->Pass		= 'pass';
		$subject->Host		= 'hello.world.com';
		$subject->Port		= 89;
		$subject->Path		= '/hi.html';
		$subject->Query		= ['a' => 3];
		$subject->Fragment	= 'menu';
		
		self::assertEquals('http://:pass@hello.world.com:89/hi.html?a=3#menu', $subject->url());
	}
	
	public function test_url_PassNotSet()
	{
		$subject = new URL();
		$subject->Scheme	= 'http';
		$subject->User		= 'test';
		$subject->Host		= 'hello.world.com';
		$subject->Port		= 89;
		$subject->Path		= '/hi.html';
		$subject->Query		= ['a' => 3];
		$subject->Fragment	= 'menu';
		
		self::assertEquals('http://test:@hello.world.com:89/hi.html?a=3#menu', $subject->url());
	}
	
	public function test_url_HostNotSet()
	{
		$subject = new URL();
		$subject->Scheme	= 'http';
		$subject->User		= 'test';
		$subject->Pass		= 'pass';
		$subject->Port		= 89;
		$subject->Path		= '/hi.html';
		$subject->Query		= ['a' => 3];
		$subject->Fragment	= 'menu';
		
		self::assertEquals('http://test:pass@:89/hi.html?a=3#menu', $subject->url());
	}
	
	public function test_url_PortNotSet()
	{
		$subject = new URL();
		$subject->Scheme	= 'http';
		$subject->User		= 'test';
		$subject->Pass		= 'pass';
		$subject->Host		= 'hello.world.com';
		$subject->Path		= '/hi.html';
		$subject->Query		= ['a' => 3];
		$subject->Fragment	= 'menu';
		
		self::assertEquals('http://test:pass@hello.world.com/hi.html?a=3#menu', $subject->url());
	}
	
	public function test_url_PathNotSet()
	{
		$subject = new URL();
		$subject->Scheme	= 'http';
		$subject->User		= 'test';
		$subject->Pass		= 'pass';
		$subject->Host		= 'hello.world.com';
		$subject->Port		= 89;
		$subject->Query		= ['a' => 3];
		$subject->Fragment	= 'menu';
		
		self::assertEquals('http://test:pass@hello.world.com:89?a=3#menu', $subject->url());
	}
	
	public function test_url_PathStartsWithSlash()
	{
		$subject = new URL();
		$subject->Scheme	= 'http';
		$subject->User		= 'test';
		$subject->Pass		= 'pass';
		$subject->Host		= 'hello.world.com';
		$subject->Port		= 89;
		$subject->Path		= '/hi.html';
		$subject->Query		= ['a' => 3];
		$subject->Fragment	= 'menu';
		
		self::assertEquals('http://test:pass@hello.world.com:89/hi.html?a=3#menu', $subject->url());
	}
	
	public function test_url_PathNotStartsWithSlash()
	{
		$subject = new URL();
		$subject->Scheme	= 'http';
		$subject->User		= 'test';
		$subject->Pass		= 'pass';
		$subject->Host		= 'hello.world.com';
		$subject->Port		= 89;
		$subject->Path		= 'hi.html';
		$subject->Query		= ['a' => 3];
		$subject->Fragment	= 'menu';
		
		self::assertEquals('http://test:pass@hello.world.com:89/hi.html?a=3#menu', $subject->url());
	}
	
	public function test_url_QueryNotSet()
	{
		$subject = new URL();
		$subject->Scheme	= 'http';
		$subject->User		= 'test';
		$subject->Pass		= 'pass';
		$subject->Host		= 'hello.world.com';
		$subject->Port		= 89;
		$subject->Path		= '/hi.html';
		$subject->Fragment	= 'menu';
		
		self::assertEquals('http://test:pass@hello.world.com:89/hi.html#menu', $subject->url());
	}
	
	public function test_url_FragmentNotSet()
	{
		$subject = new URL();
		$subject->Scheme	= 'http';
		$subject->User		= 'test';
		$subject->Pass		= 'pass';
		$subject->Host		= 'hello.world.com';
		$subject->Port		= 89;
		$subject->Path		= '/hi.html';
		$subject->Query		= ['a' => 3];
		
		self::assertEquals('http://test:pass@hello.world.com:89/hi.html?a=3', $subject->url());
	}
	
	public function test_url_QueryHasArrayParam_NotOverride()
	{
		$subject = new URL();
		$subject->Scheme	= 'http';
		$subject->User		= 'test';
		$subject->Pass		= 'pass';
		$subject->Host		= 'hello.world.com';
		$subject->Port		= 89;
		$subject->Path		= '/hi.html';
		$subject->Query		= ['a' => 3, 'b[]' => [4, 5]];
		$subject->Fragment	= 'menu';
		
		self::assertEquals('http://test:pass@hello.world.com:89/hi.html?a=3&b[]=4&b[]=5#menu', $subject->url());
	}
	
	public function test_url_PortIsDefault_PortOmitted()
	{
		$subject = new URL();
		$subject->Scheme	= 'http';
		$subject->User		= 'test';
		$subject->Pass		= 'pass';
		$subject->Host		= 'hello.world.com';
		$subject->Port		= 80;
		$subject->Path		= '/hi.html';
		$subject->Query		= ['a' => 3];
		$subject->Fragment	= 'menu';
		
		self::assertEquals('http://test:pass@hello.world.com/hi.html?a=3#menu', $subject->url());
	}
	
	public function test_url_BuildOnlyPathWithQueryParams()
	{
		$subject = new URL();
		$subject->Path = 'edit';
		$subject->Query = [
			'a' => 5,
			'b' => 3
		];
		
		self::assertEquals('/edit?a=5&b=3', $subject->url());
	}
	
	public function test_url_WwwHandling()
	{
		$subject = new URL('http://www.hello.world.com:80/hi.php?a=3#abcdef');
		
		self::assertEquals('http://www.hello.world.com/hi.php?a=3#abcdef', $subject->url());
	}
	
	public function test_setQueryParams_SetsParams()
	{
		$subject = new URL();
		$subject->setQueryParams(['a' => 3]);
		
		self::assertEquals(['a' => 3], $subject->Query);
	}
	
	public function test_addQueryParams_AddsParams()
	{
		$subject = new URL();
		$subject->setQueryParams(['a' => 3]);
		$subject->addQueryParams(['b' => 4]);
		
		self::assertEquals(['a' => 3, 'b' => 4], $subject->Query);
	}
	
	public function test_addQueryParam_AddsParam()
	{
		$subject = new URL();
		$subject->addQueryParam('a', 3);
		$subject->addQueryParam('b', 4);
		
		self::assertEquals(['a' => 3, 'b' => 4], $subject->Query);
	}
	
	
	public function test_get_NewURLInstanceReturned()
	{
		self::assertInstanceOf(URL::class, URL::get('http://www.unstable-cacao.com'));
	}
	
	public function test_get_ParamsSet()
	{
		$url = URL::get('http://www.unstable-cacao.com');
		
		self::assertEquals('http', $url->Scheme);
		self::assertEquals('www.unstable-cacao.com', $url->Host);
	}
	
	/**
	 * @expectedException \Structura\Exceptions\InvalidURLException
	 */
	public function test_get_ThrowExceptionOnInvalidURL_ExceptionThrown()
	{
		URL::get('http://', true);
	}
	
	public function test_hasScheme()
	{
		self::assertTrue(URL::hasScheme('http://www.unstable-cacao.com'));
		self::assertFalse(URL::hasScheme('www.unstable-cacao.com'));
	}
	
	public function test_hasHost()
	{
		self::assertTrue(URL::hasHost('http://www.unstable-cacao.com'));
		self::assertFalse(URL::hasHost('/hello/world'));
	}
	
	public function test_hasPort()
	{
		self::assertTrue(URL::hasPort('localhost:80'));
		self::assertFalse(URL::hasPort('localhost'));
	}
	
	public function test_hasUser()
	{
		self::assertTrue(URL::hasUser('http://user:@localhost'));
		self::assertFalse(URL::hasUser('http://localhost'));
	}
	
	public function test_hasPass()
	{
		self::assertTrue(URL::hasPass('http://:pass@localhost'));
		self::assertFalse(URL::hasPass('http://@localhost'));
	}
	
	public function test_hasPath()
	{
		self::assertTrue(URL::hasPath('http://www.unstable-cacao.com/hello/world'));
		self::assertFalse(URL::hasPath('http://www.unstable-cacao.com'));
	}
	
	public function test_hasQuery()
	{
		self::assertTrue(URL::hasQuery('http://www.unstable-cacao.com?a=1'));
		
		self::assertFalse(URL::hasQuery('http://www.unstable-cacao.com'));
		self::assertFalse(URL::hasQuery('http://www.unstable-cacao.com?'));
	}
	
	public function test_hasFragment()
	{
		self::assertTrue(URL::hasFragment('http://www.unstable-cacao.com#yes'));
		
		self::assertFalse(URL::hasFragment('http://www.unstable-cacao.com#'));
		self::assertFalse(URL::hasFragment('http://www.unstable-cacao.com'));
	}
	
}