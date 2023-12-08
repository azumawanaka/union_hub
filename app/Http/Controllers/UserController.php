<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
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

        $query = User::select(
            'users.id as u_id',
            \DB::raw("CONCAT(users.first_name, ' ', users.last_name) as full_name"),
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
                    ->orWhere('users.email', 'like', '%' . $search['value'] . '%')
                    ->orWhere('users.address', 'like', '%' . $search['value'] . '%')
                    ->orWhere('users.mobile', 'like', '%' . $search['value'] . '%')
                    ->orWhere('users.gender', 'like', '%' . $search['value'] . '%')
                    ->orWhere('users.role', 'like', '%' . $search['value'] . '%')
                    ->orWhere('users.created_at', 'like', '%' . $search['value'] . '%')
                    ->orWhere(function ($query) use ($search) {
                        $query->where(\DB::raw("CONCAT(users.first_name, ' ', users.last_name)"), 'like', '%' . $search['value'] . '%');
                    });
            });
        }
    }

    public function getUserById(string $id)
    {
        //
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
     * @return mixed
     */
    public function updateUser(Request $request, string $id)
    {
       //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
