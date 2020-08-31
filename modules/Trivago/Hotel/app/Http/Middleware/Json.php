<?php
/**
 * Created by PhpStorm.
 * User: kousha
 * Date: 3/1/19
 * Time: 3:27 PM
 */

namespace Hotel\app\Http\Middleware;

use Closure;
use Exception;

class Json
{

    /**
     * CREATE JSON RESPONSE
     *
     * @param $request
     * @param Closure $next
     *
     * @return Closure
     */
    public function handle($request, Closure $next)
    {


        if ($request->headers->has('accept-app')) {
            try {
                $response = $next($request);
                return response()->json([
                    "status" => true,
                    "code" => 200,
                    "message" => "",
                    "error" => "",
                    "data" => $response->original
                ], 200);
            } catch (Exception $e) {
                return response()->json([
                    "status" => false,
                    "code" => $e->getCode(),
                    "message" => $e->getMessage(),
                    "error" => $e->getMessage(),
                    "data" => $response->original
                ], $e->getCode());
            }
        } else {
            return $next($request);
        }

    }

}
