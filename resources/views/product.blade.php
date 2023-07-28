<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container">
    <div class="container">
        <h2>Product List</h2>
        <a href="{{url('add-form')}}" class="btn btn-info">Add Product</a>
    </div>
        <div class="card-body card-filter flex-container farmer-filter px-0">
                    <form class="row gx-3 gy-2 align-items-center form-filter">
                            <div class="col-sm-2">
                                <select id="username" name="username" class="form-control select2">
                                        <option  value="">Select name</option>
                                        @if($Users)
                                        @foreach($Users as $User)
                                            <option value="{!! $User->id !!}">{!! $User->name !!}</option>
                                        @endforeach
                                        @endif
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-rounded btn-danger filter-remove"><span class="btn-icon-start text-dangers"><i class="fa fa-filter color-danger"></i> </span>Clear</button>
                            </div>
                    </form>
                </div>
        <table class="table table-bordered dt-responsive nowrap display data-table">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>User Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                </tr>
            </thead>
        </table>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>


    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script> -->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> -->
    <script>
        
        var table=$('.data-table').DataTable({
            "processing": true,
            "serverSide": true,
            'responsive': true,
            "pageLength": 20,
            "ajax": {
                "url": "",
                "type": "GET",
                    "data":function(data){
                            data._token="{!! csrf_token() !!}";
                            $('.card-filter select').each(function(){
                                if($(this).val()){
                                        data[$(this).attr('name')]=$(this).val();
                                }
                            });
                    }
            },
            // "aaSorting": [[ 0, "asc" ]],
            "columns": [
                { "data": 'id',"name":'id','orderable': false, 'searchable': false,'width':'5%'},
                { "data": "name","name":"name",defaultContent:''},
                { "data": "username","name":"username",defaultContent:'NA'},
                { "data": "phone","name":"phone",defaultContent:''},
                { "data": "email","name":"email"},
            ],
            "columnDefs": [
                {render: function (data, type, row, meta) {
                        return meta.row+1;
                    },
                    "targets":0,
                },
            ],
        });

        $('.filter-remove').on('click',function(e){
            e.preventDefault();
            $(".form-filter select").val("").trigger('change');
        });

        $('.card-filter select').on('change',function(){
            $(".data-table").DataTable().ajax.reload();
        });


        // $('#username').select2({
        //     selectOnClose: true
        // });
    </script>
</body>
</html>
