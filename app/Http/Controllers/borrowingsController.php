<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Book;
use\App\Models\Borrowing;

class borrowingsController extends Controller
{
    // عرض الكتب التي استعارها العميل المسجل حالياً
    public function index()
    {
        $user = auth()->user();
        return response()->json(["data" => $user->books]);
    }

    // طلب استعارة كتاب جديد من قبل العميل
    public function borrow(Request $request)
{
    // المهمة 3: التحقق من صحة التواريخ
    $data = $request->validate([
        "book_id"        => ["required", "exists:books,id"],
        "borrowing_date" => ["required", "date", "after_or_equal:today"],
        "return_date"    => ["required", "date", "after:borrowing_date"]
    ]);

    // المهمة 4: التأكد أن الكتاب غير مستعار من شخص آخر في نفس التواريخ
    $isTaken = Book::find($data["book_id"])->customers()
        ->wherePivot("is_returned", false)
        ->wherePivot("borrowing_date", "<=", $data["return_date"])
        ->wherePivot("return_date", ">=", $data["borrowing_date"])
        ->exists();

    if ($isTaken) {
        return response()->json([
            "message" => "This book is already borrowed on these dates"
        ], 422);
    }

    // المهمة 5: التأكد أن العميل ليس لديه 3 استعارات مفتوحة حالياً
    $openCount = auth()->user()->books()
        ->wherePivot("is_returned", false)
        ->count();

    if ($openCount >= 3) {
        return response()->json([
            "message" => "You cannot have more than 3 open borrowings at the same time"
        ], 422);
    }

    // تنفيذ الاستعارة بعد اجتياز كل الشروط
    auth()->user()->books()->attach(
        $data["book_id"],
        [
            "borrowing_date" => $data["borrowing_date"],
            "return_date"    => $data["return_date"],
            "is_returned"    => false
        ]
    );

    return response()->json(['message' => 'Book borrowed successfully'], 201);
}

    // إلغاء/حذف سجل استعارة من قبل العميل
    public function destroy($id)
    {
        $user = auth()->user();
        $user->books()->detach($id);
        return response()->json(['message' => 'done']);
    }

    // تأكيد إرجاع الكتاب (خاص بالموظفين فقط)
    public function markAsReturned(Request $request)
    {
        $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'book_id'     => ['required', 'exists:books,id'],
        ]);

        $customer = Customer::find($request->customer_id);
        
        $borrowing = $customer->books()
            ->wherePivot('book_id', $request->book_id)
            ->wherePivot('is_returned', false)
            ->first();

        if (!$borrowing) {
            return response()->json([
                'message' => 'This customer has no open borrowing for this book'
            ], 404);
        }

        $customer->books()
            ->wherePivot('is_returned', false)
            ->updateExistingPivot($request->book_id, [
                'is_returned' => true,
            ]);

        return response()->json([
            'message'        => 'Book marked as returned',
            'customer_id'    => $customer->id,
            'book_id'        => $borrowing->id,
            'borrowing_date' => $borrowing->pivot->borrowing_date,
        ]);
    }
    public function all(Request $request)
    {
        $query = Borrowing::with(["customer", "book"]);

        if ($request->has("is_returned")) {
        $query->where("is_returned", $request->is_returned);
    }

    return response()->json($query->get());
    }
}
