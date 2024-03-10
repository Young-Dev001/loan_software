<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document; // Assuming you have a Document model
use App\Models\Member;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Group;

class DocumentController extends Controller
{


    public function generatePDF()
    {
        $members = member::get();

        $data = [
            'title' => 'Welcome to Funda of Web IT - fundaofwebit.com',
            'date' => date('m/d/Y'),
            'members' => $members
        ];

        $pdf = PDF::loadView('pdf.usersPdf', $data);
        return $pdf->download('users-lists.pdf');
    }

    public function index()
    {
        $documents = Document::all();
        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.documents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        Document::create($request->all());

        return redirect()->route('documents.index')
            ->with('success', 'Document created successfully');
    }

    public function show(Document $document)
    {
        return view('admin.documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        return view('admin.documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $document->update($request->all());

        return redirect()->route('documents.index')
            ->with('success', 'Document updated successfully');
    }

    public function destroy(Document $document)
    {
        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'Document deleted successfully');
    }
}
