<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SocialData;
use OpenAI\Laravel\Facades\OpenAI;

class Emotion extends Component
{
    public $emotionResult = null;
    public $whoYouAre = null;
    public $whatCanBeSell = null;


    // Function to filter the array
    public function filterEmptyNameOrDescription($array)
    {
        foreach ($array as $key => $item) {
            // Check if name or description is empty
            if (empty($item['name']) || empty($item['description'])) {
                // Remove the element from the array
                unset($array[$key]);
            }
        }
        return array_values($array); // Re-index the array after unset
    }


    public function fetchEmotionData()
    {

        if ($this->emotionResult !== null) {
            $this->emotionResult = $this->emotionResult;
            $this->dispatch('emotionResult', $this->emotionResult);
            return $this->emotionResult;
        }

        // Ensure the user is authenticated
        if ($user = auth()->user()) {
            $socialData = SocialData::where('user_id', $user->id)->first();
            if ($socialData) {
                $tempData = $socialData->data;
                $data = $this->filterEmptyNameOrDescription($tempData);

                $prompt = 'This is an array of my data. 
                How is the user feeling according to his posts and images. 
                You must return 1 possible feeling, like angry, happy, etc. 
                Responses must be in first person, like you telling an user how is he feeling.
                Responses must be formatted beautifully in boostrap 5 alert, styles just for the text and remove any ```html.
                This is the array:' . json_encode($data);

                $result = OpenAI::chat()->create([
                    'model' => 'gpt-4o',
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ]);
                $this->emotionResult = $result['choices'][0]['message']['content'];
                $this->dispatch('emotionResult', $result['choices'][0]['message']['content']);
            } else {
                $this->dispatch('emotionResult', 'No social data found.');
            }
        } else {
            $this->dispatch('emotionResult', 'User not authenticated.');
        }
    }



    public function whoYouAreFunction()
    {
        if ($this->whoYouAre !== null) {
            $this->whoYouAre = $this->whoYouAre;
            $this->dispatch('whoYouAre', $this->whoYouAre);
            return $this->whoYouAre;
        }


        // Ensure the user is authenticated
        if ($user = auth()->user()) {
            $socialData = SocialData::where('user_id', $user->id)->first();
            if ($socialData) {
                $tempData = $socialData->data;
                $data = $this->filterEmptyNameOrDescription($tempData);
                $fullPictures = $this->extractFullPictures($data);

                $prompt3 = 'This is an array of my data. Read each image on the array. 
                Responses must be in first person, like you telling an user how is he feeling.
                Responses must be formatted beautifully in boostrap 5 alert, styles just for the text and remove any ```html.

                And tell me who i am based on what i like.' . json_encode($fullPictures);
                $result3 = OpenAI::chat()->create([
                    'model' => 'gpt-4o',
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt3],
                    ],
                ]);

                //dd($result['choices'][0]);
                // Emit the result to the frontend
                $this->whoYouAre = $result3['choices'][0]['message']['content'];
                $this->dispatch('whoYouAre', $result3['choices'][0]['message']['content']);
            } else {
                $this->dispatch('whoYouAre', 'No social data found.');
            }
        } else {
            $this->dispatch('whoYouAre', 'User not authenticated.');
        }
    }


    public function whatCanBeSellFunction()
    {
        if ($this->whatCanBeSell !== null) {
            $this->whatCanBeSell = $this->whatCanBeSell;
            $this->dispatch('whatCanBeSell', $this->whatCanBeSell);
            return $this->whatCanBeSell;
        }


        // Ensure the user is authenticated
        if ($user = auth()->user()) {
            $socialData = SocialData::where('user_id', $user->id)->first();
            if ($socialData) {
                $tempData = $socialData->data;
                $data = $this->filterEmptyNameOrDescription($tempData);
                //second
                $prompt2 = 'This is an array of my data. Tell me what can I sell to this user based on his posts and emotions. 
                Responses must be in first person, like you telling an user how is he feeling.
                Responses must be formatted beautifully in boostrap 5 alert, styles just for the text and remove any ```html.
                At last, tell me how much aproximately i am going to spend in all that you are offering me.
                Read each image URL and determine according to the iamges what can be sold as well.' . json_encode($data);
                $result2 = OpenAI::chat()->create([
                    'model' => 'gpt-4o',
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt2],
                    ],
                ]);
                $this->whatCanBeSell = $result2['choices'][0]['message']['content'];

                // Emit the result to the frontend
                $this->whatCanBeSell = $result2['choices'][0]['message']['content'];
                $this->dispatch('whatCanBeSell', $result2['choices'][0]['message']['content']);
            } else {
                $this->dispatch('whatCanBeSell', 'No social data found.');
            }
        } else {
            $this->dispatch('whatCanBeSell', 'User not authenticated.');
        }
    }


    public function render()
    {
        return view('livewire.emotion', [
            'emotionResult' => $this->emotionResult,
            'whoYouAre' => $this->whoYouAre,
            'whatCanBeSell' => $this->whatCanBeSell,
        ]);
    }

    public function extractFullPictures($arrayData)
    {

        // Initialize an array to store full_picture URLs
        $fullPictures = [];

        // Iterate through each element and extract full_picture
        foreach ($arrayData as $item) {
            if (isset($item['full_picture'])) {
                $fullPictures[] = $item['full_picture'];
            }
        }

        // Return the array of full_picture URLs
        return $fullPictures;
    }
}
