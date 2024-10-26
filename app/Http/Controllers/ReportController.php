<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Testimony;
use App\Models\Prayer;
use App\Models\Payment;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function usersReport(Request $request)
{
    $query = User::query();

    if ($request->has('search')) {
        $search = $request->input('search');
        $query->where('name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%")
              ->orWhere('user_type', 'LIKE', "%{$search}%");
    }

    $users = $query->paginate(25);

    if ($request->ajax()) {
        return response()->json([
            'html' => view('partials.users_table', compact('users'))->render(),
            'pagination' => $users->links()->render()
        ]);
    }

    return view('reports.users', compact('users'));
}

    

public function testimoniesReport(Request $request)
{
    $query = Testimony::query();

    if ($request->has('search')) {
        $search = $request->input('search');
        $query->where('testimony_type', 'LIKE', "%{$search}%")
              ->orWhere('text', 'LIKE', "%{$search}%");
    }

    $testimonies = $query->paginate(25);

    if ($request->ajax()) {
        return response()->json([
            'html' => view('partials.testimonies_table', compact('testimonies'))->render()
        ]);
    }

    return view('reports.testimonies', compact('testimonies'));
}


    public function prayersReport()
    {
        $prayers = Prayer::paginate(25);
        return view('reports.prayers', compact('prayers'));
    }

    public function paymentsReport()
    {
        $payments = Payment::paginate(25);
        return view('reports.payments', compact('payments'));
    }
}

