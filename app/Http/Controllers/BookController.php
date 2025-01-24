<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    public function update(Request $request, $id)
    {
    $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'year_published' => 'required|integer',
        'description' => 'required|string',
    ]);

    $book = Book::findOrFail($id);
    $book->title = $request->input('title');
    $book->author = $request->input('author');
    $book->year_published = $request->input('year_published');
    $book->description = $request->input('description');
    $book->save();

    return redirect()->back()->with('success', 'Book updated successfully.');
    }


    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'year_published' => 'required|integer', // Ensure 'year_published' is provided and is an integer
        ]);

        // Create a new book record
        Book::create($validated);

        // Redirect or return response
        return redirect()->route('books.index')->with('success', 'Book created successfully!');
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}