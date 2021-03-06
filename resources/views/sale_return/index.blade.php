@section('title', '销货退货')
@include('layouts.header')
<body class="gray-bg">
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>销货退货</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="table_basic.html#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <a href="table_basic.html#">选项1</a>
                        </li>
                        <li>
                            <a href="table_basic.html#">选项2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="ibox-content">
                    <div class="row">
                        <form action="/salereturn" method="get" class="col-sm-12">
                            <div class="form-group" id="data_5">
                                <label>日期：</label>
                                <div class="input-daterange input-group" id="datepicker">
                                    <input class="form-control layer-date" placeholder="YYYY-MM-DD" onclick="laydate({istime: true, format: 'YYYY-MM-DD'})" style="background: white" readonly name="start_date">
                                    <span class="input-group-addon">到</span>
                                    <input class="form-control layer-date" placeholder="YYYY-MM-DD" onclick="laydate({istime: true, format: 'YYYY-MM-DD'})" readonly  style="background: white" name="end_date">
                                </div>
                            </div>

                            <div class="form-group" style="width: 395px">
                                <label>客户：</label>
                                <div>
                                    <select class="form-control m-b" name="client">
                                        <option></option>
                                        @foreach($client as $key => $value)
                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" value="" name="status">

                            <div class="form-group" style="width: 395px">
                                <label>销售人员：</label>
                                <div>
                                    <select class="form-control m-b" name="staff">
                                        <option></option>
                                        @foreach($staff as $key => $value)
                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" style="width: 395px">
                                <label>单据编号：</label>
                                <div>
                                    <input type="text" class="form-control" name="document_number" placeholder="请输入单据编号">
                                </div>
                            </div>



                            <div class="form-group">
                                <div>
                                    <button class="btn btn-primary btn-sm" type="submit">查询内容</button>
                                    @can('add saleReturn')
                                    <a class="btn btn-info btn-sm " type="button" href="/salereturn/create"><i class="glyphicon glyphicon-plus"></i> 新增</a>
                                    @endcan
                                    <a class="btn btn-info btn-sm " type="button" href="/salereturn/excel"><i class="glyphicon glyphicon-share"></i> 导出Excel</a>
                                    <a class="btn btn-warning btn-sm " type="button" href="/salereturn"><i class="glyphicon glyphicon-refresh"></i>  重置 / 刷新</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <div class="text-center">
                            @if(!empty(session('success')))
                                <div class="alert alert-success">
                                    {{session('success')}}
                                    <button type="button" class="close" data-dismiss="alert">
                                        <span>&times;</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="text-center"></th>
                                <th class="text-center">序号</th>
                                <th class="text-center">单据日期</th>
                                <th class="text-center">单据编号</th>
                                <th class="text-center">客户</th>
                                <th class="text-center">销售人员</th>
                                <th class="text-center">销货金额</th>
                                <th class="text-center">优惠后金额</th>
                                <th class="text-center">已退款款</th>
                                <th class="text-center">退款状态</th>
                                <th class="text-center">制单人</th>
                                <th class="text-center">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($model as $key => $value)
                                <tr>
                                    <td class="sorting_1">
                                        <div class="text-center">
                                            <input type="checkbox" name="check[]"  yang="yang"  value="{{$value->id}}" >
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if(isset($_GET['page']))
                                            {{($key+1)+($_GET['page']-1)*2}}
                                        @else
                                            {{($key+1)+(1-1)*2}}
                                        @endif
                                    </td>
                                    <td class="text-center">{{$value->created_at}}</td>
                                    <td class="text-center">{{$value->document_number}}</td>
                                    <td class="text-center">{{$value->getClient->name}}</td>
                                    <td class="text-center">{{$value->getStaff->name}}</td>
                                    <td class="text-center">
                                        @php
                                            $number = 0;
                                            for ($i = 0; $i <sizeof($value->getSaleReturnExtend); $i++){
                                                 $number+=$value->getSaleReturnExtend[$i]->purchase_amount;
                                             }
                                             echo $number;
                                        @endphp
                                    </td>

                                    <td class="text-center">
                                        @php
                                            $number = 0;
                                            for ($i = 0; $i <sizeof($value->getSaleReturnExtend); $i++){
                                                 $number+=$value->getSaleReturnExtend[$i]->purchase_amount;
                                             }
                                             if ($value->preferential_rate == 0){
                                                echo $number;
                                             }else{
                                                $preferential_rate = ($value->preferential_rate/100);
                                                echo  $number*$preferential_rate;
                                             }
                                        @endphp
                                    </td>

                                    <td class="text-center">{{$value->paid}}</td>

                                    <td class="text-center">
                                        @php
                                            $number = 0;
                                            for ($i = 0; $i <sizeof($value->getSaleReturnExtend); $i++){
                                                 $number+=$value->getSaleReturnExtend[$i]->purchase_amount;
                                            }
                                            if ($value->preferential_rate == 0){
                                                 $number;
                                            }else{
                                                $preferential_rate = ($value->preferential_rate/100);
                                                $number =  $number*$preferential_rate;
                                            }

                                            if ($value->paid==0){
                                                echo '未退款';
                                            }else if($value->paid < $number){
                                                echo '部分退款';
                                            }else if($value->paid == $number){
                                                echo '已退完全款';
                                            }
                                        @endphp
                                    </td>

                                    <td class="text-center">{{$value->user_name}}</td>

                                    <td class="text-center">
                                        <a href="/salereturn/{{$value->id}}" class="btn btn-primary btn-sm " type="button"><i class="fa fa-money"></i> 查看</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        {{$model->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.loading')
@include('layouts.footer')

