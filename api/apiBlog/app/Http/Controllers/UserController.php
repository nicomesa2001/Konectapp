<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    //
    public function store(Request $request)
    {

        //Validation
        if ($request->ajax()) {

            try {
                //code...

                $this->validate($request, [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email',
                    'password' => 'required|string',
                ]);

                //Save
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->save();

                //Retornar respuesta
                return response()->json([
                    'Message' => 'Ok',
                    'User' => $user
                ]);
            } catch (ValidationException $error) {
                return response()->json(
                    $error->validator->errors()
                );
            }
        }
    }

    public function update(Request $request, User $user)
    {


        if ($request->ajax()) {
            try {

                //Validation
                $this->validate($request, [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email',
                    'password' => 'required|string',
                ]);

                //Save
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->save();

                //Retornar respuesta
                return response()->json([
                    'Message' => 'Ok',
                    'User' => $user
                ]);
            } catch (ValidationException $error) {
                return response()->json(
                    $error->validator->errors()
                );
            }
        }
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'Message' => 'Ok',
            'User' => $user
        ]);
    }
}