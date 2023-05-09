<?php
namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use App\Lib\Auth;

class AuthMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        // Verifica si el usuario está autenticado
        // Recupera el token Bearer de la petición
        $authorizationHeader = $request->getHeaderLine('Authorization');
        $token = null;

        if (preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
            $token = $matches[1];
        }

        $authenticated = Auth::validateToken($token); // aquí se debe verificar la autenticación del usuario

        if (!$authenticated) {
            // Si el usuario no está autenticado, devuelve una respuesta de error
            $response = new Response();
            $response->getBody()->write(json_encode([
                "result"     =>null,
                "response"   => false,
                "message"    => "Unauthorized"
            ]));
            return $response->withStatus(401);
        }

        // Si el usuario está autenticado, continua con el procesamiento
        return $handler->handle($request);
    }
}
