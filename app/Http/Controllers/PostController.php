<?php

namespace App\Http\Controllers;

use App\Mail\ContactsEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
 /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $posts = Post::get();
  
        return view('posts', compact('posts'));
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        //Validate POST-method data

        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                Rule::unique('posts', 'email')
            ],
            'phone' => [
                'required',
                'regex:/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/i',
                Rule::unique('posts', 'phone')
            ],
            'login' => [
                'required',
                Rule::unique('posts', 'login')
            ],
        ]);
  
        if ($validator->fails()) {
            return response()->json([
                        'error' => $validator->errors()->all()
                    ]);
        }

        //Create post
        Post::create([
            'email' => $request->email,
            'phone' => $request->phone,
            'login' => $request->login,
        ]);

        $mailData = [
            'email' => $request->email,
            'phone' => $request->phone,
            'login' => $request->login,
        ];

        Mail::to("maksernstok@gmail.com")->send(new ContactsEmail($mailData)); //Send mail

        return response()->json(['success' => 'Post created and sent successfully.']);
    }
}
