<?php
// 2016-11-23
namespace Df\Sso;
use Df\Sso\Settings\Button as S;
use Df\Sso\Source\Button\Type\UNL;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\Html\Links;
abstract class Button extends AbstractBlock {
	/**
	 * 2016-11-27
	 * @used-by htmlL()
	 * @return string
	 */
	abstract protected function lHref();

	/**
	 * 2016-11-23
	 * @override
	 * @see AbstractBlock::_toHtml()
	 * @return string
	 */
	final protected function _toHtml() {
		/** @var string $result */
		if (!self::sModule()->enable() || !$this->s()->enable()) {
			$result = '';
		}
		else if (df_customer_logged_in()) {
			$result = $this->loggedIn();
		}
		else {
			$result = $this->loggedOut();
		}
		/**
		 * 2016-11-23
		 * Ссылки в шапке надо обязательно обрамлять в <li>, потому что они выводятся внутри <ul>:
				$html = '<ul' . ($this->hasCssClass() ? ' class="' . $this->escapeHtml(
					$this->getCssClass()
				) . '"' : '') . '>';
				foreach ($this->getLinks() as $link) {
					$html .= $this->renderLink($link);
				}
				$html .= '</ul>';
		 * @see \Magento\Framework\View\Element\Html\Links::_toHtml()
		 * https://github.com/magento/magento2/blob/2.1.2/lib/internal/Magento/Framework/View/Element/Html/Links.php#L76-L82
		 */
		if ($result && $this->getParentBlock() instanceof Links) {
			$result = "<li>{$result}</li>";
		}
		return $result;
	}

	/**
	 * 2016-11-26
	 * @used-by loggedOut()
	 * @see \Df\Sso\Button\Js::attributes()
	 * @see \Dfe\FacebookLogin\Button::attributes()
	 * @return array(string => string)
	 */
	protected function attributes() {return
		($this->isNative() ? $this->attributesN() :
			['href' => $this->lHref(), 'title' => $this->s()->label()]
		)
		+ [
			'class' => df_cc_s('df-sso-button', $this->cssClass(), $this->s()->type(), $this->cssClass2())
			,'id' => df_uid(4, "{$this->cssClass()}-")
		]
	;}

	/**
	 * 2016-11-29
	 * @used-by attributes()
	 * @return array(string => string)
	 */
	protected function attributesN() {return [];}

	/**
	 * 2016-11-25
	 * @used-by id()
	 * @used-by attributes()
	 * @used-by \Df\Sso\Button\Js::jsOptions()
	 * @return string
	 */
	final protected function cssClass() {return dfc($this, function() {return
		implode('-', df_explode_class_lc_camel($this))
	;});}

	/**
	 * 2016-11-29
	 * @used-by attributes()
	 * @see \Dfe\FacebookLogin\Button::cssClass2()
	 * @return string
	 */
	protected function cssClass2() {return '';}

	/**
	 * 2016-11-29
	 * @used-by attributes()
	 * @used-by \Dfe\FacebookLogin\Button::cssClass2()
	 * @return bool
	 */
	final protected function isNative() {return dfc($this, function() {return
		UNL::isNative($this->s()->type());
	});}

	/**
	 * 2016-11-23
	 * @used-by _toHtml()
	 * @return string
	 */
	protected function loggedIn() {return '';}

	/**
	 * 2016-11-23
	 * @see \Dfe\FacebookLogin\Button::loggedOut()
	 * @used-by _toHtml()
	 * @return string
	 */
	protected function loggedOut() {return df_tag('a', $this->attributes(), $this->s()->label());}
	
	/**
	 * 2016-11-24
	 * 2016-11-27
	 * Не помечаем метод как final, потому что потомки уточняют его тип посредством phpDoc,
	 * и тогда IntelliJ IDEA ругается на final.
	 * @return S
	 */
	protected function s() {return dfc($this, function() {return
		df_ic(df_con_heir($this, S::class), [S::PREFIX => $this['dfConfigPrefix']]);
	});}

	/**
	 * 2016-11-23
	 * Для каждого класса кнопок система будет создавать несколько экземпляров:
	 * для каждого из местоположений кнопки.
	 * Поэтому кэшируем результат вызова @uses \Df\Config\Settings::convention() для класса
	 * (но при этом используем static::class, чтобы разные классы имели разные значения кэша).
	 * 2016-11-24
	 * Передаём static::class как аргумент, чтобы потомки этого класса имели индивидуальный кэш:
	 * https://github.com/mage2pro/core/blob/ab34df/Core/lib/cache.php?ts=4#L151-L160
	 * @return \Df\Config\Settings
	 */
	private static function sModule() {return dfcf(function($c) {return
		\Df\Config\Settings::convention($c)
	;}, [static::class]);}
}