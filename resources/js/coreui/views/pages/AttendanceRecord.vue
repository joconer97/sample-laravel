<template>
    <div style="margin-bottom : 10px">
        <h1>Camera</h1>
        <div class="row" style="background:red;margin:0 auto">
            <input type="text" placeholder="Employee #" v-model="employeeID">
            <button class="btn btn-primary" @click="switchCamera">Enter</button>
        </div>

        <div class="row" style="background:green;height:600px">
            <div class="col-md-8" style="background:blue">
                <template v-if="isOn">
                    <attendance-camera :employee="employee"></attendance-camera>
                </template>
                <template v-else>
                    <div>
                        Waiting...
                    </div>
                </template>
            </div>

            <div class="col-md-4">
                <table>
                    <tr v-for="history in attendanceHistory" :key="history.id">
                        <td><img :src="`/images/employees/`+history.profile_pic" height="180" width="180" alt=""></td>
                        <td>{{history.firstname}}</td>
                        <td>{{history.lastname}}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <table>
                <tr v-for="employee in employees" :key="employee.id">
                    <td>{{employee.id}}</td>
                    <td>{{employee.firstname}}</td>
                </tr>
            </table>
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

            return this.employees[index]
        },
        loadLabeledImages() {
            var labels = []
            this.employees.forEach(employee => {
                labels.push(employee.id + '-' + employee.firstname)
            })
    

            return Promise.all(
                labels.map(async label => {
                    const descriptions = []
                    for (let i = 1; i <= 4; i++) {
                        try{
                            const img = await faceapi.fetchImage(`https://vuespatest.test/images/label_images/${label}/${i}.jpg`)
                            const detections = await faceapi.detectSingleFace(img).withFaceLandmarks().withFaceDescriptor()
                            descriptions.push(detections.descriptor)
                            }catch(err){
                                console.log(err)
                            }
                                    
                    }

                    return new faceapi.LabeledFaceDescriptors(label, descriptions)
                })
            )
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
        setTimeout(() => {
            this.loadLabeledImages()
        },10000)
        bus.$on('testing', (data) => {
            var today = new Date();
            var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            var attendance = {user_id : data.id,attendance : time}
            console.log(attendance)
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
