<template>
    <div>
        <div class="col-md-7">
            <span><b>Room No. or Table No.</b></span><input type="text" class="form-control"/>

            <span><b>Category</b></span>
            <select class="form-control">
                <option value="">Alcohol</option>
                <option value="">Pulutan</option>
                <option value="">Value Meal</option>
            </select>
        </div>
        
        <br>
        <div class="col-md-7">
            <table class="table table-hover table-bordered table-light">
                        <thead>
                            <th>No.</th>
                            <th>Item name</th>
                            <th>Item price</th>
                            <th>Action</th>
                        </thead>

                        <tbody>
                            <tr v-for="(item,index) in items" :key="item.id">
                                <td @>{{index + 1}}</td>
                                <td>{{item.item_name}}</td>
                                <td>{{item.item_price}}</td>
                                <td><button class="btn btn-info" @click="addItem(item,item.id)">Add</button></td>
                            </tr>
                        </tbody>
            </table>
            <div>
            <b-button class="form-control" variant="primary" v-b-modal.modal-1>Show Order</b-button>

            <b-modal id="modal-1" title="BootstrapVue">
                <table class="table table-hover table-bordered table-light">
                        <thead>
                            <th>No.</th>
                            <th>Item name</th>
                            <th>Item price</th>
                            <th>Quantity</th>
                        </thead>

                        <tbody>
                            <tr v-for="(item,index) in orders" :key="item.id">
                                <td @>{{index + 1}}</td>
                                <td>{{item.item_name}}</td>
                                <td>{{item.item_price}}</td>
                                <td>{{item.item_quantity}}</td>
                            </tr>
                        </tbody>
            </table>
            </b-modal>
            </div>
            <br><br>
            <button class="btn btn-danger form-control" @click="sendOrder">Order</button>
        </div>
        
    </div>
</template>
<script>
import swal from 'sweetalert2'

export default {
    data(){
        return {
            orders : []
        }
    },
    computed : {
        items(){
            return this.$store.getters.items
        }
    },
    mounted(){
        if(this.items.length)
            return

        this.$store.dispatch('getItems')
    },
    methods : {
            addItem(item){
                let index = this.checkIfAlreadyPending(item.id)
                let tempItem = {id : item.id,item_name : item.item_name,item_price : item.item_price,item_quantity : 1}
                if(index == -1){
                    this.orders.push(tempItem)
                }else{
                    this.orders[index].item_quantity++
                }
            },
            checkIfAlreadyPending(id){

            return this.orders.findIndex(item => item.id == id)

        },
        sendOrder(){
            this.$swal.fire({
                title: '<strong>Confirmation</strong>',
                icon: 'info',
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText:
                    'Proceed',
                cancelButtonText:
                    'Cancel',
                cancelButtonAriaLabel: 'Cancel'
                }).then(result => {
                    if(result){
                        this.$swal('Guest House','Sucessfully Send Order','success')
                        this.orders = []
                    }else{

                    }
                })
        }
    }
}
</script>