<?php
namespace Df\Payment\Source;
use Magento\Payment\Model\Method\AbstractMethod as M;
/**
 * 2017-03-21
 * Этот класс не абстрактен: он используется напрямую модулями, не поддерживающими Review
 * в силу необходимости проверки 3D Secure: Checkout.com, Paymill, Omise.
 * @see \Df\Payment\Source\ACR
 */
class AC extends \Df\Config\SourceT {
	/**
	 * 2017-03-21
	 * @override
	 * @see \Df\Config\Source::map()
	 * @used-by \Df\Config\Source::toOptionArray()
	 * @see \Df\Payment\Source\ACR::map()
	 * @return array(string => string)
	 */
	protected function map() {return [self::A => 'Authorize', self::C => 'Capture'];}

	/**
	 * 2017-03-21
	 * @used-by \Df\Payment\Source\AC::map()
	 * @used-by \Df\StripeClone\W\Strategy\Charge::action()
	 * @used-by \Dfe\CheckoutCom\Handler\CustomerReturn::action()
	 * @used-by \Dfe\CheckoutCom\Handler\CustomerReturn::p()
	 * @used-by \Dfe\CheckoutCom\Response::action()
	 * @used-by \Dfe\CheckoutCom\Response::magentoTransactionId()
	 */
	const A = M::ACTION_AUTHORIZE;

	/**
	 * 2017-03-21
	 * @used-by \Df\Payment\Method::getConfigPaymentAction()
	 * @used-by \Df\Payment\Source\AC::map()
	 * @used-by \Df\PaypalClone\W\Confirmation::capture()
	 * @used-by \Df\StripeClone\W\Strategy\Charge::action()
	 * @used-by \Dfe\CheckoutCom\Method::isCaptureDesired()
	 */
	const C = M::ACTION_AUTHORIZE_CAPTURE;
}