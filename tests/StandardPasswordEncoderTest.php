<?php
use PHPUnit\Framework\TestCase;
use Darkindy\SpringPasswordUtils\StandardPasswordEncoder;

/**
*
*
*  @author Andrei Pietrușel
*/
class StandardPasswordEncoderTest extends TestCase
{

	/**
	* 
	*/
	public function testIsThereAnySyntaxError()
	{
		$var = new StandardPasswordEncoder;
		$this->assertTrue(is_object($var));
		unset($var);
	}
	
	/**
	* 
	*/
	public function testMatches()
	{
		$var = new StandardPasswordEncoder;
		$this->assertTrue($var->matches("1234567890","1234567890") === true);
		unset($var);
	}
  
}
