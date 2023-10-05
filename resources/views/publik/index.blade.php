<?php

use App\Models\District;
use App\Models\Village;
use App\Models\Tps;
use App\Models\SaksiData;
use App\Models\Paslon;
?>
@extends('layouts.mainpublic')
@section('content')


<?php
$saksidatai = SaksiData::sum("voice");
$dpt = District::where('regency_id', $config->regencies_id)->sum("dpt");
$data_masuk = (int)$saksidatai / (int)$dpt * 100;

?>
<style>
    .card-header {
        padding-top: 5px;
        padding-bottom: 5px;
    }
    .card-title a:hover {
        color: #ebebeb;
    }
</style>
<div class="tab-content" id="pills-tabContent p-3">

    <!-- 1st card -->
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
        <div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12 text-center fs-4 fw-bold">
                Wilayah Pemilihan Prov. {{$data_prov->name}}
            </div>
            <div class="col-12">
                <div class="container">
                    <div id="chart-all" class="chartsh h-100 w-100"></div>
                </div>
            </div>
            <div class="col-12 text-center fs-5 fw-bold">
                <?php $i = 0; ?>
                @foreach ($paslon as $pas)
                    {{$pas->candidate}} {{$pas->deputy_candidate}} - <span class="voice{{$i}}"></span> <br>
                    <?php $i++; ?>
                @endforeach
            </div>
            <div class="col-md-12 text-center mt-2 fs-6">
    <span class="badge bg-primary">Time Closed: - Progress 0% dari 100%</span>
</div>
        </div>
        <div class="row mt-3">
            
            <table class="table mt-2">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Wilayah</th>

      @foreach ($paslon as $pas)
        <th scope="col">{{$pas->candidate}}</th>
      @endforeach
    </tr>
  </thead>
  <tbody id="data-kota">
     
  </tbody>
</table>

     <div class="card w-100 text-center py-1 mt-4 fs-5" style="font-weight: bold; background: #ff022d; color: #fff">
                Hasil Perhitungan Tingkat Kabupaten/Kota
            </div>
           
            <?php $i = 1; ?>
            <?php  
        $config = App\Models\Config::first();
        $kotas =App\Models\Regency::join('regency_domains','regency_domains.regency_id','=','regencies.id')->where('regencies.province_id',$config->provinces_id)->get();

        ?>
            <?php 
                foreach ($kotas as $hehe) :  ?>
                        <div class="col-lg-3">
                            <div class="card text-center">
                                <div class="card-header bg-primary">
                                    <div class="card-title text-white"><a href="https://{{$hehe->domain}}"target="_blank">{{ $hehe->name}}</a></div>
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

    </div>
</div>
</div>
</div>

</div>


<script>

window.onload = function() {

    
        $.ajax({
            url:"{{url('')}}/get-api-masuk",
            type:'get',
            dataType : 'html',
            success:(res)=>{
                $('#data-kota').html(res)
            }
        });


    }
</script>
@endsection
