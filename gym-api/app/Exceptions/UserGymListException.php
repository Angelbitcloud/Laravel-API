<?php

namespace App\Exceptions;

use Exception;

class UserGymListException extends Exception
{
     protected $message = 'Error al listar los usuarios.';
     protected $code = 500; 
     protected $errors; // Almacena los errores de validación

 
     public function __construct($errors = [],$message = null, $code = 500, Exception $previous = null)
     {
        $this->errors = $errors;

         // Construye el mensaje de error personalizado
        $this->message = $message ?? $this->buildMessage();

        parent::__construct($message ?? $this->message, $code, $previous);
     }

     // Método para construir el mensaje de error
     protected function buildMessage()
     {
         // Si no hay errores, devolver un mensaje estándar
         if (empty($this->errors)) {
             return json_encode([
                 'message' => 'Error en la validación.',
                 'errors' => ['No se proporcionaron detalles de error.'],
             ]);
         }
 
         // Si hay errores, devolverlos
         return json_encode([
             'message' => 'Error en la validación.',
             'errors' => $this->errors,
         ]);
     }

    // Método para obtener los errores de validación
    public function getErrors()
    {
        return $this->errors;
    }
}
