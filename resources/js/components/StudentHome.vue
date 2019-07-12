<template>
  <div class="row" style="padding-top: 10vh">

    <!-- Thoi khoa bieu -->
    <div class="col-md-4" style="padding-left: 11vw;position: relative">
      <transition name="slide-fade">
      <div v-if="showResultPage" class="home-tag home-schedule-tag">
        <div class="row" style="position:relative">
          <div class="table-title-h1">
            Kết quả học tập
          </div>
          <div v-on:click="closeResultPage" class="round-button round-button--negative"
                style="position:absolute;right:0">
            <img src="./common/assets/close.svg" alt="">
          </div>
        </div>
        <div class="row">
          <div class="table-title-h2">
            Sinh viên <a class="txt-primary-color">{{currentstudentid}}</a>
          </div>
        </div>
        <loading v-show="loading"></loading>
        <div v-if="!loading">
            <result-table :studyList="userStudyList" :courseList="userCourseList"></result-table>
        </div>
      </div></transition>

      <transition name="slide-fade">
      <div v-show="showScheduleTag" class="home-tag">
        <div class="row center h3" style="margin-top:25px">
          Nhập MSSV cần tra cứu
        </div>
        <div class="row center" style="margin-top:25px">
          <input v-model="searchID">
        </div>
        <div class="warning"><a v-show="warning">{{warning}}</a></div>
        <div class="row center">
          <div v-on:click="openSchedulePage()" class="button button--primary"style="margin:auto">
            Tìm kiếm</div>
        </div>
        <div class="vector-left">
          <img src="./common/assets/vector1.svg" alt="">
        </div>
        <div class="row center h1" style="position:absolute; bottom:46px;color:#ffffff">
          Thời khóa biểu
        </div>
      </div></transition>
    </div>

    <div class="col-md-4" style="position: relative">
      <transition name="slide-fade">
      <div v-if="showSchedulePage" class="home-tag home-schedule-tag">
        <div class="row" style="position:relative">
          <div class="table-title-h1">
            Thời khóa biểu
          </div>
          <div v-on:click="closeSchedulePage" class="round-button round-button--negative"
                style="position:absolute;right:0">
            <img src="./common/assets/close.svg" alt="">
          </div>
        </div>
        <div class="row">
          <div class="table-title-h2">
            Sinh viên <a class="txt-primary-color">{{searchIdFound}}</a>
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
        <div class="row h3 center" style="margin-top:15px">Xin chào</div>
        <div class="row h1 center" style="margin:5px 0 0 0;">{{currentstudentname}}</div>
        <div class="row center">
          <div class="button button--primary" style="position:absolute;margin:auto;bottom:96px"
            v-on:click="openInfoPage">
            Xem thông tin tài khoản</div>
        </div>
        <div class="row center">
          <div class="text-button" v-on:click="logOut()" style="position:absolute;margin:auto;bottom:36px">
            Log out
          </div>
        </div>
      </div></transition>
    </div>


    <!-- Xem ket qua hoc tap -->
    <div class="col-md-4" style="padding-right: 11vw">
      <transition name="slide-fade">
      <div v-show="showResultTag" class="home-tag">
        <div class="vector-right">
          <img src="./common/assets/vector2.svg" alt="">
        </div>
        <div class="row h1" style="margin-left: 5px;position:absolute;padding-right:50px;bottom:169px;text-align:left">
          Xem <br /> kết quả <br /> học tập
        </div>
        <div v-on:click="openResultPage" class="row round-button--result-button" style="margin-left: 5px">
          <a class="round-button round-button--primary" style="padding-left:2px">
              <img src="./common/assets/arrow.svg" alt="">
          </a>
          <div class="round-button__expand h3">
              Bảng điểm cá nhân
          </div>
        </div>
      </div></transition>
    </div>

    <div class="popup-full">
      <transition name="slide-fade">
        <div class="info-page" v-show="showInfoPage">
          <loading v-show="loading"></loading>
          <div v-on:click="closeInfoPage" class="round-button round-button--negative"
                style="position: absolute;right: 35px;top: 20px;">
            <img src="./common/assets/close.svg" alt="">
          </div>
          <div v-if="!loading">
            <info-page :user="user" :student="student"></info-page>
          </div>
        </div>
      </transition>
    </div>

  </div>
</template>

<script>
import ScheduleTable from "./common/ScheduleTable.vue";
import ResultTable from "./common/ResultTable.vue";
import InfoPage from "./common/InfoPage.vue";
import Loading from "./common/Loading.vue";

