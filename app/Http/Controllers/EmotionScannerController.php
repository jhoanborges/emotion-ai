<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gemini\Data\Blob;
use Gemini\Enums\MimeType;
use Gemini\Laravel\Facades\Gemini;
use App\Models\SocialData;


class EmotionScannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $file = asset('https://www.upload.ee/image/16676954/jhoanborges.jpg');

        $socialData = SocialData::where('user_id', auth()->user()->id)->first();
        $data = $socialData->data;
        return response()->json($data);

        $result = Gemini::geminiProVision()
            ->generateContent([
                'analize emotions of this user according to what it post on his social network. ',
                new Blob(
                    mimeType: MimeType::IMAGE_JPEG,
                    data: base64_encode(
                        file_get_contents($file)
                    )
                )
            ]);

        return response()->json($result->text());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
