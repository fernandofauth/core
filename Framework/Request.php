<?php
// 2017-01-01
// Этот класс вычленяет из запроса параметры с приставкой «df-»
namespace Df\Framework;
class Request {
	/**
	 * 2017-01-01
	 * Возвращает параметры запроса без приставки «df-».
	 * @param string|null $k [optional]
	 * @param mixed|null|callable $d [optional]
	 * @return array(string => mixed)|mixed|null
	 */
	public static function clean($k = null, $d = null) {return dfak(function() {return
		dfa_unset($_REQUEST, self::extraKeysRaw())
	;}, $k, $d);}

	/**
	 * 2017-01-01
	 * Возвращает параметры запроса с приставкой «df-», при этом удалив эту приставку.
	 * @param string|null $k [optional]
	 * @param mixed|null|callable $d $key [optional]
	 * @return array(string => mixed)|mixed|null
	 */
	public static function extra($k = null, $d = null) {return dfak(function() {return
		df_map_kr(function($k, $v) {return [
			df_trim_text_left($k, 'df-'), $v
		];}, dfa_select($_REQUEST, self::extraKeysRaw()))
	;}, $k, $d);}

	/**
	 * 2017-01-01
	 * @return array(string => mixed)
	 */
	private static function extraKeysRaw() {return dfcf(function() {return
		array_filter(array_keys($_REQUEST), function($k) {return df_starts_with($k, 'df-');})
	;});}
}