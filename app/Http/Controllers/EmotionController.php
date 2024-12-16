<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EmotionController extends Controller
{
    public function processEmotion(Request $request)
    {
        $image = $request->input('image'); // Terima gambar dalam format Base64

        // Kirim gambar ke API Flask untuk analisis
        $response = Http::post('http://127.0.0.1:5000/processEmotion', [
            'image' => $image,
        ]);

        // Ambil hasil deteksi emosi dari API Flask
        $emotion = $response->json()['emotion'];

        // (Opsional) Simpan ke database
        // DB::table('emotions')->insert([
        //     'user_id' => auth()->id(),
        //     'emotion' => $emotion,
        //     'created_at' => now(),
        // ]);

        return response()->json(['emotion' => $emotion]);
    }
}
