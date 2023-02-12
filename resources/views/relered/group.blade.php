@extends('layout')
@section('title')
    Releted Community Group
@endsection
@section('page')
    {{-- MYGROUP START --}}

    <section class="mygroup my-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="sticky">
                        <div class="group_members communities post my-2 mt-2">
                            <div class="community_box mx-auto mt-2">
                                <h5 class="text-center">Group Members</h5>
                            </div>
                            <div class="community mt-3">
                                <div class="community_img d-flex align-items-center">
                                    <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . $group->mentor->image, imagePath()['profile']['user']['path']) }}" class="rounded-circle" />
                                    <a href="javascript:void(0)">{{ @$group->mentor->name }}</a>
                                </div>
                            </div>
                            {{-- <div class="community mt-1">
                                <div class="community_img d-flex align-items-center">
                                    <img src="{{ asset('images') }}/profile.jpg" class="rounded-circle" />
                                    <a href="#0">John Doe</a>
                                </div>
                            </div>
                            <div class="community mt-1">
                                <div class="community_img d-flex align-items-center">
                                    <img src="{{ asset('images') }}/profile.jpg" class="rounded-circle" />
                                    <a href="#0">Richarlson</a>
                                </div>
                            </div> --}}
                        </div>
                        <div class="group_members communities post my-2 mt-3">
                            <div class="community_box mx-auto mt-2">
                                <h5 class="text-center">Rules</h5>
                            </div>
                            <div class="community mt-3">
                                <div class="community_img">
                                    <ul class="list-group">
                                        @forelse ($rules as $rule)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                          {{ ucwords(shortDescription($rule->rule,42)) }}
                                          <div class="modify">
                                          <span class="edit me-1"> <a href="javascript:void(0)" data-rule="{{ ucwords($rule->rule) }}" role="button" class="ruleViewBtn"><i class="fa-solid fa-eye"></i></a></span>
                                          @if($user->id == $group->group_mentor)
                                          <span class="delete"><a href="javascript:void(0)" class="deleteRule" data-id="{{ $rule->id }}"><i class="fa-solid fa-trash"></i></a></span>
                                          @endif
                                        </div>
                                        </li>
                                        @empty
                                        <li class="list-group-item d-flex justify-content-center align-items-center">
                                            <span > No Rules Added Yet</span>
                                        </li>
                                        @endforelse
                                      </ul>
                                      @if($user->id == $group->group_mentor)
                                      <div class="set_rules mt-2">
                                        <button class="comment_icon mx-auto" type="submit" role="button" data-bs-toggle="modal"
                                        data-bs-target="#modalRules">
                                            <a href="#" class="text-uppercase"><i class="fa-solid fa-user-gear"></i> set rules</a>
                                        </button>
                                    </div>
                                      @endif

                                </div>
                            </div>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="button2 my-2" type="submit" role="button">
                                <span>log out</span>
                                <div class="icon">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    <i class="fa fa-check"></i>
                                </div>
                            </button>
                        </form>

                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="post groups my-2 py-4">
                        <div class="group_header d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="groups_img me-2">
                                    <img width="100px" height="100px" src="{{ getImage(imagePath()['group']['path'] . '/' . $group->image, imagePath()['group']['size']) }}" class="img-fluid rounded-circle"
                                        alt="">
                                </div>
                                <div class="groups_name">
                                    <h5>{{ @$group->name }}</h5>
                                    <p>{{ @$group->mentor->name }}</p>
                                </div>
                            </div>
                            <div>
                                @if(isset($followers))
                                @if($followers != null)
                                <div class="follow">
                                    <button class="follow_btn comment_icon unFollowBtn" data-group_id ="{{ $group->id }}">
                                        <a href="javascript:void(0)" > <i class="fa-solid fa-user-plus"></i> Followed</a>
                                    </button>
                                </div>
                                @endif
                                @else
                                <div class="follow">
                                    <button class="follow_btn comment_icon followBtn" data-group_id ="{{ $group->id }}">
                                        <a href="javascript:void(0)" > <i class="fa-solid fa-user-plus"></i> Follow</a>
                                    </button>
                                </div>
                                @endif

                                @if($user->id == $group->group_mentor && $group->post_permisison !=0)
                                <div class="post_permission">
                                    <p>Post Permission</p>
                                    <label class="switch">
                                        <input type="checkbox" data-id="{{ $group->id}}"  class="toggle-class" {{$group->post_permisison == 1 ?'checked':''}}>
                                        <span class="slider round"></span>
                                      </label>
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    {{-- @if($group->group_type == 1 && $group->post_permisison == 1) --}}
                    @if( $group->post_permisison == 1)
                    <div class="post create_post px-4 my-2 py-4">
                        <div class="user d-flex align-items-center">
                            <div class="user_img me-2">
                                <img  src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . auth()->user()->image, imagePath()['profile']['user']['path']) }}" class="img-fluid rounded-circle" alt="profile">
                            </div>
                            <div class="user_post group_name">
                                <input class="" placeholder="Click to create post" disabled role="button" data-bs-toggle="modal"
                                        data-bs-target="#createPost">
                            </div>
                        </div>
                    </div>
                    @endif

                    @forelse ($groupPosts as $post)
                    <div class="post px-4 my-2 py-4">
                        <div class="user d-flex align-items-center">
                            <div class="user_img me-1">
                                <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . $post->user->image, imagePath()['profile']['user']['path']) }}" class="img-fluid rounded-circle" alt="profile">
                            </div>
                            <div class="user_name">
                                <h6 >{{ $post->user->name }}</h6>
                                <p class="time">{{ diffForHumans($post->created_at) }}</p>
                            </div>
                        </div>

                        <div class="post_title mt-2">
                            @php
                               if($post->group->group_mentor == $user->id){
                                $route = 'my.group';
                               }else{
                                $route = 'related.communit';
                               }

                            @endphp

                            <p class="">{{ ucwords($post->title) }}</p>
                            @if($post->link != null)
                            <h6><i class="fa-solid fa-link"></i> Link:<a href="{{ $post->link }}" class="me-1" target="_blank"> {{ $post->link }}</a> </h6>
                            @endif
                        </div>

                        @php
                            $files = App\Models\PostFile::where('post_id',$post->id)->get();
                        @endphp
                        @if(isset($files))
                            @foreach ($files as $file)
                            @php
                                $extension = pathinfo($file->files, PATHINFO_EXTENSION);
                                if($extension === 'jpg' || $extension === 'jpeg' || $extension === 'png') {
                                    $fileType = "Image";
                                }elseif($extension === 'mp4' || $extension === 'mov' || $extension === 'avi' || $extension === 'wmv' || $extension === 'flv'){
                                    $fileType = "Video";
                                }
                             @endphp
                             @if($fileType == "Image")
                             <div class="post_img mt-2">
                                <img width="100%" src="{{ getImage(imagePath()['post']['path'] . '/' . $file->files,) }}" class="img-fluid rounded" alt="">
                            </div>
                            @else
                            <div class="post_img mt-2 border">
                                <video width="100%" height="240" controls>
                                    <source src="{{ getImage(imagePath()['post']['path'] . '/' . $file->files,) }}" type="video/mp4">
                                  </video>
                            </div>
                             @endif

                            @endforeach

                        @endif
                        <div class="d-flex justify-content-between">
                            <div class="post_comment mt-2">

                                  <button class="comment_icon">
                                     <a class="my-2 mr-3"  role="button" data-id="{{ $group->id}}" onclick="like({{$post->id}},{{$group->id}});">  <i class="far fa-heart" style="color:red;"></i>  </a>  

                                        <button class="px-1 m-0 comment_icon">
                                    <p id="likes{{$post->id}}"class=" border border-left d-inline bg-light">
                                         @if(!isset($likes[0])) 0 @endif

                                    @foreach($likes as $like)
                                    @if($like->post_id == $post->id)
                                     {{$like->likes}} @endif @endforeach
                                    </p>

                                        
                                </button>


                                <button class="comment_icon">
                                    <i class="far fa-comments"></i> <a class="my-2" href="javascripts:void(0)" role="button"
                                        data-bs-toggle="modal" data-bs-target="#modalComment{{$post->id}}"> comments </a>
                                </button>
                            </div>
                            <div class="post_comment mt-2">
                                <button class="comment_icon">
                                    <i class="far fa-comments"></i> <a class="my-2" href="javascripts:void(0)" role="button"
                                        data-bs-toggle="modal" data-bs-target="#modalComments{{ $post->id }}"> view comments </a>
                                </button>
                            </div>
                        </div>
                        @php
                            $comments = App\Models\PostComment::where('post_id',$post->id)->orderBy('id',"DESC")->get();
                        @endphp
                         {{-- START COMMENTs Display MODAL --}}
                        <div class="modal fade" id="modalComments{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="modalCommentsTitle"
                            aria-hidden="true">
                            <div class="modal-dialog modal-md  modal-dialog-centered" role="document">
                                <div class="modal-content rounded-0">
                                    <div class="modal-body py-0">
                                        <div class="d-block main-content">
                                            <form action="#">
                                                <div class="content-text p-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <h3>View Comments</h3>
                                                        <a href="javascripts:void(0)" class="btn btn-link" data-bs-dismiss="modal"><i
                                                                class="fa-solid fa-xmark"></i></a>
                                                    </div>
                                                    @forelse($comments as $key => $comment)
                                                    <div class="comments_border mt-2">
                                                        <div class="user d-flex align-items-center">
                                                            <div class="user_img me-1">
                                                                <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' .$comment->user->image, imagePath()['profile']['user']['path']) }}" class="img-fluid rounded-circle"
                                                                    alt="profile">
                                                            </div>
                                                            <div class="user_name">
                                                                <h6>{{ @$comment->user->name }}</h6>
                                                                <p class="time">{{diffForHumans($comment->created_at)}}</p>
                                                            </div>
                                                        </div>
                                                        <p class="comments_text py-2">{{ $comment->comment }}</p>
                                                    </div>
                                                    @empty
                                                    <div class="comments_border mt-2">
                                                        <p class="comments_text fw-bold">No one comments here</p>
                                                    </div>
                                                    @endforelse


                                                </div>
                                        </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalComment{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="modalCommentTitle"
                            aria-hidden="true">
                            <div class="modal-dialog modal-md  modal-dialog-centered" role="document">
                                <div class="modal-content rounded-0">
                                    <div class="modal-body py-0">
                                        <div class="d-block main-content">
                                            <form action="{{ route('post.comment') }}" method="POST">
                                                @csrf
                                                <div class="content-text p-4">
                                                    <h3 class="mb-3">Comment</h3>
                                                    <label for="comment" class="mb-2">Please, write your comment here</label> <br>
                                                    <input type="hidden" name="id" value="{{ $post->id }}">
                                                    <textarea name="comment" class="comment" placeholder="This post is really awesome!!!"></textarea>
                                                    <div class="d-flex mt-3">
                                                        <div class="mx-auto">
                                                            <a href="javascripts:void(0)" class="btn btn-link" data-bs-dismiss="modal">Close</a>
                                                            <button type="submit" class="btn btn-primary px-4">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                    </div>
                    </div>
                @empty
                <div class="post px-4 my-2 py-4">
                    <div class="post_title mt-2">
                        <p>No News Feed Available Right Now.</p>
                    </div>
                </div>
                @endforelse
                </div>
                <div class="col-lg-3">

                    <div class="sticky">
                        <div class="communities post my-2">
                            <div class="community_box mx-auto mt-2">
                                <h5 class="text-center">About Community</h5>
                            </div>
                            <div class="community_desc mt-2">
                                <p>{{ $group->details }}</p>
                            </div>
                            <div class="created mt-1 mb-2">
                                <i class="fa-regular fa-bookmark"></i> <small class="fw-bold">Created {{ showDate($group->created_at) }}</small>
                            </div>
                            <div class="created mt-1 mb-2">
                               <a href="{{ route('home') }}">
                                <i class="fa fa-home "></i> <small class="fw-bold">Home </small>
                               </a>
                            </div>

                            {{-- <div class="read_like mt-2 d-flex justify-content-between">
                                <div class="read">
                                    <div class="read_text text-center">
                                        <h6>601k</h6>
                                    </div>
                                    <div class="read_icon">
                                        <i class="fa-brands fa-react"></i> <span>Read</span>
                                    </div>
                                </div>
                                <div class="read_border"> </div>
                                <div class="read">
                                    <div class="read_text text-center">
                                        <h6>1.1k</h6>
                                    </div>
                                    <div class="read_icon">
                                        <i class="fa-regular fa-heart"></i> <span>Likes</span>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="communities post my-2 mt-4">
                            <div class="community_box mx-auto mt-2">
                                <h5 class="text-center">Related Community</h5>
                            </div>
                                @forelse ($relatedGroups as $val)
                                 @if($val->id != $group->id)
                                 <div class="community mt-3">
                                    <div class="community_img d-flex align-items-center">
                                        <img src="{{ getImage(imagePath()['group']['path'] . '/' . $val->image, imagePath()['group']['size']) }}"
                                            class="rounded-circle" />
                                        <a href="{{route('related.communit',[$val->id, slug(@$val->name)])}}">{{ $val->name ?? '' }}</a>
                                    </div>
                                </div>
                                 @endif

                            @empty
                                <div class="community mt-3">
                                    <div class=" ">
                                        <p class="text-center" style="text-align: center !important; font-size:15px">No Related Community</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>


    {{-- START CREATE POST MODAL --}}
    <div class="modal fade" id="createPost" tabindex="-1" role="dialog" aria-labelledby="createPostTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-md  modal-dialog-centered" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-body py-0">
                    <div class="d-block main-content">
                        <form action="{{ route('group.post') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="group_id" value="{{ $group->id }}">
                            <div class="content-text p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h3>Create a Post</h3>
                                    <a href="#" class="btn btn-link" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></a>
                                </div>
                                <div class="user d-flex align-items-center">
                                    <div class="user_img me-1">
                                        <img src="{{ getImage(imagePath()['profile']['user']['path'] . '/' . $user->image, imagePath()['profile']['user']['path']) }}" class="img-fluid rounded-circle" alt="profile">
                                    </div>
                                    <div class="user_name">
                                        <h6>{{ @$user->name }}</h6>
                                    </div>
                                </div>
                                <div class="group_name create_post mt-2">
                                    <label for="create_post">Post Title</label> <br>
                                    <textarea name="title" id="create_post" class="create_post_input"
                                        placeholder="Please write something.." ></textarea>
                                </div>
                                <div class="up_img_vid">
                                    <div class="group_name img_group">
                                        <label for="up_img">Media Files</label>
                                        <input type="file" name="media_files[]" multiple>
                                    </div>
                                </div>
                                <div class="group_name mt-2">
                                    <label for="addLink">Add Link</label> <br>
                                    <input type="text" name="link" id="addLink" class="addLink">
                                </div>
                                <div class="d-flex mt-3">
                                    <div class="mx-auto">
                                        <button type="submit" class="btn btn-block btn-primary px-5">POST</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- END CREATE POST MODAL --}}
    {{-- START SetRules MODAL --}}
    <div class="modal fade" id="modalRules" tabindex="-1" role="dialog" aria-labelledby="modalRulesTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-md  modal-dialog-centered" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-body py-0">
                    <div class="d-block main-content">
                        <form action="{{ route('setup.rules') }}" method="POST" >
                            @csrf
                            <div class="content-text p-4">
                                <h3 class="mb-3">Set Rules</h3>
                                <input type="hidden" name="id" value="{{ $group->id }}">
                                <div class="group_name">
                                    <label for="rules_set">Set Your Rules</label> <br>
                                    <input type="text" name="rules" id="rules_set" class="rules_set"
                                        placeholder="Enter Your Rules Here">
                                </div>
                                <div class="mt-3">
                                        <a href="#" class="btn btn-link" data-bs-dismiss="modal">No Thanks</a>
                                        <button type="submit" class="btn btn-primary px-4">Add Rules</button>

                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- END SetRules MODAL --}}

    {{-- START VIEW RULES MODAL --}}
    <div class="modal fade" id="viewRules" tabindex="-1" role="dialog" aria-labelledby="viewRulesTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-md  modal-dialog-centered" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-body py-0">
                    <div class="d-block main-content">
                        <form action="#">
                            <div class="content-text p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h3>View Rules</h3>
                                    <a href="#" class="btn btn-link" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></a>
                                </div>
                                <p class="rule">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus excepturi rem nostrum dignissimos aspernatur corporis maiores vero eaque? Dolor quaerat odio maxime facilis saepe cum quibusdam, nostrum debitis tenetur ipsam voluptate ad fuga eos reprehenderit pariatur atque! Ratione esse placeat ut itaque vero iure mollitia id expedita. Mollitia, at obcaecati?</p>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>



