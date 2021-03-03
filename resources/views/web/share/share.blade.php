@extends('web.main')
@section('title','文章列表')
@section('content')
    <body>
    <div class="container pt-5">
        <div class="title">
            <blockquote class="blockquote text-right">
                <p class="mb-0">折花逢驿使，寄与陇头人。 江南无所有，聊赠一枝春。</p>
                <footer class="blockquote-footer">《赠范晔诗》
                    <cite title="Source Title">陆凯</cite>
                </footer>
            </blockquote>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @foreach($share_list as $k => $v)
                <div class="col-sm-3">
                    <div class="card card-pricing" data-background="image"
                         style="background-image: url('{{$v->share_src}}')">
                        <div class="card-body">
                            <h6 class="card-category">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">{{$v->share_title}}</font>
                                </font>
                            </h6>
                            <div class="card-icon">
                                <i class="fas {{$v->share_icon}}"></i>
                            </div>
                            <h3 class="card-title">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">{{$v->share_title}}</font>
                                </font>
                            </h3>
                            <p class="card-description">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">
                                        {{$v->share_intro}}
                                    </font>
                                </font>
                            </p>
                            <div class="card-footer">
                                <a href="#pablo" class="btn btn-info btn-round card-link" data-toggle="modal"
                                   data-target="#myModal{{$v->id}}">
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;"> 查看详情</font>
                                    </font>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 软件弹出分享详情start -->
                <div class="modal fade" id="myModal{{$v->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$v->id}}"
                     style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <h5 class="modal-title text-center" id="exampleModalLabel{{$v->id}}">{{$v->share_title}}详情描述</h5>
                            </div>
                            <div class="modal-body">
                                {{$v->share_describe}}
                            </div>
                            <div class="modal-footer">
                                <div class="right-side">
                                    <a href="{{$v->share_link}}" target="_blank">
                                        <button type="button" class="btn btn-success btn-link">下载</button>
                                    </a>
                                </div>
                                <div class="divider"></div>
                                <div class="left-side">
                                    <button type="button" class="btn btn-default btn-link" data-dismiss="modal">确定</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- 软件弹出分享详情end -->
        <div class="col-sm-12">
            <div class="pagination-area mt-3">
                {{$share_list->onEachSide(1)->links('vendor.pagination.default')}}
            </div>
        </div>
    </div>

    </body>
    <!--   核心JS文件   -->
    <script src="./assets/js/core/jquery.min.js" type="text/javascript"></script>
    <script src="./assets/js/core/popper.min.js" type="text/javascript"></script>
    <script src="./assets/js/core/bootstrap.min.js" type="text/javascript"></script>
    <!--  开关插件，完整的文档如下：http://www.jque.re/plugins/version3/bootstrap.switch/ -->
    <script src="./assets/js/plugins/bootstrap-switch.js"></script>
    <!--  Sliders插件，完整文档如下：http://refreshless.com/nouislider/ -->
    <script src="./assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
    <!--  pplugin用于日期选取器，完整文档如下：https://github.com/uxsolutions/bootstrap-datepicker -->
    <script src="./assets/js/plugins/moment.min.js"></script>
    <script src="./assets/js/plugins/bootstrap-datepicker.js" type="text/javascript"></script>
    <!-- 工具箱控制中心：视差效果、示例页面脚本等 -->
    <script src="./assets/js/paper-kit.js?v=2.2.0" type="text/javascript"></script>
    <script type="text/javascript">
        function index_blog() {
            window.location.href = "index.html";
        }
    </script>
@endsection