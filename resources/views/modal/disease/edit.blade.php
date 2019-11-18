<div class="modal fade" id="editDiseaseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
               <div class="text-center">
                   <span class="modal-title" id="exampleModalLabel">Edit Disease</span>
               </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="diseaseFormEdit">
                <div class="modal-body">
                    <div class="form-group" id="form-group">
                        <label for="recipient-name" class="col-form-label">Disease Name:</label>
                        <div class="info_symptom" id="info_symptom" >
                            <div class="row">
                                <div class="col-md-9">
                                    <input name="name" type="text" class="form-control" style="margin-bottom: 15px" id="editName">
                                    <input name="id" type="hidden" class="form-control" id="editId">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary " >Update</button>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" > Update symptom</button>
                    <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>

                </div>
            </form>
        </div>
    </div>
</div>

