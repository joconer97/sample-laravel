<template>
    <div class="container">
        <div class="row">
            <form @submit.prevent="saveLocation">
                    <div class="form-row">
                        <label for="">Location</label>
                        <input type="text" v-model="location.location" class="form-control"/> 
                        <button class="btn btn-primary">Add</button>
                    </div>
            </form>
        </div>
        <div class="row">
            <form @submit.prevent="saveActivity">
                <div class="form-row">
                    <label for="">Activity name</label>
                    <input type="text" placeholder="Activity" v-model="activity.name" class="form-control"/>
                </div>

                <div class="form-row">
                    <label for="">Activity Location</label>
                    <select class="form-control" v-model="activity.location_id">
                        <option v-for="location in locations" :key="location.id" :value="location.id">{{location.location}}</option>
                    </select>
                </div>

                <div class="form-row">
                    <label>Position</label>
                    <select class="form-control" v-model="activity.position">
                        <option>Admin</option>
                        <option>Manager</option>
                        <option>Housewife</option>
                        <option>Maintenance</option>
                        <option>Timekeeper</option>
                        <option>Chef</option>
                    </select>
                </div>

                <div class="form-row">
                    <label for="">Activity duration</label>
                    <input type="number" placeholder="Activity duration (mins)" v-model="activity.duration" class="form-control"/>
                </div>
                

                <div class="form-row">
                    <button class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>

        <div class="row">
            <table class="table table-border">
                <thead>
                    <th>Activity name</th>
                    <th>Locations</th>
                    <th>Positions</th>
                </thead>
                <tbody>
                    <tr v-for="(task,index) in tasks" :key="index">
                        <td>{{task.name}}</td>
                        <td>{{task.location.location}}</td>
                        <td>{{task.position}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            location : {location : ''},
            activity : {
                name : '',
                location_id : '',
                position : '',
                duration : ''
            }
        }
    },
    computed : {
        locations(){
            return this.$store.getters.locations
        },
        tasks(){
            return this.$store.getters.tasks
        }
    },
    mounted(){
        this.getLocations()
        this.getTasks()
    },
    methods : {
        getLocations(){
            if(this.locations.length)
                return
            
            this.$store.dispatch('getLocations')
        },
        getTasks(){
            if(this.tasks.length)
                return
            
            this.$store.dispatch('getTasks')
        },
        saveLocation(){
            console.log(this.location)
            axios.post('/api/location',this.location).then(response => {
                this.locations.push(response.data.location)
            })
        },
        saveActivity(){
            axios.post('/api/task',this.activity).then(response => {
                console.log(response.data.activity)
                this.tasks.push(response.data.activity)
                this.activity.name = ''
                this.activity.location = ''
                this.activity.position = ''
                this.activity.duration = ''
            })
        }
    }
}
</script>