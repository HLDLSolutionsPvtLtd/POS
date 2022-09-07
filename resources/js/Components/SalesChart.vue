<template>
    <div class="bg-gray-200 shadow-sm p-4">
        <div class="p-2">
            <div class="">
                <div class="py-4">
                    <span class="font-bold text-gray-500">SALES</span>
                </div>
                <div class="flex items-center pb-4">
                    <span class="pr-2 text-xl tracking-wider font-extrabold text-red-600">&#8377; {{yValues[yValues.length-1]}}</span>
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
            </div>
            <div>
                <canvas id="myChart" style="width:100%;" class=""></canvas>
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
            var ctx = document.getElementById('myChart'); // node
            ctx.height = 320;
            var myChart = new Chart(ctx, {
                            id:   "sales",
                            type: "line",
                            data: {
                                labels: this.xValues,
                                datasets: [{
                                    label: 'Sales',
                                    fill: true,
                                    lineTension: 0.4,
                                    borderWidth: 2,
                                    pointRadius: 4,
                                    pointHoverRadius: 4,
                                    pointBackgroundColor: "#1f2937",
                                    pointBorderColor: '#1f2937',
                                    backgroundColor: "rgba(160,150,150,0 )",
                                    borderColor: "#1f2937",
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
                                            
                                        },
                                        title: {
                                                font: {
                                                    size: 14,
                                                },
                                                color: 'black'
                                            },

                                            ticks: {
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
