<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="min-height:700px">
                    <div class="card-header py-1">
                        Reports
                        <button class="btn btn-info btn-sm float-right"
                        @click="openCreateReportModal">CREATE REPORT</button>
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
                            <div class="col-md-12">
                                <b-table
                                bordered
                                stacked="md"
                                :items="reports"
                                :fields="headers"
                                :current-page="currentPage"
                                :per-page="perPage"
                                :filter="filter"
                                @filtered="onFiltered">
                                    <template slot="actions" slot-scope="row">
                                        <button class="btn btn-info btn-sm"
                                        @click="openReport(row.item)">open</button>
                                        <button 
                                        @click="openEditModal(row.item, row.index)"
                                        class="btn btn-sm btn-primary">edit</button>
                                        <button 
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
        </div>
        <!-- create report modal  -->
        <b-modal ref="createModal" hide-footer title="Create Report" centered>
            <form @submit.prevent="createReport">
                <div class="form-group">
                    <label for="">Label</label>
                    <input type="text" class="form-control" v-model="report.label" autofocus required/>
                </div>
                <div class="form-group">
                    <label for="">Company</label>
                    <select v-model="report.company_id" class="form-control" required>
                        <option v-for="company in companies" :value="company.id" :key="company.id">
                            {{ company.label }}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Branch</label>
                    <select v-model="report.branch_id" class="form-control" required>
                        <option v-for="branch in branches" :value="branch.id" :key="branch.id">
                            {{ branch.label }}
                        </option>
                    </select>
                </div>
                <button class="btn btn-block btn-info mt-4" type="submit"
                :disabled="isLoading">CREATE REPORT</button>
            </form>
        </b-modal>

        <!-- Edit Modal -->
        <b-modal ref="editModal" hide-footer title="Edit Report" centered>
            <form @submit.prevent="updateReport">
                <div class="form-group">
                    <label for="">Label</label>
                    <input type="text" class="form-control" v-model="edit_data.label" autofocus required/>
                </div>
                <div class="form-group">
                    <label for="">Company</label>
                    <select v-model="edit_data.company_id" class="form-control" required>
                        <option v-for="company in companies" :value="company.id" :key="company.id">
                            {{ company.label }}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Branch</label>
                    <select v-model="edit_data.branch_id" class="form-control" required>
                        <option v-for="branch in branches" :value="branch.id" :key="branch.id">
                            {{ branch.label }}
                        </option>
                    </select>
                </div>
                <button class="btn btn-block btn-info mt-4" type="submit"
                :disabled="isLoading">CREATE REPORT</button>
            </form>
        </b-modal>
    </div>
</template>
<script>
    let baseUrl = process.env.MIX_APP_URL;
    export default {
        mounted() {
            console.log('baseUrl', process.env.MIX_BASE_URL);
            this.fetchCompanies();
            this.fetchBranches();
            this.fetchReports();
        },
        data(){
            return {
                filter:'',
                reports: [],
                report: {label:'', company_id:null, branch_id:null},
                edit_data: {},
                headers: [{key:'label', label:'Label'}, {key:'created_at', label:'created on'}
                            ,{key:'company.label', label:'company'}, {key:'branch.label', label:'branch'}
                            , {key:'user.name', label:'created by'},{key:'actions', label:'Actions'}],
                currentPage: 1,
                isLoading:false,
                index: null,
                perPage: 10,
                totalRows: null,
                pageOptions: [10, 15, 20],
                companies: [],
                branches: [],
            }
        },
        methods: {
            fetchCompanies: function(){
                axios.get('/api/companies')
                    .then(result=> {
                        console.log(result.companies);
                        this.companies = result.companies || []
                    })
                    .catch(err=> {

                    })
            },
            fetchBranches: function(){
                axios.get('/api/branches')
                    .then(result=> {
                        this.branches = result.branches || []
                    })
                    .catch(err=> {

                    })
            },
            fetchReports: function(){
                axios.get('/api/reports')
                    .then(result=> {
                        console.log(result.reports);
                        this.reports = result.reports || []
                        this.totalRows = this.reports.length
                    })
                    .catch(err=> {

                    })
            },
            openCreateReportModal: function() {
                this.$refs.createModal.show();
            },
            openEditReportModal: function(row) {
                this.edit_data = row;
                this.$refs.editModal.show();
            },
            createReport: function(){
                this.isLoading = true;
                axios.post('/api/reports', this.report)
                    .then(result=> {
                        this.reports.push(result.report || {});
                        let id = (result.report || {}).id
                        this.report = {}
                        this.isLoading == false;;
                        this.$refs.createModal.hide();
                        if(id) {
                            location.href = `${baseUrl}/reports/${id}`;
                        }
                    })
                    .catch(err=> {
                        this.isLoading = false;
                    })
            },
            updateReport: function(){
                this.isLoading = true;
                axios.put(`/api/reports/${this.edit_data.id}`, this.edit_data)
                    .then(result=> {
                        this.isLoading = false;
                        location.reload(true);
                    })
                    .catch(err=> {
                        this.isLoading = false;
                    })
            },
            openEditModal: function(row, index) {
                this.edit_data = Vue.util.extend({},row);
                this.index = index;
                this.$refs.editModal.show();
            },
            deleteEntry: function(row) {
                if(confirm('Are you sure you want to delete')) {
                    axios.delete(`/api/reports/${row.id}`)
                    .then(result=> {
                        location.reload(true)
                    })
                    .catch(err=> {
                        
                    })
                }
            },
            openReport: function(row) {
                location.href = `${baseUrl}/reports/${row.id}`;
            },
            onFiltered: function(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
        }
    }
</script>