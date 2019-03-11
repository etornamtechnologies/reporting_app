<template>
    <div style="width:100%; height:100%">
        <div style="width:100%; text-align:center; margin-bottom:10px;">
            <span>{{ header }}</span>
        </div>
        <div class="bar-row" v-for="(element, index) in data" :key="index">
            <div class="row-label-col">
                {{ element.label }}
            </div>
            <div class="bar-data-col">
                <div class="bar" :style="{backgroundColor:`${miss_color}`}">
                    <div class="bar-progress" 
                    v-if="element.value > 0"
                    :style="{width:`${element.value}%`, backgroundColor:`${score_color}`}">
                        <span style="color:#ffffff; font-weight:bold">{{ element.value }}%</span>
                    </div>
                    <span class="float-right" style="color:#ffffff; margin-top:5px; font-weight:bold">
                        {{ (100-element.value).toFixed(2) }}%
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['data','header', 'score_color', 'miss_color'],
        mounted() {
            console.log('etor',this.data);
        },
        data: function() {
            return {
                
            }
        },
        methods: {

        }
    }
</script>

<style scoped>
    .bar-row {
        width: 100%;
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        margin-bottom: 15px;
    }
    .row-label-col {
        width: 30%;
        font-size: 20px;
    }
    .bar-data-col {
        width: 70%;
    }
    .bar {
        width: 100%;
        height: 30px;
        position: relative;
    }

    .bar-progress {
        position: absolute;
        height: 100%;
        width: 50%;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        z-index:66666;
    }
</style>

