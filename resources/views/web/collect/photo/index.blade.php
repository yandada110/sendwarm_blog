@extends('web.main')
@section('title','相册列表')
@section('content')
    <div class="container pt-5">
        <div class="title">
            <blockquote class="blockquote text-right">
                <p class="mb-0">枯藤老树昏鸦，小桥流水人家，古道西风瘦马。夕阳西下，断肠人在天涯。</p>
                <footer class="blockquote-footer">《天净沙·秋思》
                    <cite title="Source Title">马致远</cite>
                </footer>
            </blockquote>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-9 ml-auto mr-auto">
                    <div class="col-sm-12">
                        <div class="title">
                            <h3>相册列表
                                <br>
                                <small>折戟沉沙铁未销,自将磨洗认前朝。东风不与周郎便,铜雀春深锁二乔。--《赤壁》(唐/杜牧)</small>
                            </h3>
                        </div>
                    </div>
                    <div class="row  collections">
                        @foreach($photo_result as $v)
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <a href="{{$v->id}}/list">
                                            <div class="photo-img" data-background="image"
                                                 style="background-image: url('{{$v->photo_img}}');"></div>
                                            <div class="card-body">
                                                <h5 class="card-title">{{$v->photo_title}}</h5>
                                                <p class="card-text">
                                                    <small class="text-muted">更新时间：{{$v->updated_at}}</small>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!--分页开始-->
                    <div class="pagination-area">
                        {{$photo_result->onEachSide(1)->links('vendor.pagination.default')}}
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
