<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; 
class BrancardierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        return DB::select("select DISTINCT users.id,
        users.name,
        users.nom,
        users.prenom,
        users.tel,
        users.email,
        users.password,
        users.metier from users 
        join user_role on users.id = user_role.user_id 
        join roles on roles.id = user_role.role_id where user_role.role_id <> 6 and users.deleted_at is NULL and users.metier != 'Sans'");
    }
    public function index2()
    {
      
        return DB::select("select DISTINCT users.id,
        users.name,
        users.nom,
        users.prenom,
        users.tel,
        users.email,
        users.photo,
        users.cin,
        users.age,
        users.sexe,
        users.metier,
        users.ppr,   
        users.poste_en_interne,
        users.temporaire,
        users.password from users 
        join user_role on users.id = user_role.user_id 
        join roles on roles.id = user_role.role_id where user_role.role_id = 5 and users.deleted_at is NULL and users.metier = 'brancardier'");
    }
    
    public function index3()
    {
      
        return DB::select("select DISTINCT users.id,
        users.name,
        users.nom,
        users.prenom,       
        users.email,
        users.password,
        users.metier from users     
        join user_role on users.id = user_role.user_id 
        join roles on roles.id = user_role.role_id where user_role.role_id = 6 and users.deleted_at is NULL and users.metier = 'Sans'");
    }

    public function index4($id)
    {
     $bran =User::findOrFail($id);
      return $bran->profile;   
    }
    public function index5($id)
    {
     return User::findOrFail($id);
       
    }

    public function profileAuth()
    {

        return $user = Auth::user();
   
    }
    public function updateProfile($request, $id)
    {
        $bran =User::findOrFail($id);
      $profil = $bran->profile;
      $profil->update($request->all());   

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request['photo']!='profile.png')
 
           { $name = time().'.' . explode('/', explode(':', substr($request['photo'], 0, strpos($request['photo'], ';')))[1])[1];
 
            \Image::make($request['photo'])->save(public_path('img/profile/').$name);
            $request->merge(['photo' => $name]);}

            
            $this->validate($request, [
            'name' =>  'required|string|max:191',
            'email' =>  'required|string||email|max:191|unique:users',
            'password' =>  'required|string|min:8',
            'age' => 'required|integer|max:100|min:18',
            'sexe' => 'required',
            'ppr' => 'required',
            'nom' => 'required',
            'prenom' => 'required',
            'tel' => 'required',
            'poste_en_interne' => 'required',
            ]);
        
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],   
            'password' => Hash::make($request['password']),
        ]);

        $bran =User::where('email',$request['email'])->first();
        $bran->age=$request['age'];
        $bran->poste_en_interne=$request['poste_en_interne'];
        $bran->temporaire=$request['temporaire'];
        $bran->ppr=$request['ppr'];
        $bran->sexe=$request['sexe'];
        $bran->metier='brancardier';
        $bran->nom=$request['nom'];
        $bran->prenom=$request['prenom'];
        $bran->tel=$request['tel'];
        $bran->photo=$request['photo'];
        $bran->save();
        $bran->roles()->attach(Role::where('name','brancardier')->first());

    }
    public function storeUser(Request $request)
    {         
            $this->validate($request, [
            'name' =>  'required|string|max:191',
            'email' =>  'required|string||email|max:191|unique:users',
            'password' =>  'required|string|min:8',
            'metier' => 'required',
            ]);
        
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],   
            'password' => Hash::make($request['password']),
        ]);

        $user =User::where('email',$request['email'])->first();
        $user->metier=$request['metier'];
        $user->nom=$request['nom'];
        $user->prenom=$request['prenom'];
        $user->save();
        if($request['metier']==='brancardier')
        $user->roles()->attach(Role::where('name','brancardier')->first());
        else if($request['metier']==='major')
        $user->roles()->attach(Role::where('name','major')->first());
        else if($request['metier']==='admin')
        $user->roles()->attach(Role::where('name','admin')->first());
        else if($request['metier']==='demandeur')
        $user->roles()->attach(Role::where('name','demandeur')->first());
        else if($request['metier']==='coordinateur')
        $user->roles()->attach(Role::where('name','coordinateur')->first());
        else
        $user->roles()->attach(Role::where('name','not_active')->first());

    }
    public function updateUser2(Request $request,$id)
    {       
        $user =User::findOrFail($id);  
            $this->validate($request, [
            'name' =>  'required|string|max:191',
            'email' =>  'required|string||email|max:191|unique:users,email,'.$user->id,
            'password' =>  'required|string|min:8',
            'metier' => 'required',
            ]);
              
        $user->metier=$request['metier'];
        $user->name=$request['name'];
        $user->email=$request['email'];
        $user->password=Hash::make($request['password']);
        $user->save();
        if($request['metier']==='brancardier')
        $user->roles()->attach(Role::where('name','brancardier')->first());
        else if($request['metier']==='major')
        $user->roles()->attach(Role::where('name','major')->first());
        else if($request['metier']==='admin')
        $user->roles()->attach(Role::where('name','admin')->first());
        else if($request['metier']==='demandeur')
        $user->roles()->attach(Role::where('name','demandeur')->first());
        else if($request['metier']==='coordinateur')
        $user->roles()->attach(Role::where('name','coordinateur')->first());
        else
        $user->roles()->attach(Role::where('name','not_active')->first());

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
    public function updateUser(Request $request, $id)
    {
        //return ['message' => 'update bran'];
       $bran =User::findOrFail($id);
       $currentPhoto = $bran->photo;


       if($request['photo'] != $currentPhoto){
           $name = time().'.' . explode('/', explode(':', substr($request['photo'], 0, strpos($request['photo'], ';')))[1])[1];

           \Image::make($request['photo'])->save(public_path('img/profile/').$name);
           $request->merge(['photo' => $name]);

           $userPhoto = public_path('img/profile/').$currentPhoto;
           if(file_exists($userPhoto)){
               @unlink($userPhoto);
           }
        }

       $this->validate($request, [
        'name' =>  'required|string|max:191',
        'email' =>  'required|string||email|max:191|unique:users,email,'.$bran->id,
        'password' =>  'sometimes|min:8',
        'age'=>'required',
        'metier'=>'required',
        ]);     
        $bran->name=$request['name'];
        $bran->email=$request['email'];
        $bran->password=Hash::make($request['password']);
        $bran->age=$request['age'];
        $bran->poste_en_interne=$request['poste_en_interne'];
        $bran->temporaire=$request['temporaire'];
        $bran->ppr=$request['ppr'];
        $bran->sexe=$request['sexe'];
        $bran->nom=$request['nom'];
        $bran->prenom=$request['prenom'];
        $bran->tel=$request['tel'];
        $bran->photo=$request['photo'];

        if($request['metier']!= $bran->metier)
        {$bran->metier=$request['metier'];
        $bran->roles()->attach(Role::where('name',$bran->metier)->first());}

        else if($request['metier']==='Sans')
        {
            $bran->metier=$request['metier'];
            $bran->roles()->attach(Role::where('name','not_active')->first());   
        }
        else{
            $bran->metier=$request['metier'];
        }

        $bran->save();
      // return ['message' => 'update bran'+$request['age']];
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
