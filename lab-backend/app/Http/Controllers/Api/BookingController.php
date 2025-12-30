<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking; // تأكدي من استدعاء الموديل هنا

class BookingController extends Controller
{
    public function store(Request $request) {
        // 1. قراءة البيانات من الملفات (بعد نقل المجلد للمجلد الرئيسي)
        // استخدمنا base_path لأن المجلد أصبح خارج storage
        $roomsPath = base_path('integration/rooms.json');
        $staffPath = base_path('integration/staff.json');

        // التأكد من وجود الملفات لتجنب الأخطاء
        if (!file_exists($roomsPath) || !file_exists($staffPath)) {
            return response()->json(['error' => 'ملفات البيانات غير موجودة في المسار الجديد'], 500);
        }

        $rooms = json_decode(file_get_contents($roomsPath), true)['data'];
        $staff = json_decode(file_get_contents($staffPath), true)['data'];

        // 2. التحقق هل الغرفة موجودة؟
        $roomExists = collect($rooms)->firstWhere('id', $request->room_id);
        if (!$roomExists) {
            return response()->json(['error' => 'المعمل غير موجود'], 404);
        }

        // التحقق هل الموظف/الدكتور موجود؟ (إضافة لزيادة الدقة)
        $staffExists = collect($staff)->firstWhere('id', $request->staff_id);
        if (!$staffExists) {
            return response()->json(['error' => 'بيانات المحاضر غير صحيحة'], 404);
        }

        // 3. التحقق من تضارب الوقت (Conflict Logic)
        $conflict = Booking::where('room_id', $request->room_id)
            ->where(function($q) use ($request) {
                $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                  ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
            })->exists();

        if ($conflict) {
            return response()->json(['error' => 'هذا المعمل محجوز في هذا الوقت!'], 422);
        }

        // 4. حفظ الحجز
        $booking = Booking::create([
            'staff_id'   => $request->staff_id,
            'room_id'    => $request->room_id,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
            'status'     => 'pending' // أو 'confirmed' حسب نظامكم
        ]);

        return response()->json(['message' => 'تم الحجز بنجاح', 'data' => $booking], 201);
    }
}
