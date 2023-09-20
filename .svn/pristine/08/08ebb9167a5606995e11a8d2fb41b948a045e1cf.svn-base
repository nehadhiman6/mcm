<?php

namespace App\Http\Controllers;

use App\PuPaper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PuPaperController extends Controller
{
    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('paper.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $std = PuPaper::where('college_roll', $request->college_roll)
            ->where('token', $request->token)
            ->first();

        if (!$std) {
            return "Invalid Request";
        }

        if (! Storage::exists($request->file_path)) {
            return "File not found!";
        }

        $path = storage_path("app/") . $request->file_path;
        // return $path;
        return response()->download($path);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PuPaper  $puPaper
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $college_roll)
    {
        $this->validate($request, [
            'college_roll' => "required|numeric",
            'pu_roll' => "required|numeric|exists:yearly_db.pu_papers,pu_roll,college_roll," . $college_roll,
        ], [
            'pu_roll.exists' => 'The selected pu roll is invalid or it does not match with the entered college roll number!'
        ]);

        $std = PuPaper::where('college_roll', $college_roll)
            ->where('pu_roll', $request->pu_roll)
            ->first();

        $files = Storage::files('papers/' . $std->class_folder);

        $token = str_random(32);
        $std->token = $token;
        $std->save();

        return reply("OK", [
            'student_det' => $std,
            'files' => $files
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PuPaper  $puPaper
     * @return \Illuminate\Http\Response
     */
    public function edit(PuPaper $puPaper)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PuPaper  $puPaper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PuPaper $puPaper)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PuPaper  $puPaper
     * @return \Illuminate\Http\Response
     */
    public function destroy(PuPaper $puPaper)
    {
        //
    }
}
