<template>
  <div>
    <div class="content">
      <router-view />
    </div>
  </div>
</template>

<script>
// import Header from '././views/pages/Header.vue';
import Header from './views/pages/Header'
export default
{
  name      : 'App',
  components: { Header },
}
</script>
