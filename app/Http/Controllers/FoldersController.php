<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Folder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class FoldersController extends Controller
{
    public function __construct()
    {
        // Temporarily disable auth for testing
        // $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the folders.
     */
    public function index(Request $request)
    {
        try {
            // Simplified query to isolate the issue
            $folders = Folder::all();
            
            return response()->json([
                'folders' => $folders,
                'count' => $folders->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch folders',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created folder in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'parent_folder_id' => 'nullable|exists:folders,id',
        //     'department_id' => 'required|exists:departments,id',
        // ]);

        $folder = Folder::create([
            'name' => $request->name,
            'parent_folder_id' => $request->parent_folder_id,
            'department_id' => Auth::user()->department_id,
            'created_by' => Auth::user()->id,
        ]);

        return response()->json([
            'message' => 'Folder created successfully',
            'folder' => Auth::user()->deparment_id,
        ], 201);
    }

    /**
     * Display the specified folder.
     */
    public function show(Folder $folder)
    {
        $folder->load(['department', 'creator', 'parentFolder', 'childFolders', 'documents']);

        return response()->json([
            'folder' => $folder
        ]);
    }

    /**
     * Update the specified folder in storage.
     */
    public function update(Request $request, Folder $folder)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_folder_id' => [
                'nullable',
                'exists:folders,id',
                Rule::notIn([$folder->id]), // Prevent self-reference
            ],
            'department_id' => 'required|exists:departments,id',
        ]);

        $folder->update([
            'name' => $request->name,
            'parent_folder_id' => $request->parent_folder_id,
            'department_id' => $request->department_id,
        ]);

        return response()->json([
            'message' => 'Folder updated successfully',
            'folder' => $folder->load(['department', 'creator', 'parentFolder'])
        ]);
    }

    /**
     * Remove the specified folder from storage.
     */
    public function destroy(Folder $folder)
    {
        // Check if folder has child folders or documents
        if ($folder->childFolders()->count() > 0) {
            return response()->json([
                'message' => 'Cannot delete folder with subfolders',
                'error' => 'has_child_folders'
            ], 422);
        }

        if ($folder->documents()->count() > 0) {
            return response()->json([
                'message' => 'Cannot delete folder with documents',
                'error' => 'has_documents'
            ], 422);
        }

        $folder->delete();

        return response()->json([
            'message' => 'Folder deleted successfully'
        ]);
    }

    /**
     * Get folder tree structure
     */
    public function tree(Request $request)
    {
        $departmentId = Auth::user()->deparment_id;
        
        $query = Folder::with(['childFolders' => function($query) {
            $query->with(['childFolders']);
        }]);

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        $rootFolders = $query->whereNull('parent_folder_id')->get();

        return response()->json([
            'folders' => $rootFolders
        ]);
    }
}
