<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::select('id','name','phone','company','role');

        if ($request->company) {
            $query->where('company', 'like', "%{$request->company}%");
        }

        if ($request->role) {
            $query->where('role', $request->role);
        }

        return response()->json($query->paginate());
    }
}
