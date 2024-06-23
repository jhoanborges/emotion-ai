<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\SocialData;
use OpenAI\Laravel\Facades\OpenAI;

class ChatGPTController extends Controller
{
    public function index()
    {
        $socialData = SocialData::where('user_id', auth()->user()->id)->first();
        $data = $socialData->data;

        $prompt = 'This is an array of my data. How is the user feeling accoding to his posts and images. You must return 1 possible feeling, like angry, happy, etc. ALso important to return what can i sell to this user based on hs posts and emotions. Read each image url. This is the array:' . json_encode($data);
        $result = OpenAI::chat()->create([
            'model' => 'gpt-4o',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);
        dd($result);

        return view('layouts.chatgpt.index');
    }

    public function ask(Request $request)
    {

        $prompt = $request->input('prompt');
        $response = $this->askToChatGPT($prompt);

        return view('layouts.chatgpt.response', ['response' => $response]);
    }

    private function askToChatGPT($prompt)
    {
        $socialData = SocialData::where('user_id', auth()->user()->id)->first();
        $data = $socialData->data;
        //$prompt = 'This is an array of my data. How is the user feeling accoding to his posts and images. Read each image url. ';
        $response = Http::withoutVerifying()
            ->withHeaders([
                'Authorization' => 'Bearer ' . env('CHATGPT_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/engines/text-davinci-003/completions', [
                "prompt" => $prompt,
                "max_tokens" => 1000,
                "temperature" => 0.5
            ]);

        return $response->json()['choices'][0]['text'];
    }
}
