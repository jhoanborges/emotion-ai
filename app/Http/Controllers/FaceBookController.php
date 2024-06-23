<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Http;
use App\Models\SocialData;

class FaceBookController extends Controller
{
    /**
     * Login Using Facebook
     */
    public function loginUsingFacebook()
    {
        return Socialite::driver('facebook')->stateless()
            ->scopes([
                'email',
                'user_photos',
                'user_friends',
                'user_gender',
                'user_birthday',
                'user_hometown',
                'user_likes',
                'user_link',
                'user_location',
                'user_videos'
            ])
            ->redirect();
    }

    public function callbackFromFacebook()
    {
        try {
            $user = Socialite::driver('facebook')->stateless()->user();

            $saveUser = User::updateOrCreate([
                'facebook_id' => $user->getId(),
            ], [
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => Hash::make($user->getName() . '@' . $user->getId()),
                'facebook_token' => $user->token, // Save the token
            ]);

            //Auth::loginUsingId($saveUser->id);
            Auth::login($saveUser);

            return redirect()->route('dashboard');
        } catch (\Throwable $th) {
            throw $th;
        }
    }




    public function fetchFacebookPosts()
    {
        $user = Auth::user();

        if (!$user->facebook_token) {
            return redirect()->route('dashboard')->withErrors(['msg' => 'No Facebook token found.']);
        }

        try {
            // Check if there is existing social data for the user
            $socialData = SocialData::where('user_id', $user->id)->first();
            if ($socialData && count($socialData->data) > 0) {
                // Use existing data from database if it's valid JSON

                $posts = $socialData->data;
            } else {
                // Fetch new data from Facebook API
                $posts = $this->fetchPostsFromFacebook($user->facebook_token);

                // Save fetched data as JSON in the database
                if ($socialData) {
                    $socialData->update(['data' => $posts]);
                } else {
                    SocialData::create([
                        'user_id' => $user->id,
                        'data' => $posts,
                    ]);
                }
            }
            return view('layouts.posts', compact('posts'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->withErrors(['msg' => 'Exception occurred: ' . $e->getMessage()]);
        }
    }

    private function fetchPostsFromFacebook($accessToken)
    {
        $posts = [];
        $limit = 100; // Desired number of posts to fetch (up to the API limit)
        $url = 'https://graph.facebook.com/v20.0/me/feed';

        try {
            $params = [
                'access_token' => $accessToken,
                'fields' => 'id,name,description,full_picture,video_buying_eligibility',
                'limit' => $limit,
            ];

            $response = Http::get($url, $params);

            if ($response->successful()) {
                $data = $response->json();

                // Check if 'data' exists in the response
                if (isset($data['data'])) {
                    $posts = $data['data'];
                }

                return $posts;
            } else {
                throw new \Exception('Failed to fetch Facebook posts: ' . $response->body());
            }
        } catch (\Exception $e) {
            throw new \Exception('Failed to fetch Facebook posts: ' . $e->getMessage());
        }
    }
}
