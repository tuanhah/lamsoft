 $(document).ready(function () {
   "use strict";
     // toat popup js
     $.toast({
       heading: 'Welcome to LAM SOFT',
       text: 'Phần mềm hàng đầu trong việc giám sát không khí trong thư viện',
       position: 'top-right',
       loaderBg: '#fff',
       icon: 'warning',
       hideAfter: 3500,
       stack: 6
   })


     //ct-visits
     new Chartist.Line('#ct-visits', {
       labels: ['1h', '3h', '6h', '9h', '12h', '15h', '17h', '19h', '21h', '24h'],
       series: [
       [5, 2, 7, 4, 5, 3, 5, 4, 3, 3, 2]
       , [2, 5, 2, 6, 2, 5, 2, 4, 3, 3, 2]
       // , [0, 0.4, 1, 7, 5, 6, 2, 5, 4, 3.2, 2.1]
       ]
   }, {
       top: 0,
       low: 0,
       showPoint: true,
       fullWidth: true,
       plugins: [
       Chartist.plugins.tooltip()
       ],
       axisY: {
           labelInterpolationFnc: function (value) {
               return (value / 1);
           }
       },
       showArea: true
   });
     // counter
     $(".counter").counterUp({
       delay: 100,
       time: 1200
   });

     var sparklineLogin = function () {
       $('#sparklinedash').sparkline([0, 5, 6, 10, 9, 12, 4, 9], {
           type: 'bar',
           height: '30',
           barWidth: '4',
           resize: true,
           barSpacing: '5',
           barColor: '#7ace4c'
       });
       $('#sparklinedash2').sparkline([0, 5, 6, 10, 9, 12, 4, 9], {
           type: 'bar',
           height: '30',
           barWidth: '4',
           resize: true,
           barSpacing: '5',
           barColor: '#7460ee'
       });
       $('#sparklinedash3').sparkline([0, 5, 6, 10, 9, 12, 4, 9], {
           type: 'bar',
           height: '30',
           barWidth: '4',
           resize: true,
           barSpacing: '5',
           barColor: '#11a0f8'
       });
       $('#sparklinedash4').sparkline([0, 5, 6, 10, 9, 12, 4, 9], {
           type: 'bar',
           height: '30',
           barWidth: '4',
           resize: true,
           barSpacing: '5',
           barColor: '#f33155'
       });
   }
   var sparkResize;
   $(window).on("resize", function (e) {
       clearTimeout(sparkResize);
       sparkResize = setTimeout(sparklineLogin, 500);
   });
   sparklineLogin();
});
