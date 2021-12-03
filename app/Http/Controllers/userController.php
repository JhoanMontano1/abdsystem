<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class userController extends Controller
{
    //
    public function index(){
        $user=$datos['user']=User::paginate(5);
       return view('user.index',compact('user'));
    }

    public function create()
    {
        // $user=$datos['user']=User::paginate(10);

    
        return view('user.create');
    }


    public function store(Request $request)
    {
        //
        $campos=[
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'integer', 'max:1'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8']];
            $mensaje=[
                'required'=>'El :attribute esta vacio',];
                $this->validate($request,$campos,$mensaje);
       
        $datos=request()->except('_token');
        User::insert($datos);
        return redirect('user')->with('mensaje',' El usuario se ha registrado correctamente.');

    }

    public function show(User $user)
    {
        //
    }

    public function edit($id)
    {
        //
        $user=User::findOrFail($id);
        $user2=$datos['user']=User::all();
        return view('user.edit' , compact('user'));

    }


    public function update(Request $request,$id)

    {
        
         $campos=[
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'integer', 'max:1'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,id'],
            'password' => ['required', 'string', 'min:8']];
            $mensaje=[
                'required'=>'El :attribute esta vacio',];

               
                $this->validate($request,$campos,$mensaje);
                // $request['password']=Hash::make($request['password']);
        //
        $datos=request()->except(['_token','_method']);
        $datos["password"]=Hash::make($datos["password"]);
        
        User::where('id','=',$id)->update($datos);
        $user=User::findOrFail($id);
        return redirect('user')->with('mensaje','Usuario modificado correctamente');

    }


    public function destroy($id)
    {
        //

        User::destroy($id);
        return redirect('user')->with('mensaje','El usuario se ha eliminado correctamente.');
    }
}
