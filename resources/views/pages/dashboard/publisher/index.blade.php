@extends('layouts.dashboard')

@section('title')
    Publisher
@endsection

@section('dashboard-title')
    Publisher
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Publisher</li>
@endsection

@section('content')
    <div id="app">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Publishers</h3>
                        </div>

                        <div class="card-body">
                            <div class="justify-content-end pb-2">
                                <button class="btn btn-primary" @click="addData()">Create New Publisher</button>
                            </div>
                            <table id="table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($publishers as $publisher)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $publisher->name }}</td>
                                            <td>{{ $publisher->email }}</td>
                                            <td>{{ $publisher->phone_number }}</td>
                                            <td>{{ $publisher->address }}</td>
                                            <td>
                                                <Button class="btn btn-warning"
                                                    @click="editData({{ $publisher }})">Edit</Button>
                                                <Button class="btn btn-danger"
                                                    @click="confirmDelete({{ $publisher->id }})">Delete</Button>
                                            </td>
                                        </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Publisher</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" :action="actionUrl">
                            @csrf
                            <input type="hidden" name="_method" value="PUT" v-if="isEdit">

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="exampleInputEmail1"
                                    placeholder="Enter Name" :value="data.name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email"
                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                    placeholder="Enter Email" :value="data.email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Phone Number</label>
                                <input type="number" name="phone_number"
                                    class="form-control @error('phone_number') is-invalid @enderror" id="phone_number"
                                    placeholder="Enter Phone Number" :value="data.phone_number">

                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3"
                                    placeholder="Enter Your Address..." :value="data.address"></textarea>
                            </div>

                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this publisher?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script type="text/javascript">
        var datas = []
        var data = {}
        var isEdit = false
        var actionUrl = '{{ url('publishers') }}'
        var apiUrl = '{{ url('api/publishers') }}'

        var columns = [{
                data: 'DT_RowIndex',
                class: 'text-center',
                orderable: false,
            },
            {
                data: 'name',
                class: 'text-center',
                orderable: false,
            },
            {
                data: 'email',
                class: 'text-center',
                orderable: true,
            },
            {
                data: 'phone_number',
                class: 'text-center',
                orderable: true,
            },
            {
                data: 'address',
                class: 'text-center',
                orderable: true,
            },
            {
                render: function(index, row, data, meta) {
                    return `<Button class="btn btn-warning" onclick="app.editData(event, ${meta.row})">Edit</Button>
                        <Button class="btn btn-danger" onclick="app.deleteData(event, ${data.id})">Delete</Button>`;
                },
                orderable: false,
            },
        ];

        const {
            createApp,
            ref
        } = Vue

        createApp({
            data() {
                return {
                    datas,
                    data,
                    isEdit,
                    actionUrl,
                    apiUrl,
                }
            },
            mounted() {
                this.datatable();
            },
            methods: {
                datatable() {
                    const _this = this;
                    _this.table = $(document).ready(function() {
                        $('#table').DataTable({
                            ajax: {
                                url: _this.apiUrl,
                                type: 'GET'
                            },
                            columns: columns,
                            columnDefs: [{
                                defaultContent: "-",
                                targets: "_all"
                            }],
                            "paging": true,
                            "lengthChange": true,
                            "searching": true,
                            "ordering": true,
                            "info": true,
                            "autoWidth": false,
                            "responsive": true,
                        });
                    }).on('xhr', function() {
                        _this.datas = _this.table.ajax.json().data
                    });
                },
                addData() {
                    this.data = {}
                    axios.post(this.actionUrl, this.data)
                        .then(response => {
                            location.reload();
                        });
                    $('#modal-lg').modal()
                },
                editData() {
                    this.data = data
                    this.isEdit = true
                    this.actionUrl = '{{ url('publishers') }}' + '/' + data.id
                    axios.put(this.actionUrl, this.data, )
                        .then(response => {
                            location.reload();
                        })
                        .catch(error => {
                            console.error(error);
                        });
                    $('#modal-lg').modal()
                },
                confirmDelete(id) {
                    this.data = id
                    $('#confirmDeleteModal').modal()
                },
                deleteData() {
                    this.actionUrl = '{{ url('publishers') }}' + '/' + this.data
                    axios.post(this.actionUrl, {
                            _method: 'DELETE'
                        })
                        .then(response => {
                            location.reload();
                        })
                        .catch(error => {
                            console.error(error);
                        });
                },
            },
        }).mount('#app')
    </script>
@endsection
