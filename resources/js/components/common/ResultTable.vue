<template>
  <div id="mytable" class="schedule-tb" style="margin-left:-15px;margin-top:16px;">
    <tr>
      <th>Tên học phần</th>
      <th>Mã HP</th>
      <th>Mã lớp</th>
      <th>Điểm</th>
      <th>TC</th>
    </tr>
    <tr v-for="(row, key) in studyList" :key="key">
      <td id="mytable--wide">{{courseList[key].course_name}}</td>
      <td id="mytable--narrow">{{courseList[key].course_id}}</td>
      <td id="mytable--narrow">{{studyList[key].study_classroomid}}</td>
      <td id="mytable--narrow">{{studyList[key].study_result}}</td>
      <td id="mytable--narrow">{{courseList[key].course_credit}}</td>
    </tr>
    <div style="display: block; height: 20px; width: 10px"></div>
    <tr>
      <th>Học kì</th>
      <th>Điểm tổng kết</th>
      <th>Xếp loại</th>
    </tr>
    <tr>
      <td id="mytable--narrow">2018</td>
      <td id="mytable--medium">{{finalResult}}</td>
      <td id="mytable--medium">A</td>
    </tr>
  </div>
</template>

<script>
export default {
  props: ['studyList', 'courseList'],

  created() {
      var finalResult_a = 0;
      var finalResult_b = 0;
      for (var i = 0; i < this.studyList.length; ++i) {
        finalResult_a += this.studyList[i].study_result*this.courseList[i].course_credit;
        finalResult_b += this.courseList[i].course_credit;
      }
      this.finalResult = finalResult_a/finalResult_b

  },

  data() {
    return {
      finalResult: 0,
    }
  }
}
</script>

<style lang="scss" scoped>
</style>
