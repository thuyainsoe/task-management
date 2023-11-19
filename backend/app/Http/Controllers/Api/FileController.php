<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return File::query()->where('task_id', $request->task_id)->orderByDesc('created_at')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file = $request->file('file');

        $filename =  Carbon::now()->format('YmdHis') . $file->getClientOriginalName();
        Storage::putFileAs("tasks", $file, $filename);

        $filepath = Storage::path($filename);

        $data = [
            'task_id' => $request->task_id,
            'file_name' => $filename,
            'file_path' => $filepath,
            'upload_date' => Carbon::now()->format('Y-m-d H:i'),
        ];

        return File::create($data);

    }

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        //
    }

    public function download(Request $request, File $file) {
        $file = File::query()->findOrFail($request->id);

        $filename = $file->file_name;

        return Storage::download("tasks/$filename");
    }
}
