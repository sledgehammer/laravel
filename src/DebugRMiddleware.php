<?php

namespace Sledgehammer\Laravel;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Sledgehammer\Core\Debug\DebugR;
use Throwable;

class DebugRMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        try {
            $response = $next($request);
            if (headers_sent() === false && DebugR::isEnabled()) {
                ob_start();
                \Sledgehammer\statusbar(false);
                DebugR::send('sledgehammer-statusbar', ob_get_clean());
            }
        } catch (Exception $exception) {
            $this->reportAndThrow($exception);
        } catch (Error $error) {
            $this->reportAndThrow($error);
        }
        return $response;
    }

    /**
     * 
     * @param Exception|Throwable $exception
     */
    private function reportAndThrow($exception) {
        if (headers_sent() === false && DebugR::isEnabled()) {
            if ($exception->getFile()) {
                $file = preg_replace('/^'.preg_quote(dirname(\Sledgehammer\VENDOR_DIR), '/').'/', '', $exception->getFile());
                $location = "\nin ".$file.' on line '.$exception->getLine();
            } else  {
                $location = '';
            }
            DebugR::warning(get_class($exception)."\n".$exception->getMessage().$location);
        }
        throw $exception;
    }

}
