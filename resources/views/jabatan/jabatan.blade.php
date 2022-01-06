@extends('app')

@section('konten')
<div id="component">
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>Data Jabatan</div>
                    <button @click="tambah" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Tambah
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-sm" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Jabatan</th>
                                <th>Gaji Pokok</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
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

                    <form @submit.prevent="editMode ? editAction(dataEdit.id) : tambahAction()" id="form">

                        <div class="form-group mb-3">
                            <label>Nama</label>

                            <!-- tambah -->
                            <input type="text" name="nama_jabatan" v-if="!editMode" class="form-control" id="nama_jabatan">
                            <!-- edit -->
                            <input type="text" v-if="editMode" v-model="dataEdit.nama_jabatan" class="form-control" id="nama_jabatan">

                            <div class="form-text text-danger" v-if="errors['nama_jabatan']">@{{ errors['nama_jabatan'][0] }}</div>
                        </div>

                        <div class="form-group mb-3">
                            <label>Gaji Pokok</label>
                            
                            <!-- tambah -->
                            <input type="text" name="gaji_pokok" v-if="!editMode" class="form-control" id="gaji_pokok">
                            <!-- edit -->
                            <input type="text" v-if="editMode" v-model="dataEdit.gaji_pokok" class="form-control" id="gaji_pokok">

                            <div class="form-text text-danger" v-if="errors['gaji_pokok']">@{{ errors['gaji_pokok'][0] }}</div>
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
    <!-- akhir modal -->
</div>
@endsection

@push('js')
<script>
    var component = new Vue({
        el: '#component',
        data: {
            editMode: false,
            dataEdit: {},
            errors: [],
            load: false
        },
        mounted(){
            this.ambilData()
        },
        methods: {
            ambilData(){
                $('#table').DataTable({
                    processing: true,
                    language: {
                        url: '{{ asset("datatable/language.json") }}'
                    },
                    ajax: {
                        type: 'GET',
                        url: 'jabatan'
                    },
                    columns   : [
                        {
                            "data" : null, "sortable" : false,
                            render: function(data, type, row, meta){
                                return meta.row + meta.settings._iDisplayStart + 1
                            }
                        },
                        {data: 'nama_jabatan', name: 'nama_jabatan'},
                        {data: 'gaji_pokok', name: 'gaji_pokok'},
                        {data: 'opsi', name: 'opsi'}
                    ]
                })
            },
            tutupModal(){
                this.errors = []
                $('#nama_jabatan').val('')
                $('#gaji_pokok').val('')
            },
            tambah(){
                this.editMode = false
            },
            async tambahAction(){
                let btn = document.getElementById('btn-submit')
                this.load = true
                try{
                    btn.setAttribute('disabled', true)

                    await axios.post('jabatan', new FormData($('#form')[0]))
                    $('#table').DataTable().ajax.reload()
    
                    this.load = false
                    btn.removeAttribute('disabled', false)
                    $('#tutup-modal').click()

                    Toast.fire({
                        icon: 'success',
                        title: 'Jabatan berhasil di tambahkan'
                    })
                }catch(e){
                    this.errors = e.response.data.errors
                    this.load = false
                    btn.removeAttribute('disabled', false)
                }
            },
            async edit(id){
                this.editMode = true

                let response = await axios.get('jabatan/'+ id)
                this.dataEdit = response.data.data
            },
            async editAction(id){
                let btn = document.getElementById('btn-submit')
                this.load = true
                try{
                    btn.setAttribute('disabled', true)

                    await axios.patch('jabatan/'+ id, this.dataEdit)
                    $('#table').DataTable().ajax.reload()
    
                    this.load = false
                    btn.removeAttribute('disabled', false)
                    $('#tutup-modal').click()

                    Toast.fire({
                        icon: 'success',
                        title: 'Jabatan berhasil di edit'
                    })
                }catch(e){
                    this.errors = e.response.data.errors
                    this.load = false
                    btn.removeAttribute('disabled', false)
                }
            },
            hapus(id){
                Swal.fire({
                    title: 'Apa kamu yakin ?',
                    text: "ingin menghapus jabatan ini",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Kembali',
                    cancelButtonColor: 'black'
                    }).then((result) => {
                    if (result.isConfirmed) {

                        // ajax toke setup
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        // hapus dengan ajax
                        $.ajax({
                            type: "DELETE",
                            url: "jabatan/"+id,
                            success: function(){
                                $('#table').DataTable().ajax.reload()
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Jabatan berhasil dihapus'
                                })
                            },
                            error: function(){
                                toastFail.fire({
                                    icon: 'error',
                                    title: 'Jabatan ini tidak bisa dihapus, masih ada data lain yang berelasi dengan jabatan ini !'
                                })
                            }
                        })
                    }
                })
            }
        }
    })
</script>
@endpush