<script type="text/javascript">
        function like(post_id,group_id){ 
            var likes = document.getElementById('likes'+post_id).innerHTML; 
            //alert(post_id+'//'+group_id);
            $.ajax({
                    type:  "GET",
                    dataType: "json",
                    url:'{{ route("post_like") }}',
                    data:{'post_id': post_id, 'group_id': group_id},
                    success: function(data){
                       document.getElementById('likes'+post_id).innerHTML=(parseInt(likes)+1);
                        notify('success','You like this post!')
                        
                }

                });
        }

    </script>

@endsection
@push('script')
    <script>

        $(function(){
            $('.toggle-class').change(function(){
                var on = $(this).prop('checked') == true ? 1 : 2;
                var group_id = $(this).data('id');
                $.ajax({
                    // headers: { "X-CSRF-Token": $("meta[name=csrf_token]").attr("content") },
                    type:  "GET",
                    dataType: "json",

                    url:'{{ route("post.on.off") }}',
                    data:{'on': on, 'group_id': group_id},
                    success: function(data){
                       if(on == 1){
                        notify('success','Post Permission On Successfully.')

                       }else{
                        notify('success','Post Permission Off Successfully.')
                       }

                    }

                });
            });
        })
        $(function(){
            $('.deleteRule').click(function(){
                var rule_id = $(this).data('id');
                $.ajax({
                    // headers: { "X-CSRF-Token": $("meta[name=csrf_token]").attr("content") },
                    type:  "GET",
                    dataType: "json",

                    url:'{{ route("delete.rule") }}',
                    data:{ 'rule_id': rule_id},
                    success: function(data){
                     notify('success','Rule Removed Successfully.')
                     setTimeout(function(){// wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1000);
                    }

                });
            });
        })
        $(function(){
            $('.followBtn').click(function(){
                var group_id = $(this).data('group_id');
                $.ajax({
                    // headers: { "X-CSRF-Token": $("meta[name=csrf_token]").attr("content") },
                    type:  "GET",
                    dataType: "json",

                    url:'{{ route("follow.group") }}',
                    data:{ 'group_id': group_id},
                    success: function(data){
                     notify('success','Thanks For Following Us')
                     setTimeout(function(){// wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1000);
                    }

                });
            });
        })
        $(function(){
            $('.unFollowBtn').click(function(){
                var group_id = $(this).data('group_id');
                $.ajax({
                    // headers: { "X-CSRF-Token": $("meta[name=csrf_token]").attr("content") },
                    type:  "GET",
                    dataType: "json",

                    url:'{{ route("unfollow.group") }}',
                    data:{ 'group_id': group_id},
                    success: function(data){
                     notify('success','Unfollowing this group successful')
                     setTimeout(function(){// wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1000);
                    }

                });
            });
        })
        $('.ruleViewBtn').on('click', function() {
                var modal = $('#viewRules');
                var rule = $(this).data('rule');
                modal.find('.rule').text(rule);
                modal.modal('show');
        });


    </script>

@endpush
