<?php
namespace Df\Payment\R;
// 2016-07-09
class Exception extends \Df\Payment\Exception {
	/**
	 * 2016-07-09
	 * @param string $message
	 * @param Response $response
	 */
	public function __construct($message, Response $response) {
		parent::__construct($message);
		$this->_response = $response;
	}

	/**
	 * 2016-07-10
	 * @override
	 * @see \Df\Core\Exception::getMessageRm()
	 * @return string
	 */
	public function getMessageRm() {return $this->response()->report()->asText();}

	/** @return Response */
	protected function response() {return $this->_response;}

	/**
	 * 2016-07-09
	 * @var Response
	 */
	private $_response;
}