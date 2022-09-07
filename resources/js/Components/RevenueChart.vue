<template>
    <div>
        <div class="flex justify-between">
            <span class="pr-2 text-xl tracking-wider font-extrabold text-red-600">&#8377; {{yValues[yValues.length-1]}}</span>
            <div class="flex items-center justify-center">
                <span class="text-green-400">{{diff.percent}}%</span>

                <svg v-if="diff.greater" width="14" height="12" viewBox="0 0 24 24" class="fill-current text-green-500" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                    <path d="M11 2.206l-6.235 7.528-.765-.645 7.521-9 7.479 9-.764.646-6.236-7.53v21.884h-1v-21.883z"/>
                </svg>
                <svg v-else width="14" height="12" viewBox="0 0 24 24" class="fill-current text-red-500" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                    <path d="M11 21.883l-6.235-7.527-.765.644 7.521 9 7.479-9-.764-.645-6.236 7.529v-21.884h-1v21.883z"/>
                </svg>
            </div>
        </div>
        <div>
            <span class="text-xs tracking-wider text-gray-400">Revenue</span>
            <canvas id="myChart4" style="width:100%;" class=""></canvas>
        </div>
    </div>
</template>
<script>
import Chart from 'chart.js/auto';
export default{
    data()
    {
        return{
            response: [],
            xValues : [],
            yValues : [],
            diff: {
                greater : true,
                no: '',
                percent: ''
            }

        }
    },
    methods:
    {
        loadchart()
        {
            var ctx = document.getElementById('myChart4'); // node
            ctx.height = 150;
            var myChart = new Chart(ctx, {
                            id:   "DailySales",
                            type: "bar",
                            data: {
                                labels: this.xValues,
                                datasets: [{
                                    label: 'Sales',
                                    fill: true,
                                    lineTension: 0.4,
                                    borderWidth: 2,
                                    pointRadius: 4,
                                    pointHoverRadius: 4,
                                    pointBackgroundColor: "rgba( 246, 49, 131 ,0.5)",
                                    pointBorderColor: 'rgba( 246, 49, 131 ,0.5)',
                                    backgroundColor: "rgba(160,150,150,0 )",
                                    borderColor: "rgba( 246, 49, 131 ,0.5)",
                                    data: this.yValues,
                                }]
                            },
                            options: {
                                layout: {
                                
                                },
                                plugins: {
                                    legend: {
                                        display: false,
                                    }
                                },
                                
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid:{
                                            drawBorder: false,
                                            display: false
                                        },
                                        title: {
                                                font: {
                                                    size: 14,
                                                },
                                                color: 'black'
                                            },

                                        ticks: {
                                            display: false,
                                            min: Math.min.apply(this, this.yValues) - 5,
                                            max: Math.max.apply(this, this.yValues) + 5,
                                            font: {
                                                size: 12,
                                            },
                                        
                                        },
                                    },
                                    x:{
                                        grid:{
                                            
                                            display:false,
                                            opacity:0.5,
                                            color:"rgba(158, 105, 100, 0.5)",
                                        },
                                        ticks: {
                                            display: false,
                                                font: {
                                                    size: 12,
                                                },
                                            
                                            },
                                    }
                                },

                            }
            });
        }
    },
    watch:{
        response(){
            this.yValues = this.response.y;
            this.xValues = this.response.x;
            if(this.yValues[this.yValues.length - 1] >= this.yValues[this.yValues.length - 2])
            {
                this.diff.greater = true;
                this.diff.no = this.yValues[this.yValues.length - 1] - this.yValues[this.yValues.length - 2];
                this.diff.percent = parseFloat((this.yValues[this.yValues.length -2] * this.diff.no)/100).toFixed(2)
            }
            else
            {
                this.diff.greater = false;
                this.diff.no = this.yValues[this.yValues.length - 2] - this.yValues[this.yValues.length - 1];
                this.diff.percent = parseFloat((this.yValues[this.yValues.length -2] * this.diff.no)/100).toFixed(2)
            }
            this.loadchart();
        },
    },
    mounted()
    {
         axios.get('/admin/chart/sales/revenue')
        .then(res => this.response = res.data);
    },
}

</script>
