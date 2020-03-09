<?php 

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\BinaryFileResponse as FileResponse;

class CorsMiddleware {

  public function handle($request, \Closure $next)
  {
    $languageId = $request->header('Accept-Language');
    if ($languageId) {
        app('translator')->setLocale($languageId);
    }

  	if ($request->isMethod('OPTIONS')) {
      app('router')->options($request->path(), function() { return response('', 200); });
    }

    $response = $next($request);

    if ( $response instanceof FileResponse ) {
      return $response;
    }

    $response->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, PATCH, DELETE');
    $response->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'));
    $response->header('Access-Control-Allow-Origin', '*');
    return $response;
  }

}