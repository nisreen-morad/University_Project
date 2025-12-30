<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request) {
    // 1. قراءة البيانات من الملفات (للمحاكاة)
    $rooms = json_decode(file_get_contents(storage_path('app/integration/rooms.json')), true)['data'];
    $staff = json_decode(file_get_contents(storage_path('app/integration/staff.json')), true)['data'];

    // 2. التحقق هل الغرفة موجودة؟
    $roomExists = collect($rooms)->firstWhere('id', $request->room_id);
    if (!$roomExists) return response()->json(['error' => 'المعمل غير موجود'], 404);

    // 3. التحقق من تضارب الوقت (Conflict Logic)
    $conflict = \App\Models\Booking::where('room_id', $request->room_id)
        ->where(function($q) use ($request) {
            $q->whereBetween('start_time', [$request->start_time, $request->end_time])
              ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
        })->exists();

    if ($conflict) {
        return response()->json(['error' => 'هذا المعمل محجوز في هذا الوقت!'], 422);
    }

    // 4. حفظ الحجز
    $booking = \App\Models\Booking::create($request->all());
    return response()->json(['message' => 'تم الحجز بنجاح', 'data' => $booking], 201);
}
}
