<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::select('id', 'name', 'phone', 'company', 'role','favorite');

        if ($request->company) {
            $query->where('company', 'like', "%{$request->company}%");
        }

        if ($request->role) {
            $query->where('role', $request->role);
        }

        return response()->json($query->get());
    }

    public function favorite(Request $request)
    {
        $validated = $request->validate([
            'contact_id' => 'required|uuid|exists:contacts,id',
            'favorite' => 'required|boolean',
        ]);

        $contact = Contact::findOrFail($validated['contact_id']);
        $contact->favorite = $validated['favorite'];
        $contact->save();
        if( $contact->save()){
            return response()->json([
             'message' => 'Favorite updated',
            ]);
        }else{
            return response()->json([
                'message' => 'update Favorite is  failed',
            ]);
        }
        
    }
}
