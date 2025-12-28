<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lab; // استيراد الموديل
use Illuminate\Http\Request;

class LabController extends Controller
{
    public function index()
    {
        // جلب كل المختبرات من قاعدة البيانات الحقيقية
        return response()->json(Lab::all());
    }

// إضافة مختبر جديد
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string',
        'floor' => 'required|string',
        'status' => 'required|string',
    ]);

    $lab = Lab::create($validated);
    return response()->json($lab, 201);
}

// حذف مختبر
public function destroy($id)
{
    Lab::destroy($id);
    return response()->json(['message' => 'Lab deleted successfully']);
}

}