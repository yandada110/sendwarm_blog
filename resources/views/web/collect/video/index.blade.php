@extends('web.main')
@section('title','视频列表')
@section('content')
    <div class="container pt-5">
        <div class="title">
            <blockquote class="blockquote text-right">
                <p class="mb-0">篱落疏疏一径深，树头花落未成阴。儿童急走追黄蝶，飞入菜花无处寻。</p>
                <footer class="blockquote-footer">《宿新市徐公店》
                    <cite title="Source Title">杨万里</cite>
                </footer>
            </blockquote>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-9 ml-auto mr-auto">
                    <div class="col-sm-12">
                        <div class="title">
                            <h3>视频列表
                                <br>
                                <small>千山鸟飞绝，万径人踪灭。孤舟蓑笠翁，独钓寒江雪。--《江雪》(柳宗元)</small>
                            </h3>
                        </div>
                    </div>
                    <div class="row mt-3">
                        @foreach($video_result as $v)
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="video-img" data-background="image" style="background-image: url('{{$v->video_img}}');"></div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{$v->video_title}}</h5>
                                        <hr>
                                        <div class="card-footer text-center">
                                            <a href="{{$v->id}}/detail" class="btn btn-sm btn-success btn-round">
                                                <i class="far fa-play-circle" aria-hidden="true"></i>
                                                播放视频
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!--分页开始-->
                    <div class="pagination-area">
                        {{$video_result->onEachSide(1)->links('vendor.pagination.default')}}
                    </div>

                </div>
                <div class="col-md-3 mr-auto ml-auto stats">
                    <div class="col-sm-12 mt-2 p-0">
                        <h5>精选推荐</h5>
                        <div class="row">
                            <div class="col-sm-12">
                                @foreach($recommended_video as $k=>$v)
                                    <div class="message">
                                        <a href="{{$v->id}}/detail" class="list-group-item list-group-item-action list-group-item-light">
                                            <span class="badge badge-pill badge-primary">{{$k+1}}</span>{{$v->video_title}}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
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
