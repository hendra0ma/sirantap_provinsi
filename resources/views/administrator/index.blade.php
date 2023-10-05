@extends('layouts.mainlayout')

@section('content')

<?php

use App\Models\Config;
use App\Models\District;
use App\Models\Regency;
use App\Models\Province;
use App\Models\SaksiData;
use App\Models\Tps;
use App\Models\Village;
use App\Models\User;
use Illuminate\Support\Facades\DB;

$config = Config::all()->first();
$regency = District::where('regency_id', $config['regencies_id'])->get();
$provinsi = Province::where('id', $config['provinces_id'])->first();
$kota = Regency::where('id', $config['regencies_id'])->first();
$dpt = District::where('regency_id', $config['regencies_id'])->sum('dpt');
$tps = Tps::count();

$kotas =App\Models\Regency::join('regency_domains','regency_domains.regency_id','=','regencies.id')
->where('regencies.province_id',$config->provinces_id)->get();
?>


<?php $i = 1; ?>
<?php  
use Illuminate\Support\Facades\Cache;
    // $config = App\Models\Config::first();
    $kotas = App\Models\Regency::join('regency_domains','regency_domains.regency_id','=','regencies.id')
        ->where('regencies.province_id', $config->provinces_id)->get();

    $client = new GuzzleHttp\Client(); //GuzzleHttp\Client
    $ApiMasuk = [];
    $ApiVerif = [];
    $ApiMasuk2 = [];
    $ApiVerif2 = [];

    foreach ($kotas as $hehe) :  
        $url = "https://".$hehe->domain."/api/public/get-voice?jenis=suara_masuk";
        
        $voices = Cache::get($url, function () use ($client, $url) {
                $response = $client->request('GET', $url, [
                    'headers' => [
                                'Authorization' => 'Bearer '.'123789',
                                'Accept' => 'application/json',
                            ],
                ]);
                $voices = json_decode($response->getBody());
                Cache::put($url, $voices, 60);
                return $voices;
            });

       
        array_push($ApiMasuk,$voices);
        $ApiMasuk2[] = $voices;

        $url = "https://".$hehe->domain."/api/public/get-voice?jenis=terverifikasi";
        $voices2 = Cache::get($url, function () use ($client, $url) {
                $response = $client->request('GET', $url, [
                    'headers' => [
                                            'Authorization' => 'Bearer '.'123789',
                                            'Accept' => 'application/json',
                                        ],
                ]);
                $voices2 = json_decode($response->getBody());
                Cache::put($url, $voices2, 60);
                return $voices2;
            });
        array_push($ApiVerif,$voices2);
        $ApiVerif2[] = $voices2;

    endforeach;
  
     $paslon = App\Models\Paslon::get();


    foreach($paslon as $j => $pas){
        $useApiMasuk[$j]['voice'] = 0;
        foreach($ApiMasuk2 as $i => $voice){
        
            $useApiMasuk[$j]['paslon'] = $voice[$j]->candidate;
            $useApiMasuk[$j]['color'] = $voice[$j]->color;
            $useApiMasuk[$j]['voice'] += $voice[$j]->voice;
            $useApiMasuk[$j]['urutan'] = $j;

        }
    }
    foreach($paslon as $k => $pas){
        $useApiVerif[$k]['voice'] = 0;
        foreach($ApiVerif2 as $i => $voice){
          
            $useApiVerif[$k]['paslon'] = $voice[$k]->candidate;
            $useApiVerif[$k]['color'] = $voice[$k]->color;
            $useApiVerif[$k]['voice'] += $voice[$k]->voice;
                 $useApiMasuk[$j]['urutan'] = $k;

        }
    }


