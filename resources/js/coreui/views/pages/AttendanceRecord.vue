<template>
    <div style="margin-bottom : 10px;background : rgb(153, 51, 51) !important;color:white"> 
        <h1 class="display-4">RAMASHINTA DAILY TIME RECORDER</h1>
        <hr>
        <br>
        <div class="row" style="margin:0 auto">
            <input type="text" placeholder="Employee #" v-model="employeeID">
            <button class="btn btn-danger" @click="switchCamera">Enter</button>
        </div>

        <center><span><p class="display-4">{{time}}</p></span></center>
        <div class="row" style="height:600px">
            <div class="col-md-8" >
                <h1>Camera</h1>
                <div style="border : 1px solid black">
                    <attendance-camera :employee="employee" v-show="isOn"></attendance-camera>
                </div>
            </div>

            <div class="col-md-4">
                <h1>Previous Attendance</h1>
                <b-card no-body class="overflow-hidden" style="max-width: 540px;padding:5px;margin:5px;color:black" v-for="(history,index) in attendanceHistory" :key="index">
                    <b-row no-gutters>
                    <b-col md="6">
                        <b-card-img :src="`/images/employees/`+history.profile_pic"  height="200" width="90x" class="rounded"></b-card-img>
                    </b-col>
                    <b-col md="6">
                        <b-card-body :title="history.attendance">
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
            employee : null,
            time : ''
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
        setInterval(() => {
                var time = new Date();
                this.time = time.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric',second : 'numeric', hour12: true })
        },100)

        bus.$on('testing', (data) => {
            var today = new Date();
            var time = today.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric',second : 'numeric', hour12: false })
            var attendance = {user_id : data.id,attendance : time,firstname : data.firstname,lastname : data.lastname,profile_pic : data.profile_pic}
            let counter = 0

            if(counter == 0){
                axios.post('/api/attendance',attendance)
                .then(response => {
                    if(response.status == 200){
                        this.attendanceHistory.push(attendance)
                        this.isOn = false
                    }
                })
                counter++
            }
        })
    }
}
</script>
