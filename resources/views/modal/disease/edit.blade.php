{{--<div class="modal fade" id="editDiseaseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--    <div class="modal-dialog" role="document">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--               <div class="text-center">--}}
{{--                   <span class="modal-title" id="exampleModalLabel">Edit Disease</span>--}}
{{--               </div>--}}
{{--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                    <span aria-hidden="true">&times;</span>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--            <form id="diseaseFormEdit">--}}
{{--                <div class="modal-body">--}}
{{--                    <div class="form-group" id="form-group">--}}
{{--                        <label for="recipient-name" class="col-form-label">Disease Name:</label>--}}

{{--                            <div class="row">--}}
{{--                                <div class="col-md-9">--}}
{{--                                    <input name="name" type="text" class="form-control" style="margin-bottom: 15px" id="editName">--}}
{{--                                    <input name="id" type="hidden" class="form-control" id="editId">--}}
{{--                                </div>--}}
{{--                                <div class="col-md-3">--}}
{{--                                    <button type="submit" class="btn btn-primary " >Update</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-primary btn_update" > Update symptom</button>--}}
{{--                    <button type="button" class="btn btn-secondary "--}}
{{--                            data-dismiss="modal"--}}
{{--                    >Close</button>--}}

{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--@include('modal.disease.editSymptom')--}}
{{--<script>--}}


{{--    $(document).ready(function () {--}}
{{--        var inputdata = [];--}}
{{--        $(document).on('click', '.btn_update', function () {--}}
{{--            // $('#editId').val)--}}
{{--            $('#editDiseaseModal').modal('hide');--}}
{{--            $('#editSymModal').modal('show');--}}
{{--                $.ajax({--}}
{{--                    url: 'admin/module/disease/definitions/' + $('#editId').val(),--}}
{{--                    headers: {--}}
{{--                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--                    },--}}
{{--                    dataType: 'json',--}}
{{--                    type: "GET",--}}
{{--                })--}}
{{--                    .done( function (data) {--}}

{{--                        console.log(data['disease']);--}}
{{--                        inputdata = data['disease'];--}}
{{--                        // if (data['message']['status'] === 'invalid') {--}}
{{--                        //     swal("", data['message']['description'], "error");--}}
{{--                        // }--}}
{{--                        if (data['message']['status'] === 'existed') {--}}
{{--                            swal("", data['message']['description'], "error");--}}
{{--                        }--}}
{{--                        if (data['message']['status'] === 'success') {--}}
{{--                            // swal("", data['message']['description'], "success");--}}
{{--                            $('#modal-loading').modal('hide');--}}
{{--                            for(var i = 0; i < data['disease'].length; i++){--}}
{{--                                var inputcontent = data['disease'][i];--}}
{{--                                $('#info_symptom').append(--}}
{{--                                    '<div class="row" style="margin-top: 20px " id="row'+inputcontent['id']+'">' +--}}
{{--                                    '                            <div class="col-md-9"> \n' +--}}
{{--                                    '                                <input name="symptom_name'+inputcontent['id']+'" type="text" class="form-control" id="symptom' + inputcontent['id'] + '" value="' + inputcontent['name'] + '">\n' +--}}
{{--                                    '                            </div>\n' +--}}
{{--                                    '<div class="col-md-2"> \n' +--}}
{{--                                     ' <button type="button" class="btn btn-default update_symptom" id="' +inputcontent['id']+ '" >Chỉnh sửa</button>' +--}}
{{--                                     '                            </div>\n' +--}}
{{--                                        '<div class="col-md-1">  '+--}}
{{--                                     ' <button type="button" class="btn btn-secondary btn_remove" id="' +inputcontent['id']+ '" >X</button>' +--}}
{{--                                     '                            </div>\n' +--}}
{{--                                    '                        </div>'--}}
{{--                                )--}}
{{--                            }--}}
{{--                        }--}}
{{--                        // else if (data.status === 'error') {--}}
{{--                        //     swal("", data['message']['description'], "error");--}}
{{--                        // }--}}
{{--                    })--}}

{{--        })--}}

{{--        $(document).on('click', '.update_symptom', function () {--}}
{{--            if (!$(this).valid()) return false;--}}

{{--             var button_id = $(this).attr("id")--}}

{{--            var nameSym = $('#definitions'+button_id+'').val();--}}

{{--            var formData = new FormData();--}}
{{--             formData.append('name',nameSym)--}}
{{--            $.ajax({--}}
{{--                url: '/admin/module/definitions/' + button_id,--}}
{{--                headers: {--}}
{{--                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--                },--}}
{{--                method: 'POST',--}}
{{--                dataType: 'json',--}}
{{--                data: formData,--}}
{{--                processData: false,--}}
{{--                contentType: false--}}
{{--            })--}}
{{--                .done(function (data) {--}}
{{--                    if (data['message']['status'] === 'success') {--}}
{{--                        swal("", data['message']['description'], "success");--}}
{{--                       $('#definitions'+button_id+'').val(nameSym);--}}
{{--                    }--}}
{{--                })--}}
{{--        })--}}
{{--        $(document).on('click', '.btn_remove', function () {--}}
{{--            var button_id = $(this).attr("id");--}}
{{--            $.ajax({--}}
{{--                url: '/admin/module/definitions/' + button_id,--}}
{{--                headers: {--}}
{{--                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--                },--}}
{{--                dataType: 'json',--}}
{{--                type: "DELETE",--}}
{{--            })--}}
{{--                    .done(function (data) {--}}
{{--                        console.log(data);--}}

{{--                        if (data['message']['status'] === 'success') {--}}
{{--                            swal("", data['message']['description'], "success");--}}
{{--                            // $('#row'+button_id+'').remove()--}}
{{--                        }--}}
{{--                        if (data['message']['status'] === 'error') {--}}
{{--                            swal("", data['message']['description'], "error");--}}
{{--                        }--}}
{{--                    })--}}
{{--                    .fail(function (error) {--}}
{{--                        console.log(error);--}}
{{--                    });--}}

{{--        });--}}

{{--        $(document).on('click', '.btn_close', function () {--}}
{{--                if(inputdata!=null){--}}
{{--                    for( var i =0 ; i < inputdata.length; i++) {--}}
{{--                        $('#row'+inputdata[i]['id']+'').remove()--}}
{{--                    }--}}
{{--                }--}}
{{--        })--}}

{{--    });--}}
{{--</script>--}}
