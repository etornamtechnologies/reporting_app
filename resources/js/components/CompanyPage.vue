<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header py-1">
                        <span>Companies</span>
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
                                :items="companies"
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
                    <div class="card-header py-1">Create Company</div>
                    <div class="card-body">
                        <form @submit.prevent="createCompany">
                            <div class="form-group">
                                <label for="">Label</label>
                                <input class="form-control" v-model="company.label" required>
                            </div>
                            <div class="form-group">
                                <label for="">Company logo</label>
                                <b-form-file
                                v-model="logo"
                                placeholder="Choose a file..."
                                drop-placeholder="Drop file here..."
                                accept=".jpg, .png,"
                                type="file"
                                />
                            </div>
                            <button
                            style="margin-top:30px" 
                            class="btn btn-info btn-block">CREATE COMAPNY</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <b-modal ref="editModal" hide-footer title="UPDATE COMPANY" centered>
            <form @submit.prevent="updateCompany">
                <div class="form-group">
                    <label for="">Label</label>
                    <input type="text" class="form-control" v-model="edit_data.label" autofocus />
                </div>
                <b-form-file
                label="comapny logo"
                v-model="logo"
                :state="Boolean(file)"
                placeholder="Choose a file..."
                drop-placeholder="Drop file here..."
                />
                <button class="btn btn-block btn-info mt-4" type="submit">UPDATE</button>
            </form>
        </b-modal>
    </div>
</template>
<script>
    export default {
        mounted(){
            this.fetchCompanies();
            console.log('welcome to comapanies')
        },
        data(){
            return {
                filter:'',
                company: {label:''},
                logo:'',
                companies: [],
                edit_data: {label:'', id:null, index:null},
                headers: [{key:'label', label:'Label'}, {key:'user.name', label:'created by'}
                            ,{key:'actions', label:'Actions'}],
                currentPage: 1,
                index: null,
                perPage: 10,
                totalRows: null,
                pageOptions: [10, 15, 20],
                isLoading: true,
            }
        },
        methods: {
            fetchCompanies: function(){
                this.isLoading = true;
                axios.get('/api/companies')
                    .then(result=> {
                        this.isLoading = false;
                        this.companies = result.companies || []
                        this.totalRows = this.companies.length
                    })
                    .catch(err=> {
                        this.isLoading = false;
                    })
            },
            createCompany: function(){
                let fd = new FormData();
                fd.append('file', this.logo);
                fd.append('label', this.company.label)
                for(var pair of fd.entries()) {
                    console.log(pair[0]+', '+pair[1]);
                }
                this.isLoading = true;
                axios.post('/api/companies', fd)
                    .then(result=> {
                        this.isLoading = false;
                        if((result || {}).code == 0) {
                            this.companies.push(result.company || {});
                        this.company.label = "";
                        this.company.file = "";
                        }
                    })
                    .catch(err=> {
                        this.isLoading = false;
                    })
            },
            updateCompany: function(){
                console.log('data', this.edit_data)
                axios.put(`/api/companies/${this.edit_data.id}`, this.edit_data)
                    .then(result=> {
                        if(result.code == 0) {
                             location.reload(true);
                            this.edit_data = {id:null, label:'', index:null};
                            this.$refs.editModal.hide();
                        }
                    })
                    .catch(err=> {
                        Notifier.error(err.message || 'server error');
                    })
            },
            openEditModal: function(row, index) {
                this.edit_data = Vue.util.extend({},row);
                this.index = index;
                this.$refs.editModal.show();
            },
            deleteEntry: function(row) {
                axios.delete(`/api/companies/${row.id}`)
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
            },
            file: function(){
                if(this.company.file != "" || this.company.file != null) {
                    return true
                }
                return false;
            }
        },
        computed: {
            
        }
    }
</script>