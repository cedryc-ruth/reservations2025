<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('user.index',[
            'users'=>$users,
            
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|max:60',
            'lastname' => 'required|max:60',
            'email' => 'required|max:60',
            'password'=>'required|max:60',
            'langue' => 'max:60',
        ]);
        //Le formulaire a été validé, nous créons un nouvel utilisateur  à insérer
        $user = new User();

        //Assignation des données et sauvegarde dans la base de données
        $user->firstname = $validated['firstname'];
        $user->lastname = $validated['lastname'];
        $user->password = $validated['password'];
        $user->email = $validated['email'];
        $user->langue = $validated['langue'];
        $user->save();

        return redirect()->route('user.index');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        
        return view('user.show',[
            'user' => $user,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        
        return view('user.edit',[
                    'user' => $user,
        ]);
    }


 

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //Validation des données du formulaire
        $validated = $request->validate([
            'firstname' => 'required|max:60',
            'lastname' => 'required|max:60',
            'langue' => 'required|max:2',
        ]);
        //Le formulaire a été validé, nous récupérons l’artiste à modifier
        $user = User::find($id);

	   //Mise à jour des données modifiées et sauvegarde dans la base de données
        $user->update($validated);

        return view('user.show',[
            'user' => $user,
        ]);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = user::find($id);

        if($user) {
            $user->delete();
        }

        return redirect()->route('user.index');
    }


   
}
