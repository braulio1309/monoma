<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;

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

    public function edit($id)
    {
        // Muestra el formulario para editar un candidato
    }

    public function update(Request $request, $id)
    {
        // Lógica para actualizar un candidato en la base de datos
    }

    public function destroy($id)
    {
        // Lógica para eliminar un candidato de la base de datos
    }
}
