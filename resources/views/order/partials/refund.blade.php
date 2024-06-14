<div class="modal fade" id="refundModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="refundModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="refundModalLabel">Refund</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['method' => 'post', 'route' => ['admin.order.refund'], 'enctype' => 'multipart/form-data']) !!}
                    
                    <div class="form-group">
                        <label>Kode Klien</label>
                        <h4 id="kodeKlienRefund"></h4>
                    </div>

                    <div class="form-group">
                        <label>Total Uang Masuk</label>
                        <h4 id="totalPembayaranRefund"></h4>
                    </div>

                    <input type="hidden" name="order_id" id="orderIdRefund">
                    
                    <div class="form-group">
                        <label for="">Nominal</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                Rp
                              </div>
                            </div>
                            <input type="text" name="nominal" class="form-control currency2" value="{{ old('nominal') }}" autocomplete="off">
                        </div>
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
