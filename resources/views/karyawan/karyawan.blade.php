@extends('app')

@section('konten')
<div id="component">
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>Data Karyawan</div>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" @click="tambah">Tambah</button>
                </div>
                <div class="card-body">
                    <table class="table" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Jenis Kelamin</th>
                                <th>Telepon</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    
        <!-- Modal tambah dan edit-->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">
                            <div v-if="!editMode">Tambah</div>
                            <div v-if="editMode">Edit</div>
                        </h5>
                        <button type="button" @click="tutupModal" class="btn-close" id="tutup-modal" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        <form @submit.prevent="editMode ? editAction(dataEdit.id) : tambahAction()" id="form" enctype="multipart/form-data">
    
                            <div class="form-group mb-3">
                                <label>NIP</label>

                                <!-- tambah -->
                                <input type="text" v-if="!editMode" name="nip" class="form-control" id="input">
                                <!-- edit -->
                                <input type="text" v-if="editMode" v-model="dataEdit.nip" name="nip" class="form-control" id="input">

                                <div class="form-text text-danger" v-if="errors['nip']">@{{ errors['nip'][0] }}</div>
                            </div>

                            <div class="form-group mb-3">
                                <label>Nama</label>

                                <!-- tambah -->
                                <input type="text" v-if="!editMode" name="nama_karyawan" class="form-control" id="input">
                                <!-- edit -->
                                <input type="text" v-if="editMode" v-model="dataEdit.nama_karyawan" name="nama_karyawan" class="form-control" id="input">
                                
                                <div class="form-text text-danger" v-if="errors['nama_karyawan']">@{{ errors['nama_karyawan'][0] }}</div>
                            </div>

                            <div class="row">
                                <div class="col-md">
                                    <div class="form-group mb-3">
                                        <label>Jabatan</label>

                                        <!-- tambah -->
                                        <select name="jabatan" class="form-control" id="input" v-if="!editMode">
                                            <option value="">----</option>
                                            <option v-for="j in jabatans" :value="j.id">@{{ j.nama_jabatan }}</option>
                                        </select>
                                        <!-- edit -->
                                        <select name="jabatan" class="form-control" id="input" v-if="editMode" v-model="dataEdit.id_jabatan">
                                            <option v-for="j in jabatans" :value="j.id">@{{ j.nama_jabatan }}</option>
                                        </select>

                                        <div class="form-text text-danger" v-if="errors['jabatan']">@{{ errors['jabatan'][0] }}</div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group mb-3">
                                        <label>Jenis Kelamin</label>

                                        <!-- tambah -->
                                        <select name="jenis_kelamin" class="form-control" id="input" v-if="!editMode">
                                            <option value="">----</option>
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                        <!-- edit -->
                                        <select name="jenis_kelamin" class="form-control" id="input" v-if="editMode" v-model="dataEdit.jenis_kelamin">
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>

                                        <div class="form-text text-danger" v-if="errors['jenis_kelamin']">@{{ errors['jenis_kelamin'][0] }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label>Telepon</label>

                                <input type="text" v-if="!editMode" name="telepon" class="form-control" id="input">
                                <input type="text" v-if="editMode" v-model="dataEdit.telepon" name="telepon" class="form-control" id="input">

                                <div class="form-text text-danger" v-if="errors['telepon']">@{{ errors['telepon'][0] }}</div>
                            </div>

                            <div class="form-group mb-3">
                                <label>CV <span class="not">max 2 MB</span></label>
                                <input type="file" name="cv" class="form-control" id="input">
                                <div class="form-text text-danger" v-if="errors['cv']">@{{ errors['cv'][0] }}</div>
                            </div>

                            <button class="btn btn-sm btn-primary float-end d-flex" id="btn-submit">
                                <div v-if="!editMode">Tambah</div>
                                <div v-if="editMode">Edit</div>
                                <svg v-if="load" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgba(255, 255, 255, 0); display: block; shape-rendering: auto;" width="24px" height="22px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                                    <g>
                                        <path d="M50 15A35 35 0 1 0 74.74873734152916 25.251262658470843" fill="none" stroke="#ffffff" stroke-width="12"></path>
                                        <path d="M49 3L49 27L61 15L49 3" fill="#ffffff"></path>
                                        <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                                    </g>
                                </svg>
                            </button>
    
                        </form>
    
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdropCv" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropCvLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropCvLabel">CV @{{ dataCv.nama_karyawan }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <embed :src="linkCv(dataCv.cv)" type="application/pdf" width="100%" height="500">
                    </div>
                </div>
            </div>
        </div>
    
    </div>
</div>
@endsection

@push('js')
<script>
    var component = new Vue({
        el: '#component',
        data: {
            jabatans: [],
            editMode: false,
            errors: [],
            load: false,
            dataEdit: {},
            dataCv: []
        },
        mounted(){
            this.ambilKaryawan()
            this.ambilJabatan()
        },
        methods: {
            async ambilJabatan(){
                let response = await axios.get('data_jabatan')
                this.jabatans = response.data.data
            },
            ambilKaryawan(){
                $('#table').DataTable({
                    processing: true,
                    language: {
                        url: '{{ asset("datatable/language.json") }}'
                    },
                    ajax: {
                        type: 'GET',
                        url: '/'
                    },
                    columns   : [
                        {
                            "data" : null, "sortable" : false,
                            render: function(data, type, row, meta){
                                return meta.row + meta.settings._iDisplayStart + 1
                            }
                        },
                        {data: 'nip', name: 'nip'},
                        {data: 'nama_karyawan', name: 'nama_karyawan'},
                        {data: 'jabatan', name: 'jabatan'},
                        {data: 'jenis_kelamin', name: 'jenis_kelamin'},
                        {data: 'telepon', name: 'telepon'},
                        {data: 'opsi', name: 'opsi'}
                    ]
                })
            },
            tutupModal(){
                var input = document.querySelectorAll('#input')
                for(var i=0; i<input.length; i++){
                    input[i].value = ""
                }

                this.dataEdit = {}
                this.errors = []
            },
            tambah(){
                this.editMode = false
            },
            async tambahAction(){
                let btn = document.getElementById('btn-submit')
                this.load = true
                try{
                    btn.setAttribute('disabled', true)

                    await axios.post('karyawan', new FormData($('#form')[0]))
                    $('#table').DataTable().ajax.reload()
    
                    $('#tutup-modal').click()
                    this.load = false
                    btn.removeAttribute('disabled', false)
    
                    Toast.fire({
                        icon: 'success',
                        title: 'Karyawan berhasil di tambahkan'
                    })
                }catch(e){
                    btn.removeAttribute('disabled', false)
                    this.errors = e.response.data.errors
                    this.load = false
                }
            },
            async edit(id){
                this.editMode = true
                let response = await axios.get('karyawan/'+ id)
                this.dataEdit = response.data.data
            },
            async editAction(id){
                let btn = document.getElementById('btn-submit')
                this.load = true
                try{
                    btn.setAttribute('disabled', true)

                    await axios.post('karyawan/'+ id, new FormData($('#form')[0]))
                    $('#table').DataTable().ajax.reload()
    
                    $('#tutup-modal').click()
                    this.load = false
                    btn.removeAttribute('disabled', false)
    
                    Toast.fire({
                        icon: 'success',
                        title: 'Karyawan berhasil di edit'
                    })
                }catch(e){
                    btn.removeAttribute('disabled', false)
                    this.errors = e.response.data.errors
                    this.load = false
                }
            },
            hapus(id){
                Swal.fire({
                    title: 'Apa kamu yakin ?',
                    text: "ingin menghapus karyawan ini",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Kembali',
                    cancelButtonColor: 'black'
                    }).then((result) => {
                    if (result.isConfirmed) {

                        axios.delete('karyawan/'+ id)
                        $('#table').DataTable().ajax.reload()

                        Toast.fire({
                            icon: 'success',
                            title: 'karyawan berhasil di hapus'
                        })
                    }
                })
            },
            async cv(id){
                let response = await axios.get('karyawan/'+ id)
                this.dataCv = response.data.data
            },
            linkCv(cv){
                return 'cv/'+ cv;
            }
        }
    })
</script>
@endpush