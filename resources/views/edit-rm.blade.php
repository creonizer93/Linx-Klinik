@extends('master')
@foreach ($metadatas as $metadata)
  @section('judul_halaman')
    {{ $metadata->Judul }}
  @endsection
  @section('deskripsi_halaman')
    {{ $metadata->Deskripsi }}
  @endsection
@endforeach
@section('konten')
  <!--Modal Konfirmasi Delete-->
  <div id="DeleteModal" class="modal fade text-danger" role="dialog">
    <div class="modal-dialog modal-dialog modal-dialog-centered ">
      <!-- Modal content-->
      <form action="" id="deleteForm" method="post">
        <div class="modal-content">
          <div class="modal-header bg-danger">
            <h4 class="modal-title text-center text-white">Konfirmasi Penghapusan</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <p class="text-center">Apakah anda yakin untuk menghapus Rekam Medis? Data yang sudah dihapus tidak bisa
              kembali</p>
          </div>
          <div class="modal-footer">
            <center>
              <button type="button" class="btn btn-success" data-dismiss="modal">Tidak, Batal</button>
              <button type="button" name="" class="btn btn-danger" data-dismiss="modal" onclick="formSubmit()">Ya,
                Hapus</button>
            </center>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!--End Modal-->
  <div class="card shadow mb-4">
    <a href="#Identitas" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"
      aria-controls="Identitas">
      <h6 class="m-0 font-weight-bold text-primary">Identitas Pasien</h6>
    </a>
    <div class="collapse show" id="Identitas">
      <div class="card-body">
        @foreach ($idens as $iden)
          <form class="user" action="">
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="Nama_Lengkap">Nama Lengkap</label>
                <input type="text" class="form-control " name="Nama_Lengkap" value="{{ $iden->nama }}" readonly>
              </div>
              <div class="col-sm-6">
                <label for="umur">Umur</label>
                <input type="text" class="form-control " name="Umur" value="{{ $iden->umur }}" readonly>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-6">
                <label for="Alamat">Alamat</label>
                <input type="text" class="form-control " name="Alamat" value="{{ $iden->alamat }}" readonly>
              </div>
              <div class="col-sm-6">
                <label for="jk">Jenis Kelamin</label>
                <input type="text" class="form-control " name="jk" value="{{ $iden->jk }}" readonly>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="alergi">Riwayat Alergi</label>
                <input type="text" class="form-control " name="alergi" value="{{ $iden->alergi }}" readonly>
              </div>
              <div class="col-sm-6">
                <label for="no_handphone">No. Handphone</label>
                <input type="text" class="form-control " name="no_handphone" value="{{ $iden->hp }}" readonly>
              </div>
            </div>
          </form>
        @endforeach

      </div>
    </div>
  </div>
  @foreach ($datas as $data)
    <div class="card shadow mb-4">
      <a href="#tambahrm" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true"
        aria-controls="tambahrm">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Rekam Medis</h6>
      </a>
      </a>
      <div class="collapse show" id="tambahrm">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-12" align="right">
              <a href="javascript:;" data-toggle="modal" onclick="deleteData({{ $data->id }})"
                data-target="#DeleteModal" class="btn btn-icon-split btn-danger">
                <span class="icon"><i class="fa  fa-trash" style="padding-top: 4px;"></i></span><span
                  class="text">Hapus Rekam Medis</span></a>
            </div>
          </div>
          <form class="user" action="{{ route('rm.update') }}" method="post">
            {{ csrf_field() }}

            <input type="hidden" name="idpasien" value="{{ $data->idpasien }}">
            <input type="hidden" name="id" value="{{ $data->id }}">
            <div class="form-group row col-sm-12">
              <label for="dokter">Dokter Pemeriksa</label>
              <select class="form-control " name="dokter"
                {{ Auth::user()->admin !== 1 ? (Auth::user()->profesi !== 'Staff' ? 'disabled="true"' : '') : '' }}>
                @foreach ($dokters as $dokter)
                  <option value="{{ $dokter->id }}" {{ $dokter->id === $data->dokter ? 'selected' : '' }}>dr.
                    {{ get_value('users', $dokter->id, 'name') }}</option>
                @endforeach
              </select>
              <input type="hidden" name="dokter" value="{{ $dokter->id }}"
                {{ $dokter->id === $data->dokter ? 'selected' : '' }} />
            </div>
            <div class="form-group row col-sm-12">
              <label for="keluhan-utama">Keluhan Utama</label>
              <input type="text" class="form-control " name="keluhan_utama" value="{{ $data->ku }}" required>
            </div>
            <div class="form-group row col-sm-12  ">
              <label for="anamnesis">Anamnesis</label>
              <textarea type="date" class="form-control " name="anamnesis" required>{{ $data->anamnesis }}</textarea>
            </div>
            {{-- slider --}}
            <div class="form-group row">
              <div class="col">
                <label for="sistolik">Sistolik</label>
                <input type="range" name="sistolik1" min="70" max="300" value="{{ $data->sistolik }}"
                  oninput="this.form.sistolik2.value=this.value" />
                <input type="number" name="sistolik2" min="70" max="300" value="{{ $data->sistolik }}"
                  oninput="this.form.sistolik1.value=this.value" />
              </div>
              <div class="col">
                <label for="diastolik">Diastolik</label>
                <input type="range" name="diastolik1" min="30" max="150" value="{{ $data->diastolik }}"
                  oninput="this.form.diastolik2.value=this.value" />
                <input type="number" name="diastolik2" min="30" max="150" value="{{ $data->diastolik }}"
                  oninput="this.form.diastolik1.value=this.value" />
              </div>
              <div class="col">
                <label for="hr">HeartRate</label>
                <input type="range" name="hr1" min="40" max="150" value="{{ $data->hr }}"
                  oninput="this.form.hr2.value=this.value" />
                <input type="number" name="hr2" min="40" max="150" value="{{ $data->hr }}"
                  oninput="this.form.hr1.value=this.value" />
              </div>
              <div class="col">
                <label for="bb">Berat Badan</label>
                <input type="range" name="bb1" min="3" max="150" value="{{ $data->bb }}"
                  oninput="this.form.bb2.value=this.value" />
                <input type="number" name="bb2" min="3" max="150" value="{{ $data->bb }}"
                  oninput="this.form.bb1.value=this.value" />
              </div>
              <div class="col">
                <label for="tb">Temperature</label>
                <input type="range" name="tb1" min="35" max="40" value="{{ $data->tb }}"
                  oninput="this.form.tb2.value=this.value" />
                <input type="number" name="tb2" min="35" max="40" value="{{ $data->tb }}"
                  oninput="this.form.tb1.value=this.value" />
              </div>
              <div class="col">
                <label for="rr">Respiration Rate</label>
                <input type="range" name="rr1" min="18" max="50" value="{{ $data->rr }}"
                  oninput="this.form.rr2.value=this.value" />
                <input type="number" name="rr2" min="18" max="50" value="{{ $data->rr }}"
                  oninput="this.form.rr1.value=this.value" />
              </div>

            </div>
            {{-- end slider --}}


            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="penunjang">Pemeriksaan Penunjang</label>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <select num="{{ $num['lab'] }}" class="form-control selectpicker" data-live-search="true"
                  id="penunjang" name="penunjang">
                  <option value="" selected disabled>Pilih satu</option>
                  @foreach ($labs as $lab)
                    <option satuan="{{ $lab->satuan }}" value="{{ $lab->id }}">{{ $lab->nama }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-sm-6">
                <a href="javascript:;" onclick="addpenunjang()" type="button" name="add" id="add"
                  class="btn btn-success">Tambahkan</a>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-12 mb-3 mb-sm-0">
                <table id="dynamicTable" width="75%">
                  @if ($data->lab != null)
                    @for ($i = 0; $i < $num['lab']; $i++)
                      <tr>
                        <td><input type="hidden" name="lab[{{ $i }}][id]"
                            value="{{ array_keys($data->labhasil)[$i] }}" class="form-control" readonly></td>
                        <td width="30%"><input type="text" name="lab[{{ $i }}][nama]"
                            value="{{ get_value('lab', array_keys($data->labhasil)[$i], 'nama') }}"
                            class="form-control" readonly></td>
                        <td width="10%"><input type="text" name="lab[{{ $i }}][hasil]"
                            value="{{ $data->labhasil[array_keys($data->labhasil)[$i]] }}" placeholder="Hasil"
                            class="form-control" required>
                        <td width=10%"><input class="form-control"
                            value='{{ get_value('lab', array_keys($data->labhasil)[$i], 'satuan') }}' readonly></td>
                        </td>
                        <td><button type="button" class="btn btn-danger remove-pen">Hapus</button></td>
                      </tr>
                    @endfor
                  @endif
                </table>

              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-12 mb-3 mb-sm-0">
                <label for="diagnosis">Diagnosis</label>
                <input type="text" class="form-control " name="diagnosis" value="{{ $data->diagnosis }}"
                  {{ Auth::user()->profesi !== 'Dokter' ? 'disabled="true"' : '' }}required>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-6 mb-3 mb-sm-0">
                <label for="reseplist">Resep</label>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-9 mb-0 mb-sm-0">
                <select {{ Auth::user()->profesi !== 'Dokter' ? 'disabled="true"' : '' }} num="{{ $num['resep'] }}"
                  class="form-control selectpicker" data-live-search="true" name="reseplist" id="reseplist">
                  <option value="" selected disabled>Pilih satu</option>
                  @foreach ($obats as $obat)
                    <option value="{{ $obat->id }}">{{ $obat->nama_obat }} {{ $obat->sediaan }}
                      {{ $obat->dosis }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-sm-3">
                <a href="javascript:;" onclick="addresep()" type="button" name="addresep" id="addresep"
                  class="btn btn-success">Tambahkan</a>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-12 mb-3 mb-sm-0">
                <table width="75%" id="reseps">
                  @if ($data->resep != 0)
                    @for ($i = 0; $i < $num['resep']; $i++)
                      <tr>
                        <td><input type="hidden" name="resep[{{ $i }}][id]"
                            value="{{ array_keys($data->allresep)[$i] }}" class="form-control" readonly></td>
                        <td width="30%"><input type="text" name="resep[{{ $i }}][nama]"
                            value="{{ get_value('obat', array_keys($data->allresep)[$i], 'nama_obat') }} {{ get_value('obat', array_keys($data->allresep)[$i], 'sediaan') }} {{ get_value('obat', array_keys($data->allresep)[$i], 'dosis') }}"
                            class="form-control" readonly></td>
                        <td width="10%"><input type="text" name="resep[{{ $i }}][jumlah]"
                            value="{{ $data->jum[$i] }}" placeholder="Jumlah" class="form-control" required></td>
                        <td width="30%"><input type="text" name="resep[{{ $i }}][aturan]"
                            value="{{ $data->allresep[array_keys($data->allresep)[$i]] }}" placeholder="Aturan"
                            class="form-control" required></td>
                        <td><button type="button" class="btn btn-danger remove-pen">Hapus</button></td>
                      </tr>
                    @endfor
                  @elseif ($data->resep ===0)
                    <tr>""</tr>
                  @endif
                </table>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-4 mb-3 mb-sm-0">
                @foreach ($idens as $iden)
                  <a href="{{ route('rm.list', $iden->id) }}" class="btn btn-danger btn-block" name="simpan">
                    <i class="fas fa-arrow-left fa-fw"></i> kembali
                  </a>
                @endforeach
              </div>
              <div class="col-sm-4 mb-3 mb-sm-0">
                <button type="submit" class="btn btn-primary btn-block" name="simpan" value="simpan_edit">
                  <i class="fas fa-save fa-fw"></i> Simpan
                </button>
              </div>
              <div class="col-sm-4 mb-3 mb-sm-0">
                <button type="submit" class="btn btn-success btn-block" name="simpan" value="simpan_tagihan">
                  <i class="fas fa-cart-plus fa-fw"></i> Simpan & Buat Tagihan
                </button>
              </div>
          </form>
  @endforeach
  </div>
  </div>

  </div>
  <script>
    $(document).ready(function() {
      var table = $('#pasien').DataTable({
        pageLength: 5,
        lengthMenu: [
          [5, 10, 20, -1],
          [5, 10, 20, 'Todos']
        ]
      })
    });
  </script>
  <script type="text/javascript">
    var i = $("#penunjang").attr('num');
    var a = $("#reseplist").attr('num');

    function addpenunjang() {


      var pen = $("#penunjang option:selected").html();
      var penid = $("#penunjang").val();
      var satuan = $("#penunjang option:selected").attr('satuan');
      if (penid !== null) {
        //code
        $("#dynamicTable").append('<tr><td><input type="hidden" name="lab[' + i + '][id]" value="' + penid +
          '" class="form-control" readonly></td><td><input type="text" name="lab[' + i + '][nama]" value="' + pen +
          '" class="form-control" readonly></td><td><input type="text" name="lab[' + i +
          '][hasil]" placeholder="Hasil" class="form-control" required><td width=20%"><input class="form-control" value=' +
          satuan +
          ' readonly></td></td><td><button type="button" class="btn btn-danger remove-pen">Hapus</button></td></tr>');
      }
      ++i;
    };

    function addresep() {

      var res = $("#reseplist option:selected").html();
      var resid = $("#reseplist").val();
      if (resid !== null) {
        //code
        $("#reseps").append('<tr><td><input type="hidden" name="resep[' + a + '][id]" value="' + resid +
          '" class="form-control" readonly></td><td><input type="text" name="resep[' + a + '][nama]" value="' + res +
          '" class="form-control" readonly></td><td><input type="text" name="resep[' + a +
          '][jumlah]" placeholder="Jumlah" class="form-control" required><td><input type="text" name="resep[' + a +
          '][aturan]" placeholder="Aturan pakai" class="form-control" required></td><td><button type="button" class="btn btn-danger remove-res">Hapus</button></td></tr>'
        );
      }
      ++a;
    };

    $(document).on('click', '.remove-pen', function() {
      $(this).parents('tr').remove();
    });

    $(document).on('click', '.remove-res', function() {
      $(this).parents('tr').remove();
    });
  </script>

  <script type="text/javascript">
    function deleteData(id) {
      var id = id;
      var url = '{{ route('rm.destroy', ':id') }}';
      url = url.replace(':id', id);
      $("#deleteForm").attr('action', url);
    }

    function formSubmit() {
      $("#deleteForm").submit();
    }
  </script>
@endsection
