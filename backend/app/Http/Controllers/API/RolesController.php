<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Roles::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $roles = Roles::create($input);
        return $roles;
    }

    /**
     * Display the specified resource.
     */
    public function show(Roles $roles)
    {
        return $roles;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Roles $roles)
    {
        $input = $request->all();
        $roles = Roles::update($input);
        return $roles;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Roles $roles)
    {
        $roles->delete();
        return response()->json(['message' => 'Roles deleted']);
    }
}
