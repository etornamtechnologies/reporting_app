<template>
    <div class="px-4">
        <el-tabs type="border-card" style="min-height:650px">
            <el-tab-pane label="Report">
                <b-row>
                    <b-col md="12">
                        <el-collapse class="tab-menu">
                            <el-collapse-item title="Report Info" name="1" class="tab-item">
                                <div class="card" style="background-color:#ededed !important; width:60%; margin:auto">
                                    <div class="card-header text-white" style="background-color:#ffc107">Report Info</div>
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <div class="col-sm-4"> <span class="rep-label">Label</span> </div>
                                            <div class="col-sm-8 rep-box">
                                                <div class="rep-box">{{ info.label }}</div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-sm-4"> <span class="rep-label">Comapny</span> </div>
                                            <div class="col-sm-8 rep-box">
                                                <div class="rep-box">{{ (info.company || {}).label || "" }}</div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-sm-4"> <span class="rep-label">Branch</span> </div>
                                            <div class="col-sm-8 rep-box">
                                                <div class="rep-box">{{ (info.branch || {}).label }}</div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-sm-4"> <span class="rep-label">Previous Ranking</span> </div>
                                            <div class="col-sm-8 rep-box">
                                                <div class="rep-box">
                                                    {{ info.previous_num }} / {{ info.previous_den }}
                                                    <button class="btn btn-light btn-sm float-right mt-1 mr-2" @click="openAddRankModal('previous')">
                                                        <i class="el-icon-circle-plus-outline"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-sm-4"> <span class="rep-label">Current Ranking</span> </div>
                                            <div class="col-sm-8 rep-box">
                                                <div class="rep-box">
                                                    {{ info.current_num }} / {{ info.current_den }}
                                                    <button class="btn btn-light btn-sm float-right mt-1 mr-2" @click="openAddRankModal('current')">
                                                        <i class="el-icon-circle-plus-outline"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </el-collapse-item>

                            <el-collapse-item name="3">
                                <template slot="title">
                                    Phone-in customer experience <span style="font-weight:bold; font-size=20px; margin-left:100px">({{ phoneInTotalScorePercent }}%)</span>
                                </template>
                                <div style="background-color:#d9e5f7; width:70%; margin:auto">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-light btn-sm float-right" @click="openAddPhoneInModal">
                                                <i class="el-icon-circle-plus"></i> add
                                            </button>
                                        </div>
                                    </div>
                                    <el-collapse v-for="(entry,index) in phone_in_entries" :key="index">
                                        <el-collapse-item :title="getTypeInfo(entry)">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <button class="btn btn-light btn-sm" @click="openAddSubFieldModal(entry, index, 'phone_in')">
                                                        <i class="el-icon-circle-plus-outline"></i> add new field
                                                    </button>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="float-right">
                                                        <span style="font-weight:bold" class="mr-3">total(ratio): {{ totalFactor(entry).num }}/{{totalFactor(entry).den}}</span>
                                                        <span style="font-weight:bold">total(%): {{ totalPercent(entry) }}%</span>
                                                        <button class="btn btn-light btn-sm ml-3" 
                                                        @click="openEditReportTypeDialog(entry, index, 'phone_in')">
                                                            <i class="el-icon-edit"></i>
                                                        </button>
                                                        <button class="btn btn-light btn-sm  ml-3" @click="removeReportType(entry, index)">
                                                            <i class="el-icon-delete"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Label</th>
                                                        <th>Approve</th>
                                                        <th>Score</th>
                                                        <td>Action</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(sub, idx) in entry.fields" :key="idx">
                                                        <td>{{ sub.label }}</td>
                                                        <td>{{ sub.approve }}</td>
                                                        <td>{{ sub.numerator }}/{{ sub.denumerator }}</td>
                                                        <td>
                                                            <button class="btn btn-light btn-sm  ml-2" @click="openEditSubFieldDialog(sub, index, idx, 'phone_in')">
                                                                <i class="el-icon-edit"></i>
                                                            </button>
                                                            <button class="btn btn-light btn-sm  ml-2" @click="removeSubField(sub, index, idx, 'phone_in')">
                                                                <i class="el-icon-delete"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </el-collapse-item>
                                    </el-collapse>
                                </div>
                            </el-collapse-item>


                            <el-collapse-item name="2">
                                <template slot="title">
                                    Walk-in customer experience <span style="font-weight:bold; font-size=20px; margin-left:100px">({{ walkInTotalScorePercent }}%)</span>
                                </template>
                                <div style="background-color:#d9e5f7; width:70%; margin:auto">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-light btn-sm float-right" @click="openAddWalkInModal">
                                                <i class="el-icon-circle-plus"></i> add
                                            </button>
                                        </div>
                                    </div>
                                    <el-collapse v-for="(entry,index) in walk_in_entries" :key="index">
                                        <el-collapse-item :title="getTypeInfo(entry)">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <button class="btn btn-light btn-sm" @click="openAddSubFieldModal(entry, index, 'walk_in')">
                                                        <i class="el-icon-circle-plus-outline"></i> add new field
                                                    </button>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="float-right">
                                                        <span style="font-weight:bold" class="mr-3">total(ratio): {{ totalFactor(entry).num }}/{{totalFactor(entry).den}}</span>
                                                        <span style="font-weight:bold">total(%): {{ totalPercent(entry) }}%</span>
                                                        <button class="btn btn-light btn-sm ml-3" 
                                                        @click="openEditReportTypeDialog(entry, index, 'walk_in')">
                                                            <i class="el-icon-edit"></i>
                                                        </button>
                                                        <button class="btn btn-light btn-sm  ml-2" @click="removeReportType(entry, index)">
                                                            <i class="el-icon-delete"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table table-bordered mt-1">
                                                <thead>
                                                    <tr>
                                                        <th>Label</th>
                                                        <th>Approve</th>
                                                        <th>Score</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(sub, idx) in entry.fields" :key="idx">
                                                        <td>{{ sub.label }}</td>
                                                        <td>{{ sub.approve }}</td>
                                                        <td>{{ sub.numerator }}/{{ sub.denumerator }}</td>
                                                        <td>
                                                            <button class="btn btn-light btn-sm  ml-2" @click="openEditSubFieldDialog(sub, index, idx, 'walk_in')">
                                                                <i class="el-icon-edit"></i>
                                                            </button>
                                                            <button class="btn btn-light btn-sm  ml-2" @click="removeSubField(sub, index, idx, 'walk_in')">
                                                                <i class="el-icon-delete"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </el-collapse-item>
                                    </el-collapse>
                                </div>
                            </el-collapse-item>

                            <el-collapse-item title="trend data" name="4">
                                <div style="width:70%; margin:auto">
                                    <div class="row" style="background-color:#d9e5f7;">
                                        <div class="col-md-12">
                                            <button class="btn btn-light btn-sm float-right" @click="openAddTrendDataModal">
                                                <i class="el-icon-circle-plus"></i> add
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Label</th>
                                                        <th>Value</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(trend, index) in trend_entries" :key="index">
                                                        <td> {{ trend.label }} </td>
                                                        <td>{{ trend.value }}</td>
                                                        <td>
                                                            <button class="btn btn-light btn-sm float-right" @click="deleteTrend(trend.id, index)">
                                                                <i class="el-icon-delete"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </el-collapse-item>
                        </el-collapse>
                    </b-col>
                </b-row>
            </el-tab-pane>
            <el-tab-pane label="Generate Charts">
                <div class="row">
                    <div class="col-md-12 bg-light">
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-info float-right"
                                @click="printPage()">PRINT</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="background-color:#ffffff; text-align:center;">
                                <span style="font-size:20px; color:#a7a8aa"> {{ info.label }} </span>
                            </div>
                        </div>
                        <div class="row py-3">
                            <div class="col-md-6">
                                <div class="chart-info-header flex-box" style="height:100%">{{ (info.company || {}).label }}</div>
                            </div>
                            <div class="col-md-6" style="text-align:center">
                               <div class="flex-box">
                                   <img src="/images/rocksters-logo.jpg" alt="" class="logo-container">
                               </div>
                            </div>
                        </div>
                        
                        <div class="row px-2">
                            <div class="col-md-12 py-5" style="background-color:#fff; border-radius:10px">
                                <div class="row">
                                    <div class="col-md-12 justify-content-center d-flex">
                                        <span 
                                        class="text-uppercase"
                                        style="font-size:50px; font-weight:bold"> {{ (info.branch || {}).label }} </span>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-12 justify-content-center d-flex">
                                        <span
                                        style="font-size:50px; font-weight:bold">Service Excellence Report</span>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-12 justify-content-center d-flex">
                                        <span
                                        style="font-size:50px; font-weight:bold">Your perfomance:</span>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-12 justify-content-center d-flex">
                                        <span
                                        style="font-size:60px; font-weight:bolder"> {{ averageScore }}% </span>
                                    </div>
                                </div>
                                <div class="row mt-1 mb-5">
                                    <div class="col-md-12 justify-content-center d-flex">
                                        <span
                                        style="font-size:60px; font-weight:bolder"> {{ getClass(averageScore) }} </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row px-4 py-4">
                            <div class="col-md-12" style="text-align:center; background-color:#ffffff; border-radius:10px">
                                <span style="font-size:27px; font-weight:bold">Score</span>
                            </div>
                        </div>

                        <div class="row" style="border-radius: 10px; background-color:#ffffff">
                            <div class="col-md-6" style="text-align:center">
                                {{ walkInTotalScorePercent }}
                                <div id="chart-container">
                                        <fusioncharts
                                        :type="type"
                                        :width="width"
                                        :height="height"
                                        :dataFormat="dataFormat"
                                        :dataSource="walkInGaugeData"
                                        >
                                        </fusioncharts>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-align-center">
                                        <span class="text-score" :class="getClass(walkInTotalScorePercent)">
                                            {{walkInTotalScorePercent}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align:center">
                                {{ phoneInTotalScorePercent }}
                                <div class="chart-container">
                                        <fusioncharts
                                        :type="type"
                                        :width="width"
                                        :height="height"
                                        :dataFormat="dataFormat"
                                        :dataSource="phoneInGaugeData"
                                        >
                                        </fusioncharts>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-align-center">
                                        <span class="text-score" :class="getClass(phoneInTotalScorePercent)">
                                            {{phoneInTotalScorePercent}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 py-3">
                                <div style="width:80%; margin:auto; display:flex; flex-direction:row; justify-content:space-around; align-items:center">
                                    <div class="item-block item-poor">poor</div>
                                    <div class="item-block item-average">average</div>
                                    <div class="item-block item-excellent">excellent</div>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="background-color:#ffffff;">
                            <div class="col-md-12 text-center py-2">
                                <span style="font-size:25px; font-weight:bold; ">
                                    Section Summary
                                </span>
                            </div>
                        </div>

                        <div class="row py-3" style="border:solid 1px #9fa2a3">
                            <div class="col-md-6" style="border-right: 1px solid #ffffff">
                                <barchart-component 
                                :data="etxWalkInBarData" 
                                :miss_color="miss_color" 
                                :score_color="score_color"></barchart-component>
                            </div>
                            <div class="col-md-6">
                                <barchart-component 
                                :data="etxPhoneInBarData" 
                                :miss_color="miss_color" 
                                :score_color="score_color"></barchart-component>
                            </div>
                        </div>
                        <div class="row py-4">
                            <div style="display:flex; flex-direction:row; justify-content:center; width:40%; margin:auto">
                                <div class="score-bg">Scored</div>
                                <div class="missen-bg">Missing</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 text-center">
                                <span style="font-weight:bold; font-size:25px">Overall Trend</span>
                            </div>
                            <div class="col-md-4 text-center">
                                <span style="font-weight:bold; font-size:25px">Your Rank</span>
                            </div>
                        </div>
                        <div class="row py-2 px-2" style="border:solid 2px #9fa2a3; border-radius:10px; overflow-x:auto">
                            <div class="col-md-7 col-sm-12 col-xs-12">
                                <div id="chart-container">
                                    <fusioncharts 
                                    :max-width="max_line_width"
                                    :type="line_type"
                                    :width="line_width"
                                    :height="line_height"
                                    :dataFormat="line_dataFormat"
                                    :dataSource="trendLineChartData"></fusioncharts>
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-12 col-xs-12" style="min-width:300px">
                                <div class="row">
                                    <div class="col-sm-6" style="text-align:center">
                                        <span>Current</span>
                                    </div>
                                    <div class="col-sm-6" style="text-align:center">
                                        <span>Previous</span>
                                    </div>
                                </div>
                                <div class="row py-2">
                                    <div class="col-sm-12 text-center">
                                        <span style="font-wight:bold; font-size:22px">Company</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-12 text-center">
                                                <span style="font-weight:bold; font-size:20px">{{ info.current_num }}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 text-center">
                                                <span style="font-size:20px">(of {{ info.current_den }})</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-12 text-center">
                                                <span style="font-weight:bold; font-size:20px">{{ info.previous_num }}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 text-center">
                                                <span style="font-size:20px">(of {{ info.previous_den }})</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </el-tab-pane>
            <el-tab-pane label="Export to Excel">
                <div class="row bg-light py-1 mb-3">
                    <div class="col-md-12">
                        <download-excel
                            class   = "btn btn-info btn-sm float-right"
                            title = "Customer Experience Report"
                            :data   = "allCsv"
                            :fields = "json_fields"
                            worksheet = "My Worksheet"
                            :name    = "reportName"
                            type = "excel">
                        
                            Customer Experience report
                        
                        </download-excel>
                    </div>                  
                </div>
                <div class="row">
                    <div class="col-md-6" style="min-height:400px">
                        <div class="card">
                            <div class="card-header py-1 bg-dark text-white">Phone-In Customer experience</div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Field</th>
                                            <th>Approve</th>
                                            <th>Ratio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(entry, index) in phoneInCsv" :key="index">
                                            <td>{{ entry.field }}</td>
                                            <td>{{ entry.approve }}</td>
                                            <td style="min-width:90px">{{ entry.score_ratio }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" style="min-height:400px">
                        <div class="card">
                            <div class="card-header py-1 bg-dark text-white">Walk-In Customer experience</div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Field</th>
                                            <th>Approve</th>
                                            <th>Ratio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(entry, index) in walkInCsv" :key="index">
                                            <td>{{ entry.field }}</td>
                                            <td>{{ entry.approve }}</td>
                                            <td style="min-width:90px">{{ entry.score_ratio }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                    
                </div>
            </el-tab-pane>
        </el-tabs>

        <b-modal ref="addWalkInNewFieldModal"
            title="add new walk-in field"
            centered
            :no-close-on-backdrop="true"
            :no-close-on-esc="true"
            :hide-footer="true"
        >
            <b-form @submit.prevent="addWalkIn">
                <b-form-group label="field label">
                    <b-form-input
                        type="text"
                        v-model="new_walk_in_field"
                        required
                    >
                    </b-form-input>
                </b-form-group>
                <b-button type="submit" variant="success" class="btn-block" :disabled="isLoading">
                    <i class="fas fa-edit"></i> Add
                </b-button>
            </b-form>
        </b-modal>

        <b-modal ref="addPhoneInNewFieldModal"
            title="add new phone-in field"
            centered
            :no-close-on-backdrop="true"
            :no-close-on-esc="true"
            :hide-footer="true"
        >
            <b-form @submit.prevent="addPhoneIn">
                <b-form-group label="field label">
                    <b-form-input
                        type="text"
                        v-model="new_phone_in_field"
                        required
                    >
                    </b-form-input>
                </b-form-group>
                <b-button type="submit" variant="success" class="btn-block" :disabled="isLoading">
                    <i class="fas fa-edit"></i> Add
                </b-button>
            </b-form>
        </b-modal>

        <b-modal ref="editReportTypeDialog"
        title="edit"
        centered
        :no-close-on-backdrop="true"
        :no-close-on-esc="true"
        :hide-footer="true"
        >
            <b-form @submit.prevent="editReportType">
                <b-form-group label="field label">
                    <b-form-input
                        type="text"
                        v-model="edit_report_type.label"
                        required
                    >
                    </b-form-input>
                </b-form-group>
                <b-button type="submit" variant="success" class="btn-block" :disabled="isLoading">
                    <i class="fas fa-edit"></i> Update
                </b-button>
            </b-form>
        </b-modal>

        <b-modal ref="addSubFieldModal"
            title="add new field"
            centered
            :no-close-on-backdrop="true"
            :no-close-on-esc="true"
            :hide-footer="true"
        >
            <b-form @submit.prevent="createSubField">
                <b-form-group label="field label">
                    <b-form-input
                        id="#phone-in-subfield-label"
                        type="text"
                        v-model="new_sub_field.label"
                        required
                    >
                    </b-form-input>
                </b-form-group>
                <div class="form-group">
                    <label for="">Approve</label>
                    <select name="" id="" class="form-control" v-model="new_sub_field.approve">
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                    </select>
                </div>
                <b-form-group label="score(numerator)">
                    <b-form-input
                        type="number"
                        v-model="new_sub_field.num"
                        required
                        min="0"
                        autocomplete="off"
                    >
                    </b-form-input>
                </b-form-group>
                <b-form-group label="score(denumerator)">
                    <b-form-input
                        type="number"
                        v-model="new_sub_field.den"
                        required
                        min="0"
                        autocomplete="off"
                    >
                    </b-form-input>
                </b-form-group>
                <b-button type="submit" variant="success" class="btn-block" :disabled="isLoading">
                    <i class="fas fa-edit"></i> Add
                </b-button>
            </b-form>
        </b-modal>


        <b-modal ref="editSubFieldDialog"
            title="add new field"
            centered
            :no-close-on-backdrop="true"
            :no-close-on-esc="true"
            :hide-footer="true"
        >
            <b-form @submit.prevent="editSubField">
                <b-form-group label="field label">
                    <b-form-input
                        type="text"
                        v-model="edit_sub_field.label"
                        required
                    >
                    </b-form-input>
                </b-form-group>
                <div class="form-group">
                    <label for="">Approve</label>
                    <select name="" id="" class="form-control" v-model="edit_sub_field.approve">
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                    </select>
                </div>
                <b-form-group label="score(numerator)">
                    <b-form-input
                        type="number"
                        v-model="edit_sub_field.numerator"
                        required
                        min="0"
                        autocomplete="off"
                    >
                    </b-form-input>
                </b-form-group>
                <b-form-group label="score(denumerator)">
                    <b-form-input
                        type="number"
                        v-model="edit_sub_field.denumerator"
                        required
                        min="0"
                        autocomplete="off"
                    >
                    </b-form-input>
                </b-form-group>
                <b-button type="submit" variant="success" class="btn-block" :disabled="isLoading">
                    <i class="fas fa-edit"></i> Update
                </b-button>
            </b-form>
        </b-modal>

        <b-modal ref="addTrendDataModal"
            title="add new record"
            centered
            :no-close-on-backdrop="true"
            :no-close-on-esc="true"
            :hide-footer="true"
        >
            <b-form @submit.prevent="createTrend">
                <b-form-group label="field">
                    <b-form-input
                        type="text"
                        v-model="new_trend.label"
                        required
                    >
                    </b-form-input>
                </b-form-group>
                <b-form-group label="value">
                    <b-form-input
                        type="number"
                        v-model="new_trend.value"
                        required
                    >
                    </b-form-input>
                </b-form-group>
                <b-button type="submit" variant="success" class="btn-block" :disabled="isLoading">
                    <i class="fas fa-edit"></i> Add
                </b-button>
            </b-form>
        </b-modal>

        <b-modal ref="addRankModal"
            :title="new_rank.title"
            centered
            :no-close-on-backdrop="true"
            :no-close-on-esc="true"
            :hide-footer="true"
        >
            <b-form @submit.prevent="createRank">
                <b-form-group label="rank">
                    <b-form-input
                        type="number"
                        v-model="new_rank.num"
                        required
                        min="0"
                        autocomplete="off"
                    >
                    </b-form-input>
                </b-form-group>
                <b-form-group label="out of">
                    <b-form-input
                        type="number"
                        v-model="new_rank.den"
                        required
                        autocomplete="off"
                        min="0"
                    >
                    </b-form-input>
                </b-form-group>
                <b-button type="submit" variant="success" class="btn-block" :disabled="isLoading">
                    <i class="fas fa-edit"></i> Update
                </b-button>
            </b-form>
        </b-modal>

    </div>
</template>

<script>
    const SUB_FIELD_STORE_KEY = 'sub_field_key';
    let items = [];
    import FusionCharts from 'fusioncharts';
    import Charts from 'fusioncharts/fusioncharts.charts';
    import { FCComponent } from 'vue-fusioncharts';

    // Resolves charts dependancy
    Charts(FusionCharts);
    export default {
        mounted() {
            //this.walk_in_datasource.dials.dial[0].value = this.walkInTotalScorePercent;
            this.fetchReport();
            // jQuery('#phone-in-subfield-label').val((this.new_phone_in || {}).label || "").autocomplete({
            //     autoFocus:true,
            //     classes: {
            //         "ui-autocomplete": "auto-style"
            //     },
            //     position: {
            //     collision:"fit flip"
            //     },
            //     minLength: 3,
            //     source: (request, response)=> {
            //         let res = this.subFieldStore(request.term)
            //         response(res);
            //     },
            //     select: (event, ui) => {
            //             $select = jQuery(event.target);
            //             let value = ui.item;
            //             this.new_phone_in = value
            //     },
            //     change: (event, ui) => {
            //         let text = jQuery(event.target).val()
            //     },
            // }).focus(function() {
            //     $(this).autocomplete("search");
            // })    
        },
        watch: {
            
        },
        data() {
            return {
                isLoading: false,
                //etx_bar_char data
                miss_color: '#f44242',
                score_color: '#277fd1',
                report: {},
                sub_loading: false,
                //gauge config data
                type: "angulargauge",
                renderAt: "chart-container",
                width: "400",
                height: "400",
                dataFormat:'json',

                //barchart config data
                bar_type: "bar2d",
                bar_width: '100%',
                bar_height: '400',
                bar_dataFormat: 'json',

                line_width:"800",
                max_line_width: '800',
                line_type:"line",
                line_height:"600",
                line_dataFormat:"json",
                // activeNames: ['1'],
                new_walk_in_field: "", 
                new_phone_in_field: "",
                new_sub_field: {label:"", num:null, den:null},
                walk_in_total_score_percent: this.walkInTotalScorePercent,
                phone_in_total_score_percent: this.phoneInTotalScorePercent,
                new_trend: {},
                new_rank:{},
                edit_report_type: {},
                edit_sub_field: {},

                trendMaxWidth: '200px',

                json_fields: {
                    '': 'index',
                    'Customer experience field': 'field',
                    'approve': 'approve',
                    'score ratio': 'score_ratio',
                },
                json_meta: [
                    [
                        {
                            'key': 'charset',
                            'value': 'utf-8'
                        }
                    ]
                ],

            }
        },
        methods: {
            getClass: function(score) {
                if(score < 50) {
                    return 'poor'
                } else if(score >= 50 && score < 75) {
                    return 'average'
                } else {
                    return 'excellent'
                }
            },
            fetchReport: function() {
                let urlArray = (location.href || "").split('/');
                let reportId = urlArray[urlArray.length - 1];
                this.isLoading = true;
                axios.get(`/api/reports/${reportId}`)
                    .then((result)=> {
                        this.isLoading = false;
                        console.log('res',result);
                        this.report = result.report || {}
                    })
                    .catch((err)=> {
                        this.isLoading = false;
                        this.handleError(err);
                    })
            },
            printPage: function(){
                this.$nextTick(()=> {
                    window.print();
                })
            },
            openAddRankModal: function(type) {
                this.new_rank = {};
                this.new_rank.title = type;
                this.$refs.addRankModal.show();
            },
            createRank: function() {
                this.isLoading = true;
                axios.put(`/api/reports/${this.report.report.id}/add-rank`, this.new_rank)
                    .then((res)=> {
                        this.isLoading = false;
                        location.reload(true);
                    })
                    .catch((err)=> {
                        this.isLoading = false;
                        this.handleError(err);
                    })
                
            },
            test: function() {
                this.walkInBarData.data = this.walkInBarChartData
            },
            openAddWalkInModal: function() {
                this.new_walk_in_field = "";
                this.$refs.addWalkInNewFieldModal.show();
            },
            openAddPhoneInModal: function() {
                this.new_phone_in_field = "";
                this.$refs.addPhoneInNewFieldModal.show();
            },
            addWalkIn: function() {
                let fieldLabel = this.new_walk_in_field;
                let data = {};
                data.label = this.new_walk_in_field;
                data.type = 'walk_in';
                data.total_score_percent = 0;
                data.numerator = null;
                data.denumerator = null;
                this.isLoading = true;
                axios.post(`/api/reports/${this.info.id}/types/create`, data)
                    .then((res)=> {
                        this.isLoading = false;
                        if(res.code == 0) {
                            this.$refs.addWalkInNewFieldModal.hide();
                            let type = res.report || {};
                            type.fields = [];
                            (this.report.walk_in_entries || []).push(type);
                            Notifier.success('Added');
                        } else {
                            Notifier.error(res.message || "")
                        }
                    })
                    .catch((err)=> {
                        this.isLoading = false;
                        this.handleError(err);
                    })
            },
            editReportType: function() {
                let data = this.edit_report_type;
                this.isLoading = true;
                axios.put(`/api/reports/${this.info.id}/types/${data.id}/edit`, data)
                    .then((res)=> {
                        console.log('res',res)
                        this.isLoading = false;
                        if(res.code == 0) {
                            Notifier.success('Updated');
                            location.reload(true)
                        } else {
                            this.isLoading = false;
                            Notifier.error(res.message || "")
                        }
                    })
            },
            removeWalkIn: function(index) {
                this.walk_in.splice(index, 1);
            },
            addPhoneIn: function() {
                let data = {};
                data.label = this.new_phone_in_field;
                data.type = 'phone_in';
                data.total_score_percent = 0;
                data.numerator = null;
                data.denumerator = null;
                this.isLoading = true;
                axios.post(`/api/reports/${this.info.id}/types/create`, data)
                    .then((res)=> {
                        this.isLoading = false;
                        if(res.code == 0) {
                            this.$refs.addPhoneInNewFieldModal.hide();
                            let type = res.report || {};
                            type.fields = [];
                            (this.report.phone_in_entries || []).push(type);
                            Notifier.success('Added');
                        } else {
                            Notifier.error(res.message || "")
                        }
                    })
                    .catch((err)=> {
                        this.isLoading = false;
                        this.handleError(err);
                    })
            },
            removeReportType: function(entry, index) {
                this.isLoading = true;
                axios.delete(`/api/reports/types/delete/${entry.id}`)
                    .then((res)=> {
                        this.isLoading = false;
                        if(res.code == 0) {
                            let type = entry.type || "";
                            if(type == 'walk_in') {
                                (this.report.walk_in_entries || []).splice(index, 1);
                            } else if(type == 'phone_in') {
                                (this.report.phone_in_entries || []).splice(index, 1)
                            }
                            Notifier.success('remove successful')
                        }
                    })
                    .catch((err)=> {
                        this.isLoading = false;
                        this.handleError(err);
                    })
            },
            removePhoneIn: function(index) {
                this.phone_in.entries.splice(index, 1);
            },
            handleChange(val) {
            },
            openAddSubFieldModal: function(entry, index, type) {
                this.new_sub_field = {};
                this.new_sub_field.index = index || 0;
                this.new_sub_field.type = type;
                this.new_sub_field.id = entry.id;
                this.$refs.addSubFieldModal.show();
            },
            openEditSubFieldDialog: function(entry, index, type) {
                console.log('row',entry);
                this.edit_sub_field = Vue.util.extend({},entry);
                this.edit_sub_field.index = index || 0;
                this.edit_sub_field.type = type;
                this.$refs.editSubFieldDialog.show();
            },
            createSubField: function() {
                let type = this.new_sub_field.type;
                let index = this.new_sub_field.index;
                this.isLoading = true;              
                axios.post(`/api/reports/create-subfield`, this.new_sub_field)
                    .then((res)=> {
                        this.isLoading = false;
                        if(res.code == 0) {
                            this.$refs.addSubFieldModal.hide();
                            if(type == 'walk_in') {
                                this.report.walk_in_entries[index].fields.push(res.field);
                            } else if(type == 'phone_in') {
                                this.report.phone_in_entries[index].fields.push(res.field);
                            }
                            Notifier.success('Field created')
                        } else {
                            Notifier.error(res.message || "")
                        }
                    })
                    .catch((err)=> {
                        this.isLoading = false;
                        this.handleError(err);
                    })
            },
            editSubField: function() {
                console.log('sub',this.edit_sub_field)
                this.isLoading = true;
                let data = this.edit_sub_field
                axios.put(`/api/reports/create-subfield/${data.id}`, data)
                    .then(res=> {
                        this.isLoading = false;
                        Notifier.success('updated');
                        location.reload(true);
                    })
                    .catch(err=> {
                        Notifier.error('Failed');
                    })
            },
            removeSubField: function(entry, type_index, sub_index, type) {
                this.isLoading = true;
                axios.delete(`/api/reports/create-subfield/${entry.id}`)
                    .then((res)=> {
                        this.isLoading = false;
                        if(res.code == 0) {
                            if(type == 'walk_in') {
                                ((this.report.walk_in_entries[type_index] || {}).fields || []).splice(sub_index, 1);
                            } else if(type=='phone_in') {
                                ((this.report.phone_in_entries[type_index] || {}).fields || []).splice(sub_index, 1);
                            }
                            Notifier.success('field removed')
                        } else {
                            Notifier.error(res.message || "")
                        }
                    })
                    .catch((err)=> {
                        this.isLoading = false;
                        this.handleError(err);
                    })
            },
            totalFactor: function(entry) {
                let entries = entry.fields || [];
                let num = 0;
                let den = 0;
                entries.forEach((ent)=> {
                    let n = Number(ent.numerator || 0);
                    let d = Number(ent.denumerator || 0)
                    num+=n;
                    den+=d;
                })
                return {num:num, den:den};
            },
            totalPercent: function(entry) {
                let entries = entry.fields || [];
                let num = 0;
                let den = 0;
                entries.forEach((ent)=> {
                    let n = Number(ent.numerator || 0);
                    let d = Number(ent.denumerator || 0)
                    num+=n;
                    den+=d;
                })
                let percent = (((num * 100)/den) || 0).toFixed(2);
                return percent;
            },
            getTypeInfo: function(entry) {
                let name = entry.label || "";
                let percent = this.totalPercent(entry);
                return `${name}     (${percent}%)`
            },
            openAddTrendDataModal: function(entry) {
                this.new_trend = {};
                this.$refs.addTrendDataModal.show();
            },
            createTrend: function() {
                this.isLoading = true;
                axios.post(`/api/reports/${this.report.report.id}/create-trend`, this.new_trend)
                    .then((res)=> {
                        this.isLoading = false;
                        if(res.code == 0) {
                            this.$refs.addTrendDataModal.hide();
                            this.report.trend_entries.push(res.trend);
                            Notifier.success('trend created')
                        } else {
                            Notifier.error(res.message || "")
                        }
                    })
                    .catch((err)=> {
                        this.isLoading = false;
                        this.handleError(err);
                    })
            },
            deleteTrend: function(id, idx) {
                this.isLoading = true;
                axios.delete(`/api/reports/trend-data/${id}`)
                    .then((res)=> {
                        this.isLoading = false;
                        if(res.code == 0) {
                            this.report.trend_entries.splice(idx, 1);
                            this.trendLineChartData
                            Notifier.success('trend deleted');
                        } else {
                            Notifier.error(res.message || "");
                        }
                    })
                    .catch((err)=> {
                        this.isLoading = false;
                        this.handleError(err);
                    })
            },
            handleError: function(err) {
                let errResponse = err.response || {};
                if(errResponse.status ==422) {
                    let data = errResponse.data || {}
                    let errors = data.errors
                    Object.keys(errors).forEach((error)=> {
                        let er = errors[error];
                        Notifier.error(er[0]);
                    })
                } else {
                    Notifier.error('Server error / Please reload the page or cintact admin');
                }
            },
            openEditReportTypeDialog: function(row, idx, type) {
                this.edit_report_type = Vue.util.extend({},row);
                this.edit_report_type.type = type;
                this.edit_report_type.index = idx;
                this.$refs.editReportTypeDialog.show();
            }
        },
        computed: {
            subFieldStore: function(txt) {
                let store = localStorage.getItem(SUB_FIELD_STORE_KEY);
                let list = [];
                if(store) {
                    list = JSON.parse(store) || [];
                } else {
                    return []
                }
                let res = list.filter((item)=> {
                    return item.indexOf(txt) > -1
                })
                console.log(res)
                return res;
            },
            setSubField: function(text) {
                let store = localStorage.getItem(SUB_FIELD_STORE_KEY);
                let list = [];
                if(store) {
                    list = JSON.parse(store);
                }
                if(!list.includes(text)) {
                    list.push(text);
                    localStorage.setItem(SUB_FIELD_STORE_KEY, JSON.stringify(list));
                }
            },
            walkInTotalScorePercent: function() {
                let entries = this.report.walk_in_entries || [];
                let totalNum = 0;
                let totalDen = 0;
                entries.forEach((entry)=> {
                    let ratioT = this.totalFactor(entry) || {};
                    totalNum+=Number(ratioT.num || 0);
                    totalDen+=Number(ratioT.den || 0) || 0;
                })
                if(totalNum == 0) {
                    return 0;
                } else {
                    let ratioStr = (`${totalNum} / ${totalDen}`);
                    let percent = ((totalNum * 100)/totalDen).toFixed(2) || 0.00;
                    return percent
                }
                
            },
            phoneInTotalScorePercent: function() {
                let entries = this.report.phone_in_entries || [];
                let totalNum = 0;
                let totalDen = 0;
                entries.forEach((entry)=> {
                    let ratioT = this.totalFactor(entry) || {};
                    totalNum+=Number(ratioT.num || 0);
                    totalDen+=Number(ratioT.den || 0);
                })
                if(totalNum == 0) {
                    return 0;
                } else {
                    let ratioStr = (`${totalNum} / ${totalDen}`);
                    let percent = ((totalNum * 100)/totalDen).toFixed(2) || 0.00;
                    return percent
                }
            },
            walkInGaugeData: function() {
                let data = {}
                data.chart = {
                    caption: "walk in",
                    lowerLimit: 0,
                    upperLimit: 100,
                    showValue:1,
                    numberSuffix: '%',
                    theme: "fusion",
                    showToolTip: 0
                };
                data.colorRange = {
                    color:[{minValue:0,
                            maxValue:50,
                            code: "#f44646"
                            },
                            {minValue:50,
                            maxValue:75,
                            code: "#ed8c4b"
                            },
                            {minValue:75,
                            maxValue:100,
                            code: "#f2e71a"
                            },
                    ]
                };
                data.dials= {
                    dial: [{value:null}]
                }
                let totalPercent = this.walkInTotalScorePercent;
                data.dials.dial[0].value = totalPercent;
                return data;
            },
            phoneInGaugeData: function() {
                let data = {}
                data.chart = {
                    caption: "phone in",
                    lowerLimit: 0,
                    upperLimit: 100,
                    showValue:1,
                    numberSuffix: '%',
                    theme: "fusion",
                    showToolTip: 0
                };
                data.colorRange = {
                    color:[{minValue:0,
                            maxValue:50,
                            code: "#f44646"
                            },
                            {minValue:50,
                            maxValue:75,
                            code: "#ed8c4b"
                            },
                            {minValue:75,
                            maxValue:100,
                            code: "#f2e71a"
                            },
                    ]
                };
                data.dials= {
                    dial: [{value:null}]
                }
                let totalPercent = this.phoneInTotalScorePercent;
                data.dials.dial[0].value = totalPercent;
                return data;
            },
            walkInBarChartData: function() {
                let data = {};
                data.chart = {
                    caption: "walk-in bar chart",
                    yaxisname: "score",
                    aligncaptionwithcanvas: "0",
                    plottooltext: "<b>$dataValue</b> leads received",
                    theme: "zune"
                }
                let entries = this.report.walk_in_entries || [];
                let res = [];
                entries.forEach((entry)=> {
                    let dd = {};
                    let entryRatio = this.totalFactor(entry) || {};
                    let num = Number(entryRatio.num) || 0;
                    let dem = Number(entryRatio.den) || 0;
                    let percent = ((num * 100)/dem).toFixed(2) || 0.00;
                    if(isNaN(percent)) {
                        percent = 0.00;
                    }
                    dd.label = entry.label;
                    dd.value = percent;
                    res.push(dd);
                })
                data.data = res;
                return data;
            },
            phoneInBarChartData: function() {
                let data = {};
                data.chart = {
                    caption: "phone-in bar chart",
                    yaxisname: "score",
                    aligncaptionwithcanvas: "0",
                    plottooltext: "<b>$dataValue</b> leads received",
                    theme: "zune"
                }
                let entries = this.report.phone_in_entries || [];
                let res = [];
                entries.forEach((entry)=> {
                    let dd = {};
                    let entryRatio = this.totalFactor(entry) || {};
                    let num = Number(entryRatio.num) || 0;
                    let dem = Number(entryRatio.den) || 0;
                    let percent = ((num * 100)/dem).toFixed(2) || 0.00;
                    if(isNaN(percent)) {
                        percent = 0.00;
                    }
                    dd.label = entry.label;
                    dd.value = percent;
                    res.push(dd);
                })
                data.data = res;
                return data;
            },
            trendLineChartData: function() {
                let data = {};
                data.chart =  {
                                caption: "overall trend",
                                yaxisname: "score",
                                numbersuffix: "%",
                                rotatelabels: "1",
                                setadaptiveymin: "1",
                                theme: "zune"
                            };
                let dataList = [];
                this.trend_entries.forEach((entry)=> {
                    let d = {};
                    d.value = entry.value || 0;
                    d.label = entry.label || "";
                    dataList.push(d);
                })
                data.data = dataList;
                return data;            
            },
            trend_entries: function() {
                return this.report.trend_entries || [];
            },
            info: function() {
                console.log('repirt',this.report)
                return this.report.report || {};
            },
            walk_in_entries: function() {
                return this.report.walk_in_entries || []
            },
            phone_in_entries: function() {
                return this.report.phone_in_entries || []
            },
            walkInLabel: function() {
                return `Walk-in customer experience  (${this.walkInTotalScorePercent})`
            },
            phoneInLabel: function() {
                return `Phone-in customer experience (${this.phoneInTotalScorePercent})`
            },
            etxWalkInBarData: function() {
                let entries = this.report.walk_in_entries || [];
                let res = [];
                let inf = {};
                inf.label = 'Walk in total';
                inf.value = this.walkInTotalScorePercent;
                res.push(inf);
                entries.forEach((entry)=> {
                    let dd = {};
                    let entryRatio = this.totalFactor(entry) || {};
                    let num = Number(entryRatio.num) || 0;
                    let dem = Number(entryRatio.den) || 0;
                    let percent = ((num * 100)/dem).toFixed(2) || 0.00;
                    if(isNaN(percent)) {
                        percent = 0.00;
                    }
                    dd.label = entry.label;
                    dd.value = percent;
                    res.push(dd);
                })
                return res;
            },
            etxPhoneInBarData: function() {
                let entries = this.report.phone_in_entries || [];
                let res = [];
                let inf = {};
                inf.label = 'Phone in total';
                inf.value = this.phoneInTotalScorePercent;
                res.push(inf);
                entries.forEach((entry)=> {
                    let dd = {};
                    let entryRatio = this.totalFactor(entry) || {};
                    let num = Number(entryRatio.num) || 0;
                    let dem = Number(entryRatio.den) || 0;
                    let percent = ((num * 100)/dem).toFixed(2) || 0.00;
                    if(isNaN(percent)) {
                        percent = 0.00;
                    }
                    dd.label = entry.label;
                    dd.value = percent;
                    res.push(dd);
                })
                return res;
            },
            walkInCsv: function(){
                let walk_entries = this.report.walk_in_entries || [];
                let phone_entries = this.report.phone_in_entries || [];
                let res = [];
                walk_entries.forEach((walk_entry)=> {
                    let f = {};
                    f.field = (walk_entry.label).toUpperCase() || "";
                    f.approve = "";
                    let entryRatio = this.totalFactor(walk_entry)
                    f.score_ratio = `${entryRatio.num}/${entryRatio.den}`;
                    res.push(f);
                    let walk_fields = walk_entry.fields || [];
                    walk_fields.forEach((ent, index)=> {
                        let d = {};
                        d.index = index+1;
                        d.field = ent.label || "";
                        d.approve = ent.approve || 'no';
                        d.score_ratio = `${ent.numerator}/${ent.denumerator}`
                        res.push(d)
                    })
                })
                return res;
            },
            phoneInCsv: function(){
                let phone_entries = this.report.phone_in_entries || [];
                let res = [];
                phone_entries.forEach((phone_entry)=> {
                    let f = {};
                    f.field = (phone_entry.label).toUpperCase() || "";
                    f.approve = "";
                    let entryRatio = this.totalFactor(phone_entry) || {};
                    f.score_ratio = `${entryRatio.num}/ ${entryRatio.den}`;
                    res.push(f);
                    let phone_fields = phone_entry.fields || [];
                    phone_fields.forEach((ent, index)=> {
                        let d = {};
                        d.index = index+1;
                        d.field = ent.label || "";
                        d.approve = ent.approve || 'no';
                        d.score_ratio = `${ent.numerator}/${ent.denumerator}`
                        res.push(d)
                    })
                })
                return res;
            },      
            allCsv: function() {
                let walk_entries = this.report.walk_in_entries || [];
                let phone_entries = this.report.phone_in_entries || [];
                let res = [];
                res.push({field:'', approve:'', score_ratio:''});
                res.push({field:'', approve:'', score_ratio:''});
                let phoneHeader = {field: 'PHONE IN CUSTOMER EXPERIENCE', approve:'', score_ratio: this.phoneInTotalScorePercent}
                res.push(phoneHeader);
                phone_entries.forEach((phone_entry)=> {
                    let f = {};
                    f.field = (phone_entry.label).toUpperCase() || "";
                    f.approve = "";
                    let entryRatio = this.totalFactor(phone_entry) || {}
                    let entryPercent = this.totalPercent(phone_entry) || 0;
                    f.score_ratio = `${entryRatio.num}/${entryRatio.den} (${entryPercent}%)`;
                    res.push(f);
                    let phone_fields = phone_entry.fields || [];
                    phone_fields.forEach((ent, index)=> {
                        let d = {};
                        d.index = index+1;
                        d.field = ent.label || "";
                        d.approve = ent.approve || 'no';
                        let percent = 0;
                        let den = ent.denumerator;
                        let num = ent.numerator;
                        if(den && num && den != 0) {
                            percent = ((num *100)/den).toFixed(2);
                        }
                        d.score_ratio = `${ent.numerator}/${ent.denumerator}  (${percent}%)`
                        res.push(d)
                    })
                }) 
                let walkHeader = {field: 'WALK IN CUSTOMER EXPERIENCE', approve:'', score_ratio: this.walkInTotalScorePercent}
                res.push(walkHeader);
                walk_entries.forEach((walk_entry)=> {
                    let f = {};
                    f.field = (walk_entry.label).toUpperCase() || "";
                    f.approve = "";
                    let entryRatio = this.totalFactor(walk_entry) || {}
                    let entryPercent = this.totalPercent(walk_entry) || 0;
                    f.score_ratio = `${entryRatio.num}/${entryRatio.den} (${entryPercent}%)`;
                    res.push(f);
                    let walk_fields = walk_entry.fields || [];
                    walk_fields.forEach((ent, index)=> {
                        let d = {};
                        d.index = index+1;
                        d.field = ent.label || "";
                        d.approve = ent.approve || 'no';
                        let percent = 0;
                        let den = ent.denumerator;
                        let num = ent.numerator;
                        if(den && num && den != 0) {
                            percent = ((num *100)/den).toFixed(2);
                        }
                        d.score_ratio = `${ent.numerator}/${ent.denumerator}  (${percent}%)`
                        res.push(d)
                    })
                })   
                return res;            
            },      
            staffData: function() {
                let entries = this.report.walk_in_entries || [];
                let fieldData = entries[0].fields || [];
                let res = [];
                fieldData.forEach((ent)=> {
                    let d = {};
                    d.field = ent.label || "";
                    d.approve = ent.approve || 'no';
                    d.score_ratio = `${ent.numerator}/${ent.denumerator}`
                    res.push(d)
                })
                return res;
            },
            reportName: function() {
                return this.info.label || "customer_report";
            },
            averageScore: function() {
                let walkInPercent = this.walkInTotalScorePercent || 0;
                let phoneInPercent = this.phoneInTotalScorePercent || 0;
                let sum = Number(walkInPercent) + Number(phoneInPercent)
                return (sum/2).toFixed(2)
            }
        }
    }
</script>

<style>
    .rep-label {
        font-size: 20px;
        font-weight: bold;
        color: #abacad;
    }

    .rep-box {
        background-color: #ffc107;
        font-size: 20px;
        font-weight: bold;
        color: #ffffff;
        width: 120% !important;
        box-shadow: 3px 3px 12px 0px
    }

    .chart-info-header {
        font-size: 25px;
        font-weight: bold;
        color: #959799;
        text-transform: uppercase;
        font-family: "Comic Sans MS", cursive, sans-serif
    }

    .item-block{
        height: 20px;
        width: 100px;
        color: #ffffff;
        font-size: 20px;
        padding: 5px;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .item-poor {
        background-color: #f44646
    }

    .item-average {
        background-color: #ed8c4b;
    }

    .item-excellent {
        background-color: #f2e71a;
    }

    .score-bg {
        background-color: #277fd1;
        width: 70px;
        height: 30px;
        margin-right: 10px;
        color: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .missen-bg {
        background-color: #f44242;
        width: 70px;
        height: 30px;
        color: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    thead {
        color: #b0b1b2;
    }

    .text-score {
        font-weight: bold;
        font-size: 35px;
    }

    .poor {
        color: #f44646;
    }
    .average {
        color: #ed8c4b
    }
    .excellent {
        color: #f2e71a;
    }

    .logo-container {
        width: 600px;
        max-width: 600px;
        height: 100px;
    }

    .flex-box {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        flex-wrap: nowrap;
        width: 100%;
        height: 100%;
    }
    @media print {
        button {
            display: none !important;
        }
        .el-tab-pane .el-tab {
            display: none !important;
        }
        .logo-container {
            width: 400px;
        }
        .raphael-group-163-canvas {
            max-width: 20px;
        }
        #chartobject-3 {

        }
        #raphael-paper-140 {
            /* width: 100%;
            max-width: 5100%;
            overflow-x: hidden; */
        }
    }
</style>
