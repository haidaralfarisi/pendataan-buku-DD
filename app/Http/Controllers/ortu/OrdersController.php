<?php

namespace App\Http\Controllers\ortu;

use App\Http\Controllers\Controller;
use App\Models\Books;
use App\Models\OrderDetails;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'selected_books' => 'required|array|min:1',
            'selected_books.*' => 'exists:books,id'
        ]);

        $user = Auth::user();
        $books = Books::whereIn('id', $request->selected_books)->get();

        $order = Orders::create([
            'user_id' => $user->id,
            'total_books' => $books->count(),
            'total_price' => $books->sum('price'),
            'status' => 'pending',
        ]);

        // Simpan ke order_details sekaligus
        $orderDetails = $books->map(function ($book) use ($order) {
            return [
                'order_id' => $order->id,
                'book_id' => $book->id,
                'quantity' => 1, // default
                'price_each' => $book->price,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        OrderDetails::insert($orderDetails);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    public function show($id)
    {
        $order = Orders::with('details.book')->findOrFail($id);

        // Hitung total jumlah buku
        $totalBooks = $order->details->sum('quantity');

        return view('ortu.orders.show', compact('order', 'totalBooks'));
    }


    // Update jumlah item
    public function updateQuantity(Request $request, $orderId, $detailId)
    {
        $detail = OrderDetails::where('order_id', $orderId)
            ->where('id', $detailId)
            ->firstOrFail();

        $newQuantity = max(1, (int) $request->input('quantity')); // minimal 1
        $detail->quantity = $newQuantity;
        $detail->subtotal = $detail->price * $newQuantity;
        $detail->save();

        // Update total order
        $this->updateOrderTotal($orderId);

        return redirect()->route('orders.show', $orderId)
            ->with('success', 'Jumlah item berhasil diperbarui.');
    }

    // Hapus item dari order
    public function deleteItem($orderId, $detailId)
    {
        $order = Orders::findOrFail($orderId);
        $detail = $order->details()->findOrFail($detailId);

        // Kurangi total harga
        $order->total_price -= ($detail->price_each * $detail->quantity);
        $order->save();

        // Hapus detail pesanan
        $detail->delete();

        return redirect()->back()->with('success', 'Buku berhasil dihapus dari pesanan.');
    }


    // Helper: update total harga order
    private function updateOrderTotal($orderId)
    {
        $order = Orders::with('details')->findOrFail($orderId);
        $order->total_price = $order->details->sum('subtotal');
        $order->save();
    }

    public function cancel(Orders $order)
    {
        // Hapus semua detail terkait
        $order->details()->delete();

        // Hapus order
        $order->delete();

        return redirect()->route('ortu.books.index')->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
