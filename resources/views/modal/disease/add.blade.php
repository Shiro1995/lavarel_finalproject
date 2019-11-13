<div class="modal fade" id="addSymptomModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLabel">New Disease</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="SymptomFormAdd">
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control">
                            <option selected>Disease</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <select class="form-control">
                                    <option selected>level</option>
                                    <option value="1">0</option>
                                    <option value="2">1</option>
                                    <option value="3">2</option>
                                </select>
                            </div>
                            <div class="col-md-9">
                                <select class="form-control">
                                    <option selected value=false">parent</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <label for="recipient-name" class="col-form-label">Symptom Name:</label>
                            <input name="symptom_name" class="form-control" id="symptom_name">
                        </div>
                        <div class="col-md-3">
                            <button type="button" name="addSymptom" id="addSymptom" class="btn btn-primary"> Add Symptom</button>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
