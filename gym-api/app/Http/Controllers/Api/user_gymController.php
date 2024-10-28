<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Exceptions\UserGymListException;
use App\Services\UserService; 
use Illuminate\Http\Request;



class user_gymController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService; // Inyección de dependencias
    }

    public function listAll()
    {
        // Usa el servicio para obtener la lista de usuarios
        $users = $this->userService->listAllUsers();

        // Devuelve los usuarios en formato JSON
        return response()->json($users, 200);
    }

    public function listUserByID($id)
    {
        // Usa el servicio para obtener un usuario por su ID
        $user = $this->userService->listUser($id);

        // Devuelve el usuario en formato JSON
        return response()->json($user, 200);
    }

    public function createUser(Request $request)
    {
        // Usa el servicio para crear un nuevo usuario
        $user = $this->userService->createUser($request->all());

        // Devuelve el usuario creado en formato JSON
        return response()->json($user, 201);
    }

    public function deletedByID($id)
    {
        // Usa el servicio para eliminar un usuario por su ID
        $user = $this->userService->deleteUser($id);

        // Devuelve el usuario eliminado en formato JSON
        return response()->json($user, 200);
    }

    public function updateUserByID(Request $request, $id)
    {
        // Usa el servicio para actualizar un usuario por su ID
        $user = $this->userService->updateUser($request->all(), $id);

        // Devuelve el usuario actualizado en formato JSON
        return response()->json($user, 200);
    }
    
}
