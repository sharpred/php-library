<?php
/*
 Thanks George A. Papayiannis, most codes of this file are from
http://www.sematopia.com/2006/10/how-to-making-a-php-rest-client-to-call-rest-resources/
*/

class RESTClient {

	private $user_name = "";
	private $password = "";
	private $content_type = "";
	private $response = "";
	private $responseBody = "";
	private $responseCode = "";
	private $req = null;

	public function __construct($user_name="", $password="", $content_type="") {
		$this->user_name = $user_name;
		$this->password = $password;
		$this->content_type = $content_type;
		return true;
	}

	public function createRequest($url, $method, $arr = null) {
		$this->req = new HttpRequest($url);
		try {
			if ($this->user_name != "" && $this->password != "") {
				$credentials = $this->user_name .':' .$this->password;
				$options = array('httpauth' => $credentials, 'httpauthtype' => HttpRequest::AUTH_BASIC);
				$this->req->setOptions($options);
			}
			if ($this->content_type != "") {
				$this->req->setContentType($this->content_type);
			}

			switch($method) {
				case "GET":
					$this->req->setMethod(HttpRequest::METH_GET);
					break;
				case "POST":
					$this->req->setMethod(HttpRequest::METH_POST);
					$this->req->setBody($arr);
					break;
				case "PUT":
					$this->req->setMethod(HttpRequest::METH_PUT);
					$this->req->setBody($arr);
					break;
				case "DELETE":
					$this->req->setMethod(HttpRequest::METH_DELETE);
					break;
			}
		} catch (Exception $e) {

			
			
		}
	}

	public function sendRequest() {
		$this->response = $this->req->send();

		$this->responseCode = $this->req->getResponseCode();
		$this->responseBody = $this->req->getResponseBody();

	}

	public function getResponse() {
		return array($this->responseCode, $this->responseBody);
	}

}

?>
