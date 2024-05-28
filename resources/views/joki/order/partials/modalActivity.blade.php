<div class="modal fade" id="modalActivity" tabindex="-1" aria-labelledby="modalActivityLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalActivityLabel">Tambah Aktivitas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['method' => 'post', 'route' => ['penjoki.fileproject.activity-store']]) !!}
                <div class="mb-3">
                    <label for="floatingTextarea2">Judul Aktivitas</label>
                    <input type="hidden" name="order_id" value={{ $order->id }} />
                    <textarea class="form-control" placeholder="Sedang mengerjakan.." id="floatingTextarea2" row="4"
                        style="resize: none;" name="judul_aktivitas"></textarea>
                </div>
                <div class="form-check">
                  <input class="form-check-input" name="status" type="checkbox" value="1" id="flexCheckDefault" />
                  <label class="form-check-label" for="flexCheckDefault">
                    Sudah selesai
                  </label>
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
