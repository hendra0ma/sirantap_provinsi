<?php

use App\Models\User;
?>

<!-- BACK-TO-TOP -->
<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>



<!-- Modal -->
<div class="modal fade" id="modallockdown" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-danger text-light">
      <div class="modal-header">
        <h5 class="modal-title" id="modallockdownLabel">Lockdown</h5>
      </div>
      <div class="modal-body">
            <div class="alert alert-danger text-dark" role="alert">
                <h3 class="display-3 text-light">
                   <i class="fas fa-lock-alt fa-3x"></i> LOCKDOWN
                </h3>
            </div>
      </div>
      
    </div>
  </div>
</div>

<!-- JQUERY JS -->
<script src="../../assets/js/jquery.min.js"></script>

<!-- BOOTSTRAP JS -->
<script src="../../assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="../../assets/plugins/bootstrap/js/bootstrap.min.js"></script>

<!-- SPARKLINE JS-->
<script src="../../assets/js/jquery.sparkline.min.js"></script>

<!-- CHART-CIRCLE JS-->
<script src="../../assets/js/circle-progress.min.js"></script>

<!-- CHARTJS CHART JS-->
<script src="../../assets/plugins/chart/Chart.bundle.js"></script>
<script src="../../assets/plugins/chart/utils.js"></script>

<!-- PIETY CHART JS-->
<script src="../../assets/plugins/peitychart/jquery.peity.min.js"></script>
<script src="../../assets/plugins/peitychart/peitychart.init.js"></script>

<!-- INTERNAL SELECT2 JS -->
<script src="../../assets/plugins/select2/select2.full.min.js"></script>

<script src="../../assets/js/table-data.js"></script>

<!-- ECHART JS-->
<script src="../../assets/plugins/echarts/echarts.js"></script>

<!-- SIDE-MENU JS-->
<script src="../../assets/plugins/sidemenu/sidemenu.js"></script>

<!-- SIDEBAR JS -->
<script src="../../assets/plugins/sidebar/sidebar.js"></script>


<!-- APEXCHART JS -->
<script src="../../assets/js/apexcharts.js"></script>

<!-- INDEX JS -->
<script src="../../assets/js/index1.js"></script>

<!-- CUSTOM JS -->
<script src="../../assets/js/custom.js"></script>

<!-- C3 CHART JS -->
<script src="../../assets/plugins/charts-c3/d3.v5.min.js"></script>
<script src="../../assets/plugins/charts-c3/c3-chart.js"></script>
<!-- INTERNAL Notifications js -->
<script src="../../assets/plugins/notify/js/rainbow.js"></script>
<script src="../../assets/plugins/notify/js/sample.js"></script>
<script src="../../assets/plugins/notify/js/jquery.growl.js"></script>
<script src="../../assets/plugins/notify/js/notifIt.js"></script>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>









<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

<!-- CHART-CIRCLE JS-->
<script src="../../assets/js/circle-progress.min.js"></script>
<script>
  

<?php
 
 $i = 1;
$paslonApi = [];
foreach($ApiMasuk as $past){
   $voice = 0;
   for($j = 0;$j<count($past); $j++){
       $paslonApi[$j]['namaPas'] = $past[$j]->candidate.' | '.$past[$j]->deputy_candidate;
       $paslonApi[$j]['color'] = $past[$j]->color;
       $paslonApi[$j]['voice'] = 0;
       $paslonApi[$j]['voice'] += $past[$j]->voice;
   }
   $i++;
}

