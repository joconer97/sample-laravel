<script>
import { Line } from 'vue-chartjs'

const brandPrimary = '#20a8d8'
const brandInfo    = '#63c2de'
const datasets     = [
  {
    label          : 'My First dataset',
    backgroundColor: brandPrimary,
    borderColor    : 'rgba(255,255,255,.55)',
    data           : [
      1,
      59,
      84,
      84,
      51,
      55,
      40,
    ],
  },
  {
    label          : 'My Second dataset',
    backgroundColor: brandInfo,
    borderColor    : 'rgba(255,255,255,.55)',
    data           : [
      5,
      2,
      120,
      504,
      51,
      55,
      40,
    ],
  },
  {
    label          : 'My First dataset',
    backgroundColor: brandPrimary,
    borderColor    : 'rgba(255,255,255,.55)',
    data           : [
      1,
      59,
      84,
      84,
      51,
      55,
      40,
    ],
  },
  {
    label          : 'My First dataset',
    backgroundColor: brandPrimary,
    borderColor    : 'rgba(255,255,255,.55)',
    data           : [
      1,
      59,
      84,
      84,
      51,
      55,
      40,
    ],
  },
  
]

export default {
  extends: Line,
  props  : ['height'],
  mounted () {
    this.renderChart({
      labels: [
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
      datasets: datasets,
    }, {
      maintainAspectRatio: false,
      legend             : { display: false },
      scales             : {
        xAxes: [
          {
            gridLines: {
              color        : 'transparent',
              zeroLineColor: 'transparent',
            },
            ticks: {
              fontSize : 2,
              fontColor: 'transparent',
            },
          },
        ],
        yAxes: [
          {
            display: false,
            ticks  : {
              display: false,
              min    : Math.min.apply(Math, datasets[0].data) - 5,
              max    : Math.max.apply(Math, datasets[0].data) + 5,
            },
          },
        ],
      },
      elements: {
        line : { borderWidth: 1 },
        point: {
          radius     : 4,
          hitRadius  : 10,
          hoverRadius: 4,
        },
      },
    })
  },
}
</script>
