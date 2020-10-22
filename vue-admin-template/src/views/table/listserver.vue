<template>
  <div class="app-container">
        <!-- <el-button type="primary" @click="getds()">显示数据</el-button> -->

    <el-table
      v-loading="listLoading"
      :data="stationDetailsData"
      element-loading-text="Loading"
      border
      fit
      highlight-current-row
    >
      <!-- <el-table-column align="center" label="ID" width="95">
        <template slot-scope="scope">
          {{ scope.$index }}
        </template>
      </el-table-column> -->
      <el-table-column label="keys" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.keys }}</span>
        </template>
      </el-table-column>
      <el-table-column  label="urls" width="110" align="center">
        <template slot-scope="scope">
          <span v-if="scope.row.postTypes==1">{{ scope.row.urls }}</span>
        </template>
      </el-table-column>
      <el-table-column  label="postData" width="110" align="center">
        <template slot-scope="scope">
          <span v-if="scope.row.postTypes==1">{{ scope.row.postData }}</span>
        </template>
      </el-table-column>
      <el-table-column label="多少时间执行一次" width="110" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.times }}毫秒</span>
        </template>
      </el-table-column>
      <el-table-column label="执行次数" width="110" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.numss?scope.row.numss:'无限' }}</span>
        </template>
      </el-table-column>
      
      <el-table-column  label="shellData" width="110" align="center">
        <template slot-scope="scope">
          <span v-if="scope.row.postTypes==2">{{ scope.row.shellData }}</span>
        </template>
      </el-table-column>
      <el-table-column label="postTypes" width="110" align="center">
        <template slot-scope="scope">
          <span>{{ scope.row.postTypes==1?'Post':'Shell' }}</span>
        </template>
      </el-table-column>
       
     
     
      <!-- <el-table-column label="Pageviews" width="110" align="center">
        <template slot-scope="scope">
          {{ scope.row.urls }}
        </template>
      </el-table-column> -->
      <el-table-column class-name="status-col" label="运行状态" width="110" align="center">
        <template slot-scope="scope">
          <el-tag :type="scope.row.ing | statusFilter">{{ scope.row.ing?'运行':'停止' }}</el-tag>
        </template>
      </el-table-column>


       <el-table-column label="Actions" align="center" width="190" class-name="small-padding fixed-width">
        <template  slot-scope="scope">
           
          <el-button v-if="scope.row.ing" type="primary" size="mini" @click="stop(scope.row.keys,scope.$index) " >
            停止
          </el-button>
         
          <!-- <el-button   size="mini" type="success"  @click="getLog(scope.row.types)" >
            记录
          </el-button> -->

          <el-button v-if="!scope.row.ing"   size="mini" type="danger" @click="del(scope.row.keys,scope.$index)" >
            删除
          </el-button>

        </template>
        
      </el-table-column>

       <el-table-column align="center" prop="created_at" label="执行时间" width="200">
        <template slot-scope="scope">
          <i class="el-icon-time" />
          <span>{{ scope.row.starttime }}</span>
        </template>
      </el-table-column>

    </el-table>
     <pagination v-show="total" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getds" />
  </div>
</template>

<script>
import { getList } from '@/api/table'
import Pagination from '@/components/Pagination' // secondary package based on el-pagination

export default {
  name: 'ComplexTable',
  components: { Pagination },
  filters: {
    statusFilter(status) {
      const statusMap = {
        published: 'success',
        draft: 'gray',
        deleted: 'danger'
      }
      return statusMap[status]
    }
  },
  data() {
    return {
      list: null,
      listLoading: true,
      total:0,
      listQuery: {
        page: 1,
        limit: 10,
        importance: undefined,
        title: undefined,
        type: undefined,
        sort: '+id'
      },
      ss:"",
      stationDetsailsData:"",
      stationDetailsData: [],
      reduce:1,
    }
  },
  created() {  
    this.init()
  },
  mounted:function(){
    this.getds()

  },
  methods: {
    getLog(key){

    },
    //删除当前任务
      del(keys,index){
                var msg = {delete:keys};
                  var senddata = JSON.stringify(msg);
                  this.$global.ws.send(senddata); 
                  this.stationDetailsData.splice(index, 1)
      },
    //停止当前任务
      stop(keys,index){
                  var msg = {stop:keys};
                  var senddata = JSON.stringify(msg);
                  this.$global.ws.send(senddata); 
                  this.stationDetailsData.[index]['ing']=false
                
      },

    stationDetails(row) {
      this.stationDetailsData = [{}]
      for (const i in row) {
        if(!isNaN(i)){
         this.$set(this.stationDetailsData, i, row[i])
        }
      }

    },
     init(){
      const that = this
      this.$global.ws.onmessage = function (evt) 
                { 
                    var received_msg = evt.data;
                    var arrdata = JSON.parse( received_msg );
                    if(arrdata['total']>0){
                      that.total = arrdata['total'];
                      that.tableData = that.stationDetails(arrdata)
                    }

                };
        this.listLoading = false

     },
     getds(){
      const that = this

      this.$global.ws.onopen = function()
               {
                  var msg = {getarrdata:2,search:that.listQuery};
                  var senddata = JSON.stringify(msg);
                  that.$global.ws.send(senddata); 

               }; 
                  var msg = {getarrdata:2,search:that.listQuery};
                  var senddata = JSON.stringify(msg);
                  that.$global.ws.send(senddata); 
    },
    handle(){
      this.$message({
        message: '操作Success',
        type: 'success'
      })
    }
  }
}
</script>
