@extends('web.main')
@section('title','歌单列表')
@section('content')
    <div class="container pt-5">
        <div class="title">
            <blockquote class="blockquote text-right">
                <p class="mb-0">谁家玉笛暗飞声，散入春风满洛城。 此夜曲中闻折柳，何人不起故园情。</p>
                <footer class="blockquote-footer">《春夜洛阳城闻笛》
                    <cite title="Source Title">李白</cite>
                </footer>
            </blockquote>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-9 ml-auto mr-auto ">
                    <div class="col-sm-12">
                        <div class="title">
                            <h3>音乐列表
                                <br>
                                <small>日暮苍山远,天寒白屋贫。柴门闻犬吠,风雪夜归人。--《逢雪宿芙蓉山主人》(刘长卿)</small>
                            </h3>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($music_result as $v)
                            <div class="col-sm-4">
                                <div class="card" data-background="image" style="background-image: url('{{asset(__STATIC_WEB__)}}/assets/img/noah-wetering.jpg')" style="height: 200px;">
                                    <div class="card-body">
                                        <div style="height: 200px;">
                                            <a href="{{$v->id}}/list">
                                                <h5 class="card-title">{{$v->song_list_title}}</h5>
                                            </a>
                                            <p class="card-description">
                                                {{Str::limit($v->song_list_describe,160)}}
                                            </p>
                                        </div>
                                        <div class="card-footer">
                                            <a href="{{$v->id}}/list" class="btn btn-sm btn-success btn-round">
                                                <i class="fa fa-music" aria-hidden="true"></i>播放歌单
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!--分页开始-->
                    <div class="pagination-area">
                        {{$music_result->onEachSide(1)->links('vendor.pagination.default')}}
                    </div>
                </div>
                <div class="col-md-3 mr-auto ml-auto stats">
                    <div class="col-sm-12 mt-2 p-0 mr-auto ml-auto stats">
                        <div class="col-sm-12 mt-2 p-0">
                            <p class="h5">标签云</p>
                            @foreach($tags as $k => $v)
                                <a href="javascript:void(0)" class="badge badge-{{$tag_color[$v->tags->tag_color]}}  badge-pill" onclick="tag_article('{{$v->tag_id}}')">{{$v->tags->tag_name}}({{$v->counts}})</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function tag_article($tag_id) {
        // 取得要提交页面的URL地址
        var url = "{{{url()->current()}}}";

        // 创建Form
        var form = $('<form id="tag_form"></form>');
        form.attr('action', url);        // 设置Form表单的action属性
        form.attr('method', 'post');        // 设置Form表单的method属性
        var csrf = '@csrf';
        form.append(csrf);
        // 创建input
        var input_tag = $('<input type="text" name="tag_id" />');
        input_tag.attr('value', $tag_id);     // 设置input的value属性

        // 把input添加到表单中
        form.append(input_tag);

        // 把表单添加到document.body中（不然在谷歌浏览器中会报错）
        $(document.body).append(form);

        // 提交表单（当然也可以通过AJAX来提交了，只要你喜欢）
        form.submit();
        $("#tag_form").remove();
        return false;
    }
</script>
