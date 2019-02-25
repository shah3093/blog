<div class="d-none d-md-block d-lg-none">
    <span style="margin-top: 10px;">.</span>
</div>
<div class="col-md-12 col-lg-4 sidebar">
    <div class="sidebar-box search-form-wrap  d-none d-sm-none d-md-none d-lg-block">
        <form action="#" class="search-form">
            <div class="form-group">
                <span class="icon fa fa-search"></span>
                <input type="text" class="form-control" id="s" placeholder="Type a keyword and hit enter">
            </div>
        </form>
    </div>

    <div class="sidebar-box d-none d-sm-none d-md-block ">
        <h3 class="heading">Popular Posts</h3>
        <div class="post-entry-sidebar">
            <ul>

                @foreach($popular_posts as $post)
                    <li>
                        <a href="{{route('post',['slug'=>$post->slug])}}">
                            <?php
                            $url = "";
                            $check = preg_match('/post/', $post->featuredImage);
                            if(empty($check)) {
                                $url = $post->featuredImage;
                            } else {
                                $url = Storage::url($post->featuredImage);
                            }
                            ?>
                            <img src="{{$url}}" alt="{{$post->title}}" class="mr-4">
                            <div class="text">
                                <h4>{{$post->title}}</h4>
                                <div class="post-meta">
                                    <span class="mr-2">{{$post->created_at}}</span> &bullet;
                                    <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach

            </ul>
        </div>
    </div>

    <div class="sidebar-box">
        <h3 class="heading">Categories</h3>
        <ul class="categories">

            @foreach($all_categories as $category)
                <li><a href="{{route('category',['slug'=>$category->slug])}}">{{$category->name}}
                        <span>({{count($category->posts)}})</span></a></li>
            @endforeach
        </ul>
    </div>

    <div class="sidebar-box  d-none d-sm-none d-md-block">
        <h3 class="heading">Tags</h3>
        <ul class="tags">
            @foreach($all_tags as $tag)
                <li><a href="{{route('tag',['name'=>$tag->name])}}">{{$tag->name}}</a></li>
            @endforeach
        </ul>
    </div>
</div>
