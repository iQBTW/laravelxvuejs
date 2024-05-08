@extends('layouts.dashboard')

@section('title')
    Publisher
@endsection

@section('dashboard-title')
    Publisher
@endsection

@section('content')
    <div id="publishers">
        <section class="content">
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
                                <table id="example2" class="table table-bordered table-hover">
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
                                    @foreach ($publishers as $publisher)
                                    <tbody>
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $publisher->name }}</td>
                                            <td>{{ $publisher->email }}</td>
                                            <td>{{ $publisher->phone_number }}</td>
                                            <td>{{ $publisher->address }}</td>
                                            <td>
                                                <Button class="btn btn-warning" @click="editData({{ $publisher }})">Edit</Button>
                                                <Button class="btn btn-danger" @click="confirmDelete({{ $publisher->id }})">Delete</Button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Address</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                {{ $publishers->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-lg">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h4 class="modal-title" >New Publisher</h4>
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
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="exampleInputEmail1" placeholder="Enter Name" :value="data.name">

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter Email" :value="data.email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_number">Phone Number</label>
                                        <input type="number" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" placeholder="Enter Phone Number" :value="data.phone_number">

                                        @error('phone_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" name="address" rows="3" placeholder="Enter Your Address..." :value="data.address"></textarea>
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

            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this author?
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-danger" @click="deleteData()">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        const { createApp } = Vue

        createApp({
            data() {
                return {
                    data: {},
                    isEdit: false,
                    actionUrl: '{{ url('publishers') }}',
                }
            },
            methods: {
                addData() {
                    this.data = {}
                    axios.post(this.actionUrl, this.data)
                        .then(response => {
                            location.reload();
                        })
                        .catch(error => {
                            console.error(error);
                        });
                    $('#modal-lg').modal()
                },
                editData(data) {
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
                    axios.post(this.actionUrl, {_method: 'DELETE'})
                    .then(response => {
                        location.reload();
                    })
                    .catch(error => {
                            console.error(error);
                    });
                }
            },
        }).mount('#publishers')
    </script>
@endsection
