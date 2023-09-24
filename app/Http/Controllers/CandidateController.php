<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidateRequest;
use Illuminate\Support\Facades\Cache;
use App\Models\Candidate;

class CandidateController extends Controller
{
   public function index(){

        $candidates = Cache::remember('candidates', 60, function () {
            if (auth()->user()->role === Candidate::MANAGER) {
                return Candidate::all();
            } else {
                return Candidate::where('owner', auth()->user()->id)->get();
            }
        });
        
        $response = [
            'meta' => [
                'success' => true,
                'errors' => [],
            ],
            'data' => $candidates,
        ];

        return response()->json($response, 200);
    }

    public function store(CandidateRequest $request)
    {

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
