<?php
/**
 * Created by PhpStorm.
 * User: vuongluis
 * Date: 4/7/2018
 * Time: 11:11 AM
 */

?>

<div id="page_content_ajax" class="right_col" role="main">
    <div class="">
        <div class="page-title">

            <div class="x_title">
                <button id="newDisease" class="btn btn-default" type="button">New Disease</button>
                <div class="clearfix"></div>
            </div>
            <div class="title_right">
{{--                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">--}}
{{--                    <div class="input-group">--}}
{{--                        <input type="text" class="form-control" placeholder="Search for...">--}}
{{--                        <span class="input-group-btn">--}}
{{--                      <button class="btn btn-default" type="button">Go!</button>--}}
{{--                    </span>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Default Example
                            <small>Users</small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Settings 1</a>
                                    </li>
                                    <li><a href="#">Settings 2</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <p class="text-muted font-13 m-b-30">
                            DataTables has most features enabled by default, so all you need to do to use it with your
                            own tables is to call the construction function: <code>$().DataTable();</code>
                        </p>
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
            "lengthMenu": [[15,30,45,-1], [15,30,45,'All']],
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            "processing": true,
            "serverSide": true,

            "ajax": {
                url: '/admin/module/disease',
                type: 'GET'
            },



            "columns": [
                { "data": "id" },
                { "data": "name"},
                { "data": "manipulation", "render": function (id) {
                    return '<div class="text-center">'
                        + '<a onclick= "editDisease('+id+')"><img src="/images/icon_edit.svg"  width="24px" height="24px"></a>'
                        + '<span>  </span>' + '<a href="javascript:void(0)" onclick="deleteDisease('+id+')"><img src="/images/icon_delete.svg"  width="24px" height="24px"></a>'
                        + '</div>';
                }},
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
        $('#diseaseFormCreate').on('submit', function (event) {
            /**
             * This code blocks to validate Form using Jquery validate.
             * As I told you before: https://thienanblog.com/javascript/jquery/huong-dan-su-dung-jquery-validation/
             * Please take a look and observe if you want to understand validate more in blade file.
             *
             * What does it mean?
             * rules: allow you to add field need to validate: name <name get from attribute id in tag input)
             * messages: allow you to show message error when user didn't obey your rules with the same field.
             */
            $("#diseaseFormCreate").validate({
                rules: {
                    name: "required",
                    create_at: "required"
                },
                messages: {
                    name: "Vui lòng nhập name",
                    create_at: "Vui lòng nhập Ngày tạo",
                }
            });

            /**
             * This command is check validate successfully. If it's failure and return false.
             * You can go to the next step.
             * If you remove this line and you ignore check validation in blade.
             * The code blocks above doesn't mean.
             */
            if (!$(this).valid()) return false;

            /**
             * event.preventDefault() to prevent navigate to another page.
             * Basic of Ajax, it call inside page and get result inside page.
             * There are two cases to prevent:
             * Using this command
             * If you use tag a and you should add javascript:void(0) in attribute href.
             */
            event.preventDefault();

            /**
             * After you've done all manipulations above, you will hide modal => hide form and conduct submit your data.
             */
            // $('#createDiseaseModal').modal('hide');

            /**
             * Get all value by using attribute name in Form.
             * @type {FormData}
             */
            var formData = new FormData(this);
            $.ajax({
                url: '/admin/module/disease', // URL to submit
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
                    /**
                     * To know exactly, when you've submit and your Ajax call where.
                     * Please using php artisan route:list to check route, Controller and Method is called.
                     * Inside, let's see it:
                     * admin/module/disease  App\Http\Controllers\Dashboard\DiseaseController@store
                     * What you are doing here?
                     * You want to create Category why you navigate to DiseaseController?
                     * OK. I'm in wrong file.
                     * Can you understand it?
                     * a little :D
                     * I'll try to explain clearly for you and
                     */
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
        $("#diseaseFormEditFormEdit").validate({
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
                $('#editId').val(data['disease']['id']);
                $('#editName').val(data['disease']['name']);
                $('#modal-loading').modal('hide');
                $('#editDiseaseModal').modal('show');
            })
            .fail(function (error) {
                console.log(error);
            });
    }
</script>
