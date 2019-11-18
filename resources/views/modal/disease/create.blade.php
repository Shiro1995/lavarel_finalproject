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
                                <button type="button" name="addSymptom" id="addMore" class="btn btn-danger ">+</button>
                            </div>
                        </div>

                    </div>
                </div>
               <div>
                   <div class="modal-footer">
                       <button type="button" name="addSymptom" id="addSymptom" class="btn btn-primary" data-dismiss="modal"> Add Symptom</button>
                       <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
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
        $('#addMore').click(function () {
            i++;
            if($('#symptom_name').val().length!==0){
                var inputcontent = $('#symptom_name').val();
                console.log(inputcontent);
                $('#form-add').append(
                    '<div class="row" style="margin-top: 20px " id="row'+i+'">' +
                    '                            <div class="col-md-9"> \n' +
                    '                                <input disabled name="symptom_name'+i+'" class="form-control" id="symptom'+i+'" value="'+inputcontent+'">\n' +
                    '                            </div>\n' +
                    '                            <div class="col-md-3"> \n' +
                    ' <button type="button" class="btn btn-secondary btn_remove" id="'+i+'" >X</button>'+
                    '                            </div>\n' +
                    '                        </div>'
                )
            };
    });

        $(document).on('click', '.btn_remove', function () {
                var button_id = $(this).attr("id");
                $("#row"+button_id+"").remove();
        })
    });




</script>