?>
<style>
    .open-desktop {
        display: block;
    }

    @media (max-width: 1680px) {

        .open-desktop {
            display: none;
        }

        .break-point-1 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .break-point-2 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    @media (max-width: 1024px) {

        .open-desktop {
            display: none;
        }

        .break-point-1 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .break-point-2 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

</style>

<div class="row mt-3">
    <div class="col-lg-6 col-md-6 break-point-1">
      

                <h1 class="page-title fs-2 mt-2">DASHBOARD PROVINSI
                </h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$provinsi->name}}
                        <!-- Kota -->
                    </li>
                </ol>
               <h1 class="fs-5 mt-1">
                 SUPER ADMINISTRATOR
                </h1>  
               
    </div>



    <div class="col-lg-6 col-xxl-0 justify-content-end mt-2 break-point-1">
        <div class="row">
            <div class="col-lg- col-md- justify-content-end  break-point-2">
                <div class="card" style="margin-bottom: 0px;">
                    <div class="card-body">
                        <div class="row mx-auto">
                                  
                                <?php

                                $dataTertinggi = $useApiMasuk;

                                usort($dataTertinggi, function($a, $b) {
                                          return $b['voice'] <=> $a['voice'];
                                    });
                                    
                                ?>
                             
                            <div class="col-3 ">
                                <div class="counter-icon box-shadow-secondary brround candidate-name text-white"
                                    style="margin-bottom: 0;background-color:<?=$dataTertinggi[0]['color']?>">
                                    <?=(int)$dataTertinggi[0]['urutan'] + 1?>
                                </div>
                            </div>
                            <div class="col me-auto">
                                <h6 class="">Suara Tertinggi</h6>
                                <h3 class="mb-2 number-font">   
                               {{$dataTertinggi[0]['voice']}} 
                                    || {{$dataTertinggi[0]['paslon']}}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="{{($config->otonom == 'yes')?'col-lg-12 col-md-12':'col-lg-6 col-md-12'}}">
        <div class="card">
            <div class="card-header bg-info-gradient">
                <h3 class="card-title text-white">Suara TPS Masuk (Provinsi Banten)</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xxl-6">
                        <div class="container" style="margin-left: 3%; margin-top: 10%;">
                            <div class="text-center fs-3 mb-3 fw-bold">SUARA MASUK</div>
                            <div class="text-center">Progress {{substr($realcount,0,5)}}% dari 100%</div>
                            <div id="chart-all" class="chartsh h-100 w-100"></div>
                        </div>
                    </div>
                    <div class="col-xxl-6">
                    <?php
                                $i = 1;
                                $paslonApi = [];
                                foreach($ApiMasuk as $past){
                                    $voice = 0;
                                    for($j = 0;$j<count($past); $j++){
                                        $paslonApi['namaPas'.$j] = $past[$j]->candidate.' | '.$past[$j]->deputy_candidate;
                                        $voice  += $past[$j]->voice;
                                        $paslonApi['color'.$j] = $past[$j]->color;
                                        $paslonApi['voice'.$j] =  $past[$j]->voice;
                                    }
                                    $i++;
                                    $voice = 0;
                                    }

                                ?>
                        <?php $i = 0; 
                        ?>
                        <?php $k = 1; 
                        ?>
                        @foreach ($paslon as $pas)
                        <div class="row mt-2">
                            <div class="col-lg col-md col-sm col-xl mb-3">
                                <div class="card" style="margin-bottom: 0px;">
                                    <div class="card-body">
                                        <div class="row me-auto">
                                            <div class="col-4">
                                                <div class="counter-icon box-shadow-secondary brround candidate-name text-white "
                                                    style="margin-bottom: 0; background-color: {{ $paslonApi['color'.$i]}};">
                                                 {{$k}}
                                                </div>
                                            </div>
                                            <div class="col me-auto">
                                                <h6 class="">{{$pas->candidate}} </h6>
                                                <h6 class="">{{$pas->deputy_candidate}} </h6>
                                              
                                                <h3 class="mb-2 number-font number-font-voice{{$i}}">{{$paslonApi['voice'.$i]}} suara</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php  $k++ ?>
                <?php  $i++ ?>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-12" style="display:{{($config->otonom == 'yes')?'none':'block'}}">
        <div class="card">
            <div class="card-header bg-secondary-gradient">
                <h3 class="card-title text-white">Suara TPS Terverifikasi (Provinsi Banten)</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xxl-6">
                        <div class="container" style="margin-left: 3%; margin-top: 10%;">
                            <div class="text-center fs-3 mb-3 fw-bold">SUARA TERVERIFIKASI</div>
                            <div class="text-center">Terverifikasi {{$saksi_terverifikasi}} TPS dari {{$saksi_masuk}}
                                TPS Masuk</div>
                            <div id="chart-donut" class="chartsh h-100 w-100"></div>
                        </div>
                    </div>
                    <div class="col-xxl-6">

                    <?php
                                $i = 1;
                                $paslonApiVerif = [];
                                foreach($ApiVerif as $pastverif){
                                    $voice = 0;
                                    for($j = 0;$j<count($pastverif); $j++){
                                        $paslonApiVerif['namaPas'.$j] = $pastverif[$j]->candidate.' | '.$pastverif[$j]->deputy_candidate;
                                        $voice  += $pastverif[$j]->voice;
                                        $paslonApiVerif['color'.$j] = $pastverif[$j]->color;
                                        $paslonApiVerif['voice'.$j] =  $pastverif[$j]->voice;
                                    }
                                    $i++;
                                    $voice = 0;
                                    }

                                ?>
                    <?php $i = 0; 
                        ?>
                        <?php $k = 1; 
                        ?>
                        @foreach ($paslon_terverifikasi as $pas)
                        <div class="row mt-2">
                            <div class="col-lg col-md col-sm col-xl mb-3">
                                <div class="card" style="margin-bottom: 0px;">
                                    <div class="card-body">
                                        <div class="row me-auto">
                                            <div class="col-4">
                                            <div class="counter-icon box-shadow-secondary brround candidate-name text-white "
                                                    style="margin-bottom: 0; background-color: {{ $paslonApiVerif['color'.$i]}};">
                                                 {{$k}}
                                                </div>
                                            </div>
                                            <div class="col me-auto">
                                            <h6 class="">{{$pas->candidate}} </h6>
                                                <h6 class="">{{$pas->deputy_candidate}} </h6>
                                              
                                                <h3 class="mb-2 number-font number-font-voice-verif{{$i}}">{{$paslonApiVerif['voice'.$i]}} suara</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                             <?php  $k++ ?>
                <?php  $i++ ?>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Perhitungan Setiap Kota/Kabupaten</div>
    </div>
    <div class="card-body">
        <div class="row">


        <?php $i = 1; ?>
            <?php 
                foreach ($kotas as $hehe) :  ?>
            <div class="col-lg-3">
                <div class="card text-center">
                    <div class="card-header bg-primary">
                        <div class="card-title text-white"><a href="https://{{ $hehe->domain}}">{{ $hehe->name}}</a></div>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div id="chart-{{$i}}" class="chartsh h-100 w-100"></div>
                        </div>
                    </div>
                </div>
            </div>
    <?php 

