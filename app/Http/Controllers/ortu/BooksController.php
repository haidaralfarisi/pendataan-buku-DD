<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use App\Models\Books;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BooksController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Pastikan user punya classroom_id
        if (!$user->classroom_id) {
            // Kalau belum ada kelas, kirim pesan atau view kosong
            return view('ortu.books.index', [
                'books' => collect(), // kosong
                'classrooms' => Classroom::all(),
                'message' => 'Anda belum terhubung ke kelas mana pun.'
            ]);
        }

        // Ambil data buku yang sesuai kelas user
        $books = Books::with('classroom')
            ->where('classroom_id', $user->classroom_id)
            ->paginate(10);

        $classrooms = Classroom::all();

        return view('ortu.books.index', compact('books', 'classrooms'));
    }

    public function addToCart(Request $request)
    {
        $selectedBooks = $request->input('selected_books', []);

        // Ambil cart lama dari session
        $cart = session()->get('cart', []);

        foreach ($selectedBooks as $bookId) {
            $book = Books::find($bookId);

            if ($book) {
                // Cek apakah buku sudah ada di cart
                if (!isset($cart[$bookId])) {
                    $cart[$bookId] = [
                        'id' => $book->id,
                        'title' => $book->title,
                        'price' => $book->price,
                    ];
                }
            }
        }

        // Simpan kembali ke session
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan ke keranjang.');
    }

    public function removeFromCart(Request $request)
    {
        $bookId = $request->input('book_id');
        $cart = session()->get('cart', []);

        if (isset($cart[$bookId])) {
            unset($cart[$bookId]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Buku berhasil dihapus dari keranjang.');
    }
}
