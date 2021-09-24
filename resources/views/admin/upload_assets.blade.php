<div class="modal fade" id="uploadAssetsModal" tabindex="-1" role="dialog" aria-labelledby="uploadAssetsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload Assets</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <input type="file" class="form-control-file" id="asset-file" name="asset_file" accept="image/*,video/mp4,video/x-m4v,video/*,application/pdf">

            <div class="mt-3">
                <h6>Assets</h6>
                <div id="assets-container">
                @if(!count($assets))
                <i>No assets found</i>
                @endif
                @include('admin.assets')
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<style>
.list-group{
    max-height: 200px;
    margin-bottom: 10px;
    overflow:scroll;
    -webkit-overflow-scrolling: touch;
}
</style>
