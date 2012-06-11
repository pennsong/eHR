<?php
/**
 * customized Input
 * @author: penn
 */
class CW_Input extends CI_Input
{
	/**
	 * Fetch an item from the POST array
	 * 和CI原来的input->post()区别是对于没有设置的值返回NULL而不是false
	 * @access	public
	 * @param	string
	 * @param	bool
	 * @return	string or NULL
	 */
	function post($index = NULL, $xss_clean = FALSE)
	{
		// Check if a field has been provided
		if ($index === NULL AND !empty($_POST))
		{
			$post = array();
			// Loop through the full _POST array and return it
			foreach (array_keys($_POST) as $key)
			{
				$post[$key] = $this->_fetch_from_array($_POST, $key, $xss_clean);
			}
			return $post;
		}
		return $this->_fetch_from_array($_POST, $index, $xss_clean);
	}

	// --------------------------------------------------------------------
	/**
	 * Fetch from array
	 *
	 * This is a helper function to retrieve values from global arrays
	 *
	 * @access	private
	 * @param	array
	 * @param	string
	 * @param	bool
	 * @return	string
	 */
	function _fetch_from_array(&$array, $index = '', $xss_clean = FALSE)
	{
		if (!isset($array[$index]))
		{
			return NULL;
		}
		if ($xss_clean === TRUE)
		{
			return $this->security->xss_clean($array[$index]);
		}
		return $array[$index];
	}

	// --------------------------------------------------------------------
}

/*end*/
 