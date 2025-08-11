<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\YearBook;
use Illuminate\Http\Request;

class YearBookController extends Controller
{
    public function index()
    {
        $yearBooks = YearBook::paginate(10); // Ini panggil model dengan benar
        return view('superadmin.year.index', compact('yearBooks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|digits:4|integer|min:2000|max:2100',
        ]);

        YearBook::create([
            'year' => $request->year,
        ]);

        return redirect()->back()->with('success', 'Year book added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'year' => 'required|digits:4|integer|min:2000|max:2100',
        ]);

        $yearBook = YearBook::findOrFail($id); // ambil data berdasarkan ID
        $yearBook->update([
            'year' => $request->year,
        ]);

        return redirect()->back()->with('success', 'Year book updated successfully.');
    }


    public function destroy($id)
    {

        $yearBook = YearBook::findOrFail($id);
        $yearBook->delete();

        return redirect()->back()->with('success', 'Year book deleted successfully.');
    }
}
