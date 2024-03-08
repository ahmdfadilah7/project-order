<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah File Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['method' => 'post', 'route' => ['admin.fileproject.store'], 'enctype' => 'multipart/form-data']) !!}
                    <div class="form-group">
                        <label>Project</label>
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <input type="text" name="project" class="form-control" value="{{ $order->project->judul }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>File Project</label>
                        <input type="file" name="file" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" class="form-control">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Simpan</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
