<div id="page_content_ajax" class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <button id="newCategory" class="btn btn-default" type="button">New Type Disease</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatablesDisease" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Manipulation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('modal.disease.create')
@include('modal.disease.edit')

<script>
    /**
     * This code to get all diseases from Server and
     * show it in DataTables.
     */

    $(document).ready(function () {
        $('#datatablesDisease').dataTable({
            "pageLength": 15,
            "lengthMenu": [[15, 30, 45, -1], [15, 30, 45, 'All']],
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            "processing": true,
            "serverSide": true,

            "ajax": {
                url: '/admin/module/type_disease',
                type: 'GET'
            },

            "columns": [
                {"data": "id"},
                {"data": "name"},
                {
                    "data": "manipulation", "render": function (id) {
                    return '<div class="text-center">'
                        + '<a onclick= "editDisease(' + id + ')"><img src="/images/icon_edit.svg"  width="24px" height="24px"></a>'
                        + '<span>  </span>' + '<a href="javascript:void(0)" onclick="deleteDisease(' + id + ')"><img src="/images/icon_delete.svg"  width="24px" height="24px"></a>'
                        + '</div>';
                }
                },
            ]
        });
    });


    /**
     * We will show form Create Category again.
     * Please make sure you have form create Category in index.blade.php
     * - ('modal.disease.create')
     * - Check id of modal to show createCategoryModal => you can create any modal different for object
     * For example: createDiseaseModal, createSymphonyModal,....
     */
    $('#newDisease').click(function () {
        // This command is shown
        $('#createDiseaseModal').modal('show');
        // This command is used to clear form when you open again.
        $('#diseaseFormCreate').find('input[type=text], input[type=password], input[type=number], input[type=email], textarea').val('');
    });
    /**
     * When you click button <button type="submit" class="btn btn-primary">Create</button>
     * => It automatically call submit form with Ajax.
     * Normally,
     */
    $(document).ready(function () {
        var disease_id;
        $('#diseaseFormCreate').on('submit', function (event) {
            $("#diseaseFormCreate").validate({
                rules: {
                    name: "required",
                },
                messages: {
                    name: "Vui lòng nhập name",
                }
            });
            if (!$(this).valid()) return false;
            event.preventDefault();
            // $('#createDiseaseModal').modal('hide');

            /**
             * Get all value by using attribute name in Form.
             * @type {FormData}
             */
            var formData = new FormData(this);
            console.log(...formData);
            $.ajax({
                url: '/admin/module/type_disease', // URL to submit
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Authenticate with website by token. You just add and don't care it. If you didn't add and you will get error code 419 and search more about it.
                },
                method: 'POST', // Method
                dataType: 'json', // We will send and get data returns as Json.
                data: formData, // Pass data here.
                processData: false,
                contentType: false
            })
                .done(function (data) {
                    // Request Ajax successfully and get response.
                    if (data['message']['status'] === 'invalid') {
                        swal("", data['message']['description'], "error");
                    }
                    if (data['message']['status'] === 'existed') {
                        swal("", data['message']['description'], "error");
                    }
                    if (data['message']['status'] === 'success') {
                        swal("", data['message']['description'], "success");
                        disease_id = data['disease']['id'];
                        var table = $('#datatablesDisease').DataTable();
                        $.fn.dataTable.ext.errMode = 'none';
                        table.row.add(
                            [
                                data['disease']['id'],
                                data['disease']['name'],
                                function (id) {
                                    return '<div class="text-center">'
                                        + '<a onclick= "editDisease(' + id + ')"><img src="/images/icon_edit.svg"  width="24px" height="24px"></a>'
                                        + '<span>  </span>' + '<a href="javascript:void(0)" onclick="deleteDisease(' + id + ')"><img src="/images/icon_delete.svg"  width="24px" height="24px"></a>'
                                        + '</div>';
                                }
                            ]
                        ).draw();
                    } else if (data.status === 'error') {
                        swal("", data['message']['description'], "error");
                    }
                })
                .fail(function (error) {
                    console.log(error);
                });
        });

        function deleteDisease(id) {
            console.log(id);
            $.ajax({
                url: '/admin/module/disease/' + id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                type: "DELETE",
                beforeSend: function () {
                    $('#modal-loading').modal('show');
                }
            })
                .done(function (data) {
                    console.log(data);
                    $('#modal-loading').modal('hide');

                    if (data['message']['status'] === 'success') {
                        swal("", data['message']['description'], "success");
                        var table = $('#datatablesDisease').DataTable();
                        $.fn.dataTable.ext.errMode = 'none';
                        var rows = table.rows().data();
                        for (var i = 0; i < rows.length; i++) {
                            if (rows[i].id === data['id']) {
                                table.row(this).remove().draw();
                            }
                        }
                    }
                    if (data['message']['status'] === 'error') {
                        swal("", data['message']['description'], "error");
                    }
                })
                .fail(function (error) {
                    console.log(error);
                });
        }


        $('#diseaseFormEdit').on('submit', function (event) {
            $("#diseaseFormEdit").validate({
                rules: {
                    name: "required",
                    description: "required"
                },
                messages: {
                    name: "Please fill name",
                    description: "Please fill description"
                }
            });
            if (!$(this).valid()) return false;
            event.preventDefault();

            $('#editDiseaseModal').modal('hide');
            var formData = new FormData(this);
            $.ajax({
                url: '/admin/module/disease/' + $('#editId').val(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false
            })
                .done(function (data) {
                    if (data['message']['status'] === 'invalid') {
                        swal("", data['message']['description'], "error");
                    }
                    if (data['message']['status'] === 'existed') {
                        swal("", data['message']['description'], "error");
                    }
                    if (data['message']['status'] === 'success') {
                        swal("", data['message']['description'], "success");
                        var table = $('#datatablesDisease').DataTable();
                        $.fn.dataTable.ext.errMode = 'none';
                        var rows = table.rows().data();
                        for (var i = 0; i < rows.length; i++) {
                            console.log(rows[i].id);
                            console.log(data['disease']['id']);

                            if (rows[i].id == data['disease']['id']) {
                                console.log("run");
                                table.row(this).data(
                                    [
                                        data['disease']['name'],
                                        function (id) {
                                            return '<div class="text-center">'
                                                + '<a onclick= "editDisease(' + id + ')"><img src="/images/icon_edit.svg"  width="24px" height="24px"></a>'
                                                + '<span>  </span>' + '<a href="javascript:void(0)" onclick="deleteDisease(' + id + ')"><img src="/images/icon_delete.svg"  width="24px" height="24px"></a>'
                                                + '</div>';
                                        }
                                    ]
                                ).draw();
                            }
                        }
                    } else if (data.status === 'error') {
                        swal("", data['message']['description'], "error");
                    }
                })
                .fail(function (error) {
                    console.log(error);
                });
        });


        function editDisease(id) {
            console.log(id);
            $.ajax({
                url: '/admin/module/disease/' + id,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                type: "GET",
                beforeSend: function () {
                    $('#modal-loading').modal('show');
                }
            })
                .done(function (data) {
                    // if(data['message'].status==="success"){
                    //     for( var i = 0; i< data['disease'].length; i++){
                    //         var name0 = data['disease'][i]['name'];
                    //         console.log(i+'a'+name0);
                    //         $('#info_symptom').append(
                    //             '<div class="row" style="margin-top: 20px " id="row'+i+'">' +
                    //             '                            <div class="col-md-9"> \n' +
                    //             '<input disabled name="symptom_name'+i+'" class="form-control" id="symptom'+i+'" value="'+name0+'">' +
                    //             '</div>\n' +
                    //             '      <div class="col-md-3">'+
                    //             ' <button type="button" class="btn btn-secondary btn_remove" id="'+i+'" >X</button>'+
                    //             '                            </div>\n' +
                    //             '                        </div>'
                    //         );
                    //     }
                    // } else {
                    //     $('#info_symptom').append(
                    //         '<div class="input-group" >' +
                    //         '<p>Empty data!</p>' +
                    //         '</div>'
                    //     )
                    // }
                    $('#editId').val(data['disease']['id']);
                    $('#editName').val(data['disease']['name']);
                    $('#modal-loading').modal('hide');
                    $('#editDiseaseModal').modal('show');
                })
                .fail(function (error) {
                    console.log(error);
                });
        }
    });

</script>
