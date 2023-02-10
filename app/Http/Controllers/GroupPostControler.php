<?php

namespace App\Http\Controllers;

use App\Models\GroupPost;
use App\Models\PostComment;
use App\Models\PostFile;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use DB;

class GroupPostControler extends Controller
{
    public function postOnGroup(Request $request){
        $user = auth()->user();
        $attachments = $request->file('media_files');
        $allowedExts = array('jpg', 'png', 'jpeg', 'mp4', 'mov', 'avi','wmv','flv');

        $this->validate($request, [
            'attachments' => [
                'max:4096',
                function ($attribute, $value, $fail) use ($attachments, $allowedExts) {
                    foreach ($attachments as $attachment) {
                        $ext = strtolower($attachment->getClientOriginalExtension());
                        // if (($attachment->getSize() / 1000000) > 2) {
                        //     return $fail("Miximum 2MB file size allowed!");
                        // }

                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only jpeg, jpg, png, mp4, mov, avi, wmv, flx files are allowed");
                        }
                    }
                    if (count($attachments) > 10) {
                        return $fail("Maximum 10 files can be uploaded");
                    }
                }
            ],
            'title' => 'required|string',
        ]);
        $in['group_id'] = $request->group_id;
        $in['user_id'] = $user->id;
        $in['title'] = $request->title;
        $in['link'] = $request->link;
        $post = GroupPost::create($in);
        $path = imagePath()['post']['path'];
        if ($request->hasFile('media_files')) {
            foreach ($request->file('media_files') as $file) {
                try {
                    $attachment = new PostFile();
                    $attachment->post_id = $post->id;
                    $attachment->files = uploadFile($file, $path);
                    $attachment->save();
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Could not upload your ' . $file];
                    return back()->withNotify($notify)->withInput();
                }
            }
        }
        $notify[] = ['success', 'Post Created Successfully.'];
        return back()->withNotify($notify);


    }

    public function commentOnPost(Request $request){
        $request->validate([
            'comment' => 'required|string',
        ]);
        $cm['post_id'] = $request->id;
        $cm['user_id'] = auth()->user()->id;
        $cm['comment'] = $request->comment;
        PostComment::create($cm);
        $notify[] = ['success', 'Comment Added Successfully.'];
        return back()->withNotify($notify);
    }


     public function post_like(Request $request){ 
        $post_id = $request->post_id;
        $user_id = auth()->user()->id;
        $group_id = $request->group_id; 

        $post = DB::table('post_likes')->where('post_id',$post_id)->first();
        
        if($post!=null)
             DB::table('post_likes')->where('post_id',$post_id)->update([
                'likes' => $post->likes+1 ]);
         else
            DB::table('post_likes')->insert([
                'user_id' => $user_id,
                'group_id' => $group_id,
                'post_id' => $post_id,
                'likes' => 1
            ]); 


        $notify[] = ['success', 'Liked!'];
        return \response()->json('ok');
    }

}
