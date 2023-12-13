<?php

namespace App\Http\Controllers;

use App\Actions\DeleteUserAction;
use App\Actions\GetUserAction;
use App\Actions\StoreUserAction;
use App\Actions\UpdateUserAction;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
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
    public function getAllUsers(Request $request): JsonResponse
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $order = $request->input('order');
        $search = $request->input('search');

        $query = User::where('id', '!=', auth()->user()->id)->select(
            'users.id as u_id',
            'users.first_name as u_fn',
            'users.last_name as u_ln',
            'users.email as u_email',
            'users.address as u_address',
            'users.mobile as u_mobile',
            'users.gender as u_gender',
            'users.role as u_role',
            'users.created_at as u_created_at',
        );

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
                    ->orWhere('users.first_name', 'like', '%' . $search['value'] . '%')
                    ->orWhere('users.last_name', 'like', '%' . $search['value'] . '%')
                    ->orWhere('users.email', 'like', '%' . $search['value'] . '%')
                    ->orWhere('users.address', 'like', '%' . $search['value'] . '%')
                    ->orWhere('users.mobile', 'like', '%' . $search['value'] . '%')
                    ->orWhere('users.gender', 'like', '%' . $search['value'] . '%')
                    ->orWhere('users.role', 'like', '%' . $search['value'] . '%')
                    ->orWhere('users.created_at', 'like', '%' . $search['value'] . '%');
            });
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