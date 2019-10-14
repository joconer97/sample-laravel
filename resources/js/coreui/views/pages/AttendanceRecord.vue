<template>
    <div style="margin-bottom : 10px">
        <h1>Camera</h1>
        <div class="row" style="background:red;margin:0 auto">
            <input type="text" placeholder="Employee #" v-model="employeeID">
            <button class="btn btn-primary" @click="switchCamera">Enter</button>
        </div>

        <div class="row" style="background:green;height:600px">
            <div class="col-md-8" style="background:blue">
                <attendance-camera :employee="employee" v-show="isOn"></attendance-camera>
            </div>

            <div class="col-md-4">
                <b-card no-body class="overflow-hidden" style="max-width: 540px;" v-for="(history,index) in attendanceHistory" :key="index">
                    <b-row no-gutters>
                    <b-col md="6">
                        <b-card-img :src="`/images/employees/`+history.profile_pic"  height="150" width="150x" class="rounded mx-auto d-block"></b-card-img>
                    </b-col>
                    <b-col md="6">
                        <b-card-body :title="history.firstname">
                        <b-card-text>
                            <p>{{history.firstname}}   {{history.lastname}}</p>
                        </b-card-text>
                        </b-card-body>
                    </b-col>
                    </b-row>
                </b-card>
            </div>
        </div>
    </div>
</template>
<script>
import AttendanceCamera from './AttendanceCamera'
import * as faceapi from "../../../face-api.min.js";
import {bus} from '../../main.js'
export default {
    data(){
        return {
            employeeID : undefined,
            isOn : false,
            attendanceHistory : [],
            employee : null
        }
    },
    components : {AttendanceCamera},
    methods : {
        switchCamera(){
            if(this.employeeID == undefined) return
            if(this.isOn){
                this.isOn = false
            }else{
                this.employee = this.getEmployee(this.employeeID)
                console.log(this.employee)
                this.isOn = true
                this.employeeID = undefined
            }
        },
        getEmployee(id){
            let index = this.employees.findIndex(employee => employee.id == id)
            this.employee = this.employees[index]
            bus.$emit('searchEmployee',this.employee)
            return this.employees[index]
        }
    },
    computed : {
        employees () {
            return this.$store.getters.employees
        }
    },
    mounted(){
        if (this.employees.length)
            return

        this.$store.dispatch('getEmployee')
        
    },
    created(){
        bus.$on('testing', (data) => {
            var today = new Date();
            var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            var attendance = {user_id : data.id,attendance : time}

            axios.post('/api/attendance',attendance)
                .then(response => {
                    console.log(response)
                })
            this.attendanceHistory.push(data)
            this.isOn = false
        })
    }
}
</script>
