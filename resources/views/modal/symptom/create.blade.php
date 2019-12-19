<div class="modal fade" id="createDefinitionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLabel">New Symptom</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="DefinitionFormCreate">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
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
                    </div>
                       <div class="col-md-12">
                           <div class="form-group">
                               <label for="recipient-name" class="col-form-label">Symptom Name:</label>
                               <input name="symptom_name" class="form-control" id="name"/>
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
