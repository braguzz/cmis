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

/**
 * Form Authenticator
 *
 * Authenticates an identity based on the POST data of the request.
 */
class SmartcardAuthenticator extends AbstractAuthenticator
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

    /**
     * Checks the fields to ensure they are supplied.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request that contains login information.
     * @return array|null Username and password retrieved from a request body.
     */
 
    /**
     * Authenticates the identity contained in a request. Will use the `config.userModel`, and `config.fields`
     * to find POST data that is used to find a matching record in the `config.userModel`. Will return false if
     * there is no post data, either username or password is missing, or if the scope conditions have not been met.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request that contains login information.
     * @return \Authentication\Authenticator\ResultInterface
     */
    public function authenticate(ServerRequestInterface $request): ResultInterface
    {
     
        if (!env('SSL_CLIENT_M_SERIAL')
		|| !env('SSL_CLIENT_V_END')
		|| !env('SSL_CLIENT_VERIFY')
		|| env('SSL_CLIENT_VERIFY') !== 'SUCCESS'
		|| !env('SSL_CLIENT_I_DN'))  {
		return new Result(null, Result::FAILURE_CREDENTIALS_MISSING, [
                'Login credentials not found',
            ]);
	}
     // giorni residui validi per il certificato
	if (env('SSL_CLIENT_V_REMAIN') <= 0) {
		return new Result(null, Result::FAILURE_CREDENTIALS_MISSING, [
                'Login credentials not found',
            ]);
	}
	// verifica l'abilitazione dell'utente
	$cf = substr(env('SSL_CLIENT_S_DN_CN'),0,16); // il codice fiscale    
      $users = TableRegistry::get('Users');
     
      $query = $users->find('all', [
                            'conditions' => ['Users.codice_fiscale' => $cf],
                            'contain' => ['Roles']
                        ]);
      $sslUser = $query->first();
     if(!$sslUser) {
		return new Result(null, Result::FAILURE_CREDENTIALS_MISSING, [
                'Login credentials not found',
            ]);
	} 
    return new Result($sslUser, Result::SUCCESS);
      


        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        if (!$this->_checkUrl($request)) {
            return $this->_buildLoginUrlErrorResult($request);
        }

        $data = $this->_getData($request);
        if ($data === null) {
            return new Result(null, Result::FAILURE_CREDENTIALS_MISSING, [
                'Login credentials not found',
            ]);
        }

        $user = $this->_identifier->identify($data);

        if (empty($user)) {
            return new Result(null, Result::FAILURE_IDENTITY_NOT_FOUND, $this->_identifier->getErrors());
        }

        return new Result($user, Result::SUCCESS);
    }
}
