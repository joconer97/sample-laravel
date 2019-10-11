<template>
<div>
    <h1>Room Lists</h1>
    <table class="table table-hover" style="rgb(153, 51, 51) !important">
        <thead>
            <th>Room name</th>
            <th>Room Details</th>
            <th>Room Price</th>
            <th>Room Capacity</th>
            <th>Actions</th>
        </thead>
        <tbody>
            <tr v-for="room in rooms" :key="room.id">
                <td>{{room.room_name}}</td>
                <td>{{room.room_details}}</td>
                <td>{{room.price}}</td>
                <td>{{room.capacity}}</td>
                <td> 
                    <b-list-group horizontal>
                        <b-list-group-item><button type="button" class="btn btn-primary" @click="update(room.id)">Update</button></b-list-group-item>
                        <b-list-group-item><button type="button" class="btn btn-warning">Deactivate</button></b-list-group-item>
                        <b-list-group-item><button type="button" class="btn btn-danger" @click="showMsgBoxTwo(room.room_name,room.id)">Delete</button></b-list-group-item>
                    </b-list-group></td>
            </tr>
        </tbody>
    </table>
</div>
</template>
<script>
export default {
    computed : {
        rooms(){
            return this.$store.getters.rooms
        }
    },
    mounted(){
        if (this.rooms.length)
            return

        this.$store.dispatch('getRooms');
    },
    methods : {
        showMsgBoxTwo(name,id){
            this.boxTwo = ''
            this.$bvModal.msgBoxConfirm('Please confirm that you want to delete ' + name, {
            title: 'Please Confirm',
            size: 'sm',
            buttonSize: 'sm',
            okVariant: 'danger',
            okTitle: 'YES',
            cancelTitle: 'NO',
            footerClass: 'p-2',
            hideHeaderClose: false,
            centered: true
            })
            .then(value => {
                //value is true of false
                if(!value){
                    return
                }
                this.remove(id)
            })
            .catch(err => {
                // An error occurred
            })
        },
    remove(id){
        
            axios.delete(`/api/rooms/${id}`).then((response) => {
            if(response.status == 200){
                let index = this.rooms.findIndex(item => item.id === id)
                this.rooms.splice(index,1)
            }

        })

        },
    update(id){
        this.$router.push(`/room/update/${id}`)
    }
    },
}
</script>