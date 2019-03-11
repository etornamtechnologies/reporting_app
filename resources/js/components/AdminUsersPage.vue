<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-2">
                    <div class="card-header py-1">Users</div>
                    <div class="card-body">
                        <b-table
                            show-empty
                            stacked="md"
                            :items="users"
                            :fields="users_header"
                            :filter="filter"
                        >
                            <template slot="actions" slot-scope="row">
                                <b-button size="sm" @click.stop="userDetail(row.item)" variant="primary">
                                    <!-- <i v-if="!row.detailsShowing" class="fas fa-plus-square"></i>
                                    <i v-if="row.detailsShowing" class="fas fa-minus-square"></i> -->
                                    more
                                </b-button>
                                <b-button size="sm" @click.stop="deleteUser(row.item)" class="mr-1"
                                variant="outline-danger"
                                >
                                    Delete
                                </b-button>
                            </template>
                        </b-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                filter:'',
                users:[],
                users_header: [{key:'name', label:'name'}, {key:'username', label:'username'}
                                , {key:'email', label:'email'}, {key:'actions', label:''}],
                currentPage: 1,
                perPage:10,
                pageOptions: [10,20,30],
                totalRows: 0,              
            }
        },
        mounted() {
            this.fetchUsers();
        },
        methods: {
            fetchUsers: function() {
                axios.get('/api/admin/users')
                .then((res)=> {
                    if(res.code == 0) {
                        this.users = res.users || [];
                    }
                })
                .catch((err)=> {
                    alert(err);
                })
            },
            userDetail: function(user) {
                let baseUrl = process.env.MIX_APP_URL;
                location.href = `${baseUrl}/admin/users/${user.id}`
            },
            deleteUser: function(user) {
                let userId = user.id || null
                axios.delete(`/admin/users/${userId}`)
                    .then((result)=> {
                        let data = result.data || {};
                        if(data.code == 0) {
                            location.reload(true);
                        }
                    })
                    .catch((err)=> {
                        alert(err);
                    }) 
            },
            editUser: function(user) {
                
            },
            onFiltered: function(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
        }
    }
</script>

<style scoped>
    
</style>