<?php
namespace Df\PaypalClone\Source;
/**      
 * 2016-08-15                                                
 * 1) AllPay: https://github.com/mage2pro/allpay/blob/1.5.10/etc/adminhtml/system.xml#L299
 * 2) Yandex.Kassa: https://github.com/mage2pro/yandex-kassa/blob/0.0.9/etc/adminhtml/system.xml#L152-L163
 */
final class OptionsLocation extends \Df\Payment\Source {
	/**
	 * 2016-08-15
	 * @override
	 * @see \Df\Config\Source::map()
	 * @used-by \Df\Config\Source::toOptionArray()
	 * @return array(string => string)
	 */
	protected function map() {return [
		'psp' => "on the {$this->titleB()} payment page", self::MAGENTO => 'on the Magento checkout page'
	];}

	/**
	 * 2017-03-19
	 * @used-by \Dfe\AllPay\ConfigProvider::config()
	 * @used-by \Df\PaypalClone\Source\OptionsLocation::map()
	 */
	const MAGENTO = 'magento';
}