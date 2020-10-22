<template>
  <div class="app-container">
    <el-form ref="form" :model="form" label-width="120px">
     
      <el-form-item label="定时器类型">
        <el-select v-model="form.region" placeholder="please select your zone">
          <el-option label="Post" value="1" />
          <el-option label="Shell" value="2" />
        </el-select>
      </el-form-item>

      <!-- <el-form-item label="定时器方式">
        <el-select v-model="form.timeType" placeholder="please select your zone">
          <el-option label="多少毫秒重复执行" value="2" />
          <el-option label="固定时间开始重复执行" value="4" />
          <el-option label="清除定时器" value="5" />
          <el-option label="当前所有任务" value="6" />
        </el-select>
      </el-form-item> -->


       <el-form-item label="执行次数" >
        <el-input  v-model="form.numbers" placeholder="0或不填则无限循环" />
      </el-form-item>

      <el-form-item label="执行时间" prop="timestamp"  >
          <el-date-picker style="width:300px"   v-model="temp.timestamp" type="datetime" placeholder="不填或时间过期默认当前时间执行" @focus="getNowTime" />
        </el-form-item>

      <!-- <el-form-item label="执行时间" >
        <el-col :span="11">
          <el-date-picker v-model="form.date1" type="date" placeholder="Pick a date" style="width: 100%;" />
        </el-col>
        <el-col :span="2" class="line">-</el-col>
        <el-col :span="11">
          <el-time-picker v-model="form.date2" type="fixed-time" placeholder="Pick a time" style="width: 100%;" />
        </el-col>
      </el-form-item> -->

       <el-form-item label="多少毫秒执行">
        <el-col :span="3">
          <el-input v-model="form.longTime1" />
        </el-col>
        <el-col :span="1" class="line">*</el-col>
        <el-col :span="3">
          <el-input v-model="form.longTime2" />
        </el-col>
        <el-col :span="1" class="line">*</el-col>
        <el-col :span="3">
          <el-input v-model="form.longTime3" />
        </el-col>
        <el-col :span="1" class="line">*</el-col>
        <el-col :span="3">
          <el-input v-model="form.longTime4" />
        </el-col>
        <el-col :span="2" class="line">毫秒</el-col>

      </el-form-item>
    
      
      
      <el-form-item label="url请求地址" v-if="show.RequestType==1">
        <el-input placeholder='https://github.com/zyx7017' v-model="form.url" />
      </el-form-item>
      <el-form-item label="postData"  v-if="show.RequestType==1" >
        <el-input placeholder='{"username":6,"postData":"5"}' v-model="form.desc" type="textarea"  />
      </el-form-item>
      <el-form-item label="Shell" v-if="show.RequestType==2">
        <el-input placeholder="shell命令" v-model="form.shell" type="textarea" />
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="onSubmit">Create</el-button>
        <el-button @click="onCancel">Cancel</el-button>
      </el-form-item>
    </el-form>
  </div>
</template> 

<script>

export default {
  data() {
    return {
      form: {
        numbers:'1',
        region: '1',
        date1: '',
        date2: '',
        type: [],
        resource: '',
        desc: '',
        ws: '',
        url:"",
        timeType:'2',
        longTime1:'1',
        longTime2:'1',
        longTime3:'1',
        longTime4:'1000',
      },
      show:{
        RequestType: '1',
      },temp: {
        id: undefined,
        importance: 1,
        remark: '',
        // timestamp: new Date(),
        timestamp: '',
        title: '',
        type: '',
        status: 'published'
      },
    }
  },
  mounted(){

    this.init()
  },
  watch: {
    'form.region': function(newVal){
      this.show.RequestType = newVal
              // alert(newVal)
          },
  },
  methods: {

    getNowTime(){
      this.temp.timestamp = new Date()
    },

    init:function(){
       // alert("您的浏览器支持 WebSocket!");
               // 打开一个 web socket
               const that = this
              // this.ws = new WebSocket("ws://localhost:9502");
              // this.$global.ws.onopen = function()
              //  {
              //     // Web Socket 已连接上，使用 send() 方法发送数据
              //     // ws.send("发送数据");
              //     // console.log("数据发送中...");
              //  }; 
                
              //   this.$global.ws.onclose = function()
              //   { 
              //       // 关闭 websocket
              //       alert("连接已关闭...")
              //       console.log("连接已关闭..."); 
              //   };
                this.$global.ws.onmessage = function (evt) 
                { 
                    var received_msg = evt.data;
                    console.log(received_msg);
                    that.$message({
                      message: 'submit!!',
                      type: 'success'

                    })
                };
    },
    onSubmit() {
      var actionTime = this.form.longTime1*this.form.longTime2*this.form.longTime3*this.form.longTime4
      var msg = {times:actionTime,urls:this.form.url,postData:this.form.desc,types:this.form.timeType,datestart:this.temp.timestamp,numss:this.form.numbers,shellData:this.form.shell,postTypes:this.form.region};
      var senddata = JSON.stringify(msg);
      // console.log(senddata)
      this.$global.ws.send(senddata); 
      this.$router.push('/example/listserver')
    },
    onCancel() {
      this.$message({
        message: 'cancel!',
        type: 'warning'
      })
    }
  }
}
</script>

<style scoped>
.line{
  text-align: center;
}
</style>

