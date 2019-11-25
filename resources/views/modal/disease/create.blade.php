<div class="modal fade" id="createDiseaseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLabel">New Disease</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="diseaseFormCreate">
                <div class="modal-body" >
                       <div class="form-group" id="form-main">
                           <label for="recipient-name" class="col-form-label">Disease Name:</label>
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
                       </div>
                    <div class="form-group" id="form-add">
                        <label for="recipient-name" class="col-form-label">Symptom Name:</label>
                        <div class="row">
                            <div class="col-md-9">
                                <input name="symptom_name" class="form-control" id="symptom_name">
                            </div>
                            <div class="col-md-3">
                                <button type="button" name="addSymptom" id="addMore" class="btn btn-danger btn_add ">+</button>
                            </div>
                        </div>

                    </div>
                </div>
               <div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary "
                               data-dismiss="modal"
                       >Close</button>
{{--                       <button type="submit" onclick="add" class="btn btn-primary">Create</button>--}}
                   </div>
               </div>
            </form>
        </div>
    </div>
</div>
@include('modal.disease.add')
<script>
    $(document).ready(function () {
        var i =1;

        // $('#addMore').click(function (event) {
        //     if($('#symptom_name').val().length!==0) {
        //         // var hi = confirm('do you want to create the Symptom?')
        //         // if (hi === true) {
        //         event.preventDefault();
        //         i++;
        //         var inputcontent = $('#symptom_name').val();
        //         var formData = new FormData();
        //         formData.append('symptom_name', inputcontent);
        //         $.ajax({
        //             url: '/admin/module/symptom', // URL to submit
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Authenticate with website by token. You just add and don't care it. If you didn't add and you will get error code 419 and search more about it.
        //             },
        //             method: 'POST', // Method
        //             dataType: 'json', // We will send and get data returns as Json.
        //             data: formData, // Pass data here.
        //             processData: false,
        //             contentType: false
        //         })
        //             .done(function (data) {
        //                 // Request Ajax successfully and get response.
        //                 if (data['message']['status'] === 'invalid') {
        //                     swal("", data['message']['description'], "error");
        //                 }
        //                 if (data['message']['status'] === 'existed') {
        //                     swal("", data['message']['description'], "error");
        //                 }
        //                 if (data['message']['status'] === 'success') {
        //                     swal("", data['message']['description'], "success");
        //                 } else if (data.status === 'error') {
        //                     swal("", data['message']['description'], "error");
        //                 }
        //             })
        //             .fail(function (error) {
        //                 console.log(error);
        //             });
        //
        //     };
        //
        // });
        $(document).on('click', '.btn_remove', function () {
                     var button_id = $(this).attr("id");
            $("#row" + button_id + "").remove();
        })
        function getID(){

        }

    });




</script>
