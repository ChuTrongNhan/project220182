<template>
    <div class="login-tag" style="margin-top: 10vh;">
      <div class="vector-right">
        <img src="./common/assets/vector2.svg" alt="">
      </div>

      <div class="table-title-h1" style="font-size: 48px;">Login</div>

      <div class="row left h3 input-title">Tên đăng nhập</div>
      <input v-model="username">
      <div class="row left h3 input-title">Mật khẩu</div>
      <input type="password" v-model="password">
      <div class="warning">
          <a v-show="loginFail">{{warning}}</a>
      </div>
      <select v-model="selected" style="
                margin-left: 148px;
                outline: none;
                font-size: 10px;
                font-weight: 300;
                position: absolute;
                margin-top: -5px;">
        <option disabled value="">Đăng nhập với tư cách</option>
        <option>student</option>
        <option>teacher</option>
      </select>
      <div  class="button button--primary"
            style="margin:auto;margin-top:20px "
            v-on:click="checkLogin()">
        Login
      </div>
      <div class="row center">
        <div class="text-button" style="position:absolute;margin:auto;bottom:36px">
          Quên mật khẩu
        </div>
      </div>
      <div class="loading-background" v-show="loading">
        <load-ing></load-ing>
      </div>
    </div>
</template>

<script>
import Loading from "./common/Loading.vue";
export default {
    components: {
      'load-ing': Loading,
    },
    data() {
        return {
            username: '',
            password: '',
            randomStr: '',
            loginFail: false,
            loading: false,
            listUser: [],
            selected: '',
            warning: '',
            type: ['teacher','student'],
        }
    },

    methods: {
        checkUserList: async function() {
          if (this.selected == '') {
            this.loginFail = true;
            this.warning = 'Chọn tư cách đăng nhập';
            return;
          }
          for ( var i = 0; i < this.listUser.length; ++i ) {
              if (this.username === this.listUser[i].username
                && this.password === this.listUser[i].password
                && this.selected === this.type[this.listUser[i].type])
                {
                      var router = window.location.pathname;
                      this.randomStr = this.generate_random_user_code();
                      try {
                        let response = await axios.put('/users/' + this.listUser[i].id, {name: '_', password: '_', code: this.randomStr, email: '_'})
                        router = router + this.selected + this.randomStr;
                        window.location.assign('http://huststudentresult' + router);
                        this.loginFail = false;
                        return;
                      } catch (e) {
                          console.log(e);
                      }
                  }
          }
          this.loginFail = true;
          this.warning = 'Sai tên đăng nhập hoặc mật khẩu !';
        },

        checkLogin: async function() {
            this.loading = true;
            if (this.listUser.length == 0) {
              try {
                let response = await axios.get('/users');
                this.listUser = response.data;
                this.checkUserList();
                this.loading = false;
              } catch (e) {
                console.log(e);
              }
            }
            else {
              this.checkUserList();
              this.loading = false;
            }
        },

        generate_random_user_code() {
            let random_string = '';
            let random_ascii;
            for(let i = 0; i < 6; i++) {
                random_ascii = Math.floor((Math.random() * 25) + 97);
                random_string += String.fromCharCode(random_ascii)
            }
            return random_string
        },
    }
}
</script>

<style type="text/css" lang="scss" scoped>
.input-title {
  margin-top:25px;
  margin-left: 0;
  font-weight: lighter;
}
input {
  width: 75%;
  text-align: left;
}
</style>
