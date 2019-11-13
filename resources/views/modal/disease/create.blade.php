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
                <div class="modal-body" id="form-main">
                       <div class="form-group">
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
                </div>
               <div>
                   <div class="modal-footer">
                       <button type="button" name="addSymptom" id="addSymptom" class="btn btn-primary" data-dismiss="modal"> Add Symptom</button>
                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
{{--                       <button type="submit" onclick="add" class="btn btn-primary">Create</button>--}}
                   </div>
               </div>
            </form>
        </div>
    </div>
</div>
@include('modal.disease.add')
<script>
$('#addSymptom').click(function () {
    $('#addSymptomModal').modal('show');
    console.log(document.getElementById('name').value);
});
$(document).ready(function () {
    $('#SymptomFormAdd').on('submit', function (event) {
        $("#SymptomFormAdd").validate({
            rules: {
                name: "required"
            },
            messages: {
                name: "Vui lòng nhập name"
            }
        });

        if (!$(this).valid()) return false;

        event.preventDefault();

        /**
         * After you've done all manipulations above, you will hide modal => hide form and conduct submit your data.
         */
        $('#createDiseaseModal').modal('hide');
    })
});

</script>
