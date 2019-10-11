<template>
    <div>
        <h1 v-if="!employees.length">No records</h1>
        <table v-else class="table table-hover" style="background : rgb(153, 51, 51) !important;color:white ">
            <thead>
                <th>Employee ID</th>
                <th>Firstname</th>
                <th>Middle Initial</th>
                <th>Lastname</th>
                <th>Position</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <tr v-for="employee in employees" :key="employee.id">
                    <td>{{employee.id}}</td>
                    <td>{{employee.firstname}}</td>
                    <td>{{employee.middleinitial}}</td>
                    <td>{{employee.lastname}}</td>
                    <td>{{employee.position}}</td>
                    <td>
                        <b-list-group horizontal>
                            <b-list-group-item><button type="button" class="btn btn-primary" @click="update(employee.id)">View</button></b-list-group-item>
                            <b-list-group-item><button type="button" class="btn btn-warning">Deactivate</button></b-list-group-item>
                            <b-list-group-item><button type="button" class="btn btn-danger" @click="showMsgBoxTwo(employee.firstname,employee.lastname,employee.id)">Delete</button></b-list-group-item>
                        </b-list-group>
                    </td>
                </tr>
            </tbody>

        </table>
        <div>
 

        
</div>
    </div>
</template>
<script>
export default {
    name    : 'EmployeeList',
    computed: {
        employees () {
            return this.$store.getters.employees
        },
    },
    mounted () {
        // do something after mounting vue instance
        if (this.employees.length)
            return

        this.$store.dispatch('getEmployee');
    },
    created(){
        
    },
    methods : {
        showMsgBoxTwo(firstname,lastname,id){
            this.boxTwo = ''
            this.$bvModal.msgBoxConfirm('Please confirm that you want to ' + firstname + ' ' + lastname, {
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
        
            axios.delete(`/api/auth/users/${id}`).then((response) => {
            console.log(response)
            if(response.status == 200){
                let index = this.employees.findIndex(item => item.id === id)
                this.employees.splice(index,1)
            }

        })

        },
    update(id){
        this.$router.push(`/employee/update/${id}`)
    }
    },
            
}
</script>

<style>
.list-group-item {
background-color: transparent;
border-radius: 0;
color: #fff;
border : none
}
</style>