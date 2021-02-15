@extends('admin.layouts.core')
@section('content')

<section class="content">
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body block-header">
                        <div class="row">
                            <div class="col-lg-6 col-md-8 col-sm-12">
                                <h2>Orders</h2>
                                <ul class="breadcrumb p-l-0 p-b-0 ">
                                    <li class="breadcrumb-item"><a href="{{ URL::to('/'.Core::getAdminURI().'dashboard') }}"><i class="icon-home"></i></a></li>
                                    <li class="breadcrumb-item active">Orders</li>
                                </ul>
                            </div>            
                            <div class="col-lg-6 col-md-4 col-sm-12 text-right">
                                <a href="{{ URL::to('/'.Core::getAdminURI().'order/new') }}" class="btn btn-primary btn-round btn-simple float-right hidden-xs m-l-10">Create New</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body"> 
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#published" aria-expanded="true">Published ({{ $publishCount }})</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#trash" aria-expanded="false">Trash ({{ $trashCount }})</a></li>                        
                        </ul>                        
                        <!-- Tab panes -->
                        <div class="tab-content">
                            @include('admin.snippets.messages',['errors'=>$errors])
                            <div role="tabpanel" class="tab-pane in active" id="published" aria-expanded="true"> 
                                <div class="body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover dataTable" id="publish-table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Order#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Quantity</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Order#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Quantity</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="trash" aria-expanded="false">
                                <div class="body">
                                    <div class="table-responsive">
                                        <table style="width: 99%" class="table table-bordered table-striped table-hover dataTable" id="trashed-table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Order#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Quantity</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Order#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Quantity</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
        <!-- #END# Basic Examples --> 
    </div>
</section>
@section('script')
<script>
    function getTableData(selector, recordType) {
        $(selector).DataTable({
            "processing": true,
            "serverSide": true,
            "aaSorting": [[0, 'desc']],
            "ajax": {
                "url": BASEPATH + "order/get-data",
                "dataType": "json",
                "type": "POST",
                "data": {_token: "{{csrf_token()}}", 'record_type': recordType}
            },
            "columns": [
                {"data": "id"},
                {"data": "order_no"},
                {"data": "customer_name"},
                {"data": "email"},
                {"data": "phone"},
                {"data": "quantity"},
                {"data": "total"},
                {"data": "status"},
                {"data": "date"}
            ],
            "columnDefs": [
                {
                    "className": "dt-center",
                    "targets": [2],
                    "searchable": true,
                    "orderable": true,
                    "render": function (data, type, row) {
                        var resultHtml = '';
                        resultHtml = '<a href="' + BASEPATH + 'order/edit/' + row.id + '" title="Edit">' + row.customer_name + '</a> ';
                        return resultHtml;
                    }

                },
                {
                    "className": "dt-center",
                    "targets": [9],
                    "searchable": true,
                    "orderable": true,
                    "render": function (data, type, row) {
                        var resultHtml = '';
                        if (recordType != 'trashed') {
                            resultHtml = '<a href="' + BASEPATH + 'order/edit/' + row.id + '" title="Edit"><i class="material-icons">edit</i></a> ';
                            resultHtml += '<a class="confirmation" href="' + BASEPATH + 'order/delete/' + row.id + '" title="Delete"><i class="material-icons">delete</i></a>';
                        }
                        return resultHtml;
                    }

                }
            ]
        });
    }

    $(function () {
        getTableData('#publish-table', 'published');
        getTableData('#trashed-table', 'trashed');


    });
</script>
@stop
@endsection