$i++;
endforeach ?>
       
        </div>
    </div>
</div>

<div class="row">
    <div class="{{($config->otonom == 'yes')?'col-lg-12 col-md-12':'col-lg-6 col-md-12'}}">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Suara TPS Masuk (Provinsi Banten)</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-white text-center align-middle">KOTA</th>
                            @foreach ($paslon as $item)
                            <th class="text-white text-center align-middle">{{ $item['candidate']}} - <br>
                                {{ $item['deputy_candidate']}}</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody  id="body-masuk">

</tbody>

                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-md-12" style="display:{{($config->otonom == 'yes')?'none':'block'}}">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Suara TPS Terverifikasi (Provinsi Banten)</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="bg-primary">
                        <td class="text-white text-center align-middle">KOTA</td>
                        @foreach ($paslon as $item)
                        <th class="text-white text-center align-middle">{{ $item['candidate']}} - <br>
                            {{ $item['deputy_candidate']}}</th>
                        @endforeach
                    </thead>
                    <tbody  id="body-verif">

                    </tbody>
                   
                </table>
            </div>
        </div>
    </div>
</div>

<div id="body-cards">

</div>




<script>
  setTimeout(function(){
    $.when(
        $('#body-masuk').load("{{url('administrator/get-api-masuk')}}"),
        $('#body-verif').load("{{url('administrator/get-api-verif')}}"),
        $('#body-cards').load("{{url('administrator/get-api-cards')}}")
    );
}, 1000);

</script>




@endsection
