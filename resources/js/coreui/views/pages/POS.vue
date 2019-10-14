<template>
    <div style="background : rgb(153, 51, 51) !important;color:white;height:900px"> 
        <div class="container">
            <div class="row">
                <h1 class="display-3" style="margin-left:7px">POINT OF SALE SYSTEM</h1>
            </div>

            <div class="row">
                <form @submit.prevent="searchItem">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search item name..." style="margin-left:15px">
                        <span class="input-group-btn">
                                <button class="btn btn-primary" type="button">Search</button>
                        </span>
                    </div>
                </form>
            </div>

            <br>

            <div class="row">
                <div class="col-md-7">
                    <h1>Items</h1>
                    <table class="table table-hover table-bordered table-light">
                        <thead>
                            <th>No.</th>
                            <th>Item name</th>
                            <th>Item price</th>
                            <th>Item Quantity</th>
                            <th>Item Category</th>
                            <th>Action</th>
                        </thead>

                        <tbody>
                            <tr v-for="(item,index) in items" :key="item.id">
                                <td>{{index + 1}}</td>
                                <td>{{item.item_name}}</td>
                                <td>{{item.item_price}}</td>
                                <td>{{item.item_quantity}}</td>
                                <td>{{item.item_category}}</td>
                                <td><button class="btn btn-info" @click="addItem(item,item.id)">Add</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md">
                    <h1>Pending</h1>
                    <table class="table table-hover table-bordered table-light">
                        <thead>
                            <th>No.</th>
                            <th>Item name</th>
                            <th>Item price</th>
                            <th>Item Quantity</th>
                            <th>Action</th>
                        </thead>

                        <tbody>
                            <tr v-for="(item,index) in itemPending" :key="item.id">
                                <td>{{index + 1}}</td>
                                <td>{{item.item_name}}</td>
                                <td>{{item.item_price}}</td>
                                <td>{{item.item_quantity}}</td>
                                <td><button class="btn btn-warning" @click="reduceItem(item)">-</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <label for="">Total Price :</label>
                    <input type="decimal" class="form-control" disabled v-model="totalPrice">
                    <label for="">Payment :</label>
                    <input type="decimal" class="form-control" v-model="payMoney">
                    <button class="btn btn-primary" @click="payment">Buy</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import swal from 'sweetalert2'

export default{
    data(){
        return{
            itemPending : [],
            totalPrice : 0.0,
            payMoney : 0.0
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

            // console.log(this.validateItem(item.id))
            if(this.validateItem(item.id)){
                if(index == -1){
                    console.log(item.item_price)
                    this.totalPrice += parseFloat(item.item_price)
                    this.itemPending.push(tempItem)
                }
                else{
                    this.totalPrice += parseFloat(item.item_price)
                    this.itemPending[index].item_quantity++
                }
                    
            }
        },
        checkIfAlreadyPending(id){
            return this.itemPending.findIndex(item => item.id == id)

        },
        validateItem(id){

            if(this.itemPending.length == 0)
                return true

            let index1 = this.items.findIndex(item => item.id == id)
            let index2 = this.itemPending.findIndex(item => item.id == id)

            if(index2 == -1) 
                return true
        
            if(this.items[index1].item_quantity > this.itemPending[index2].item_quantity)
                return true
            
            return false
        },
        reduceItem(item,id){
            item.item_quantity--
            if(item.item_quantity == 0){
                let index = this.itemPending.findIndex(item => item.id == id)
                this.itemPending.splice(index,1)
            }
        },
        payment(){
            if(this.payMoney < this.totalPrice){
                this.$swal('Ramashinta System Message','Failed Transaction','warning')
            }
            else{
                this.$swal('Ramashinta System Message','Sucessful Transaction!','success')
                this.itemPending.forEach(item => {

                    let id = item.id
                    let index = this.items.findIndex(item => item.id == id)

                    this.items[index].item_quantity -= item.item_quantity
                    
                    console.log(this.items[index])

                    axios.put('/api/items',this.items[index]).then(response => {
                        console.log(response)
                    })
                    
                    let temp =  {item_id : this.items[index].id, quantity : item.item_quantity, status : 1}
                    axios.post('/api/inventory',temp).then(response => {
                        console.log(response)
                    })
                })
                this.itemPending = []
                this.totalPrice = 0.0
                this.payMoney = 0.0
            }
        }
    }
}
</script>