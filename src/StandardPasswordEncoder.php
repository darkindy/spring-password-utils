<?php
namespace Darkindy\SpringPasswordUtils;

/**
*  
*
*  @author Andrei Pietrușel
*/
class StandardPasswordEncoder 
{
	
	/**  @var string $m_SampleProperty define here what this variable is for, do this for every instance variable */
	protected $m_SaltGenerator;
	
	public function __construct()
	{
		$this->m_SaltGenerator = new SaltGenerator;
	}
	
	/**
	* 
	*
	* @param string $param1 A string containing the parameter
	*
	* @return boolean
	*/
	public function matches($rawPassword, $encodedPassword)
	{
		$digested = $this->decode($encodedPassword);
		$salt = $this->subArray($digested, 0, $this->m_SaltGenerator->getKeyLength());
		return $this->matchesInternal($digested, $this->digest($rawPassword, $salt));
	}
	
	protected function matchesInternal($expected, $actual)
	{
		if (strlen($expected) !== strlen($actual)) {
            return false;
        }
        $result = 0;
        for ($i = 0; $i < strlen($expected); $i++) {
            $result |= ord($expected[$i]) ^ ord($actual[$i]);
        }
        return $result === 0;
	}
	
	/**
	* Extract a sub array of characters out of the char array.
    * @param array $array The char array to extract from
    * @param int $beginIndex The beginning index of the sub array, inclusive
    * @param int $endIndex the ending index of the sub array, exclusive
	* @return array The array containing the extracted subset of characters
	*/
	protected function subArray($array, $beginIndex, $endIndex)
	{
		$length = $endIndex - $beginIndex;
        $subarray = array();
		for($i = $beginIndex; ($i - $beginIndex) < $length; $i++) {
			$subarray[$i - $beginIndex] = $array[$i];
		}
        return $subarray;
	}
	
	protected function digest($rawPassword, $salt)
	{
		return $rawPassword;
	}
	
	protected function decode($encodedPassword)
	{
		return Hex::decode($encodedPassword);
	}
	
}

class SaltGenerator {
	public function getKeyLength()
	{
		return 8;
	}
}

class Hex {
	public static function decode($encodedString)
	{
		return $encodedString;
	}
}


