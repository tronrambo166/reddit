<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupFollow;
use App\Models\GroupPost;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function home() {
        $pageTitle = "Home";
        $user = auth()->user();
        $myGroups = Group::where('group_mentor',$user->id)->orderBy('id','DESC')->get();
        $relatedGroups = Group::where('group_mentor','!=',$user->id)->get();
        $followingGroup = GroupFollow::where('user_id',$user->id)->orderBy('created_at',"DESC")->get()->map(function($follow){
          $groupPost = GroupPost::where('group_id',$follow->group_id)->orderBy('id',"DESC")->get();
          return $groupPost;
        });
        // $collapsedArray = array_collapse($followingGroup);
        $collapsedArray = Arr::collapse($followingGroup);
        $groupPosts = collect($collapsedArray);
        $groupPosts = $groupPosts->sortByDesc('created_at');
        // return $groupPosts;
        return view('home',\compact('pageTitle','user','myGroups','relatedGroups','groupPosts'));
    }
    public function placeholderImage($size = null){
        $imgWidth = explode('x',$size)[0];
        $imgHeight = explode('x',$size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }


  public function radio() {
    return view('radio');
     }


  public function breakdown() {
    return view('breakdown');
}


  public function social() {
    return view('social');
}



  public function about() {
    return view('about');
}

}
