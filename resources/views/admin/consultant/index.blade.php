
<x-app-layout>
@section("css")
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <style>
    select{
        min-width: 55px;
    }

    .new {
        padding: 50px;
    }

    .form-group {
        display: block;
        margin-bottom: 15px;
    }

    .form-group input {
        padding: 0;
        height: initial;
        width: initial;
        margin-bottom: 0;
        display: none;
        cursor: pointer;
    }

    .form-group label {
        position: relative;
        cursor: pointer;
    }

    .form-group label:before {
        content:'';
        -webkit-appearance: none;
        background-color: transparent;
        border: 2px solid #0079bf;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
        padding: 10px;
        display: inline-block;
        position: relative;
        vertical-align: middle;
        cursor: pointer;
        margin-right: 5px;
    }

    .form-group input:checked + label:after {
        content: '';
        display: block;
        position: absolute;
        top: 2px;
        left: 9px;
        width: 6px;
        height: 14px;
        border: solid #0079bf;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    </style>
@endsection
    <div class="container" style="padding: 100px 300px" >

        <div class="d-flex text-center" >
            <h1 style="font-size: 30px" >Consultants</h1>
        </div>
        <div class="card">
            <div class="card-body">

                <div class="table-responsive">

                    <table id="consultant-table" class="table table-bordered table-condensed table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th width="70">Status</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>


    @section("script")
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {

              const datatable = $('#consultant-table').DataTable({
                    ajax: "{{route('admin.consultant.index')}}",
                    serverSide: true,
                    processing: true,
                    aaSorting:[[0,"asc"]],
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'name', name: 'name'},
                        {data: 'email', name: 'email'},
                        {data: 'is_approved', name: 'is_approved',
                            render: function(data, type, full, meta) {
                              let html = `<div class="form-group"><input type="checkbox"  ${data ? "checked" : ""} class="aproved-checkbox" data-id="${full.id}"  id="checkbox-${full.id}"> <label for="checkbox-${full.id}"></label></div>`;
                              return html;
                        }},

                    ]
                });

                $(document).on('change','.aproved-checkbox',function(){
                    const userId = $(this).data("id");
                    const checkbox = $(this);

                    if (checkbox.prop('checked')) {
                        checkbox.prop('checked', false);
                    }else{
                        checkbox.prop('checked', true);
                    }

                    $.ajax({
                        type: 'POST',
                        url: '{{route('admin.consultant.approve')}}',
                        data: {"userId":userId},
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': "{{csrf_token()}}"
                        }
                    }).done(function(result) {

                        let message = "";

                        if(result.approved){
                            checkbox.prop('checked', true);
                            message = "Consultant account successfully approved";
                        }else{
                            checkbox.prop('checked', false);
                            message = "Consultant account is deactivated.";
                        }

                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: message,
                            showConfirmButton: false,
                            timer: 1500
                        });

                    }).fail(function(xhr, status, error) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Unexpected error",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        });
                })
            })
        </script>

    @endsection
</x-app-layout>




