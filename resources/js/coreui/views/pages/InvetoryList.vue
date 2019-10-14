<template>
    <table class="table table-hover" style="background : rgb(153, 51, 51) !important;color:white">
        <thead>
            <th scope="col">#</th>
            <th scope="col">Item name</th>
            <th scope="col">Item price</th>
            <th scope="col">Item Quantity</th>
            <th scope="col">Item Category</th>
            <th scope="col">Action</th>
        </thead>

        <tbody>
            <tr v-for="(item,index) in items" :key="item.id">
                <td>{{index + 1}}</td>
                <td>{{item.item_name}}</td>
                <td>{{item.item_price}}</td>
                <td>{{item.item_quantity}}</td>
                <td>{{item.item_category}}</td>
                <td>
                    <b-list-group horizontal="md">
                        <b-list-group-item  variant="danger"><button class="btn btn-primary" @click="addStock(item)">Stock in</button></b-list-group-item>
                        <b-list-group-item  variant="danger"><button class="btn btn-primary" @click="stockOut(item)">Stock out</button></b-list-group-item>
                        <b-list-group-item  variant="danger"><button class="btn btn-warning" @click="editItem(item)">Edit</button></b-list-group-item>
                        <b-list-group-item  variant="danger"><button class="btn btn-danger" @click="deleteItem(item)">Delete</button></b-list-group-item>
                    </b-list-group>
                </td>
            </tr>
        </tbody>
    </table>
</template>
<script>
import {bus} from '../../main.js'
export default {
    name : 'InvetoryList',
    props : ['items'],
    methods : {
        addStock(item){
            bus.$emit('stockAdd',item)
        },
        editItem(item){
            bus.$emit('itemEdit',item)
        },
        deleteItem(item){
            bus.$emit('itemDelete',item)
        },
        stockOut(item){
            bus.$emit('stockingOut',item)
        }
    }

}
</script>