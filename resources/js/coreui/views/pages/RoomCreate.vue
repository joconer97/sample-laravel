<template>
<div class="container">
    <h1 class="display-3 form-row" style="margin-bottom:50px">Creating room</h1>
     <form @submit.prevent>
         <div class="form-row">
            <div class="form-group col-md-5">
                <label for="inputFirstname">Room name</label>
                <input type="text" class="form-control" id="inputFirstname" placeholder="Room name" v-model="room.roomName">
            </div>

            <div class="form-group col-md-5">
                <label for="inputFirstname">Room Capacity</label>
                <input type="number" class="form-control" id="inputFirstname" placeholder="Room Capacity" v-model="room.roomCapacity">
            </div>

            <div class="form-group col-md-5">
                <label for="inputFirstname">Room Details</label>
                <input type="text" class="form-control" id="inputFirstname" placeholder="Room Capacity" v-model="room.roomDetails">
            </div>

              <div class="form-group col-md-5">
                <label for="inputFirstname">Room Price</label>
                <input type="text" class="form-control" id="inputFirstname" placeholder="Room Price" v-model="room.price">
            </div>
        </div>
        <div class="form-row">
            <h1 class="display-6">Adding bed</h1>
            <select id="bedType" class="form-control" v-model="selectedBed">
                <option value="" disabled selected>Select your option</option>
                <option :value="bedType" v-for="(bedType, index) in bedTypes" :key="index">{{bedType.bed_type}}</option>
            </select>
            <div class="form-group col-md-5">
                <label for="inputFirstname">Bed quantity</label>
                <input type="number" class="form-control" id="inputFirstname" v-model="quantity">
            </div>
            <button class="btn btn-primary" @click="addBed">Add</button>
        </div>

    </form>
    <table class="table">
        <th>Bed Type</th>
        <th>Quantity</th>
        <th>Actions</th>

        <tr v-for="(bed,index) in room.beds" :key="index">
            <td>{{bed.bed_type}}</td>
            <td><input type="number"  v-model="bed.quantity"/></td>
            <td><button @click="deleteBed(index)">Delete</button></td>
        </tr>
    </table>


    <button class="btn btn-primary" @click="createRoom">Save room</button>
</div>
</template>
<script>


export default {
    data(){
        return {
            room : {roomName : 'Sample Room', roomCapacity : 4,roomDetails : 'Sample',price : 500,beds : []},
            bedTypes : [],
            selectedBed : '',
            quantity : 1
        }
    },
    created(){
        this.getBedType()
    },
    methods : {
        createRoom(){
            axios.post('/api/rooms/create',this.room).then(response => {
                if(response.status == 200){
                    // this.$store.getters.rooms.push(response.data)
                    this.$router.push('/room')
                }
            })
        },
        getBedType(){
            axios.get('/api/beds').then(response => {
                this.bedTypes = response.data
            })
        },
        addBed(){
            
            let isRepeated = false
            let addQuantity = 0
            let index = 0
            this.room.beds.some(bed => {
                if(bed.id === this.selectedBed.id){
                    console.log(bed.id + ' ' + this.selectedBed.id)
                    console.log(index)
                    isRepeated = true
                    addQuantity = parseInt(bed.quantity)
                    this.room.beds.splice(index,1)
                    this.selectedBed.quantity = parseInt(this.quantity) + parseInt(addQuantity)
                    this.room.beds.push(this.selectedBed)
                    return true
                }
                index++
            })

            if(!isRepeated){
                this.selectedBed.quantity = parseInt(this.quantity) + parseInt(addQuantity)
                this.room.beds.push(this.selectedBed)
            }

            
        },
        deleteBed(index){
            this.room.beds.splice(index,1)
        }
    }
}
</script>