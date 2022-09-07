<template>
    <div>
        <div class="flex justify-between">
            <span class="pr-2 text-xl tracking-wider font-extrabold text-red-600 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="fill-current pr-2" viewBox="0 0 24 24">
                    <path d="M12 2c2.757 0 5 2.243 5 5.001 0 2.756-2.243 5-5 5s-5-2.244-5-5c0-2.758 2.243-5.001 5-5.001zm0-2c-3.866 0-7 3.134-7 7.001 0 3.865 3.134 7 7 7s7-3.135 7-7c0-3.867-3.134-7.001-7-7.001zm6.369 13.353c-.497.498-1.057.931-1.658 1.302 2.872 1.874 4.378 5.083 4.972 7.346h-19.387c.572-2.29 2.058-5.503 4.973-7.358-.603-.374-1.162-.811-1.658-1.312-4.258 3.072-5.611 8.506-5.611 10.669h24c0-2.142-1.44-7.557-5.631-10.647z"/>
                </svg>
             {{yValues[yValues.length-1]}}</span>
            <div class="flex items-center justify-center">
                <svg v-if="diff.greater" width="14" height="12" viewBox="0 0 24 24" class="fill-current text-green-500" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                    <path d="M11 2.206l-6.235 7.528-.765-.645 7.521-9 7.479 9-.764.646-6.236-7.53v21.884h-1v-21.883z"/>
                </svg>
                <svg v-else width="14" height="12" viewBox="0 0 24 24" class="fill-current text-red-500" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                    <path d="M11 21.883l-6.235-7.527-.765.644 7.521 9 7.479-9-.764-.645-6.236 7.529v-21.884h-1v21.883z"/>
                </svg>
                <span class="text-green-400">{{diff.percent}}%</span>
            </div>
        </div>
        <div>
            <span class="text-xs tracking-wider text-gray-400">Customers</span>
            <div>
                <canvas id="myChart3" style="width:100%;" class=""></canvas>
            </div>
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
            var ctx = document.getElementById('myChart3'); // node
            ctx.height = 150;
            var myChart = new Chart(ctx, {
                            id:   "DailySales",
                            type: "line",
                            data: {
                                labels: this.xValues,
                                datasets: [{
                                    label: 'Sales',
                                    fill: true,
                                    lineTension: 0.4,
                                    borderWidth: 2,
                                    pointRadius: 0,
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
                                            drawBorder: false,
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
         axios.get('/admin/chart/sales/month')
        .then(res => this.response = res.data);
    },
}

</script>
