<div class="modal fade" id="editSymModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <form id="SymFormEdit">
                <div class="modal-body">
                    <div class="form-group" id="form-group">
                        <label for="recipient-name" class="col-form-label">Disease Name:</label>
                        <div class="info_symptom" id="info_symptom" >
                            <input name="name" type="text" class="form-control" style="margin-bottom: 15px" id="editName">
                            <input name="id" type="text" class="form-control" id="editId">

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary bt_removeAll"
                            data-dismiss="modal"
                    >Close</button>
                    <button type="submit" class="btn btn-primary update_all" >Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '.bt_removeAll', function () {
        console.log('xin chao')
        $('#info_symptom').remove();
        $('#form-group').append(
            ' <div class="info_symptom" id="info_symptom" >'+
            '</div>'
        );

    });
    $(document).on('click', '.update_all', function () {
        $('#info_symptom').remove();
        $('#form-group').append(
            ' <div class="info_symptom" id="info_symptom" >'+
            '</div>'
        );

    });
</script>
