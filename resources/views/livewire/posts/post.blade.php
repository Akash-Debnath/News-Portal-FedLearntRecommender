<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Post
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            <div class="grid gap-4">
                <div class="font-bold text-xl mb-2">{{ $post ? $post->title : ''}}</div>
                <div class="flex">
                    by&nbsp;<span class="italic">{{ ($post ? $post->author->first_name : '') . ' ' . ($post ? $post->author->last_name : '') }}</span>
                    &nbsp;in&nbsp;<a href="{{ url('dashboard/categories/' . $post->category->id . '/posts') }}"
                        class="underline">{{ $post ? $post->category->title : '' }}</a>
                    &nbsp;on&nbsp;{{ $post->updated_at->format('F, d Y') }}
                </div>
                <div class="grid grid-flow-col">
                    @foreach ($post->images as $image)
                        <div class="px-6 py-4">
                            <img src="{{ $image->url }}" alt="{{ $image->description }}" width="300" height="200">
                        </div>
                    @endforeach
                </div>
                <div class="grid grid-flow-col">
                    @foreach ($post->videos as $video)
                        <div class="px-6 py-4">
                            <img src="{{ $video->url }}" alt="{{ $video->title }}" width="300" height="200">
                        </div>
                    @endforeach
                </div>
                <div class="text-gray-700 text-base">
                    {!! $post->content !!}
                </div>
                <div class="flex">
                    @php
                    $tags=$post->tags->pluck('id', 'title');
                    @endphp
                    @if (count($tags) > 0)
                        Tags:
                        @foreach ($tags as $key => $tag)
                            <a href="{{ url('dashboard/tags/' . $tag . '/posts') }}"
                                class="underline px-1">{{ $key }}</a>
                        @endforeach
                    @endif
                </div>
                <hr><hr>
                <!-- like button -->
                <div class="btn-group">
                    {{-- <form method="POST" action="{{ url('likes/posts') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $post->id }}" />
                        @php 
                            $userID = Auth::user()->id;
                        @endphp
                        @foreach($post->likes as $likeInfo)
                            @if($likeInfo->author_id == $userID)
                                <h5> {{ $post->likes->count() }} Liked</h5>
                                @php break; @endphp
                            @else
                                <button type="submit" class="btn btn-link">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                    {{ $post->likes->count() }} Like
                                </button>
                            @endif
                        @endforeach
                    </form> --}}

                    <form method="POST" action="{{ url('likes/posts') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $post->id }}" />
                        @php 
                            $userID = Auth::user()->id;
                            $liked = false;
                            foreach($post->likes as $likeInfo) {
                                if($likeInfo->author_id == $userID) {
                                    $liked = true;
                                    break;
                                }
                            }
                        @endphp
                        @if($liked)
                        <div>
                            {{-- <h5> {{ $post->likes->count() }}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path d="M7.493 18.75c-.425 0-.82-.236-.975-.632A7.48 7.48 0 016 15.375c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75 2.25 2.25 0 012.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23h-.777zM2.331 10.977a11.969 11.969 0 00-.831 4.398 12 12 0 00.52 3.507c.26.85 1.084 1.368 1.973 1.368H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 01-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227z" />
                                </svg>
                            </h5> --}}
                            <div class="flex flex-row pr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path d="M7.493 18.75c-.425 0-.82-.236-.975-.632A7.48 7.48 0 016 15.375c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75 2.25 2.25 0 012.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23h-.777zM2.331 10.977a11.969 11.969 0 00-.831 4.398 12 12 0 00.52 3.507c.26.85 1.084 1.368 1.973 1.368H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 01-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227z" />
                                </svg>
                                <h3 class="pl-2"><b>{{ $post->likes->count() }}</b></h3>
                            </div>                            
                        </div>
                        @else
                            <button type="submit" class="btn btn-link">
                                {{-- <i class="fa fa-heart" aria-hidden="true"></i> --}}
                                <div class="flex flex-row pr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                                    </svg>
                                    <h3 class="pl-2"><b>{{ $post->likes->count() }}</b></h3> 
                                </div>    
                            </button>
                        @endif
                    </form>

                    <!-- unlike button -->
                    {{-- <form method="POST" action="{{ url('unlikes/posts') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $post->id }}" />
                        <button type="submit" class="btn btn-link">
                            <i class="fa fa-thumbs-down"></i>
                            {{ $post->unlikes->count() }} Unlike
                        </button>
                    </form> --}}
                </div>
                {{-- LIKe Unlike SEction End --}}


                @if ($post->comments->count())
                    <div class="text-base">
                        <h4 class="text-green-900 pt-2 pb-4"><b>{{ $post->comments->count() }}
                            @if ($post->comments->count() > 1) Comments @else Comment @endif </b>
                        </h4>
                        <div class="bg-gray-100 overflow-hidden shadow-xl px-6 pt-4">
                            @foreach ($post->comments as $comment)
                                <div>
                                    <p class="text-gray-500 font-bold">
                                        {{ $comment->author->first_name . ' ' . $comment->author->last_name }}</p>
                                    <p class="text-gray-400 text-xs">{{ $comment->created_at->format('F, d Y') }}
                                    </p>
                                    <p class="text-gray-500 pb-4">{{ $comment->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <h4><strong>Add Comment</strong></h4>
                <form method="post" action="{{ url('comments/posts') }}">
                    @csrf
                    <div class="form-group">
                        <textarea class="form-control border border-dark mb-2" rows="3" cols="40" name="comment"></textarea>
                        <input type="hidden" name="id" value="{{ $post->id }}" />

                        {{-- <input type="submit" class="btn btn-sm btn-info btn-block" value="Send"/> --}}
                        <button type="submit" class="btn btn-success">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- https://www.php.net/manual/en/datetime.format.php --}}
