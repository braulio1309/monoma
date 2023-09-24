<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Candidate;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
   public function index(){

        if (auth()->user()->role === Candidate::MANAGER) {
            $candidates = Candidate::all();
        } else {
            $candidates = Candidate::where('owner', auth()->user()->id)->get();
        }

        $response = [
            'meta' => [
                'success' => true,
                'errors' => [],
            ],
            'data' => $candidates,
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'source' => 'required|string',
            'owner' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'meta' => [
                    'success' => false,
                    'errors' => $validator->errors()->all(),
                ],
            ], 400); 
        }

        $candidate = Candidate::create([
            'name' => $request->input('name'),
            'source' => $request->input('source'),
            'owner' => $request->input('owner'),
            'created_by' => auth()->user()->id, 
        ]);

        return response()->json([
            'meta' => [
                'success' => true,
                'errors' => [],
            ],
            'data' => $candidate,
        ], 201); 
    }

    public function show($id)
    {
        $candidate = Candidate::find($id);

        if (!$candidate) {
            return response()->json([
                'meta' => [
                    'success' => false,
                    'errors' => ['No lead found'],
                ],
            ], 404); 
        }

        return response()->json([
            'meta' => [
                'success' => true,
                'errors' => [],
            ],
            'data' => $candidate,
        ], 200); 
    }
}
