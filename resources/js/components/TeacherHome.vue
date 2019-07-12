<template>
  <div class="row" style="padding-top: 10vh">

    <!-- Lich day -->
    <div class="col-md-4" style="padding-left: 11vw;position: relative">
      <transition name="slide-fade">
      <div v-if="showClassListPage" class="home-tag home-schedule-tag">
        <div class="row" style="position:relative">
          <div class="table-title-h1">
            Lịch dạy
          </div>
          <div v-on:click="closeClassListPage()" class="round-button round-button--negative"
                style="position:absolute;right:0;">
            <img src="./common/assets/close.svg" alt="">
          </div>
        </div>
        <div class="row">
          <div class="table-title-h2">
            Giáo viên <a class="txt-primary-color">{{currentteacherid}}</a>
          </div>
        </div>
        <loading v-show="loading"></loading>
        <div v-if="!loading" id="mytable" class="schedule-tb" style="margin-left:-15px;margin-top:16px;">
            <tr>
              <th>Mã lớp</th>
              <th>Mã HP</th>
              <th>Tên HP</th>
            </tr>
            <tr v-for="(row, key) in userClassList" :key="key" class="class-list-row" v-on:click="openStudentList(key)">
              <td id="mytable--narrow">{{userClassList[key].classroom_id}}</td>
              <td id="mytable--narrow">{{userCourseList[key].course_id}}</td>
              <td id="mytable--wide">{{userCourseList[key].course_name}}</td>
            </tr>
        </div>
      </div></transition>

      <transition name="slide-fade">
      <div v-show="showScheduleTag" class="home-tag">
        <div class="row center h3" style="margin-top:25px">
          Nhập mã giáo viên cần tra cứu
        </div>
        <div class="row center" style="margin-top:25px">
          <input v-model="searchID">
        </div>
        <div class="warning"><a v-show="warning">{{warning}}</a></div>
        <div class="row center">
          <div v-on:click="openSchedulePage()" class="button button--primary" style="margin:auto">
            Tìm kiếm</div>
        </div>
        <div class="vector-left">
          <img src="./common/assets/vector1.svg" alt="">
        </div>
        <div class="row center h1" style="position:absolute; bottom:46px;left: 60px;color:#ffffff">
          Lịch dạy
        </div>
      </div></transition>
    </div>

    <div class="col-md-4" style="position: relative">
      <transition name="slide-fade">
      <div v-if="showSchedulePage" class="home-tag home-schedule-tag">
        <div class="row" style="position:relative">
          <div class="table-title-h1">
            Lịch dạy
          </div>
          <div v-on:click="closeSchedulePage()" class="round-button round-button--negative"
                style="position:absolute;right:0">
            <img src="./common/assets/close.svg" alt="">
          </div>
        </div>
        <div class="row">
          <div class="table-title-h2">
            Giáo viên <a class="txt-primary-color">{{searchIdFound}}</a>
          </div>
        </div>
        <loading v-show="loading"></loading>
        <div v-if="!loading">
            <schedule-table :id="searchID" :classList="classList" :courseList="courseList"></schedule-table>
        </div>
      </div></transition>

      <!-- User -->
      <transition name="slide-fade">
      <div v-if="showUserTag" class="home-tag">
        <div class="avatar"></div>
        <div class="row h3 center" style="margin-top:15px">Giáo viên</div>
        <div class="row h1 center" style="margin:5px 0 0 0;">{{currentteachername}}</div>
        <div class="row center">
          <div class="button button--primary" style="position:absolute;margin:auto;bottom:96px"
            v-on:click="openInfoPage()">
            Xem thông tin tài khoản</div>
        </div>
        <div class="row center">
          <div class="text-button" v-on:click="logOut()" style="position:absolute;margin:auto;bottom:36px">
            Log out
          </div>
        </div>
      </div></transition>
    </div>


    <!-- Xem danh sach lop day -->
    <div class="col-md-4" style="padding-right: 11vw">
      <transition name="slide-fade">
      <div v-show="showClassListTag" class="home-tag">
        <div class="vector-right">
          <img src="./common/assets/vector2.svg" alt="">
        </div>
        <div class="row h1" style="margin-left: 5px;position:absolute;padding-right:50px;bottom:169px;text-align:left">
          Xem <br /> danh sách <br /> lớp dạy
        </div>
        <div v-on:click="openClassListPage()" class="row round-button--result-button" style="margin-left: 5px">
          <a class="round-button round-button--primary" style="padding-left:2px">
              <img src="./common/assets/arrow.svg" alt="">
          </a>
          <div class="round-button__expand h3">
              Danh sách lớp dạy
          </div>
        </div>
      </div></transition>
    </div>

    <div class="popup-full">
      <transition name="slide-fade">
        <div class="info-page" v-show="showInfoPage">
          <loading v-show="loading"></loading>
          <div v-on:click="closeInfoPage()" class="round-button round-button--negative"
                style="position: absolute;right: 35px;top: 20px;">
            <img src="./common/assets/close.svg" alt="">
          </div>
          <div v-if="!loading">
            <info-page-teacher :user="user" :teacher="teacher"></info-page-teacher>
          </div>
        </div>
      </transition>
    </div>

    <div class="popup-full">
      <transition name="slide-fade">
        <div class="info-page" v-show="showClassListPopup">
          <loading v-show="loading"></loading>
          <div v-on:click="closeStudentListPage()" class="round-button round-button--negative"
                style="position: absolute;right: 35px;top: 20px;">
            <img src="./common/assets/close.svg" alt="">
          </div>
          <div v-if="!loading" style="padding-top:25px;">
            <class-list-table :studyList="studyList"></class-list-table>
          </div>
        </div>
      </transition>
    </div>

  </div>
