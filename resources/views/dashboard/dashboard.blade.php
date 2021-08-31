@extends('templates/template1')

@section('konten')
<div class="row">
   <div class="col-md-4 mt-4">
      <div class="back-card">
         <div class="front-card front-card-mahasiswa">
            <div class="row">
               <div class="col">
                  <h6>DATA MAHASISWA</h6>
               </div>
            </div>
            <div class="row">
               <div class="col">
                  <h4 style="font-weight:bold;" id="count-mahasiswa"></h4>
               </div>
               <div class="col">
                  <a href="{{ url('mahasiswa-admin') }}" class="text-white float-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat">
                     <h5 class="float-end"><i class="fas fa-arrow-right"></i></h5>
                  </a>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-4 mt-4">
      <div class="back-card">
         <div class="front-card front-card-buku">
            <div class="row">
               <div class="col">
                  <h6>DATA BUKU</h6>
               </div>
            </div>
            <div class="row">
               <div class="col">
                  <h4 style="font-weight:bold;" id="count-buku"></h4>
               </div>
               <div class="col">
                  <a href="{{ url('buku') }}" class="text-white float-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat">
                     <h5 class="float-end"><i class="fas fa-arrow-right"></i></h5>
                  </a>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-4 mt-4">
      <div class="back-card">
         <div class="front-card front-card-jurusan">
            <div class="row">
               <div class="col">
                  <h6>DATA JURUSAN</h6>
               </div>
            </div>
            <div class="row">
               <div class="col">
                  <h4 style="font-weight:bold;" id="count-jurusan"></h4>
               </div>
               <div class="col">
                  <a href="{{ url('jurusan') }}" class="text-white float-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat">
                     <h5 class="float-end"><i class="fas fa-arrow-right"></i></h5>
                  </a>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-4 mt-4">
      <div class="back-card">
         <div class="front-card front-card-collapse">
            <div class="row">
               <div class="col">
                  <h6>TRANSAKSI COLLAPSE</h6>
               </div>
            </div>
            <div class="row">
               <div class="col">
                  <h4 style="font-weight:bold;" id="count-collapse"></h4>
               </div>
               <div class="col">
                  <a href="{{ url('collapse') }}" class="text-white float-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat">
                     <h5 class="float-end"><i class="fas fa-arrow-right"></i></h5>
                  </a>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-4 mt-4">
      <div class="back-card">
         <div class="front-card front-transaksi-harian">
            <div class="row">
               <div class="col">
                  <h6>LAPORAN HARIAN</h6>
               </div>
            </div>
            <div class="row">
               <div class="col">
                  <h4 style="font-weight:bold;">
                     <i class="fas fa-calendar-day"></i>
                  </h4>
               </div>
               <div class="col">
                  <a href="{{ url('laporan-harian') }}" class="text-white float-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat">
                     <h5 class="float-end"><i class="fas fa-arrow-right"></i></h5>
                  </a>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-4 mt-4">
      <div class="back-card">
         <div class="front-card front-transaksi-bulanan">
            <div class="row">
               <div class="col">
                  <h6>LAPORAN BULANAN</h6>
               </div>
            </div>
            <div class="row">
               <div class="col">
                  <h4 style="font-weight:bold;">
                     <i class="fas fa-calendar-alt"></i>
                  </h4>
               </div>
               <div class="col">
                  <a href="{{ url('laporan-bulanan') }}" class="text-white float-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat">
                     <h5 class="float-end"><i class="fas fa-arrow-right"></i></h5>
                  </a>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="row mb-5">
   <div class="col-sm mt-5">
      <canvas id="lineChart" style="height:60vh; width:50vw"></canvas>
   </div>
   <div class="col-sm mt-5">
      <canvas id="doughnutChart" style="height:50vh; width:50vh"></canvas>
   </div>
</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
   let overlay = document.getElementById('overlay-container')
   overlay.style.display = 'flex'
   $(document).ready(function(){
      // ambil data
      $.ajax({
         type: 'GET',
         url: 'dashboard/ambilData',
         success: function(response){

            $('#count-mahasiswa').append(response.mahasiswa)
            $('#count-buku').append(response.buku)
            $('#count-jurusan').append(response.jurusan)
            $('#count-collapse').append(response.collapse)

            // line chart
            var ctxLine = document.getElementById('lineChart').getContext('2d');
            var myChartLine = new Chart(ctxLine, {
               type: 'line',
               data: {
                  labels: response.tgl,
                  datasets: [{
                        label: 'Jumlah Buku dipinjam',
                        data: response.jumlah,
                        borderColor: 'red',
                        borderWidth: 1,
                        pointBackgroundColor: 'red',
                        tension: 0.5,
                     }]
               },
               options: {
                  scales: {
                     y: {
                     beginAtZero: true
                     }
                  },
                  plugins: {
                        title: {
                           display: true,
                           text: 'Peminjaman 15 hari terakhir',
                           padding: {
                              top: 10,
                              bottom: 30
                           }
                        }
                  },
                  responsive: true
               }
            })
            // akhir line chart

            // doughnut chart
            // let judul = response.chartDoughnut.map((x) => x.judul)
            // let qty = response.chartDoughnut2.map((y) => y.jumlahPinjam)
            console.log(response)
            // console.log(judul)
            // console.log(qty)
            var ctxdoughnut = document.getElementById('doughnutChart').getContext('2d');
            var myChartDoughnut = new Chart(ctxdoughnut, {
               type: 'doughnut',
               data: {
                  labels: qty,
                  datasets: [{
                     data: qty,
                     backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'red',
                        'blue'
                     ],
                     hoverOffset: 4
                  }]
               },
               options: {
                  plugins: {
                        title: {
                           display: true,
                           text: 'Buku paling sering di pinjam',
                           padding: {
                              top: 10,
                              bottom: 30
                           }
                        }
                  },
                  responsive: true
               }
            })
            // akhir doughnut chart

            overlay.style.display = 'none'
         }
      })
   })
</script>
@endpush