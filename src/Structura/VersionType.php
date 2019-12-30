<?php
namespace Structura;


use Traitor\TEnum;


class VersionType
{
	use TEnum;
	
	
	public const RELEASE	= 'Release';
	public const ALPHA		= 'Alpha'; 
	public const BETA		= 'Beta';
	public const RC_1		= 'RC1';
	public const RC_2		= 'RC2';
	public const RC_3		= 'RC3';
}