?>
<?php $i = 0; ?>  







    var chart = c3.generate({
      bindto: '#chart-all', // id of chart wrapper
      data: {
          columns: [
            
            <?php $i = 1; ?>
            <?php $j = 0; ?>
            @foreach ($useApiMasuk as $pas)
            // each columns data
              ['data{{$j}}',{{$pas['voice']}}],
          
              <?php $i++; ?>
              <?php $j++; ?>
              @endforeach
    
              
          ],
          type: 'pie', // default type of chart
          colors: {
            <?php $i = 0; ?>
            @foreach ($useApiMasuk as $pas)

              'data{{$i}}': " <?=  $pas['color']?>",
             
               <?php $i++; ?>
               @endforeach
    
          },
          names: {
              // name of each serie
              <?php $i = 0; ?>
            @foreach ($useApiMasuk as $pas)

              'data{{$i}}': " <?=  $pas['paslon']?>",
          
               <?php $i++; ?>
               @endforeach
          }
      },
      axis: {},
      legend: {
          show: true, //hide legend
      },
      padding: {
          bottom: 0,
          top: 0
      },
    });

    
            <?php $i = 1; ?>
            <?php $j = 0; ?>
    @foreach ($useApiMasuk as $pas)
        $('.number-font-voice<?=$j?>').html(<?=$pas['voice']?>);
        <?php $i++; ?>
        <?php $j++; ?>
    @endforeach




    <?php
   $i = 1;
   $paslonApi = [];
   foreach($ApiVerif as $past){
    $voice = 0;
    for($j = 0;$j<count($past); $j++){
        $paslonApi['namaPas'.$j] = $past[$j]->candidate.' | '.$past[$j]->deputy_candidate;
        $voice  += $past[$j]->voice;
        $paslonApi['color'.$j] = $past[$j]->color;
        $paslonApi['voice'.$j] =   $voice;
    }
    $i++;
    $voice = 0;
    }

?>

<?php $i = 0; ?>
@foreach ($useApiVerif as $pas)
    $('.number-font-voice-verif<?=$i?>').html('<?=$pas['voice']?>');
    <?php $i++; ?>
    @endforeach


    var chart = c3.generate({
      bindto: '#chart-donut', // id of chart wrapper
      data: {
          columns: [
            
            <?php $i = 0; ?>
            @foreach ($useApiVerif as $pas)
            // each columns data
              ['data{{$i}}', <?=$pas['voice']?>],
          
              <?php $i++; ?>
              @endforeach
    
              
          ],
          type: 'pie', // default type of chart
          colors: {
            <?php $i = 0; ?>
            @foreach ($useApiVerif as $pas)

              'data{{$i}}': " <?=$pas['color']?>",
             
               <?php $i++; ?>
               @endforeach
    
          },
          names: {
              // name of each serie
              <?php $i = 0; ?>
            @foreach ($useApiVerif as $pas)

              'data{{$i}}': " <?=$pas['paslon']?>",
          
               <?php $i++; ?>
               @endforeach
          }
      },
      axis: {},
      legend: {
          show: true, //hide legend
      },
      padding: {
          bottom: 0,
          top: 0
      },
    });



</script>

<script>
    
    /*chart-pie*/
   <?php
   $i = 1;
   foreach($ApiMasuk as $pas): 
   ?>
   var chart = c3.generate({
        bindto: '#chart-{{$i}}', // id of chart wrapper
        data: {
            columns: [
                <?php  for($j = 0;$j<count($pas); $j++){ ?>
                    ['data{{$j}}', {{$pas[$j]->voice}}],
                    <?php  }?>
              

            ],
            type: 'pie', // default type of chart
            colors: {
                <?php  for($j = 0;$j<count($pas); $j++){ ?>
                'data{{$j}}': "{{$pas[$j]->color}}",
                <?php  }?>
                //  'data1': "rgb(7, 116, 248)",
                //  'data4': "rgb(226, 161, 23)",
            },
            names: {
               // name of each serie
               <?php  for($j = 0;$j<count($pas); $j++){ ?>
               'data{{$j}}': "{{$pas[$j]->candidate}} | {{$pas[$j]->deputy_candidate}} ",
               <?php  }?>
            }
        },
        axis: {},
        legend: {
            show: true, //hide legend
        },
        padding: {
            bottom: 0,
            top: 0
        },
    });
    
  
    
    <?php 

     $i++;
    endforeach ?>
</script>








