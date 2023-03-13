<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Str;

class VerifyWebhook
{
    /**
     * The session store instance.
     *
     * @var Store
     */
    protected $session;

    /**
     * Create a new middleware instance.
     *
     * @param Store $session
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->startSessionIfNecessary($request);

        $token = $this->session->get('_token');
        if (empty($token)) {
            $token = $this->generateToken();
            $this->session->put('_token', $token);
        }

        $request->attributes->set('verifiedCsrfToken', $token);

        return $next($request);
    }

    /**
     * Start the session if necessary for the request.
     *
     * @param Request $request
     */
    protected function startSessionIfNecessary(Request $request)
    {
        if ($this->session->isStarted()) {
            return;
        }

        $sessionCookie = $request->cookies->get(config('session.cookie'));

        if (!is_null($sessionCookie)) {
            $this->session->setId($sessionCookie);
        }

        $this->session->start();
    }

    /**
     * Generate a new CSRF token.
     *
     * @return string
     */
    protected function generateToken()
    {
        return Str::random(40);
    }
}
