<template>
<div>
    <h1>Creating new employee</h1>

    <img v-bind:src="link" height="280" width="280" alt="">
    <input style="display:block" type="file" class="btn btn-primary" @change="imageChange" multiple="multiple" width="250" accept=".jpg">
    <form @submit.prevent="createEmployee">
         <div class="form-row">
            <div class="form-group col-md-5">
            <label for="inputFirstname">Firstname</label>
            <input type="text" class="form-control" id="inputFirstname" placeholder="Firstname" v-model="employee.firstname">
            </div>
            <div class="form-group col-md-2">
            <label for="inputMiddleinitial">Middle Initial</label>
            <input type="text" class="form-control" id="inputMiddleinitial" placeholder="Middle Initial" v-model="employee.middleinitial">
            </div>
            <div class="form-group col-md-5">
            <label for="inputLastname">Lastname</label>
            <input type="text" class="form-control" id="inputLastname" placeholder="Lastname" v-model="employee.lastname">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
            <label for="inputEmail4">Email</label>
            <input type="email" class="form-control" id="inputEmail4" placeholder="Email" v-model="employee.email">
            </div>
            <div class="form-group col-md-6">
            <label for="inputPassword4">Password</label>
            <input type="password" class="form-control" id="inputPassword4" placeholder="Password" v-model="employee.password">
            </div>
        </div>
        <div class="form-group">
            <label for="inputAddress">Address</label>
            <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" v-model="employee.address">
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
            <label for="inputCity">Landmark</label>
            <input type="text" class="form-control" id="inputCity" v-model="employee.landmark">
            </div>
            <div class="form-group col-md-4">
            <label for="inputState">City</label>
            <select id="inputState" class="form-control" v-model="employee.city">
                <option value="" disabled selected>Select your city</option>
                <option value="city.name" v-for="(city, index) in cities" :key="index">{{city.name}}</option>
            </select>
            </div>
            <div class="form-group col-md-2">
            <label for="inputZip">Zip</label>
            <input type="text" class="form-control" id="inputZip" v-model="employee.zip">
            </div>
        </div>
        <div class="form-row">
             <select id="inputState" class="form-control" v-model="employee.position">
                <option>Admin</option>
                <option>Manager</option>
                <option>Housewife</option>
                <option>Maintenance</option>
                <option>Chef</option>
            </select>
        </div>

        <div style="margin-bottom : 30px">
            <h1>Working Schedule</h1>
            <div class="form-group col-md-2">
                <label for="inputStart">Start Time</label>
                <input type="time" value="08:00" v-model="employee.start_time">
            </div>

            <div class="form-group col-md-2">
                <label for="inputStart">End Time</label>
                <input type="time" value="08:00" v-model="employee.end_time">
            </div>

            <!-- <div class="form-group col-md-2">
                <ul>
                    <li><label><input name="Checkbox1" type="checkbox" value="Sunday">Sunday</label></li>
                    <li><label for=""><input type="checkbox"  id="" value="Monday">Monday</label></li>
                    <li><label><input name="Checkbox1" type="checkbox" value="Tuesday">Tuesday</label></li>
                    <li><label for=""><input type="checkbox"  id="" value="Wednesday">Wednesday</label></li>
                    <li><label><input name="Checkbox1" type="checkbox" value="Thursday">Thursday</label></li>
                    <li><label for=""><input type="checkbox"  id="" value="Friday">Friday</label></li>
                    <li><label><input name="Checkbox1" type="checkbox" value="Saturday">Saturay</label></li>
                </ul>
                
            </div> -->
            
        </div>

        <div style="margin-bottom : 30px">
            <h1>Facial Recognition Model</h1>
            <div class="active-purple-3 active-purple-4 mb-4" style="height : 300px">
                <img v-for="(image,index) in employee.images" :key="index" :src="image" height="250px" width="250px">
            </div>
            <input type="file" class="form-control btn btn-primary" @change="uploadFacialModel" multiple="multiple" accept=".jpg"> 
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>



</div>
</template>
<script>
import {cities} from '../../helpers/cities.js'
export default {
    data(){
        return{
            link : 'http://maestroselectronics.com/wp-content/uploads/bfi_thumb/blank-user-355ba8nijgtrgca9vdzuv4.jpg',
            employee : {
                firstname : 'arnel',
                middleinitial : 'o',
                lastname : 'payongayong',
                position : 'Admin',
                email : 'arnel@google.com',
                password : '123456789',
                address : 'Block 2 Lot 4',
                city : '',
                landmark : 'School',
                zip : '4000',
                profile_pic : '',
                images : [],
                start_time : '08:00',
                end_time : '08:00',
                },
        }
    },
    computed : {
    cities(){
            return cities()
        }
    },
    methods : {
        createEmployee(){
            axios.post('/api/auth/register',this.employee).then(response =>{
                if (response.status == 200) {
                    this.$store.getters.employees.push(response.data.employee)
                    this.$router.push('/employee')
                }
            })
        },
       imageChange(e){
            var fileReader = new FileReader();

            fileReader.readAsDataURL(e.target.files[0]);

            fileReader.onload = (e) =>{
                this.link = e.target.result
                this.employee.profile_pic = e.target.result
                }
            },
        uploadFacialModel(e){
            

            
            var files = e.target.files

            Array.from(files).forEach(file => {
                    var fileReader = new FileReader()

                    fileReader.readAsDataURL(file)

                    fileReader.onload = (e) =>{
                        this.employee.images.push(e.target.result)
                        }
                    });

        },
    }
}
</script>
