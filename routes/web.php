<?php

use App\Http\Controllers\ProfileController;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    $user = Auth::user();

    $documents = Document::with('user')
        ->latest()
        ->get();

    if ($user && $user->isAdmin()) {
        return view('admin.dashboard', compact('documents'));
    }

    return view('welcome', compact('documents'));
})->middleware(['auth', 'verified'])->name('welcome');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->get('/documents/{document}', function (Document $document) {
    $user = Auth::user();

    
    return view('documents.show', compact('document'));
})->name('documents.show');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
    $user = Auth::user();
    if (!$user || !$user->isAdmin()) {
        abort(403);
    }

    
    $documents = Document::with('user')->orderBy('created_at', 'desc')->get();

    return view('admin.dashboard', compact('documents'));
    })->name('admin.dashboard');


    
    Route::get('/upload', function () {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }
        return view('admin.upload');
    })->name('admin.upload');

    
    Route::post('/upload', function (\Illuminate\Http\Request $request) {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403);
        }

        $request->validate([
        'title' => 'required|string|max:255',
        'type' => 'required|string|max:100',
        'content' => 'required|string',
        'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName); 
            $imagePath = 'uploads/' . $imageName; 
        }

        Document::create([
            'title' => $request->title,
            'type' => $request->type,
            'content' => $request->content,
            'image_path' => $imagePath,
            'user_id' => $user->id,
        ]); 

        return back()->with('success', 'Documento salvato correttamente!');
    });

    Route::get('/documents/{document}/edit', function (Document $document) {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        return view('admin.edit', compact('document'));
    })->name('admin.documents.edit');

    Route::put('/documents/{document}', function (\Illuminate\Http\Request $request, Document $document) {

    if (!Auth::user()->isAdmin()) {
        abort(403);
    }

    $request->validate([
        'title' => 'required|string|max:255',
        'type' => 'required|string|max:100',
        'content' => 'required|string',
        'image' => 'nullable|image|max:2048',
    ]);

    
    if ($request->hasFile('image')) {

        
        if ($document->image_path && file_exists(public_path($document->image_path))) {
            unlink(public_path($document->image_path));
        }

        $image = $request->file('image');
        $imageName = time().'_'.$image->getClientOriginalName();
        $image->move(public_path('uploads'), $imageName);

        $document->image_path = 'uploads/'.$imageName;
    }

    $document->update([
        'title' => $request->title,
        'type' => $request->type,
        'content' => $request->content,
        'image_path' => $document->image_path,
    ]);

    return redirect()->route('admin.dashboard')
        ->with('success', 'Documento modificato correttamente');

    })->name('admin.documents.update');


    Route::delete('/documents/{document}', function (Document $document) {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        if ($document->image_path) {
            Storage::delete($document->image_path);
        }

        $document->delete();

        return back()->with('success', 'Documento eliminato');
    })->name('admin.documents.destroy');
});

require __DIR__.'/auth.php';
