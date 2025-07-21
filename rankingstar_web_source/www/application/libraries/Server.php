<?php
require_once APPPATH.'third_party/OAuth2/Autoloader.php';
class Server{
	function __construct(){
		//Database Configuration
		$config = array(
			'dsn' => 'mysql:dbname=rankingstar;host=127.0.0.1',
			'username' => 'rankingstar',
			'password' => 'skyand2020!' 
		);
		OAuth2\Autoloader::register();
		$this->storage = new OAuth2\Storage\Pdo(array('dsn' => $config["dsn"], 'username' => $config["username"], 'password' => $config["password"]));
		$this->server = new OAuth2\Server($this->storage, array('allow_implicit' => true, 'access_lifetime' => ACCESS_TOKEN_LIFETIME));
		$this->request = OAuth2\Request::createFromGlobals();
		$this->response = new OAuth2\Response();
	}

	public function client_credentials(){
		$this->server->addGrantType(new OAuth2\GrantType\ClientCredentials($this->storage, array(
    		"allow_credentials_in_request_body" => true
		)));
		$this->server->handleTokenRequest($this->request)->send();
	}

	public function password_credentials(){
		$this->server->addGrantType(new OAuth2\GrantType\UserCredentials($this->storage));
		$response = $this->server->handleTokenRequest($this->request)->send();
		return $response;
	}

	public function refresh_token(){
		$this->server->addGrantType(new OAuth2\GrantType\RefreshToken($this->storage, array(
			"always_issue_new_refresh_token" => true,
			"unset_refresh_token_after_use" => true,
			"refresh_token_lifetime" => 2419200,
		)));
		$response = $this->server->handleTokenRequest($this->request)->send();
		return $response;
	}

	public function get_user_data(){
		if($this->server->verifyResourceRequest($this->request, $this->response)){
			return $this->server->getAccessTokenData($this->request);
		}
		return $this->response->send();
	}
	/**
	* limit scpoe here
	* @param $scope = "node file userinfo"
	*/
	public function require_scope($scope=""){
		if (!$this->server->verifyResourceRequest($this->request, $this->response, $scope)) {
    		$this->server->getResponse()->send();
    		die;
		}
	}

	public function check_client_id(){
		if (!$this->server->validateAuthorizeRequest($this->request, $this->response)) {
    		$this->response->send();
    		die;
		}
	}

	public function authorize($is_authorized){
		$this->server->addGrantType(new OAuth2\GrantType\AuthorizationCode($this->storage));
		$this->server->handleAuthorizeRequest($this->request, $this->response, $is_authorized);
		if ($is_authorized) {
	  		$code = substr($this->response->getHttpHeader('Location'), strpos($this->response->getHttpHeader('Location'), 'code=')+5, 40);
	  		header("Location: ".$this->response->getHttpHeader('Location'));
	  	}
		$this->response->send();
	}

	public function authorization_code(){
		$this->server->addGrantType(new OAuth2\GrantType\AuthorizationCode($this->storage));
		$this->server->handleTokenRequest($this->request)->send();
	}

	//check for access token
    public function check_auth_access(){
        if(!$this->server->verifyResourceRequest($this->request, $this->response)){
			return $this->response->send();
        }
    }

	// //check for basic token
    // public function check_basic_auth(){
	// 	// If we get here, username was provided. Check password.
	// 	if ($_SERVER['PHP_AUTH_USER'] == 'ranking-star' && $_SERVER['PHP_AUTH_PW'] == 'b4bca6aa25828cf702d06cbc9656d4e3') {
	// 		echo '<p>Access granted. You know the password!</p>';
	// 	}
    // }
}
