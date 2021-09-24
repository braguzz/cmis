<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         1.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Authenticator;

use Authentication\Authenticator\AbstractAuthenticator;
use Authentication\Authenticator\ResultInterface;
use Authentication\Authenticator\Result;

use Authentication\Identifier\IdentifierInterface;
use Authentication\UrlChecker\UrlCheckerTrait;
use Psr\Http\Message\ServerRequestInterface;
use Cake\ORM\TableRegistry;


use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Event\EventDispatcherTrait;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\Utility\Hash;
use Exception;
use League\OAuth2\Client\Provider\AbstractProvider;
use Cake\Routing\Router;


class ArpaAuthenticator extends AbstractAuthenticator
{
    use UrlCheckerTrait;

    /**
     * Default config for this object.
     * - `fields` The fields to use to identify a user by.
     * - `loginUrl` Login URL or an array of URLs.
     * - `urlChecker` Url checker config.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'loginUrl' => null,
        'urlChecker' => 'Authentication.Default',
        'fields' => [
            IdentifierInterface::CREDENTIAL_USERNAME => 'username',
            IdentifierInterface::CREDENTIAL_PASSWORD => 'password',
        ],
    ];
    
    
    public function authenticate(ServerRequestInterface $request): ResultInterface {

        $myServer  = "https://" . $_SERVER['SERVER_NAME'];
        $arpaConf = Configure::read('regtoscConf.arpaAuthenticator');
        $landingPage = Configure::read('regtoscConf.landingPage');

        if (!defined('MYCLIENTID')) {
            define('MYCLIENTID', $arpaConf['myClientID']);
        }
        if (!defined('MYCLIENTSECRET')) {
            define('MYCLIENTSECRET', $arpaConf['myClientSecret']);
        }
        if (!defined('MYSERVER')) {
            define('MYSERVER', $myServer);
        }
        if (!defined('ARPA')) {
            define('ARPA', $arpaConf['arpa']);
        }

//session_start(); 
        $url = Router::url('/', true);
        $url1 = strtok(Router::url(null, true), '?');

//$action=Router::getRequest()->params['action'];

        $pass = $request->getParam('pass');
        if (empty($pass[0]))
            $pass[0] = '';
        $action = $request->getParam('action');
        $controller = $request->getParam('controller');
        $client_id = MYCLIENTID;
        $client_secret = MYCLIENTSECRET;

        $redirect_uri = $url . $controller . '/' . $action;

        $idp = (object) [
                    'authorization_endpoint' => ARPA . '/auth',
                    'token_endpoint' => ARPA . '/token',
                    'userinfo_endpoint' => ARPA . '/userinfo',
        ];

        if (!isset($_GET['code']) && (($_SERVER['REQUEST_METHOD'] === 'POST')) && ($pass[0] != 'userpass')) {

            $_SESSION['state'] = bin2hex(random_bytes(5));

            $authorize_url = $idp->authorization_endpoint . '?' . http_build_query([
                        'response_type' => 'code',
                        'client_id' => $client_id,
                        'redirect_uri' => $redirect_uri,
                        'state' => $_SESSION['state'],
                        'scope' => 'openid profile',
                            //'code_challenge' => $code_challenge, // PKCE NON ABILITATO SU ARPA
                            //'code_challenge_method' => 'S256', // PCKE NON ABILITATO SU ARPA
            ]);
            header('Location: ' . $authorize_url);
            exit;
        }

        if (isset($_GET['code'])) {
            $response = $this->_http($idp->token_endpoint, [
                'grant_type' => 'authorization_code',
                'code' => $_GET['code'],
                'redirect_uri' => $redirect_uri,
                'client_id' => $client_id,
                'client_secret' => $client_secret,
            ]);

            if (isset($response->id_token)) {
                list($header, $payload, $signature) = explode(".", $response->id_token);
                $list = json_decode(base64_decode($payload));
                $cf = $list->preferred_username;
                $nome = $list->name;
                $cognome = $list->family_name;

                $users = TableRegistry::get('Users');

                $query = $users->find('all', [
                    'conditions' => ['Users.codice_fiscale' => $cf],
                    'contain' => ['Roles']
                ]);
                $sslUser = $query->first();
                if ($sslUser) {
                    return new Result($sslUser, Result::SUCCESS);
                } else {      //in fase di registrazione 
                    //   $this->Session->write('Person.eyeColor', 'Green');
                    $session = $request->getAttribute('session');
                    $session->write('arpaCf', $cf);
                }
            }
        }
        return new Result(null, Result::FAILURE_CREDENTIALS_MISSING, [
            'Login credentials not found',
        ]);
    }

 
    
protected function _http($url, $params=false) {
  $cu = curl_init($url);
   curl_setopt($cu,CURLOPT_RETURNTRANSFER, true);
  if($params) {
    curl_setopt($cu,CURLOPT_POST,1);
    curl_setopt($cu,CURLOPT_POSTFIELDS,http_build_query($params));
    curl_setopt($cu,CURLOPT_HTTPHEADER,['content-type: application/x-www-form-urlencoded']);
   }
   $response = curl_exec($cu);
   $err = curl_error($cu);
   curl_close($cu);   
   return $err ?  $err : json_decode($response);
}  


    
  
    
    
}    