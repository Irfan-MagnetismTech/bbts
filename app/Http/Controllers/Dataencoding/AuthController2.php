<?php

namespace App\Http\Controllers\Dataencoding;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\AuthRequest;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController2 extends Controller
{
    /**
     * Register User and Token Creation
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $attr = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
//                'c_password' => 'required|same:password',
            ]);

            $user = User::create([
                'name' => $attr['name'],
                'password' => bcrypt($attr['password']),
                'email' => $attr['email']
            ]);

            if ($user) {
                $data = [
                    'token' => $user->createToken($request->device_name)->plainTextToken,
                    'user' => $user
                ];
                return response()->success('User Created Successfully', $data);
            }
        } catch (ValidationException $e) {
            return response()->error($e->getMessage());
        }
    }

    /**
     * Login User and Token Creation
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(AuthRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['success' => false, 'error' => 'Incorrect email/password !', 'message' => 'Incorrect email/password !'], 200);
            }

            $permissions = [];
            foreach ($user->getRoleNames() as $role) {
                $permissions[] = Role::whereName($role)->with('permissions')->get()->pluck('permissions')->flatten()->pluck('name')->toArray();
            }
            $allPermissions = [];
            foreach ($permissions as $permission) {
                foreach ($permission as $item) {
                    if (!in_array($item, $allPermissions)) {
                        $allPermissions[] = $item;
                    }
                }
            }

            $data = [
                'token' => $user->createToken('Desktop')->plainTextToken,
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->getRoleNames(),
                    'permissions' => $allPermissions,
                ]
            ];

            return response()->success('Login successful', $data, 200);
        } catch (ValidationException $e) {
            return response()->error($e->getMessage());
        }
    }

    /**
     * Logout User and Token Deletion
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->success('Logout successful');
        } catch (ValidationException $e) {
            return response()->error('Logout failed');
        }
    }

    public function export()
    {
        return Excel::download(new PurchaseOrdersExport, 'bpo.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
