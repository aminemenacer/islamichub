<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpamReport;

class SpamReportController extends Controller
{
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'report_type' => 'required',
            'details' => 'required'
        ]);

        // Create a new spam report
        SpamReport::create([
            'report_type' => $request->input('report_type'),
            'details' => $request->input('details')
        ]);

        // Return a success response
        return response()->json(['message' => 'Report submitted successfully']);
    }

}
