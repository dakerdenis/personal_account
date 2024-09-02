<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete <span class="recordName" ></span></h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <span class="recordName" ></span></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
                <form action="" method="post" id="deleteRecord">@method('delete') @csrf
                    <button class="btn btn-danger" type="submit">Delele</button>
                </form>
            </div>
        </div>
    </div>
</div>
