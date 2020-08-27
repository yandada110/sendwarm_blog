@extends('web.main')
@section('title','歌单详情')
@section('content')
    <div class="container pt-5">
        <div class="title">
            <blockquote class="blockquote text-right">
                <p class="mb-0">锦城丝管日纷纷，半入江风半入云。此曲只应天上有，人间能得几回闻。</p>
                <footer class="blockquote-footer">《赠花卿》
                    <cite title="Source Title">杜甫</cite>
                </footer>
            </blockquote>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="title">
                    <h3>我的歌单
                        <br>
                        <small>人闲桂花落,夜静春山空。月出惊山鸟,时鸣春涧中。--《鸟鸣涧》(王维)</small>
                    </h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <img class="card-img pl-5 pr-5" src="{{$song->song_list_img}}" alt="Card image">
            </div>
            <div class="col-sm-9">
                <p class="h3">{{$song->song_list_title}}</p>
                <div class="blog-tags pt-2">
                    标签:&nbsp;
                    @foreach($tags as $k => $tag)
                        <span class="badge badge-{{Arr::random($tag_color)}}">{{$tag->tag_name}}</span>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-sm-12">
                <h5>简介</h5>
                {{$song->song_list_describe}}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="pt-3" data-example-id="">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>歌曲名称</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if($music_list)
                                @foreach($music_list as $k => $v)
                                    <tr>
                                        <td class="text-center">{{$k+1}}</td>
                                        <td>{{$v->music_name}}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
