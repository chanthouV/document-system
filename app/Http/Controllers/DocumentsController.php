<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DocumentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of documents.
     */
    public function index(Request $request)
    {
        // try {
        //     $query = Document::with(['folder', 'user', 'department']);

        //     // Filter by folder if provided
        //     if ($request->has('folder_id')) {
        //         $query->where('folder_id', $request->folder_id);
        //     }

        //     // Filter by department if provided
        //     if ($request->has('department_id')) {
        //         $query->where('department_id', $request->department_id);
        //     }

        //     // Filter by status if provided
        //     if ($request->has('status')) {
        //         $query->where('status', $request->status);
        //     }

        //     // Search by name if provided
        //     if ($request->has('search')) {
        //         $query->where('name', 'like', '%' . $request->search . '%');
        //     }

        //     $documents = $query->orderBy('created_at', 'desc')->get();

        //     return response()->json([
        //         'documents' => $documents,
        //         'count' => $documents->count()
        //     ]);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'error' => 'Failed to fetch documents',
        //         'message' => $e->getMessage()
        //     ], 500);
        // }
        return response()->json([
            'message' => 'Test successful'
        ]);
    }

    /**
     * Store a newly created document in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'file' => 'required|file|max:10240', // Max 10MB
        //     'folder_id' => 'nullable|exists:folders,id',
        //     'department_id' => 'required|exists:departments,id',
        //     'status' => 'nullable|in:active,archived,deleted',
        // ]);

        try {
            // if ($request->hasFile('file')) {
            //     $file = $request->file('file');
            //     $fileName = time() . '_' . $file->getClientOriginalName();
            //     $filePath = $file->storeAs('documents', $fileName, 'public');
                
            //     $document = Document::create([
            //         'name' => $request->name,
            //         'file_path' => $filePath,
            //         'file_size' => $file->getSize(),
            //         'file_type' => $file->getClientMimeType(),
            //         'status' => $request->status ?? 'active',
            //         'folder_id' => $request->folder_id,
            //         'department_id' => $request->department_id,
            //         'user_id' => Auth::user()->id,
            //     ]);

            //     return response()->json([
            //         'message' => 'Document uploaded successfully',
            //         'document' => $document->load(['folder', 'user', 'department'])
            //     ], 201);
            // }

            return response()->json([
                'error' => 'No file provided'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to upload document',
                // 'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified document.
     */
    public function show(Document $document)
    {
        $document->load(['folder', 'user', 'department']);

        return response()->json([
            'document' => $document
        ]);
    }

    /**
     * Update the specified document in storage.
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'folder_id' => 'nullable|exists:folders,id',
            'department_id' => 'required|exists:departments,id',
            'status' => 'nullable|in:active,archived,deleted',
        ]);

        try {
            $document->update([
                'name' => $request->name,
                'folder_id' => $request->folder_id,
                'department_id' => $request->department_id,
                'status' => $request->status ?? $document->status,
            ]);

            return response()->json([
                'message' => 'Document updated successfully',
                'document' => $document->load(['folder', 'user', 'department'])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update document',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy(Document $document)
    {
        try {
            // Delete file from storage
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            // Delete database record
            $document->delete();

            return response()->json([
                'message' => 'Document deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete document',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download the specified document.
     */
    public function download(Document $document)
    {
        try {
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                $filePath = Storage::disk('public')->path($document->file_path);
                
                return response()->download($filePath, $document->name);
            }

            return response()->json([
                'error' => 'File not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to download document',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get documents by folder
     */
    public function getByFolder($folderId)
    {
        try {
            $documents = Document::where('folder_id', $folderId)
                ->with(['folder', 'user', 'department'])
                ->orderBy('name')
                ->get();

            return response()->json([
                'documents' => $documents,
                'count' => $documents->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch documents',
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
