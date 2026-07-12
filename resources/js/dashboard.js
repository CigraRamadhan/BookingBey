import Chart from 'chart.js/auto';

const canvas = document.getElementById('bookingChart');

const bookingData = window.chartBooking ?? {
    labels: [],
    data: []
};

// const canvas = document.getElementById('bookingChart');

if (canvas) {

    new Chart(canvas, {

        type: 'line',

        data: {

            labels: bookingData.labels,

            datasets: [{

                label: 'Booking',

                data: bookingData.data,

                borderColor: '#2563eb',

                backgroundColor: 'rgba(37,99,235,.15)',

                fill: true,

                tension: .4,

                borderWidth: 3

            }]

        },

        options: {

            responsive: true,

            plugins: {

                legend: {

                    display: false

                }

            }

        }

    });

}
document.querySelectorAll(".dashboard-card h2").forEach(el=>{

const target=parseInt(el.innerText);

let count=0;

const speed=25;

const update=()=>{

if(count<target){

count++;

el.innerText=count;

setTimeout(update,speed);

}else{

el.innerText=target;

}

};

update();

});