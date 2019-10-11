<template>
    <div>
        <div>
            <b-card style="background:#fdd6d6" text-variant="white" header="Add new item" class="text-center">
                <b-form  @submit.stop.prevent="saveItem">
                    <b-form-row>
                        <label for="category">Category</label>
                        <b-form-select v-model="item.item_category" :state="validationCategory" :options="options" :select-size="1" id="category"></b-form-select>
                        <b-form-invalid-feedback :state="validationCategory">
                            Please select a category
                        </b-form-invalid-feedback>
                        <b-form-valid-feedback :state="validationCategory">
                            Looks Good.
                        </b-form-valid-feedback>
                    </b-form-row>

                    <b-form-row>
                        <label for="name">Item Name</label>
                        <b-input v-model="item.item_name" :state="validationItemName" id="name"></b-input>
                        <b-form-invalid-feedback :state="validationItemName">
                            Please fill the item name
                        </b-form-invalid-feedback>
                        <b-form-valid-feedback :state="validationItemName">
                            Looks Good.
                        </b-form-valid-feedback>
                    </b-form-row>

                    <b-form-row>
                        <label for="quantity">Item Quantity</label>
                        <b-input v-model="item.item_quantity" :state="validationQuantity" id="quantity" type="number"></b-input>
                        <b-form-invalid-feedback :state="validationQuantity">
                            Please fill the item quantity
                        </b-form-invalid-feedback>
                        <b-form-valid-feedback :state="validationQuantity">
                            Looks Good.
                        </b-form-valid-feedback>
                        </b-form-row>
                        
                    <b-button type="submit" variant="primary">Save</b-button>
                </b-form>
            </b-card>
        </div>
        <inventory-list :items="items"></inventory-list>

        <div>
            <b-modal id="bv-modal-addStock" hide-footer>
                <template v-slot:modal-title>
                    Adding Stock
                </template>
                <div class="form-group col-md-5">
                    <label for="inputItemName">Item Name</label>
                    <input type="text" class="form-control" id="inputItemName" v-model="editItem.item_name" disabled>
                </div>
                <div class="form-group col-md-5">
                    <label for="inputItemQuantity">Item Quantity</label>
                    <input class="form-control" type="number" v-model="editItem.item_quantity" disabled>

                    <label for="inputItemQuantity">Additional Quantity</label>
                    <input class="form-control" type="number" v-model="addQuantity">
                </div>

                <b-button class="mt-3 btn btn-primary" block @click="saveNewStock">Save</b-button>
            </b-modal>
        </div>

        <div>
            <b-modal id="bv-modal-editItem" hide-footer>
                <template v-slot:modal-title>
                    Edit item
                </template>
                <div class="form-group col-md-5">
                    <label for="inputItemName">Item Name</label>
                    <input type="text" class="form-control" id="inputItemName" v-model="editItem.item_name" >

                    <label for="inputCategory">Category</label>
                            <select v-model="editItem.item_category" class="form-control">
                                <option>Beverages</option>
                                <option>Junkfoods</option>
                                <option>Foods</option>
                            </select>
                </div>
                <div class="form-group col-md-5">
                    <label for="inputItemQuantity">Item Quantity</label>
                    <input class="form-control" type="number" v-model="editItem.item_quantity" disabled>

                    <label for="inputItemQuantity">Additional Quantity</label>
                    <input class="form-control" type="number" v-model="addQuantity">
                </div>

                <b-button class="mt-3 btn btn-primary" block @click="saveNewStock">Save</b-button>
            </b-modal>
        </div>
    </div>
</template>
<script>
import swal from 'vue-sweetalert2'
import {bus} from '../../main.js'
import InventoryList from './InvetoryList.vue'
export default {
    components : {InventoryList},
    data(){
        return {
            item : {item_name : '',item_quantity : 0,item_category : ''},
            editItem : {},
            addQuantity : 0,
            errorMessage : [],
            options : [
                {value : 'Beverages',text : 'Beverages'},
                {value : 'Junk Food',text : 'Junk Food'}
                ]
        }
    },
    computed : {
        items(){
            return this.$store.getters.items
        }, 
        validationCategory() {
            return this.item.item_category.length != 0
        },
        validationItemName(){
            return this.item.item_name.length > 0
        },
        validationQuantity(){
            return this.item.item_quantity > 0
        }
    },
    methods : {
        saveItem(){
            console.log('hello')
            if(this.validateItem()){
                console.log('item are already existed')
                this.$swal('Ramashita System Message','The item you creating is already existed','error');
                return
            }
            if(!this.validatingNewItem()){
                console.log(this.errorMessage)
                return
            }
            axios.post('/api/items',this.item)
            .then(response => {
                if(response.status == 200){
                    this.$swal('Ramashita System Message','Sucessfully created the item','success');
                    this.items.push(response.data.item)
                }
            })
        },
        saveNewStock(){
            this.editItem.additonal_quantity = this.addQuantity
            this.editItem.choice = 1  
            axios.put('/api/items',this.editItem)
            .then(response => {
                console.log(response.data)
            })
            this.$bvModal.hide('bv-modal-addStock')
        },
        updateItem(){
            this.editItem.addQuantity_quantity = 0
        },
        deleteItem(id){
            axios.delete(`/api/items/${id}`)
            .then(response => {
                if(response.status == 200){
                    let index = this.items.findIndex(item => item.id == id)
                    
                    this.items.splice(index,1)
                }
            })
        },
        validateItem(){
            let isExisted = false
            this.items.some(item => {
                if(item.item_name.toLowerCase() == this.item.item_name.toLowerCase()){
                    isExisted = true
                    return
                }
            })
            return isExisted
        },
        validatingNewItem(){
            let isGood = true

            if(this.item.item_name.length == 0){
                this.errorMessage.push('Please fill the item name')
                isGood = false
            }
            if(this.item.item_category.length == 0){
                this.errorMessage.push('Please fill the item category')
                isGood = false
            }
            if(this.item.item_quantity == 0){
                this.errorMessage.push('Please fill the item quantity')
                isGood = false
            }

            return isGood
        }
    },
    beforeMount(){
        if(this.items.length)
            return
        
        this.$store.dispatch('getItems')
    },
    mounted(){
        bus.$on('stockAdd',(data) => {
            this.$bvModal.show('bv-modal-addStock')
            this.editItem = data
        })

        bus.$on('itemEdit',(data) => {
            this.$bvModal.show('bv-modal-editItem')
            this.editItem = data
        })

        bus.$on('itemDelete',(data) => {
            let message = 'Are you sure you want to delete ' + data.item_name 
            this.$swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.value) {
                    this.deleteItem(data.id)
                    this.$swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                    )
                }
})
        })
    }
}
</script>