<div class="modal fade" id="editSymModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="text-center">
                    <span class="modal-title" id="exampleModalLabel">Edit Symptom</span>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="SymFormEdit">
                <div class="modal-body">
                    <div class="form-group" id="form-group">
                        <label for="recipient-name" class="col-form-label">Symptoms</label>
                        <div>
                            <div class="row">
                                <div class="col-md-9">
                                    <input name="name" class="form-control" id="name"/>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary"> Add Disease</button>
                                </div>
                            </div>
                        </div>
                        <div class="info_symptom" id="info_symptom" >
{{--                            <input name="name" type="text" class="form-control" style="margin-bottom: 15px" id="editSymName">--}}
{{--                            <input name="id" type="text" class="form-control" id="editSymId">--}}

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn_close"
                            data-dismiss="modal"
                    >Close</button>
{{--                    <button type="submit" class="btn btn-primary update_all" >Update</button>--}}
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '.btn_remove', function () {
        var button_id = $(this).attr("id");
        // var name = $('#symptom'+button_id+'').val();
        $('#row'+button_id+'').remove();
    })
    $(document).ready(function () {
        var disease_id;
        $('#SymFormEdit').on('submit', function (event) {
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
                    if (data['message']['status'] === 'invalid') {
                        swal("", data['message']['description'], "error");
                    }
                    if (data['message']['status'] === 'existed') {
                        swal("", data['message']['description'], "error");
                    }
                    if (data['message']['status'] === 'success') {
                        swal("", data['message']['description'], "success");
                    }
                });
        });
    });


</script>
