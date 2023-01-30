<?php

namespace App\Http\Controllers\security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $permisos = Permission::with('roles')->get();
        $roles = Role::active()->pluck('name');
        return inertia('security/Permisos', ['permisos' => $permisos, 'roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:roles,name|min:4',
        ]);

        
        $permiso = Permission::create(['guard_name' => 'web', 'name' => $validateData['name']]);

        if($request->roles != null){
            $roles = Role::whereIn('name', $request->roles)->get();
            $permiso->syncRoles($roles);
        }
       
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permiso = Permission::whereId($id)->first();
        $permiso->name = $request->name;
        if($request->roles != null){
            $roles = Role::whereIn('name', $request->roles)->get();
            $permiso->syncRoles($roles);
        }
        $permiso->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function quitarRol(Permission $permiso , Role $rol){
        $rol->revokePermissionTo($permiso->name);
        return back();
    }
}
