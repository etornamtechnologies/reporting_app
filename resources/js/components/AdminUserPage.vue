<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-1">
                        USER INFO
                        <div class="float-right" @click="redirectToUsers" style="cursor:pointer">
                            <i class="fas fa-angle-left"></i>
                            USERS
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4" style="border-right:solid 1px #dcdee2">
                                <div class="row bg-light py-2">
                                    <div class="col-md-3">
                                        <i class="fas fa-user" style="font-size:80px; color:#17a2b8"></i>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="">Name:</label>
                                            <input type="text" class="form-control" :value="user.name" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-1 bg-light py-2">
                                    <div class="col-md-3">
                                        <i class="fas fa-user-tie" style="font-size:80px; color:#17a2b8"></i>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="">Username:</label>
                                            <input type="text" class="form-control" :value="user.username" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-1 bg-light py-2">
                                    <div class="col-md-3">
                                        <i class="fas fa-envelope" style="font-size:80px; color:#17a2b8"></i>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="">Email:</label>
                                            <input type="text" class="form-control" :value="user.email" readonly>
                                        </div>  
                                    </div>
                                </div>
                                <div class="row mt-1 bg-light py-2">
                                    <div class="col-md-3">
                                        <i class="fas fa-calendar-alt" style="font-size:80px; color:#17a2b8"></i>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="">Registered On</label>
                                            <input type="text" class="form-control" :value="prettyDate(user.created_at)" readonly>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>Admin</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="checkbox" class=""
                                                  v-model="employee">
                                            </td>
                                            <td><input type="checkbox" class=""
                                                  v-model="admin">
                                            </td>
                                            <td>
                                                <button class="btn btn-warning text-white" @click="assignRole()">
                                                    assign role
                                                </button>
                                            </td>      

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    const baseUrl = process.env.MIX_BASE_URL;
    export default {
        data: function() {
            return {
                user:{},   
                admin:false,
                sales_rep: false,
                employee: false,   
            }
        },
        mounted() {
            this.fetchUser();
        },
        methods: {
            fetchUser: function() {
                let urlString = location.href.split('/');
                let userId = urlString[urlString.length-1];
                axios.get(`/api/admin/users/${userId}`)
                    .then((res)=> {
                        if(res.code == 0) {
                            this.user = res.user;
                            this.initRoles();
                        }
                    })
                    .catch((err)=> {
                        alert(err);
                    });
            },  
            prettyDate: function(dd) {
                let date = new Date(dd);
                let options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                return date.toLocaleDateString("en-US", options);
            },
            initRoles: function() {
                let roles = this.user.roles || [];
                console.log(roles);
                roles.forEach((role)=> {
                    if(role.label == 'admin') {
                        this.admin = true;
                    }
                    if(role.label == 'employee') {
                        this.employee = true;
                    }
                })
            },
            assignRole: function() {
                let userId = this.user.id || null;
                let roles = {};
                if(this.employee) {
                    roles.employee = this.employee;
                }
                if(this.admin) {
                    roles.admin = this.admin;
                }
                axios.post(`/api/admin/users/${userId}/assign-role`, roles)
                    .then((res)=> {
                        if(res.code == 0) {
                            Notifier.success('added');
                            location.reload(true)
                        }
                    })
            },
            redirectToUsers: function(){
                location.href = `/admin/users`
            }
        }
    }
</script>

<style scoped>
    .detail-label {
        font-size: 20px;
        font-weight: bold;
    }
</style>