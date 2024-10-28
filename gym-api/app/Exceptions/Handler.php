<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;

class Handler extends ExceptionHandler
{
    // Lista de excepciones que deseas manejar
    protected $dontReport = [
        // otras excepciones
    ];

    // Registra las excepciones personalizadas que deseas manejar
    public function render($request, Exception $exception)
    {
        // Manejo de excepciones personalizadas
        if ($exception instanceof UserGymListException) {
            return response()->json([
                'message' => $exception->getMessage(),
                'errors' => $exception->getCode() === 404 ? null : $exception->getTrace()
            ], $exception->getCode() ?: 500);
        }

        if ($exception instanceof UserGymValidationException) {
            return response()->json([
                'message' => $exception->getMessage(),
                'errors' => $exception->getErrors() // Asegúrate de que esta función esté en tu excepción
            ], $exception->getCode() ?: 400);
        }

        return parent::render($request, $exception);
    }
}
