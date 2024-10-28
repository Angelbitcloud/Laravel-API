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
        } catch (UserGymListException $e) {
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

    /*
    public function createUser(array $data)
    {
        if (!isset($data['is_active'])) {
            $data['is_active'] = 's'; 
        }

        $validator = Validator::make($data->all(), [
            'name' => 'required|string',
            'lastname' => 'required|string',
            'cell' => 'required|integer',
            'monthly_payment' => 'required|integer',
            'is_active' => 'required|in:s,n'
        ]);

        if ($validator->fails()) {
            throw new UserGymListException($validator->errors()->all(), 'Errores de validación', 400);
        }

        $user = User_Gym::create([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'cell' => $data['cell'],
            'monthly_payment' => $data['monthly_payment'],
            'is_active' => $data['is_active']
        ]); 

        if (!$user) {
            throw new UserGymListException('Error al crear el usuario.', 500);
        }

        return $user;
    }
    */

    public function createUser(array $data)
    {
        if (!isset($data['is_active'])) {
            $data['is_active'] = 's'; 
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
            $user->isActive = $data['isactive'];

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

            $user->is_active = 'n';
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
