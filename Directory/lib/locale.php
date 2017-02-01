<?php
use Df\Directory\Model\Country;
use Magento\Framework\Locale\Format;
use Magento\Framework\Locale\FormatInterface as IFormat;
/**
 * 2015-08-15
 * @return string
 */
function df_locale() {
	/** @var string $result */
	static $result;
	if (!isset($result)) {
		/**
		 * 2015-10-22
		 * Отдельно обрабатываем случай запроса вида:
		 * http://localhost.com:900/store/pub/static/adminhtml/Magento/backend/ru_RU/js-translation.json
		 * Если при таком запросе использовать стандартную обработку, то почему-то слетает сессия.
		 */
		/** @var string[] $urlParts */
		$urlParts = explode('/', df_current_url());
		/** @var string $fileName */
		$fileName = array_pop($urlParts);
		/**
		 * 2015-10-22
		 * m_request_o()->isAjax() здесь не работает:
		 * RequireJS text plugin (lib/web/requirejs/text.js) does not set «X-Requested-With» HTTP header
		 * so the @see \Zend\Http\Request::isXmlHttpRequest() method returns a wrong value:
		 https://github.com/magento/magento2/issues/2159
		 */
		if ($fileName === \Magento\Translation\Model\Js\Config::DICTIONARY_FILE_NAME) {
			$result = array_pop($urlParts);
		}
		if (!isset($result)) {
			/** @var \Magento\Framework\Locale\Resolver $resolver */
			/**
			 * 2015-09-20
			 * Обратите внимание, что перечисленные ниже классы ведут себя по-разному.
			 * Класс \Magento\Backend\Model\Locale\Resolver просто вернёт локально по умолчанию,
			 * а класс \Magento\Framework\Locale\Resolver учитывает предпочтения администратора.
			 * @see \Magento\Backend\Model\Locale\Resolver::setLocale()
			 * Когда мы запрашиваем интерфейс — мы получаем нужный результат:
			 * \Magento\Backend\Model\Locale\Resolver или \Magento\Framework\Locale\Resolver
			 */
			$resolver = df_o(\Magento\Framework\Locale\ResolverInterface::class);
			$result = $resolver->getLocale();
		}
	}
	return $result;
}

/**
 * 2017-01-29
 * «US» => «en_US», «SE» => «sv_SE».
 * Some contries has multiple locales (e.g., Finland has the «fi_FI» and «sv_FI» locales).
 * The function returns the default locale: «FI» => «fi_FI».
 * @param string|Country $c
 * @return string
 */
function df_locale_by_country($c) {return \Zend_Locale::getLocaleToTerritory(df_country_code($c));}

/**
 * 2016-09-06
 * @return IFormat|Format
 */
function df_locale_f() {return df_o(IFormat::class);}