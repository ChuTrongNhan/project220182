<template>
  <div id="mytable" class="schedule-tb" style="margin:auto">
    <tr>
      <th>MSSV</th>
      <th>Điểm</th>
      <th>Cập nhập điểm</th>
    </tr>
    <tr v-for="(row, key) in studyList" :key="key">
      <td id="mytable--wide">{{studyList[key].study_studentid}}</td>
      <td id="mytable--wide">{{studyList[key].study_result}}</td>
      <td id="mytable--wide">
        <input v-model="updateResult[key]">
      </td>
    </tr>
    <div v-on:click="update()" class="button button--primary"
        style="position: absolute;bottom: 40px;left: 0;right: 0;margin: auto;">
            Cập nhập
    </div>
  </div>
</template>

<script>
import { async } from 'q';
export default {
  props: ['studyList'],

  methods: {
    update: async function() {
      for (var i = 0; i <= this.studyList.length; ++i) {
        if (this.updateResult[i] == null) {this.updateResult.push('');}
        if ((i<this.studyList.length) && (this.updateResult[i] != this.studyList[i].study_result) && (this.updateResult[i] != '')) {
          try {
            this.studyList[i].study_result = this.updateResult[i];
            let response = await axios.put("/studies/" + this.studyList[i].study_id, {study_result:  this.updateResult[i]});
            this.updateResult[i] = '';
          } catch (e) {
            console.log(e);
          }
        } else this.updateResult[i] = '';
      }
    },
  },

  data() {
    return {
      updateResult:[],
    }
  }
}
</script>

<style lang="scss" scoped>
input {
  font-size: 14px;
}
th, tr {
  text-align: center !important;
}
</style>
