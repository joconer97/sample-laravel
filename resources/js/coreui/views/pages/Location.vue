<template>
    <form @submit.prevent="saveLocation">
        <div class="form-row">
            <label for="">Location</label>
            <input type="text" v-model="location"/>
        </div>
    </form>
</template>
<script>
export default {
    data(){
        return{
            location : ''
        }
    },
    methods : {
        saveLocation(){

        }
    }
}
</script>