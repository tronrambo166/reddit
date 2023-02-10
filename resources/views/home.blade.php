@extends('layout')
@section('title')
    Home
@endsection
@section('page')
    {{-- HOMEPAGE START --}}

    <section class="main my-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="sticky">
                    <div class="group">
                        <button class="button my-2" type="submit" role="button" data-bs-toggle="modal"
                            data-bs-target="#modalPost">

                            <span>create group</span>
                            <div class="icon">
                                <i class="fa-solid fa-plus"></i>
                                <i class="fa fa-check"></i>
                            </div>
                        </button>
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
                </div>
                <div class="col-lg-6">
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
                            <a href="{{route( $route,[$post->group->id, slug(@$post->group->name)])}}">
                            <h5 class="fw-bold py-2">{{ ucwords($post->group->name) }}</h5>
                             </a>
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
                                <button class="comment_icon commentBtn" data-id="{{ $post->id }}">
                                    <i class="far fa-comment"></i> <a class="my-2" href="javascripts:void(0)" role="button"> comment </a>
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
                    {{-- <div class="communities post my-2">
                        <div class="community_box mx-auto mt-2">
                            <h5 class="text-center">About Community</h5>
                        </div>
                        <div class="community_desc mt-2">
                            <p>Lorem ipsum dolor sit</p>
                        </div>
                        <div class="created mt-1 mb-2">
                            <i class="fa-regular fa-bookmark"></i> <small>Created oct 26, 2023</small>
                        </div>
                        <hr class="created_hr">
                        <div class="read_like mt-2 d-flex justify-content-between">
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
                        </div>
                    </div> --}}
                <div class="sticky">
                    <div class="communities post my-2 mt-2">
                        <div class="community_box mx-auto mt-2">
                            <h5 class="text-center">My Groups</h5>
                        </div>
                        @forelse ($myGroups as $val)
                            <div class="community mt-3">
                                <div class="community_img d-flex align-items-center">
                                    <img src="{{ getImage(imagePath()['group']['path'] . '/' . $val->image, imagePath()['group']['size']) }}"
                                        class="rounded-circle" />
                                    <a
                                        href="{{ route('my.group', [$val->id, slug(@$val->name)]) }}">{{ $val->name ?? '' }}</a>
                                </div>
                            </div>
                        @empty
                            <div class="community mt-3">
                                <div class=" ">
                                    <p class="text-center" style="text-align: center !important; font-size:15px">No Group
                                        Created Yet</p>
                                </div>
                            </div>
                        @endforelse


                    </div>
            
                  
                    <div class="communities post my-2 mt-4">
                        <div class="community_box mx-auto mt-2">
                            <h5 class="text-center">Related Community</h5>
                        </div>
                        @forelse ($relatedGroups as $val)
                            <div class="community mt-3">
                                <div class="community_img d-flex align-items-center">
                                    <img src="{{ getImage(imagePath()['group']['path'] . '/' . $val->image, imagePath()['group']['size']) }}"
                                        class="rounded-circle" />
                                    <a
                                        href="{{ route('related.communit', [$val->id, slug(@$val->name)]) }}">{{ $val->name ?? '' }}</a>
                                </div>
                            </div>
                        @empty
                            <div class="community mt-3">
                                <div class=" ">
                                    <p class="text-center" style="text-align: center !important; font-size:15px">No
                                        Related Community</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    </div>
                </div>
            </div>
        </div>

    </section>


    {{-- START create Group MODAL --}}
    <div class="modal fade" id="modalPost" tabindex="-1" role="dialog" aria-labelledby="modalPostTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-md  modal-dialog-centered" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-body py-0">
                    <div class="d-block main-content">
                        <form action="{{ route('group.create') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="content-text p-4">
                                <h3 class="mb-3">Create Group</h3>

                                <div class="group_name d-flex align-items-center">
                                    <label for="group_name">Group Name</label>
                                    <input type="text" name="name" id="group_name" class="group_name"
                                        placeholder="Enter Group Name">
                                </div>
                                <div class="group_name mt-2 d-flex align-items-center">
                                    <label for="group_details">Group Details</label> <br>
                                    <textarea name="details" id="group_details" class="group_details" placeholder="Write your group description here"></textarea>

                                </div>
                                <div class="group_name img_group mt-2">
                                    <label for="group_img">Group Image</label>
                                    <input type="file" name="image" id="group_img" class="group_img">
                                </div>

                                <p class="select_option mb-1 mt-2">Select Your Option</p>
                                <div>
                                    <label class="me-2"><input type="radio" name="group_type" value="free">
                                        Free</label>
                                    @if ($user->user_type == 2)
                                        <label><input type="radio" name="group_type" value="paid"> Paid</label>
                                    @endif

                                </div>
                                @if ($user->user_type == 2)
                                    <div class="paid box">
                                        <div class="d-flex justify-content-between">
                                            <div class="days">
                                                <label for="days">Days</label> <br>
                                                <select id="days" name="days">
                                                    <option value="">Select Days</option>
                                                    <option value="15">15 days</option>
                                                    <option value="30">30 days</option>
                                                </select>
                                            </div>
                                            <div class="amount">
                                                <label for="amount">Price</label> <br>
                                                <div class="price d-flex">
                                                    <input type="number" name="price" id="amount">
                                                    <div class="win text-center">WIN</div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endif
                                <div class="mt-2 pb-4">
                                    <div class="can_post">
                                        <label for="c_post">Any One Can Post?</label> <br>
                                        <select id="c_post" class="post_permisison" name="post_permisison">
                                            <option value="1">ON</option>
                                            <option value="2">OFF</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex mt-5">
                                    <div class="mx-auto">
                                        <a href="#" class="btn btn-link" data-bs-dismiss="modal">No Thanks</a>
                                        <button type="submit" class="btn btn-primary px-4">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- END POST MODAL --}}

    {{-- START COMMENT MODAL --}}
    <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="modalCommentTitle"
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
                                <input type="hidden" name="id">
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
    {{-- END COMMENT MODAL --}}

@endsection
@push('script')
<script>
      $('.commentBtn').on('click', function() {
            var modal = $('#commentModal');
            modal.find('input[name=id]').val($(this).data('id'))
            modal.modal('show');
        });
</script>

@endpush
