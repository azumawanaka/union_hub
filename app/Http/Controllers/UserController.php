<?php

namespace App\Http\Controllers;

use App\Actions\CheckOldPasswordAction;
use App\Actions\DeleteUserAction;
use App\Actions\GetUserAction;
use App\Actions\SelectUserAction;
use App\Actions\StoreUserAction;
use App\Actions\UpdatePasswordAction;
use App\Actions\UpdateProfilePhotoAction;
use App\Actions\UpdateUserAction;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.users.index');
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getAllUsers(Request $request, SelectUserAction $selectUserAction): JsonResponse
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $order = $request->input('order');
        $search = $request->input('search');

        $query = $selectUserAction->execute();

        $this->applySearchConditions($query, $search);
        $this->applyOrdering($query, $order, $request);

        $users = $query->skip($start)->take($length)->get();
        $totalRecords = User::count();

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $users,
        ]);
    }

    private function applySearchConditions($query, $search)
    {
        if (!empty($search['value'])) {
            $query->where(function ($q) use ($search) {
                $q->where('users.id', 'like', '%' . $search['value'] . '%')
                    ->orWhere('users.id', 'like', '%' . $search['value'] . '%')
                    ->orWhere(DB::raw("CONCAT_WS(users.first_name, ' ', users.last_name)"), 'like', '%' . $search['value'] . '%')
                    ->orWhere('users.email', 'like', '%' . $search['value'] . '%')
                    ->orWhere('users.address', 'like', '%' . $search['value'] . '%')
                    ->orWhere('users.mobile', 'like', '%' . $search['value'] . '%')
                    ->orWhere('users.gender', 'like', '%' . $search['value'] . '%')
                    ->orWhere('users.role', 'like', '%' . $search['value'] . '%')
                    ->orWhere('users.created_at', 'like', '%' . $search['value'] . '%');
            });
        }
    }

    private function applyOrdering($query, $order, $request)
    {
        if (!empty($order) && count($order) > 0) {
            $columnIndex = $order[0]['column'];
            $columnName = $request->input("columns.$columnIndex.name");
            $columnDirection = $order[0]['dir'];

            $query->orderBy($columnName, $columnDirection);
        }
    }

    /**
     * @param string $id
     * @param GetUserAction $getUserAction
     *
     * @return JsonResponse
     */
    public function getUserById(string $id, GetUserAction $getUserAction): JsonResponse
    {
        $data = $getUserAction->execute($id);
        return response()->json($data);
    }

    /**
     * @param UserRequest $userRequest
     * @param StoreUserAction $storeUserAction
     *
     * @return RedirectResponse
     */
    public function store(UserRequest $userRequest, StoreUserAction $storeUserAction): RedirectResponse
    {
        try {
            $storeUserAction->execute($userRequest->all());
            return redirect()->back()->with('success', 'User was successfully added.');
        } catch (\Throwable $th) {
            \Log::info('errors: ', [$th]);
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * @param UserRequest $userRequest
     * @param string $id
     * @param UpdateUserAction $updateUserAction
     *
     * @return JsonResponse
     */
    public function updateUser(UserRequest $userRequest, string $id, UpdateUserAction $updateUserAction): JsonResponse
    {
        try {
            $updateUserAction->execute($id, $userRequest->all());
            return response()->json($this->responseMsg('User was successfully updated.', 'success'));
        } catch (\Throwable $th) {
            return response()->json($this->responseMsg($th->getMessage(), 'error'));
        }
    }

    public function edit(string $id)
    {
        return view('pages.user.edit-profile');
    }

    /**
     * @param Request $request
     * @param UpdateProfilePhotoAction $updateProfilePhotoAction
     *
     * @return JsonResponse
     */
    public function uploadProfilePhoto(Request $request, UpdateProfilePhotoAction $updateProfilePhotoAction): JsonResponse
    {
        // Retrieve the current profile photo path
        $previousProfilePhotoPath = auth()->user()->photo;

        if ($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid()) {
            $file = $request->file('profile_picture');

            // Generate a unique filename
            $filename = uniqid('profile_', true) . '.' . $file->extension();

            // Store the file in the storage directory with the specified filename
            $path = $file->storeAs('profile_pictures', $filename, 'public');

            // Delete the previous profile photo if it exists
            if ($previousProfilePhotoPath) {
                Storage::disk('public')->delete(str_replace('storage/', '', $previousProfilePhotoPath));
            }

            // Save the file path to the user's profile_picture column
            $updateProfilePhotoAction->execute(['file' => 'storage/'.$path]);

            // Optionally, you can return a JSON response
            return response()->json($this->responseMsg('Image was successfully uploaded.', 'success'));
        }

        // Optionally, you can return a JSON response
        return response()->json('Failed to upload image.', 'error');
    }

    public function show($id)
    {
        abort(404);
    }

    /**
     * @param Request $request
     * @param CheckOldPasswordAction $checkOldPasswordAction
     *
     * @return JsonResponse
     */
    public function checkOldPassword(Request $request, CheckOldPasswordAction $checkOldPasswordAction): JsonResponse
    {
        $data = [
            'user_id' => $request['user_id'],
            'password' => $request['old_password'],
        ];
        $isSame = $checkOldPasswordAction->execute($data);
        return response()->json($isSame);
    }

    /**
     * @param string $id
     * @param Request $request
     * @param UpdatePasswordAction $updatePaswordAction
     *
     *@return JsonResponse
     */
    public function updatePassword(string $id, Request $request, UpdatePasswordAction $updatePaswordAction): JsonResponse
    {
        try {
            $updatePaswordAction->execute($id, $request->all());
            return response()->json($this->responseMsg('Password was successfully updated.', 'success'));
        } catch (\Throwable $th) {
            return response()->json($this->responseMsg($th->getMessage(), 'error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, DeleteUserAction $deleteUserAction): JsonResponse
    {
        $deleteUserAction->execute($id);
        return response()->json($this->responseMsg('User was successfully deleted.', 'success'));
    }

    private function responseMsg($msg, $status): array
    {
        return [
            'message' => $msg,
            'status' => $status,
        ];
    }
}
