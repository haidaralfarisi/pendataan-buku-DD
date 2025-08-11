<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\YearBook;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        $yearBooks = YearBook::all(); // ambil semua data yearbook

        $classrooms = Classroom::with('yearBook')->paginate(10); // untuk menampilkan tabel class
        return view('superadmin.classrooms.index', compact('yearBooks', 'classrooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_name' => 'required|string|max:255',
            'year_book_id' => 'required|exists:year_books,id'
        ]);

        Classroom::create([
            'class_name' => $request->class_name,
            'year_book_id' => $request->year_book_id,
        ]);

        return redirect()->back()->with('success', 'Classroom berhasil ditambahkan.');
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'class_name' => 'required|string|max:255',
            'year_book_id' => 'required|exists:year_books,id'
        ]);

        $classroom = Classroom::findOrFail($id);
        $classroom->update([
            'class_name' => $request->class_name,
            'year_book_id' => $request->year_book_id,
        ]);

        return redirect()->back()->with('success', 'Classroom berhasil diperbarui.');
    }

    // Hapus data
    public function destroy($id)
    {
        $classroom = Classroom::findOrFail($id);
        $classroom->delete();

        return redirect()->back()->with('success', 'Classroom berhasil dihapus.');
    }
}
