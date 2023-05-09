@extends('layouts.backend-layout')
@section('title', 'Tickets Reports')

@section('style')
    
@endsection

@section('breadcrumb-title')
    Reports
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('support-tickets.create')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total Tickets: {{ !empty($supportTickets) ? $supportTickets->count() : 0 }} <br>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-6">
            <table class="text-center table table-bordered mt-5" id="tabularData">
                <thead>
                    <tr>
                        <th>Monthly Source Counting</th>
                        <th>Total Complaints Tickets</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Email</td>
                        <td>485</td>
                    </tr>
                    <tr>
                        <td>Mobile</td>
                        <td>5</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>January' 23 Total</th>
                        <th>1382</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <canvas id="curve_chart" class="col-md-6" style="height: 150px"></canvas>
        
    </div>
    <div class="row">
        <canvas id="line_chart" class="col-md-6" style="height: 150px"></canvas>
    </div>
    
    <button type="button" onclick="downloadPdf()" class="btn btn-info">Download PDF</button>
@endsection

@section('script')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('curve_chart');
    const ctxLine = document.getElementById('line_chart');
    const bgColor = {
        id: 'bgColor',
        beforeDraw: (chart, options) => {
            const {
                ctx, width, height
            } = chart;
            ctx.fillStyle = 'white';
            ctx.fillRect(0, 0, width, height);
            ctx.restore();
        }
    }
    const config = {
      type: 'bar',
      data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green'],
        datasets: [{
          label: 'Total',
          data: [7, 9, 3, 5],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        },
        plugins: {
            legend: {
                labels: {
                    usePointStyle: true,
                    pointStyle: 'circle',
                    font: {
                        size: 26
                    },
                    boxWidth: 0,
                    display: true
                }
            }
        }
      },
      plugins: [bgColor]
    }

    const configLine = {
      type: 'line',
      data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Red', 'Blue', 'Yellow', 'Green'],
        datasets: [{
          label: 'Total Complaint',
          data: [7, 9, 3, 5, 7, 9, 3, 5],
          borderWidth: 2
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        },
        plugins: {
            legend: {
                labels: {
                    usePointStyle: true,
                    pointStyle: 'circle',
                    font: {
                        size: 26
                    },
                    boxWidth: 0,
                    display: true
                }
            }
        }
      },
      plugins: [bgColor]
    }
  
    new Chart(ctx, config);
    new Chart(ctxLine, configLine);
  </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>


<script>
    function downloadPdf() {
      
        // Get the width and height of the screen
        const screenWidth = window.innerWidth;
        const screenHeight = window.innerHeight;

        // Set the desired width and height of the image
        const imageWidth = screenWidth * 0.5;
        const imageHeight = screenHeight * 0.5;


        var printableArea = document.getElementById('curve_chart');
        var printableArea2 = document.getElementById('line_chart');
        var printableTable = document.getElementById('tabularData')

        var printableAreaImage = printableArea.toDataURL('image/jpeg', 1.0)
        var printableAreaImage2 = printableArea2.toDataURL('image/jpeg', 1.0)

        html2canvas(printableTable).then(canvas => {
            var imgData = canvas.toDataURL('image/jpeg', 1.0);

            var image = new Image();
image.src = imgData;

image.onload = function() {
                    var aspectRatio = image.width / image.height;
                    var height = 90 / aspectRatio;

                    var jsPdf = new jsPDF('landscape');
                    jsPdf.setFontSize(18)
                    
                    jsPdf.addImage(imgData, 'JPEG', 10, 20, 90, height)
                    jsPdf.addImage(printableAreaImage, 'JPEG', 105, 10, 90, 60)
                    jsPdf.addImage(printableAreaImage2, 'JPEG', 10, 80, 190, 60)
                    jsPdf.save('test.pdf')

                }
            
        })

        
    }
</script>
@endsection
