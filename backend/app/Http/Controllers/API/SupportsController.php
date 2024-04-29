<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Supports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role_id === 'admin') {
                $supports = Supports::all();
            } else {
                $supports = $user->support()->get();
            }

            return $supports;
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();
        $supports = $user->support()->create($input);
        return $supports;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (Auth::check()) {
            $support = Supports::find($id);
            if (!$support) {
                return response()->json(['message' => 'Support not found'], 404);
            } else {
                return $support;
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supports $supports, $id)
    {
        if (Auth::check()) {
            $input = $request->all();
            $supports = Supports::update($input);
            return $supports;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Auth::check()) {
            $support = Supports::find($id);
            if (!$support) {
                return response()->json(['message' => 'Support not found'], 404);
            }
            $support->delete();
            return response()->json(['message' => 'Support deleted']);
        }
    }
}
