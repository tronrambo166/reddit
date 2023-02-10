<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupFollow;
use App\Models\GroupPost;
use App\Models\SetupRole;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GroupController extends Controller
{
    public function groupCreate(Request $request){

        $user = Auth::user();
        if( $request->group_type == 'free'){
            $group_type = 1;
            $days ='';
            $price ='';
            // $post_permisison_v ="";

        }elseif($request->group_type == 'paid'){
            $group_type = 2;
            $days ="required";
            $price ="required";
            // $post_permisison_v ="required";
        }elseif($request->group_type == null){
            $days ='';
            $price ='';
        }
        $request->validate([
            'name' => 'required|string|max:100',
            'details' => 'required|string',
            'image' => ['required','image',new FileTypeValidate(['jpg','jpeg','png'])],
            'group_type' => 'required',
            'days' => $days,
            'price' => $price,
            'post_permisison' => 'required',
        ]);
        $in['group_mentor'] = $user->id;
        $in['name'] = $request->name;
        $in['slug'] = Str::slug($request->name);
        $in['details'] = $request->details;
        $in['group_type'] = $group_type;
        $in['days'] = $request->days??0;
        $in['price'] = $request->price??0;
        $in['post_permisison'] =  $request->post_permisison;

        if ($request->hasFile('image')) {
            $location = imagePath()['group']['path'];
            $size = imagePath()['group']['size'];
            $filename = uploadImage($request->image, $location, $size);
            $in['image'] = $filename;
        }
        Group::create($in);
        $notify[] = ['success', 'Group Created Successfully.'];
        return back()->withNotify($notify);
    }
    public function myGroup($id,$slug){
        $user = auth()->user();
        $group = Group::where('id',$id)->first();
        $relatedGroups = Group::where('group_mentor','!=',$user->id)->get();
        $rules = SetupRole::where('group_id', $group->id)->get();
        $followers = GroupFollow::where('group_id',$group->id)->where('user_id',$user->id)->first();
        $groupPosts = GroupPost::where('group_id',$group->id)->orderBy('id',"DESC")->get();

      return view('mygroup.group',compact('user','group','relatedGroups','rules','followers','groupPosts'));
    }
    public function RelatedCommunity($id,$slug){
        $user = auth()->user();
        $group = Group::where('id',$id)->first();
        $relatedGroups = Group::where('group_mentor','!=',$user->id)->get();
        $rules = SetupRole::where('group_id', $group->id)->get();
        $followers = GroupFollow::where('group_id',$group->id)->where('user_id',$user->id)->first();
        $groupPosts = GroupPost::where('group_id',$group->id)->orderBy('id',"DESC")->get();

      return view('relered.group',compact('user','group','relatedGroups','rules','followers','groupPosts'));
    }
    public function onOff(Request $request){
        $on = Group::find($request->group_id);
        $on->post_permisison	= $request->on;
        $on->save();
        return \response()->json('ok');
    }
    public function setupRules(Request $request){
        $request->validate([
            'rules' => 'required|string|max:100',
        ]);
        $group = Group::findOrFail($request->id);
        $in['group_id'] =  $group->id;
        $in['rule'] =  $request->rules;
        SetupRole::create($in);
        $notify[] = ['success', 'Group Rules Added Successfully.'];
        return back()->withNotify($notify);
    }
    public function deleteRule(Request $request){
        $rule = SetupRole::find($request->rule_id);
        $rule->delete();
        return \response()->json('deleted');
    }
    public function followGroup(Request $request){
        $user = auth()->user();
        $in['group_id'] = $request->group_id;
        $in['user_id'] = $user->id;
        GroupFollow::create($in);
        return \response()->json('ok');
    }
    public function unFollowGroup(Request $request){
        $user = auth()->user();
        $unfollow = GroupFollow::where('group_id',$request->group_id)->where('user_id',$user->id)->first();
        $unfollow->delete();
        return \response()->json('ok');
    }
}
