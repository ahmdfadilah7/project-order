<div class="modal fade" id="paymentModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['method' => 'post', 'route' => ['pelanggan.order.payment'], 'enctype' => 'multipart/form-data']) !!}
                    
                    <div class="form-group">
                        <input type="hidden" name="order_id" id="orderId">
                        <label>Bukti Pembayaran</label>
                        <input type="file" name="file" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control selectric">
                            <option value="">- Pilih -</option>
                            @foreach($status as $key => $value)
                                <option value="{{ ++$key }}">{{ $value }}</option>
                            @endforeach
                        </select>
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
