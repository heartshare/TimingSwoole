(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-53d82a80"],{2534:function(e,t,l){"use strict";l.r(t);var s=function(){var e=this,t=e.$createElement,l=e._self._c||t;return l("div",{staticClass:"app-container"},[l("el-form",{ref:"form",attrs:{model:e.form,"label-width":"120px"}},[l("el-form-item",{attrs:{label:"定时器类型"}},[l("el-select",{attrs:{placeholder:"please select your zone"},model:{value:e.form.region,callback:function(t){e.$set(e.form,"region",t)},expression:"form.region"}},[l("el-option",{attrs:{label:"Post",value:"1"}}),l("el-option",{attrs:{label:"Shell",value:"2"}})],1)],1),l("el-form-item",{attrs:{label:"执行次数"}},[l("el-input",{attrs:{placeholder:"0或不填则无限循环"},model:{value:e.form.numbers,callback:function(t){e.$set(e.form,"numbers",t)},expression:"form.numbers"}})],1),l("el-form-item",{attrs:{label:"执行时间",prop:"timestamp"}},[l("el-date-picker",{staticStyle:{width:"300px"},attrs:{type:"datetime",placeholder:"不填或时间过期默认当前时间执行"},on:{focus:e.getNowTime},model:{value:e.temp.timestamp,callback:function(t){e.$set(e.temp,"timestamp",t)},expression:"temp.timestamp"}})],1),l("el-form-item",{attrs:{label:"多少毫秒执行"}},[l("el-col",{attrs:{span:3}},[l("el-input",{model:{value:e.form.longTime1,callback:function(t){e.$set(e.form,"longTime1",t)},expression:"form.longTime1"}})],1),l("el-col",{staticClass:"line",attrs:{span:1}},[e._v("*")]),l("el-col",{attrs:{span:3}},[l("el-input",{model:{value:e.form.longTime2,callback:function(t){e.$set(e.form,"longTime2",t)},expression:"form.longTime2"}})],1),l("el-col",{staticClass:"line",attrs:{span:1}},[e._v("*")]),l("el-col",{attrs:{span:3}},[l("el-input",{model:{value:e.form.longTime3,callback:function(t){e.$set(e.form,"longTime3",t)},expression:"form.longTime3"}})],1),l("el-col",{staticClass:"line",attrs:{span:1}},[e._v("*")]),l("el-col",{attrs:{span:3}},[l("el-input",{model:{value:e.form.longTime4,callback:function(t){e.$set(e.form,"longTime4",t)},expression:"form.longTime4"}})],1),l("el-col",{staticClass:"line",attrs:{span:2}},[e._v("毫秒")])],1),1==e.show.RequestType?l("el-form-item",{attrs:{label:"url请求地址"}},[l("el-input",{attrs:{placeholder:"https://github.com/zyx7017"},model:{value:e.form.url,callback:function(t){e.$set(e.form,"url",t)},expression:"form.url"}})],1):e._e(),1==e.show.RequestType?l("el-form-item",{attrs:{label:"postData"}},[l("el-input",{attrs:{placeholder:'{"username":6,"postData":"5"}',type:"textarea"},model:{value:e.form.desc,callback:function(t){e.$set(e.form,"desc",t)},expression:"form.desc"}})],1):e._e(),2==e.show.RequestType?l("el-form-item",{attrs:{label:"Shell"}},[l("el-input",{attrs:{placeholder:"shell命令",type:"textarea"},model:{value:e.form.shell,callback:function(t){e.$set(e.form,"shell",t)},expression:"form.shell"}})],1):e._e(),l("el-form-item",[l("el-button",{attrs:{type:"primary"},on:{click:e.onSubmit}},[e._v("Create")]),l("el-button",{on:{click:e.onCancel}},[e._v("Cancel")])],1)],1)],1)},o=[],a={data:function(){return{form:{numbers:"1",region:"1",date1:"",date2:"",type:[],resource:"",desc:"",ws:"",url:"",timeType:"2",longTime1:"1",longTime2:"1",longTime3:"1",longTime4:"1000"},show:{RequestType:"1"},temp:{id:void 0,importance:1,remark:"",timestamp:"",title:"",type:"",status:"published"}}},mounted:function(){this.init()},watch:{"form.region":function(e){this.show.RequestType=e}},methods:{getNowTime:function(){this.temp.timestamp=new Date},init:function(){var e=this;this.$global.ws.onmessage=function(t){var l=t.data;console.log(l),e.$message({message:"submit!!",type:"success"})}},onSubmit:function(){var e=this.form.longTime1*this.form.longTime2*this.form.longTime3*this.form.longTime4,t={times:e,urls:this.form.url,postData:this.form.desc,types:this.form.timeType,datestart:this.temp.timestamp,numss:this.form.numbers,shellData:this.form.shell,postTypes:this.form.region},l=JSON.stringify(t);this.$global.ws.send(l),this.$router.push("/example/listserver")},onCancel:function(){this.$message({message:"cancel!",type:"warning"})}}},i=a,n=(l("6bb2"),l("2877")),r=Object(n["a"])(i,s,o,!1,null,"f953bf40",null);t["default"]=r.exports},"29b2":function(e,t,l){},"6bb2":function(e,t,l){"use strict";var s=l("29b2"),o=l.n(s);o.a}}]);