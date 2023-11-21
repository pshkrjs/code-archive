<script setup>
import { ref } from 'vue'
const visible = ref(false);
const showModal = () => {
  visible.value = true;
};
const handleOk = e => {
  visible.value = false;
}
</script>

<template>
  <div class="container">
    <a-row>
      <a-col :span="24">
        <h1>Dashboard</h1>
      </a-col>
    </a-row>
    <hr>
    <a-row>
      <a-col :span="2">
        <a-button type="primary" shape="round" @click="showModal">
          Add Item
        </a-button>
        <a-modal v-model:visible="visible" title="Basic Modal" @ok="handleOk">
          <p>Some contents...</p>
          <p>Some contents...</p>
          <p>Some contents...</p>
        </a-modal>
      </a-col>
    </a-row>
  </div>
</template>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  margin: 1rem;
}
</style>
