<?php

namespace App\Http\Controllers;

use App\Models\CallLog;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CallController extends Controller
{
    public function calls(Contact $contact)
    {
        $status = ['Completed', 'Missed'][rand(0, 1)];
        $duration = rand(30, 300); // 30 sec to 5 mins

        $log = CallLog::create([
            'contact_id' => $contact->id,
            'duration' => $duration,
            'status' => $status,
        ]);

        return response()->json(['data'=>$log]);;
    }

    public function logs(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        $query = CallLog::with('contact');

       
        if ($request->start_date && $request->end_date) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [$request->start_date, $request->end_date]);
        }

        if ($request->contact) {
            $query->where('name', 'like', "%{$request->contact}%");
        }
        
        $log = $query->latest('created_at')->get();
        return response()->json(['data'=>$log]);
    }

}
