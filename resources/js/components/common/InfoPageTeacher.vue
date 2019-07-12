<template>
  <div>
    <div class="row h1"
        style="
              border-bottom: 2px solid #c1c1c1;
              margin: 10px 60px 0 20px;
              padding: 15px 0px;">
        {{teacher.teacher_name}} - {{user.id}}
        <div style="
              font-weight: 300;
              font-size: 18px;
              line-height: 21px;
              text-align: right;
              color: #000;
              right: 94px;
              position: absolute;
                    ">
          {{teacher.teacher_birthday}}</br>
          {{teacher.teacher_address}}
        </div>
    </div>

    <!-- Ten dang nhap -->
    <div class="row info-page-row">
        <div class="row">
          <div class="field">Tên đăng nhập</div>
          <div class="value">{{user.username}}</div>
          <div v-on:click="openEdit(0)" class="edit-button"><img src="./assets/ic_edit.svg" alt="Edit"></div>
        </div>
        <div class="row" v-show="edit[0]">
          <div class="field"></div>
          <input v-model="username">
          <div class="text-button" style="margin-left: 40px"  v-on:click="edit[0]=false">Hủy</div>
          <div class="button button--primary" style="margin-left: 40px" v-on:click="updateUserName(username)">Thay đổi</div>
        </div>
    </div>

    <!-- Mat khau -->
    <div class="row info-page-row">
        <div class="row">
          <div class="field">Mật khẩu</div>
          <div class="value">{{user.password}}</div>
          <div v-on:click="openEdit(1)" class="edit-button"><img src="./assets/ic_edit.svg" alt="Edit"></div>
        </div>
        <div class="row" v-show="edit[1]">
          <div class="field"></div>
          <input v-model="password">
          <div class="text-button" style="margin-left: 40px"  v-on:click="edit[1]=false">Hủy</div>
          <div class="button button--primary" style="margin-left: 40px" v-on:click="updatePassword(password)">Thay đổi</div>
        </div>
    </div>

    <!-- Email -->
    <div class="row info-page-row">
        <div class="row">
          <div class="field">Email</div>
          <div class="value">{{user.email}}</div>
          <div v-on:click="openEdit(2)" class="edit-button"><img src="./assets/ic_edit.svg" alt="Edit"></div>
        </div>
        <div class="row" v-show="edit[2]">
          <div class="field"></div>
          <input v-model="email">
          <div class="text-button" style="margin-left: 40px"  v-on:click="edit[2]=false">Hủy</div>
          <div class="button button--primary" style="margin-left: 40px" v-on:click="updateEmail(email)">Thay đổi</div>
        </div>
    </div>

    <!-- Phone -->
    <div class="row info-page-row">
        <div class="row">
          <div class="field">Điện thoại</div>
          <div class="value">{{teacher.teacher_phone}}</div>
          <div v-on:click="openEdit(3)" class="edit-button"><img src="./assets/ic_edit.svg" alt="Edit"></div>
        </div>
        <div class="row" v-show="edit[3]">
          <div class="field"></div>
          <input v-model="phone">
          <div class="text-button" style="margin-left: 40px"  v-on:click="edit[3]=false">Hủy</div>
          <div class="button button--primary" style="margin-left: 40px" v-on:click="updatePhone(phone)">Thay đổi</div>
        </div>
    </div>

    <div class="loading-background" v-show="loadingInfoPage">
      <div class="wrapper t-loader">
        <svg viewBox="0 0 38 34">
          <polygon points="3,31 19,3 35,31 "/>
          <line class="dot active" x1="19" y1="31" x2="19" y2="31"></line>
        </svg>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  props: ['user','teacher'],

  methods: {
    openEdit(index) {
      for (var i = 0; i < index; ++i) this.edit[i] = false;
      this.edit[index] = !this.edit[index];
      for (var i = index + 1; i < 4; ++i) this.edit[i] = false;
      this.$forceUpdate();
    },

    updateUserName: async function(str) {
      try {
        this.username = '';
        this.loadingInfoPage = true;
        let response = await axios.put('/users/' + this.user.id, {name: str, password: '_', code: '_', email: '_'});
        this.user.username = str;
        this.edit[0] = false;
        this.loadingInfoPage = false;
      } catch (e) {
        console.log(e);
      }
    },

    updatePassword: async function(str) {
      try {
        this.password = '';
        this.loadingInfoPage = true;
        let response = await axios.put('/users/' + this.user.id, {name: '_', password: str, code: '_', email: '_'});
        this.user.password = str;
        this.edit[1] = false;
        this.loadingInfoPage = false;
      } catch (e) {
        console.log(e);
      }
    },

    updateEmail: async function(str) {
      try {
        this.email = '';
        this.loadingInfoPage = true;
        let response = await axios.put('/users/' + this.user.id, {name: '_', password: '_', code: '_', email: str});
        this.user.email = str;
        this.edit[2] = false;
        this.loadingInfoPage = false;
      } catch (e) {
        console.log(e);
      }
    },

    updatePhone: async function(str) {
      try {
        this.phone = '';
        this.loadingInfoPage = true;
        let response = await axios.put('/teachers/' + this.user.id, {phone: str});
        this.student.student_phone = str;
        this.edit[3] = false;
        this.loadingInfoPage = false;
      } catch (e) {
          console.log(e);
      }
    },
  },

  data() {
    return {
      edit: [false,false,false,false],
      username: '',
      password: '',
      email: '',
      phone: '',
      loadingInfoPage: false,
    }
  },
}
</script>

<style lang="scss" scoped>

.field {
  width: 170px;
  font-weight: 500;
}
.value {

}
.edit-button {
  position: absolute;
  right: 120px;
  cursor: pointer;
}

input, input:focus{
  font-family: Roboto;
  font-weight: normal;
  font-size: 14px;
  line-height: 16px;
  width: 240px;
  height: 35px;
  text-align: left;
  font-style: italic;
  color: #333;
}
</style>
