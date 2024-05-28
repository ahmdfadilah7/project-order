<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['method' => 'post', 'route' => ['admin.fileproject.store'], 'enctype' => 'multipart/form-data']) !!}
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Karyawan</label>
                            <select name="penjoki" class="form-control">
                                <option value="">- Pilih -</option>
                                @foreach ($penjoki as $row)
                                    <option value="{{ $row->id }}" @if(old('penjoki')==$row->id) selected @endif>{{ $row->name }}</option>
                                @endforeach
                            </select>
                            <i class="text-danger">{{ $errors->first('penjoki') }}</i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
