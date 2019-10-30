<div class="modal fade" id="createCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLabel">New Category</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!--
                Normally, we will submit form and we need declare information in header of form
                action = ?
                method = ?
                Here, we no need to do it. We use Ajax and submit follow this direction.
                Please notice here.
            -->
            <form id="categoryFormCreate">
                <!--
                    This is form, you can add tag input, text area,... if you want create any object here.
                    Please two field in tag input, ...
                    Get example: <input name="name" class="form-control" id="name"/>
                    When you get value from tag input we use id field which name is name
                    => Set/Get Value : $('#name').val() or $('#name').val('Data you want set here')
                    Id also used for validate from by Jquery, you can research more here:  https://thienanblog.com/javascript/jquery/huong-dan-su-dung-jquery-validation/

                    We have name="name". When we submit, Server get object Request and query using attribute name.
                    If you want to know input is submit successfully to Server, you will use
                    \Log::info($request->name)
                    Understand?
                    yes
                 -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Category Name:</label>
                        <input name="name" class="form-control" id="name"/>
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