export default {
  props: ['currentstudentid', 'currentstudentname'],
  components: {
    'schedule-table': ScheduleTable,
    'result-table': ResultTable,
    'info-page': InfoPage,
    'loading': Loading,
  },

  methods: {
    userResult() {

      var finalResult_a = 0;
      var finalResult_b = 0;
      for (var i = 0; i < this.userStudyList.length; ++i) {
        finalResult_a += this.userStudyList[i].study_result*this.courseList[i].course_credit;
        finalResult_b += this.courseList[i].course_credit;
      }
      this.finalResult = 1/finalResult_b;
    },

    searchCourse: async function(i) {
      try{
        let response =  await axios.get('/courses/' + this.classList[i].classroom_courseid);
        this.courseList.push(response.data[0]);
        this.loading = (i < this.scheduleList.length-1);
        if ((i == this.scheduleList.length - 1) && (this.userStudyList.length == 0)) {
          this.userStudyList = this.scheduleList;
          this.userCourseList = this.courseList;
        }
      }catch(error) {
          console.log(error);
        };
    },

    searchClasses: async function() {
      let i = 0;
      for (i = 0; i < this.scheduleList.length; ++i) {
      try{
       let response =  await axios.get('/classes/' + this.scheduleList[i].study_classroomid);
       this.classList.push(response.data[0]);
       this.searchCourse(i);
      }catch(error) {
          console.log(error);
        };
      }
    },

    searchSchedule: async function(id) {
      this.loading = true;
      this.scheduleList = [];
      this.classList = [];
      this.courseList = [];

      try{
         let response =  await axios.get('/studies/' + id);
         this.scheduleList = response.data;
         if (response.data.length == 0) {
           this.warning = 'Không tìm thấy sinh viên mã số ' + this.searchID;
           this.loading = false;
           return;
         }
         else this.searchClasses();
         if (!this.showResultPage) {
           this.showSchedulePage = true;
           this.showResultTag = false;
         }
         this.showUserTag = false;
         this.warning = '';
      }catch(error) {
          console.log(error);
      };
    },

    searchUser: async function() {
      try {
        let response = await axios.get('/users/' + this.currentstudentid);
        this.user = response.data[0];
        console.log(this.user);
        this.loading = false;
      } catch (e) {
        console.log(e);
      }
    },

    searchStudent: async function() {
      this.loading = true;
      try {
        let response = await axios.get('/students/' + this.currentstudentid);
        this.student = response.data[0];
        this.searchUser();
      } catch (e) {
        console.log(e);
      }
    },

    openSchedulePage() {
      if (this.searchID == '') {
        this.warning = 'Chưa nhập MSSV';
        return;
      }
      if (this.searchID === this.searchIdFound) {
        this.showSchedulePage = true;
        this.showUserTag = false;
        this.showResultTag = false;
        return;
      }
      this.searchIdFound = this.searchID;
      this.searchSchedule(this.searchID);

    },

    closeSchedulePage() {
      this.showUserTag = true;
      this.showResultTag = true;
      this.showSchedulePage = false;
    },

    openResultPage() {
      this.showResultPage = true;
      this.showScheduleTag = false;
      this.showUserTag = false;
      if (this.userStudyList.length > 0) return;
      this.searchSchedule(this.currentstudentid);
    },

    closeResultPage() {
      this.showResultPage = false;
      this.showScheduleTag = true;
      this.showUserTag = true;
    },

    openInfoPage() {
      this.showUserTag = false;
      this.showResultTag = false;
      this.showScheduleTag = false;
      this.showInfoPage = true;
      if (this.user.id == 'null') this.searchStudent();
    },

    closeInfoPage() {
      this.showUserTag = true;
      this.showResultTag = true;
      this.showScheduleTag = true;
      this.showInfoPage = false;
    },

    logOut() {
        window.location.assign('http://huststudentresult/');
    }

  },

  data() {
    return {
      showUserTag: true,
      showResultTag: true,
      showScheduleTag: true,

      showSchedulePage: false,
      showResultPage: false,
      showInfoPage: false,

      searchID: '',
      searchIdFound: '',
      loading: false,
      warning: '',

      student: {
        student_id: 'null',
      },

      user: {
        id: 'null',
      },

      scheduleList: [],
      classList: [],
      courseList:[],

      userStudyList: [],
      userCourseList:[],
    }
  }
}
</script>

<style lang="scss" scoped>
</style>
