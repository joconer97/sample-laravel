<script>
import { Line } from 'vue-chartjs'
import {bus} from '../../../main.js'
// const brandPrimary = '#20a8d8'
const brandSuccess = '#4dbd74'
const brandInfo    = '#63c2de'
const brandDanger  = '#f86c6b'

function convertHex (hex, opacity) {
  hex     = hex.replace('#', '')
  const r = parseInt(hex.substring(0, 2), 16)
  const g = parseInt(hex.substring(2, 4), 16)
  const b = parseInt(hex.substring(4, 6), 16)

  const result = `rgba(${r},${g},${b},${opacity / 100})`
  return result
}

function random (min, max) {
  return Math.floor(Math.random() * (max - min + 1) + min)
}

export default {
  extends: Line,
  data(){
    return{
      datasets : [],
      labels : [
          'January',
          'February',
          'March',
          'April',
          'May',
          'June',
          'July',
          'August',
          'September',
          'October',
          'November',
          'December'
        ],
        max : 250
    }
  },
  props  : ['height'],
  computed : {
    inventories(){
      return this.$store.getters.inventoryReports
    },
    inventoriesDaily(){
      return this.$store.getters.inventoryReportsDay
    }
  },
  created(){
    bus.$on('reportDays',(data) => {
      this.initializeDailyReports()
    })
    
    bus.$on('reportMonth',(data) => {
      this.initializeData()
    })
  },
  mounted () {
    if(this.inventories.length)
      return

      this.$store.dispatch('getInventoryReports')
      setTimeout(() => {
        this.initializeData()
      },1000)
  },
  methods : {
    initializeDailyReports(){
      var date = new Date();
      var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
      var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);

      var start = firstDay.getDate()
      var end = lastDay.getDate()
      this.labels = []
      this.datasets = []

      for(let i = start; i <= end; i++){
        this.labels.push(i)
      }
      this.max = 1000
      this.inventoriesDaily.forEach(inventory => {

        let data = []
        this.labels.forEach(day => {
          if(inventory.day == day){
            console.log(this.max + "<" + inventory.total)
            console.log(this.max < inventory.total)
            if(this.max < inventory.total){
                this.max = inventory.total
            }
            data.push(inventory.total)
          }else{
            data.push(0)
          }
        })

        let tempColor = ''
          if(inventory.total < 20){
            tempColor = brandDanger
          }
          else if(inventory.total < 50){
            tempColor = brandInfo
          }else{
            tempColor = brandSuccess
          }
          let tempObject =  {
          label                    : inventory.item_name,
          backgroundColor          : convertHex(tempColor, 10),
          borderColor              : tempColor,
          pointHoverBackgroundColor: '#fff',
          borderWidth              : 2,
          data                     : data,
        }

        this.datasets.push(tempObject)
      })
      this.initialize()
    },
    initializeData(){
        this.labels = []
        this.datasets = []
        this.labels = [
          'January',
          'February',
          'March',
          'April',
          'May',
          'June',
          'July',
          'August',
          'September',
          'October',
          'November',
          'December'
        ]
        this.max = 1000
        this.inventories.forEach(inventory => {
          let data = []
          let counter = 1
          this.labels.forEach(label => {
    
              if(counter == inventory.date){
                data.push(inventory.total)
              }
              else
              {
                data.push(0)
              }
              counter++
          })
          let tempColor

          if(inventory.total < 20){
            tempColor = brandDanger
          }
          else if(inventory.total < 50){
            tempColor = brandInfo
          }else{
            tempColor = brandSuccess
          }
          let tempObject =  {
          label                    : inventory.item_name,
          backgroundColor          : convertHex(tempColor, 10),
          borderColor              : tempColor,
          pointHoverBackgroundColor: '#fff',
          borderWidth              : 2,
          data                     : data,
        }

        this.datasets.push(tempObject)
        })
        this.initialize()
    },
    initialize(){
      this.renderChart({
        labels: this.labels,
        datasets: this.datasets,
        
      }, 
      {
        maintainAspectRatio: false,
        legend             : { display: false },
        scales             : {
          xAxes: [{ gridLines: { drawOnChartArea: false }, display: true}],
          yAxes: [
            {
              ticks: {
                beginAtZero  : true,
                maxTicksLimit: 5,
                stepSize     : Math.ceil(250 / 5),
                max          : this.max,
              },
              gridLines: { display: true },
            },
          ],
        },
        elements: {
          point: {
            radius          : 0,
            hitRadius       : 10,
            hoverRadius     : 4,
            hoverBorderWidth: 3,
          },
        },
      })
    }
  }
}
</script>
