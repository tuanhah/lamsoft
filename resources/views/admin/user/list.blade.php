@extends('admin.layout.index')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Danh sách</h4> 
            </div>                    
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="white-box">
                    <h3 class="page-title">NGƯỜI DÙNG GẦN ĐÂY</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th>Avatar</th>
                                    <th>Email</th>
                                    <th>SĐT</th>
                                    <th>Cấp</th>
                                    <th>Xóa</th>
                                    <th>Sửa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user as $u)
                                <tr class="odd gradeX">
                                    <td>{{$u->id}}</td>
                                    <td>{{$u->fullname}}</td>
                                    <td><img width="100px" src="upload/avatar/{{$u->avatar}}"/></td>
                                    <td>{{$u->email}}</td>
                                    <td>{{$u->phone_number}}</td>
                                    <td>
                                        @if($u->level==1)
                                            {{"Manager"}}
                                        @else
                                            {{"Staff"}}
                                        @endif
                                    </td>
                                    <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/user/delete/{{$u->id}}"> Xóa</a></td>
                                    <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/user/edit/{{$u->id}}">Sửa</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection