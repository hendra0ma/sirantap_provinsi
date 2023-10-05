<?php 
use Illuminate\Support\Facades\Cache;

$config = App\Models\Config::first();
$kotas = App\Models\Regency::join('regency_domains','regency_domains.regency_id','=','regencies.id')
    ->where('regencies.province_id', $config->provinces_id)
    ->get();

$client = new GuzzleHttp\Client();
$dataApi = [];
$i = 0;
foreach ($kotas as $hehe) : 
    $a = 1;
    if ($a == 1) {
        $voices = "";
    }else{
        $url = "https://".$hehe->domain."/api/public/get-voice?jenis=suara_masuk";
        $voices = Cache::get($url, function () use ($client, $url) {
            $response = $client->request('GET', $url, [
                'headers' => [
                'Authorization' => 'Bearer '.'123789',
                'Accept' => 'application/json',
            ],]);
            $voices = json_decode($response->getBody());
            Cache::put($url, $voices, 60 * 5);
            return $voices;
        });
        array_push($dataApi, $voices);
    }
  

?>
<tr>
    <th scope="row"> 
        <a href="https://{{$hehe->domain}}/ceksetup">
            <?= $hehe->name  ?>
        </a>      
    </th>

    @if($voices == "")
    <td>0</td>
    <td>0</td>
    <td>0</td>
   
    @else

        @foreach($voices as $vcs)
        <td>{{$vcs->voice}}</td>
        @endforeach

    @endif
</tr>
<?php endforeach; ?>
                

@if($voices == "")
@else
<script>
    
    /*chart-pie*/
   <?php
   $i = 1;
   foreach($dataApi as $pas): 
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
    
  
    
    <?php  $i++;
    endforeach ?>





</script>


<?php


 $i = 1;
$paslonApi = [];
foreach($dataApi as $past){
   $voice = 0;
   for($j = 0;$j<count($past); $j++){
       $paslonApi[$j]['namaPas'] = $past[$j]->candidate.' | '.$past[$j]->deputy_candidate;
       $paslonApi[$j]['color'] = $past[$j]->color;
       $paslonApi[$j]['voice'] = 0;
       $paslonApi[$j]['voice'] += $past[$j]->voice;
   }
   $i++;
}
$coba = json_encode($dataApi);



?>


<script>

     let arr =   JSON.parse('<?=$coba?>')

     let paslon1 = 0;
    let paslon2 = 0;
    let paslon3 = 0;

for(let items of arr){
  
  for (let item of items){
  	switch(item.candidate){
  	case 'Paslon 1':
    	paslon1 += item.voice;
    break;
    
    case 'Paslon 2':
    	paslon2 += item.voice;
    break;
    
    case 'Paslon 3':
    	paslon3 += item.voice;
    break;
    
    default:
    	console.log('ada kesalahan di candidate')
    break;
  }
  }
  
}






    var chart = c3.generate({
      bindto: '#chart-all', // id of chart wrapper
      data: {
          columns: [
            
            <?php $i = 1; ?>
            <?php $j = 0; ?>
            @foreach ($paslon as $pas)
            // each columns data
              ['data{{$j}}', <?='paslon'.$i?>],
          
              <?php $i++; ?>
              <?php $j++; ?>
              @endforeach
    
              
          ],
          type: 'pie', // default type of chart
          colors: {
            <?php $i = 0; ?>
            @foreach ($paslon as $pas)

              'data{{$i}}': " <?=  $paslonApi[$i]['color']?>",
             
               <?php $i++; ?>
               @endforeach
    
          },
          names: {
              // name of each serie
              <?php $i = 0; ?>
            @foreach ($paslon as $pas)

              'data{{$i}}': " <?=  $paslonApi[$i]['namaPas']?>",
          
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
    @foreach ($paslon as $pas)
        $('span.voice<?=$j?>').html(<?='paslon'.(int)$i?>);
        <?php $i++; ?>
        <?php $j++; ?>
    @endforeach

</script>   
@endif