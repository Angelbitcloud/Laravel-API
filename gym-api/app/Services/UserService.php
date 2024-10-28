<?php

namespace App\Services;

use App\Models\User_Gym;
use App\Exceptions\UserGymListException;
use Illuminate\Support\Facades\validator;


class UserService
{
    public function listAllUsers()
    {
        try {
            $users = User_Gym::all();

            if ($users->isEmpty()) {
                return response()->json([
                    'error' => 'No se encontraron usuarios.'
                ], 404);
            }

            return $users;
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function listUser($id)
    {
        try {
            $user = User_Gym::find($id);

            if (!$user) {
                return response()->json([
                    'error' => 'Usuario no encontrado.'
                ], 404);
            }

            return $user;

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }

   
    public function createUser(array $data)
    {
        if (!isset($data['isActive'])) {
            $data['isActive'] = 's'; 
        }

        $validator = Validator::make($data, [
            'name' => 'required|string',
            'lastname' => 'required|string',
            'cell' => 'required|integer',
            'monthlyPayment' => 'required|integer',
            'isActive' => 'required|in:s,n'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Errores de validación',
                'messages' => $validator->errors()->all()
            ], 400);
        }

        try {
            $user = User_Gym::create([
                'name' => $data['name'],
                'lastname' => $data['lastname'],
                'cell' => $data['cell'],
                'monthlyPayment' => $data['monthlyPayment'],
                'isActive' => $data['isActive']
            ]); 

            if (!$user) {
                return response()->json([
                    'error' => 'Error al crear el usuario.'
                ], 500);
            }

            return response()->json($user, 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }

    public function updateUser(array $data, $id)
    {
        try {
            $user = User_Gym::find($id);

            if (!$user) {
            return response()->json([
                'error' => 'Usuario no encontrado.'
            ], 404);
            }

            $validator = Validator::make($data, [
                'name' => 'required|string',
                'lastname' => 'required|string',
                'cell' => 'required|integer',
                'monthlyPayment' => 'required|integer',
                'isActive' => 'required|in:s,n'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Errores de validación',
                    'messages' => $validator->errors()->all()
                ], 400);
            }

            $user->name = $data['name'];
            $user->lastname = $data['lastname'];
            $user->cell = $data['cell'];
            $user->monthlyPayment = $data['monthlyPayment'];
            $user->isActive = $data['isActive'];

            $user->save();

            $data = [
                'mesage' => 'Usuario actualizado correctamente.',
                'user' => $user,
                'status' => 200
            ];

            return response()->json($data, 200);

        } catch (\Exception $e) {
            return response()->json([
            'error' => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = User_Gym::find($id);

            if (!$user) {
            return response()->json([
                'error' => 'Usuario no encontrado.'
            ], 404);
            }

            $user->isActive = 'n';
            $user->save();

            return response()->json([
            'message' => 'Usuario desactivado correctamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
            'error' => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }
}