</template>

<script>
import ScheduleTable from "./common/ScheduleTable.vue";
import ClassListTable from "./common/ClassListTable.vue";
import InfoPageTeacher from "./common/InfoPageTeacher.vue";
import Loading from "./common/Loading.vue";

export default {
  props: ['currentteacherid', 'currentteachername'],
  components: {
    'schedule-table': ScheduleTable,
    'class-list-table': ClassListTable,
    'info-page-teacher': InfoPageTeacher,
    'loading': Loading,
  },

  methods: {
    openSchedulePage: async function() {
      if (this.searchID == '') {
        this.warning = "Chưa nhập mã giáo viên";
        return;
      }
      this.showUserTag = false;
      this.showClassListTag = false;
      this.showSchedulePage = true;
      if (this.searchID == this.searchIdFound) return;
      this.searchIdFound = this.searchID;
      this.warning = '';
      this.classList = [];
      this.courseList = [];
      this.loading = true;
      try {
        let responseTeacher = await axios.get('/teachers/' + this.searchID);
        if (responseTeacher.data.length == 0) {
          this.warning = 'Không tìm thấy giáo viên mã số ' + this.searchID;
          this.loading = false;
          return;
        }
        let responseClass = await axios.get('/classes/');

        for (var i = 0; i < responseClass.data.length; ++i)
          if (responseClass.data[i].classroom_teacherid == this.searchID){
              this.classList.push(responseClass.data[i]);
              let responseCourse = await axios.get('/courses/' + responseClass.data[i].classroom_courseid);
              this.courseList.push(responseCourse.data[0]);
          }
      } catch (e) {
        console.log(e);
      }
      this.loading = false;
    },

    closeSchedulePage() {
      this.showUserTag = true;
      this.showClassListTag = true;
      this.showSchedulePage = false;
    },

    openInfoPage: async function() {
      this.showUserTag = false;
      this.showClassListTag = false;
      this.showScheduleTag = false;
      this.showInfoPage = true;
      if (this.teacher.teacher_id != 'null') return;
      this.loading = true;
      try {
        let responseTeacher = await axios.get('/teachers/' + this.currentteacherid);
        this.teacher = responseTeacher.data[0];
        let responseUser = await axios.get('/users/' + this.currentteacherid);
        this.user = responseUser.data[0];
        this.loading = false;
      } catch (e) {
        console.log(e);
      }
    },

    closeInfoPage() {
      this.showInfoPage = false;
      this.showUserTag = true;
      this.showClassListTag = true;
      this.showScheduleTag = true;
    },

    openClassListPage: async function() {
      this.showUserTag = false;
      this.showScheduleTag = false;
      this.showClassListPage = true;
      if (this.userClassList.length > 0) return;
      this.userClassList = [];
      this.userCourseList = [];
      this.loading = true;
      try {
        let responseClass = await axios.get('/classes/');
        for (var i = 0; i < responseClass.data.length; ++i)
          if (responseClass.data[i].classroom_teacherid == this.currentteacherid){
              this.userClassList.push(responseClass.data[i]);
              let responseCourse = await axios.get('/courses/' + responseClass.data[i].classroom_courseid);
              this.userCourseList.push(responseCourse.data[0]);
          }
      } catch (e) {
        console.log(e);
      }
      this.loading = false;
    },

    closeClassListPage() {
      this.showUserTag = true;
      this.showScheduleTag = true;
      this.showClassListPage = false;
    },

    openStudentList: async function(key) {
      this.showClassListPopup = true;
      this.showClassListTag = false;
      this.showClassListPage = false;
      this.loading = true;
      this.studyList = [];
      if (this.fullStudyList.length > 0) {
        for (var i = 0; i < this.fullStudyList.length; ++i) {
          if (this.fullStudyList[i].study_classroomid == this.userClassList[key].classroom_id) {
            this.studyList.push(this.fullStudyList[i]);
          }
        }
      }
      if (this.fullStudyList.length == 0)
      try {
        let response = await axios.get('/studies/');
        this.fullStudyList = response.data;
        for (var i = 0; i < response.data.length; ++i) {
          if (response.data[i].study_classroomid == this.userClassList[key].classroom_id) {
            this.studyList.push(response.data[i]);
          }
        }
      } catch (e) {
        console.log(e);
      }
      this.loading = false;
    },

    closeStudentListPage() {
      this.showClassListPopup = false;
      this.showClassListTag = true;
      this.showClassListPage = true;
    },

    logOut() {
        window.location.assign('http://huststudentresult/');
    }

  },

  data() {
    return {
      showUserTag: true,
      showClassListTag: true,
      showScheduleTag: true,

      showSchedulePage: false,
      showClassListPage: false,
      showInfoPage: false,
      showClassListPopup: false,

      searchID: '',
      searchIdFound: '',
      loading: false,
      warning: '',

      teacher: {
        teacher_id: 'null',
      },

      user: {
        id: 'null',
      },

      classList: [],
      courseList:[],

      userClassList:[],
      userCourseList:[],

      fullStudyList: [],
      studyList:[],
    }
  }
}
</script>

<style lang="scss" scoped>
.class-list-row {
  cursor: pointer;
}
.class-list-row:hover {
  text-decoration: underline;
}
</style>
