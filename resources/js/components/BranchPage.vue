<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header py-1">
                        <span>Company branches</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <b-form-group label-cols-sm="3" label="Filter" class="mb-0">
                                    <b-input-group>
                                        <b-form-input v-model="filter" placeholder="Type to Search" />
                                        <b-input-group-append>
                                        <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12" v-loading="isLoading">
                                <b-table
                                bordered
                                stacked="md"
                                :items="branches"
                                :fields="headers"
                                :current-page="currentPage"
                                :per-page="perPage"
                                :filter="filter"
                                @filtered="onFiltered">
                                    <template slot="actions" slot-scope="row">
                                        <button 
                                        @click="openEditModal(row.item, row.index)"
                                        class="btn btn-sm btn-primary">edit</button>
                                        <button 
                                        disabled
                                        @click="deleteEntry(row.item)"
                                        class="btn btn-danger btn-sm">delete</button>
                                    </template>
                                </b-table>
                            </div>
                        </div>
                        <b-row>
                            <b-col md="12" class="my-1">
                                <b-pagination
                                align="center"
                                :total-rows="totalRows"
                                :per-page="perPage"
                                v-model="currentPage"
                                class="my-0"
                                />
                            </b-col>
                        </b-row>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="min-height:600px">
                    <div class="card-header py-1">Create Branch</div>
                    <div class="card-body">
                        <form @submit.prevent="createBranch">
                            <div class="form-group">
                                <label for="">Label</label>
                                <input class="form-control" v-model="new_branch.label" required />
                            </div>
                            <button
                            style="margin-top:30px" 
                            class="btn btn-info btn-block">CREATE BRANCH</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <b-modal ref="editModal" hide-footer title="Using Component Methods" centered>
            <form @submit.prevent="updateBranch">
                <div class="form-group">
                    <label for="">Label</label>
                    <input type="text" class="form-control" v-model="edit_data.label" autofocus />
                </div>
                <button class="btn btn-block btn-info" type="submit">UPDATE</button>
            </form>
        </b-modal>
    </div>
</template>
<script>
    export default {
        mounted(){
            this.fetchBranches();
        },
        data(){
            return {
                filter:'',
                new_branch: {label:''},
                branches: [],
                edit_data: {label:'', id:null, index:null},
                headers: [{key:'label', label:'Label'}, {key:'user.name', label:'created by'}
                            ,{key:'actions', label:'Actions'}],
                currentPage: 1,
                index: null,
                perPage: 10,
                totalRows: null,
                pageOptions: [10, 15, 20],
                isLoading: false,
            }
        },
        methods: {
            fetchBranches: function(){
                this.isLoading = true;
                axios.get('/api/branches')
                    .then(result=> {
                        this.isLoading = false;
                        this.branches = result.branches || []
                        this.totalRows = this.branches.length
                    })
                    .catch(err=> {
                        this.isLoading = false;
                    })
            },
            createBranch: function(){
                axios.post('/api/branches', this.new_branch)
                    .then(result=> {
                        //location.reload(true);
                        this.branches.push(result.branch);
                        this.new_branch.label = "";
                    })
            },
            updateBranch: function(){
                axios.put(`/api/branches/${this.edit_data.id}`, this.edit_data)
                    .then(result=> {
                        location.reload(true);
                        this.edit_data = {id:null, label:'', index:null};
                        this.$refs.editModal.hide();
                    })
            },
            openEditModal: function(row, index) {
                this.edit_data = Vue.util.extend({},row);
                this.index = index;
                this.$refs.editModal.show();
            },
            deleteEntry: function(row) {
                axios.delete(`/api/branches/${row.id}`)
                    .then(result=> {
                        location.reload(true)
                    })
                    .catch(err=> {
                        
                    })
            },
            onFiltered: function(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            }
        },
        computed: {
            
        }
    }
</script>