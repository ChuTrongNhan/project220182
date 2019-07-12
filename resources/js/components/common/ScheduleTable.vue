<template>
  <div id="mytable" class="schedule-tb" style="margin-left:-15px;margin-top:16px;">
    <tr>
      <th>Thời gian</th>
      <th>Phòng học</th>
      <th>Mã lóp</th>
      <th>Mã HP</th>
      <th>Tên học phần</th>
    </tr>
    <tr v-for="(row, key) in classList" :key="key">
      <td id="mytable--medium">{{classTime(key)}}</td>
      <td id="mytable--narrow">{{classList[key].classroom_room}}</td>
      <td id="mytable--narrow">{{classList[key].classroom_id}}</td>
      <td id="mytable--narrow">{{classList[key].classroom_courseid}}</td>
      <td id="mytable--wide">{{courseList[key].course_name}}</td>
    </tr>
  </div>
</template>

<script>
export default {
  props: ['id', 'classList', 'courseList'],

  methods: {
    classTime(i) {
        let x = this.classList[i].classroom_time;
        let day = (x - x%100)/100;
        let start = (x%100 - x%10)/10;
        let end = x%10;
        return 'Thứ ' + day + ' tiết ' + start + ' đến ' + end;
      }
  },

  data() {
    return {
    }
  }
}
</script>

<style lang="scss" scoped>
</style>
