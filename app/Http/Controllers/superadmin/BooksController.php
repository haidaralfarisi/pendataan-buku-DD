<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\Books;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BooksController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::all(); // ambil semua data

        $books = Books::with('classroom')->paginate(10);
        return view('superadmin.books.index', compact('books', 'classrooms'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'title'        => 'required|string|max:255',
            'price'        => 'required|string', // tetap string karena kita akan format
            'classroom_id' => 'required|exists:classrooms,id',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048' // validasi gambar
        ]);

        // Bersihkan format rupiah, hanya simpan angka
        $price = preg_replace('/\D/', '', $request->price);

        // Pastikan price valid number
        if (!is_numeric($price)) {
            return redirect()->back()->withErrors(['price' => 'Harga tidak valid.']);
        }

        // Siapkan nama file image jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
        }

        // Simpan ke database
        Books::create([
            'title'        => $request->title,
            'price'        => $price,
            'classroom_id' => $request->classroom_id,
            'image'        => $imagePath,

        ]);

        return redirect()->back()->with('success', 'Book berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|string',
            'classroom_id' => 'required|exists:classrooms,id',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048' // validasi gambar

        ]);

        $price = preg_replace('/\D/', '', $request->price);

        $books = Books::findOrFail($id);

        // Simpan path gambar lama
        $imagePath = $books->image;

        // Kalau ada upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama kalau ada
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            // Simpan gambar baru
            $imagePath = $request->file('image')->store('books', 'public');
        }

        $books->update([
            'title' => $request->title,
            'price' => $price,
            'classroom_id' => $request->classroom_id,
            'image'        => $imagePath
        ]);

        return redirect()->back()->with('success', 'Book updated successfully.');
    }

    public function destroy($id)
    {
        $books = Books::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($books->image && Storage::disk('public')->exists($books->image)) {
            Storage::disk('public')->delete($books->image);
        }
        // Hapus data buku
        $books->delete();

        return redirect()->back()->with('success', 'Book deleted successfully.');
    }
}
