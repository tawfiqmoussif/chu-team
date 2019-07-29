<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;

class BrancardierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $this->validate($request, [
            'name' =>  'required|string|max:191',
            'email' =>  'required|string||email|max:191|unique:users',
            'password' =>  'required|string|min:8',
            ]);
        
        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],   
            'password' => Hash::make($request['password']),
        ]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        //return ['message' => 'update bran'];
    $bran =User::findOrFail($id);
    $this->validate($request, [
        'name' =>  'required|string|max:191',
        'email' =>  'required|string||email|max:191|unique:users,email,'.$bran->id,
        'password' =>  'sometimes|min:8',
        ]);
        $bran->update($request->all());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

      $bran =User::findOrFail($id);

        //delete bran
        $bran->delete();

        return ['message' => 'bran deleted !'];
    }
}
