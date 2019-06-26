<?php
use oauth\Oauth;
use patterns\ServiceLocator;

class Oauth2Controller extends \Zend_Controller_Action{
	
	private $server = null;

	public function response($respuesta, $http_code = 200){
        $this->getResponse()->setHttpResponseCode($http_code);
        $respuesta = \Zend_Json::encode($respuesta);
        exit($this->getResponse()->appendBody($respuesta));
    }

    public function error(\Exception $e, $http_code = 500){
        //die($e->getMessage());
        //Envio al cliente codigo HTTP de error
        //valido que el $e->getCode() dentro de un http code, sino 500
        $this->getResponse()->setHttpResponseCode($http_code);
        $resultado = array("status"=>1, "description"=>$e->getMessage());
        $resultado = \Zend_JSON::encode($resultado);
        //Con instancia de Response envio cuerpo del mensaje
        exit($this->getResponse()->appendBody($resultado));
	}
	
	public function getRawParam($name){
        $raw    = $this->getRequest()->getRawBody();
        $raw    = \Zend_JSON::decode($raw);
        return $raw[$name];
    }


	public function init(){
		try{
			$Config	= ServiceLocator::getConfig();
			$storage = new \OAuth2\Storage\Pdo(array(
				'dsn' 		=> $Config->database->oauth->dsn, 
				'username'	=> $Config->database->oauth->username,
				'password' 	=> $Config->database->oauth->password));
			// Pass a storage object or array of storage objects to the OAuth2 server class
			$this->server = new \OAuth2\Server($storage, array(
					'allow_implicit' => true,
					'expires'=>1,
			));
			// Add the "Client Credentials" grant type (it is the simplest of the grant types)
			$this->server->addGrantType(new \OAuth2\GrantType\ClientCredentials($storage));
			// Add the "Authorization Code" grant type (this is where the oauth magic happens)
			$this->server->addGrantType(new \OAuth2\GrantType\AuthorizationCode($storage));
		}
		catch (\Exception $e){
			$this->error($e, 409);
		}
	}

	public function verifyAction(){
		try{
			$scopeRequired = is_null($this->getRawParam('scope_required'))?$this->getParam('scope_required'):$this->getRawParam('scope_required');
			if(empty($scopeRequired) || is_null($scopeRequired)){
				throw new \Exception('La solicitud requiere privilegios superiores a los proporcionados por el token de acceso ('.$scopeRequired.')', 9875);
			}
			$request = \OAuth2\Request::createFromGlobals();
			$response = new \OAuth2\Response();
			if (!$this->server->verifyResourceRequest($request, $response, $scopeRequired)) {
				// if the scope required is different from what the token allows, this will send a "401 insufficient_scope" error
				throw new \Exception('La solicitud requiere privilegios superiores a los proporcionados por el token de acceso ('.$scopeRequired.')', 9875);
			}
			$this->response(array('description'=>"OK"), 200);
		}
		catch (\Exception $e){
			$this->error($e, 404);
		}
	}

	public function tokenAction(){
		try{
			$request = OAuth2\Request::createFromGlobals();
			$response = new OAuth2\Response();
			$this->server->handleTokenRequest($request,$response)->send();
			exit();
		}
		catch (\Exception $e){
			$this->error($e, 409);
		}
	}

	public function authorize(){
		die('Not implemented, this server does not require users access');
	}
}
