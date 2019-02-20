@if($type == "home")
    <input type="text" readonly value="home" class="required form-control" name="menu_url" id="menuitem"/>
@elseif($type == "contact")
    <input type="text" readonly value="contact" class="required form-control" name="menu_url" id="menuitem"/>
@elseif($type == "custom")
    <input type="url" value="" class="required form-control" name="menu_url" id="menuitem"/>
@elseif($type == "page")
    <select class="required form-control select2" name="menu_url" id="menuitem">
        <option value="">Select page</option>
        @foreach($pages as $page)
            <option value="page/{{$page->slug}}">{{$page->title}}</option>
        @endforeach
    </select>
@elseif($type == "category")
    <select class="required form-control select2" name="menu_url" id="menuitem">
        <option value="">Select category</option>
        @foreach($categories as $category)
            <option value="category/{{$category->slug}}">{{$category->name}}</option>
        @endforeach
    </select>
@elseif($type == "post")
    <select class="required form-control select2" name="menu_url" id="menuitem">
        <option value="">Select post</option>
        @foreach($posts as $post)
            <option value="post/{{$post->slug}}">{{$post->title}}</option>
        @endforeach
    </select>
@endif

<script>
    $(function () {
        $(".select2").select2();
    });
</script>
