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
namespace App\Middleware\UnauthorizedHandler;

use Authorization\Exception\Exception;
use Authorization\Exception\MissingIdentityException;
use Authorization\Exception\ForbiddenException;
use Authorization\Middleware\UnauthorizedHandler\HandlerInterface;
use Cake\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * This handler will redirect the response if one of configured exception classes is encountered.
 */
class RegtoscHandler  extends \Authorization\Middleware\UnauthorizedHandler\RedirectHandler
{
    /**
     * Default config:
     *
     *  - `exceptions` - A list of exception classes.
     *  - `url` - Url to redirect to.
     *  - `queryParam` - Query parameter name for the target url.
     *  - `statusCode` - Redirection status code.
     *
     * @var array
     */
/*    protected $defaultOptions = [
        'exceptions' => [
            MissingIdentityException::class,
        ],
        'url' => 'Users/landing',
        'queryParam' => 'redirect',
        'statusCode' => 302,
          'custom_param' => true,
    ];*/

    /**
     * {@inheritDoc}
     *
     * Return a response with a location header set if an exception matches.
     */
 public function handle(Exception $exception, ServerRequestInterface $request, array $options = []): ResponseInterface {
    $response = parent::handle($exception, $request, $options);
    $controller=$request->getParam('controller') ;
    $action=$request->getParam('action') ;
    $request->getFlash()->error('Non sei autorizzato ad eseguire ' . $action . ' su ' . $controller);
    return $response;
}
    /**
     * Checks if an exception matches one of the classes.
     *
     * @param \Authorization\Exception\Exception $exception Exception instance.
     * @param \Exception[] $exceptions A list of exception classes.
     * @return bool
     */
 /*   protected function checkException(Exception $exception, array $exceptions): bool
    {
        foreach ($exceptions as $class) {
            if ($exception instanceof $class) {
                return true;
            }
        }

        return false;
    }*/

    /**
     * Returns the url for the Location header.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request Server request.
     * @param array $options Options.
     * @return string
     */
    protected function getUrl(ServerRequestInterface $request, array $options): string
    {
      $a=$request->referer();
        $url = $options['url'];  
        if ($options['queryParam'] !== null && $request->getMethod() === 'GET') {
            $uri = $request->getUri();
            $redirect = $uri->getPath();
            $webroot = $uri->base;
    
            if ($uri->getQuery()) {
                $redirect .= '?' . $uri->getQuery();
            }
            $query = urlencode($options['queryParam']) . '=' . urlencode($redirect);
            if (strpos($url, '?') !== false) {
                $query = '&' . $query;
            } else {
                $query = '?' . $query;
            }

            $url .= $query;
        }
if (empty($webroot)) $webroot= MYAPP;
        return $webroot . $a;
    }
}